@extends('main.app')

@section('title', 'Pengajuan Surat Pengantar Saya')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Riwayat Pengajuan Surat Pengantar</h2>
                    <a href="{{ route('mahasiswa.surat-pengantar.create') }}" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Buat Pengajuan Baru
                    </a>
                </div>

                @if (session('success'))
                    <div class="p-4 mx-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="p-4 mx-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Tgl. Pengajuan</th>
                            <th scope="col" class="px-4 py-3">Lokasi Penelitian</th>
                            <th scope="col" class="px-4 py-3">Penerima Surat</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3">Tgl. Pengambilan</th>
                            <th scope="col" class="px-4 py-3">Catatan Bapendik</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($suratPengantars as $surat)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($surat->tanggal_pengajuan)->isoFormat('D MMM YYYY') }}</td>
                                <td class="px-4 py-3">{{ $surat->lokasi_penelitian }}</td>
                                <td class="px-4 py-3">{{ $surat->penerima_surat }}</td>
                                <td class="px-4 py-3">
                                    @if($surat->status_bapendik == 'menunggu')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Menunggu</span>
                                    @elseif($surat->status_bapendik == 'disetujui')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Disetujui</span>
                                    @elseif($surat->status_bapendik == 'ditolak')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $surat->tanggal_pengambilan ? \Carbon\Carbon::parse($surat->tanggal_pengambilan)->isoFormat('D MMM YYYY') : '-' }}</td>
                                <td class="px-4 py-3">{{ $surat->catatan_bapendik ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada pengajuan surat pengantar.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $suratPengantars->links() }}
                </nav>
            </div>
        </div>
    </section>
@endsection
