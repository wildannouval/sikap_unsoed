@extends('main.app')

@section('title', 'Riwayat Konsultasi: ' . Str::limit($pengajuanKp->judul_kp, 30))

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat Konsultasi Kerja Praktek</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            <strong>Judul KP:</strong> {{ $pengajuanKp->judul_kp }}<br>
                            <strong>Dosen Pembimbing:</strong> {{ $pengajuanKp->dosenPembimbing->user->name ?? 'Belum ada Dosen Pembimbing' }}
                        </p>
                    </div>
                    @if ($pengajuanKp->status_komisi == 'diterima' && $pengajuanKp->status_kp == 'dalam_proses')
                        <a href="{{ route('mahasiswa.pengajuan-kp.konsultasi.create', $pengajuanKp->id) }}" class="inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-150">
                            <svg class="h-4 w-4 mr-2 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" /></svg>
                            Tambah Catatan Konsultasi
                        </a>
                    @endif
                </div>

                <div class="px-4 pt-4">
                    @include('partials.session-messages')
                </div>
                @if (session('error')) {{-- Ini akan ditangkap oleh partials.session-messages juga --}}
                <div class="p-4 mx-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3">Topik Konsultasi</th>
                            <th scope="col" class="px-6 py-3">Catatan Mahasiswa</th>
                            <th scope="col" class="px-6 py-3">Catatan Dosen</th>
                            <th scope="col" class="px-6 py-3">Status Verifikasi</th>
                            <th scope="col" class="px-6 py-3">Tgl. Verifikasi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($konsultasis as $konsultasi)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 align-top">{{ \Carbon\Carbon::parse($konsultasi->tanggal_konsultasi)->isoFormat('D MMM YY') }}</td>
                                <td class="px-6 py-4 align-top font-medium text-gray-900 dark:text-white">{{ $konsultasi->topik_konsultasi }}</td>
                                <td class="px-6 py-4 align-top">
                                    <div class="prose prose-sm dark:prose-invert max-w-md">{!! nl2br(e($konsultasi->hasil_konsultasi)) !!}</div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="prose prose-sm dark:prose-invert max-w-md">{!! nl2br(e($konsultasi->catatan_dosen ?? '-')) !!}</div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    @if($konsultasi->diverifikasi)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Diverifikasi</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Belum Diverifikasi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 align-top">{{ $konsultasi->tanggal_verifikasi ? \Carbon\Carbon::parse($konsultasi->tanggal_verifikasi)->isoFormat('D MMM YY, HH:mm') : '-' }}</td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada catatan konsultasi untuk KP ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $konsultasis->links() }}
                </div>
                <div class="p-4 border-t dark:border-gray-700 flex justify-start">
                    <a href="{{ route('mahasiswa.pengajuan-kp.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0l4 4M1 5l4-4"/>
                        </svg>
                        Kembali ke Riwayat KP
                    </a>
                </div>
            </div>
        </div>
    </section>

    @if(session('success_modal_message'))
        @include('partials.modal-success')
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success_modal_message'))
            const successModalEl = document.getElementById('successModal');
            const successModalMessageEl = document.getElementById('successModalMessage');
            if (successModalEl && successModalMessageEl) {
                successModalMessageEl.textContent = @json(session('success_modal_message'));
                const successModal = new Modal(successModalEl, {});
                successModal.show();
            }
            @endif
        });
    </script>
@endpush
