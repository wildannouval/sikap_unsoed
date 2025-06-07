@extends('main.app')

@section('title', 'Buat Pengajuan Kerja Praktek')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Container konsisten --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Form Pengajuan Kerja Praktek</h2>
                </div>

                <form action="{{ route('mahasiswa.pengajuan-kp.store', $pengajuanKpAktif ?? 0) }}" {{-- Beri parameter dummy jika $pengajuanKpAktif mungkin null --}}
                method="POST" enctype="multipart/form-data" class="p-4 sm:p-6">
                    @csrf
                    <div class="px-0 pb-4">
                        @include('partials.session-messages')
                    </div>

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label for="surat_pengantar_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Surat Pengantar (yang sudah disetujui & belum dipakai) <span class="text-red-500">*</span></label>
                            <select name="surat_pengantar_id" id="surat_pengantar_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('surat_pengantar_id') border-red-500 @enderror" required>
                                <option value="">-- Pilih Surat Pengantar --</option>
                                @forelse ($suratPengantars as $sp)
                                    <option value="{{ $sp->id }}" {{ old('surat_pengantar_id') == $sp->id ? 'selected' : '' }} data-lokasi="{{ $sp->lokasi_penelitian }}">
                                        Ke: {{ $sp->lokasi_penelitian }} (Diajukan: {{ \Carbon\Carbon::parse($sp->tanggal_pengajuan)->isoFormat('D MMM YY') }})
                                    </option>
                                @empty
                                    <option value="" disabled>Tidak ada surat pengantar yang disetujui atau tersedia</option>
                                @endforelse
                            </select>
                            @error('surat_pengantar_id') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            @if($suratPengantars->isEmpty())
                                <p class="mt-2 text-xs text-yellow-600 dark:text-yellow-400">Pastikan Anda sudah memiliki Surat Pengantar yang disetujui Bapendik dan belum pernah digunakan untuk pengajuan KP.</p>
                            @endif
                        </div>

                        <div class="md:col-span-2">
                            <label for="judul_kp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Kerja Praktek <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_kp" id="judul_kp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('judul_kp') border-red-500 @enderror" value="{{ old('judul_kp') }}" placeholder="Judul lengkap kerja praktek Anda" required>
                            @error('judul_kp') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="instansi_lokasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Instansi/Perusahaan Tempat KP <span class="text-red-500">*</span></label>
                            <input type="text" name="instansi_lokasi" id="instansi_lokasi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('instansi_lokasi') border-red-500 @enderror" value="{{ old('instansi_lokasi') }}" placeholder="Nama perusahaan/instansi" required>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Akan terisi otomatis jika memilih surat pengantar, namun bisa diedit.</p>
                            @error('instansi_lokasi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="proposal_kp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Proposal KP (PDF, max 2MB) <span class="text-red-500">*</span></label>
                            <input type="file" name="proposal_kp" id="proposal_kp" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('proposal_kp') border-red-500 @enderror" accept=".pdf" required>
                            @error('proposal_kp') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="surat_keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Surat Keterangan Diterima dari Instansi (PDF/JPG/PNG, max 2MB) <span class="text-red-500">*</span></label>
                            <input type="file" name="surat_keterangan" id="surat_keterangan" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('surat_keterangan') border-red-500 @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                            @error('surat_keterangan') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.428A1 1 0 008 16.171V11.83l5.707 5.707a1 1 0 001.414-1.414l-4.293-4.293 4.293-4.293a1 1 0 00-1.414-1.414L10 8.586 8.293 6.879a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 000 1.414l5 1.428a1 1 0 001.17-1.408l-7-14Z"></path></svg>
                            Kirim Pengajuan KP
                        </button>
                        <a href="{{ route('mahasiswa.pengajuan-kp.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
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
        document.addEventListener('DOMContentLoaded', function() {
            const selectSuratPengantar = document.getElementById('surat_pengantar_id');
            const inputInstansiLokasi = document.getElementById('instansi_lokasi');

            // Buat map dari data surat pengantar jika dikirim dari controller
            // Jika tidak, atribut data-lokasi akan digunakan
            const suratPengantarsData = {};
            @if(isset($suratPengantars))
                @foreach ($suratPengantars as $sp)
                suratPengantarsData["{{ $sp->id }}"] = "{{ $sp->lokasi_penelitian }}";
            @endforeach
            @endif

            function updateInstansi() {
                const selectedOption = selectSuratPengantar.options[selectSuratPengantar.selectedIndex];
                const selectedId = selectedOption.value;

                if (suratPengantarsData[selectedId]) {
                    inputInstansiLokasi.value = suratPengantarsData[selectedId];
                } else if (selectedOption && selectedOption.dataset.lokasi) { // Fallback ke data attribute
                    inputInstansiLokasi.value = selectedOption.dataset.lokasi;
                } else {
                    inputInstansiLokasi.value = '';
                }
            }

            if(selectSuratPengantar && inputInstansiLokasi) {
                selectSuratPengantar.addEventListener('change', updateInstansi);

                // Panggil sekali saat load untuk handle old value atau pilihan awal
                if (selectSuratPengantar.value) {
                    // Hanya isi jika field instansi masih kosong (belum ada old value dari error validasi sebelumnya)
                    if(!inputInstansiLokasi.value || inputInstansiLokasi.value === '') {
                        updateInstansi();
                    }
                }
            }
        });
    </script>
@endpush
