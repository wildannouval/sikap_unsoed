<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PengajuanKp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\BimbinganKpExport;
use Maatwebsite\Excel\Facades\Excel;

class BimbinganKpController extends Controller
{
    public function index(Request $request)
    {
        $dosenId = Auth::user()->dosen->id; // Pastikan relasi 'dosen' ada di model User

        $query = PengajuanKp::where('dosen_pembimbing_id', $dosenId)
            ->where('status_kp', 'dalam_proses') // Hanya yang aktif
            ->with(['mahasiswa.user', 'mahasiswa.jurusan'])
            ->latest('updated_at');

        // Opsional: Tambahkan search jika perlu
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('mahasiswa.user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%");
            })->orWhereHas('mahasiswa', function ($q) use ($searchTerm) {
                $q->where('nim', 'like', "%{$searchTerm}%");
            })->orWhere('judul_kp', 'like', "%{$searchTerm}%");
        }

        $pengajuanKps = $query->paginate(10)->appends($request->query());

        return view('dosen-pembimbing.bimbingan_kp.index', compact('pengajuanKps', 'request'));
    }

    public function exportExcel(Request $request)
    {
        $dosenId = auth()->user()->dosen->id;
        $searchTerm = $request->query('search');
        $fileName = 'laporan-bimbingan-kp-' . auth()->user()->name . '-' . now()->format('d-m-Y') . '.xlsx';

        return Excel::download(new BimbinganKpExport($dosenId, $searchTerm), $fileName);
    }
}
