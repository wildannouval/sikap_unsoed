@extends('main.app')

@section('title', 'Pusat Export Laporan')

@section('content')
    <div class="p-4 sm:p-6 space-y-6">
        {{-- Form Filter --}}
        <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden p-4 sm:p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Filter Laporan Kerja Praktek</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Pilih kriteria di bawah untuk menampilkan preview data sebelum diekspor.</p>

            <form action="{{ route('dosen.komisi.laporan.index') }}" method="GET">
                {{-- Input tersembunyi untuk menandai bahwa filter telah diterapkan --}}
                <input type="hidden" name="filter" value="true">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Filter Jurusan --}}
                    <div>
                        <label for="jurusan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan</label>
                        <select name="jurusan_id" id="jurusan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                            <option value="">Semua Jurusan</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Filter Status KP --}}
                    <div>
                        <label for="status_kp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status KP</label>
                        <select name="status_kp" id="status_kp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                            <option value="">Semua Status</option>
                            @foreach ($kpStatuses as $status)
                                <option value="{{ $status }}" {{ request('status_kp') == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$status)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Filter Rentang Tanggal --}}
                    <div>
                        <label for="tanggal_mulai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Periode Mulai Dari</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sampai Dengan</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                </div>
                <div class="mt-6 flex items-center space-x-4">
                    <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        <svg class="w-5 h-5 mr-2 -ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14v.01M14 14v.01M10 10v.01M14 10v.01M4 18h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1Z"/></svg>
                        Tampilkan Data
                    </button>
                    <a href="{{ route('dosen.komisi.laporan.index') }}" class="text-sm text-gray-500 hover:underline dark:text-gray-400">Reset Filter</a>
                </div>
            </form>
        </div>

        {{-- Tabel Preview Data --}}
        @if (isset($pengajuanKps))
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Hasil Preview ({{ $pengajuanKps->total() }} Data Ditemukan)</h3>
                    {{-- Tombol Export hanya muncul jika ada data --}}
                    @if(!$pengajuanKps->isEmpty())
                        <a href="{{ route('dosen.komisi.laporan.export-kp', request()->query()) }}" class="inline-flex items-center text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg class="w-5 h-5 mr-2 -ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
                            Export ke Excel
                        </a>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">NIM</th>
                            <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                            <th scope="col" class="px-6 py-3">Judul KP</th>
                            <th scope="col" class="px-6 py-3">Dospem</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($pengajuanKps as $kp)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ $kp->mahasiswa->nim ?? '-' }}</td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $kp->mahasiswa->user->name ?? '-' }}</th>
                                <td class="px-6 py-4">{{ Str::limit($kp->judul_kp, 40) }}</td>
                                <td class="px-6 py-4">{{ $kp->dosenPembimbing->user->name ?? '-' }}</td>
                                <td class="px-6 py-4">
                                <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded-full
                                @if($kp->status_kp == 'lulus') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @elseif($kp->status_kp == 'tidak_lulus') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 @endif">
                                    {{ ucfirst(str_replace('_',' ',$kp->status_kp)) }}
                                </span>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data yang cocok dengan filter yang Anda pilih.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($pengajuanKps->hasPages())
                    <nav class="p-4" aria-label="Table navigation">
                        {{ $pengajuanKps->links() }}
                    </nav>
                @endif
            </div>
        @endif
    </div>
@endsection
