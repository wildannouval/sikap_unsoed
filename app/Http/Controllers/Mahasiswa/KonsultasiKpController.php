<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\PengajuanKp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiKpController extends Controller
{
    /**
     * Menampilkan daftar konsultasi untuk Pengajuan KP tertentu.
     */
    public function index(PengajuanKp $pengajuanKp)
    {
        // Autorisasi: Pastikan mahasiswa yang login adalah pemilik pengajuan KP ini
        if ($pengajuanKp->mahasiswa_id !== Auth::user()->mahasiswa->id) {
            abort(403, 'Akses ditolak.');
        }

        $konsultasis = Konsultasi::where('pengajuan_kp_id', $pengajuanKp->id)
            ->orderBy('tanggal_konsultasi', 'desc')
            ->paginate(10);

        return view('mahasiswa.pengajuan_kp.konsultasi.index', compact('pengajuanKp', 'konsultasis'));
    }

    /**
     * Menampilkan form untuk membuat entri konsultasi baru.
     */
    public function create(PengajuanKp $pengajuanKp)
    {
        // Autorisasi
        if ($pengajuanKp->mahasiswa_id !== Auth::user()->mahasiswa->id) {
            abort(403, 'Akses ditolak.');
        }

        // Cek apakah KP sudah disetujui dan sedang berjalan
        if ($pengajuanKp->status_komisi !== 'diterima' || $pengajuanKp->status_kp !== 'dalam_proses') {
            return redirect()->route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKp)
                ->with('error', 'Konsultasi hanya bisa ditambahkan untuk KP yang sudah disetujui dan sedang berjalan.');
        }

        return view('mahasiswa.pengajuan_kp.konsultasi.create', compact('pengajuanKp'));
    }

    /**
     * Menyimpan entri konsultasi baru.
     */
    public function store(Request $request, PengajuanKp $pengajuanKp)
    {
        // Autorisasi
        if ($pengajuanKp->mahasiswa_id !== Auth::user()->mahasiswa->id) {
            abort(403, 'Akses ditolak.');
        }

        // Cek apakah KP sudah disetujui dan sedang berjalan
        if ($pengajuanKp->status_komisi !== 'diterima' || $pengajuanKp->status_kp !== 'dalam_proses' || !$pengajuanKp->dosen_pembimbing_id) {
            return redirect()->route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKp)
                ->with('error', 'Konsultasi tidak bisa ditambahkan. Pastikan KP sudah disetujui, sedang berjalan, dan memiliki dosen pembimbing.');
        }

        $request->validate([
            'tanggal_konsultasi' => 'required|date|before_or_equal:today',
            'topik_konsultasi' => 'required|string|max:255',
            'hasil_konsultasi' => 'required|string',
        ]);

        Konsultasi::create([
            'pengajuan_kp_id' => $pengajuanKp->id,
            'mahasiswa_id' => Auth::user()->mahasiswa->id,
            'dosen_pembimbing_id' => $pengajuanKp->dosen_pembimbing_id, // Ambil dari pengajuan KP
            'tanggal_konsultasi' => $request->tanggal_konsultasi,
            'topik_konsultasi' => $request->topik_konsultasi,
            'hasil_konsultasi' => $request->hasil_konsultasi,
            'diverifikasi' => false, // Default saat mahasiswa input
        ]);

        return redirect()->route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKp)
            ->with('success_modal_message', 'Catatan konsultasi berhasil ditambahkan.');
    }
}
