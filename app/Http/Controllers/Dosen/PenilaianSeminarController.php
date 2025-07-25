<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PengajuanKp;
use App\Models\Seminar;
use App\Notifications\SeminarSelesaiDinilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PenilaianSeminarController extends Controller
{
    /**
     * enampilkan daftar seminar yang perlu dinilai atau sudah dinilai.
     */
    public function index(Request $request)
    {
        $dosenId = Auth::user()->dosen->id;

        $query = Seminar::whereHas('pengajuanKp', function ($q) use ($dosenId) {
            $q->where('dosen_pembimbing_id', $dosenId);
        })
            ->whereIn('status_pengajuan', ['dijadwalkan_bapendik', 'selesai_dinilai'])
            ->with(['mahasiswa.user', 'mahasiswa.jurusan', 'pengajuanKp'])
            ->latest('tanggal_seminar');

        // Opsional: Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul_kp_final', 'like', "%{$searchTerm}%")
                    ->orWhereHas('mahasiswa.user', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        $seminars = $query->paginate(10)->appends($request->query());

        return view('dosen-pembimbing.penilaian_seminar.index', compact('seminars', 'request'));
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

    public function editHasil(Seminar $seminar)
    {
        $dosenId = Auth::user()->dosen->id;
        // Autorisasi
        if ($seminar->pengajuanKp->dosen_pembimbing_id !== $dosenId) {
            abort(403, 'Akses ditolak. Anda bukan pembimbing untuk KP terkait seminar ini.');
        }

        // --- PERBAIKAN DI SINI JUGA ---
        // Hanya bisa diisi jika statusnya sudah dijadwalkan Bapendik atau sudah pernah dinilai
        if (!in_array($seminar->status_pengajuan, ['dijadwalkan_bapendik', 'selesai_dinilai'])) {
            return redirect()->route('dosen.pembimbing.penilaian-seminar.index')
                ->with('error', 'Hasil seminar hanya bisa diinput/diedit untuk seminar yang sudah dijadwalkan atau selesai dinilai.');
        }

        $seminar->load(['mahasiswa.user', 'pengajuanKp']);
        return view('dosen-pembimbing.penilaian_seminar.edit', compact('seminar'));
    }

    /**
     * Memproses penyimpanan hasil seminar.
     */
    public function updateHasil(Request $request, Seminar $seminar)
    {
        $dosenId = Auth::user()->dosen->id;
        if ($seminar->pengajuanKp->dosen_pembimbing_id !== $dosenId) {
            abort(403, 'Akses ditolak.');
        }
        // --- PERBAIKAN DI SINI JUGA ---
        if (!in_array($seminar->status_pengajuan, ['dijadwalkan_bapendik', 'selesai_dinilai'])) {
            return redirect()->route('dosen.pembimbing.penilaian-seminar.index')
                ->with('error', 'Gagal menyimpan, status seminar tidak valid untuk penilaian.');
        }

        $request->validate([
            'nilai_seminar_angka' => 'required|numeric|min:0|max:100',
//            'catatan_hasil_seminar' => 'nullable|string|max:2000',
            'berita_acara_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request, $seminar) {
            $seminar->nilai_seminar_angka = $request->nilai_seminar_angka;
//            $seminar->catatan_hasil_seminar = $request->catatan_hasil_seminar;

            if ($request->hasFile('berita_acara_file')) {
                // Hapus file lama jika ada dan mau diganti
                if ($seminar->berita_acara_path && Storage::disk('public')->exists($seminar->berita_acara_path)) {
                    Storage::disk('public')->delete($seminar->berita_acara_path);
                }
                $file = $request->file('berita_acara_file');
                $nim = $seminar->mahasiswa->nim;
                $originalExtension = $file->getClientOriginalExtension();
                $fileName = "BERITA_ACARA_SEMINAR_" . $nim . "_" . time() . "." . $originalExtension;
                $seminar->berita_acara_path = $file->storeAs('berita_acara_seminar', $fileName, 'public');
            }

            $seminar->status_pengajuan = 'selesai_dinilai';
            $seminar->save();

            // --- LOGIKA UPDATE PENGAJUAN KP ---
            $pengajuanKp = $seminar->pengajuanKp;
            if ($pengajuanKp) {
                $nilaiAngka = $seminar->nilai_seminar_angka;
                $pengajuanKp->nilai_akhir_angka = $nilaiAngka;
                $pengajuanKp->nilai_akhir_huruf = PengajuanKp::konversiNilaiKeHuruf($nilaiAngka); // Asumsi method ini ada di model PengajuanKp

                // Tentukan status kelulusan KP
                if ($nilaiAngka >= 60) { // Asumsi batas lulus 60
                    $pengajuanKp->status_kp = 'lulus';
                } else {
                    $pengajuanKp->status_kp = 'tidak_lulus';
                }
                $pengajuanKp->save();
            }

            // --- KIRIM NOTIFIKASI KE MAHASISWA ---
            $mahasiswaUser = $seminar->mahasiswa->user;
            $mahasiswaUser->notify(new SeminarSelesaiDinilai($seminar));
            // --- AKHIR BLOK NOTIFIKASI ---
        });

        return redirect()->route('dosen.pembimbing.penilaian-seminar.index')
            ->with('success_modal_message', 'Hasil seminar untuk mahasiswa ' . $seminar->mahasiswa->user->name . ' berhasil disimpan dan status KP diperbarui.');
    }
}
