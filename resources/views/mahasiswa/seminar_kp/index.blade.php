@extends('main.app')

@section('title', 'Status Pengajuan Seminar KP Saya')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Status Pengajuan Seminar Kerja Praktek</h2>
                    {{-- Mahasiswa mengajukan seminar via halaman detail KP -> konsultasi, jadi tidak ada tombol tambah di sini --}}
                </div>

                @if (session('success'))
                    <div class="p-4 mx-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('info'))
                    <div class="p-4 mx-4 mt-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                        {{ session('info') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="p-4 mx-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Tgl. Pengajuan Seminar</th>
                            <th scope="col" class="px-4 py-3">Judul KP Final</th>
                            <th scope="col" class="px-4 py-3">Status Pengajuan</th>
                            <th scope="col" class="px-4 py-3">Jadwal Seminar (Jika Ditetapkan)</th>
                            <th scope="col" class="px-4 py-3">Ruangan</th>
                            <th scope="col" class="px-4 py-3">Catatan Komisi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($seminars as $seminar)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($seminar->tanggal_pengajuan_seminar)->isoFormat('D MMM YY') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $seminar->judul_kp_final }}</td>
                                <td class="px-4 py-3">
                                    @if($seminar->status_pengajuan == 'diajukan')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Diajukan</span>
                                    @elseif($seminar->status_pengajuan == 'dijadwalkan')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Dijadwalkan</span>
                                    @elseif($seminar->status_pengajuan == 'selesai_dinilai')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Selesai Dinilai</span>
                                    @elseif($seminar->status_pengajuan == 'dibatalkan')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Dibatalkan</span>
                                    @elseif($seminar->status_pengajuan == 'revisi_jadwal')
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">Revisi Jadwal</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($seminar->tanggal_seminar && $seminar->jam_mulai)
                                        {{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('dddd, D MMMM YYYY') }}
                                        <br> Pukul {{ \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') }} - {{ $seminar->jam_selesai ? \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $seminar->ruangan ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $seminar->catatan_komisi ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada pengajuan seminar.
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
