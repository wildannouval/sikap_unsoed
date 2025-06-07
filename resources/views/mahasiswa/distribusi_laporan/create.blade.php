{{-- resources/views/mahasiswa/distribusi_laporan/create.blade.php --}}
@extends('main.app')

@section('title', 'Upload Bukti Distribusi Laporan KP')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Container konsisten --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Upload Bukti Distribusi Laporan Kerja Praktek</h2>
                </div>

                <div class="p-4 sm:p-6">
                    <div class="mb-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/30">
                        {{-- ... (Detail KP seperti di respons sebelumnya) ... --}}
                        <h3 class="text-md font-semibold text-gray-800 dark:text-white mb-2">Detail Kerja Praktek:</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Judul KP:</span>
                                <span class="text-gray-700 dark:text-gray-200 ml-1">{{ $pengajuanKp->judul_kp }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Instansi:</span>
                                <span class="text-gray-700 dark:text-gray-200 ml-1">{{ $pengajuanKp->instansi_lokasi }}</span>
                            </div>
                            @if($pengajuanKp->seminars->where('status_pengajuan', 'selesai_dinilai')->first())
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Status Seminar:</span>
                                    <span class="text-green-600 dark:text-green-400 ml-1">Selesai Dinilai</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @include('partials.session-messages') {{-- Untuk error validasi --}}

                    <form action="{{ route('mahasiswa.pengajuan-kp.distribusi.store', $pengajuanKp->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- ... (Field form: berkas_distribusi, tanggal_distribusi, catatan_mahasiswa seperti sebelumnya) ... --}}
                        <div class="grid gap-6 mb-6">
                            <div>
                                <label for="berkas_distribusi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">File Bukti Distribusi <span class="text-red-500">*</span></label>
                                <input type="file" name="berkas_distribusi" id="berkas_distribusi" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('berkas_distribusi') border-red-500 @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">Tipe file yang diterima: PDF, JPG, PNG (Max. 2MB).</p>
                                @error('berkas_distribusi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="tanggal_distribusi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Distribusi Dilakukan <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_distribusi" id="tanggal_distribusi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full md:w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('tanggal_distribusi') border-red-500 @enderror" value="{{ old('tanggal_distribusi', date('Y-m-d')) }}" required>
                                @error('tanggal_distribusi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="catatan_mahasiswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan Tambahan (Opsional)</label>
                                <textarea name="catatan_mahasiswa" id="catatan_mahasiswa" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('catatan_mahasiswa') border-red-500 @enderror" placeholder="Contoh: Diserahkan ke bagian layanan akademik perpustakaan pusat...">{{ old('catatan_mahasiswa') }}</textarea>
                                @error('catatan_mahasiswa') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            {{-- ... (Tombol Submit dan Batal seperti sebelumnya) ... --}}
                            <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                                <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M15.172 7.172a1 1 0 012.828 0l1.414 1.414a1 1 0 010 1.414l-1.414 1.414a1 1 0 01-1.414 0l-1.414-1.414a1 1 0 010-1.414l1.414-1.414zM10 2.586l4.293 4.293a1 1 0 11-1.414 1.414L10 5.414 7.121 8.293a1 1 0 01-1.414 0L2.293 4.879A1 1 0 013.707 3.464L10 9.757l6.293-6.293a1 1 0 011.414 0L20 6.172a1.001 1.001 0 010 1.414l-2.414 2.414a1 1 0 01-.707.293H8.828a1 1 0 01-.707-.293L3.414 5.121A1 1 0 013.414 3.707L6.293.879a1 1 0 011.414 0L10 2.586Z"/></svg>
                                Upload Bukti
                            </button>
                            <a href="{{ route('mahasiswa.distribusi-laporan.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                                <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
