<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanKp;
use App\Models\Konsultasi;
use App\Models\Seminar;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dosen = $user->dosen;
        if (!$dosen) {
            return redirect()->route('home')->with('error', 'Profil dosen tidak ditemukan.');
        }

        $isKomisi = $dosen->is_komisi;

        // --- Data untuk Kartu Tugas Mendesak ---
        $countSeminarMenungguPersetujuan = Seminar::whereHas('pengajuanKp', fn($q) => $q->where('dosen_pembimbing_id', $dosen->id))
            ->where('status_pengajuan', 'diajukan_mahasiswa')->count();

        $countKonsultasiMenungguVerifikasi = Konsultasi::where('dosen_pembimbing_id', $dosen->id)
            ->where('diverifikasi', false)->count();

        $countSeminarMenungguPenilaian = Seminar::whereHas('pengajuanKp', fn($q) => $q->where('dosen_pembimbing_id', $dosen->id))
            ->where('status_pengajuan', 'dijadwalkan_bapendik')->count();

        // --- TAMBAHAN: Data untuk daftar & jadwal ---
        $mahasiswaBimbingan = PengajuanKp::where('dosen_pembimbing_id', $dosen->id)
            ->where('status_kp', 'dalam_proses')
            ->with('mahasiswa.user')
            ->latest('updated_at')
            ->take(5)
            ->get();

        $seminarMendatang = Seminar::whereHas('pengajuanKp', fn($q) => $q->where('dosen_pembimbing_id', $dosen->id))
            ->where('status_pengajuan', 'dijadwalkan_bapendik')
            ->where('tanggal_seminar', '>=', now()->startOfDay())
            ->with('mahasiswa.user')
            ->orderBy('tanggal_seminar', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->take(3)
            ->get();

        // Data khusus Dosen Komisi
        $countPengajuanKpMenungguValidasi = 0;
        if ($isKomisi) {
            $countPengajuanKpMenungguValidasi = PengajuanKp::where('status_komisi', 'direview')->count();
        }

        return view('dosen.dashboard', [
            'is_komisi' => $isKomisi,
            'countSeminarMenungguPersetujuan' => $countSeminarMenungguPersetujuan,
            'countKonsultasiMenungguVerifikasi' => $countKonsultasiMenungguVerifikasi,
            'countSeminarMenungguPenilaian' => $countSeminarMenungguPenilaian,
            'countPengajuanKpMenungguValidasi' => $countPengajuanKpMenungguValidasi,
            'mahasiswaBimbingan' => $mahasiswaBimbingan, // Kirim data bimbingan
            'seminarMendatang' => $seminarMendatang,   // Kirim data seminar
        ]);
    }
}
