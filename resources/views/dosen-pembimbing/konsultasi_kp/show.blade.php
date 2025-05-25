@extends('main.app')

@section('title', 'Detail Konsultasi KP - ' . Str::limit($pengajuanKp->mahasiswa->user->name ?? '', 20))

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            {{-- Detail Pengajuan KP (Tetap Sama) --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden mb-6">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Detail Kerja Praktek</h2>
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
                    </div>
                    <a href="{{ route('dosen-pembimbing.bimbingan-kp.index') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400">&laquo; Kembali ke Daftar Bimbingan</a>
                </div>
            </div>

            {{-- Daftar Konsultasi --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Riwayat & Verifikasi Konsultasi</h2>
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
                    @if($konsultasis->isEmpty())
                        <p class="p-4 text-center text-gray-500 dark:text-gray-400">Belum ada catatan konsultasi dari mahasiswa.</p>
                    @else
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Tanggal</th>
                                <th scope="col" class="px-4 py-3">Topik (Mhs)</th>
                                <th scope="col" class="px-4 py-3">Isi (Mhs)</th>
                                <th scope="col" class="px-4 py-3">Catatan Dosen</th>
                                <th scope="col" class="px-4 py-3">Status Verifikasi</th>
                                <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($konsultasis as $konsultasi)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="px-4 py-3 align-top">{{ \Carbon\Carbon::parse($konsultasi->tanggal_konsultasi)->isoFormat('D MMM YY') }}</td>
                                    <td class="px-4 py-3 align-top font-medium text-gray-900 dark:text-white">{{ $konsultasi->topik_konsultasi }}</td>
                                    <td class="px-4 py-3 align-top max-w-xs prose prose-sm dark:prose-invert">{!! nl2br(e($konsultasi->hasil_konsultasi)) !!}</td>
                                    <td class="px-4 py-3 align-top max-w-xs prose prose-sm dark:prose-invert">{!! nl2br(e($konsultasi->catatan_dosen ?? '-')) !!}</td>
                                    <td class="px-4 py-3 align-top">
                                        @if($konsultasi->diverifikasi)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                            Diverifikasi
                                            <br>
                                            <span class="text-xs">({{ \Carbon\Carbon::parse($konsultasi->tanggal_verifikasi)->isoFormat('D MMM YY, HH:mm') }})</span>
                                        </span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Belum Diverifikasi</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 align-top text-center">
                                        <button type="button"
                                                data-modal-target="verifikasiKonsultasiModal"
                                                data-modal-toggle="verifikasiKonsultasiModal"
                                                data-konsultasi-id="{{ $konsultasi->id }}"
                                                data-catatan-dosen="{{ $konsultasi->catatan_dosen ?? '' }}"
                                                data-is-verified="{{ $konsultasi->diverifikasi ? '1' : '0' }}"
                                                data-action-url="{{ route('dosen-pembimbing.konsultasi.verifikasi', $konsultasi->id) }}"
                                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800">
                                            Proses/Edit
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

    <div id="verifikasiKonsultasiModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        {{-- ⇑ DIV TERLUAR: Pastikan semua kelas ini ada: hidden, fixed, top-0, right-0, left-0, z-50, justify-center, items-center, w-full, md:inset-0 --}}

        <div class="relative p-4 w-full max-w-md max-h-full"> {{-- <-- GANTI 'max-w-2xl' DENGAN LEBAR YANG DIINGINKAN, misal 'max-w-lg' atau 'max-w-md' jika ingin lebih sempit --}}
            {{-- ⇑ DIV KEDUA: Ini yang menentukan lebar maksimal. Pastikan ada 'w-full' dan 'max-w-*'. --}}

            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Proses Verifikasi Konsultasi
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="verifikasiKonsultasiModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form id="verifikasiForm" action="" method="POST" class="p-4 md:p-5">
                    @csrf
                    {{-- Isi form (textarea catatan_dosen dan checkbox diverifikasi) --}}
                    <div class="mb-4">
                        <label for="modal_catatan_dosen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan Dosen Pembimbing:</label>
                        <textarea name="catatan_dosen" id="modal_catatan_dosen" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></textarea>
                    </div>
                    <div class="flex items-center mb-4">
                        <input id="modal_diverifikasi" name="diverifikasi" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="modal_diverifikasi" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Sudah Diverifikasi</label>
                    </div>
                    {{-- Tombol Simpan dan Batal --}}
                    <button type="submit" class="text-white inline-flex items-center bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">
                        Simpan Perubahan
                    </button>
                    <button type="button" class="ml-2 py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" data-modal-hide="verifikasiKonsultasiModal">
                        Batal
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const verifikasiModal = document.getElementById('verifikasiKonsultasiModal');
            const verifikasiForm = document.getElementById('verifikasiForm');
            const modalCatatanDosen = document.getElementById('modal_catatan_dosen');
            const modalDiverifikasiCheckbox = document.getElementById('modal_diverifikasi');

            // Menangani saat modal akan ditampilkan
            // Kita perlu event listener untuk semua tombol yang mentargetkan modal ini
            document.querySelectorAll('[data-modal-toggle="verifikasiKonsultasiModal"]').forEach(button => {
                button.addEventListener('click', function () {
                    const catatanDosen = this.dataset.catatanDosen;
                    const isVerified = this.dataset.isVerified === '1';
                    const actionUrl = this.dataset.actionUrl;

                    verifikasiForm.action = actionUrl;
                    modalCatatanDosen.value = catatanDosen;
                    modalDiverifikasiCheckbox.checked = isVerified;
                });
            });
        });
    </script>
@endpush
