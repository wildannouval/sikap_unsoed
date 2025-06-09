@extends('main.app')

@section('title', 'Edit Jurusan - ' . $jurusan->nama)

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Data Jurusan: {{ $jurusan->nama }}</h2>
                </div>

                <form action="{{ route('bapendik.jurusan.update', $jurusan->id) }}" method="POST" class="p-4 sm:p-6">
                    @csrf
                    @method('PUT') {{-- Method untuk update --}}
                    <div class="grid gap-6 mb-6 sm:grid-cols-2">
                        <div>
                            <label for="kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Jurusan <span class="text-red-500">*</span></label>
                            <input type="text" name="kode" id="kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('kode') border-red-500 @enderror" value="{{ old('kode', $jurusan->kode) }}" required>
                            @error('kode') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Jurusan <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('nama') border-red-500 @enderror" value="{{ old('nama', $jurusan->nama) }}" required>
                            @error('nama') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="fakultas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fakultas <span class="text-red-500">*</span></label>
                            <input type="text" name="fakultas" id="fakultas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('fakultas') border-red-500 @enderror" value="{{ old('fakultas', $jurusan->fakultas) }}" required>
                            @error('fakultas') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="jenjang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenjang <span class="text-red-500">*</span></label>
                            <input type="text" name="jenjang" id="jenjang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('jenjang') border-red-500 @enderror" value="{{ old('jenjang', $jurusan->jenjang) }}" required>
                            @error('jenjang') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
{{--                        <div>--}}
{{--                            <label for="akreditasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Akreditasi</label>--}}
{{--                            <input type="text" name="akreditasi" id="akreditasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('akreditasi', $jurusan->akreditasi) }}" placeholder="Contoh: A, Unggul">--}}
{{--                            @error('akreditasi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror--}}
{{--                        </div>--}}
                    </div>
                    <div class="flex items-center space-x-4 mt-8">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Update Jurusan
                        </button>
                        <a href="{{ route('bapendik.jurusan.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
