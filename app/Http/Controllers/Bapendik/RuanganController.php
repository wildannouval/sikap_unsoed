<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ruangan::orderBy('nama_ruangan', 'asc');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama_ruangan', 'like', "%{$searchTerm}%")
                    ->orWhere('lokasi_gedung', 'like', "%{$searchTerm}%")
                    ->orWhere('fasilitas', 'like', "%{$searchTerm}%");
            });
        }

        $ruangans = $query->paginate(10)->appends($request->query());
        return view('bapendik.ruangan.index', compact('ruangans', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bapendik.ruangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255|unique:ruangans,nama_ruangan',
            'lokasi_gedung' => 'nullable|string|max:100',
            'kapasitas' => 'nullable|integer|min:1',
            'fasilitas' => 'nullable|string|max:500',
            'is_tersedia' => 'sometimes|boolean',
        ]);

        Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
            'lokasi_gedung' => $request->lokasi_gedung,
            'kapasitas' => $request->kapasitas,
            'fasilitas' => $request->fasilitas,
            'is_tersedia' => $request->has('is_tersedia') ? true : false,
        ]);

        return redirect()->route('bapendik.ruangan.index')
            ->with('success_modal_message', 'Data ruangan seminar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Method show() biasanya tidak terlalu dibutuhkan untuk CRUD sederhana jika semua info ada di index & edit.
     * Jika ingin halaman detail khusus, bisa diimplementasikan.
     */
    // public function show(Ruangan $ruangan)
    // {
    //     // return view('bapendik.ruangan.show', compact('ruangan'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ruangan $ruangan)
    {
        return view('bapendik.ruangan.edit', compact('ruangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'nama_ruangan' => ['required', 'string', 'max:255', Rule::unique('ruangans')->ignore($ruangan->id)],
            'lokasi_gedung' => 'nullable|string|max:100',
            'kapasitas' => 'nullable|integer|min:1',
            'fasilitas' => 'nullable|string|max:500',
            'is_tersedia' => 'sometimes|boolean',
        ]);

        $ruangan->update([
            'nama_ruangan' => $request->nama_ruangan,
            'lokasi_gedung' => $request->lokasi_gedung,
            'kapasitas' => $request->kapasitas,
            'fasilitas' => $request->fasilitas,
            'is_tersedia' => $request->has('is_tersedia') ? true : false,
        ]);

        return redirect()->route('bapendik.ruangan.index')
            ->with('success_modal_message', 'Data ruangan seminar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ruangan $ruangan)
    {
        // PERHATIAN: Tambahkan logika pengecekan di sini
        // apakah ruangan sedang/akan digunakan untuk seminar terjadwal.
        // Jika iya, mungkin jangan biarkan dihapus atau berikan peringatan.
        // Contoh:
        // if ($ruangan->seminars()->where('status_pengajuan', 'dijadwalkan_komisi')->exists()) {
        //     return redirect()->route('bapendik.ruangan.index')
        //                      ->with('error', 'Ruangan tidak bisa dihapus karena sedang terjadwal untuk seminar.');
        // }

        try {
            $ruangan->delete();
            return redirect()->route('bapendik.ruangan.index')
                ->with('success_modal_message', 'Ruangan seminar berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani error jika ada constraint foreign key yang menghalangi penghapusan
            return redirect()->route('bapendik.ruangan.index')
                ->with('error', 'Ruangan tidak bisa dihapus, kemungkinan masih terkait dengan data seminar. Error: ' . $e->getMessage());
        }
    }
}
