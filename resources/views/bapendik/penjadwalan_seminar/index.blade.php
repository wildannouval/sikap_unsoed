@extends('main.app')

@section('title', 'Penjadwalan Seminar KP')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Container agar memenuhi ruang --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Pengajuan Seminar (Siap Dijadwalkan)</h2>
                    {{-- Tidak ada tombol Tambah Baru di sini --}}
                </div>

                <div class="px-4 pt-4">
                    @include('partials.session-messages') {{-- Menampilkan pesan sukses/error --}}
                </div>

                {{-- Form Search dan Filter --}}
                <form method="GET" action="{{ route('bapendik.penjadwalan-seminar.index') }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 p-4">
                        <div>
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari (Nama/NIM/Judul)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ $request->search ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Kata kunci...">
                            </div>
                        </div>
                        <div>
                            <label for="jurusan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter Jurusan</label>
                            <select name="jurusan_id" id="jurusan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Semua Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ ($request->jurusan_id ?? '') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status_filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Pengajuan</label>
                            @php
                                // Tentukan nilai terpilih:
                                // 1. Jika parameter ada di URL, gunakan nilainya.
                                // 2. Jika tidak ada, default ke 'disetujui_dospem'.
                                $selectedValue = request()->has('status_filter')
                                                ? request('status_filter')
                                                : 'disetujui_dospem';
                            @endphp
                            <select name="status_filter" id="status_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="" {{ $selectedValue == '' ? 'selected' : '' }}>Semua Status Relevan</option>
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ $selectedValue == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full md:w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-150">
                                Filter
                            </button>
                            @if(request()->filled('search') || request()->filled('status_filter') || request()->filled('jurusan_id'))
                                <a href="{{ route('bapendik.penjadwalan-seminar.index') }}" class="ml-2 w-full md:w-auto text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 transition-colors duration-150">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Tgl. Disetujui Dospem</th>
                            <th scope="col" class="px-6 py-3">Mahasiswa</th>
                            <th scope="col" class="px-6 py-3">Judul KP Final</th>
                            <th scope="col" class="px-6 py-3">Pembimbing</th>
                            <th scope="col" class="px-6 py-3">Usulan Jadwal (dari Mhs)</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($seminarApplications as $seminar)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ $seminar->dospem_approved_at ? \Carbon\Carbon::parse($seminar->dospem_approved_at)->isoFormat('D MMM YY, HH:mm') : ($seminar->tanggal_pengajuan_seminar ? \Carbon\Carbon::parse($seminar->tanggal_pengajuan_seminar)->isoFormat('D MMM YY') : 'N/A') }}</td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $seminar->mahasiswa->user->name ?? 'N/A' }}</span><br>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">NIM: {{ $seminar->mahasiswa->nim ?? 'N/A' }}</span><br>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $seminar->mahasiswa->jurusan->nama ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4">{{ Str::limit($seminar->judul_kp_final, 30) }}</td>
                                <td class="px-6 py-4">{{ $seminar->pengajuanKp->dosenPembimbing->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-xs">
                                    @if($seminar->tanggal_seminar && $seminar->jam_mulai) {{-- Ini adalah usulan mahasiswa atau jadwal final --}}
                                    Tgl: {{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('D MMM YY') }}<br>
                                    Jam: {{ \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') }} - {{ $seminar->jam_selesai ? \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '' }}<br>
                                    Ruang: {{ $seminar->ruangan ?? '-' }}
                                    @else
                                        (Belum ada usulan)
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($seminar->status_pengajuan == 'disetujui_dospem')
                                        <span class="bg-sky-100 text-sky-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-sky-900 dark:text-sky-300">Menunggu Dijadwalkan</span>
                                    @elseif($seminar->status_pengajuan == 'dijadwalkan_bapendik')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Sudah Dijadwalkan</span>
                                    @elseif($seminar->status_pengajuan == 'revisi_jadwal_bapendik')
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-orange-900 dark:text-orange-300">Revisi Jadwal</span>
                                    @elseif($seminar->status_pengajuan == 'dibatalkan')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Dibatalkan</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $seminar->status_pengajuan)) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    {{-- Tombol untuk memproses/mengedit jadwal --}}
                                    <a href="{{ route('bapendik.penjadwalan-seminar.editJadwal', $seminar->id) }}" class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 mb-1 md:mb-0 md:me-1 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-150">
                                        <svg class="w-3.5 h-3.5 mr-1 -ml-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        {{ ($seminar->status_pengajuan == 'dijadwalkan_bapendik' || $seminar->status_pengajuan == 'revisi_jadwal_bapendik') ? 'Edit Jadwal' : 'Tetapkan Jadwal' }}
                                    </a>

                                    {{-- KEMBALIKAN TOMBOL EXPORT INI --}}
                                    @if($seminar->status_pengajuan == 'dijadwalkan_bapendik' || $seminar->status_pengajuan == 'selesai_dinilai')
                                        <a href="{{ route('bapendik.penjadwalan-seminar.exportBeritaAcaraWord', $seminar->id) }}" class="inline-flex items-center text-white bg-teal-600 hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 font-medium rounded-lg text-xs px-3 py-1.5 mb-1 md:mb-0 dark:bg-teal-500 dark:hover:bg-teal-600 focus:outline-none dark:focus:ring-teal-800 transition-colors duration-150" target="_blank" title="Export Blangko Berita Acara">
                                            <svg class="w-3.5 h-3.5 mr-1.5 -ml-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                                            Blangko BA
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada pengajuan seminar yang perlu diproses.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $seminarApplications->appends(request()->query())->links() }}
                </nav>
            </div>
        </div>
    </section>

    {{-- Modal konfirmasi tidak langsung digunakan di halaman index ini, kecuali ada aksi delete massal --}}
    {{-- Modal sukses akan dipanggil jika ada flash message dari controller --}}
    @if(session('success_modal_message'))
        @include('partials.modal-success')
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success_modal_message'))
            const successModalEl = document.getElementById('successModal'); // Pastikan ID ini ada di partials.modal-success
            const successModalMessageEl = document.getElementById('successModalMessage'); // Pastikan ID ini ada di partials.modal-success
            if (successModalEl && successModalMessageEl) {
                successModalMessageEl.textContent = "{{ session('success_modal_message') }}";
                const successModal = new Modal(successModalEl, {});
                successModal.show();
            }
            @endif
        });
    </script>
@endpush
