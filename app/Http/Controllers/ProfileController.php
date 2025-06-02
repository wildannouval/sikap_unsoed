<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $profileData = null;
        $jurusans = Jurusan::orderBy('nama')->get(); // Ambil semua jurusan untuk dropdown

        // Ambil data spesifik peran
        if ($user->role === 'mahasiswa' && $user->mahasiswa) {
            $profileData = $user->mahasiswa;
        } elseif ($user->role === 'dosen' && $user->dosen) {
            $profileData = $user->dosen;
        }
        // Untuk Bapendik, mungkin tidak ada tabel profil terpisah selain 'users'
        // atau bisa ditambahkan jika ada data spesifik Bapendik.

        return view('profile.edit', [
            'user' => $user,
            'profileData' => $profileData,
            'jurusans' => $jurusans, // Kirim data jurusan ke view
            'mustVerifyEmail' => false, // Sesuaikan jika kamu pakai verifikasi email Breeze
            'status' => session('status'), // Untuk pesan sukses update password
        ]);

//        return view('profile.edit', [
//            'user' => $request->user(),
//        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update data di tabel 'users'
        $user->fill($request->validated()); // ProfileUpdateRequest akan validasi name & email

        if ($user->isDirty('email')) {
            $user->email_verified_at = null; // Jika email diubah, reset verifikasi (jika pakai fitur verifikasi)
        }
        $user->save();

        // Update data spesifik peran di tabel 'mahasiswas' atau 'dosens'
        if ($user->role === 'mahasiswa' && $user->mahasiswa) {
            $request->validate([
                'nim' => ['required', 'string', 'max:20', Rule::unique('mahasiswas')->ignore($user->mahasiswa->id)],
                'no_hp' => ['nullable', 'string', 'max:20'],
                'tahun_masuk' => ['required', 'numeric', 'digits:4'],
                'alamat' => ['nullable', 'string', 'max:255'],
                'jurusan_id_mahasiswa' => ['required', 'exists:jurusans,id'], // Pastikan nama field ini konsisten dengan view
            ]);
            $user->mahasiswa->update([
                'nim' => $request->nim,
                'no_hp' => $request->no_hp,
                'tahun_masuk' => $request->tahun_masuk,
                'alamat' => $request->alamat,
                'jurusan_id' => $request->jurusan_id_mahasiswa,
            ]);
        } elseif ($user->role === 'dosen' && $user->dosen) {
            $request->validate([
                'nidn' => ['required', 'string', 'max:20', Rule::unique('dosens')->ignore($user->dosen->id)],
                'bidang_keahlian' => ['nullable', 'string', 'max:255'],
                'jurusan_id_dosen' => ['required', 'exists:jurusans,id'], // Pastikan nama field ini konsisten dengan view
                // 'is_komisi' tidak diupdate dari sini, itu oleh admin/Bapendik
            ]);
            $user->dosen->update([
                'nidn' => $request->nidn,
                'bidang_keahlian' => $request->bidang_keahlian,
                'jurusan_id' => $request->jurusan_id_dosen,
            ]);
        }
        // Untuk Bapendik, jika ada data profil lain, update di sini.

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
//        $request->user()->fill($request->validated());
//
//        if ($request->user()->isDirty('email')) {
//            $request->user()->email_verified_at = null;
//        }
//
//        $request->user()->save();
//
//        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
