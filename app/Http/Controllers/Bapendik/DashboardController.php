<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\PengajuanKp;
use App\Models\Seminar;
use App\Models\SuratPengantar;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk "Tugas Mendesak"
        $countSuratMenungguValidasi = SuratPengantar::where('status_bapendik', 'menunggu')->count();
        $countSeminarMenungguJadwal = Seminar::where('status_pengajuan', 'disetujui_dospem')->count();
        // Tambahkan hitungan lain jika ada tugas mendesak untuk Bapendik,
        // misalnya Pengajuan KP yang statusnya 'disetujui_dospem' dan perlu dibuatkan SPK
        // $countKpSiapSpk = PengajuanKp::where('status_komisi', 'diterima')
        //                             ->whereNotNull('tanggal_diterima_komisi')
        //                             // Tambahkan kondisi untuk cek apakah SPK sudah ada/dibuat jika perlu
        //                             ->count();


        // Data untuk "Statistik Kunci"
        $countMahasiswaAktifKp = PengajuanKp::where(function ($query) {
            $query->where('status_kp', 'dalam_proses')
                ->orWhere(function ($subQuery) {
                    $subQuery->where('status_kp', 'pengajuan')
                        ->where('status_komisi', 'diterima');
                });
        })
            ->distinct('mahasiswa_id')
            ->count();

        $countTotalJurusan = Jurusan::count();
        $countTotalMahasiswa = User::where('role', 'mahasiswa')->count();
        $countTotalDosen = User::where('role', 'dosen')->count();


        return view('bapendik.dashboard', compact(
            'countSuratMenungguValidasi',
            'countSeminarMenungguJadwal',
            // 'countKpSiapSpk',
            'countMahasiswaAktifKp',
            'countTotalJurusan',
            'countTotalMahasiswa',
            'countTotalDosen'
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
