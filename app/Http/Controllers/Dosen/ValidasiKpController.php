<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\PengajuanKp;
use App\Models\User;
use App\Notifications\PengajuanKpDiterimaUntukMahasiswa;
use App\Notifications\PenunjukanSebagaiPembimbing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// TAMBAHKAN USE STATEMENTS

class ValidasiKpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PengajuanKp::with(['mahasiswa.user', 'mahasiswa.jurusan', 'suratPengantar', 'dosenPembimbing.user'])
            ->latest();

        // Filter berdasarkan status_komisi
        if ($request->filled('status_komisi')) {
            $query->where('status_komisi', $request->status_komisi);
        }

        // Filter berdasarkan jurusan mahasiswa
        if ($request->filled('jurusan_id')) {
            $query->whereHas('mahasiswa.jurusan', function ($q) use ($request) {
                $q->where('id', $request->jurusan_id);
            });
        }

        // Search (nama mahasiswa, nim, judul kp, instansi)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul_kp', 'like', "%{$searchTerm}%")
                    ->orWhere('instansi_lokasi', 'like', "%{$searchTerm}%")
                    ->orWhereHas('mahasiswa.user', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('mahasiswa', function ($subQ) use ($searchTerm) {
                        $subQ->where('nim', 'like', "%{$searchTerm}%");
                    });
            });
        }

        $pengajuanKps = $query->paginate(10)->appends($request->query());
        $jurusans = Jurusan::orderBy('nama')->get(); // Untuk dropdown filter

        return view('dosen-komisi.validasi_kp.index', compact('pengajuanKps', 'jurusans', 'request'));
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
    public function show(PengajuanKp $pengajuanKp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanKp $pengajuanKp)
    {
        // Load relasi yang mungkin dibutuhkan di view
        $pengajuanKp->load(['mahasiswa.user', 'mahasiswa.jurusan', 'suratPengantar']);

        // Ambil daftar dosen untuk pilihan Dosen Pembimbing
        // Kita ambil user dengan role 'dosen' dan memiliki entri di tabel 'dosens'
        $calonPembimbings = User::where('role', 'dosen')
            ->whereHas('dosen') // Pastikan user ini adalah dosen yang terdata di tabel dosens
            ->orderBy('name')
            ->get();

        return view('dosen-komisi.validasi_kp.edit', compact('pengajuanKp', 'calonPembimbings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanKp $pengajuanKp)
    {
        $request->validate([
            'status_komisi' => ['required', Rule::in(['direview', 'diterima', 'ditolak'])],
            'alasan_ditolak' => ['nullable', 'string', 'required_if:status_komisi,ditolak'],
            // dosen_pembimbing_id WAJIB diisi JIKA status_komisi adalah 'diterima'
            // dan harus merupakan ID yang ada di tabel 'dosens' (karena relasi ke dosens.id)
            'dosen_pembimbing_id' => [
                'nullable',
                'required_if:status_komisi,diterima',
                Rule::exists('dosens', 'id'),
            ],
            'tanggal_mulai_kp' => ['nullable', 'date'],
            'tanggal_selesai_kp' => ['nullable', 'date', 'after_or_equal:tanggal_mulai_kp'],
        ]);

        $pengajuanKp->status_komisi = $request->status_komisi;
        $pengajuanKp->alasan_ditolak = ($request->status_komisi == 'ditolak') ? $request->alasan_ditolak : null;
        $pengajuanKp->dosen_pembimbing_id = ($request->status_komisi == 'diterima') ? $request->dosen_pembimbing_id : null;

        if ($request->status_komisi == 'diterima') {
            $pengajuanKp->tanggal_diterima_komisi = now(); // Set tanggal diterima komisi
            $pengajuanKp->status_kp = 'dalam_proses'; // Ubah status KP mahasiswa
            $pengajuanKp->tanggal_mulai_kp = $request->tanggal_mulai_kp ? $request->tanggal_mulai_kp : null;
            $pengajuanKp->tanggal_selesai_kp = $request->tanggal_selesai_kp ? $request->tanggal_selesai_kp : null;

            // --- KIRIM NOTIFIKASI ---
            // 1. Notifikasi ke Mahasiswa
            $mahasiswaUser = $pengajuanKp->mahasiswa->user;
            $mahasiswaUser->notify(new PengajuanKpDiterimaUntukMahasiswa($pengajuanKp));

            // 2. Notifikasi ke Dosen Pembimbing yang ditunjuk
            if ($pengajuanKp->dosenPembimbing) {
                $dosenPembimbingUser = $pengajuanKp->dosenPembimbing->user;
                $dosenPembimbingUser->notify(new PenunjukanSebagaiPembimbing($pengajuanKp));
            }
        } else {
            $pengajuanKp->tanggal_diterima_komisi = null; // Hapus tanggal jika ditolak
            $pengajuanKp->dosen_pembimbing_id = null;
            if ($request->status_komisi == 'ditolak') {
                $pengajuanKp->status_kp = 'tidak_lulus';
            }
        }

        $pengajuanKp->save();

        return redirect()->route('dosen.komisi.validasi-kp.index')
            ->with('success_modal_message', 'Status pengajuan KP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanKp $pengajuanKp)
    {
        //
    }
}
