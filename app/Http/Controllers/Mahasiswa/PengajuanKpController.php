<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PengajuanKp;
use App\Models\SuratPengantar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Dosen;
use App\Notifications\PengajuanKpBaru;
use Illuminate\Support\Facades\Notification;

class PengajuanKpController extends Controller
{
    /**
     * Menampilkan daftar pengajuan KP milik mahasiswa yang login.
     */
    public function index()
    {
        $mahasiswaId = Auth::user()->mahasiswa->id;
        $pengajuanKps = PengajuanKp::where('mahasiswa_id', $mahasiswaId)
            ->with([
                'suratPengantar',
                'dosenPembimbing.user',
                'seminars' => function($query){ // Ambil seminar terkait
                    $query->orderBy('created_at', 'desc'); // Ambil yang terbaru jika ada banyak
                },
                'distribusi' // Eager load relasi distribusi
            ])
            ->latest()
            ->paginate(10);

        return view('mahasiswa.pengajuan_kp.index', compact('pengajuanKps'));
    }

    /**
     * Menampilkan form untuk membuat pengajuan KP baru.
     */
    public function create()
    {
        $mahasiswaId = Auth::user()->mahasiswa->id;

        // Ambil surat pengantar yang sudah disetujui dan belum pernah dipakai untuk pengajuan KP
        $suratPengantars = SuratPengantar::where('mahasiswa_id', $mahasiswaId)
            ->where('status_bapendik', 'disetujui')
            ->whereDoesntHave('pengajuanKp') // Cek apakah surat pengantar ini sudah punya relasi pengajuanKp
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        return view('mahasiswa.pengajuan_kp.create', compact('suratPengantars'));
    }

    /**
     * Menyimpan pengajuan KP baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'surat_pengantar_id' => 'required|exists:surat_pengantars,id,mahasiswa_id,'.Auth::user()->mahasiswa->id,
            'judul_kp' => 'required|string|max:255',
            'instansi_lokasi' => 'required|string|max:255',
            'proposal_kp' => 'required|file|mimes:pdf|max:2048', // Max 2MB
            'surat_keterangan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        $mahasiswa = Auth::user()->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Profil mahasiswa tidak ditemukan.')->withInput();
        }

        // Cek apakah surat pengantar yang dipilih sudah pernah dipakai
        $suratPengantarSudahDipakai = PengajuanKp::where('surat_pengantar_id', $request->surat_pengantar_id)->exists();
        if ($suratPengantarSudahDipakai) {
            return redirect()->back()->with('error', 'Surat pengantar ini sudah pernah digunakan untuk pengajuan KP.')->withInput();
        }

        $pathProposal = null;
        $pathSuratKeterangan = null;
        $timestamp = time(); // Dapatkan timestamp saat ini untuk keunikan nama file

        // Handle file upload untuk Proposal KP
        if ($request->hasFile('proposal_kp')) {
            $fileProposal = $request->file('proposal_kp');
            $originalExtensionProposal = $fileProposal->getClientOriginalExtension();
            // Contoh nama file: PROPOSAL_KP_NIMMAHASISWA_TIMESTAMP.pdf
            $namaFileProposal = "PROPOSAL_KP_" . $mahasiswa->nim . "_" . $timestamp . "." . $originalExtensionProposal;
            // Simpan ke folder 'proposal_kp' di disk 'public'
            $pathProposal = $fileProposal->storeAs('proposal_kp', $namaFileProposal, 'public');
        }

        // Handle file upload untuk Surat Keterangan
        if ($request->hasFile('surat_keterangan')) {
            $fileSuratKeterangan = $request->file('surat_keterangan');
            $originalExtensionSuratKeterangan = $fileSuratKeterangan->getClientOriginalExtension();
            // Contoh nama file: SURKET_INSTANSI_NIMMAHASISWA_TIMESTAMP.pdf
            $namaFileSuratKeterangan = "SURKET_INSTANSI_" . $mahasiswa->nim . "_" . $timestamp . "." . $originalExtensionSuratKeterangan;
            // Simpan ke folder 'surat_keterangan_instansi' di disk 'public'
            $pathSuratKeterangan = $fileSuratKeterangan->storeAs('surat_keterangan_instansi', $namaFileSuratKeterangan, 'public');
        }
        $user = Auth::user();
        $pengajuanKp= PengajuanKp::create([
            'mahasiswa_id' => $user->mahasiswa->id,
            'surat_pengantar_id' => $request->surat_pengantar_id,
            'judul_kp' => $request->judul_kp,
            'instansi_lokasi' => $request->instansi_lokasi,
            'proposal_kp' => $pathProposal,
            'surat_keterangan' => $pathSuratKeterangan,
            'tanggal_pengajuan' => now(),
            'status_komisi' => 'direview', // Status awal saat pengajuan
            'status_kp' => 'pengajuan',    // Status KP awal
        ]);

        // --- AWAL BAGIAN BARU: MENGIRIM NOTIFIKASI ---

        // 1. Ambil semua user Dosen yang merupakan anggota Komisi
        $dosenKomisi = User::where('role', 'dosen')
            ->whereHas('dosen', function ($query) {
                $query->where('is_komisi', true);
            })->get();

        // 2. Kirim notifikasi ke semua Dosen Komisi jika ada
        if ($dosenKomisi->isNotEmpty()) {
            Notification::send($dosenKomisi, new PengajuanKpBaru($pengajuanKp));
        }
        // --- AKHIR BAGIAN BARU ---

        return redirect()->route('mahasiswa.pengajuan-kp.index')
            ->with('success_modal_message', 'Pengajuan KP berhasil dikirim.');
    }
}
