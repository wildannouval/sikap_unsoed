@extends('main.app')

@section('title', 'Riwayat Pengajuan Kerja Praktek')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Riwayat Pengajuan Kerja Praktek</h2>
                    <a href="{{ route('mahasiswa.pengajuan-kp.create') }}" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Buat Pengajuan KP Baru
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
                            <th scope="col" class="px-4 py-3">Judul KP</th>
                            <th scope="col" class="px-4 py-3">Instansi</th>
                            <th scope="col" class="px-4 py-3">Status Komisi</th>
                            <th scope="col" class="px-4 py-3">Status KP</th>
                            <th scope="col" class="px-4 py-3">Dosen Pembimbing</th>
                            <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                            {{-- Tambahkan kolom lain jika perlu, misal tombol lihat detail --}}
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($pengajuanKps as $pengajuan)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->isoFormat('D MMM YY') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $pengajuan->judul_kp }}</td>
                                <td class="px-4 py-3">{{ $pengajuan->instansi_lokasi }}</td>
                                <td class="px-4 py-3">
                                    @if($pengajuan->status_komisi == 'direview')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Direview</span>
                                    @elseif($pengajuan->status_komisi == 'diterima')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Diterima</span>
                                    @elseif($pengajuan->status_komisi == 'ditolak')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Ditolak</span>
                                        @if($pengajuan->alasan_ditolak)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Alasan: {{ $pengajuan->alasan_ditolak }}</p>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ ucfirst(str_replace('_', ' ', $pengajuan->status_kp)) }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $pengajuan->dosenPembimbing->user->name ?? 'Belum Ditentukan' }}</td>
                                {{-- Tombol Aksi Konsultasi --}}
                                <td class="px-4 py-3 text-center">
                                    @if ($pengajuan->status_komisi == 'diterima' && $pengajuan->status_kp == 'dalam_proses')
                                        <a href="{{ route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuan->id) }}" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none dark:focus:ring-indigo-800">
                                            Konsultasi
                                        </a>
                                        @if ($pengajuan->jumlah_konsultasi_verified >= \App\Http\Controllers\Mahasiswa\SeminarKpController::MIN_KONSULTASI_VERIFIED && !$pengajuan->has_active_seminar)
                                            <a href="{{ route('mahasiswa.pengajuan-kp.seminar.create', $pengajuan->id) }}" class="text-white bg-teal-600 hover:bg-teal-700 font-medium rounded-lg text-xs px-3 py-1.5 mb-1 inline-block">
                                                Ajukan Seminar
                                            </a>
                                        @elseif($pengajuan->has_active_seminar)
                                            <span class="text-xs text-gray-500 dark:text-gray-400 block">(Seminar Diajukan/Dijadwalkan)</span>
                                        @else
                                            <span class="text-xs text-gray-500 dark:text-gray-400 block">(Syarat Konsul Seminar: {{ $pengajuan->jumlah_konsultasi_verified }}/{{ \App\Http\Controllers\Mahasiswa\SeminarKpController::MIN_KONSULTASI_VERIFIED }})</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada pengajuan kerja praktek.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $pengajuanKps->links() }}
                </nav>
            </div>
        </div>
    </section>
@endsection
