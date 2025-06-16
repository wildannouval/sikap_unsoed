<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman form edit profil.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        // Eager load relasi untuk efisiensi
        $user->load(['mahasiswa.jurusan', 'dosen.jurusan']);

        return view('profile.edit', [
            'user' => $user,
            'jurusans' => Jurusan::orderBy('nama')->get(),
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi data dasar & foto
        $validatedUser = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Batas diubah ke 2MB
            ],
            [
                // Pesan error kustom jika file terlalu besar
                'photo.max' => 'Ukuran foto tidak boleh lebih dari 2MB.',
            ]
        );

        // Handle upload foto profil
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Simpan foto baru dan update path di database
            $user->profile_photo_path = $request->file('photo')->store('profile-photos', 'public');
        }

        $user->name = $validatedUser['name'];
        $user->email = $validatedUser['email'];

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Validasi dan update data spesifik peran (jika ada)
        if ($user->role === 'mahasiswa' && $user->mahasiswa) {
            $user->mahasiswa->update($request->validate([
                'nim' => ['required', 'string', 'max:20', Rule::unique('mahasiswas')->ignore($user->mahasiswa->id)],
                'tahun_masuk' => ['required', 'numeric', 'digits:4'],
                'jurusan_id' => ['required', 'exists:jurusans,id'],
                'no_hp' => ['nullable', 'string', 'max:20'],
                'alamat' => ['nullable', 'string', 'max:1000'],
            ]));
        } elseif ($user->role === 'dosen' && $user->dosen) {
            $user->dosen->update($request->validate([
                'nidn' => ['required', 'string', 'max:20', Rule::unique('dosens')->ignore($user->dosen->id)],
                'jurusan_id' => ['required', 'exists:jurusans,id'],
                'bidang_keahlian' => ['nullable', 'string', 'max:255'],
            ]));
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroyPhoto(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            // Hapus file dari storage
            Storage::disk('public')->delete($user->profile_photo_path);

            // Hapus path dari database
            $user->forceFill([
                'profile_photo_path' => null,
            ])->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Menghapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus foto profil dari storage sebelum hapus user
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
