<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanKp;
use App\Models\Konsultasi;
use App\Models\Seminar;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->dosen) {
            return view('dosen-pembimbing.dashboard')->withErrors(['profil_dosen' => 'Profil dosen tidak ditemukan.']);
        }
        $dosenId = $user->dosen->id;

        // Data untuk "Tugas Mendesak"
        $countSeminarMenungguPersetujuan = Seminar::whereHas('pengajuanKp', function ($query) use ($dosenId) {
            $query->where('dosen_pembimbing_id', $dosenId);
        })->where('status_pengajuan', 'diajukan_mahasiswa')->count();

        $countKonsultasiMenungguVerifikasi = Konsultasi::where('dosen_pembimbing_id', $dosenId)
            ->where('diverifikasi', false)
            ->count();

        $countSeminarMenungguPenilaian = Seminar::whereHas('pengajuanKp', function ($query) use ($dosenId) {
            $query->where('dosen_pembimbing_id', $dosenId);
        })->where('status_pengajuan', 'dijadwalkan_komisi')->count();


        // Data untuk "Statistik Kunci"
        $countMahasiswaBimbinganAktif = PengajuanKp::where('dosen_pembimbing_id', $dosenId)
            ->where('status_kp', 'dalam_proses') // KP yang aktif dan sedang berjalan
            ->count();

        $countTotalKonsultasiDiverifikasi = Konsultasi::where('dosen_pembimbing_id', $dosenId)
            ->where('diverifikasi', true)
            ->count();

        $countTotalSeminarDinilai = Seminar::whereHas('pengajuanKp', function ($query) use ($dosenId) {
            $query->where('dosen_pembimbing_id', $dosenId);
        })->where('status_pengajuan', 'selesai_dinilai')->count();


        return view('dosen-pembimbing.dashboard', compact(
            'countSeminarMenungguPersetujuan',
            'countKonsultasiMenungguVerifikasi',
            'countSeminarMenungguPenilaian',
            'countMahasiswaBimbinganAktif',
            'countTotalKonsultasiDiverifikasi',
            'countTotalSeminarDinilai'
        ));
    }
}
