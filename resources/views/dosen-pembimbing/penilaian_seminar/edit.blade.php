@extends('main.app')

@section('title', $seminar->status_pengajuan == 'selesai_dinilai' ? 'Edit Hasil Seminar' : 'Input Hasil Seminar')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-lg px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">
                        {{ $seminar->status_pengajuan == 'selesai_dinilai' ? 'Edit Hasil Seminar KP' : 'Input Hasil Seminar KP' }}
                    </h2>
                </div>

                {{-- Detail Seminar (Read-only) --}}
                <div class="p-4 sm:p-6 mb-6 border-b dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Detail Seminar</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Nama Mahasiswa:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $seminar->mahasiswa->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">NIM:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $seminar->mahasiswa->nim ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500 dark:text-gray-400">Judul KP Final:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $seminar->judul_kp_final }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Jadwal Seminar:</p>
                            <p class="text-gray-900 dark:text-white font-medium">
                                {{ $seminar->tanggal_seminar ? \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('dddd, D MMMM YYYY') : 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Waktu & Ruangan:</p>
                            <p class="text-gray-900 dark:text-white font-medium">
                                {{ $seminar->jam_mulai ? \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') : '' }}
                                {{ $seminar->jam_selesai ? ' - ' . \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '' }}
                                (Ruang: {{ $seminar->ruangan ?? 'N/A' }})
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Draft Laporan KP Mahasiswa:</p>
                            @if($seminar->draft_laporan_path)
                                <a href="{{ Storage::url($seminar->draft_laporan_path) }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400 underline">Lihat Draft</a>
                            @else
                                <p class="text-gray-900 dark:text-white font-medium">-</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Form Input Hasil Seminar --}}
                <form action="{{ route('dosen-pembimbing.penilaian-seminar.updateHasil', $seminar->id) }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6">
                    @csrf
                    @method('PUT')
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Formulir Penilaian Seminar</h3>

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="nilai_seminar_angka" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai Seminar (Angka 0-100) <span class="text-red-500">*</span></label>
                            <input type="number" name="nilai_seminar_angka" id="nilai_seminar_angka" step="0.01" min="0" max="100" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('nilai_seminar_angka', $seminar->nilai_seminar_angka) }}" required>
                            @error('nilai_seminar_angka') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="catatan_hasil_seminar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan Hasil Seminar (Revisi, dll)</label>
                        <textarea id="catatan_hasil_seminar" name="catatan_hasil_seminar" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600">{{ old('catatan_hasil_seminar', $seminar->catatan_hasil_seminar) }}</textarea>
                        @error('catatan_hasil_seminar') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="berita_acara_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload File Berita Acara Seminar (PDF/JPG/PNG, max 2MB)</label>
                        <input type="file" name="berita_acara_file" id="berita_acara_file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept=".pdf,.jpg,.jpeg,.png">
                        @error('berita_acara_file') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        @if($seminar->berita_acara_path)
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                File saat ini: <a href="{{ Storage::url($seminar->berita_acara_path) }}" target="_blank" class="text-blue-600 hover:underline">{{ Str::afterLast($seminar->berita_acara_path, '/') }}</a>
                                (Upload file baru untuk mengganti)
                            </p>
                        @endif
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan Hasil Seminar
                        </button>
                        <a href="{{ route('dosen-pembimbing.penilaian-seminar.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
