@extends('main.app')

@section('title', 'Kelola Pengguna')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                {{-- Header Utama dan Tombol Tambah --}}
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Data Pengguna</h2>
                    <a href="{{ route('bapendik.pengguna.create') }}" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Tambah Pengguna
                    </a>
                </div>

                @if (session('success'))
                    <div class="p-4 mx-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Sistem Tab --}}
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="penggunaTab" data-tabs-toggle="#penggunaTabContent" role="tablist">
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="mahasiswa-tab" data-tabs-target="#mahasiswa" type="button" role="tab" aria-controls="mahasiswa" aria-selected="true">Mahasiswa</button>
                        </li>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="dosen-tab" data-tabs-target="#dosen" type="button" role="tab" aria-controls="dosen" aria-selected="false">Dosen</button>
                        </li>
                    </ul>
                </div>
                <div id="penggunaTabContent">
                    {{-- Konten Tab Mahasiswa --}}
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="mahasiswa" role="tabpanel" aria-labelledby="mahasiswa-tab">
                        @include('bapendik.pengguna.partials.table-mahasiswa', ['users' => $mahasiswas, 'jurusans' => $jurusans, 'request' => $request])
                    </div>
                    {{-- Konten Tab Dosen --}}
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dosen" role="tabpanel" aria-labelledby="dosen-tab">
                        @include('bapendik.pengguna.partials.table-dosen', ['users' => $dosens, 'jurusans' => $jurusans, 'request' => $request])
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('bapendik.pengguna.delete-modal')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('button[data-modal-toggle="deleteModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    const form = document.getElementById('deleteForm');
                    if (form) {
                        form.action = url;
                    }
                });
            });
        });
    </script>
@endpush
