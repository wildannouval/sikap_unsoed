@extends('main.app')

@section('title', 'Buat Pengajuan Kerja Praktek')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-6">Form Pengajuan Kerja Praktek</h2>

                @if (session('error'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('mahasiswa.pengajuan-kp.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label for="surat_pengantar_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Surat Pengantar (yang sudah disetujui) <span class="text-red-500">*</span></label>
                            <select name="surat_pengantar_id" id="surat_pengantar_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                                <option value="">-- Pilih Surat Pengantar --</option>
                                @forelse ($suratPengantars as $sp)
                                    <option value="{{ $sp->id }}" {{ old('surat_pengantar_id') == $sp->id ? 'selected' : '' }}>
                                        {{ $sp->lokasi_penelitian }} (Diajukan: {{ \Carbon\Carbon::parse($sp->tanggal_pengajuan)->isoFormat('D MMM YY') }})
                                    </option>
                                @empty
                                    <option value="" disabled>Tidak ada surat pengantar yang disetujui atau tersedia</option>
                                @endforelse
                            </select>
                            @error('surat_pengantar_id') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            @if($suratPengantars->isEmpty())
                                <p class="mt-2 text-sm text-yellow-600 dark:text-yellow-400">Pastikan Anda sudah memiliki Surat Pengantar yang disetujui oleh Bapendik dan belum pernah digunakan.</p>
                            @endif
                        </div>

                        <div class="md:col-span-2">
                            <label for="judul_kp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Kerja Praktek <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_kp" id="judul_kp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('judul_kp') }}" required>
                            @error('judul_kp') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="instansi_lokasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Instansi/Perusahaan Tempat KP <span class="text-red-500">*</span></label>
                            <input type="text" name="instansi_lokasi" id="instansi_lokasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('instansi_lokasi') }}" required>
                            @error('instansi_lokasi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="proposal_kp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Proposal KP (PDF, max 2MB) <span class="text-red-500">*</span></label>
                            <input type="file" name="proposal_kp" id="proposal_kp" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept=".pdf" required>
                            @error('proposal_kp') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="surat_keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Surat Keterangan Diterima dari Instansi (PDF/JPG/PNG, max 2MB) <span class="text-red-500">*</span></label>
                            <input type="file" name="surat_keterangan" id="surat_keterangan" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept=".pdf,.jpg,.jpeg,.png" required>
                            @error('surat_keterangan') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 mt-8">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Kirim Pengajuan KP
                        </button>
                        <a href="{{ route('mahasiswa.pengajuan-kp.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Script untuk mengisi otomatis Instansi/Lokasi KP jika surat pengantar dipilih
        document.addEventListener('DOMContentLoaded', function() {
            const selectSuratPengantar = document.getElementById('surat_pengantar_id');
            const inputInstansiLokasi = document.getElementById('instansi_lokasi');

            // Daftar surat pengantar dengan detailnya (dibuat dari PHP ke JS)
            const suratPengantarsData = {
                @foreach ($suratPengantars as $sp)
                "{{ $sp->id }}": "{{ $sp->lokasi_penelitian }}",
                @endforeach
            };

            selectSuratPengantar.addEventListener('change', function() {
                const selectedId = this.value;
                if (suratPengantarsData[selectedId]) {
                    inputInstansiLokasi.value = suratPengantarsData[selectedId];
                } else {
                    inputInstansiLokasi.value = ''; // Kosongkan jika tidak ada yang dipilih
                }
            });

            // Panggil sekali saat load untuk handle old value
            if (selectSuratPengantar.value && suratPengantarsData[selectSuratPengantar.value]) {
                if(!document.getElementById('instansi_lokasi').value) { // Hanya isi jika field instansi masih kosong (belum ada old value dari error)
                    inputInstansiLokasi.value = suratPengantarsData[selectSuratPengantar.value];
                }
            }
        });
    </script>
@endpush
