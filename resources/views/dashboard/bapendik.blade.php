@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">
                    Dashboard Admin Bapendik
                </h2>
                <p class="mt-2 text-gray-600">
                    Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Card Total Mahasiswa -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Total Mahasiswa</h3>
                    <p class="text-3xl font-bold text-blue-600">142</p>
                    <p class="mt-2 text-sm text-gray-500">Aktif KP Semester Ini</p>
                </div>

                <!-- Card Pengajuan -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Pengajuan Baru</h3>
                    <p class="text-3xl font-bold text-yellow-500">8</p>
                    <p class="mt-2 text-sm text-gray-500">Menunggu Verifikasi</p>
                </div>

                <!-- Card Dosen -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Total Dosen</h3>
                    <p class="text-3xl font-bold text-green-600">24</p>
                    <p class="mt-2 text-sm text-gray-500">Pembimbing & Komisi</p>
                </div>

                <!-- Card Seminar -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Jadwal Seminar</h3>
                    <p class="text-3xl font-bold text-purple-600">15</p>
                    <p class="mt-2 text-sm text-gray-500">Minggu Ini</p>
                </div>
            </div>

            <!-- Grafik dan Tabel -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Grafik -->
                <div class="bg-white p-6 rounded-lg shadow lg:col-span-2">
                    <h3 class="text-lg font-medium mb-4">Statistik KP per Jurusan</h3>
                    <div class="h-64 bg-gray-100 rounded flex items-center justify-center">
                        <!-- Placeholder untuk grafik -->
                        <p class="text-gray-500">Grafik akan ditampilkan di sini</p>
                    </div>
                </div>

                <!-- Aktivitas Terakhir -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Aktivitas Terakhir</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 h-5 w-5 text-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="ml-2 text-sm text-gray-700">5 pengajuan baru diverifikasi</p>
                        </li>
                        <!-- Item lainnya -->
                    </ul>
                </div>
            </div>

            <!-- Tabel Cepat -->
            <div class="mt-8 bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium mb-4">Pengajuan Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @for($i = 1; $i <= 5; $i++)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Mahasiswa Contoh {{ $i }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">20041110000{{ $i }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">@php echo now()->subDays($i)->format('d M Y'); @endphp</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($i % 2 == 0) bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                                    @if($i % 2 == 0) Disetujui @else Menunggu @endif
                                </span>
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
