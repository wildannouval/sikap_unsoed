<?php

namespace App\Http\Controllers\DosenPembimbing;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\PengajuanKp;
use App\Notifications\KonsultasiDiverifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiKpController extends Controller
{
    /**
     * Menampilkan riwayat konsultasi dan form verifikasi untuk Pengajuan KP tertentu.
     */
    public function showKonsultasi(PengajuanKp $pengajuanKp)
    {
        $dosenId = Auth::user()->dosen->id;

        // Autorisasi: Pastikan dosen yang login adalah pembimbing KP ini
        if ($pengajuanKp->dosen_pembimbing_id !== $dosenId) {
            abort(403, 'Akses ditolak. Anda bukan pembimbing untuk KP ini.');
        }

        $konsultasis = Konsultasi::where('pengajuan_kp_id', $pengajuanKp->id)
            ->orderBy('tanggal_konsultasi', 'desc')
            ->paginate(10);

        $pengajuanKp->load('mahasiswa.user'); // Load info mahasiswa untuk ditampilkan

        return view('dosen-pembimbing.konsultasi_kp.show', compact('pengajuanKp', 'konsultasis'));
    }

    /**
     * Menyimpan verifikasi dan catatan dosen pada entri konsultasi.
     */
    public function verifikasi(Request $request, Konsultasi $konsultasi)
    {
        $dosenId = Auth::user()->dosen->id;

        // Autorisasi: Pastikan dosen yang login adalah pembimbing dari KP terkait konsultasi ini
        // dan konsultasi ini memang milik mahasiswa yang dibimbingnya
        if ($konsultasi->pengajuanKp->dosen_pembimbing_id !== $dosenId || $konsultasi->dosen_pembimbing_id !== $dosenId) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'catatan_dosen' => 'nullable|string',
            'diverifikasi' => 'sometimes|boolean', // 'sometimes' berarti hanya divalidasi jika ada di request
        ]);

        $konsultasi->catatan_dosen = $request->catatan_dosen;

        // Jika checkbox 'diverifikasi' dicentang dan status sebelumnya belum diverifikasi
        if ($request->has('diverifikasi') && $request->input('diverifikasi') == '1' && !$konsultasi->diverifikasi) {
            $konsultasi->diverifikasi = true;
            $konsultasi->tanggal_verifikasi = now();
        } elseif (!$request->has('diverifikasi')) { // Jika checkbox tidak dicentang (misal, ingin membatalkan verifikasi)
            $konsultasi->diverifikasi = false;
            $konsultasi->tanggal_verifikasi = null;
        }
        // Jika sudah diverifikasi dan checkbox tidak dicentang, status verifikasi tidak berubah kecuali ada logika khusus
        // Jika sudah diverifikasi dan checkbox dicentang, tanggal_verifikasi tidak diupdate lagi

        $konsultasi->save();
        // --- KIRIM NOTIFIKASI KE MAHASISWA ---
        $mahasiswaUser = $konsultasi->mahasiswa->user;
        $mahasiswaUser->notify(new KonsultasiDiverifikasi($konsultasi));
        // --- AKHIR BLOK NOTIFIKASI ---

        return redirect()->route('dosen-pembimbing.bimbingan-kp.konsultasi.show', $konsultasi->pengajuan_kp_id)
            ->with('success', 'Catatan konsultasi berhasil diperbarui/diverifikasi.');
    }
}
