@extends('main.app')

@section('title', 'Validasi Pengajuan Kerja Praktek')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Daftar Pengajuan Kerja Praktek</h2>
                    {{-- Tidak ada tombol tambah, karena pengajuan datang dari mahasiswa --}}
                </div>

                @if (session('success'))
                    <div class="p-4 mx-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Form Search dan Filter --}}
                <form method="GET" action="{{ route('dosen-komisi.validasi-kp.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4">
                        <div>
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari (Nama/NIM/Judul/Instansi)</label>
                            <input type="text" name="search" id="search" value="{{ $request->search }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Kata kunci...">
                        </div>
                        <div>
                            <label for="status_komisi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status Komisi</label>
                            <select name="status_komisi" id="status_komisi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="">Semua Status</option>
                                <option value="direview" {{ $request->status_komisi == 'direview' ? 'selected' : '' }}>Direview</option>
                                <option value="diterima" {{ $request->status_komisi == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditolak" {{ $request->status_komisi == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
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
                            <th scope="col" class="px-4 py-3">Judul KP</th>
                            <th scope="col" class="px-4 py-3">Instansi</th>
                            <th scope="col" class="px-4 py-3">Status Komisi</th>
                            <th scope="col" class="px-4 py-3">Dosbing</th>
                            <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($pengajuanKps as $pengajuan)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->isoFormat('D MMM YY') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $pengajuan->mahasiswa->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $pengajuan->mahasiswa->nim ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $pengajuan->mahasiswa->jurusan->nama ?? 'N/A' }}</td>
                                <td class="px-4 py-3">{{ Str::limit($pengajuan->judul_kp, 30) }}</td>
                                <td class="px-4 py-3">{{ Str::limit($pengajuan->instansi_lokasi, 25) }}</td>
                                <td class="px-4 py-3">
                                    @if($pengajuan->status_komisi == 'direview')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Direview</span>
                                    @elseif($pengajuan->status_komisi == 'diterima')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Diterima</span>
                                    @elseif($pengajuan->status_komisi == 'ditolak')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $pengajuan->dosenPembimbing->user->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('dosen-komisi.validasi-kp.edit', $pengajuan->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800">
                                        Proses
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data pengajuan KP.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $pengajuanKps->links() }}
                </nav>
            </div>
        </div>
    </section>
@endsection
