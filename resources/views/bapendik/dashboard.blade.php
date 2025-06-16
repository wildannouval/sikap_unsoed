{{--@extends('main.app')--}}

{{--@section('title', 'Dashboard Bapendik')--}}

{{--@section('content')--}}
{{--    <div class="p-4 sm:p-6">--}}
{{--        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8">--}}
{{--            Dashboard Administrasi Akademik (BAPENDIK)--}}
{{--        </h1>--}}

{{--        @if (session('success'))--}}
{{--            <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">--}}
{{--                {{ session('success') }}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        --}}{{-- Bagian Tugas Mendesak --}}
{{--        <div class="mb-8">--}}
{{--            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Tugas Mendesak Anda</h2>--}}
{{--            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">--}}
{{--                --}}{{-- Card Validasi Surat Pengantar --}}
{{--                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">--}}
{{--                    <div class="flex items-center justify-between">--}}
{{--                        <div>--}}
{{--                            <h5 class="text-3xl font-bold text-blue-600 dark:text-blue-500">{{ $countSuratMenungguValidasi }}</h5>--}}
{{--                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 mt-1">Surat Pengantar Menunggu Validasi</p>--}}
{{--                        </div>--}}
{{--                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">--}}
{{--                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18"><path d="M18 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3.525V18h-1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1.542a1 1 0 0 0 .875-.515L7.89 18H12.1l1.433 1.485a1 1 0 0 0 .875.515H15.96a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1h-1.525v-4H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-4.5 8.5H11V6a1 1 0 0 0-2 0v2.5H6.5a1 1 0 0 0 0 2H9V13a1 1 0 0 0 2 0v-2.5h2.5a1 1 0 0 0 0-2Z"/></svg>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    @if($countSuratMenungguValidasi > 0)--}}
{{--                        <a href="{{ route('bapendik.validasi-surat.index', ['status_bapendik' => 'menunggu']) }}" class="inline-flex items-center px-3 py-2 mt-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">--}}
{{--                            Proses Validasi--}}
{{--                            <svg class="rtl:rotate-180 w-3 h-3 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>--}}
{{--                        </a>--}}
{{--                    @endif--}}
{{--                </div>--}}

{{--                --}}{{-- Card Penjadwalan Seminar --}}
{{--                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">--}}
{{--                    <div class="flex items-center justify-between">--}}
{{--                        <div>--}}
{{--                            <h5 class="text-3xl font-bold text-orange-600 dark:text-orange-500">{{ $countSeminarMenungguJadwal }}</h5>--}}
{{--                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 mt-1">Seminar KP Menunggu Penjadwalan</p>--}}
{{--                        </div>--}}
{{--                        <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-full">--}}
{{--                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6 5V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h1a2 2 0 0 1 2 2v2H3V7a2 2 0 0 1 2-2h1ZM3 19v-8h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm5-6a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8Z" clip-rule="evenodd"/></svg>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    @if($countSeminarMenungguJadwal > 0)--}}
{{--                        <a href="{{ route('bapendik.penjadwalan-seminar.index', ['status_filter' => 'disetujui_dospem']) }}" class="inline-flex items-center px-3 py-2 mt-4 text-xs font-medium text-center text-white bg-orange-700 rounded-lg hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">--}}
{{--                            Proses Penjadwalan--}}
{{--                            <svg class="rtl:rotate-180 w-3 h-3 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>--}}
{{--                        </a>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{-- Bagian Statistik Kunci (Desain Baru) --}}
{{--        <div class="mb-8">--}}
{{--            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Ringkasan Data SIKAP</h2>--}}
{{--            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">--}}
{{--                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-6 text-center">--}}
{{--                    <div>--}}
{{--                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $countMahasiswaAktifKp }}</p>--}}
{{--                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 uppercase mt-1">Mahasiswa Aktif KP</p>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $countTotalJurusan }}</p>--}}
{{--                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 uppercase mt-1">Total Jurusan</p>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $countTotalMahasiswa }}</p>--}}
{{--                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 uppercase mt-1">Total Mahasiswa</p>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <p class="text-3xl font-bold text-pink-600 dark:text-pink-400">{{ $countTotalDosen }}</p>--}}
{{--                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 uppercase mt-1">Total Dosen</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        --}}{{-- Bagian Akses Cepat ke Modul (Desain Tetap dengan Ikon Besar) --}}
{{--        <div>--}}
{{--            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Akses Cepat Modul</h2>--}}
{{--            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">--}}
{{--                <a href="{{ route('bapendik.jurusan.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">--}}
{{--                    <div class="p-3 mb-2 text-blue-600 bg-blue-100 rounded-full dark:text-blue-400 dark:bg-gray-700">--}}
{{--                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>--}}
{{--                    </div>--}}
{{--                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Manajemen Jurusan</span>--}}
{{--                </a>--}}
{{--                <a href="{{ route('bapendik.pengguna.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">--}}
{{--                    <div class="p-3 mb-2 text-green-600 bg-green-100 rounded-full dark:text-green-400 dark:bg-gray-700">--}}
{{--                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>--}}
{{--                    </div>--}}
{{--                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Manajemen Pengguna</span>--}}
{{--                </a>--}}
{{--                <a href="{{ route('bapendik.validasi-surat.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">--}}
{{--                    <div class="p-3 mb-2 text-purple-600 bg-purple-100 rounded-full dark:text-purple-400 dark:bg-gray-700">--}}
{{--                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>--}}
{{--                    </div>--}}
{{--                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Validasi Surat Pengantar</span>--}}
{{--                </a>--}}
{{--                <a href="{{ route('bapendik.penjadwalan-seminar.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">--}}
{{--                    <div class="p-3 mb-2 text-orange-600 bg-orange-100 rounded-full dark:text-orange-400 dark:bg-gray-700">--}}
{{--                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V1a1 1 0 0 0-2 0v1H5V1Zm10 5H5v8h10V6Z"/></svg>--}}
{{--                    </div>--}}
{{--                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Penjadwalan Seminar</span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}



@extends('main.app')

@section('title', 'Dashboard Bapendik')

@section('content')
    <div class="p-4 sm:p-6 space-y-8">
        {{-- Header Sambutan --}}
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Dashboard Administrasi</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Selamat datang kembali, {{ Auth::user()->name }}! Berikut adalah ringkasan sistem hari ini.</p>
        </div>

        @include('partials.session-messages')

        {{-- Bagian Tugas Mendesak --}}
        <section>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Tugas Mendesak</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Kartu Validasi Surat Pengantar --}}
                <a href="{{ route('bapendik.validasi-surat.index', ['status_bapendik' => 'menunggu']) }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700/50 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Validasi Surat</p>
                            <h5 class="text-4xl font-bold tracking-tight text-blue-600 dark:text-blue-400">{{ $countSuratMenungguValidasi }}</h5>
                        </div>
                        <span class="inline-flex items-center justify-center p-3 bg-blue-100 rounded-full dark:bg-blue-900/50">
                            {{-- Flowbite Icon: file-pen --}}
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm-1.05-3.05a2.5 2.5 0 0 1 3.55 0M8 9.05a2.5 2.5 0 0 1 3.55 0m4.5 0a2.5 2.5 0 0 1-3.55 0"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Pengajuan perlu diproses</p>
                </a>
                {{-- KARTU BARU: Cetak SPK --}}
                <a href="{{ route('bapendik.spk.index', ['status_spk_filter' => 'belum_dicetak']) }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700/50 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cetak SPK</p>
                            <h5 class="text-4xl font-bold tracking-tight text-green-600 dark:text-green-400">{{ $countSpkMenungguCetak }}</h5>
                        </div>
                        <span class="inline-flex items-center justify-center p-3 bg-green-100 rounded-full dark:bg-green-900/50">
            {{-- FLOWBITE ICON: document-check --}}
            <svg class="w-6 h-6 text-green-600 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z"/>
            </svg>
        </span>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">KP disetujui, perlu SPK</p>
                </a>
                {{-- Kartu Penjadwalan Seminar --}}
                <a href="{{ route('bapendik.penjadwalan-seminar.index', ['status_filter' => 'disetujui_dospem']) }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700/50 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Penjadwalan Seminar</p>
                            <h5 class="text-4xl font-bold tracking-tight text-orange-600 dark:text-orange-400">{{ $countSeminarMenungguJadwal }}</h5>
                        </div>
                        <span class="inline-flex items-center justify-center p-3 bg-orange-100 rounded-full dark:bg-orange-900/50">
                            {{-- Flowbite Icon: calendar --}}
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Seminar perlu jadwal final</p>
                </a>
                {{-- KARTU BARU: Cetak Berita Acara --}}
                <a href="{{ route('bapendik.penjadwalan-seminar.index', ['status_filter' => 'dijadwalkan_bapendik']) }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700/50 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cetak Berita Acara</p>
                            <h5 class="text-4xl font-bold tracking-tight text-teal-600 dark:text-teal-400">{{ $countBaMenungguCetak }}</h5>
                        </div>
                        <span class="inline-flex items-center justify-center p-3 bg-teal-100 rounded-full dark:bg-teal-900/50">
            {{-- FLOWBITE ICON: document-text --}}
            <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-14 4h14m-14-8h14H5Zm7 12a9 9 0 1 1 0-18 9 9 0 0 1 0 18Z"/>
            </svg>
        </span>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Untuk seminar terjadwal</p>
                </a>
            </div>
        </section>

        {{-- Grid Utama: Statistik & Aktivitas --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Kiri (Lebar): Aktivitas Terbaru --}}
            <div class="lg:col-span-2">
                <section>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Aktivitas Terbaru</h2>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border dark:border-gray-700">
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentActivities as $activity)
                                <li class="p-4 flex flex-col sm:flex-row justify-between sm:items-center hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                    <div class="flex items-center gap-x-4">
                                        <div class="hidden sm:inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 dark:bg-gray-900">
                                            {{-- Flowbite Icon: document-add --}}
                                            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h0m0 4h0m0-8v8"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Pengajuan Surat dari <span class="font-bold">{{ $activity->mahasiswa->user->name }}</span></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Tujuan: {{ Str::limit($activity->lokasi_penelitian, 40) }} &bull; {{ $activity->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('bapendik.validasi-surat.edit', $activity->id) }}" class="mt-3 sm:mt-0 shrink-0 text-xs font-semibold text-blue-600 dark:text-blue-500 hover:underline">
                                        Lihat & Proses &rarr;
                                    </a>
                                </li>
                            @empty
                                <li class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada aktivitas pengajuan surat terbaru.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </section>
            </div>

            {{-- Kolom Kanan (Sempit): Statistik & Navigasi --}}
            <div class="lg:col-span-1 space-y-8">
                <section>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Statistik Sistem</h2>
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                            <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500/20">
                                {{-- Flowbite Icon: office-building --}}
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h12M6 4v16M6 4H5m1 16v.01M5 20v.01M4 20h16v-4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v4h-2m-1-4-1 4h-2m-1-4-1 4h-2m12-4v.01M11 8h2m-1 0v4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Jurusan</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $countTotalJurusan }}</p>
                            </div>
                        </div>
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500/20">
                                {{-- Flowbite Icon: users-group --}}
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M11 15h2M12 12v.01M12 9v.01M12 6v.01M4 12h1.5M6.5 4.5l1.06 1.06M4.5 6.5l1.06-1.06M17.5 4.5l-1.06 1.06M19.5 6.5l-1.06-1.06M12 20.5A8.5 8.5 0 1 1 20.5 12 8.5 8.5 0 0 1 12 20.5Z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Pengguna</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $countTotalMahasiswa + $countTotalDosen }}</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
