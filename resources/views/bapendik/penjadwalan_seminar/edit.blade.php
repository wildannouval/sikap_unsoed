@extends('main.app')

@section('title', 'Proses Jadwal Seminar')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Proses & Penetapan Jadwal Seminar KP</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4 sm:p-6">
                    {{-- Kolom Kiri: Detail Pengajuan (Read-only) --}}
                    <div class="md:col-span-2 p-6 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Pengajuan Seminar</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Nama Mahasiswa:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $seminar->mahasiswa->user->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">NIM:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $seminar->mahasiswa->nim ?? 'N/A' }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Judul KP Final:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $seminar->judul_kp_final }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Dosen Pembimbing:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $seminar->pengajuanKp->dosenPembimbing->user->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 mb-1">Draft Laporan KP:</p>
                                @if($seminar->draft_laporan_path)
                                    <a href="{{ Storage::url($seminar->draft_laporan_path) }}" target="_blank"
                                       class="inline-flex items-center text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none dark:focus:ring-indigo-800 transition-colors duration-150">
                                        <svg class="w-3.5 h-3.5 mr-1.5 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 19"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 0L10 14M10 14L18 6M10 14L2 6"/></svg>
                                        Unduh/Lihat Draft
                                    </a>
                                @else
                                    <p class="text-gray-900 dark:text-white font-medium">-</p>
                                @endif
                            </div>
                            @if($seminar->catatan_mahasiswa)
                                <div class="sm:col-span-2">
                                    <p class="text-gray-500 dark:text-gray-400">Catatan dari Mahasiswa:</p>
                                    <p class="text-gray-900 dark:text-white whitespace-pre-wrap bg-gray-100 dark:bg-gray-700/50 p-2 rounded-md">{{ $seminar->catatan_mahasiswa }}</p>
                                </div>
                            @endif
                            @if($seminar->catatan_dospem)
                                <div class="sm:col-span-2">
                                    <p class="text-gray-500 dark:text-gray-400">Catatan dari Dosen Pembimbing:</p>
                                    <p class="text-gray-900 dark:text-white whitespace-pre-wrap bg-gray-100 dark:bg-gray-700/50 p-2 rounded-md">{{ $seminar->catatan_dospem }}</p>
                                </div>
                            @endif
                            <div class="sm:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Usulan Jadwal dari Mahasiswa (Disetujui Dospem):</p>
                                <div class="text-gray-900 dark:text-white font-medium bg-yellow-50 dark:bg-gray-700 p-3 rounded-md">
                                    @if($seminar->status_pengajuan == 'disetujui_dospem' && $seminar->tanggal_seminar)
                                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                        <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') }} - {{ $seminar->jam_selesai ? \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : 'Selesai' }} WIB</p>
                                        <p><strong>Ruangan:</strong> {{ $seminar->ruangan ?? 'N/A' }}</p>
                                    @else
                                        <p class="italic text-gray-600 dark:text-gray-300">(Tidak ada usulan jadwal atau status tidak sesuai)</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Form Aksi Bapendik --}}
                    <div class="md:col-span-1">
                        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <form action="{{ route('bapendik.penjadwalan-seminar.updateJadwal', $seminar->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi Penjadwalan Final</h3>
                                <div class="px-0 pb-4">@include('partials.session-messages')</div>

                                <div class="space-y-6">
                                    {{-- Pilihan Aksi --}}
                                    <div>
                                        <label for="tindakan_bapendik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Tindakan</label>
                                        <select id="tindakan_bapendik" name="tindakan_bapendik" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                                            <option value="tetapkan_jadwal" {{ old('tindakan_bapendik', 'tetapkan_jadwal') == 'tetapkan_jadwal' ? 'selected' : '' }}>Tetapkan Jadwal Final</option>
                                            <option value="minta_revisi" {{ old('tindakan_bapendik') == 'minta_revisi' ? 'selected' : '' }}>Minta Mahasiswa Revisi Jadwal</option>
                                        </select>
                                    </div>

                                    {{-- Form Jadwal (ditampilkan/disembunyikan oleh JS) --}}
                                    <div id="form_jadwal_final" class="grid gap-6 md:grid-cols-1">
                                        <div>
                                            <label for="tanggal_seminar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Seminar Final <span class="text-red-500">*</span></label>
                                            <input type="date" name="tanggal_seminar" id="tanggal_seminar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('tanggal_seminar') border-red-500 @enderror" value="{{ old('tanggal_seminar', $seminar->tanggal_seminar ? \Carbon\Carbon::parse($seminar->tanggal_seminar)->format('Y-m-d') : '') }}">
                                            @error('tanggal_seminar') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label for="ruangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ruangan Seminar <span class="text-red-500">*</span></label>
                                            <select name="ruangan" id="ruangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('ruangan') border-red-500 @enderror">
                                                <option value="">-- Pilih Ruangan Final --</option>
                                                @foreach ($daftarRuangan as $itemRuangan)
                                                    <option value="{{ $itemRuangan->nama_ruangan }}" {{ (old('ruangan', $seminar->ruangan) == $itemRuangan->nama_ruangan) ? 'selected' : '' }}>{{ $itemRuangan->nama_ruangan }}</option>
                                                @endforeach
                                            </select>
                                            @error('ruangan') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="jam_mulai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Mulai <span class="text-red-500">*</span></label>
                                                <input type="time" name="jam_mulai" id="jam_mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('jam_mulai') border-red-500 @enderror" value="{{ old('jam_mulai', $seminar->jam_mulai ? \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') : '') }}">
                                                @error('jam_mulai') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                            </div>
                                            <div>
                                                <label for="jam_selesai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Selesai <span class="text-red-500">*</span></label>
                                                <input type="time" name="jam_selesai" id="jam_selesai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('jam_selesai') border-red-500 @enderror" value="{{ old('jam_selesai', $seminar->jam_selesai ? \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '') }}">
                                                @error('jam_selesai') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                        {{-- PERBAIKAN: Input Tanggal Pengambilan BA --}}
                                        <div id="ba_ambil_div">
                                            <label for="ba_tanggal_pengambilan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pengambilan Berita Acara <span class="text-red-500">*</span></label>
                                            <input type="date" name="ba_tanggal_pengambilan" id="ba_tanggal_pengambilan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('ba_tanggal_pengambilan') border-red-500 @enderror" value="{{ old('ba_tanggal_pengambilan', $seminar->ba_tanggal_pengambilan ? \Carbon\Carbon::parse($seminar->ba_tanggal_pengambilan)->format('Y-m-d') : '') }}">
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tanggal mahasiswa bisa mengambil berkas BA.</p>
                                            @error('ba_tanggal_pengambilan') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    {{-- Form Catatan --}}
                                    <div>
                                        <label id="label_catatan_komisi" for="catatan_komisi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                                        <textarea id="catatan_komisi" name="catatan_komisi" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 @error('catatan_komisi') border-red-500 @enderror" placeholder="...">{{ old('catatan_komisi', $seminar->catatan_komisi) }}</textarea>
                                        @error('catatan_komisi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="flex items-center space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        {{-- Tombol Simpan Keputusan (Aksi Utama) --}}
                                        <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                                            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            Simpan Keputusan
                                        </button>
                                        {{-- Tombol Batal (Aksi Sekunder) --}}
                                        <a href="{{ route('bapendik.penjadwalan-seminar.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Batal
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- TAMBAHKAN BAGIAN INI --}}
                        @if($seminar->status_pengajuan === 'dijadwalkan_bapendik')
                            <div class="p-6 border border-red-300 dark:border-red-700 rounded-lg mt-6">
                                <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-2">Aksi Berisiko</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Membatalkan jadwal seminar yang sudah ditetapkan. Aksi ini tidak dapat diurungkan.</p>
                                <button type="button"
                                        data-modal-target="cancelSeminarModal"
                                        data-modal-toggle="cancelSeminarModal"
                                        data-cancel-url="{{ route('bapendik.penjadwalan-seminar.cancel', $seminar->id) }}"
                                        class="w-full inline-flex items-center justify-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    Batalkan Jadwal Seminar Ini
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('partials.modal-cancel-seminar')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tindakanSelect = document.getElementById('tindakan_bapendik');
            const formJadwal = document.getElementById('form_jadwal_final');
            const jadwalInputs = formJadwal.querySelectorAll('input, select');
            const catatanTextarea = document.getElementById('catatan_komisi');
            const catatanLabel = document.getElementById('label_catatan_komisi');
            // PERBAIKAN: Dapatkan elemen div untuk tanggal BA
            const baAmbilDiv = document.getElementById('ba_ambil_div');

            function toggleJadwalForm() {
                if (tindakanSelect.value === 'tetapkan_jadwal') {
                    formJadwal.style.display = 'grid';
                    jadwalInputs.forEach(input => {
                        // Hanya set 'required' untuk input yang bukan tanggal BA jika ingin opsional
                        if(input.name !== 'ba_tanggal_pengambilan') {
                            input.required = true;
                        }
                    });
                    // PERBAIKAN: Tanggal BA wajib
                    document.getElementById('ba_tanggal_pengambilan').required = true;

                    catatanLabel.innerHTML = 'Catatan Tambahan (Opsional)';
                    catatanTextarea.required = false;
                    catatanTextarea.placeholder = 'Catatan tambahan untuk mahasiswa atau dosen...';

                } else { // Jika 'minta_revisi'
                    formJadwal.style.display = 'none';
                    jadwalInputs.forEach(input => input.required = false);

                    catatanLabel.innerHTML = 'Catatan dari Bapendik <span class="text-red-500">*</span>';
                    catatanTextarea.required = true;
                    catatanTextarea.placeholder = 'Jelaskan alasan kenapa mahasiswa harus merevisi jadwal...';
                }
            }

            if (tindakanSelect) {
                toggleJadwalForm();
                tindakanSelect.addEventListener('change', toggleJadwalForm);
            }

            // Script untuk Modal Pembatalan
            const cancelSeminarModalEl = document.getElementById('cancelSeminarModal');
            if (cancelSeminarModalEl) {
                document.querySelectorAll('button[data-modal-toggle="cancelSeminarModal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const url = this.dataset.cancelUrl; // Menggunakan data-cancel-url
                        const form = document.getElementById('cancelSeminarForm'); // ID form di dalam modal
                        if (form) {
                            form.action = url;
                        }
                    });
                });
            }
        });
    </script>
@endpush
