@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">
                    Dashboard Mahasiswa
                </h2>
                <p class="mt-2 text-gray-600">
                    Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span> (NIM: {{ auth()->user()->mahasiswa->nim }})
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card Status KP -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Status KP</h3>
                    <div class="flex items-center">
                        <span class="h-3 w-3 bg-green-500 rounded-full mr-2"></span>
                        <span class="text-gray-700">Dalam Proses</span>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Dosen Pembimbing: {{ auth()->user()->mahasiswa->dosenPembimbing->name ?? '-' }}</p>
                </div>

                <!-- Card Jadwal Seminar -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Jadwal Seminar</h3>
                    <p class="text-gray-700">12 Juni 2023</p>
                    <p class="text-sm text-gray-500 mt-1">Ruang A1, 09:00 WIB</p>
                </div>

                <!-- Card Progress -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Progress</h3>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 65%"></div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">65% Laporan Disetujui</p>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="mt-8 bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium mb-4">Aktivitas Terkini</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-5 w-5 text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="ml-2 text-sm text-gray-700">Proposal KP disetujui pada 15 Mei 2023</p>
                    </li>
                    <!-- Item lainnya -->
                </ul>
            </div>
        </div>
    </div>
@endsection
