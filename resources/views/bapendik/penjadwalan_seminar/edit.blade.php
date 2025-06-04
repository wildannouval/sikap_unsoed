@extends('main.app')

@section('title', 'Tetapkan Jadwal Seminar KP')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-lg px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Formulir Penetapan Jadwal Seminar Kerja Praktek</h2>
                </div>

                {{-- Detail Pengajuan dari Mahasiswa & Dospem --}}
                <div class="p-4 sm:p-6 mb-6 border-b dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Detail Pengajuan Seminar</h3>
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
                            <p class="text-gray-500 dark:text-gray-400">Dosen Pembimbing:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $seminar->pengajuanKp->dosenPembimbing->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Draft Laporan KP:</p>
                            @if($seminar->draft_laporan_path)
                                <a href="{{ Storage::url($seminar->draft_laporan_path) }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-500 dark:hover:text-blue-400 underline">Lihat Draft</a>
                            @else
                                <p class="text-gray-900 dark:text-white font-medium">-</p>
                            @endif
                        </div>
                        @if($seminar->catatan_mahasiswa)
                            <div class="md:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Catatan dari Mahasiswa:</p>
                                <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $seminar->catatan_mahasiswa }}</p>
                            </div>
                        @endif
                        @if($seminar->catatan_dospem)
                            <div class="md:col-span-2">
                                <p class="text-gray-500 dark:text-gray-400">Catatan dari Dosen Pembimbing:</p>
                                <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $seminar->catatan_dospem }}</p>
                            </div>
                        @endif
                        <div class="md:col-span-2">
                            <p class="text-gray-500 dark:text-gray-400">Status Saat Ini:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ ucfirst(str_replace('_', ' ', $seminar->status_pengajuan)) }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500 dark:text-gray-400">Usulan Jadwal dari Mahasiswa (Telah Disetujui Dospem):</p>
                            <p class="text-gray-900 dark:text-white font-medium bg-yellow-50 dark:bg-yellow-900 p-2 rounded-md">
                                @if($seminar->status_pengajuan == 'disetujui_dospem' && $seminar->tanggal_seminar && $seminar->jam_mulai)
                                    Tgl: {{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('D MMM YY') }},
                                    Jam: {{ \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') }} - {{ $seminar->jam_selesai ? \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '' }},
                                    Ruang: {{ $seminar->ruangan ?? 'N/A' }}
                                @else
                                    (Tidak ada usulan jadwal awal yang valid atau status bukan menunggu penjadwalan)
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Form Penetapan Jadwal Final --}}
                <form action="{{ route('bapendik.penjadwalan-seminar.updateJadwal', $seminar->id) }}" method="POST" class="p-4 sm:p-6">
                    @csrf
                    @method('PUT')
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Input Jadwal Seminar Final</h3>

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="tanggal_seminar" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Seminar Final <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_seminar" id="tanggal_seminar" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tanggal_seminar', $seminar->tanggal_seminar ? \Carbon\Carbon::parse($seminar->tanggal_seminar)->format('Y-m-d') : '') }}" required>
                            @error('tanggal_seminar') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="ruangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ruangan Seminar <span class="text-red-500">*</span></label>
                            <select name="ruangan" id="ruangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" required>
                                <option value="">-- Pilih Ruangan Final --</option>
                                @foreach ($daftarRuangan as $itemRuangan)
                                    <option value="{{ $itemRuangan->nama_ruangan }}"
                                        {{ (old('ruangan', $seminar->ruangan) == $itemRuangan->nama_ruangan) ? 'selected' : '' }}
                                        {{ !$itemRuangan->is_tersedia ? 'disabled class=text-gray-400' : '' }}>
                                        {{ $itemRuangan->nama_ruangan }}
                                        {{ $itemRuangan->lokasi_gedung ? '('.$itemRuangan->lokasi_gedung.')' : '' }}
                                        {{ !$itemRuangan->is_tersedia ? '[Tidak Tersedia Umum]' : '' }}
                                    </option>
                                @endforeach
                                {{-- Opsi untuk input manual jika diperlukan --}}
                                {{-- <option value="INPUT_MANUAL_RUANGAN">Lainnya (Isi Manual)</option> --}}
                            </select>
                            {{-- Jika ada opsi "Lainnya", tambahkan input teks yang muncul jika 'Lainnya' dipilih --}}
                            @error('ruangan') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="jam_mulai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Mulai Final <span class="text-red-500">*</span></label>
                            <input type="time" name="jam_mulai" id="jam_mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('jam_mulai', $seminar->jam_mulai ? \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') : '') }}" required>
                            @error('jam_mulai') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="jam_selesai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jam Selesai Final <span class="text-red-500">*</span></label>
                            <input type="time" name="jam_selesai" id="jam_selesai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('jam_selesai', $seminar->jam_selesai ? \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '') }}" required>
                            @error('jam_selesai') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="catatan_komisi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan Tambahan dari Bapendik/Komisi (Opsional)</label>
                        <textarea id="catatan_komisi" name="catatan_komisi" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600">{{ old('catatan_komisi', $seminar->catatan_komisi) }}</textarea>
                        @error('catatan_komisi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tempat untuk memilih Dosen Penguji bisa ditambahkan di sini nanti --}}

                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan & Tetapkan Jadwal
                        </button>
                        <a href="{{ route('bapendik.penjadwalan-seminar.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
