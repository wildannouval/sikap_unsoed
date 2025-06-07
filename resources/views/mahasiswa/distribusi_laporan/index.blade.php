@extends('main.app')

@section('title', 'Distribusi Laporan KP')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Distribusi Laporan Kerja Praktek</h2>
                    {{-- Tidak ada tombol tambah global di sini, aksi per item --}}
                </div>

                <div class="px-4 pt-4">
                    @include('partials.session-messages')
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Judul KP</th>
                            <th scope="col" class="px-6 py-3">Instansi</th>
                            <th scope="col" class="px-6 py-3">Status Seminar</th>
                            <th scope="col" class="px-6 py-3">Status Distribusi</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($pengajuanKps as $pengajuan)
                            @php
                                $seminarSelesaiDinilai = $pengajuan->seminars->where('status_pengajuan', 'selesai_dinilai')->first();
                            @endphp
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $loop->iteration + $pengajuanKps->firstItem() - 1 }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ Str::limit($pengajuan->judul_kp, 40) }}</td>
                                <td class="px-6 py-4">{{ Str::limit($pengajuan->instansi_lokasi, 30) }}</td>
                                <td class="px-6 py-4">
                                    @if($seminarSelesaiDinilai)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Seminar Selesai Dinilai</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Seminar Belum Selesai</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($pengajuan->distribusi)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Sudah Upload Bukti</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tgl: {{ \Carbon\Carbon::parse($pengajuan->distribusi->tanggal_distribusi)->isoFormat('D MMM YY') }}</p>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Belum Upload Bukti</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($seminarSelesaiDinilai && !$pengajuan->distribusi)
                                        <a href="{{ route('mahasiswa.pengajuan-kp.distribusi.create', $pengajuan->id) }}" class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-150">
                                            <svg class="w-3.5 h-3.5 mr-1.5 -ml-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M15.172 7.172a1 1 0 012.828 0l1.414 1.414a1 1 0 010 1.414l-1.414 1.414a1 1 0 01-1.414 0l-1.414-1.414a1 1 0 010-1.414l1.414-1.414zM10 2.586l4.293 4.293a1 1 0 11-1.414 1.414L10 5.414 7.121 8.293a1 1 0 01-1.414 0L2.293 4.879A1 1 0 013.707 3.464L10 9.757l6.293-6.293a1 1 0 011.414 0L20 6.172a1.001 1.001 0 010 1.414l-2.414 2.414a1 1 0 01-.707.293H8.828a1 1 0 01-.707-.293L3.414 5.121A1 1 0 013.414 3.707L6.293.879a1 1 0 011.414 0L10 2.586Z"/></svg>
                                            Upload Bukti
                                        </a>
                                    @elseif($pengajuan->distribusi)
                                        <span class="text-xs text-green-600 dark:text-green-400">Sudah Diupload</span>
                                        {{-- Tambahkan link untuk melihat detail/edit bukti jika perlu --}}
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada pengajuan KP yang seminarnya telah selesai dinilai.
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
