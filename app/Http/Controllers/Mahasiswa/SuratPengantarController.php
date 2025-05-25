<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\SuratPengantar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratPengantarController extends Controller
{
    /**
     * Menampilkan daftar surat pengantar milik mahasiswa yang login.
     */
    public function index()
    {
        $mahasiswaId = Auth::user()->mahasiswa->id; // Pastikan relasi 'mahasiswa' ada di model User
        $suratPengantars = SuratPengantar::where('mahasiswa_id', $mahasiswaId)
            ->latest()
            ->paginate(10);
        return view('mahasiswa.surat_pengantar.index', compact('suratPengantars'));
    }

    /**
     * Menampilkan form untuk membuat pengajuan surat pengantar baru.
     */
    public function create()
    {
        return view('mahasiswa.surat_pengantar.create');
    }

    /**
     * Menyimpan pengajuan surat pengantar baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lokasi_penelitian' => 'required|string|max:255',
            'penerima_surat' => 'required|string|max:255',
            'alamat_surat' => 'required|string',
            'tembusan_surat' => 'nullable|string',
            'tahun_akademik' => 'required|string|max:9', // contoh: 2024/2025
        ]);

        $mahasiswa = Auth::user()->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        SuratPengantar::create([
            'mahasiswa_id' => $mahasiswa->id,
            'lokasi_penelitian' => $request->lokasi_penelitian,
            'penerima_surat' => $request->penerima_surat,
            'alamat_surat' => $request->alamat_surat,
            'tembusan_surat' => $request->tembusan_surat,
            'tahun_akademik' => $request->tahun_akademik,
            'tanggal_pengajuan' => now(),
            'status_bapendik' => 'menunggu', // Status awal
        ]);

        return redirect()->route('mahasiswa.surat-pengantar.index')
            ->with('success', 'Pengajuan surat pengantar berhasil dikirim.');
    }
}
