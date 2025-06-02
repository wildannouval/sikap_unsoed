@extends('main.app')

@section('title', 'Penilaian Seminar KP')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Daftar Seminar KP Mahasiswa Bimbingan</h2>
                </div>

                @if (session('success'))
                    <div class="p-4 mx-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="p-4 mx-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Form Search (Opsional) --}}
                <form method="GET" action="{{ route('dosen-pembimbing.penilaian-seminar.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 p-4">
                        <div class="md:col-span-2">
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari (Nama Mhs/Judul)</label>
                            <input type="text" name="search" id="search" value="{{ $request->search ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Kata kunci...">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Cari</button>
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Jadwal Seminar</th>
                            <th scope="col" class="px-4 py-3">Ruangan</th>
                            <th scope="col" class="px-4 py-3">Mahasiswa</th>
                            <th scope="col" class="px-4 py-3">Judul KP Final</th>
                            <th scope="col" class="px-4 py-3">Status Penilaian</th>
                            <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($seminars as $seminar)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">
                                    {{ $seminar->tanggal_seminar ? \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('dddd, D MMM YYYY') : 'Belum Dijadwalkan' }}<br>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $seminar->jam_mulai ? \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') : '' }}
                                        {{ $seminar->jam_selesai ? ' - ' . \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $seminar->ruangan ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $seminar->mahasiswa->user->name ?? 'N/A' }}</span><br>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">NIM: {{ $seminar->mahasiswa->nim ?? 'N/A' }}</span>
                                </td>
                                <td class="px-4 py-3">{{ Str::limit($seminar->judul_kp_final, 35) }}</td>
                                <td class="px-4 py-3">
                                    @if($seminar->status_pengajuan == 'selesai_dinilai')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Sudah Dinilai</span>
                                    @elseif($seminar->status_pengajuan == 'dijadwalkan_komisi')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Dijadwalkan (Belum Dinilai)</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $seminar->status_pengajuan)) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($seminar->status_pengajuan == 'dijadwalkan_komisi' || $seminar->status_pengajuan == 'selesai_dinilai')
                                        <a href="{{ route('dosen-pembimbing.penilaian-seminar.editHasil', $seminar->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800">
                                            {{ $seminar->status_pengajuan == 'selesai_dinilai' ? 'Lihat/Edit Hasil' : 'Input Hasil' }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada seminar yang perlu dinilai atau riwayat penilaian.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $seminars->links() }}
                </nav>
            </div>
        </div>
    </section>
@endsection
