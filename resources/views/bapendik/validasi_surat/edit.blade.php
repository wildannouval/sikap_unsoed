@extends('main.app')

@section('title', 'Proses Validasi Surat Pengantar')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Container konsisten --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Detail & Validasi Pengajuan Surat Pengantar KP</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4 sm:p-6">
                    {{-- Kolom Kiri: Detail Pengajuan (Read-only) --}}
                    <div class="md:col-span-2 p-6 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Mahasiswa & Pengajuan</h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Nama Mahasiswa:</dt>
                                <dd class="text-gray-800 dark:text-gray-100 font-medium">{{ $suratPengantar->mahasiswa->user->name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">NIM:</dt>
                                <dd class="text-gray-800 dark:text-gray-100 font-medium">{{ $suratPengantar->mahasiswa->nim ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Jurusan:</dt>
                                <dd class="text-gray-800 dark:text-gray-100 font-medium">{{ $suratPengantar->mahasiswa->jurusan->nama ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Tanggal Pengajuan:</dt>
                                <dd class="text-gray-800 dark:text-gray-100 font-medium">{{ \Carbon\Carbon::parse($suratPengantar->tanggal_pengajuan)->isoFormat('D MMMM YYYY') }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-gray-500 dark:text-gray-400">Lokasi Penelitian/Instansi Tujuan:</dt>
                                <dd class="text-gray-800 dark:text-gray-100 font-medium">{{ $suratPengantar->lokasi_penelitian }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Ditujukan Kepada (Jabatan/Unit):</dt>
                                <dd class="text-gray-800 dark:text-gray-100 font-medium">{{ $suratPengantar->penerima_surat }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-gray-500 dark:text-gray-400">Alamat Instansi:</dt>
                                <dd class="text-gray-800 dark:text-gray-100 font-medium">{{ $suratPengantar->alamat_surat }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Tembusan:</dt>
                                <dd class="text-gray-800 dark:text-gray-100 font-medium">{{ $suratPengantar->tembusan_surat ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 dark:text-gray-400">Tahun Akademik:</dt>
                                <dd class="text-gray-800 dark:text-gray-100 font-medium">{{ $suratPengantar->tahun_akademik }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Kolom Kanan: Form Validasi --}}
                    <div class="md:col-span-1">
                        <form action="{{ route('bapendik.validasi-surat.update', $suratPengantar->id) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')
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
                                <label for="tanggal_pengambilan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pengambilan Surat (Jika Disetujui)</label>
                                <input type="date" name="tanggal_pengambilan" id="tanggal_pengambilan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tanggal_pengambilan', $suratPengantar->tanggal_pengambilan ? \Carbon\Carbon::parse($suratPengantar->tanggal_pengambilan)->format('Y-m-d') : '') }}">
                                @error('tanggal_pengambilan') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Opsional: Nomor Surat Resmi jika Bapendik input manual saat validasi --}}
                            {{--
                            <div>
                                <label for="nomor_surat_resmi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Surat Resmi (Jika ada)</label>
                                <input type="text" name="nomor_surat_resmi" id="nomor_surat_resmi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('nomor_surat_resmi', $suratPengantar->nomor_surat_resmi) }}" placeholder="Contoh: 123/UN23.12/KM/2025">
                                @error('nomor_surat_resmi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            --}}

                            <div>
                                <label for="catatan_bapendik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan Bapendik (Alasan jika ditolak, atau info tambahan)</label>
                                <textarea id="catatan_bapendik" name="catatan_bapendik" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ old('catatan_bapendik', $suratPengantar->catatan_bapendik) }}</textarea>
                                @error('catatan_bapendik') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex items-center space-x-4 pt-4">
                                <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Simpan Validasi
                                </button>
                                <a href="{{ route('bapendik.validasi-surat.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                                    Kembali
                                </a>
                            </div>
                            @if($suratPengantar->status_bapendik == 'disetujui')
                                <div class="pt-6 mt-6 border-t dark:border-gray-600">
                                    <a href="{{ route('bapendik.validasi-surat.exportWord', $suratPengantar->id) }}" class="w-full sm:w-auto text-white inline-flex items-center justify-center bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800 transition-colors duration-150" target="_blank">
                                        <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                                        Export Surat Pengantar ke Word
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- Script toggle field tanggal pengambilan tetap sama --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status_bapendik');
            const tanggalPengambilanDiv = document.getElementById('tanggal_pengambilan_div');
            const tanggalPengambilanInput = document.getElementById('tanggal_pengambilan');

            function toggleTanggalPengambilan() {
                if (statusSelect && tanggalPengambilanDiv && tanggalPengambilanInput) { // Tambah pengecekan elemen ada
                    if (statusSelect.value === 'disetujui') {
                        tanggalPengambilanDiv.style.display = 'block';
                        tanggalPengambilanInput.required = true;
                    } else {
                        tanggalPengambilanDiv.style.display = 'none';
                        tanggalPengambilanInput.required = false;
                    }
                }
            }
            if (statusSelect) {
                toggleTanggalPengambilan(); // Panggil saat halaman load
                statusSelect.addEventListener('change', toggleTanggalPengambilan);
            }
        });
    </script>
@endpush
