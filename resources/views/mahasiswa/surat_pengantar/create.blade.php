@extends('main.app')

@section('title', 'Buat Pengajuan Surat Pengantar KP')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Container konsisten --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Form Pengajuan Surat Pengantar Kerja Praktek</h2>
                </div>

                <form action="{{ route('mahasiswa.surat-pengantar.store') }}" method="POST" class="p-4 sm:p-6">
                    @csrf
                    {{-- Menampilkan error validasi form --}}
                    <div class="pb-4">
                        @include('partials.session-messages')
                    </div>

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label for="lokasi_penelitian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Instansi/Perusahaan Tujuan KP <span class="text-red-500">*</span></label>
                            <input type="text" name="lokasi_penelitian" id="lokasi_penelitian" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('lokasi_penelitian') border-red-500 @enderror" value="{{ old('lokasi_penelitian') }}" placeholder="Contoh: PT. Sinar Jaya Abadi" required>
                            @error('lokasi_penelitian') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="penerima_surat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Surat Ditujukan Kepada (Jabatan/Unit) <span class="text-red-500">*</span></label>
                            <input type="text" name="penerima_surat" id="penerima_surat" placeholder="Contoh: Manajer HRD, Kepala Divisi IT" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('penerima_surat') border-red-500 @enderror" value="{{ old('penerima_surat') }}" required>
                            @error('penerima_surat') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="tahun_akademik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Akademik Pengajuan <span class="text-red-500">*</span></label>
                            <input type="text" name="tahun_akademik" id="tahun_akademik" placeholder="Contoh: 2024/2025" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('tahun_akademik') border-red-500 @enderror" value="{{ old('tahun_akademik', now()->year . '/' . (now()->year + 1)) }}" required>
                            @error('tahun_akademik') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="alamat_surat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Lengkap Instansi Tujuan <span class="text-red-500">*</span></label>
                            <textarea name="alamat_surat" id="alamat_surat" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('alamat_surat') border-red-500 @enderror" placeholder="Jl. Nama Jalan No. X, Kota, Provinsi, Kode Pos" required>{{ old('alamat_surat') }}</textarea>
                            @error('alamat_surat') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="tembusan_surat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tembusan Surat (Jika Ada, pisahkan dengan koma jika lebih dari satu)</label>
                            <input type="text" name="tembusan_surat" id="tembusan_surat" placeholder="Contoh: Dekan Fakultas Teknik, Ketua Jurusan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('tembusan_surat') border-red-500 @enderror" value="{{ old('tembusan_surat') }}">
                            @error('tembusan_surat') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                            <svg class="h-4 w-4 mr-2 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" /></svg>
                            Kirim Pengajuan
                        </button>
                        <a href="{{ route('mahasiswa.surat-pengantar.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
