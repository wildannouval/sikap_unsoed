@extends('main.app')

@section('title', 'Ajukan Seminar Kerja Praktek')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-lg px-4 lg:px-12"> <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-4">
                <div class="border-b pb-4 mb-4 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Form Pengajuan Seminar Kerja Praktek</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Untuk KP Judul: {{ $pengajuanKp->judul_kp }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Dosen Pembimbing: {{ $pengajuanKp->dosenPembimbing->user->name ?? 'N/A' }}</p>
                    <p class="text-sm text-green-600 dark:text-green-400">Jumlah konsultasi terverifikasi: {{ $jumlahKonsultasiVerified }} (Minimal: {{ \App\Http\Controllers\Mahasiswa\SeminarKpController::MIN_KONSULTASI_VERIFIED }})</p>
                </div>

                @if (session('error'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('mahasiswa.pengajuan-kp.seminar.store', $pengajuanKp->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-6 mb-6 md:grid-cols-1"> {{-- Ubah ke 1 kolom utama dulu --}}
                        <div>
                            <label for="judul_kp_final" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Final Kerja Praktek <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_kp_final" id="judul_kp_final" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('judul_kp_final', $pengajuanKp->judul_kp) }}" required>
                            @error('judul_kp_final') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="draft_laporan_path" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Draft Laporan Akhir KP (PDF, max 5MB) <span class="text-red-500">*</span></label>
                            <input type="file" name="draft_laporan_path" id="draft_laporan_path" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept=".pdf" required>
                            @error('draft_laporan_path') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <hr class="my-6 border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Usulan Jadwal Seminar</h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-4">Mohon koordinasikan terlebih dahulu dengan Dosen Pembimbing Anda dan cek ketersediaan ruangan dengan Bapendik/bagian terkait sebelum mengusulkan jadwal.</p>

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="usulan_tanggal_seminar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usulan Tanggal Seminar <span class="text-red-500">*</span></label>
                            <input type="date" name="usulan_tanggal_seminar" id="usulan_tanggal_seminar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('usulan_tanggal_seminar') }}" required>
                            @error('usulan_tanggal_seminar') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="usulan_ruangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usulan Ruangan <span class="text-red-500">*</span></label>
                            <select name="usulan_ruangan" id="usulan_ruangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach ($daftarRuangan as $ruangan)
                                    <option value="{{ $ruangan->nama_ruangan }}" {{ old('usulan_ruangan') == $ruangan->nama_ruangan ? 'selected' : '' }}>
                                        {{ $ruangan->nama_ruangan }} {{ $ruangan->lokasi_gedung ? '('.$ruangan->lokasi_gedung.')' : '' }} {{ $ruangan->kapasitas ? '[Kapasitas: '.$ruangan->kapasitas.']' : ''}}
                                    </option>
                                @endforeach
                                {{-- Kamu bisa tambahkan opsi "Lainnya" jika masih ingin mahasiswa input manual --}}
                                {{-- <option value="Lainnya_Input_Manual">Lainnya (Isi Manual)</option> --}}
                            </select>
                            {{-- Jika ada opsi "Lainnya", tambahkan input teks yang muncul jika 'Lainnya' dipilih (perlu JS) --}}
                            @error('usulan_ruangan') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="usulan_jam_mulai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usulan Jam Mulai <span class="text-red-500">*</span></label>
                            <input type="time" name="usulan_jam_mulai" id="usulan_jam_mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('usulan_jam_mulai') }}" required>
                            @error('usulan_jam_mulai') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="usulan_jam_selesai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usulan Jam Selesai <span class="text-red-500">*</span></label>
                            <input type="time" name="usulan_jam_selesai" id="usulan_jam_selesai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('usulan_jam_selesai') }}" required>
                            @error('usulan_jam_selesai') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="catatan_mahasiswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan Tambahan untuk Penjadwal (Opsional)</label>
                        <textarea name="catatan_mahasiswa" id="catatan_mahasiswa" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" placeholder="Misal: preferensi waktu tertentu, atau info tambahan...">{{ old('catatan_mahasiswa') }}</textarea>
                        @error('catatan_mahasiswa') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                    </div>


                    <div class="flex items-center space-x-4 mt-8">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Ajukan Permohonan Seminar
                        </button>
                        <a href="{{ route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKp->id) }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            Batal (Kembali ke Konsultasi)
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
