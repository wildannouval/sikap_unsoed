@php use Illuminate\Support\Facades\Auth; @endphp
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>SIKAP - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Script untuk menerapkan tema dari localStorage sebelum halaman render untuk menghindari FOUC (Flash of Unstyled Content)
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @stack('head=scripts')
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased">
<div class="min-h-screen">
    @include('main.navbar')

    {{-- AWAL PERUBAHAN LOGIKA SIDEBAR --}}
    @if(Auth::check())
        {{-- Selalu baik untuk mengecek apakah user sudah login --}}
        @php
            $user = Auth::user();
            $role = strtolower($user->role);
        @endphp

        @if($role === 'mahasiswa')
            @include('main.sidebar.mahasiswa')
        @elseif($role === 'bapendik')
            @include('main.sidebar.bapendik')
        @elseif($role === 'dosen')
            @include('main.sidebar.dosen')
        @endif
        {{-- Kamu bisa menambahkan @else jika ada halaman untuk guest yang pakai layout ini --}}
    @endif
    {{-- AKHIR PERUBAHAN LOGIKA SIDEBAR --}}

    {{-- Konten Utama --}}
    <main class="p-4 pt-20 sm:ml-64"> {{-- pt-20 untuk memberi ruang di bawah navbar fixed --}}
        {{-- Kamu bisa meletakkan @include('partials.session-messages') di sini jika ingin pesan session muncul di semua halaman konten --}}
        {{-- atau di dalam @yield('content') pada masing-masing view --}}
        @yield('content')
    </main>

    {{--    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen p-4 sm:ml-64">--}}
    {{--        <div class="mt-14">--}}
    {{--            @yield('content')--}}
    {{--        </div>--}}
    {{--    </div>--}}
</div>

@include('main.scripts')

</body>
</html>
