<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = Auth::user();

        // Logika redirect yang disederhanakan
        $redirectPath = match(strtolower($user->role)) {
            'bapendik' => route('bapendik.dashboard'),
            'mahasiswa' => route('mahasiswa.dashboard'),
            'dosen' => route('dosen.dashboard'),
            default => '/login',
        };

        return redirect()->intended($redirectPath);

//        $request->authenticate();
//        $request->session()->regenerate();
//
//        $user = Auth::user(); // Ambil user yang sudah login
//        $role = strtolower($user->role);
//        $intendedUrl = $request->session()->pull('url.intended', '/'); // Ambil intended URL atau default ke '/'
//
//        $redirectPath = match($role) {
//            'bapendik' => route('bapendik.dashboard'),
//            'mahasiswa' => route('mahasiswa.dashboard'),
//            'dosen' => ($user->dosen && $user->dosen->is_komisi) ? route('dosen-komisi.dashboard') : route('dosen-pembimbing.dashboard'),
//            default => route('login'), // Seharusnya tidak terjadi jika role di database valid
//        };
//
//        // Gunakan redirect biasa jika tidak ada intended URL, atau jika intended URL adalah halaman login itu sendiri
//        if ($intendedUrl === '/' || $intendedUrl === route('login', [], false) ) {
//            return redirect($redirectPath);
//        }
//        return redirect()->intended($redirectPath);


        // Cek role dan redirect ke dashboard masing-masing
//        $role = auth()->user()->role;
//
//        return redirect()->intended(
//            match($role) {
//                'bapendik' => route('bapendik.dashboard'),
//                'mahasiswa' => route('mahasiswa.dashboard'),
//                'dosen_pembimbing' => route('dosen-pembimbing.dashboard'),
//                'dosen_komisi' => route('dosen-komisi.dashboard'),
//                default => route('dashboard')
//            }
//        );

//        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
