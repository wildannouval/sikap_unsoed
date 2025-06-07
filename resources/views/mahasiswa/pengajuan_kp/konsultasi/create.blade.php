@extends('main.app')

@section('title', 'Tambah Catatan Konsultasi KP')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Container konsisten --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Tambah Catatan Konsultasi</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Untuk KP Judul: {{ $pengajuanKp->judul_kp }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dosen Pembimbing: {{ $pengajuanKp->dosenPembimbing->user->name ?? 'N/A' }}</p>
                </div>

                <form action="{{ route('mahasiswa.pengajuan-kp.konsultasi.store', $pengajuanKp->id) }}" method="POST" class="p-4 sm:p-6">
                    @csrf
                    <div class="px-0 pb-4">
                        @include('partials.session-messages') {{-- Untuk error validasi form --}}
                    </div>

                    <div class="grid gap-6 mb-6">
                        <div>
                            <label for="tanggal_konsultasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Konsultasi <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_konsultasi" id="tanggal_konsultasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full md:w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('tanggal_konsultasi') border-red-500 @enderror" value="{{ old('tanggal_konsultasi', date('Y-m-d')) }}" required>
                            @error('tanggal_konsultasi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="topik_konsultasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Topik yang Dikonsultasikan <span class="text-red-500">*</span></label>
                            <input type="text" name="topik_konsultasi" id="topik_konsultasi" placeholder="Misal: Pembahasan Bab 1, Revisi Desain Database" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('topik_konsultasi') border-red-500 @enderror" value="{{ old('topik_konsultasi') }}" required>
                            @error('topik_konsultasi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="hasil_konsultasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hasil/Arahan Konsultasi (catatan dari mahasiswa) <span class="text-red-500">*</span></label>
                            <textarea name="hasil_konsultasi" id="hasil_konsultasi" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('hasil_konsultasi') border-red-500 @enderror" placeholder="Tuliskan poin-poin penting, arahan dari dosen, atau revisi yang perlu dilakukan..." required>{{ old('hasil_konsultasi') }}</textarea>
                            @error('hasil_konsultasi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Simpan Catatan
                        </button>
                        <a href="{{ route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKp->id) }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
