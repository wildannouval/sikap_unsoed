<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeminarApprovalController extends Controller
{
        /**
         * Menampilkan daftar pengajuan seminar yang perlu diproses oleh dosen pembimbing.
         */
        public function index(Request $request)
    {
        $dosenId = Auth::user()->dosen->id;

        $query = Seminar::whereHas('pengajuanKp', function ($q) use ($dosenId) {
            $q->where('dosen_pembimbing_id', $dosenId);
        })
            ->with(['mahasiswa.user', 'pengajuanKp'])
            ->latest('tanggal_pengajuan_seminar'); // Atau latest('updated_at') jika ingin yang baru diproses muncul di atas

        // Filter berdasarkan status_pengajuan dari request
        if ($request->filled('status_pengajuan_filter')) {
            $query->where('status_pengajuan', $request->status_pengajuan_filter);
        }
        // Default filter jika tidak ada input, bisa tampilkan semua atau yang masih relevan bagi dospem
        // Misalnya, jika tidak ada filter, tampilkan yang 'diajukan_mahasiswa' dan 'disetujui_dospem'
        // atau biarkan saja menampilkan semua jika itu yang diinginkan.
        // Untuk contoh ini, kita biarkan menampilkan semua jika tidak ada filter status.

        // Search (Tetap sama)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul_kp_final', 'like', "%{$searchTerm}%")
                    ->orWhereHas('mahasiswa.user', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('mahasiswa', function ($subQ) use ($searchTerm) {
                        $subQ->where('nim', 'like', "%{$searchTerm}%");
                    });
            });
        }

        $seminarApplications = $query->paginate(10)->appends($request->query());

        // Daftar status untuk dropdown filter
        $statuses = [
            'diajukan_mahasiswa' => 'Diajukan Mahasiswa',
            'disetujui_dospem' => 'Disetujui oleh Anda',
            'ditolak_dospem' => 'Ditolak oleh Anda',
            'dijadwalkan_komisi' => 'Dijadwalkan Komisi',
            'selesai_dinilai' => 'Selesai Dinilai',
            'dibatalkan' => 'Dibatalkan',
            'revisi_jadwal_komisi' => 'Revisi Jadwal (dari Komisi)',
        ];

        return view('dosen-pembimbing.seminar_approval.index', compact('seminarApplications', 'request', 'statuses'));
    }

        /**
         * Menampilkan form untuk Dosen Pembimbing memproses (setuju/tolak) pengajuan seminar.
         */
    public function showForm(Seminar $seminar) // Route model binding
    {
        $dosenId = Auth::user()->dosen->id;
        // Autorisasi: Pastikan dosen yang login adalah pembimbing dari KP terkait seminar ini
        if ($seminar->pengajuanKp->dosen_pembimbing_id !== $dosenId) {
            abort(403, 'Akses ditolak. Anda bukan pembimbing untuk KP terkait seminar ini.');
        }

        // HAPUS ATAU KOMENTARI BLOK IF INI:
        /*
        if ($seminar->status_pengajuan !== 'diajukan_mahasiswa') {
            return redirect()->route('dosen-pembimbing.seminar-approval.index')
                             ->with('info', 'Pengajuan seminar ini sudah diproses atau statusnya tidak valid.');
        }
        */
        // View akan menangani tampilan berdasarkan status.

        $seminar->load(['mahasiswa.user', 'pengajuanKp']);
        return view('dosen-pembimbing.seminar_approval.form', compact('seminar'));
    }

        /**
         * Memproses persetujuan atau penolakan seminar oleh Dosen Pembimbing.
         */
        public function processApproval(Request $request, Seminar $seminar)
    {
        $dosenId = Auth::user()->dosen->id;
        if ($seminar->pengajuanKp->dosen_pembimbing_id !== $dosenId) {
            abort(403, 'Akses ditolak.');
        }
        if ($seminar->status_pengajuan !== 'diajukan_mahasiswa') {
            return redirect()->route('dosen-pembimbing.seminar-approval.index')
                ->with('error', 'Pengajuan seminar ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'tindakan_dospem' => 'required|in:setuju,tolak',
            'catatan_dospem' => 'nullable|string|max:1000|required_if:tindakan_dospem,tolak',
        ]);

        if ($request->tindakan_dospem === 'setuju') {
            $seminar->status_pengajuan = 'disetujui_dospem';
            $seminar->dospem_approved_at = now();
            $seminar->catatan_dospem = $request->catatan_dospem; // Catatan opsional jika setuju
        } elseif ($request->tindakan_dospem === 'tolak') {
            $seminar->status_pengajuan = 'ditolak_dospem';
            $seminar->catatan_dospem = $request->catatan_dospem; // Catatan wajib jika ditolak
            $seminar->dospem_approved_at = null; // Reset jika sebelumnya pernah disetujui lalu diubah
        }
        $seminar->save();

        return redirect()->route('dosen-pembimbing.seminar-approval.index')
            ->with('success', 'Pengajuan seminar mahasiswa telah berhasil diproses.');
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
    public function show(Seminar $seminar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seminar $seminar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seminar $seminar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seminar $seminar)
    {
        //
    }
}
