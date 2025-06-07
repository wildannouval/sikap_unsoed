@extends('main.app')

@section('title', 'Daftar Mahasiswa Bimbingan KP')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Container agar memenuhi ruang --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Mahasiswa Bimbingan Kerja Praktek Aktif</h2>
                    {{-- Tidak ada tombol Tambah di sini karena mahasiswa ditugaskan oleh Komisi --}}
                </div>

                <div class="px-4 pt-4">
                    @include('partials.session-messages')
                </div>

                {{-- Form Search --}}
                <form method="GET" action="{{ route('dosen-pembimbing.bimbingan-kp.index') }}">
                    <div class="flex flex-col md:flex-row items-end space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <label for="search_bimbingan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari Mahasiswa/Judul KP</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input type="text" name="search" id="search_bimbingan" value="{{ $request->search ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Nama mahasiswa, NIM, atau judul KP...">
                            </div>
                        </div>
                        <div class="w-full md:w-auto">
                            <button type="submit" class="w-full md:w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-150">
                                Cari
                            </button>
                            @if(request()->filled('search'))
                                <a href="{{ route('dosen-pembimbing.bimbingan-kp.index') }}" class="ml-2 w-full md:w-auto text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 transition-colors duration-150">
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
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Nama Mahasiswa</th>
                            <th scope="col" class="px-6 py-3">NIM</th>
                            <th scope="col" class="px-6 py-3">Jurusan</th>
                            <th scope="col" class="px-6 py-3">Judul KP</th>
                            <th scope="col" class="px-6 py-3">Instansi</th>
                            <th scope="col" class="px-6 py-3">Status KP</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($pengajuanKps as $pengajuan)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $loop->iteration + $pengajuanKps->firstItem() - 1 }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $pengajuan->mahasiswa->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $pengajuan->mahasiswa->nim ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $pengajuan->mahasiswa->jurusan->nama ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ Str::limit($pengajuan->judul_kp, 30) }}</td>
                                <td class="px-6 py-4">{{ Str::limit($pengajuan->instansi_lokasi, 25) }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ ucfirst(str_replace('_', ' ', $pengajuan->status_kp)) }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('dosen-pembimbing.bimbingan-kp.konsultasi.show', $pengajuan->id) }}" class="inline-flex items-center text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none dark:focus:ring-indigo-800 transition-colors duration-150">
                                        <svg class="w-3.5 h-3.5 mr-1.5 -ml-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M18 5.923A1.99 1.99 0 0 0 16.084 4H3.916A1.99 1.99 0 0 0 2 5.923V14.08A1.99 1.99 0 0 0 3.916 16h12.168A1.99 1.99 0 0 0 18 14.079V5.923Zm-7.15.619L14.084 10h-3.5L7.15 6.542ZM5.014 13.318a1.001 1.001 0 0 1-.992-.993V7.671a1 1 0 0 1 .992-.993l4.893-2.446a1 1 0 0 1 1.21.001l4.893 2.446a1 1 0 0 1 .992.993v4.654a1.001 1.001 0 0 1-.992.993L5.014 13.318Z"/></svg>
                                        Lihat Konsultasi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada mahasiswa bimbingan KP yang aktif.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $pengajuanKps->appends(request()->query())->links() }}
                </nav>
            </div>
        </div>
    </section>

    {{-- Modal sukses akan dipanggil jika ada flash message 'success_modal_message' dari controller (misalnya setelah verifikasi konsultasi) --}}
    @if(session('success_modal_message'))
        @include('partials.modal-success')
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success_modal_message'))
            const successModalEl = document.getElementById('successModal');
            const successModalMessageEl = document.getElementById('successModalMessage');
            if (successModalEl && successModalMessageEl) {
                successModalMessageEl.textContent = @json(session('success_modal_message'));
                const successModal = new Modal(successModalEl, {});
                successModal.show();
            }
            @endif
        });
    </script>
@endpush
