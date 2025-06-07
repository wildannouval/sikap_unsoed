@extends('main.app')

@section('title', 'Manajemen Ruangan Seminar')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Container agar memenuhi ruang --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Data Ruangan Seminar</h2>
                    <a href="{{ route('bapendik.ruangan.create') }}" class="inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-150">
                        <svg class="h-4 w-4 mr-2 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" /></svg>
                        Tambah Ruangan
                    </a>
                </div>

                <div class="px-4 pt-4">
                    @include('partials.session-messages')
                </div>

                {{-- Form Search --}}
                <form method="GET" action="{{ route('bapendik.ruangan.index') }}">
                    <div class="flex flex-col md:flex-row items-end space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div class="w-full md:w-1/2">
                            <label for="search_ruangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari Ruangan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input type="text" name="search" id="search_ruangan" value="{{ $request->search ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari nama, lokasi, atau fasilitas...">
                            </div>
                        </div>
                        <div class="w-full md:w-auto">
                            <button type="submit" class="w-full md:w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-150">
                                Cari
                            </button>
                            @if(request()->filled('search')) {{-- Menggunakan request() helper --}}
                            <a href="{{ route('bapendik.ruangan.index') }}" class="ml-2 w-full md:w-auto text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800 transition-colors duration-150">
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
                            <th scope="col" class="px-6 py-3">Nama Ruangan</th>
                            <th scope="col" class="px-6 py-3">Lokasi/Gedung</th>
                            <th scope="col" class="px-6 py-3">Kapasitas</th>
                            <th scope="col" class="px-6 py-3">Fasilitas</th>
                            <th scope="col" class="px-6 py-3">Status Ketersediaan</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($ruangans as $ruangan)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $loop->iteration + $ruangans->firstItem() - 1 }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $ruangan->nama_ruangan }}</td>
                                <td class="px-6 py-4">{{ $ruangan->lokasi_gedung ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $ruangan->kapasitas ? $ruangan->kapasitas . ' orang' : '-' }}</td>
                                <td class="px-6 py-4 max-w-xs truncate">{{ Str::limit($ruangan->fasilitas, 50) ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($ruangan->is_tersedia)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Tersedia</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Tidak Tersedia</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('bapendik.ruangan.edit', $ruangan->id) }}" class="inline-flex items-center text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 dark:bg-yellow-500 dark:hover:bg-yellow-600 focus:outline-none dark:focus:ring-yellow-800 transition-colors duration-150">
                                        <svg class="w-3.5 h-3.5 mr-1 -ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        Edit
                                    </a>
                                    <button type="button"
                                            data-modal-target="deleteModal"
                                            data-modal-toggle="deleteModal"
                                            data-delete-url="{{ route('bapendik.ruangan.destroy', $ruangan->id) }}"
                                            class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-red-500 dark:hover:bg-red-600 focus:outline-none dark:focus:ring-red-900 transition-colors duration-150">
                                        <svg class="w-3.5 h-3.5 mr-1 -ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada data ruangan.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $ruangans->appends(request()->query())->links() }}
                </nav>
            </div>
        </div>
    </section>

    @include('partials.modal-delete-confirmation')

    @if(session('success_modal_message'))
        @include('partials.modal-success')
    @endif

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Untuk Modal Delete
            const deleteModalEl = document.getElementById('deleteModal');
            if (deleteModalEl) {
                document.querySelectorAll('button[data-modal-toggle="deleteModal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const url = this.dataset.deleteUrl; // Pastikan atributnya data-delete-url
                        const form = document.getElementById('deleteRecordForm');
                        if (form) {
                            form.action = url;
                        }
                    });
                });
            }

            // Untuk Modal Sukses
            @if(session('success_modal_message'))
            const successModalEl = document.getElementById('successModal');
            const successModalMessageEl = document.getElementById('successModalMessage');
            if (successModalEl && successModalMessageEl) {
                successModalMessageEl.textContent = "{{ session('success_modal_message') }}";
                const successModal = new Modal(successModalEl, {});
                successModal.show();
            }
            @endif
        });
    </script>
@endpush
