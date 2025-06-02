@extends('main.app')

@section('title', 'Dashboard Dosen Komisi')

@section('content')
    <div class="p-4 sm:p-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8">
            Dashboard Dosen Komisi KP
        </h1>

        @if (session('success'))
            <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any()) {{-- Menampilkan semua jenis error jika ada --}}
        <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">Terjadi Kesalahan:</span>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        {{-- Bagian Tugas Mendesak --}}
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Tugas Mendesak Anda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Card Validasi Pengajuan KP --}}
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5 class="text-3xl font-bold text-blue-600 dark:text-blue-500">{{ $countPengajuanKpMenungguValidasi }}</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 mt-1">Pengajuan KP Menunggu Validasi</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M17.774 3.681A1.003 1.003 0 0 0 16.618 3H3.382a1 1 0 0 0-.95.681L1.226 7.5h17.548l-1.2-3.819ZM2.226 9a1 1 0 0 0-.95.681l-1.2 3.819A1.003 1.003 0 0 0 1.226 15H18.77a1 1 0 0 0 .95-.681l1.2-3.819A1.003 1.003 0 0 0 18.774 9H2.226Z M16.23 11.882 15.126 15H4.874L3.77 11.882h12.46Z"/></svg>
                        </div>
                    </div>
                    @if($countPengajuanKpMenungguValidasi > 0)
                        <a href="{{ route('dosen-komisi.validasi-kp.index', ['status_komisi' => 'direview']) }}" class="inline-flex items-center px-3 py-2 mt-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Proses Validasi KP
                            <svg class="rtl:rotate-180 w-3 h-3 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                        </a>
                    @endif
                </div>
                {{-- Tambahkan card tugas mendesak lain jika Dosen Komisi punya tugas lain --}}
            </div>
        </div>

        {{-- Bagian Statistik Kunci --}}
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Statistik Umum</h2>
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-center">
                    <div>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $countTotalPengajuanKpDiproses }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 uppercase mt-1">Total Pengajuan KP Diproses</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $countPengajuanKpMenungguValidasi }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 uppercase mt-1">Pengajuan KP Perlu Validasi</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-pink-600 dark:text-pink-400">{{ $countTotalDosen }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 uppercase mt-1">Total Dosen (Potensi Pembimbing)</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bagian Akses Cepat ke Modul --}}
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Akses Cepat Modul</h2>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('dosen-komisi.validasi-kp.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">
                    <div class="p-3 mb-2 text-blue-600 bg-blue-100 rounded-full dark:text-blue-400 dark:bg-gray-700">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.774 3.681A1.003 1.003 0 0 0 16.618 3H3.382a1 1 0 0 0-.95.681L1.226 7.5h17.548l-1.2-3.819ZM2.226 9a1 1 0 0 0-.95.681l-1.2 3.819A1.003 1.003 0 0 0 1.226 15H18.77a1 1 0 0 0 .95-.681l1.2-3.819A1.003 1.003 0 0 0 18.774 9H2.226Z M16.23 11.882 15.126 15H4.874L3.77 11.882h12.46Z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Validasi Pengajuan KP</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">
                    <div class="p-3 mb-2 text-pink-600 bg-pink-100 rounded-full dark:text-pink-400 dark:bg-gray-700">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Profil Saya</span>
                </a>
                {{-- Tambahkan card akses cepat lain jika Dosen Komisi punya modul lain --}}
            </div>
        </div>
    </div>
@endsection
