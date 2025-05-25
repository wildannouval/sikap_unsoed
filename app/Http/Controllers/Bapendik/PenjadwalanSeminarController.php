<?php

namespace App\Http\Controllers\Bapendik; // Pastikan namespace-nya Bapendik

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use App\Models\Jurusan;
use Illuminate\Http\Request;
// Auth mungkin tidak terlalu relevan di sini karena akses sudah diproteksi role Bapendik
// tapi bisa digunakan jika ada logika terkait user Bapendik yang melakukan aksi.

class PenjadwalanSeminarController extends Controller
{
    public function index(Request $request)
    {
        // Bapendik melihat semua seminar yang sudah disetujui dospem
        // atau yang sudah dijadwalkan oleh Bapendik sendiri untuk pengelolaan
        $query = Seminar::whereIn('status_pengajuan', ['disetujui_dospem', 'dijadwalkan_komisi', 'revisi_jadwal_komisi'])
            ->with(['mahasiswa.user', 'mahasiswa.jurusan', 'pengajuanKp.dosenPembimbing.user'])
            ->latest('updated_at'); // Atau 'dospem_approved_at'

        // Filter berdasarkan status_pengajuan
        if ($request->filled('status_filter')) {
            $query->where('status_pengajuan', $request->status_filter);
        }

        // Filter berdasarkan jurusan mahasiswa
        if ($request->filled('jurusan_id')) {
            $query->whereHas('mahasiswa.jurusan', function ($q) use ($request) {
                $q->where('id', $request->jurusan_id);
            });
        }

        // Search (nama mahasiswa, nim, judul kp)
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

        $statuses = [ // Status yang relevan untuk Bapendik kelola/lihat di halaman ini
            'disetujui_dospem' => 'Disetujui Dospem (Siap Dijadwalkan)',
            'dijadwalkan_komisi' => 'Sudah Dijadwalkan',
            'revisi_jadwal_komisi' => 'Revisi Jadwal (dari Anda)',
            // Bisa ditambahkan status lain jika Bapendik perlu melihatnya di sini
        ];

        return view('bapendik.penjadwalan_seminar.index', compact('seminarApplications', 'jurusans', 'request', 'statuses'));
    }

    public function editJadwal(Seminar $seminar)
    {
        // Bapendik bisa mengedit jadwal untuk seminar yang statusnya disetujui dospem atau sudah dijadwalkan (jika ada perubahan)
        if (!in_array($seminar->status_pengajuan, ['disetujui_dospem', 'dijadwalkan_komisi', 'revisi_jadwal_komisi'])) {
            return redirect()->route('bapendik.penjadwalan-seminar.index')
                ->with('error', 'Pengajuan seminar ini tidak dalam status yang bisa dijadwalkan/diedit jadwalnya.');
        }

        $seminar->load(['mahasiswa.user', 'mahasiswa.jurusan', 'pengajuanKp.dosenPembimbing.user']);
        // $daftarRuangan = Ruangan::all(); // Jika ada master data ruangan
        // $daftarPenguji = User::where('role', 'dosen')->whereHas('dosen')->get(); // Untuk memilih penguji

        return view('bapendik.penjadwalan_seminar.edit', compact('seminar'/*, 'daftarRuangan', 'daftarPenguji'*/));
    }

