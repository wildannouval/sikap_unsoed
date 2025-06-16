@extends('main.app')

@php
    // Tentukan apakah form ini dalam mode edit/proses atau mode lihat detail
    $isEditableByDospem = in_array($seminar->status_pengajuan, ['diajukan_mahasiswa', 'ditolak_dospem', 'revisi_dospem']);
    $pageTitle = $isEditableByDospem ? 'Proses Persetujuan Seminar KP' : 'Detail Persetujuan Seminar KP';
@endphp

@section('title', $pageTitle)

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Container konsisten --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $pageTitle }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4 sm:p-6">
                    {{-- Kolom Kiri: Detail Pengajuan (Read-only) --}}
                    <div class="md:col-span-2 p-6 border border-gray-200 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-700/30">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Pengajuan dari Mahasiswa</h3>
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
                                <p class="text-gray-500 dark:text-gray-400">Judul KP Final (Diajukan):</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $seminar->judul_kp_final }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Draft Laporan KP:</p>
                                @if($seminar->draft_laporan_path)
                                    <a href="{{ Storage::url($seminar->draft_laporan_path) }}" target="_blank" class="inline-flex items-center text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none dark:focus:ring-indigo-800 transition-colors duration-150">
                                        <svg class="w-3.5 h-3.5 mr-1.5 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 19"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 0L10 14M10 14L18 6M10 14L2 6"/></svg>
                                        Unduh/Lihat Draft
                                    </a>
                                @else
                                    <p class="text-gray-900 dark:text-white font-medium">- Tidak ada file -</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Tanggal Pengajuan Seminar:</p>
                                <p class="text-gray-900 dark:text-white font-medium">{{ \Carbon\Carbon::parse($seminar->tanggal_pengajuan_seminar)->isoFormat('D MMM YYYY') }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Usulan Jadwal dari Mahasiswa:</p>
                                <div class="text-gray-900 dark:text-white font-medium bg-yellow-50 dark:bg-gray-700 p-3 rounded-md">
                                    @if($seminar->tanggal_seminar && $seminar->jam_mulai)
                                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                        <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') }} - {{ $seminar->jam_selesai ? \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : 'Selesai' }} WIB</p>
                                        <p><strong>Ruangan:</strong> {{ $seminar->ruangan ?? 'N/A' }}</p>
                                    @else
                                        <p class="italic text-gray-600 dark:text-gray-300">- Tidak ada usulan jadwal dari mahasiswa -</p>
                                    @endif
                                </div>
                            </div>
                            @if($seminar->catatan_mahasiswa)
                                <div class="sm:col-span-2">
                                    <p class="text-gray-500 dark:text-gray-400">Catatan dari Mahasiswa:</p>
                                    <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $seminar->catatan_mahasiswa }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Kolom Kanan: Form Persetujuan atau Detail Keputusan --}}
                    <div class="md:col-span-1">
                        @if ($isEditableByDospem)
                            <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Formulir Persetujuan</h3>
                                <form action="{{ route('dosen.pembimbing.seminar-approval.process', $seminar->id) }}" method="POST" class="space-y-6">
                                    @csrf
                                    {{-- Route::post, jadi @csrf saja cukup --}}
                                    <div>
                                        <label for="tindakan_dospem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tindakan Anda <span class="text-red-500">*</span></label>
                                        <select id="tindakan_dospem" name="tindakan_dospem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" required>
                                            <option value="">-- Pilih Tindakan --</option>
                                            <option value="setuju" {{ old('tindakan_dospem', $seminar->status_pengajuan) == 'disetujui_dospem' ? 'selected' : '' }}>Setujui Pengajuan Seminar</option>
                                            <option value="tolak" {{ old('tindakan_dospem', $seminar->status_pengajuan) == 'ditolak_dospem' ? 'selected' : '' }}>Tolak Pengajuan</option>
                                            <option value="revisi" {{ old('tindakan_dospem', $seminar->status_pengajuan) == 'revisi_dospem' ? 'selected' : '' }}>Minta Revisi</option>
                                        </select>
                                        @error('tindakan_dospem') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="catatan_dospem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan (Wajib jika menolak/revisi)</label>
                                        <textarea id="catatan_dospem" name="catatan_dospem" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600" placeholder="Berikan alasan jika menolak, atau catatan tambahan jika setuju...">{{ old('catatan_dospem', $seminar->catatan_dospem) }}</textarea>
                                        @error('catatan_dospem') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="flex items-center space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            Simpan Keputusan
                                        </button>
                                        <a href="{{ route('dosen.pembimbing.seminar-approval.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        @else
                            {{-- Tampilkan Detail Keputusan Dosen Pembimbing (Read-Only) --}}
                            <div class="p-6 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Hasil Keputusan Anda</h3>
                                <div class="space-y-4 text-sm">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">Status Persetujuan:</p>
                                        @if($seminar->status_pengajuan == 'disetujui_dospem')
                                            <p class="font-medium text-green-600 dark:text-green-400">Anda telah menyetujui pengajuan ini pada {{ $seminar->dospem_approved_at ? \Carbon\Carbon::parse($seminar->dospem_approved_at)->isoFormat('D MMMM YYYY, HH:mm') : '' }}</p>
                                        @elseif($seminar->status_pengajuan == 'ditolak_dospem')
                                            <p class="font-medium text-red-600 dark:text-red-400">Anda telah menolak pengajuan ini.</p>
                                        @else
                                            <p class="font-medium text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $seminar->status_pengajuan)) }} (Diproses Pihak Lain)</p>
                                        @endif
                                    </div>
                                    @if($seminar->catatan_dospem)
                                        <div>
                                            <p class="text-gray-500 dark:text-gray-400">Catatan yang Anda Berikan:</p>
                                            <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $seminar->catatan_dospem }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
