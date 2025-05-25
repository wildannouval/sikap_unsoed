<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{

    // Menampilkan daftar semua jurusan
    public function index()
    {
        $jurusans = Jurusan::latest()->paginate(10);
        return view('bapendik.jurusan.index', compact('jurusans'));
    }

    // Menampilkan form untuk membuat jurusan baru
    public function create()
    {
        return view('bapendik.jurusan.create');
    }

    // Menyimpan jurusan baru ke database
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'kode' => 'required|string|unique:jurusans,kode|max:10',
            'nama' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'jenjang' => 'required|string|max:10',
        ]);

        //Simpan data
        Jurusan::create($request->all());

        //Redirect ke halaman index dengan pesan sukses
        return redirect()->route('bapendik.jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // Menampilkan form untuk mengedit jurusan
    public function edit(Jurusan $jurusan)
    {
        return view('bapendik.jurusan.edit', compact('jurusan'));
    }

    // Memperbarui data jurusan di database
    public function update(Request $request, Jurusan $jurusan)
    {
        // Validasi input
        $request->validate([
            'kode' => 'required|string|unique:jurusans,kode,'.$jurusan->id,
            'nama' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'jenjang' => 'required|string|max:10',
        ]);

        // update data
        $jurusan->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('bapendik.jurusan.index')
            ->with('success', 'Jurusan berhasil diperbarui!');
    }

    //Menghapus data jurusan dari database
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('bapendik.jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus!');
    }
}
