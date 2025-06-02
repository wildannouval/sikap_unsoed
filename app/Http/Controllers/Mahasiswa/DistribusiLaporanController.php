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
     * Menampilkan form untuk mengupload bukti distribusi laporan.
     */
    public function create(PengajuanKp $pengajuanKp)
    {
        $mahasiswaId = Auth::user()->mahasiswa->id;

        // Autorisasi: Pastikan mahasiswa yang login adalah pemilik pengajuan KP ini
        if ($pengajuanKp->mahasiswa_id !== $mahasiswaId) {
            abort(403, 'Akses ditolak. Pengajuan KP ini bukan milik Anda.');
        }

        // Prasyarat: Seminar harus sudah selesai dinilai
        $seminarSelesaiDinilai = $pengajuanKp->seminars()
            ->where('status_pengajuan', 'selesai_dinilai')
            ->exists();

        if (!$seminarSelesaiDinilai) {
            return redirect()->route('mahasiswa.pengajuan-kp.index') // Atau ke halaman detail KP/seminar
            ->with('error', 'Anda hanya bisa mengupload bukti distribusi setelah seminar selesai dinilai.');
        }

        // Prasyarat: Cek apakah sudah pernah upload bukti distribusi
        if ($pengajuanKp->distribusi()->exists()) {
            // Jika sudah ada, mungkin arahkan ke halaman untuk melihat/edit atau tampilkan pesan
            // Untuk sekarang, kita tampilkan pesan dan arahkan ke daftar KP
            return redirect()->route('mahasiswa.pengajuan-kp.index')
                ->with('info', 'Anda sudah pernah mengupload bukti distribusi untuk KP ini.');
        }

        $pengajuanKp->load('seminars'); // Load data seminar untuk ditampilkan jika perlu

        return view('mahasiswa.distribusi.create', compact('pengajuanKp'));
    }

    /**
     * Menyimpan data bukti distribusi laporan.
     */
    public function store(Request $request, PengajuanKp $pengajuanKp)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // Autorisasi dan Prasyarat (ulangi untuk keamanan)
        if ($pengajuanKp->mahasiswa_id !== $mahasiswa->id) {
            abort(403, 'Akses ditolak.');
        }

        $seminarSelesaiDinilai = $pengajuanKp->seminars()
            ->where('status_pengajuan', 'selesai_dinilai')
            ->exists();
        if (!$seminarSelesaiDinilai) {
            return redirect()->route('mahasiswa.pengajuan-kp.index')
                ->with('error', 'Gagal menyimpan. Seminar belum selesai dinilai.');
        }

        if ($pengajuanKp->distribusi()->exists()) {
            return redirect()->route('mahasiswa.pengajuan-kp.index')
                ->with('error', 'Gagal menyimpan. Bukti distribusi sudah pernah diupload.');
        }

        $request->validate([
            'berkas_distribusi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
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
        // $pengajuanKp->status_kp = 'laporan_terdistribusi'; // Definisikan status ini jika perlu
        // $pengajuanKp->save();

        return redirect()->route('mahasiswa.pengajuan-kp.index') // Atau ke halaman detail KP/seminar
        ->with('success', 'Bukti distribusi laporan berhasil diupload.');
    }
}
