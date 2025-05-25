@php use Illuminate\Support\Facades\Auth; @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>SIKAP - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body>
@include('main.navbar')

<div>
    {{-- AWAL PERUBAHAN LOGIKA SIDEBAR --}}
    @if(Auth::check()) {{-- Selalu baik untuk mengecek apakah user sudah login --}}
    @php
        $user = Auth::user();
        $role = strtolower($user->role);
    @endphp

    @if($role === 'mahasiswa')
        @include('main.sidebar.mahasiswa')
    @elseif($role === 'bapendik')
        @include('main.sidebar.bapendik')
    @elseif($role === 'dosen')
        {{-- Jika rolenya adalah dosen, cek flag is_komisi --}}
        @if($user->dosen && $user->dosen->is_komisi)
            @include('main.sidebar.dosen-komisi')
        @else
            {{-- Jika bukan komisi, atau tidak ada profil dosen (fallback), tampilkan sidebar dosen pembimbing --}}
            @include('main.sidebar.dosen-pembimbing')
        @endif
    @endif
    {{-- Kamu bisa menambahkan @else jika ada halaman untuk guest yang pakai layout ini --}}
    @endif
    {{-- AKHIR PERUBAHAN LOGIKA SIDEBAR --}}

    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen p-4 sm:ml-64">
        <div class="mt-14">
            @yield('content')
        </div>
    </div>
</div>

@include('main.scripts')

</body>
</html>
