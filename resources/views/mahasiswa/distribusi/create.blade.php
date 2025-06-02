@extends('main.app')

@section('title', 'Upload Bukti Distribusi Laporan KP')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-lg px-4 lg:px-12"> <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Upload Bukti Distribusi Laporan Kerja Praktek</h2>
                </div>

                <div class="p-4 sm:p-6">
                    {{-- Informasi Pengajuan KP --}}
                    <div class="mb-6 p-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/30">
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

                    @if (session('error'))
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('mahasiswa.pengajuan-kp.distribusi.store', $pengajuanKp->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid gap-6 mb-6">
                            <div>
                                <label for="berkas_distribusi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">File Bukti Distribusi <span class="text-red-500">*</span></label>
                                <input type="file" name="berkas_distribusi" id="berkas_distribusi" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept=".pdf,.jpg,.jpeg,.png" required>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-300">Tipe file yang diterima: PDF, JPG, PNG (Max. 2MB).</p>
                                @error('berkas_distribusi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="tanggal_distribusi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Distribusi Dilakukan <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_distribusi" id="tanggal_distribusi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tanggal_distribusi', date('Y-m-d')) }}" required>
                                @error('tanggal_distribusi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="catatan_mahasiswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan Tambahan (Opsional)</label>
                                <textarea name="catatan_mahasiswa" id="catatan_mahasiswa" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Contoh: Diserahkan ke bagian layanan akademik perpustakaan pusat...">{{ old('catatan_mahasiswa') }}</textarea>
                                @error('catatan_mahasiswa') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center space-x-4 mt-8">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Upload Bukti
                            </button>
                            <a href="{{ route('mahasiswa.pengajuan-kp.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
