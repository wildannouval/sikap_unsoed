<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>SIKAP - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@include('main.navbar')

<div>
    @if(auth()->user()->role === 'mahasiswa')
        @include('main.sidebar.mahasiswa')
    @elseif(auth()->user()->role === 'bapendik')
        @include('main.sidebar.bapendik')
    @elseif(auth()->user()->role === 'dosen_komisi')
        @include('main.sidebar.dosen-komisi')
    @elseif(auth()->user()->role === 'dosen_pembimbing')
        @include('main.sidebar.dosen-pembimbing')
    @endif

    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen p-4 sm:ml-64">
        <div class="bg-white dark:bg-gray-800 mt-14 rounded-lg">
            @yield('content')
        </div>
    </div>
</div>

@include('main.scripts')
</body>
</html>
