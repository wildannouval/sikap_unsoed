<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Exports\LaporanKpLengkapExport;
use App\Models\PengajuanKp; // Import PengajuanKp
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Jurusan;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jurusans = Jurusan::orderBy('nama')->get();
        $kpStatuses = ['pengajuan', 'dalam_proses', 'selesai', 'lulus', 'tidak_lulus'];

        $pengajuanKps = null;

        if ($request->has('filter')) {
            $query = PengajuanKp::query()->with(['mahasiswa.user', 'mahasiswa.jurusan', 'dosenPembimbing.user']);

            // ... (Logika filter tetap sama) ...
            if ($request->filled('jurusan_id')) {
                $query->whereHas('mahasiswa', fn($q) => $q->where('jurusan_id', $request->jurusan_id));
            }
            if ($request->filled('status_kp')) {
                $query->where('status_kp', $request->status_kp);
            }
            if ($request->filled('tanggal_mulai')) {
                $query->whereDate('tanggal_mulai_kp', '>=', $request->tanggal_mulai);
            }
            if ($request->filled('tanggal_selesai')) {
                $query->whereDate('tanggal_selesai_kp', '<=', $request->tanggal_selesai);
            }

            $pengajuanKps = $query->orderBy('tanggal_pengajuan', 'desc')->paginate(15)->appends($request->query());
        }

        // --- PERBAIKAN: Tentukan view berdasarkan peran ---
        $viewName = Auth::user()->role === 'bapendik' ? 'bapendik.laporan.index' : 'dosen-komisi.laporan.index';

        return view($viewName, compact('jurusans', 'kpStatuses', 'pengajuanKps'));
    }

    public function exportKpLengkap(Request $request)
    {
        // Validasi tetap bisa dilakukan di sini untuk keamanan
        $request->validate(['tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai']);

        $filters = $request->only(['jurusan_id', 'status_kp', 'tanggal_mulai', 'tanggal_selesai']);
        $fileName = 'laporan-kp-' . now()->format('Y-m-d-His') . '.xlsx';

        return Excel::download(new LaporanKpLengkapExport($filters), $fileName);
    }
}
