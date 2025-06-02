<?php

namespace App\Http\Controllers\DosenKomisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanKp;
use App\Models\User; // Untuk menghitung total dosen
use Illuminate\Support\Facades\Auth; // Jika perlu info user Dosen Komisi yang login

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk "Tugas Mendesak"
        // Dosen Komisi perlu memvalidasi pengajuan KP yang statusnya 'direview'
        $countPengajuanKpMenungguValidasi = PengajuanKp::where('status_komisi', 'direview')->count();

        // Data untuk "Statistik Kunci"
        $countTotalPengajuanKpDiproses = PengajuanKp::whereIn('status_komisi', ['diterima', 'ditolak'])->count();
        $countTotalDosen = User::where('role', 'dosen')->count(); // Jumlah semua user dengan role dosen

        return view('dosen-komisi.dashboard', compact(
            'countPengajuanKpMenungguValidasi',
            'countTotalPengajuanKpDiproses',
            'countTotalDosen'
        ));
    }
}
