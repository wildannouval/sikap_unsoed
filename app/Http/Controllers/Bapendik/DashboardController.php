<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\PengajuanKp;
use App\Models\Seminar;
use App\Models\SuratPengantar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk "Tugas Mendesak"
        $countSuratMenungguValidasi = SuratPengantar::where('status_bapendik', 'menunggu')->count();
        $countSeminarMenungguJadwal = Seminar::where('status_pengajuan', 'disetujui_dospem')->count();

        // --- TAMBAHAN: Hitung SPK & Berita Acara yang perlu dicetak ---
        // SPK perlu dicetak jika KP sudah diterima komisi TAPI belum ada tanggal cetak SPK.
        $countSpkMenungguCetak = PengajuanKp::where('status_komisi', 'diterima')
            ->whereNull('spk_dicetak_at')
            ->count();

        // Berita Acara perlu dicetak jika seminar sudah dijadwalkan.
        $countBaMenungguCetak = Seminar::where('status_pengajuan', 'dijadwalkan_bapendik')->count();


        // Data untuk "Statistik Kunci"
        $countMahasiswaAktifKp = PengajuanKp::where('status_kp', 'dalam_proses')->distinct('mahasiswa_id')->count();
        $countTotalJurusan = Jurusan::count();
        $countTotalMahasiswa = User::where('role', 'mahasiswa')->count();
        $countTotalDosen = User::where('role', 'dosen')->count();

        // Data untuk "Aktivitas Terbaru"
        $recentActivities = SuratPengantar::with('mahasiswa.user')
            ->latest('tanggal_pengajuan')
            ->take(5)
            ->get();

        return view('bapendik.dashboard', compact(
            'countSuratMenungguValidasi',
            'countSeminarMenungguJadwal',
            'countSpkMenungguCetak',         // <-- Kirim data baru ke view
            'countBaMenungguCetak',          // <-- Kirim data baru ke view
            'countMahasiswaAktifKp',
            'countTotalJurusan',
            'countTotalMahasiswa',
            'countTotalDosen',
            'recentActivities'
        ));
    }

//    public function index()
//    {
//        // Statistik Cepat
//        $countSuratMenunggu = SuratPengantar::where('status_bapendik', 'menunggu')->count();
//        $countSeminarMenungguJadwal = Seminar::where('status_pengajuan', 'disetujui_dospem')->count();
//
//        // Mengambil jumlah mahasiswa yang status KP-nya 'dalam_proses' atau 'pengajuan' & 'diterima' komisi
//        $countMahasiswaAktifKp = PengajuanKp::where(function ($query) {
//            $query->where('status_kp', 'dalam_proses')
//                ->orWhere(function ($subQuery) {
//                    $subQuery->where('status_kp', 'pengajuan')
//                        ->where('status_komisi', 'diterima');
//                });
//        })
//            ->distinct('mahasiswa_id')
//            ->count();
//
//        $countTotalMahasiswa = User::where('role', 'mahasiswa')->count();
//        $countTotalDosen = User::where('role', 'dosen')->count();
//        $countTotalJurusan = Jurusan::count();
//
//        // Daftar Tugas Mendesak (5 terbaru)
//        $suratMenungguValidasi = SuratPengantar::where('status_bapendik', 'menunggu')
//            ->with('mahasiswa.user', 'mahasiswa.jurusan')
//            ->latest('tanggal_pengajuan')
//            ->take(5)
//            ->get();
//
//        $seminarMenungguJadwal = Seminar::where('status_pengajuan', 'disetujui_dospem')
//            ->with(['mahasiswa.user', 'mahasiswa.jurusan', 'pengajuanKp.dosenPembimbing.user'])
//            ->latest('dospem_approved_at') // Asumsi ada kolom ini
//            ->take(5)
//            ->get();
//
//        return view('bapendik.dashboard', compact(
//            'countSuratMenunggu',
//            'countSeminarMenungguJadwal',
//            'countMahasiswaAktifKp',
//            'countTotalMahasiswa',
//            'countTotalDosen',
//            'countTotalJurusan',
//            'suratMenungguValidasi',
//            'seminarMenungguJadwal'
//        ));
//    }
}
