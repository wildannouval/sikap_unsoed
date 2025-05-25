@extends('main.app')

@section('title', 'Edit Jurusan')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-4">Edit Jurusan</h2>
                <form action="{{ route('bapendik.jurusan.update', $jurusan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <label for="kode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Jurusan</label>
                            <input type="text" name="kode" id="kode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('kode') border-red-500 @enderror" value="{{ old('kode', $jurusan->kode) }}" required>
                            @error('kode') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Jurusan</label>
                            <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nama') border-red-500 @enderror" value="{{ old('nama', $jurusan->nama) }}" required>
                            @error('nama') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="fakultas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fakultas</label>
                            <input type="text" name="fakultas" id="fakultas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('fakultas') border-red-500 @enderror" value="{{ old('fakultas', $jurusan->fakultas) }}" required>
                            @error('fakultas') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="jenjang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenjang</label>
                            <input type="text" name="jenjang" id="jenjang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('jenjang') border-red-500 @enderror" value="{{ old('jenjang', $jurusan->jenjang) }}" required>
                            @error('jenjang') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Update
                    </button>
                    <a href="{{ route('bapendik.jurusan.index') }}" class="text-gray-900 dark:text-white inline-flex items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600 dark:border-gray-600">
                        Batal
                    </a>
                </form>
            </div>
        </div>
    </section>
@endsection
