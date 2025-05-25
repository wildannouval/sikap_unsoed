@extends('main.app')

@section('title', 'Persetujuan & Riwayat Pengajuan Seminar KP') {{-- Judul bisa diubah --}}

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Daftar Pengajuan Seminar KP Bimbingan Anda</h2>
                </div>

                {{-- ... Notifikasi session success/error ... --}}
                @if (session('success'))
                    <div class="p-4 mx-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Form Search dan Filter --}}
                <form method="GET" action="{{ route('dosen-pembimbing.seminar-approval.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 p-4">
                        <div>
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari (Nama Mhs/NIM/Judul)</label>
                            <input type="text" name="search" id="search" value="{{ $request->search ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Kata kunci...">
                        </div>
                        {{-- TAMBAHKAN DROPDOWN FILTER STATUS --}}
                        <div>
                            <label for="status_pengajuan_filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter Status Pengajuan</label>
                            <select name="status_pengajuan_filter" id="status_pengajuan_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Semua Status Diproses Anda</option>
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ ($request->status_pengajuan_filter ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Tgl. Ajuan Mhs</th>
                            <th scope="col" class="px-4 py-3">Nama Mahasiswa</th>
                            <th scope="col" class="px-4 py-3">NIM</th>
                            <th scope="col" class="px-4 py-3">Judul KP Final</th>
                            <th scope="col" class="px-4 py-3">Usulan Jadwal (Mhs)</th>
                            <th scope="col" class="px-4 py-3">Status Pengajuan</th> {{-- Tambah kolom status --}}
                            <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($seminarApplications as $seminar)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($seminar->tanggal_pengajuan_seminar)->isoFormat('D MMM YY') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $seminar->mahasiswa->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $seminar->mahasiswa->nim ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ Str::limit($seminar->judul_kp_final, 35) }}</td>
                                <td class="px-4 py-3">
                                    @if($seminar->tanggal_seminar && $seminar->jam_mulai)
                                        {{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('D MMM YY') }},
                                        {{ \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') }}-{{ $seminar->jam_selesai ? \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '' }},
                                        {{ $seminar->ruangan ?? '' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- TAMPILKAN STATUS PENGAJUAN --}}
                                <td class="px-4 py-3">
                                    @if($seminar->status_pengajuan == 'diajukan_mahasiswa')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Diajukan Mahasiswa</span>
                                    @elseif($seminar->status_pengajuan == 'disetujui_dospem')
                                        <span class="bg-sky-100 text-sky-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-sky-900 dark:text-sky-300">Disetujui Anda</span>
                                    @elseif($seminar->status_pengajuan == 'ditolak_dospem')
                                        <span class="bg-pink-100 text-pink-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300">Ditolak Anda</span>
                                    @elseif($seminar->status_pengajuan == 'dijadwalkan_komisi')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Dijadwalkan Komisi</span>
                                    @elseif($seminar->status_pengajuan == 'selesai_dinilai')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Selesai Dinilai</span>
                                    @elseif($seminar->status_pengajuan == 'dibatalkan')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Dibatalkan</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $seminar->status_pengajuan)) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    {{-- Tombol Proses hanya muncul jika statusnya 'diajukan_mahasiswa' --}}
                                    @if($seminar->status_pengajuan == 'diajukan_mahasiswa')
                                        <a href="{{ route('dosen-pembimbing.seminar-approval.showForm', $seminar->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800">
                                            Proses
                                        </a>
                                    @else
                                        <a href="{{ route('dosen-pembimbing.seminar-approval.showForm', $seminar->id) }}" class="text-gray-600 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                                            Lihat Detail
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data pengajuan seminar.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $seminarApplications->links() }}
                </nav>
            </div>
        </div>
    </section>
@endsection
