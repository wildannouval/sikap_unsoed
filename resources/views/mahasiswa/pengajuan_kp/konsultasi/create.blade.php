@extends('main.app')

@section('title', 'Tambah Catatan Konsultasi KP')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-md px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-4">
                <div class="border-b pb-4 mb-4 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Tambah Catatan Konsultasi</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Untuk KP Judul: {{ $pengajuanKp->judul_kp }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dosen Pembimbing: {{ $pengajuanKp->dosenPembimbing->user->name ?? 'N/A' }}</p>
                </div>

                <form action="{{ route('mahasiswa.pengajuan-kp.konsultasi.store', $pengajuanKp->id) }}" method="POST">
                    @csrf
                    <div class="grid gap-6 mb-6">
                        <div>
                            <label for="tanggal_konsultasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Konsultasi <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_konsultasi" id="tanggal_konsultasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tanggal_konsultasi', date('Y-m-d')) }}" required>
                            @error('tanggal_konsultasi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="topik_konsultasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Topik yang Dikonsultasikan <span class="text-red-500">*</span></label>
                            <input type="text" name="topik_konsultasi" id="topik_konsultasi" placeholder="Misal: Pembahasan Bab 1, Revisi Desain Database" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('topik_konsultasi') }}" required>
                            @error('topik_konsultasi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="hasil_konsultasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hasil/Arahan Konsultasi (catatan dari mahasiswa) <span class="text-red-500">*</span></label>
                            <textarea name="hasil_konsultasi" id="hasil_konsultasi" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Tuliskan poin-poin penting, arahan dari dosen, atau revisi yang perlu dilakukan..." required>{{ old('hasil_konsultasi') }}</textarea>
                            @error('hasil_konsultasi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan Catatan
                        </button>
                        <a href="{{ route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKp->id) }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
