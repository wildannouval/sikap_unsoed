<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check() || strtolower(Auth::user()->role) !== strtolower($role)) {
            abort(403, 'AKSES DITOLAK.');
        }

        return $next($request);
    }

//    public function handle(Request $request, Closure $next, string $expectedRoleParam): Response
//    {
//        $user = Auth::user();
//
//        // Jika tidak ada user yang login, arahkan ke login (atau tampilkan error 401)
//        if (!$user) {
//            return redirect('login');
//        }
//
//        $actualUserRole = strtolower($user->role); // Misal: 'mahasiswa', 'bapendik', 'dosen'
//        $expectedRole = strtolower($expectedRoleParam);
//
//        // Jika role utama cocok (misal, mahasiswa ke halaman mahasiswa)
//        if ($actualUserRole === $expectedRole) {
//            return $next($request);
//        }
//
//        // Penanganan khusus untuk dosen dengan sub-peran
//        if ($actualUserRole === 'dosen') {
//            // Jika halaman ini untuk dosen pembimbing
//            if ($expectedRole === 'dosen_pembimbing') {
//                // Asumsi semua dosen yang memiliki profil di tabel 'dosens' bisa jadi pembimbing
//                if ($user->dosen) { // Cek apakah user memiliki relasi 'dosen' (profil dosennya ada)
//                    return $next($request);
//                }
//            }
//            // Jika halaman ini untuk dosen komisi
//            elseif ($expectedRole === 'dosen_komisi') {
//                // Cek flag 'is_komisi' di profil dosennya
//                if ($user->dosen && $user->dosen->is_komisi) {
//                    return $next($request);
//                }
//            }
//        }
//
//        // Jika tidak ada kondisi di atas yang terpenuhi, akses ditolak
//        abort(403, 'ANDA TIDAK MEMILIKI AKSES UNTUK ROLE INI.');
//    }


//    public function handle(Request $request, Closure $next, string ...$guards): Response
//    {
//        $guards = empty($guards) ? [null] : $guards;
//
//        foreach ($guards as $guard) {
//            if (Auth::guard($guard)->check()) { // Jika pengguna SUDAH LOGIN
//                $role = strtolower(Auth::user()->role);
//
//                $redirectPath = match($role) {
//                    'bapendik' => route('bapendik.dashboard'),
//                    'mahasiswa' => route('mahasiswa.dashboard'),
//                    'dosen_pembimbing' => route('dosen-pembimbing.dashboard'), // Sesuaikan dengan nama route di web.php
//                    'dosen_komisi' => route('dosen-komisi.dashboard'),
//                    default => route('home'), // Arahkan ke route 'home' yang akan kita definisikan
//                };
//
//                return redirect($redirectPath);
//            }
//        }
//
//        return $next($request); // Jika pengguna BELUM LOGIN, lanjutkan (misalnya ke halaman login)
//    }
//    public function handle(Request $request, Closure $next, $role): Response
//    {
//        if (strtolower(auth()->user()->role) !== strtolower($role)) {
//            abort(403);
//        };
//
//        return $next($request);
//    }
}
