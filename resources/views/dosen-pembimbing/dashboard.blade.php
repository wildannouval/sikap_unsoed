@extends('main.app')

@section('title', 'Dashboard Dosen Pembimbing')

@section('content')
    <div class="p-4 sm:p-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8">
            Dashboard Dosen Pembimbing
        </h1>

        @if ($errors->has('profil_dosen'))
            <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Error!</span> {{ $errors->first('profil_dosen') }}
            </div>
        @endif
        @if (session('success'))
            <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Bagian Tugas Mendesak --}}
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Tugas Mendesak Anda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Card Persetujuan Seminar --}}
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5 class="text-3xl font-bold text-blue-600 dark:text-blue-500">{{ $countSeminarMenungguPersetujuan }}</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 mt-1">Pengajuan Seminar Menunggu Persetujuan</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 0 19 9.5 9.5 0 0 0 0-19ZM13.707 8.707l-4 4a1 1 0 0 1-1.414-1.414L10.586 9H7a1 1 0 0 1 0-2h3.586l-2.293-2.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414Z"/></svg>
                        </div>
                    </div>
                    @if($countSeminarMenungguPersetujuan > 0)
                        <a href="{{ route('dosen-pembimbing.seminar-approval.index', ['status_pengajuan_filter' => 'diajukan_mahasiswa']) }}" class="inline-flex items-center px-3 py-2 mt-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Proses Persetujuan
                            <svg class="rtl:rotate-180 w-3 h-3 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                        </a>
                    @endif
                </div>

                {{-- Card Verifikasi Konsultasi --}}
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5 class="text-3xl font-bold text-yellow-500 dark:text-yellow-400">{{ $countKonsultasiMenungguVerifikasi }}</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 mt-1">Konsultasi Menunggu Verifikasi</p>
                        </div>
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                            <svg class="w-6 h-6 text-yellow-500 dark:text-yellow-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M18 5.923A1.99 1.99 0 0 0 16.084 4H3.916A1.99 1.99 0 0 0 2 5.923V14.08A1.99 1.99 0 0 0 3.916 16h12.168A1.99 1.99 0 0 0 18 14.079V5.923Zm-7.15.619L14.084 10h-3.5L7.15 6.542ZM5.014 13.318a1.001 1.001 0 0 1-.992-.993V7.671a1 1 0 0 1 .992-.993l4.893-2.446a1 1 0 0 1 1.21.001l4.893 2.446a1 1 0 0 1 .992.993v4.654a1.001 1.001 0 0 1-.992.993L5.014 13.318Z"/></svg>
                        </div>
                    </div>
                    @if($countKonsultasiMenungguVerifikasi > 0)
                        <a href="{{ route('dosen-pembimbing.bimbingan-kp.index') }}" class="inline-flex items-center px-3 py-2 mt-4 text-xs font-medium text-center text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:focus:ring-yellow-700">
                            Lihat Bimbingan & Verifikasi
                            <svg class="rtl:rotate-180 w-3 h-3 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                        </a>
                    @endif
                </div>

                {{-- Card Penilaian Seminar --}}
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h5 class="text-3xl font-bold text-green-600 dark:text-green-500">{{ $countSeminarMenungguPenilaian }}</h5>
                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400 mt-1">Seminar Menunggu Penilaian</p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M17 4a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4Zm-2.5 7.5a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm-5 4a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Z"/></svg>
                        </div>
                    </div>
                    @if($countSeminarMenungguPenilaian > 0)
                        <a href="{{ route('dosen-pembimbing.penilaian-seminar.index', ['status_pengajuan' => 'dijadwalkan_komisi']) }}" class="inline-flex items-center px-3 py-2 mt-4 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            Input Hasil Seminar
                            <svg class="rtl:rotate-180 w-3 h-3 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Bagian Statistik Kunci --}}
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Statistik Kinerja Anda</h2>
            <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
                    <div>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $countMahasiswaBimbinganAktif }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 uppercase mt-1">Mhs Bimbingan Aktif</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $countTotalKonsultasiDiverifikasi }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 uppercase mt-1">Total Konsultasi Diverifikasi</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $countTotalSeminarDinilai }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 uppercase mt-1">Total Seminar Dinilai</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bagian Akses Cepat ke Modul --}}
        <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Akses Cepat Modul</h2>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('dosen-pembimbing.bimbingan-kp.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">
                    <div class="p-3 mb-2 text-blue-600 bg-blue-100 rounded-full dark:text-blue-400 dark:bg-gray-700">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 18" xmlns="http://www.w3.org/2000/svg"><path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Bimbingan KP & Konsultasi</span>
                </a>
                <a href="{{ route('dosen-pembimbing.seminar-approval.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">
                    <div class="p-3 mb-2 text-green-600 bg-green-100 rounded-full dark:text-green-400 dark:bg-gray-700">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 .5a9.5 9.5 0 1 0 0 19 9.5 9.5 0 0 0 0-19ZM13.707 8.707l-4 4a1 1 0 0 1-1.414-1.414L10.586 9H7a1 1 0 0 1 0-2h3.586l-2.293-2.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414Z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Persetujuan Seminar</span>
                </a>
                <a href="{{ route('dosen-pembimbing.penilaian-seminar.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">
                    <div class="p-3 mb-2 text-purple-600 bg-purple-100 rounded-full dark:text-purple-400 dark:bg-gray-700">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17 4a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4Zm-2.5 7.5a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm-5 4a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Penilaian Seminar</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">
                    <div class="p-3 mb-2 text-pink-600 bg-pink-100 rounded-full dark:text-pink-400 dark:bg-gray-700">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Profil Saya</span>
                </a>
            </div>
        </div>
    </div>
@endsection
