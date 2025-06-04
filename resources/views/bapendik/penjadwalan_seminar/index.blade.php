@extends('main.app')

@section('title', 'Penjadwalan Seminar KP')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Daftar Pengajuan Seminar untuk Dijadwalkan</h2>
                </div>

                @if (session('success'))
                    <div class="p-4 mx-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="p-4 mx-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Form Search dan Filter --}}
                <form method="GET" action="{{ route('bapendik.penjadwalan-seminar.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4">
                        <div>
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari (Nama/NIM/Judul)</label>
                            <input type="text" name="search" id="search" value="{{ $request->search ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Kata kunci...">
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
                            <select name="status_filter" id="status_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Semua Status Relevan</option>
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ ($request->status_filter ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Tgl. Setuju Dospem</th>
                            <th scope="col" class="px-4 py-3">Mahasiswa</th>
                            <th scope="col" class="px-4 py-3">Judul KP Final</th>
                            <th scope="col" class="px-4 py-3">Pembimbing</th>
                            <th scope="col" class="px-4 py-3">Usulan Jadwal Mhs</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($seminarApplications as $seminar)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ $seminar->dospem_approved_at ? \Carbon\Carbon::parse($seminar->dospem_approved_at)->isoFormat('D MMM YY, HH:mm') : 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $seminar->mahasiswa->user->name ?? 'N/A' }}</span><br>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $seminar->mahasiswa->nim ?? 'N/A' }}</span><br>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $seminar->mahasiswa->jurusan->nama ?? 'N/A' }}</span>
                                </td>
                                <td class="px-4 py-3">{{ Str::limit($seminar->judul_kp_final, 30) }}</td>
                                <td class="px-4 py-3">{{ $seminar->pengajuanKp->dosenPembimbing->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-xs">
                                    @if($seminar->status_pengajuan == 'disetujui_dospem' && $seminar->tanggal_seminar)
                                        Tgl: {{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('D MMM YY') }}<br>
                                        Jam: {{ \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') }} - {{ $seminar->jam_selesai ? \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '' }}<br>
                                        Ruang: {{ $seminar->ruangan ?? '-' }}
                                    @elseif($seminar->status_pengajuan == 'dijadwalkan_komisi')
                                        <span class="font-semibold text-green-600 dark:text-green-400">Final:</span><br>
                                        Tgl: {{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('D MMM YY') }}<br>
                                        Jam: {{ \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') }} - {{ $seminar->jam_selesai ? \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '' }}<br>
                                        Ruang: {{ $seminar->ruangan ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($seminar->status_pengajuan == 'disetujui_dospem')
                                        <span class="bg-sky-100 text-sky-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-sky-900 dark:text-sky-300">Disetujui Dospem</span>
                                    @elseif($seminar->status_pengajuan == 'dijadwalkan_komisi')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Dijadwalkan</span>
                                    @elseif($seminar->status_pengajuan == 'revisi_jadwal_komisi')
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">Revisi Jadwal</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $seminar->status_pengajuan)) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('bapendik.penjadwalan-seminar.editJadwal', $seminar->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800">
                                        {{ ($seminar->status_pengajuan == 'dijadwalkan_komisi' || $seminar->status_pengajuan == 'revisi_jadwal_komisi') ? 'Edit Jadwal' : 'Tetapkan Jadwal' }}
                                    </a>
                                    {{-- TOMBOL EXPORT BARU --}}
                                    @if($seminar->status_pengajuan == 'dijadwalkan_komisi')
                                        <a href="{{ route('bapendik.penjadwalan-seminar.exportBeritaAcaraWord', $seminar->id) }}" class="text-white bg-teal-600 hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 font-medium rounded-lg text-xs px-3 py-1.5 mb-1 inline-block dark:bg-teal-500 dark:hover:bg-teal-600 focus:outline-none dark:focus:ring-teal-800" target="_blank">
                                            <svg class="w-4 h-4 inline-block mr-1 -mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                                            Export Blangko BA
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada pengajuan seminar yang perlu dijadwalkan.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $seminarApplications->links() }}
                </nav>
            </div>
        </div>
    </section>
@endsection
