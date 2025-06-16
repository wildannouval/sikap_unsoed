<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\DocumentHelpers; // Trait untuk fungsi bantuan
use App\Models\Seminar;
use App\Models\Jurusan;
use App\Models\Ruangan;
use App\Notifications\RevisiJadwalDiminta;
use App\Notifications\SeminarDibatalkan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Log;
use App\Notifications\SeminarTelahDijadwalkan;
use Illuminate\Support\Facades\Notification;

class PenjadwalanSeminarController extends Controller
{
    use DocumentHelpers; // Gunakan Trait jika ada fungsi helper seperti getRomanMonth

    /**
     * Menampilkan daftar pengajuan seminar yang perlu dijadwalkan atau sudah dijadwalkan.
     */
    public function index(Request $request)
    {
        // Bapendik melihat seminar yang sudah disetujui dospem atau sudah dijadwalkan
        $query = Seminar::whereIn('status_pengajuan', [
            'disetujui_dospem',
            'dijadwalkan_bapendik',
            'revisi_jadwal_bapendik',
            'dibatalkan' // Tambahkan status ini
        ])
            ->with(['mahasiswa.user', 'mahasiswa.jurusan', 'pengajuanKp.dosenPembimbing.user'])
            ->latest('updated_at');

        // Cek apakah parameter filter status ada di URL
        if ($request->has('status_filter')) {
            if ($request->filled('status_filter')) {
                $query->where('status_pengajuan', $request->status_filter);
            }
            // Jika kosong (memilih "Semua"), maka query whereIn di atas akan berlaku
        } else {
            // Default saat pertama kali buka halaman
            $query->where('status_pengajuan', 'disetujui_dospem');
        }

        // Filter berdasarkan jurusan mahasiswa
        if ($request->filled('jurusan_id')) {
            $query->whereHas('mahasiswa.jurusan', function ($q) use ($request) {
                $q->where('id', $request->jurusan_id);
            });
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul_kp_final', 'like', "%{$searchTerm}%")
                    ->orWhereHas('mahasiswa.user', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('mahasiswa', function ($subQ) use ($searchTerm) {
                        $subQ->where('nim', 'like', "%{$searchTerm}%");
                    });
            });
        }

        $seminarApplications = $query->paginate(10)->appends($request->query());
        $jurusans = Jurusan::orderBy('nama')->get();

        $statuses = [
            'disetujui_dospem' => 'Menunggu Dijadwalkan Bapendik',
            'dijadwalkan_bapendik' => 'Sudah Dijadwalkan Bapendik',
            'revisi_jadwal_bapendik' => 'Revisi Jadwal Diminta',
            'dibatalkan' => 'Dibatalkan', // Tambahkan status ini
        ];