    public function updateJadwal(Request $request, Seminar $seminar)
    {
        if (!in_array($seminar->status_pengajuan, ['disetujui_dospem', 'dijadwalkan_komisi', 'revisi_jadwal_komisi'])) {
            return redirect()->route('bapendik.penjadwalan-seminar.index')
                ->with('error', 'Gagal memperbarui jadwal, status pengajuan seminar tidak valid.');
        }

        $request->validate([
            'tanggal_seminar' => 'required|date', // Bisa jadi tanggal lampau jika hanya mencatat jadwal yg sudah fix sebelumnya
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'required|string|max:100',
            'catatan_komisi' => 'nullable|string|max:1000', // Catatan dari Bapendik/Komisi
        ]);

        $seminar->tanggal_seminar = $request->tanggal_seminar;
        $seminar->jam_mulai = $request->jam_mulai;
        $seminar->jam_selesai = $request->jam_selesai;
        $seminar->ruangan = $request->ruangan;
        $seminar->catatan_komisi = $request->catatan_komisi;
        $seminar->status_pengajuan = 'dijadwalkan_komisi'; // Ubah status menjadi telah dijadwalkan

        // Jika ada field dosen penguji, simpan di sini
        // $seminar->dosen_penguji_1_id = $request->dosen_penguji_1_id;
        // $seminar->dosen_penguji_2_id = $request->dosen_penguji_2_id;

        $seminar->save();

        // Notifikasi ke mahasiswa dan dosen pembimbing
        // (Implementasi notifikasi bisa via Email atau Notifikasi internal sistem)

        return redirect()->route('bapendik.penjadwalan-seminar.index')
            ->with('success', 'Jadwal seminar untuk ' . $seminar->mahasiswa->user->name . ' berhasil ditetapkan/diperbarui.');
    }
    public function exportBeritaAcaraWord(Seminar $seminar)
    {
        // Pastikan seminar sudah dijadwalkan
        if ($seminar->status_pengajuan !== 'dijadwalkan_komisi') {
            return redirect()->back()->with('error', 'Dokumen hanya bisa diekspor untuk seminar yang sudah dijadwalkan.');
        }

        // Path ke file template Word kamu untuk Berita Acara Seminar
        $templatePath = storage_path('app/templates/template_berita_acara_seminar.docx'); // Sesuaikan nama filenya

        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'File template Berita Acara Seminar tidak ditemukan.');
        }

        try {
            $templateProcessor = new TemplateProcessor($templatePath);

            // Load relasi yang dibutuhkan jika belum ter-load
            $seminar->load(['mahasiswa.user', 'mahasiswa.jurusan', 'pengajuanKp.dosenPembimbing.user']);

            // Siapkan data
            $mahasiswaUser = $seminar->mahasiswa->user;
            $dataMahasiswa = $seminar->mahasiswa;
            $jurusanMahasiswa = $dataMahasiswa->jurusan;
            $dosenPembimbingUser = $seminar->pengajuanKp->dosenPembimbing->user;

            // Data pejabat (jika ada di template berita acara, contoh: Ketua Jurusan atau Wadek)
            // Ini perlu disesuaikan datanya dari mana (config, db, atau hardcode)
            $ketuaJurusanNama = "Nama Ketua Jurusan Placeholder"; // Ganti dengan data asli
            $ketuaJurusanNip = "NIP Ketua Jurusan Placeholder"; // Ganti dengan data asli


            // Set nilai untuk placeholder di template
            $templateProcessor->setValue('NAMA_MAHASISWA', $mahasiswaUser->name ?? 'N/A');
            $templateProcessor->setValue('NIM_MAHASISWA', $dataMahasiswa->nim ?? 'N/A');
            $templateProcessor->setValue('JURUSAN_MAHASISWA', $jurusanMahasiswa->nama ?? 'N/A');
            $templateProcessor->setValue('JUDUL_KP_FINAL', $seminar->judul_kp_final ?? 'N/A');

            $templateProcessor->setValue('TANGGAL_SEMINAR_FIX', $seminar->tanggal_seminar ? Carbon::parse($seminar->tanggal_seminar)->isoFormat('dddd, D MMMM YYYY') : 'N/A');
            $templateProcessor->setValue('JAM_MULAI_FIX', $seminar->jam_mulai ? Carbon::parse($seminar->jam_mulai)->format('H:i') : 'N/A');
            $templateProcessor->setValue('JAM_SELESAI_FIX', $seminar->jam_selesai ? Carbon::parse($seminar->jam_selesai)->format('H:i') : 'N/A');
            $templateProcessor->setValue('RUANGAN_FIX', $seminar->ruangan ?? 'N/A');

            $templateProcessor->setValue('NAMA_DOSEN_PEMBIMBING', $dosenPembimbingUser->name ?? 'N/A');
            $templateProcessor->setValue('NIDN_DOSEN_PEMBIMBING', $seminar->pengajuanKp->dosenPembimbing->nidn ?? 'N/A'); // Ambil NIDN dari tabel dosens

            // Placeholder untuk penguji (jika sudah ada fiturnya, jika belum, biarkan kosong atau isi strip)
            $templateProcessor->setValue('NAMA_DOSEN_PENGUJI_1', '(Nama Penguji 1)'); // Ganti jika ada data
            $templateProcessor->setValue('NIP_NIDN_PENGUJI_1', '(NIP/NIDN Penguji 1)'); // Ganti jika ada data
            // $templateProcessor->setValue('NAMA_DOSEN_PENGUJI_2', '(Nama Penguji 2)'); // Jika ada penguji 2
            // $templateProcessor->setValue('NIP_NIDN_PENGUJI_2', '(NIP/NIDN Penguji 2)');

            $templateProcessor->setValue('KETUA_JURUSAN_NAMA', $ketuaJurusanNama); // Sesuaikan
            $templateProcessor->setValue('KETUA_JURUSAN_NIP', $ketuaJurusanNip);   // Sesuaikan

            // Nama file yang akan diunduh
            $fileName = 'Blangko_Berita_Acara_Seminar_' . Str::slug($mahasiswaUser->name ?? 'mahasiswa', '_') . '.docx';

            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord_BAS');
            $templateProcessor->saveAs($tempFile);

            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat dokumen Berita Acara: ' . $e->getMessage());
        }
    }
}
