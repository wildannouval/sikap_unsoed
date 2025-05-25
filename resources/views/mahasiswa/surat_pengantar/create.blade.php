@extends('main.app')

@section('title', 'Buat Pengajuan Surat Pengantar')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-6">Form Pengajuan Surat Pengantar KP</h2>
                <form action="{{ route('mahasiswa.surat-pengantar.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="lokasi_penelitian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Instansi/Perusahaan Tujuan KP <span class="text-red-500">*</span></label>
                            <input type="text" name="lokasi_penelitian" id="lokasi_penelitian" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('lokasi_penelitian') }}" required>
                            @error('lokasi_penelitian') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="penerima_surat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Surat Ditujukan Kepada (Jabatan) <span class="text-red-500">*</span></label>
                            <input type="text" name="penerima_surat" id="penerima_surat" placeholder="Contoh: Kepala HRD, Manajer Proyek" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('penerima_surat') }}" required>
                            @error('penerima_surat') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-2">
                            <label for="alamat_surat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Lengkap Instansi Tujuan <span class="text-red-500">*</span></label>
                            <textarea name="alamat_surat" id="alamat_surat" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>{{ old('alamat_surat') }}</textarea>
                            @error('alamat_surat') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="tembusan_surat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tembusan Surat (Jika Ada)</label>
                            <input type="text" name="tembusan_surat" id="tembusan_surat" placeholder="Contoh: Dekan Fakultas Teknik" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('tembusan_surat') }}">
                            @error('tembusan_surat') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="tahun_akademik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Akademik Pengajuan <span class="text-red-500">*</span></label>
                            <input type="text" name="tahun_akademik" id="tahun_akademik" placeholder="Contoh: 2024/2025" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('tahun_akademik', now()->year . '/' . (now()->year + 1)) }}" required>
                            @error('tahun_akademik') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Kirim Pengajuan
                        </button>
                        <a href="{{ route('mahasiswa.surat-pengantar.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