        return view('bapendik.penjadwalan_seminar.index', compact('seminarApplications', 'jurusans', 'request', 'statuses'));
    }

    /**
     * Menampilkan form untuk menetapkan atau mengubah jadwal seminar.
     */
    public function editJadwal(Seminar $seminar)
    {
        // Bapendik bisa mengedit jadwal untuk seminar yang statusnya disetujui dospem atau sudah dijadwalkan (jika ada perubahan)
        if (!in_array($seminar->status_pengajuan, ['disetujui_dospem', 'dijadwalkan_bapendik', 'revisi_jadwal_bapendik'])) {
            return redirect()->route('bapendik.penjadwalan-seminar.index')
                ->with('error', 'Pengajuan seminar ini tidak dalam status yang bisa dijadwalkan atau diedit jadwalnya.');
        }

        $seminar->load(['mahasiswa.user', 'mahasiswa.jurusan', 'pengajuanKp.dosenPembimbing.user']);
        // Ambil semua data ruangan untuk dropdown, Bapendik bisa memilih bahkan yang ditandai tidak tersedia jika ada kondisi khusus
        $daftarRuangan = Ruangan::orderBy('nama_ruangan')->get();

        return view('bapendik.penjadwalan_seminar.edit', compact('seminar', 'daftarRuangan'));
    }

    /**
     * Menyimpan jadwal seminar yang final.
     */
    public function updateJadwal(Request $request, Seminar $seminar)
    {
        if (!in_array($seminar->status_pengajuan, ['disetujui_dospem', 'dijadwalkan_bapendik', 'revisi_jadwal_bapendik'])) {
            return redirect()->route('bapendik.penjadwalan-seminar.index')
                ->with('error', 'Gagal memperbarui jadwal, status pengajuan seminar tidak valid.');
        }

        $request->validate([
            'tindakan_bapendik' => ['required', Rule::in(['tetapkan_jadwal', 'minta_revisi'])],
            // Validasi kondisional untuk penetapan jadwal
            'tanggal_seminar' => 'required_if:tindakan_bapendik,tetapkan_jadwal|nullable|date',
            'jam_mulai' => 'required_if:tindakan_bapendik,tetapkan_jadwal|nullable|date_format:H:i',
            'jam_selesai' => 'required_if:tindakan_bapendik,tetapkan_jadwal|nullable|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required_if:tindakan_bapendik,tetapkan_jadwal|nullable|string|max:255|exists:ruangans,nama_ruangan',
            // PERBAIKAN: Tanggal BA sekarang wajib jika jadwal ditetapkan
            'ba_tanggal_pengambilan' => 'required_if:tindakan_bapendik,tetapkan_jadwal|nullable|date|after_or_equal:tanggal_seminar',
            // Validasi kondisional untuk minta revisi
            'catatan_komisi' => 'required_if:tindakan_bapendik,minta_revisi|nullable|string|max:1000',
        ]);

        if ($request->tindakan_bapendik === 'tetapkan_jadwal') {
            $seminar->tanggal_seminar = $request->tanggal_seminar;
            $seminar->jam_mulai = $request->jam_mulai;
            $seminar->jam_selesai = $request->jam_selesai;
            $seminar->ruangan = $request->ruangan;
            $seminar->status_pengajuan = 'dijadwalkan_bapendik'; // Status baru
            $seminar->catatan_komisi = $request->catatan_komisi; // Catatan bisa opsional di sini
            $seminar->ba_tanggal_pengambilan = $request->ba_tanggal_pengambilan;

            // --- KIRIM NOTIFIKASI ---
            // 1. Notifikasi ke Mahasiswa
            $mahasiswaUser = $seminar->mahasiswa->user;
            $mahasiswaUser->notify(new SeminarTelahDijadwalkan($seminar));

            // 2. Notifikasi ke Dosen Pembimbing
            $dosenPembimbingUser = $seminar->pengajuanKp->dosenPembimbing->user;
            $dosenPembimbingUser->notify(new SeminarTelahDijadwalkan($seminar));

            $message = 'Jadwal seminar berhasil ditetapkan.';

        } elseif ($request->tindakan_bapendik === 'minta_revisi') {
            $seminar->status_pengajuan = 'revisi_jadwal_bapendik'; // Status baru
            $seminar->catatan_komisi = $request->catatan_komisi; // Wajib diisi

            // --- KIRIM NOTIFIKASI REVISI ---
            $penerimaNotifikasi = [
                $seminar->mahasiswa->user,
                $seminar->pengajuanKp->dosenPembimbing->user
            ];
            Notification::send($penerimaNotifikasi, new RevisiJadwalDiminta($seminar));
            // --- AKHIR BLOK NOTIFIKASI ---

            $message = 'Permintaan revisi jadwal telah dikirim ke mahasiswa.';
        }

        $seminar->save();

        // Di sini bisa ditambahkan logika untuk mengirim notifikasi ke mahasiswa dan dosen pembimbing

        return redirect()->route('bapendik.penjadwalan-seminar.index')
            ->with('success_modal_message', $message);
    }

    /**
     * Generate dan download Blangko Berita Acara Seminar dalam format Word.
     */
    public function exportBeritaAcaraWord(Seminar $seminar)
    {
        if (!in_array($seminar->status_pengajuan, ['dijadwalkan_bapendik', 'selesai_dinilai'])) {
            return redirect()->back()->with('error', 'Dokumen Berita Acara hanya bisa diekspor untuk seminar yang sudah dijadwalkan atau selesai dinilai.');
        }

        $templatePath = storage_path('app/templates/template_berita_acara_seminar.docx');

        if (!file_exists($templatePath)) {
            Log::error('Template Berita Acara Seminar tidak ditemukan di: ' . $templatePath);
            return redirect()->back()->with('error', 'File template Blangko Berita Acara Seminar tidak ditemukan.');
        }

        try {
            $templateProcessor = new TemplateProcessor($templatePath);

            $seminar->load(['mahasiswa.user', 'mahasiswa.jurusan', 'pengajuanKp.dosenPembimbing.user', 'pengajuanKp.dosenPembimbing']);

            // Siapkan data
            $mahasiswaUser = $seminar->mahasiswa->user;
            $dataMahasiswa = $seminar->mahasiswa;
            $jurusanMahasiswa = $dataMahasiswa->jurusan;
            $dosenPembimbingUser = $seminar->pengajuanKp->dosenPembimbing->user;
            $dataDosenPembimbing = $seminar->pengajuanKp->dosenPembimbing;

            // Data Penandatangan (SESUAIKAN)
            $namaKajur = "Nama Ketua Jurusan";
            $nipKajur = "NIP/NIDN Ketua Jurusan";

            // Nomor Berita Acara (SESUAIKAN)
            $nomorBeritaAcara = "BA/{$seminar->id}/{$jurusanMahasiswa->kode}/SEM/" . Carbon::parse($seminar->tanggal_seminar)->format('m/Y');

            // Mengisi placeholder
            $templateProcessor->setValue('NOMOR_BERITA_ACARA', $nomorBeritaAcara);
            $templateProcessor->setValue('HARI_SEMINAR', $seminar->tanggal_seminar ? Carbon::parse($seminar->tanggal_seminar)->isoFormat('dddd') : 'N/A');
            $templateProcessor->setValue('TANGGAL_SEMINAR_LENGKAP', $seminar->tanggal_seminar ? Carbon::parse($seminar->tanggal_seminar)->isoFormat('D MMMM YYYY') : 'N/A');
            $templateProcessor->setValue('JAM_MULAI_SEMINAR', $seminar->jam_mulai ? Carbon::parse($seminar->jam_mulai)->format('H:i') : 'N/A');
            $templateProcessor->setValue('JAM_SELESAI_SEMINAR', $seminar->jam_selesai ? Carbon::parse($seminar->jam_selesai)->format('H:i') : 'N/A');
            $templateProcessor->setValue('RUANGAN_SEMINAR', $seminar->ruangan ?? 'N/A');
            $templateProcessor->setValue('NAMA_MAHASISWA', $mahasiswaUser->name ?? 'N/A');
            $templateProcessor->setValue('NIM_MAHASISWA', $dataMahasiswa->nim ?? 'N/A');
            $templateProcessor->setValue('JURUSAN_MAHASISWA', $jurusanMahasiswa->nama ?? 'N/A');
            $templateProcessor->setValue('JUDUL_KP_FINAL', $seminar->judul_kp_final ?? 'N/A');
            $templateProcessor->setValue('NAMA_DOSEN_PEMBIMBING', $dosenPembimbingUser->name ?? 'N/A');
            $templateProcessor->setValue('NIDN_DOSEN_PEMBIMBING', $dataDosenPembimbing->nidn ?? 'N/A');
            $templateProcessor->setValue('NAMA_DOSEN_PENGUJI_1', '(____________________)');
            $templateProcessor->setValue('NIDN_DOSEN_PENGUJI_1', '(____________________)');
            $templateProcessor->setValue('JABATAN_PENGESAH_BA', "Ketua Jurusan " . ($jurusanMahasiswa->nama ?? ''));
            $templateProcessor->setValue('NAMA_PENGESAH_BA', $namaKajur);
            $templateProcessor->setValue('NIP_PENGESAH_BA', $nipKajur);
            $templateProcessor->setValue('TANGGAL_CETAK_BERITA_ACARA', Carbon::now()->isoFormat('D MMMM YYYY'));

            // Generate dan kirim file
            $safeMahasiswaName = Str::slug($mahasiswaUser->name, '_');
            $fileName = 'Blangko_BA_Seminar_' . ($dataMahasiswa->nim ?? '000') . '_' . $safeMahasiswaName . '.docx';
            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord_BASeminar');
            $templateProcessor->saveAs($tempFile);

            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            Log::error('Gagal export Berita Acara Seminar, Seminar ID ' . $seminar->id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat dokumen Blangko Berita Acara. Terjadi kesalahan pada sistem.');
        }
    }
    /**
     * Membatalkan seminar yang sudah dijadwalkan.
     */
    public function cancel(Request $request, Seminar $seminar)
    {
        // Hanya seminar yang sudah dijadwalkan yang bisa dibatalkan
        if ($seminar->status_pengajuan !== 'dijadwalkan_bapendik') {
            return redirect()->route('bapendik.penjadwalan-seminar.index')
                ->with('error', 'Hanya seminar yang sudah dijadwalkan yang bisa dibatalkan.');
        }

        $request->validate([
            'catatan_pembatalan' => 'required|string|max:1000',
        ]);

        $seminar->status_pengajuan = 'dibatalkan';
        // Simpan alasan pembatalan di kolom catatan yang sama
        $seminar->catatan_komisi = "DIBATALKAN OLEH BAPENDIK: " . $request->catatan_pembatalan;
        $seminar->save();

        // --- KIRIM NOTIFIKASI PEMBATALAN ---
        $penerimaNotifikasi = [
            $seminar->mahasiswa->user,
            $seminar->pengajuanKp->dosenPembimbing->user
        ];
        Notification::send($penerimaNotifikasi, new SeminarDibatalkan($seminar));
        // --- AKHIR BLOK NOTIFIKASI ---

        return redirect()->route('bapendik.penjadwalan-seminar.index')
            ->with('success_modal_message', 'Jadwal seminar untuk ' . $seminar->mahasiswa->user->name . ' telah berhasil dibatalkan.');
    }
}
