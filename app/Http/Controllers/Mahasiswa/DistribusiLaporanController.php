<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Distribusi;
use App\Models\PengajuanKp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistribusiLaporanController extends Controller
{
    /**
     * Menampilkan daftar Pengajuan KP yang siap untuk diupload bukti distribusinya
     * atau yang sudah diupload.
     */
    public function index()
    {
        $mahasiswaId = Auth::user()->mahasiswa->id;

        // Ambil semua pengajuan KP yang seminarnya sudah selesai dinilai
        $pengajuanKps = PengajuanKp::where('mahasiswa_id', $mahasiswaId)
            ->whereHas('seminars', function ($query) {
                $query->where('status_pengajuan', 'selesai_dinilai');
            })
            ->with(['seminars' => function($query){ // Untuk ambil status seminar terbaru
                $query->orderBy('created_at', 'desc');
            }, 'distribusi']) // Eager load relasi distribusi
            ->latest('updated_at')
            ->paginate(10);

        return view('mahasiswa.distribusi_laporan.index', compact('pengajuanKps'));
    }
    /**
     * Menampilkan form untuk mengupload bukti distribusi laporan.
     */
    /**
     * Menampilkan form untuk mengupload bukti distribusi laporan.
     * (Method ini sudah ada dan seharusnya masih oke)
     */
    public function create(PengajuanKp $pengajuanKp)
    {
        $mahasiswaId = Auth::user()->mahasiswa->id;
        if ($pengajuanKp->mahasiswa_id !== $mahasiswaId) {
            abort(403, 'Akses ditolak.');
        }

        $seminarSelesaiDinilai = $pengajuanKp->seminars()
            ->where('status_pengajuan', 'selesai_dinilai')
            ->exists();
        if (!$seminarSelesaiDinilai) {
            return redirect()->route('mahasiswa.pengajuan-kp.index')
                ->with('error', 'Anda hanya bisa mengupload bukti distribusi setelah seminar selesai dinilai.');
        }

        if ($pengajuanKp->distribusi()->exists()) {
            return redirect()->route('mahasiswa.distribusi-laporan.index') // Arahkan ke index distribusi
            ->with('info', 'Anda sudah pernah mengupload bukti distribusi untuk KP ini.');
        }

        $pengajuanKp->load('seminars');
        return view('mahasiswa.distribusi_laporan.create', compact('pengajuanKp'));
    }

    /**
     * Menyimpan data bukti distribusi laporan.
     * (Method ini sudah ada dan seharusnya masih oke, hanya redirectnya disesuaikan)
     */
    public function store(Request $request, PengajuanKp $pengajuanKp)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        if ($pengajuanKp->mahasiswa_id !== $mahasiswa->id) {
            abort(403, 'Akses ditolak.');
        }
        // ... (Validasi dan logika prasyarat lainnya tetap sama) ...
        $seminarSelesaiDinilai = $pengajuanKp->seminars()->where('status_pengajuan', 'selesai_dinilai')->exists();
        if (!$seminarSelesaiDinilai) {
            return redirect()->route('mahasiswa.pengajuan-kp.index')->with('error', 'Gagal menyimpan. Seminar belum selesai dinilai.');
        }
        if ($pengajuanKp->distribusi()->exists()) {
            return redirect()->route('mahasiswa.distribusi-laporan.index')->with('error', 'Gagal menyimpan. Bukti distribusi sudah pernah diupload.');
        }


        $request->validate([
            'berkas_distribusi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal_distribusi' => 'required|date|before_or_equal:today',
            'catatan_mahasiswa' => 'nullable|string|max:1000',
        ]);

        $pathBerkasDistribusi = null;
        if ($request->hasFile('berkas_distribusi')) {
            $file = $request->file('berkas_distribusi');
            $originalExtension = $file->getClientOriginalExtension();
            $fileName = "BUKTI_DISTRIBUSI_" . $mahasiswa->nim . "_" . time() . "." . $originalExtension;
            $pathBerkasDistribusi = $file->storeAs('bukti_distribusi_laporan', $fileName, 'public');
        }

        Distribusi::create([
            'pengajuan_kp_id' => $pengajuanKp->id,
            'mahasiswa_id' => $mahasiswa->id,
            'berkas_distribusi' => $pathBerkasDistribusi,
            'tanggal_distribusi' => $request->tanggal_distribusi,
            'catatan_mahasiswa' => $request->catatan_mahasiswa,
        ]);

        // Opsional: Update status_kp di tabel pengajuan_kps
        // $pengajuanKp->status_kp = 'laporan_terdistribusi';
        // $pengajuanKp->save();

        return redirect()->route('mahasiswa.distribusi-laporan.index') // Redirect ke halaman index distribusi
        ->with('success_modal_message', 'Bukti distribusi laporan berhasil diupload.');
    }
}
