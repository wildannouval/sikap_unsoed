@extends('main.app')

@php
    // Tentukan apakah form ini dalam mode edit/proses atau mode lihat detail
    $isEditableByDospem = ($seminar->status_pengajuan === 'diajukan_mahasiswa');
    $pageTitle = $isEditableByDospem ? 'Proses Persetujuan Seminar KP' : 'Detail Persetujuan Seminar KP';
@endphp

@section('title', $pageTitle)

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-lg px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">{{ $pageTitle }}</h2>
                </div>

                {{-- Detail Pengajuan dari Mahasiswa (Read-only) - Tetap ditampilkan --}}
                <div class="p-4 sm:p-6 mb-6 border-b dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Detail Pengajuan dari Mahasiswa</h3>
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
                            <p class="text-gray-500 dark:text-gray-400">Judul KP Final (Diajukan):</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $seminar->judul_kp_final }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Draft Laporan KP:</p>
                            @if($seminar->draft_laporan_path)
                                <a href="{{ Storage::url($seminar->draft_laporan_path) }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400 underline">Lihat Draft Laporan</a>
                            @else
                                <p class="text-gray-900 dark:text-white font-medium">- Tidak ada file -</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Tanggal Pengajuan Seminar oleh Mhs:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ \Carbon\Carbon::parse($seminar->tanggal_pengajuan_seminar)->isoFormat('D MMMM eateries') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500 dark:text-gray-400">Usulan Jadwal dari Mahasiswa:</p>
                            <p class="text-gray-900 dark:text-white font-medium">
                                @if($seminar->tanggal_seminar && $seminar->jam_mulai)
                                    {{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('dddd, D MMMM eateries') }},
                                    Pukul {{ \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') }} - {{ $seminar->jam_selesai ? \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '' }},
                                    Ruang: {{ $seminar->ruangan ?? 'N/A' }}
                                @else
                                    - (Belum ada usulan jadwal dari mahasiswa) -
                                @endif
                            </p>
                        </div>
                        @if($seminar->catatan_mahasiswa)
                            <div class="md:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Catatan dari Mahasiswa:</p>
                                <p class="text-gray-900 dark:text-white font-medium whitespace-pre-wrap">{{ $seminar->catatan_mahasiswa }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Form Persetujuan Dosen Pembimbing atau Tampilan Detail Keputusan --}}
                <div class="p-4 sm:p-6">
                    @if ($isEditableByDospem)
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Form Persetujuan Dosen Pembimbing</h3>
                        <form action="{{ route('dosen-pembimbing.seminar-approval.process', $seminar->id) }}" method="POST">
                            @csrf
                            <div class="grid gap-6 mb-6">
                                <div>
                                    <label for="tindakan_dospem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tindakan Anda <span class="text-red-500">*</span></label>
                                    <select id="tindakan_dospem" name="tindakan_dospem" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" required>
                                        <option value="">-- Pilih Tindakan --</option>
                                        <option value="setuju" {{ old('tindakan_dospem') == 'setuju' ? 'selected' : '' }}>Setujui Pengajuan Seminar</option>
                                        <option value="tolak" {{ old('tindakan_dospem') == 'tolak' ? 'selected' : '' }}>Tolak Pengajuan Seminar (Minta Revisi/Pengajuan Ulang)</option>
                                    </select>
                                    @error('tindakan_dospem') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div id="catatan_dospem_div" class="mb-6">
                                <label for="catatan_dospem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan Dosen Pembimbing (Wajib diisi jika menolak, opsional jika setuju)</label>
                                <textarea id="catatan_dospem" name="catatan_dospem" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600">{{ old('catatan_dospem') }}</textarea>
                                @error('catatan_dospem') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex items-center space-x-4">
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Simpan Keputusan
                                </button>
                                <a href="{{ route('dosen-pembimbing.seminar-approval.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                    Kembali
                                </a>
                            </div>
                        </form>
                    @else
                        {{-- Tampilkan Detail Keputusan Dosen Pembimbing (Read-Only) --}}
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Hasil Keputusan Dosen Pembimbing</h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">Status Persetujuan:</p>
                                @if($seminar->status_pengajuan == 'disetujui_dospem')
                                    <p class="font-medium text-green-600 dark:text-green-400">Disetujui oleh Anda pada {{ $seminar->dospem_approved_at ? \Carbon\Carbon::parse($seminar->dospem_approved_at)->isoFormat('D MMMM YYYY, HH:mm') : '' }}</p>
                                @elseif($seminar->status_pengajuan == 'ditolak_dospem')
                                    <p class="font-medium text-red-600 dark:text-red-400">Ditolak oleh Anda</p>
                                @else
                                    <p class="font-medium text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $seminar->status_pengajuan)) }} (Diproses Pihak Lain)</p>
                                @endif
                            </div>
                            @if($seminar->catatan_dospem)
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Catatan Dosen Pembimbing:</p>
                                    <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $seminar->catatan_dospem }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('dosen-pembimbing.seminar-approval.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                Kembali ke Daftar
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
