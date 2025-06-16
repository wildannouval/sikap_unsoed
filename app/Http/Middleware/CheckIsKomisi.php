<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIsKomisi
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'dosen' && Auth::user()->dosen && Auth::user()->dosen->is_komisi) {
            return $next($request);
        }

        abort(403, 'AKSES DITOLAK. HANYA UNTUK ANGGOTA KOMISI.');
    }
}
