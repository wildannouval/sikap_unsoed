<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\PengajuanKp;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeminarKpController extends Controller
{
    const MIN_KONSULTASI_VERIFIED = 6;

    /**
     * Menampilkan daftar seminar yang diajukan oleh mahasiswa.
     */
    public function index()
    {
        $mahasiswaId = Auth::user()->mahasiswa->id;
        $seminars = Seminar::where('mahasiswa_id', $mahasiswaId)
            ->with([
                'pengajuanKp.dosenPembimbing.user',
                'pengajuanKp.distribusi'
                ])
            ->latest('tanggal_pengajuan_seminar')
            ->paginate(10);
        return view('mahasiswa.seminar_kp.index', compact('seminars'));
    }

    /**
     * Menampilkan form untuk mengajukan seminar KP.
     */
    public function create(PengajuanKp $pengajuanKp)
    {
        $mahasiswaId = Auth::user()->mahasiswa->id;
        if ($pengajuanKp->mahasiswa_id !== $mahasiswaId) {
            abort(403, 'Akses ditolak.');
        }

        if ($pengajuanKp->status_komisi !== 'diterima' || $pengajuanKp->status_kp !== 'dalam_proses') {
            return redirect()->route('mahasiswa.pengajuan-kp.index')
                ->with('error', 'Seminar hanya untuk KP yang sudah disetujui dan berjalan.');
        }

        $jumlahKonsultasiVerified = $pengajuanKp->jumlah_konsultasi_verified; // Menggunakan accessor

        if ($jumlahKonsultasiVerified < self::MIN_KONSULTASI_VERIFIED) {
            return redirect()->route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKp->id)
                ->with('error', 'Belum memenuhi syarat ' . self::MIN_KONSULTASI_VERIFIED . ' konsultasi terverifikasi. Jumlah: ' . $jumlahKonsultasiVerified);
        }

        if ($pengajuanKp->has_active_seminar) { // Menggunakan accessor
            return redirect()->route('mahasiswa.seminar.index')
                ->with('info', 'Anda sudah mengajukan seminar untuk KP ini dan sedang diproses atau sudah dijadwalkan.');
        }

        return view('mahasiswa.seminar_kp.create', compact('pengajuanKp', 'jumlahKonsultasiVerified'));
    }

    /**
     * Menyimpan pengajuan seminar KP baru.
     */
    public function store(Request $request, PengajuanKp $pengajuanKp)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        if ($pengajuanKp->mahasiswa_id !== $mahasiswa->id) { abort(403); }

        if ($pengajuanKp->status_komisi !== 'diterima' || $pengajuanKp->status_kp !== 'dalam_proses') {
            return redirect()->route('mahasiswa.pengajuan-kp.index')->with('error', 'KP belum disetujui/berjalan.');
        }
        if ($pengajuanKp->jumlah_konsultasi_verified < self::MIN_KONSULTASI_VERIFIED) {
            return redirect()->route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKp->id)->with('error', 'Belum memenuhi syarat konsultasi.');
        }
        if ($pengajuanKp->has_active_seminar) {
            return redirect()->route('mahasiswa.seminar.index')->with('error', 'Pengajuan seminar sudah ada.');
        }

        $request->validate([
            'judul_kp_final' => 'required|string|max:255',
            'draft_laporan_path' => 'required|file|mimes:pdf|max:5120',
            'catatan_mahasiswa' => 'nullable|string|max:1000',
            'usulan_tanggal_seminar' => 'required|date|after_or_equal:today',
            'usulan_jam_mulai' => 'required|date_format:H:i',
            'usulan_jam_selesai' => 'required|date_format:H:i|after:usulan_jam_mulai',
            'usulan_ruangan' => 'required|string|max:100',
        ]);

        $pathDraftLaporan = null;
        if ($request->hasFile('draft_laporan_path')) {
            $file = $request->file('draft_laporan_path');
            $originalExtension = $file->getClientOriginalExtension();
            $fileName = "DRAFT_SEMINAR_" . $mahasiswa->nim . "_" . time() . "." . $originalExtension;
            $pathDraftLaporan = $file->storeAs('draft_laporan_seminar', $fileName, 'public');
        }

        Seminar::create([
            'pengajuan_kp_id' => $pengajuanKp->id,
            'mahasiswa_id' => $mahasiswa->id,
            'judul_kp_final' => $request->judul_kp_final,
            'draft_laporan_path' => $pathDraftLaporan,
            'tanggal_pengajuan_seminar' => now(),
            'catatan_mahasiswa' => $request->catatan_mahasiswa,
            'tanggal_seminar' => $request->usulan_tanggal_seminar,
            'jam_mulai' => $request->usulan_jam_mulai,
            'jam_selesai' => $request->usulan_jam_selesai,
            'ruangan' => $request->usulan_ruangan,
            'status_pengajuan' => 'diajukan_mahasiswa',
        ]);

        return redirect()->route('mahasiswa.seminar.index')
            ->with('success', 'Pengajuan seminar KP berhasil dikirim dengan usulan jadwal Anda.');
    }
}
