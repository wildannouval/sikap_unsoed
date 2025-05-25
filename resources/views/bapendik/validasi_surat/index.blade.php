@extends('main.app')

@section('title', 'Validasi Surat Pengantar')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Daftar Pengajuan Surat Pengantar KP</h2>
                </div>

                @if (session('success'))
                    <div class="p-4 mx-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Form Search dan Filter --}}
                <form method="GET" action="{{ route('bapendik.validasi-surat.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4">
                        <div>
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari (Nama/NIM/Lokasi)</label>
                            <input type="text" name="search" id="search" value="{{ $request->search }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Kata kunci...">
                        </div>
                        <div>
                            <label for="status_bapendik" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select name="status_bapendik" id="status_bapendik" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Semua Status</option>
                                <option value="menunggu" {{ $request->status_bapendik == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="disetujui" {{ $request->status_bapendik == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ $request->status_bapendik == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div>
                            <label for="jurusan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan Mahasiswa</label>
                            <select name="jurusan_id" id="jurusan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Semua Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ $request->jurusan_id == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
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
                            <th scope="col" class="px-4 py-3">Tgl. Ajuan</th>
                            <th scope="col" class="px-4 py-3">Nama Mahasiswa</th>
                            <th scope="col" class="px-4 py-3">NIM</th>
                            <th scope="col" class="px-4 py-3">Jurusan</th>
                            <th scope="col" class="px-4 py-3">Lokasi Penelitian</th>
                            <th scope="col" class="px-4 py-3">Penerima</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($suratPengantars as $surat)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($surat->tanggal_pengajuan)->isoFormat('D MMM YY') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $surat->mahasiswa->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $surat->mahasiswa->nim ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $surat->mahasiswa->jurusan->nama ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $surat->lokasi_penelitian }}</td>
                                <td class="px-4 py-3">{{ $surat->penerima_surat }}</td>
                                <td class="px-4 py-3">
                                    @if($surat->status_bapendik == 'menunggu')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Menunggu</span>
                                    @elseif($surat->status_bapendik == 'disetujui')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Disetujui</span>
                                    @elseif($surat->status_bapendik == 'ditolak')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('bapendik.validasi-surat.edit', $surat->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800">
                                        Proses
                                    </a>
                                    {{-- TOMBOL EXPORT BARU --}}
                                    @if($surat->status_bapendik == 'disetujui')
                                        <a href="{{ route('bapendik.validasi-surat.exportWord', $surat->id) }}" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 mr-1 mb-1 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none dark:focus:ring-green-800" target="_blank">
                                            Export Word
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data pengajuan surat pengantar.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $suratPengantars->links() }}
                </nav>
            </div>
        </div>
    </section>
@endsection
