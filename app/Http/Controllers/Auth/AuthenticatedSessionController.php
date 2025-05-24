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

        // Cek role dan redirect ke dashboard masing-masing
        $role = auth()->user()->role;

        return redirect()->intended(
            match($role) {
                'bapendik' => route('dashboard.bapendik'),
                'mahasiswa' => route('dashboard.mahasiswa'),
                'dosen_pembimbing' => route('dashboard.dosen_pembimbing'),
                'dosen_komisi' => route('dashboard.dosen_komisi'),
                default => route('login')
            }
        );

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
