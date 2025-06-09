@extends('main.app')

@section('title', 'Ajukan Seminar Kerja Praktek')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Form Pengajuan Seminar Kerja Praktek</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Untuk KP Judul: <span class="font-medium">{{ $pengajuanKp->judul_kp }}</span></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dosen Pembimbing: <span class="font-medium">{{ $pengajuanKp->dosenPembimbing->user->name ?? 'N/A' }}</span></p>
                    <p class="text-sm text-green-600 dark:text-green-400">Jumlah konsultasi terverifikasi: <span class="font-semibold">{{ $jumlahKonsultasiVerified }}</span> (Minimal: {{ \App\Http\Controllers\Mahasiswa\SeminarKpController::MIN_KONSULTASI_VERIFIED }})</p>
                </div>

                <form action="{{ route('mahasiswa.pengajuan-kp.seminar.store', $pengajuanKp->id) }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6">
                    @csrf
                    <div class="px-0 pb-4">
                        @include('partials.session-messages')
                    </div>

                    <div class="grid gap-6 mb-6">
                        <div>
                            <label for="judul_kp_final" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Final Kerja Praktek <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_kp_final" id="judul_kp_final" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('judul_kp_final') border-red-500 @enderror" value="{{ old('judul_kp_final', $pengajuanKp->judul_kp) }}" required>
                            @error('judul_kp_final') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="draft_laporan_path" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Draft Laporan Akhir KP (PDF, max 5MB) <span class="text-red-500">*</span></label>
                            <input type="file" name="draft_laporan_path" id="draft_laporan_path" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('draft_laporan_path') border-red-500 @enderror" accept=".pdf" required>
                            @error('draft_laporan_path') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <hr class="my-6 border-gray-300 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Usulan Jadwal Seminar</h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-4">Mohon koordinasikan terlebih dahulu dengan Dosen Pembimbing Anda dan cek ketersediaan ruangan sebelum mengusulkan jadwal.</p>

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="usulan_tanggal_seminar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usulan Tanggal Seminar <span class="text-red-500">*</span></label>
                            <input type="date" name="usulan_tanggal_seminar" id="usulan_tanggal_seminar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('usulan_tanggal_seminar') border-red-500 @enderror" value="{{ old('usulan_tanggal_seminar') }}" required>
                            @error('usulan_tanggal_seminar') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="usulan_ruangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usulan Ruangan <span class="text-red-500">*</span></label>
                            <select name="usulan_ruangan" id="usulan_ruangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('usulan_ruangan') border-red-500 @enderror" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @if(isset($daftarRuangan) && $daftarRuangan->count() > 0)
                                    @foreach ($daftarRuangan as $ruangan)
                                        <option value="{{ $ruangan->nama_ruangan }}" {{ old('usulan_ruangan') == $ruangan->nama_ruangan ? 'selected' : '' }}>
                                            {{ $ruangan->nama_ruangan }} {{ $ruangan->lokasi_gedung ? '('.$ruangan->lokasi_gedung.')' : '' }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>Data ruangan belum tersedia</option>
                                @endif
                            </select>
                            @error('usulan_ruangan') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="usulan_jam_mulai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usulan Jam Mulai <span class="text-red-500">*</span></label>
                            <input type="time" name="usulan_jam_mulai" id="usulan_jam_mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('usulan_jam_mulai') border-red-500 @enderror" value="{{ old('usulan_jam_mulai') }}" required>
                            @error('usulan_jam_mulai') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="usulan_jam_selesai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usulan Jam Selesai <span class="text-red-500">*</span></label>
                            <input type="time" name="usulan_jam_selesai" id="usulan_jam_selesai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('usulan_jam_selesai') border-red-500 @enderror" value="{{ old('usulan_jam_selesai') }}" required>
                            @error('usulan_jam_selesai') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="catatan_mahasiswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan Tambahan untuk Penjadwal (Opsional)</label>
                        <textarea name="catatan_mahasiswa" id="catatan_mahasiswa" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('catatan_mahasiswa') border-red-500 @enderror" placeholder="Misal: preferensi waktu tertentu, atau info tambahan...">{{ old('catatan_mahasiswa') }}</textarea>
                        @error('catatan_mahasiswa') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center space-x-4 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.428A1 1 0 008 16.171V11.83l5.707 5.707a1 1 0 001.414-1.414l-4.293-4.293 4.293-4.293a1 1 0 00-1.414-1.414L10 8.586 8.293 6.879a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 000 1.414l5 1.428a1 1 0 001.17-1.408l-7-14Z"></path></svg>
                            Ajukan Permohonan Seminar
                        </button>
                        <a href="{{ route('mahasiswa.seminar.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
