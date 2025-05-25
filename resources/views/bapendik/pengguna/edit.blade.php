@extends('main.app')

@section('title', 'Edit Pengguna')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-4">Edit Pengguna: {{ $pengguna->name }}</h2>
                <form action="{{ route('bapendik.pengguna.update', $pengguna->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('name', $pengguna->name) }}" required>
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('email', $pengguna->email) }}" required>
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                            <input type="text" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ ucfirst($pengguna->role) }}" readonly>
                            <p class="mt-1 text-xs text-gray-500">Role tidak dapat diubah.</p>
                        </div>
                        <div>
                            <label for="jurusan_id" class="block mb-2 text-sm font-medium text-gray-900">Jurusan</label>
                            <select id="jurusan_id" name="jurusan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                @php
                                    $selectedJurusan = old('jurusan_id', $pengguna->mahasiswa->jurusan_id ?? $pengguna->dosen->jurusan_id ?? '');
                                @endphp
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ $selectedJurusan == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                @endforeach
                            </select>
                            @error('jurusan_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- PERHATIKAN BAGIAN INI --}}
                        @if($pengguna->role === 'mahasiswa' && $pengguna->mahasiswa)
                            <div class="sm:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4"> {{-- Menjadikan grid agar sejajar --}}
                                <div>
                                    <label for="nim" class="block mb-2 text-sm font-medium text-gray-900">NIM</label>
                                    <input type="text" name="nim" id="nim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('nim', $pengguna->mahasiswa->nim) }}">
                                    @error('nim') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                {{-- TAMBAHKAN INPUT TAHUN MASUK DI SINI --}}
                                <div>
                                    <label for="tahun_masuk" class="block mb-2 text-sm font-medium text-gray-900">Tahun Masuk</label>
                                    <input type="number" name="tahun_masuk" id="tahun_masuk" placeholder="Contoh: 2021" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('tahun_masuk', $pengguna->mahasiswa->tahun_masuk) }}">
                                    @error('tahun_masuk') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        @elseif($pengguna->role === 'dosen' && $pengguna->dosen)
                            <div class="sm:col-span-2">
                                <label for="nidn" class="block mb-2 text-sm font-medium text-gray-900">NIDN</label>
                                <input type="text" name="nidn" id="nidn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('nidn', $pengguna->dosen->nidn) }}">
                                @error('nidn') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Update</button>
                    <a href="{{ route('bapendik.pengguna.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                </form>
            </div>
        </div>
    </section>
@endsection
