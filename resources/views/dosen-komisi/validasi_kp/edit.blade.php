@extends('main.app')

@section('title', 'Validasi Pengajuan KP')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-lg px-4 lg:px-12"> {{-- max-w-screen-lg agar sedikit lebih lebar --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Detail & Validasi Pengajuan Kerja Praktek</h2>
                </div>

                {{-- Detail Pengajuan (Read-only) --}}
                <div class="p-4 sm:p-6 mb-6 border-b dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Informasi Mahasiswa & Pengajuan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Nama Mahasiswa:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->mahasiswa->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">NIM:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->mahasiswa->nim ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Jurusan:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->mahasiswa->jurusan->nama ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Tanggal Pengajuan KP:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ \Carbon\Carbon::parse($pengajuanKp->tanggal_pengajuan)->isoFormat('D MMMM YYYY') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500 dark:text-gray-400">Judul Kerja Praktek:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->judul_kp }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500 dark:text-gray-400">Instansi/Lokasi KP:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->instansi_lokasi }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Proposal KP:</p>
                            @if($pengajuanKp->proposal_kp)
                                <a href="{{ Storage::url($pengajuanKp->proposal_kp) }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400 underline">Lihat Proposal</a>
                            @else
                                <p class="text-gray-900 dark:text-white font-medium">-</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Surat Keterangan Instansi:</p>
                            @if($pengajuanKp->surat_keterangan)
                                <a href="{{ Storage::url($pengajuanKp->surat_keterangan) }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400 underline">Lihat Surat</a>
                            @else
                                <p class="text-gray-900 dark:text-white font-medium">-</p>
                            @endif
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500 dark:text-gray-400">Berdasarkan Surat Pengantar:</p>
                            <p class="text-gray-900 dark:text-white font-medium">
                                Ke {{ $pengajuanKp->suratPengantar->lokasi_penelitian ?? 'N/A' }} (Diajukan: {{ $pengajuanKp->suratPengantar ? \Carbon\Carbon::parse($pengajuanKp->suratPengantar->tanggal_pengajuan)->isoFormat('D MMM YY') : 'N/A' }})
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Form Validasi --}}
                <form action="{{ route('dosen-komisi.validasi-kp.update', $pengajuanKp->id) }}" method="POST" class="p-4 sm:p-6">
                    @csrf
                    @method('PUT')
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Form Validasi oleh Komisi</h3>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="status_komisi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Validasi Komisi <span class="text-red-500">*</span></label>
                            <select id="status_komisi" name="status_komisi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" required>
                                <option value="direview" {{ old('status_komisi', $pengajuanKp->status_komisi) == 'direview' ? 'selected' : '' }}>Direview</option>
                                <option value="diterima" {{ old('status_komisi', $pengajuanKp->status_komisi) == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditolak" {{ old('status_komisi', $pengajuanKp->status_komisi) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            @error('status_komisi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div id="dosen_pembimbing_div" style="{{ old('status_komisi', $pengajuanKp->status_komisi) == 'diterima' ? '' : 'display:none;' }}">
                            <label for="dosen_pembimbing_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Dosen Pembimbing <span class="text-red-500">*</span></label>
                            <select name="dosen_pembimbing_id" id="dosen_pembimbing_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                                <option value="">-- Pilih Dosen --</option>
                                @foreach ($calonPembimbings as $dosbing)
                                    <option value="{{ $dosbing->dosen->id }}" {{ old('dosen_pembimbing_id', $pengajuanKp->dosen_pembimbing_id) == $dosbing->dosen->id ? 'selected' : '' }}>
                                        {{ $dosbing->name }} (NIDN: {{ $dosbing->dosen->nidn }})
                                    </option>
                                @endforeach
                            </select>
                            @error('dosen_pembimbing_id') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div id="tanggal_kp_div" class="grid gap-6 mb-6 md:grid-cols-2" style="{{ old('status_komisi', $pengajuanKp->status_komisi) == 'diterima' ? '' : 'display:none;' }}">
                        <div>
                            <label for="tanggal_mulai_kp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Mulai KP <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_mulai_kp" id="tanggal_mulai_kp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tanggal_mulai_kp', $pengajuanKp->tanggal_mulai_kp ? \Carbon\Carbon::parse($pengajuanKp->tanggal_mulai_kp)->format('Y-m-d') : '') }}">
                            @error('tanggal_mulai_kp') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="tanggal_selesai_kp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Selesai KP <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_selesai_kp" id="tanggal_selesai_kp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tanggal_selesai_kp', $pengajuanKp->tanggal_selesai_kp ? \Carbon\Carbon::parse($pengajuanKp->tanggal_selesai_kp)->format('Y-m-d') : '') }}">
                            @error('tanggal_selesai_kp') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div id="alasan_ditolak_div" class="mb-6" style="{{ old('status_komisi', $pengajuanKp->status_komisi) == 'ditolak' ? '' : 'display:none;' }}">
                        <label for="alasan_ditolak" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alasan Penolakan/Tidak Layak <span class="text-red-500">*</span></label>
                        <textarea id="alasan_ditolak" name="alasan_ditolak" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600">{{ old('alasan_ditolak', $pengajuanKp->alasan_ditolak) }}</textarea>
                        @error('alasan_ditolak') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan Hasil Validasi
                        </button>
                        <a href="{{ route('dosen-komisi.validasi-kp.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status_komisi');
            const dosenPembimbingDiv = document.getElementById('dosen_pembimbing_div');
            const dosenPembimbingSelect = document.getElementById('dosen_pembimbing_id');
            const tanggalKpDiv = document.getElementById('tanggal_kp_div');
            const tanggalMulaiInput = document.getElementById('tanggal_mulai_kp');
            const tanggalSelesaiInput = document.getElementById('tanggal_selesai_kp');
            const alasanDitolakDiv = document.getElementById('alasan_ditolak_div');
            const alasanDitolakTextarea = document.getElementById('alasan_ditolak');

            function toggleValidationFields() {
                if (statusSelect.value === 'diterima') {
                    dosenPembimbingDiv.style.display = 'block';
                    dosenPembimbingSelect.required = true;
                    tanggalKpDiv.style.display = 'grid'; // atau 'block' jika tidak mau grid
                    tanggalMulaiInput.required = true;
                    tanggalSelesaiInput.required = true;
                    alasanDitolakDiv.style.display = 'none';
                    alasanDitolakTextarea.required = false;
                } else if (statusSelect.value === 'ditolak') {
                    dosenPembimbingDiv.style.display = 'none';
                    dosenPembimbingSelect.required = false;
                    tanggalKpDiv.style.display = 'none';
                    tanggalMulaiInput.required = false;
                    tanggalSelesaiInput.required = false;
                    alasanDitolakDiv.style.display = 'block';
                    alasanDitolakTextarea.required = true;
                } else { // direview atau lainnya
                    dosenPembimbingDiv.style.display = 'none';
                    dosenPembimbingSelect.required = false;
                    tanggalKpDiv.style.display = 'none';
                    tanggalMulaiInput.required = false;
                    tanggalSelesaiInput.required = false;
                    alasanDitolakDiv.style.display = 'none';
                    alasanDitolakTextarea.required = false;
                }
            }

            // Panggil saat halaman load
            toggleValidationFields();

            // Panggil saat pilihan status berubah
            statusSelect.addEventListener('change', toggleValidationFields);
        });
    </script>
@endpush
