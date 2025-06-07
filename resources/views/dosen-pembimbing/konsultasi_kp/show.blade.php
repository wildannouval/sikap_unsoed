@extends('main.app')

@section('title', 'Detail Konsultasi KP - ' . Str::limit($pengajuanKp->mahasiswa->user->name ?? '', 20))

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            {{-- Detail Pengajuan KP (Tetap Sama) --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden mb-6">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Kerja Praktek Mahasiswa</h2>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm mb-4">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Nama Mahasiswa:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->mahasiswa->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">NIM:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->mahasiswa->nim ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500 dark:text-gray-400">Judul Kerja Praktek:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->judul_kp }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Jurusan:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->mahasiswa->jurusan->nama ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Instansi:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->instansi_lokasi }}</p>
                        </div>
                    </div>
                    <a href="{{ route('dosen-pembimbing.bimbingan-kp.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-2 -ml-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0l4 4M1 5l4-4"/></svg>
                        Kembali ke Daftar Bimbingan
                    </a>
                </div>
            </div>

            {{-- Daftar Konsultasi (Diubah menjadi Tabel) --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat & Verifikasi Konsultasi</h2>
                    {{-- Tidak ada tombol tambah, mahasiswa yang menambah --}}
                </div>

                <div class="px-4 pt-4">
                    @include('partials.session-messages') {{-- Untuk modal sukses setelah verifikasi --}}
                </div>

                <div class="overflow-x-auto">
                    @if($konsultasis->isEmpty())
                        <p class="p-6 text-center text-gray-500 dark:text-gray-400">Belum ada catatan konsultasi dari mahasiswa untuk KP ini.</p>
                    @else
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Tgl. Konsul</th>
                                <th scope="col" class="px-6 py-3">Topik (Mhs)</th>
                                <th scope="col" class="px-6 py-3">Isi (Mhs)</th>
                                <th scope="col" class="px-6 py-3">Catatan Anda</th>
                                <th scope="col" class="px-6 py-3">Status Verifikasi</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($konsultasis as $konsultasi)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 align-top whitespace-nowrap">{{ \Carbon\Carbon::parse($konsultasi->tanggal_konsultasi)->isoFormat('D MMM YY') }}</td>
                                    <td class="px-6 py-4 align-top font-medium text-gray-900 dark:text-white">{{ Str::limit($konsultasi->topik_konsultasi, 40) }}</td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="prose prose-sm dark:prose-invert max-w-sm">{!! nl2br(e(Str::limit($konsultasi->hasil_konsultasi, 100))) !!}</div>
                                        @if(strlen($konsultasi->hasil_konsultasi) > 100)
                                            <button type="button" data-modal-target="detailKonsultasiModal" data-modal-toggle="detailKonsultasiModal"
                                                    data-topik="{{ $konsultasi->topik_konsultasi }}"
                                                    data-isi="{{ $konsultasi->hasil_konsultasi }}"
                                                    class="text-xs text-blue-600 dark:text-blue-500 hover:underline mt-1">Lihat Selengkapnya</button>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="prose prose-sm dark:prose-invert max-w-sm">{!! nl2br(e(Str::limit($konsultasi->catatan_dosen, 100) ?? '-')) !!}</div>
                                        @if(strlen($konsultasi->catatan_dosen) > 100)
                                            <button type="button" data-modal-target="detailCatatanDosenModal" data-modal-toggle="detailCatatanDosenModal"
                                                    data-catatan-dosen-full="{{ $konsultasi->catatan_dosen }}"
                                                    class="text-xs text-blue-600 dark:text-blue-500 hover:underline mt-1">Lihat Selengkapnya</button>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        @if($konsultasi->diverifikasi)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                            Diverifikasi
                                            @if($konsultasi->tanggal_verifikasi)
                                                    <br><span class="text-[10px]">({{ \Carbon\Carbon::parse($konsultasi->tanggal_verifikasi)->isoFormat('D MMM YY, HH:mm') }})</span>
                                                @endif
                                        </span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Belum Diverifikasi</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-top text-center">
                                        <button type="button"
                                                data-modal-target="verifikasiKonsultasiModal"
                                                data-modal-toggle="verifikasiKonsultasiModal"
                                                data-konsultasi-id="{{ $konsultasi->id }}"
                                                data-catatan-dosen="{{ $konsultasi->catatan_dosen ?? '' }}"
                                                data-is-verified="{{ $konsultasi->diverifikasi ? '1' : '0' }}"
                                                data-action-url="{{ route('dosen-pembimbing.konsultasi.verifikasi', $konsultasi->id) }}"
                                                class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-150">
                                            <svg class="w-3.5 h-3.5 mr-1.5 -ml-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                            {{ $konsultasi->diverifikasi || $konsultasi->catatan_dosen ? 'Edit' : 'Proses' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                @if(!$konsultasis->isEmpty())
                    <nav class="p-4" aria-label="Table navigation">
                        {{ $konsultasis->links() }}
                    </nav>
                @endif
            </div>
        </div>
    </section>

    {{-- Modal untuk Verifikasi/Edit Konsultasi --}}
    @include('partials.modal-verifikasi-konsultasi') {{-- Pastikan ID modal di sini adalah verifikasiKonsultasiModal --}}

    {{-- Modal untuk Melihat Detail Isi Konsultasi Mahasiswa --}}
    <div id="detailKonsultasiModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 id="detailKonsultasiModalTitle" class="text-lg font-semibold text-gray-900 dark:text-white">Detail Isi Konsultasi</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detailKonsultasiModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <div id="detailKonsultasiModalContent" class="prose dark:prose-invert max-w-none whitespace-pre-wrap"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk Melihat Detail Catatan Dosen --}}
    <div id="detailCatatanDosenModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Catatan Dosen</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="detailCatatanDosenModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <div id="detailCatatanDosenModalContent" class="prose dark:prose-invert max-w-none whitespace-pre-wrap"></div>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal sukses --}}
    @if(session('success_modal_message'))
        @include('partials.modal-success')
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Script untuk Modal Verifikasi Konsultasi (sama seperti sebelumnya)
            const verifikasiModalEl = document.getElementById('verifikasiKonsultasiModal');
            if (verifikasiModalEl) {
                const verifikasiForm = document.getElementById('verifikasiForm');
                const modalCatatanDosen = document.getElementById('modal_catatan_dosen');
                const modalDiverifikasiCheckbox = document.getElementById('modal_diverifikasi');

                document.querySelectorAll('button[data-modal-toggle="verifikasiKonsultasiModal"]').forEach(button => {
                    button.addEventListener('click', function () {
                        const catatanDosen = this.dataset.catatanDosen;
                        const isVerified = this.dataset.isVerified === '1';
                        const actionUrl = this.dataset.actionUrl;

                        if(verifikasiForm) verifikasiForm.action = actionUrl;
                        if(modalCatatanDosen) modalCatatanDosen.value = catatanDosen;
                        if(modalDiverifikasiCheckbox) modalDiverifikasiCheckbox.checked = isVerified;
                        // Jika menggunakan instance Modal Flowbite, Anda bisa memanggil .show() di sini jika diperlukan
                        // const modal = new Modal(verifikasiModalEl); modal.show();
                    });
                });
            }

            // Script untuk Modal Detail Isi Konsultasi Mahasiswa
            const detailKonsultasiModalEl = document.getElementById('detailKonsultasiModal');
            if (detailKonsultasiModalEl) {
                const detailKonsultasiModalContent = document.getElementById('detailKonsultasiModalContent');
                const detailKonsultasiModalTitle = document.getElementById('detailKonsultasiModalTitle');
                document.querySelectorAll('button[data-modal-toggle="detailKonsultasiModal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const topik = this.dataset.topik;
                        const isi = this.dataset.isi;
                        if(detailKonsultasiModalTitle) detailKonsultasiModalTitle.textContent = "Detail Konsultasi: " + topik;
                        if(detailKonsultasiModalContent) detailKonsultasiModalContent.innerHTML = isi.replace(/\n/g, '<br>');
                    });
                });
            }

            // Script untuk Modal Detail Catatan Dosen
            const detailCatatanDosenModalEl = document.getElementById('detailCatatanDosenModal');
            if (detailCatatanDosenModalEl) {
                const detailCatatanDosenModalContent = document.getElementById('detailCatatanDosenModalContent');
                document.querySelectorAll('button[data-modal-toggle="detailCatatanDosenModal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const catatanFull = this.dataset.catatanDosenFull;
                        if(detailCatatanDosenModalContent) detailCatatanDosenModalContent.innerHTML = catatanFull.replace(/\n/g, '<br>');
                    });
                });
            }


            // Script untuk Modal Sukses (sama seperti sebelumnya)
            @if(session('success_modal_message'))
            const successModalEl = document.getElementById('successModal');
            const successModalMessageEl = document.getElementById('successModalMessage');
            if (successModalEl && successModalMessageEl) {
                successModalMessageEl.textContent = @json(session('success_modal_message'));
                if(typeof Modal !== 'undefined'){
                    const successModal = new Modal(successModalEl, {});
                    successModal.show();
                } else {
                    console.error('Flowbite Modal class tidak ditemukan untuk successModal.');
                }
            }
            @endif
        });
    </script>
@endpush
