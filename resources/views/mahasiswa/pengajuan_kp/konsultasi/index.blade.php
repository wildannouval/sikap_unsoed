@extends('main.app')

@section('title', 'Riwayat Konsultasi KP - ' . Str::limit($pengajuanKp->judul_kp, 30))

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat Konsultasi KP</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Judul: {{ $pengajuanKp->judul_kp }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Dosen Pembimbing: {{ $pengajuanKp->dosenPembimbing->user->name ?? 'Belum ada' }}</p>
                    </div>
                    @if ($pengajuanKp->status_komisi == 'diterima' && $pengajuanKp->status_kp == 'dalam_proses')
                        <a href="{{ route('mahasiswa.pengajuan-kp.konsultasi.create', $pengajuanKp->id) }}" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Tambah Catatan Konsultasi
                        </a>
                    @endif
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

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Tanggal</th>
                            <th scope="col" class="px-4 py-3">Topik Konsultasi</th>
                            <th scope="col" class="px-4 py-3">Hasil/Arahan (dari Mahasiswa)</th>
                            <th scope="col" class="px-4 py-3">Catatan Dosen</th>
                            <th scope="col" class="px-4 py-3">Status Verifikasi</th>
                            <th scope="col" class="px-4 py-3">Tgl. Verifikasi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($konsultasis as $konsultasi)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($konsultasi->tanggal_konsultasi)->isoFormat('D MMM YYYY') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $konsultasi->topik_konsultasi }}</td>
                                <td class="px-4 py-3">{!! nl2br(e($konsultasi->hasil_konsultasi)) !!}</td>
                                <td class="px-4 py-3">{!! nl2br(e($konsultasi->catatan_dosen ?? '-')) !!}</td>
                                <td class="px-4 py-3">
                                    @if($konsultasi->diverifikasi)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Sudah Diverifikasi</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Belum Diverifikasi</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $konsultasi->tanggal_verifikasi ? \Carbon\Carbon::parse($konsultasi->tanggal_verifikasi)->isoFormat('D MMM YYYY, HH:mm') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada catatan konsultasi.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $konsultasis->links() }}
                </div>
                <div class="p-4 border-t dark:border-gray-700">
                    <a href="{{ route('mahasiswa.pengajuan-kp.index') }}" class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-600 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
                        Kembali ke Daftar Pengajuan KP
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
