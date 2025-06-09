@extends('main.app')

@php
    $isEditable = ($pengajuanKp->status_komisi === 'direview');
    $pageTitle = $isEditable ? 'Proses Validasi Pengajuan KP' : 'Detail Validasi Pengajuan KP';
@endphp

@section('title', $pageTitle)

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $pageTitle }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4 sm:p-6">
                    {{-- Kolom Kiri: Detail Pengajuan (Read-only) --}}
                    <div class="md:col-span-2 p-6 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Mahasiswa & Pengajuan</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Nama Mahasiswa:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->mahasiswa->user->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">NIM:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->mahasiswa->nim ?? 'N/A' }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Judul Kerja Praktek:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->judul_kp }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Instansi/Lokasi KP:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->instansi_lokasi }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 mb-1">Proposal KP:</p>
                                @if($pengajuanKp->proposal_kp)
                                    <a href="{{ Storage::url($pengajuanKp->proposal_kp) }}" target="_blank" class="inline-flex items-center text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none dark:focus:ring-indigo-800 transition-colors duration-150">
                                        <svg class="w-3.5 h-3.5 mr-1.5 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 19"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 0L10 14M10 14L18 6M10 14L2 6"/></svg>
                                        Unduh/Lihat Proposal
                                    </a>
                                @else
                                    <p class="text-gray-900 dark:text-white font-medium">-</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 mb-1">Surat Keterangan Instansi:</p>
                                @if($pengajuanKp->surat_keterangan)
                                    <a href="{{ Storage::url($pengajuanKp->surat_keterangan) }}" target="_blank" class="inline-flex items-center text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none dark:focus:ring-indigo-800 transition-colors duration-150">
                                        <svg class="w-3.5 h-3.5 mr-1.5 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 19"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 0L10 14M10 14L18 6M10 14L2 6"/></svg>
                                        Unduh/Lihat Surat
                                    </a>
                                @else
                                    <p class="text-gray-900 dark:text-white font-medium">-</p>
                                @endif
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Berdasarkan Surat Pengantar:</p>
                                <p class="text-gray-900 dark:text-white font-medium">
                                    Ke {{ $pengajuanKp->suratPengantar->lokasi_penelitian ?? 'N/A' }} (Diajukan: {{ $pengajuanKp->suratPengantar ? \Carbon\Carbon::parse($pengajuanKp->suratPengantar->tanggal_pengajuan)->isoFormat('D MMM YY') : 'N/A' }})
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Form Validasi atau Detail Validasi --}}
                    <div class="md:col-span-1">
                        <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                            @if ($isEditable)
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Form Validasi oleh Komisi</h3>
                                <form action="{{ route('dosen-komisi.validasi-kp.update', $pengajuanKp->id) }}" method="POST" class="space-y-6">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label for="status_komisi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tindakan Validasi <span class="text-red-500">*</span></label>
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
                                            @foreach ($calonPembimbings as $dosbingUser)
                                                @if($dosbingUser->dosen)
                                                    <option value="{{ $dosbingUser->dosen->id }}" {{ old('dosen_pembimbing_id', $pengajuanKp->dosen_pembimbing_id) == $dosbingUser->dosen->id ? 'selected' : '' }}>
                                                        {{ $dosbingUser->name }} ({{ $dosbingUser->dosen->nidn }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('dosen_pembimbing_id') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    <div id="tanggal_kp_div" class="space-y-4" style="{{ old('status_komisi', $pengajuanKp->status_komisi) == 'diterima' ? '' : 'display:none;' }}">
                                        <div>
                                            <label for="tanggal_mulai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Mulai KP (Opsional)</label>
                                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tanggal_mulai', $pengajuanKp->tanggal_mulai ? \Carbon\Carbon::parse($pengajuanKp->tanggal_mulai)->format('Y-m-d') : '') }}">
                                            @error('tanggal_mulai') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label for="tanggal_selesai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Selesai KP (Opsional)</label>
                                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tanggal_selesai', $pengajuanKp->tanggal_selesai ? \Carbon\Carbon::parse($pengajuanKp->tanggal_selesai)->format('Y-m-d') : '') }}">
                                            @error('tanggal_selesai') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    <div id="alasan_ditolak_div" class="mb-6" style="{{ old('status_komisi', $pengajuanKp->status_komisi) == 'ditolak' ? '' : 'display:none;' }}">
                                        <label for="alasan_ditolak" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alasan Penolakan<span class="text-red-500">*</span></label>
                                        <textarea id="alasan_ditolak" name="alasan_ditolak" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600" placeholder="Jelaskan alasan penolakan di sini...">{{ old('alasan_ditolak', $pengajuanKp->alasan_ditolak) }}</textarea>
                                        @error('alasan_ditolak') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="flex items-center space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                                            Simpan Validasi
                                        </button>
                                        <a href="{{ route('dosen-komisi.validasi-kp.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                                            Batal
                                        </a>
                                    </div>
                                </form>
                            @else
                                {{-- Tampilkan Detail Validasi (Read-Only) --}}
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Hasil Validasi Komisi</h3>
                                <div class="space-y-4 text-sm">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">Status:</p>
                                        @if($pengajuanKp->status_komisi == 'diterima')
                                            <p class="font-medium text-green-600 dark:text-green-400">Diterima</p>
                                        @elseif($pengajuanKp->status_komisi == 'ditolak')
                                            <p class="font-medium text-red-600 dark:text-red-400">Ditolak</p>
                                        @endif
                                    </div>
                                    @if($pengajuanKp->status_komisi == 'diterima' && $pengajuanKp->dosenPembimbing)
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400">Dosen Pembimbing Ditetapkan:</p>
                                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKp->dosenPembimbing->user->name ?? 'N/A' }}</p>
                                        </div>
                                    @endif
                                    @if($pengajuanKp->status_komisi == 'ditolak' && $pengajuanKp->alasan_tidak_layak)
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400">Alasan Penolakan:</p>
                                            <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $pengajuanKp->alasan_tidak_layak }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('dosen-komisi.validasi-kp.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0l4 4M1 5l4-4"/></svg>
                                        Kembali ke Daftar
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- Script toggle field tetap sama seperti sebelumnya --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status_komisi');
            const dosenPembimbingDiv = document.getElementById('dosen_pembimbing_div');
            const dosenPembimbingSelect = document.getElementById('dosen_pembimbing_id');
            const tanggalKpDiv = document.getElementById('tanggal_kp_div');
            const alasanDitolakDiv = document.getElementById('alasan_ditolak_div');
            const alasanDitolakTextarea = document.getElementById('alasan_tidak_layak');

            function toggleValidationFields() {
                if(statusSelect){ // Pastikan elemennya ada
                    if (statusSelect.value === 'diterima') {
                        dosenPembimbingDiv.style.display = 'block';
                        dosenPembimbingSelect.required = true;
                        tanggalKpDiv.style.display = 'block';
                        alasanDitolakDiv.style.display = 'none';
                        alasanDitolakTextarea.required = false;
                    } else if (statusSelect.value === 'ditolak') {
                        dosenPembimbingDiv.style.display = 'none';
                        dosenPembimbingSelect.required = false;
                        tanggalKpDiv.style.display = 'none';
                        alasanDitolakDiv.style.display = 'block';
                        alasanDitolakTextarea.required = true;
                    } else { // direview atau lainnya
                        dosenPembimbingDiv.style.display = 'none';
                        dosenPembimbingSelect.required = false;
                        tanggalKpDiv.style.display = 'none';
                        alasanDitolakDiv.style.display = 'none';
                        alasanDitolakTextarea.required = false;
                    }
                }
            }
            if(statusSelect){
                toggleValidationFields(); // Panggil saat halaman load
                statusSelect.addEventListener('change', toggleValidationFields);
            }
        });
    </script>
@endpush
