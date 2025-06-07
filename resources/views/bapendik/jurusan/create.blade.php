@extends('main.app')

@section('title', 'Tambah Jurusan Baru')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- CONTAINER BARU --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Tambah Jurusan Baru</h2>
                </div>

                <form action="{{ route('bapendik.jurusan.store') }}" method="POST" class="p-4 sm:p-6">
                    @csrf
                    <div class="grid gap-6 mb-6 sm:grid-cols-2">
                        <div>
                            <label for="kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Jurusan <span class="text-red-500">*</span></label>
                            <input type="text" name="kode" id="kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('kode') border-red-500 @enderror" value="{{ old('kode') }}" placeholder="Contoh: IF" required>
                            @error('kode') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Jurusan <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('nama') border-red-500 @enderror" value="{{ old('nama') }}" placeholder="Contoh: Teknik Informatika" required>
                            @error('nama') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="fakultas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fakultas <span class="text-red-500">*</span></label>
                            <input type="text" name="fakultas" id="fakultas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('fakultas') border-red-500 @enderror" value="{{ old('fakultas') }}" placeholder="Contoh: Fakultas Teknik" required>
                            @error('fakultas') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="jenjang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenjang <span class="text-red-500">*</span></label>
                            <input type="text" name="jenjang" id="jenjang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('jenjang') border-red-500 @enderror" value="{{ old('jenjang', 'S1') }}" placeholder="Contoh: S1, D3" required>
                            @error('jenjang') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        {{-- Tambahkan field 'akreditasi' jika masih ada di migrasi Jurusan --}}
                        {{--
                        <div>
                            <label for="akreditasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Akreditasi</label>
                            <input type="text" name="akreditasi" id="akreditasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('akreditasi') }}" placeholder="Contoh: A, Unggul">
                            @error('akreditasi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        --}}
                    </div>
                    <div class="flex items-center space-x-4 mt-8">
                        {{-- TOMBOL SIMPAN --}}
                        <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Simpan Jurusan
                        </button>
                        {{-- TOMBOL BATAL --}}
                        <a href="{{ route('bapendik.jurusan.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
