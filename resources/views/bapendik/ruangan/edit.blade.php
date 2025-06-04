@extends('main.app')

@section('title', 'Edit Ruangan Seminar - ' . $ruangan->nama_ruangan)

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-lg px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Data Ruangan Seminar: {{ $ruangan->nama_ruangan }}</h2>
                </div>

                <form action="{{ route('bapendik.ruangan.update', $ruangan->id) }}" method="POST" class="p-4 sm:p-6">
                    @csrf
                    @method('PUT') {{-- Method untuk update --}}
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label for="nama_ruangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Ruangan <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_ruangan" id="nama_ruangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nama_ruangan') border-red-500 @enderror" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}" required>
                            @error('nama_ruangan') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="lokasi_gedung" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lokasi/Gedung</label>
                            <input type="text" name="lokasi_gedung" id="lokasi_gedung" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('lokasi_gedung', $ruangan->lokasi_gedung) }}" placeholder="Contoh: Gedung F, Lantai 2">
                            @error('lokasi_gedung') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="kapasitas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kapasitas (Orang)</label>
                            <input type="number" name="kapasitas" id="kapasitas" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('kapasitas', $ruangan->kapasitas) }}" placeholder="Contoh: 50">
                            @error('kapasitas') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="fasilitas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fasilitas</label>
                            <textarea name="fasilitas" id="fasilitas" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Contoh: AC, Proyektor, Papan Tulis, Sound System">{{ old('fasilitas', $ruangan->fasilitas) }}</textarea>
                            @error('fasilitas') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="is_tersedia" class="flex items-center cursor-pointer">
                                <input id="is_tersedia" name="is_tersedia" type="checkbox" value="1" class="sr-only peer" {{ old('is_tersedia', $ruangan->is_tersedia) ? 'checked' : '' }}>
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Tandai sebagai Tersedia</span>
                            </label>
                            @error('is_tersedia') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 mt-8">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Update Ruangan
                        </button>
                        <a href="{{ route('bapendik.ruangan.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
