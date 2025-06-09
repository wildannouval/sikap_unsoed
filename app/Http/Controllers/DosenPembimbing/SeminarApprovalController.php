<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SeminarApprovalController extends Controller
{
    /**
     * Menampilkan daftar pengajuan seminar yang perlu diproses atau sudah diproses.
     */
    public function index(Request $request)
    {
        $dosenId = Auth::user()->dosen->id;

        $query = Seminar::whereHas('pengajuanKp', function ($q) use ($dosenId) {
            $q->where('dosen_pembimbing_id', $dosenId);
        })->with(['mahasiswa.user', 'pengajuanKp']);


        // Cek apakah parameter filter ada di URL. Helper request() lebih fleksibel di sini.
        // Cek apakah parameter filter ada di URL, bahkan jika nilainya kosong.
        if ($request->has('status_pengajuan_filter')) {
            // Hanya terapkan filter 'where' jika nilainya TIDAK KOSONG.
            // Jika nilainya kosong (saat user memilih "Semua Status"), jangan tambahkan klausa 'where' status.
            if ($request->filled('status_pengajuan_filter')) {
                $query->where('status_pengajuan', $request->status_pengajuan_filter);
            }
        } else {
            // Perilaku default saat halaman pertama kali dibuka (tidak ada parameter filter).
            // Tampilkan yang paling butuh tindakan.
            $query->where('status_pengajuan', 'diajukan_mahasiswa');
        }

        // Filter berdasarkan pencarian
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

        $seminarApplications = $query->latest('tanggal_pengajuan_seminar')->paginate(10)->appends($request->query());

        // Daftar status baru untuk dropdown filter
        $statuses = [
            'diajukan_mahasiswa' => 'Menunggu Persetujuan Dospem',
            'disetujui_dospem' => 'Telah Disetujui Dospem',
            'ditolak_dospem' => 'Telah Ditolak Dospem',
            'dijadwalkan_bapendik' => 'Sudah Dijadwalkan Bapendik',
            'selesai_dinilai' => 'Sudah Selesai Dinilai',
            'dibatalkan' => 'Dibatalkan',
        ];

        return view('dosen-pembimbing.seminar_approval.index', compact('seminarApplications', 'request', 'statuses'));
    }

    /**
     * Menampilkan form untuk Dosen Pembimbing memproses pengajuan seminar.
     */
    public function showForm(Seminar $seminar)
    {
        $dosenId = Auth::user()->dosen->id;
        // Otorisasi
        if ($seminar->pengajuanKp->dosen_pembimbing_id !== $dosenId) {
            abort(403, 'Akses ditolak.');
        }

        $seminar->load(['mahasiswa.user', 'pengajuanKp']);
        return view('dosen-pembimbing.seminar_approval.form', compact('seminar'));
    }

    /**
     * Memproses persetujuan atau penolakan seminar.
     */
    public function processApproval(Request $request, Seminar $seminar)
    {
        $dosenId = Auth::user()->dosen->id;
        if ($seminar->pengajuanKp->dosen_pembimbing_id !== $dosenId) {
            abort(403, 'Akses ditolak.');
        }
        // Hanya bisa memproses jika statusnya 'diajukan_mahasiswa'
        if ($seminar->status_pengajuan !== 'diajukan_mahasiswa') {
            return redirect()->route('dosen-pembimbing.seminar-approval.index')
                ->with('error', 'Pengajuan seminar ini sudah diproses sebelumnya.');
        }

        // Kita akan menggunakan 'tindakan_dospem' sebagai nama input di form
        $request->validate([
            'tindakan_dospem' => ['required', Rule::in(['setuju', 'tolak', 'revisi'])],
            'catatan_dospem' => ['nullable', 'string', 'max:2000', 'required_if:tindakan_dospem,tolak', 'required_if:tindakan_dospem,revisi'],
        ]);

        $statusMap = [
            'setuju' => 'disetujui_dospem',
            'tolak' => 'ditolak_dospem',
            'revisi' => 'revisi_dospem',
        ];

        $seminar->status_pengajuan = $statusMap[$request->tindakan_dospem];
        $seminar->catatan_dospem = $request->catatan_dospem;

        if ($request->tindakan_dospem === 'setuju') {
            $seminar->dospem_approved_at = now();
        } else {
            $seminar->dospem_approved_at = null; // Reset jika ditolak/revisi
        }

        $seminar->save();
        // --- KIRIM NOTIFIKASI KE MAHASISWA ---
        $mahasiswaUser = $seminar->mahasiswa->user;
        $mahasiswaUser->notify(new ResponPengajuanSeminar($seminar));
        // --- AKHIR BLOK NOTIFIKASI ---

        return redirect()->route('dosen-pembimbing.seminar-approval.index')
            ->with('success_modal_message', 'Pengajuan seminar mahasiswa telah berhasil diproses.');
    }
}
