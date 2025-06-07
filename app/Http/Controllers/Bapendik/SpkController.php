<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Models\PengajuanKp;
use App\Models\Jurusan; // Untuk filter
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use Illuminate\Support\Str; // Untuk Str::slug

class SpkController extends Controller
{
    /**
     * Menampilkan daftar pengajuan KP yang sudah disetujui Komisi dan siap untuk SPK.
     */
    public function index(Request $request)
    {
        $query = PengajuanKp::where('status_komisi', 'diterima') // Hanya yang sudah diterima komisi
        ->whereNotNull('dosen_pembimbing_id') // Pastikan dosen pembimbing sudah ada
        ->whereNotNull('tanggal_diterima_komisi') // Pastikan tanggal diterima komisi sudah ada
        ->with(['mahasiswa.user', 'mahasiswa.jurusan', 'dosenPembimbing.user', 'suratPengantar'])
            ->latest('tanggal_diterima_komisi');

        // Filter berdasarkan jurusan mahasiswa
        if ($request->filled('jurusan_id')) {
            $query->whereHas('mahasiswa.jurusan', function ($q) use ($request) {
                $q->where('id', $request->jurusan_id);
            });
        }

        // Search (nama mahasiswa, nim, judul kp, instansi)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul_kp', 'like', "%{$searchTerm}%")
                    ->orWhere('instansi_lokasi', 'like', "%{$searchTerm}%")
                    ->orWhereHas('mahasiswa.user', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('mahasiswa', function ($subQ) use ($searchTerm) {
                        $subQ->where('nim', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // --- FILTER STATUS SPK BARU ---
        if ($request->filled('status_spk_filter')) {
            if ($request->status_spk_filter == 'sudah_dicetak') {
                $query->whereNotNull('spk_dicetak_at');
            } elseif ($request->status_spk_filter == 'belum_dicetak') {
                $query->whereNull('spk_dicetak_at');
            }
        }

        $pengajuanKps = $query->paginate(10)->appends($request->query());
        $jurusans = Jurusan::orderBy('nama')->get();

        // Daftar status baru untuk dropdown filter
        $spkStatuses = [
            'belum_dicetak' => 'Belum Dicetak',
            'sudah_dicetak' => 'Sudah Dicetak',
        ];


        return view('bapendik.spk.index', compact('pengajuanKps', 'jurusans', 'request', 'spkStatuses'));
    }

    /**
     * Generate dan download SPK dalam format Word.
     */
    public function exportSpkWord(PengajuanKp $pengajuanKp) // Route Model Binding
    {
        // Validasi awal
        if ($pengajuanKp->status_komisi !== 'diterima' || !$pengajuanKp->dosen_pembimbing_id || !$pengajuanKp->tanggal_diterima_komisi) {
            return redirect()->back()->with('error', 'SPK hanya bisa dibuat untuk pengajuan KP yang sudah disetujui Komisi dan memiliki Dosen Pembimbing serta tanggal persetujuan.');
        }

        $templatePath = storage_path('app/templates/template_spk.docx');

        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'File templates SPK tidak ditemukan.');
        }

        try {
            $templateProcessor = new TemplateProcessor($templatePath);

            // Load relasi yang mungkin belum ter-load secara eksplisit
            $pengajuanKp->load(['mahasiswa.user', 'mahasiswa.jurusan', 'dosenPembimbing.user', 'dosenPembimbing.jurusan', 'suratPengantar']);

            // Siapkan data dari model
            $mahasiswaUser = $pengajuanKp->mahasiswa->user;
            $dataMahasiswa = $pengajuanKp->mahasiswa;
            $jurusanMahasiswa = $dataMahasiswa->jurusan;
            $dosenPembimbingUser = $pengajuanKp->dosenPembimbing->user;
            $dataDosenPembimbing = $pengajuanKp->dosenPembimbing;

            // Data pejabat yang menerbitkan SPK (contoh, sesuaikan dengan institusimu)
            // Ini bisa diambil dari database (tabel pejabat/users dengan role tertentu) atau config
            $pejabatSpkNama = "Dr. Lasmedi Afuan, ST M.Cs"; // Contoh Nama
            $pejabatSpkJabatan = "Ketua Jurusan "; // Contoh Jabatan
            $pejabatSpkNip = "198505102008121002"; // Contoh NIP

            // Contoh format Nomor SPK (sesuaikan dengan format di institusimu)
            // Format: ID_Pengajuan/SPK/KodeFakultas/KodeJurusan/BulanRomawi/Tahun
            $bulanRomawi = $this->getRomanMonth(Carbon::now()->month);
            $nomorSpk = sprintf('%03d', $pengajuanKp->id) . "/SPK/FT/{$jurusanMahasiswa->kode}/{$bulanRomawi}/" . Carbon::now()->year;

//            // Hitung lama periode KP
//            $lamaPeriode = '';
//            if ($pengajuanKp->tanggal_mulai && $pengajuanKp->tanggal_selesai) {
//                $tglMulai = Carbon::parse($pengajuanKp->tanggal_mulai);
//                $tglSelesai = Carbon::parse($pengajuanKp->tanggal_selesai);
//                $diffInMonths = $tglMulai->diffInMonths($tglSelesai);
//                $lamaPeriode = $diffInMonths . " (" . Str::ucfirst(Carbon::now()->month($diffInMonths)->locale('id')->monthName) . ") Bulan";
//                // Atau cara lain yang lebih presisi jika perlu menghitung hari juga
//            }


            // Set nilai placeholder
            $templateProcessor->setValue('NOMOR_SPK', $nomorSpk);
            $templateProcessor->setValue('TANGGAL_SPK_DIBUAT', Carbon::now()->isoFormat('D MMMM YYYY'));
            $templateProcessor->setValue('TEMPAT_PENERBITAN_SPK', 'Purbalingga'); // Atau ambil dari config

            $templateProcessor->setValue('DASAR_PENERBITAN_1', 'Surat Pengajuan Kerja Praktek mahasiswa ybs.');
            $templateProcessor->setValue('DASAR_PENERBITAN_2', 'Persetujuan dari Komisi Kerja Praktek Jurusan ' . $jurusanMahasiswa->nama . ' tanggal ' . Carbon::parse($pengajuanKp->tanggal_diterima_komisi)->isoFormat('D MMMM YYYY'));

            $templateProcessor->setValue('NAMA_MAHASISWA', $mahasiswaUser->name);
            $templateProcessor->setValue('NIM_MAHASISWA', $dataMahasiswa->nim);
            $templateProcessor->setValue('JURUSAN_MAHASISWA', $jurusanMahasiswa->nama);
            $templateProcessor->setValue('FAKULTAS_MAHASISWA', $jurusanMahasiswa->fakultas); // Pastikan ada di tabel jurusans
            $templateProcessor->setValue('JENJANG_MAHASISWA', $jurusanMahasiswa->jenjang); // Pastikan ada

            $templateProcessor->setValue('JUDUL_KP', $pengajuanKp->judul_kp);
            $templateProcessor->setValue('NAMA_INSTANSI_KP', $pengajuanKp->instansi_lokasi);
            $templateProcessor->setValue('ALAMAT_INSTANSI_KP', $pengajuanKp->suratPengantar->alamat_surat ?? '(Alamat tidak tercantum di Surat Pengantar)');

            $templateProcessor->setValue('NAMA_DOSEN_PEMBIMBING', $dosenPembimbingUser->name);
            $templateProcessor->setValue('NIDN_DOSEN_PEMBIMBING', $dataDosenPembimbing->nidn);
            // $templateProcessor->setValue('JURUSAN_DOSEN_PEMBIMBING', $dataDosenPembimbing->jurusan->nama ?? 'N/A');


            $templateProcessor->setValue('TANGGAL_MULAI_KP', $pengajuanKp->tanggal_mulai ? Carbon::parse($pengajuanKp->tanggal_mulai)->isoFormat('D MMMM YYYY') : 'N/A');
            $templateProcessor->setValue('TANGGAL_SELESAI_KP', $pengajuanKp->tanggal_selesai ? Carbon::parse($pengajuanKp->tanggal_selesai)->isoFormat('D MMMM YYYY') : 'N/A');
            // $templateProcessor->setValue('PERIODE_KP_LAMA', $lamaPeriode); // Jika ada placeholder ini

            // Data Pejabat Penandatangan SPK
            $templateProcessor->setValue('NAMA_PEJABAT_SPK', $pejabatSpkNama);
            $templateProcessor->setValue('JABATAN_PEJABAT_SPK', $pejabatSpkJabatan);
            $templateProcessor->setValue('NIP_PEJABAT_SPK', $pejabatSpkNip);

            // Nama file yang akan diunduh
            $safeMahasiswaName = Str::slug($mahasiswaUser->name, '_');
            $fileName = 'SPK_' . $dataMahasiswa->nim . '_' . $safeMahasiswaName . '.docx';

            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord_SPK_');
            $templateProcessor->saveAs($tempFile);

            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
            // Log error $e->getMessage()
            return redirect()->back()->with('error', 'Gagal membuat dokumen SPK: Terjadi kesalahan pada templates atau data.');
        }
    }

    // Helper function untuk bulan Romawi (jika diperlukan)
    private function getRomanMonth(int $monthNumber): string
    {
        $map = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1];
        $returnValue = '';
        // Untuk bulan, kita hanya butuh sampai XII
        $romanMonths = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
        return $romanMonths[$monthNumber] ?? '';
    }

    /**
     * Menampilkan form untuk mengelola status SPK (cetak/diambil).
     */
    public function edit(PengajuanKp $pengajuanKp)
    {
        // Validasi awal
        if ($pengajuanKp->status_komisi !== 'diterima' || !$pengajuanKp->dosen_pembimbing_id) {
            return redirect()->route('bapendik.spk.index')->with('error', 'Halaman ini hanya untuk KP yang sudah disetujui Komisi.');
        }
        $pengajuanKp->load(['mahasiswa.user', 'mahasiswa.jurusan', 'dosenPembimbing.user']);

        return view('bapendik.spk.edit', compact('pengajuanKp'));
    }

    /**
     * Memperbarui status SPK.
     */
    public function update(Request $request, PengajuanKp $pengajuanKp)
    {
        $request->validate([
            'spk_dicetak' => 'nullable|boolean',
            'spk_diambil_at' => 'nullable|date|required_if:spk_dicetak,1',
            'catatan_spk' => 'nullable|string|max:1000',
        ]);

        // Cek apakah checkbox "Tandai Sudah Dicetak" dicentang
        if ($request->has('spk_dicetak') && $request->spk_dicetak == '1') {
            // Hanya set tanggal cetak jika belum pernah di-set, untuk mencatat kapan pertama kali dicetak
            if (is_null($pengajuanKp->spk_dicetak_at)) {
                $pengajuanKp->spk_dicetak_at = now();
            }
            // Set atau update tanggal pengambilan
            $pengajuanKp->spk_diambil_at = $request->spk_diambil_at;
        } else {
            // Jika checkbox tidak dicentang, Bapendik bisa membatalkan status cetak
            $pengajuanKp->spk_dicetak_at = null;
            $pengajuanKp->spk_diambil_at = null; // Tanggal pengambilan juga dikosongkan
        }

        $pengajuanKp->catatan_spk = $request->catatan_spk;
        $pengajuanKp->save();

        return redirect()->route('bapendik.spk.index')
            ->with('success_modal_message', 'Status SPK untuk mahasiswa ' . $pengajuanKp->mahasiswa->user->name . ' berhasil diperbarui.');
    }
}
