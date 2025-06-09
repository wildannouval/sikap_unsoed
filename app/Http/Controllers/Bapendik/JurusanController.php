<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JurusanController extends Controller
{

    // Menampilkan daftar semua jurusan
    public function index(Request $request)
    {
        $query = Jurusan::orderBy('fakultas')->orderBy('nama'); // Urutkan berdasarkan fakultas lalu nama

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('kode', 'like', "%{$searchTerm}%")
                    ->orWhere('nama', 'like', "%{$searchTerm}%")
                    ->orWhere('fakultas', 'like', "%{$searchTerm}%")
                    ->orWhere('jenjang', 'like', "%{$searchTerm}%");
            });
        }

        $jurusans = $query->paginate(10)->appends($request->query()); // appends query untuk pagination

        return view('bapendik.jurusan.index', compact('jurusans', 'request')); // kirim 'request' ke view
    }

    // Menampilkan form untuk membuat jurusan baru
    public function create()
    {
        return view('bapendik.jurusan.create');
    }

    // Menyimpan jurusan baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:jurusans,kode',
            'nama' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'jenjang' => 'required|string|max:10',
        ]);

        Jurusan::create($request->all());

        return redirect()->route('bapendik.jurusan.index')
            ->with('success_modal_message', 'Jurusan berhasil ditambahkan.'); // Menggunakan key untuk modal
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
        $request->validate([
            'kode' => ['required','string','max:10', Rule::unique('jurusans')->ignore($jurusan->id)],
            'nama' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'jenjang' => 'required|string|max:10',
        ]);

        $jurusan->update($request->all());

        return redirect()->route('bapendik.jurusan.index')
            ->with('success_modal_message', 'Data jurusan berhasil diperbarui.'); // Menggunakan key untuk modal
    }

    //Menghapus data jurusan dari database
    public function destroy(Jurusan $jurusan)
    {
        try {
            // Tambahkan pengecekan apakah jurusan ini dipakai oleh mahasiswa atau dosen
            if ($jurusan->mahasiswas()->exists() || $jurusan->dosens()->exists()) {
                return redirect()->route('bapendik.jurusan.index')
                    ->with('error', 'Jurusan "'.$jurusan->nama.'" tidak bisa dihapus karena masih digunakan oleh data mahasiswa atau dosen.');
            }
            $jurusan->delete();
            return redirect()->route('bapendik.jurusan.index')
                ->with('success_modal_message', 'Jurusan berhasil dihapus.'); // Menggunakan key untuk modal
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('bapendik.jurusan.index')
                ->with('error', 'Jurusan tidak bisa dihapus karena masih terikat dengan data lain. Error Code: '.$e->getCode());
        }
    }
}
