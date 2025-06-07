@extends('main.app')

@section('title', 'Riwayat Pengajuan Surat Pengantar KP')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Container agar memenuhi ruang --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat Pengajuan Surat Pengantar KP</h2>
                    <a href="{{ route('mahasiswa.surat-pengantar.create') }}" class="inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-150">
                        <svg class="h-4 w-4 mr-2 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" /></svg>
                        Buat Pengajuan Baru
                    </a>
                </div>

                <div class="px-4 pt-4">
                    @include('partials.session-messages') {{-- Menampilkan pesan sukses/error --}}
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Tgl. Pengajuan</th>
                            <th scope="col" class="px-6 py-3">Tujuan Instansi</th>
                            <th scope="col" class="px-6 py-3">Penerima Surat</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Tgl. Pengambilan</th>
                            <th scope="col" class="px-6 py-3">Catatan Bapendik</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($suratPengantars as $index => $surat)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $loop->iteration + $suratPengantars->firstItem() - 1 }}
                                </td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($surat->tanggal_pengajuan)->isoFormat('D MMM YYYY') }}</td>
                                <td class="px-6 py-4">{{ Str::limit($surat->lokasi_penelitian, 40) }}</td>
                                <td class="px-6 py-4">{{ Str::limit($surat->penerima_surat, 30) }}</td>
                                <td class="px-6 py-4">
                                    @if($surat->status_bapendik == 'menunggu')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Menunggu Validasi</span>
                                    @elseif($surat->status_bapendik == 'disetujui')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Disetujui</span>
                                    @elseif($surat->status_bapendik == 'ditolak')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $surat->tanggal_pengambilan ? \Carbon\Carbon::parse($surat->tanggal_pengambilan)->isoFormat('D MMM YYYY') : '-' }}</td>
                                <td class="px-6 py-4 prose prose-sm dark:prose-invert max-w-xs">{!! nl2br(e($surat->catatan_bapendik ?? '-')) !!}</td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada riwayat pengajuan surat pengantar. Silakan buat pengajuan baru.
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

    {{-- Modal sukses akan dipanggil jika ada flash message 'success_modal_message' dari controller --}}
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
