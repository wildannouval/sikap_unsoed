@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">
                    Dashboard Dosen Komisi
                </h2>
                <p class="mt-2 text-gray-600">
                    Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span> (NIP: {{ auth()->user()->dosen->nip }})
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card Seminar yang Diuji -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Seminar yang Diuji</h3>
                    <p class="text-3xl font-bold text-blue-600">12</p>
                    <p class="mt-2 text-sm text-gray-500">Total seminar</p>
                </div>

                <!-- Card Penilaian Pending -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Penilaian Menunggu</h3>
                    <p class="text-3xl font-bold text-yellow-500">2</p>
                    <p class="mt-2 text-sm text-gray-500">Belum dinilai</p>
                </div>

                <!-- Card Jadwal -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Jadwal Terdekat</h3>
                    <p class="text-xl font-semibold text-gray-800">15 Juni 2023</p>
                    <p class="text-sm text-gray-500 mt-1">2 Seminar</p>
                </div>
            </div>

            <!-- Daftar Seminar -->
            <div class="mt-8 bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium mb-4">Daftar Seminar</h3>
                <div class="space-y-4">
                    @for($i = 1; $i <= 3; $i++)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between">
                                <div>
                                    <h4 class="font-medium">Seminar KP Mahasiswa #{{ $i }}</h4>
                                    <p class="text-sm text-gray-500">NIM: 20041110000{{ $i }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Menunggu Penilaian</span>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                10 Juni 2023, 10:00 WIB - Ruang B2
                            </div>
                            <div class="mt-2 flex justify-end">
                                <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Lihat Detail →</a>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
@endsection
