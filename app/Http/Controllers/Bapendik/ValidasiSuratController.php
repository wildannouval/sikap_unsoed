<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\SuratPengantar;
use App\Notifications\ResponSuratPengantar;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Auth; // Jika diperlukan
use Carbon\Carbon;
use Illuminate\Support\Str;

class ValidasiSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SuratPengantar::with(['mahasiswa.user', 'mahasiswa.jurusan'])->latest();

        // Filter berdasarkan status
        if ($request->filled('status_bapendik')) {
            $query->where('status_bapendik', $request->status_bapendik);
        }

        // Filter berdasarkan jurusan (melalui relasi mahasiswa)
        if ($request->filled('jurusan_id')) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('jurusan_id', $request->jurusan_id);
            });
        }

        // Search (nama mahasiswa, nim, lokasi penelitian)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('lokasi_penelitian', 'like', "%{$searchTerm}%")
                    ->orWhereHas('mahasiswa.user', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('mahasiswa', function ($subQ) use ($searchTerm) {
                        $subQ->where('nim', 'like', "%{$searchTerm}%");
                    });
            });
        }

        $suratPengantars = $query->paginate(10)->appends($request->query());
        $jurusans = Jurusan::orderBy('nama')->get(); // Untuk dropdown filter

        return view('bapendik.validasi_surat.index', compact('suratPengantars', 'jurusans', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratPengantar $suratPengantar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Laravel akan otomatis inject $suratPengantar berdasarkan ID dari URL
     */
    public function edit(SuratPengantar $suratPengantar)
    {
        // Load relasi yang mungkin dibutuhkan di view
        $suratPengantar->load(['mahasiswa.user', 'mahasiswa.jurusan']);
        return view('bapendik.validasi_surat.edit', compact('suratPengantar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratPengantar $suratPengantar)
    {
        $request->validate([
            'status_bapendik' => 'required|in:menunggu,disetujui,ditolak',
            'catatan_bapendik' => 'nullable|string',
            'tanggal_pengambilan' => 'nullable|date|required_if:status_bapendik,disetujui',
        ]);

        $suratPengantar->status_bapendik = $request->status_bapendik;
        $suratPengantar->catatan_bapendik = $request->catatan_bapendik;

        if ($request->status_bapendik == 'disetujui') {
            $suratPengantar->tanggal_pengambilan = $request->tanggal_pengambilan;
        } else {
            // Jika ditolak atau kembali ke menunggu, hapus tanggal pengambilan
            $suratPengantar->tanggal_pengambilan = null;
        }

        $suratPengantar->save();

        // --- AWAL BAGIAN BARU: MENGIRIM NOTIFIKASI KE MAHASISWA ---
        // Ambil user yang terkait dengan mahasiswa pemilik surat pengantar
        $mahasiswaUser = $suratPengantar->mahasiswa->user;

        // Kirim notifikasi
        if ($mahasiswaUser) {
            $mahasiswaUser->notify(new ResponSuratPengantar($suratPengantar));
        }
        // --- AKHIR BAGIAN BARU ---

        return redirect()->route('bapendik.validasi-surat.index')
            ->with('success_modal_message', 'Status pengajuan surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratPengantar $suratPengantar)
    {
        //
    }

    public function exportWord(SuratPengantar $suratPengantar)
    {
        // Pastikan surat sudah disetujui untuk diekspor
        if ($suratPengantar->status_bapendik !== 'disetujui') {
            return redirect()->back()->with('error', 'Surat Pengantar ini belum disetujui atau status tidak valid untuk export.');
        }

        $templatePath = storage_path('app/templates/template_surat_pengantar.docx');

        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'File template Surat Pengantar tidak ditemukan.');
        }

        try {
            $templateProcessor = new TemplateProcessor($templatePath);

            // Load relasi yang dibutuhkan jika belum ter-load
            $suratPengantar->load(['mahasiswa.user', 'mahasiswa.jurusan']);

            // Data Mahasiswa
            $namaMahasiswa = $suratPengantar->mahasiswa->user->name ?? 'N/A';
            $nimMahasiswa = $suratPengantar->mahasiswa->nim ?? 'N/A';
            $jurusanMahasiswa = $suratPengantar->mahasiswa->jurusan->nama ?? 'N/A';
            $fakultasMahasiswa = $suratPengantar->mahasiswa->jurusan->fakultas ?? 'N/A'; // Pastikan ada di model Jurusan
            $jenjangMahasiswa = $suratPengantar->mahasiswa->jurusan->jenjang ?? 'N/A';   // Pastikan ada

            // Data Pejabat Penandatangan (Contoh - sesuaikan dengan kebutuhan)
            // Ini bisa diambil dari database, config, atau di-hardcode jika selalu sama
            $namaPenandatangan = "Dr. Eng. Suroso, S.T., M.Eng."; // Ganti dengan nama pejabat yang benar
            $jabatanPenandatangan = "a.n. Dekan,\nWakil Dekan Bidang Akademik"; // \n untuk baris baru di Word (jika template mendukung)
            $nipPenandatangan = "197406022003121001"; // Ganti dengan NIP yang benar

            // Nomor Surat (Contoh logika sederhana, sesuaikan dengan format institusi)
            // Misalnya: IDSurat/SP/KodeFakultas/KodeJurusan/BulanRomawi/Tahun
            // Kolom 'nomor_surat_resmi' bisa diisi oleh Bapendik saat approval jika diperlukan
            $nomorSuratResmi = $suratPengantar->nomor_surat_resmi;
            if (empty($nomorSuratResmi)) {
                // Contoh logika generate jika nomor surat belum ada:
                $fakultasKode = $jurusanMahasiswa->fakultas_kode_singkat ?? 'FT'; // Asumsi ada accessor/kolom fakultas_kode_singkat
                $jurusanKode = $jurusanMahasiswa->kode ?? 'XX';
                $bulanRomawi = $this->getRomanMonth(Carbon::parse($suratPengantar->tanggal_pengajuan)->month);
                $tahunPengajuan = Carbon::parse($suratPengantar->tanggal_pengajuan)->year;
                $nomorSuratResmi = sprintf('%03d', $suratPengantar->id) . "/SPENG/{$fakultasKode}/{$jurusanKode}/{$bulanRomawi}/{$tahunPengajuan}";
            }

            // Mengisi placeholder di template
            $templateProcessor->setValue('NOMOR_SURAT', $nomorSuratResmi);
            $templateProcessor->setValue('TEMPAT_SURAT_DIBUAT', 'Purbalingga'); // Sesuaikan jika dinamis
            $templateProcessor->setValue('TANGGAL_SURAT_DIBUAT', Carbon::now()->isoFormat('D MMMM YYYY'));
            $templateProcessor->setValue('LAMPIRAN', 'I Lembar'); // Atau dinamis jika perlu
            $templateProcessor->setValue('PERIHAL', 'Permohonan Ijin Kerja Praktek'); // Atau dinamis jika perlu

            $templateProcessor->setValue('PENERIMA_SURAT', $suratPengantar->penerima_surat);
            $templateProcessor->setValue('NAMA_INSTANSI_TUJUAN', $suratPengantar->lokasi_penelitian);
            $templateProcessor->setValue('ALAMAT_INSTANSI_LENGKAP', $suratPengantar->alamat_surat);

            $templateProcessor->setValue('NAMA_MAHASISWA', $namaMahasiswa);
            $templateProcessor->setValue('NIM_MAHASISWA', $nimMahasiswa);
            $templateProcessor->setValue('JURUSAN_MAHASISWA', $jurusanMahasiswa);
            $templateProcessor->setValue('FAKULTAS_MAHASISWA', $fakultasMahasiswa);
            $templateProcessor->setValue('JENJANG_MAHASISWA', $jenjangMahasiswa);
            $templateProcessor->setValue('TAHUN_AKADEMIK_PENGAJUAN', $suratPengantar->tahun_akademik);

            // Untuk semester, jika format tahun_akademik seperti "Genap 2022/2023"
            // Anda bisa memprosesnya atau memiliki kolom terpisah. Untuk contoh:
            $templateProcessor->setValue('SEMESTER_TAHUN_AJARAN', $suratPengantar->tahun_akademik);
            // Jika 'penerima_surat' adalah unit/departemen, itu bisa jadi LOKASI_DETAIL_KP_DI_INSTANSI
            // Jika lokasi_penelitian sudah detail, gunakan itu. Sesuaikan.
            $templateProcessor->setValue('LOKASI_DETAIL_KP_DI_INSTANSI', $suratPengantar->lokasi_penelitian);


            // Data Penandatangan
            // $templateProcessor->setValue('ATAS_NAMA_JABATAN_1', "a.n. Dekan,"); // Jika ada placeholder ini
            $templateProcessor->setValue('JABATAN_PENANDATANGAN', $jabatanPenandatangan);
            $templateProcessor->setValue('NAMA_PENANDATANGAN', $namaPenandatangan);
            $templateProcessor->setValue('NIP_PENANDATANGAN', $nipPenandatangan);

            // Tembusan
            $templateProcessor->setValue('TEMBUSAN_1', "Ketua Jurusan " . $jurusanMahasiswa);
            // Jika kolom 'tembusan_surat' di database berisi teks lengkap untuk tembusan lainnya:
            // $templateProcessor->setValue('TEMBUSAN_LAINNYA', $suratPengantar->tembusan_surat ?? 'Pertinggal');
            // Jika tidak, bisa di-hardcode 'Pertinggal' atau dikosongkan
            $templateProcessor->setValue('TEMBUSAN_LAINNYA', 'Pertinggal');


            // Nama file yang akan diunduh
            $safeMahasiswaName = Str::slug($namaMahasiswa, '_');
            $fileName = 'Surat_Pengantar_KP_' . $nimMahasiswa . '_' . $safeMahasiswaName . '.docx';

            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord_SPengantar_');
            $templateProcessor->saveAs($tempFile);

            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
            // Log error: Log::error('PHPWord Exception: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat dokumen Surat Pengantar: Terjadi kesalahan pada template atau data. Detail: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Log error umum: Log::error('General Exception: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat dokumen Surat Pengantar: Terjadi kesalahan umum.');
        }
    }

    // Helper function untuk bulan Romawi (jika diperlukan untuk nomor surat)
    private function getRomanMonth(int $monthNumber): string
    {
        $romanMonths = [1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'];
        return $romanMonths[$monthNumber] ?? '';
    }
}
