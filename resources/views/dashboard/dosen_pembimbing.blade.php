@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">
                    Dashboard Dosen Pembimbing
                </h2>
                <p class="mt-2 text-gray-600">
                    Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span> (NIP: {{ auth()->user()->dosen->nip }})
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card Mahasiswa Bimbingan -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Mahasiswa Bimbingan</h3>
                    <p class="text-3xl font-bold text-blue-600">8</p>
                    <p class="mt-2 text-sm text-gray-500">Total mahasiswa yang dibimbing</p>
                </div>

                <!-- Card Konsultasi Pending -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Konsultasi Menunggu</h3>
                    <p class="text-3xl font-bold text-yellow-500">3</p>
                    <p class="mt-2 text-sm text-gray-500">Permintaan verifikasi</p>
                </div>

                <!-- Card Jadwal Seminar -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-medium mb-4">Jadwal Seminar</h3>
                    <p class="text-3xl font-bold text-green-600">2</p>
                    <p class="mt-2 text-sm text-gray-500">Minggu ini</p>
                </div>
            </div>

            <!-- Daftar Mahasiswa Bimbingan -->
            <div class="mt-8 bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium mb-4">Daftar Mahasiswa Bimbingan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Contoh data -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Andi Wijaya</td>
                            <td class="px-6 py-4 whitespace-nowrap">200411100001</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-blue-600 hover:text-blue-900">Detail</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
