<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\PengajuanKp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class SpkController extends Controller
{
    /**
     * Menampilkan daftar pengajuan KP yang sudah disetujui Komisi.
     */
    public function index(Request $request)
    {
        $query = PengajuanKp::where('status_komisi', 'diterima') // Hanya yang sudah diterima komisi
        ->with(['mahasiswa.user', 'mahasiswa.jurusan', 'dosenPembimbing.user'])
            ->latest('tanggal_diterima_komisi'); // Urutkan berdasarkan tanggal diterima terbaru

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

        $pengajuanKps = $query->paginate(10)->appends($request->query());
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('bapendik.spk.index', compact('pengajuanKps', 'jurusans', 'request'));
    }

    /**
     * Generate dan download SPK dalam format Word.
     */
    public function exportSpkWord(PengajuanKp $pengajuanKp)
    {
        // Pastikan pengajuan KP sudah disetujui komisi
        if ($pengajuanKp->status_komisi !== 'diterima' || !$pengajuanKp->dosen_pembimbing_id || !$pengajuanKp->tanggal_diterima_komisi) {
            return redirect()->back()->with('error', 'Pengajuan KP belum disetujui sepenuhnya oleh komisi atau data tidak lengkap.');
        }

        $templatePath = storage_path('app/templates/template_spk.docx'); // Sesuaikan dengan path template SPK-mu

        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'File template SPK tidak ditemukan.');
        }

        try {
            $templateProcessor = new TemplateProcessor($templatePath);

            // Siapkan data
            $mahasiswaUser = $pengajuanKp->mahasiswa->user;
            $dataMahasiswa = $pengajuanKp->mahasiswa;
            $jurusanMahasiswa = $dataMahasiswa->jurusan;
            $dosenPembimbingUser = $pengajuanKp->dosenPembimbing->user; // User data for dosen
            $dataDosenPembimbing = $pengajuanKp->dosenPembimbing; // Profile data (nidn) for dosen

            // Contoh: data pejabat yang menerbitkan SPK (bisa dari config, database, atau hardcode)
            $pejabatSpk = [
                'nama' => 'Prof. Dr. Ir. Nama Pejabat, M.Eng.', // Ganti dengan nama sebenarnya
                'jabatan' => 'Wakil Dekan Bidang Akademik',        // Ganti dengan jabatan sebenarnya
                'nip' => '19XXXXXXXXXXXXXX',                     // Ganti dengan NIP sebenarnya
            ];

            // Contoh Nomor SPK (bisa dikembangkan)
            $nomorSpk = "{$pengajuanKp->id}/SPK/{$jurusanMahasiswa->kode}/" . Carbon::now()->format('m/Y');


            $templateProcessor->setValue('NOMOR_SPK', $nomorSpk);
            $templateProcessor->setValue('TANGGAL_SPK_DIBUAT', Carbon::now()->isoFormat('D MMMM YYYY'));
            $templateProcessor->setValue('DASAR_PENERBITAN_1', 'Surat Pengajuan Kerja Praktek mahasiswa ybs.');
            $templateProcessor->setValue('DASAR_PENERBITAN_2', 'Persetujuan dari Komisi Kerja Praktek Jurusan ' . $jurusanMahasiswa->nama . ' tanggal ' . Carbon::parse($pengajuanKp->tanggal_diterima_komisi)->isoFormat('D MMMM YYYY'));

            $templateProcessor->setValue('NAMA_MAHASISWA', $mahasiswaUser->name);
            $templateProcessor->setValue('NIM_MAHASISWA', $dataMahasiswa->nim);
            $templateProcessor->setValue('JURUSAN_MAHASISWA', $jurusanMahasiswa->nama);
            $templateProcessor->setValue('FAKULTAS_MAHASISWA', $jurusanMahasiswa->fakultas); // Asumsi ada field fakultas di model Jurusan

            $templateProcessor->setValue('JUDUL_KP', $pengajuanKp->judul_kp);
            $templateProcessor->setValue('NAMA_INSTANSI_KP', $pengajuanKp->instansi_lokasi);
            $templateProcessor->setValue('ALAMAT_INSTANSI_KP', $pengajuanKp->suratPengantar->alamat_surat ?? 'Alamat tidak tersedia'); // Ambil dari surat pengantar jika ada

            $templateProcessor->setValue('NAMA_DOSEN_PEMBIMBING', $dosenPembimbingUser->name);
            $templateProcessor->setValue('NIDN_DOSEN_PEMBIMBING', $dataDosenPembimbing->nidn);

            $templateProcessor->setValue('TANGGAL_MULAI_KP', Carbon::parse($pengajuanKp->tanggal_mulai)->isoFormat('D MMMM YYYY'));
            $templateProcessor->setValue('TANGGAL_SELESAI_KP', Carbon::parse($pengajuanKp->tanggal_selesai)->isoFormat('D MMMM YYYY'));

            $templateProcessor->setValue('NAMA_PEJABAT_PENERBIT_SPK', $pejabatSpk['nama']);
            $templateProcessor->setValue('JABATAN_PEJABAT_PENERBIT_SPK', $pejabatSpk['jabatan']);
            $templateProcessor->setValue('NIP_PEJABAT_PENERBIT_SPK', $pejabatSpk['nip']);

            $fileName = 'SPK_' . str_replace('/', '_', $dataMahasiswa->nim) . '_' . $mahasiswaUser->name . '.docx';

            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord_SPK');
            $templateProcessor->saveAs($tempFile);

            return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);

        } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat dokumen SPK: ' . $e->getMessage());
        }
    }
}
