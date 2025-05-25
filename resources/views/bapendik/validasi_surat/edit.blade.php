@extends('main.app')

@section('title', 'Proses Validasi Surat Pengantar')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-md px-4 lg:px-12"> {{-- max-w-screen-md agar tidak terlalu lebar --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-4 sm:p-6">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-6">Detail & Validasi Pengajuan Surat KP</h2>

                {{-- Detail Pengajuan (Read-only) --}}
                <div class="mb-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Informasi Mahasiswa & Pengajuan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Nama Mahasiswa:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $suratPengantar->mahasiswa->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">NIM:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $suratPengantar->mahasiswa->nim ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Jurusan:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $suratPengantar->mahasiswa->jurusan->nama ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Tanggal Pengajuan:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ \Carbon\Carbon::parse($suratPengantar->tanggal_pengajuan)->isoFormat('D MMMM YYYY') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500 dark:text-gray-400">Lokasi Penelitian/Instansi Tujuan:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $suratPengantar->lokasi_penelitian }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Ditujukan Kepada (Jabatan):</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $suratPengantar->penerima_surat }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500 dark:text-gray-400">Alamat Instansi:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $suratPengantar->alamat_surat }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Tembusan:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $suratPengantar->tembusan_surat ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Tahun Akademik:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $suratPengantar->tahun_akademik }}</p>
                        </div>
                    </div>
                </div>

                {{-- Form Validasi --}}
                <form action="{{ route('bapendik.validasi-surat.update', $suratPengantar->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="status_bapendik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Validasi <span class="text-red-500">*</span></label>
                            <select id="status_bapendik" name="status_bapendik" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" required>
                                <option value="menunggu" {{ old('status_bapendik', $suratPengantar->status_bapendik) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="disetujui" {{ old('status_bapendik', $suratPengantar->status_bapendik) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ old('status_bapendik', $suratPengantar->status_bapendik) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status_bapendik') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div id="tanggal_pengambilan_div" style="{{ old('status_bapendik', $suratPengantar->status_bapendik) == 'disetujui' ? '' : 'display:none;' }}">
                            <label for="tanggal_pengambilan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pengambilan Surat</label>
                            <input type="date" name="tanggal_pengambilan" id="tanggal_pengambilan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tanggal_pengambilan', $suratPengantar->tanggal_pengambilan) }}">
                            @error('tanggal_pengambilan') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="catatan_bapendik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan Bapendik (Alasan jika ditolak, atau info tambahan)</label>
                        <textarea id="catatan_bapendik" name="catatan_bapendik" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('catatan_bapendik', $suratPengantar->catatan_bapendik) }}</textarea>
                        @error('catatan_bapendik') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan Validasi
                        </button>
                        <a href="{{ route('bapendik.validasi-surat.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            Kembali ke Daftar
                        </a>
                        @if($suratPengantar->status_bapendik == 'disetujui')
                            <a href="{{ route('bapendik.validasi-surat.exportWord', $suratPengantar->id) }}" class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 ml-4" target="_blank">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Export ke Word
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status_bapendik');
            const tanggalPengambilanDiv = document.getElementById('tanggal_pengambilan_div');
            const tanggalPengambilanInput = document.getElementById('tanggal_pengambilan');

            function toggleTanggalPengambilan() {
                if (statusSelect.value === 'disetujui') {
                    tanggalPengambilanDiv.style.display = 'block';
                    tanggalPengambilanInput.required = true;
                } else {
                    tanggalPengambilanDiv.style.display = 'none';
                    tanggalPengambilanInput.required = false;
                    // tanggalPengambilanInput.value = ''; // Opsional: kosongkan jika status bukan disetujui
                }
            }

            // Panggil saat halaman load
            toggleTanggalPengambilan();

            // Panggil saat pilihan status berubah
            statusSelect.addEventListener('change', toggleTanggalPengambilan);
        });
    </script>
@endpush
