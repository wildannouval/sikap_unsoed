<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\SuratPengantar;
use Illuminate\Http\Request;

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

        return redirect()->route('bapendik.validasi-surat.index')
            ->with('success', 'Status pengajuan surat berhasil diperbarui.');
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
        // Pastikan surat sudah disetujui
        if ($suratPengantar->status_bapendik !== 'disetujui') {
            return redirect()->back()->with('error', 'Surat pengantar belum disetujui atau status tidak valid untuk export.');
        }

        // Path ke file templates Word kamu
        $templatePath = storage_path('app/templates/template_surat_pengantar.docx');

        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'File templates surat tidak ditemukan.');
        }

        try {
            $templateProcessor = new TemplateProcessor($templatePath);

            // Siapkan data yang akan di-replace
            $mahasiswa = $suratPengantar->mahasiswa->user;
            $dataMahasiswa = $suratPengantar->mahasiswa;
            $jurusan = $dataMahasiswa->jurusan;

            // Contoh Nomor Surat (bisa dikembangkan lebih lanjut)
            // Misalnya: 001/SP/FTIK/V/2025 (No Urut/JenisSurat/Fakultas/BulanRomawi/Tahun)
            // Untuk saat ini kita buat sederhana atau kamu bisa tambahkan field nomor surat di db
            $nomorSurat = "{$suratPengantar->id}/SP-KP/{$jurusan->kode}/" . Carbon::now()->format('m/Y');

            $templateProcessor->setValue('NOMOR_SURAT', $nomorSurat);
            $templateProcessor->setValue('TANGGAL_SURAT', Carbon::now()->isoFormat('D MMMM YYYY'));
            $templateProcessor->setValue('NAMA_MAHASISWA', $mahasiswa->name);
            $templateProcessor->setValue('NIM_MAHASISWA', $dataMahasiswa->nim);
            $templateProcessor->setValue('JURUSAN_MAHASISWA', $jurusan->nama);
            $templateProcessor->setValue('FAKULTAS_MAHASISWA', $jurusan->fakultas); // Pastikan ada kolom fakultas di model Jurusan

            $templateProcessor->setValue('PENERIMA_SURAT', $suratPengantar->penerima_surat);
            $templateProcessor->setValue('NAMA_INSTANSI', $suratPengantar->lokasi_penelitian); // Asumsi lokasi penelitian = nama instansi
            $templateProcessor->setValue('ALAMAT_INSTANSI', $suratPengantar->alamat_surat);
            $templateProcessor->setValue('LOKASI_KP', $suratPengantar->lokasi_penelitian);
            $templateProcessor->setValue('PERIHAL_SURAT', 'Permohonan Kerja Praktek (KP)'); // Atau bisa dibuat dinamis

            // Data penandatangan (Bapendik/Pejabat Fakultas) - ini contoh, sesuaikan
            // $userBapendik = Auth::user(); // Atau user tertentu yang berwenang
            // $templateProcessor->setValue('NAMA_BAPENDIK', $userBapendik->name);
            // $templateProcessor->setValue('JABATAN_BAPENDIK', 'Kepala BAAK'); // Sesuaikan
            // $templateProcessor->setValue('NIP_BAPENDIK', $userBapendik->dosen->nidn ?? '-'); // Jika Bapendik adalah dosen

            // Nama file yang akan diunduh
            $fileName = 'Surat_Pengantar_KP_' . str_replace('/', '_', $dataMahasiswa->nim) . '_' . $mahasiswa->name . '.docx';

            // Simpan ke file sementara lalu kirim sebagai unduhan
            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
            $templateProcessor->saveAs($tempFile);

            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
            // Tangani error jika templates korup atau placeholder tidak ditemukan
            return redirect()->back()->with('error', 'Gagal membuat dokumen: ' . $e->getMessage());
        }
    }
}
