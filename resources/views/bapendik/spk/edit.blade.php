@extends('main.app')

@section('title', 'Proses SPK - ' . $pengajuanKp->mahasiswa->user->name)

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Proses Surat Perintah Kerja (SPK)</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4 sm:p-6">
                    {{-- Kolom Kiri: Detail Pengajuan (Read-only) --}}
                    <div class="md:col-span-2 p-6 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Pengajuan KP</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Nama Mahasiswa:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->mahasiswa->user->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">NIM:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->mahasiswa->nim ?? 'N/A' }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Judul KP:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->judul_kp }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Instansi:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->instansi_lokasi }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Dosen Pembimbing:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->dosenPembimbing->user->name ?? 'N/A' }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Periode Pelaksanaan KP:</p>
                                <p class="text-gray-900 dark:text-white font-medium">
                                    @if($pengajuanKp->tanggal_mulai && $pengajuanKp->tanggal_selesai)
                                        {{ \Carbon\Carbon::parse($pengajuanKp->tanggal_mulai)->isoFormat('D MMM YY') }} s.d. {{ \Carbon\Carbon::parse($pengajuanKp->tanggal_selesai)->isoFormat('D MMM YY') }}
                                    @else
                                        <span class="italic text-red-500">Periode belum lengkap, tidak bisa export SPK.</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Form Aksi SPK --}}
                    <div class="md:col-span-1">
                        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi SPK</h3>
                            <div class="space-y-6">
                                {{-- Tombol Export --}}
                                <div>
                                    <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">1. Generate Dokumen</p>
                                        <a href="{{ route('bapendik.spk.exportWord', $pengajuanKp->id) }}" class="w-full inline-flex items-center justify-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none dark:focus:ring-green-800 transition-colors duration-150" target="_blank">
                                            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                                            Export SPK ke Word
                                        </a>
                                </div>
                                <hr class="border-gray-300 dark:border-gray-600">

                                {{-- Form Update Status --}}
                                <form action="{{ route('bapendik.spk.update', $pengajuanKp->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="space-y-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                                        <p class="block text-sm font-medium text-gray-900 dark:text-white">2. Update Status</p>
                                        {{-- CHECKBOX BARU UNTUK STATUS CETAK --}}
                                        <div>
                                            <label for="spk_dicetak" class="flex items-center cursor-pointer">
                                                <input id="spk_dicetak" name="spk_dicetak" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ old('spk_dicetak', $pengajuanKp->spk_dicetak_at) ? 'checked' : '' }}>
                                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Tandai Sudah Dicetak</span>
                                            </label>
                                            @if($pengajuanKp->spk_dicetak_at)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 ml-7">Dicetak pada: {{ \Carbon\Carbon::parse($pengajuanKp->spk_dicetak_at)->isoFormat('D MMM YY, HH:mm') }}</p>
                                            @endif
                                        </div>
                                        {{-- TANGGAL PENGAMBILAN --}}
                                        <div id="tanggal_pengambilan_spk_div">
                                            <label for="spk_diambil_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pengambilan SPK <span id="wajib_tanggal" class="text-red-500" style="display:none;">*</span></label>
                                            <input type="date" name="spk_diambil_at" id="spk_diambil_at" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('spk_diambil_at', $pengajuanKp->spk_diambil_at ? \Carbon\Carbon::parse($pengajuanKp->spk_diambil_at)->format('Y-m-d') : '') }}">
                                            @error('spk_diambil_at') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                        {{-- CATATAN SPK --}}
                                        <div>
                                            <label for="catatan_spk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan SPK (Opsional)</label>
                                            <textarea id="catatan_spk" name="catatan_spk" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('catatan_spk', $pengajuanKp->catatan_spk) }}</textarea>
                                        </div>
                                        {{-- TOMBOL AKSI --}}
                                        <div class="flex items-center space-x-4 pt-4">
                                            <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Simpan Status
                                            </button>
                                            <a href="{{ route('bapendik.spk.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white">
                                                Kembali
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Opsional: JavaScript untuk membuat input tanggal pengambilan hanya muncul/wajib jika checkbox dicentang
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxCetak = document.getElementById('spk_dicetak');
            const tanggalDiv = document.getElementById('tanggal_pengambilan_spk_div');
            const wajibSpan = document.getElementById('wajib_tanggal');

            function toggleTanggalVisibility() {
                if (checkboxCetak.checked) {
                    tanggalDiv.style.display = 'block';
                    wajibSpan.style.display = 'inline';
                } else {
                    tanggalDiv.style.display = 'none'; // Sembunyikan jika tidak dicetak
                    wajibSpan.style.display = 'none';
                }
            }

            if (checkboxCetak) {
                toggleTanggalVisibility(); // Panggil saat halaman load
                checkboxCetak.addEventListener('change', toggleTanggalVisibility);
            }
        });
    </script>
@endpush
