<?php

namespace App\Http\Controllers\Bapendik;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class PenggunaController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna (mahasiswa & dosen).
     */
    public function index(Request $request)
    {

        $jurusans = Jurusan::orderBy('nama')->get(); // Untuk filter nanti

        // Data Mahasiswa dengan Search & Filter
        $queryMahasiswa = User::where('role', 'mahasiswa')->with('mahasiswa.jurusan');

        if ($request->filled('search_mahasiswa')) {
            $searchTerm = $request->search_mahasiswa;
            $queryMahasiswa->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%")
                    ->orWhereHas('mahasiswa', function ($subQ) use ($searchTerm) {
                        $subQ->where('nim', 'like', "%{$searchTerm}%");
                    });
            });
        }
        if ($request->filled('jurusan_mahasiswa')) {
            $queryMahasiswa->whereHas('mahasiswa', function ($subQ) use ($request) {
                $subQ->where('jurusan_id', $request->jurusan_mahasiswa);
            });
        }

        $mahasiswas = $queryMahasiswa->latest()->paginate(10, ['*'], 'mahasiswa_page')
            ->appends($request->except('mahasiswa_page'));


        // Data Dosen dengan Search & Filter
        $queryDosen = User::where('role', 'dosen')->with('dosen.jurusan');

        if ($request->filled('search_dosen')) {
            $searchTerm = $request->search_dosen;
            $queryDosen->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%")
                    ->orWhereHas('dosen', function ($subQ) use ($searchTerm) {
                        $subQ->where('nidn', 'like', "%{$searchTerm}%");
                    });
            });
        }
        if ($request->filled('jurusan_dosen')) {
            $queryDosen->whereHas('dosen', function ($subQ) use ($request) {
                $subQ->where('jurusan_id', $request->jurusan_dosen);
            });
        }
        $dosens = $queryDosen->latest()->paginate(10, ['*'], 'dosen_page')
            ->appends($request->except('dosen_page'));

        return view('bapendik.pengguna.index', compact('mahasiswas', 'dosens', 'jurusans', 'request'));

        // Ambil penmgguna dengan role mahasiswa atau dosen, beserta relasi profilnya
//        $users = User::whereIn('role',['mahasiswa','dosen'])
//            ->with(['mahasiswa.jurusan','dosen.jurusan']) // Eager Loading untuk performa
//            ->latest()
//            ->paginate(10);
//
//        return view('bapendik.pengguna.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function create()
    {
        // butuh daftar jurusan untuk dropdown di form
        $jurusans = Jurusan::all();
        return view('bapendik.pengguna.create', compact('jurusans'));
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:mahasiswa,dosen'],
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            // Validasi kondisional
            'nim' => ['required_if:role,mahasiswa', 'nullable', 'string', 'unique:mahasiswas,nim'],
            'tahun_masuk' => ['required_if:role,mahasiswa', 'nullable', 'numeric', 'digits:4'],
            'nidn' => ['required_if:role,dosen', 'nullable', 'string', 'unique:dosens,nidn'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:1000'],
            'bidang_keahlian' => ['nullable', 'string', 'max:255'],
        ]);

        // Gunakan Transaction untuk memastikan kedua query berhasil
        DB::transaction(function () use ($request) {
            // 1. Buat data di tabel users
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // 2. Cek role, lalu buat data di tabel mahasiswas atau dosens
            if ($request->role === 'mahasiswa') {
                Mahasiswa::create([
                    'user_id' => $user->id,
                    'jurusan_id' => $request->jurusan_id,
                    'nim' => $request->nim,
                    'tahun_masuk' => $request->tahun_masuk,
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
                ]);
            } elseif ($request->role === 'dosen') {
                Dosen::create([
                    'user_id' => $user->id,
                    'jurusan_id' => $request->jurusan_id,
                    'nidn' => $request->nidn,
                    'bidang_keahlian' => $request->bidang_keahlian,
                ]);
            }
        });

        return redirect()->route('bapendik.pengguna.index',['active_tab' => $request->role])
            ->with('success_modal_message', 'Pengguna baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit(User $pengguna)
    {
        // Load relasi agar bisa diakses di view
        $pengguna->load(['mahasiswa', 'dosen']);
        $jurusans = Jurusan::all();
        return view('bapendik.pengguna.edit', compact('pengguna', 'jurusans'));
    }

    /**
     * Memperbarui data pengguna di database.
     */
    public function update(Request $request, User $pengguna)
    {
        // Validasi dasar
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($pengguna->id)],
            'jurusan_id' => ['required', 'exists:jurusans,id'],
        ];

        // Validasi kondisional berdasarkan role yang sudah ada (tidak bisa diubah)
        if ($pengguna->role === 'mahasiswa') {
            $rules['nim'] = ['required', 'string', Rule::unique('mahasiswas', 'nim')->ignore($pengguna->mahasiswa?->id)];
            $rules['tahun_masuk'] = ['required', 'numeric', 'digits:4']; // Validasi untuk tahun_masuk
        } elseif ($pengguna->role === 'dosen') {
            $rules['nidn'] = ['required', 'string', Rule::unique('dosens', 'nidn')->ignore($pengguna->dosen?->id)];
            $rules['is_komisi'] = ['nullable','boolean'];
        }

        $request->validate($rules);

        DB::transaction(function () use ($request, $pengguna) {
            $pengguna->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update profil mahasiswa atau dosen
            if ($pengguna->role === 'mahasiswa' && $pengguna->mahasiswa) {
                $pengguna->mahasiswa->update([
                    'jurusan_id' => $request->jurusan_id,
                    'nim' => $request->nim,
                    'tahun_masuk' => $request->tahun_masuk, // Ambil dari request
                ]);
            } elseif ($pengguna->role === 'dosen' && $pengguna->dosen) {
                $pengguna->dosen->update([
                    'nidn' => $request->nidn,
                    'bidang_keahlian' => $request->bidang_keahlian,
                    'jurusan_id' => $request->jurusan_id,
                    'is_komisi' => $request->has('is_komisi') ? true : false,
                ]);
            }
        });

        return redirect()->route('bapendik.pengguna.index',['active_tab' => $pengguna->role])
            ->with('success_modal_message', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Menghapus data pengguna.
     */
    public function destroy(User $pengguna)
    {
        $roleTab = $pengguna->role; // Simpan role sebelum dihapus
        try {
            $pengguna->delete(); // Relasi cascadeOnDelete akan menghapus profil mahasiswa/dosen
            return redirect()->route('bapendik.pengguna.index', ['active_tab' => $roleTab])
                ->with('success_modal_message', 'Pengguna berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('bapendik.pengguna.index', ['active_tab' => $roleTab])
                ->with('error', 'Pengguna tidak bisa dihapus, kemungkinan masih terkait dengan data lain. Detail: ' . $e->getMessage());
        }
    }
}
