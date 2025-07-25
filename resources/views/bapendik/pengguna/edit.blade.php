@extends('main.app')

@section('title', 'Edit Pengguna - ' . $pengguna->name)

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="p-4 sm:p-6 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Data Pengguna: <span class="font-normal">{{ $pengguna->name }}</span></h2>
                </div>

                <form action="{{ route('bapendik.pengguna.update', $pengguna->id) }}" method="POST" class="p-4 sm:p-6">
                    @csrf
                    @method('PUT')

                    {{-- Menampilkan error validasi form --}}
                    <div class="pb-4">
                        @include('partials.session-messages')
                    </div>

                    {{-- Informasi Akun Dasar dari Tabel Users --}}
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('name') border-red-500 @enderror" value="{{ old('name', $pengguna->name) }}" required>
                            @error('name') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('email') border-red-500 @enderror" value="{{ old('email', $pengguna->email) }}" required>
                            @error('email') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                            <input type="text" class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-300 cursor-not-allowed" value="{{ ucfirst($pengguna->role) }}" readonly>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Role tidak dapat diubah.</p>
                        </div>

                        @if($pengguna->role === 'mahasiswa' || $pengguna->role === 'dosen')
                            <div>
                                <label for="jurusan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan <span class="text-red-500">*</span></label>
                                <select id="jurusan_id" name="jurusan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('jurusan_id') border-red-500 @enderror" required>
                                    <option value="">-- Pilih Jurusan --</option>
                                    @php
                                        $selectedJurusanId = old('jurusan_id', $pengguna->mahasiswa->jurusan_id ?? $pengguna->dosen->jurusan_id ?? null);
                                    @endphp
                                    @foreach ($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}" {{ $selectedJurusanId == $jurusan->id ? 'selected' : '' }}>
                                            {{ $jurusan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jurusan_id') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                        @endif
                    </div>

                    {{-- DATA SPESIFIK MAHASISWA --}}
                    @if ($pengguna->role === 'mahasiswa' && $pengguna->mahasiswa)
                        <hr class="my-6 border-gray-200 dark:border-gray-700">
                        <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Data Detail Mahasiswa</h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM <span class="text-red-500">*</span></label>
                                <input type="text" name="nim" id="nim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('nim') border-red-500 @enderror" value="{{ old('nim', $pengguna->mahasiswa->nim) }}" required>
                                @error('nim') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="tahun_masuk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Masuk <span class="text-red-500">*</span></label>
                                <input type="number" name="tahun_masuk" id="tahun_masuk" placeholder="YYYY" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('tahun_masuk') border-red-500 @enderror" value="{{ old('tahun_masuk', $pengguna->mahasiswa->tahun_masuk) }}" required min="1900" max="{{ date('Y') + 1 }}">
                                @error('tahun_masuk') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. HP</label>
                                <input type="text" name="no_hp" id="no_hp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('no_hp', $pengguna->mahasiswa->no_hp) }}" placeholder="08...">
                                @error('no_hp') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                                <textarea id="alamat" name="alamat" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">{{ old('alamat', $pengguna->mahasiswa->alamat) }}</textarea>
                                @error('alamat') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @endif

                    {{-- DATA SPESIFIK DOSEN --}}
                    @if ($pengguna->role === 'dosen' && $pengguna->dosen)
                        <hr class="my-6 border-gray-200 dark:border-gray-700">
                        <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Data Detail Dosen</h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="nidn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIDN/NIP <span class="text-red-500">*</span></label>
                                <input type="text" name="nidn" id="nidn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 @error('nidn') border-red-500 @enderror" value="{{ old('nidn', $pengguna->dosen->nidn) }}" required>
                                @error('nidn') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="bidang_keahlian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bidang Keahlian</label>
                                <input type="text" name="bidang_keahlian" id="bidang_keahlian" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('bidang_keahlian', $pengguna->dosen->bidang_keahlian) }}">
                                @error('bidang_keahlian') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="is_komisi" class="flex items-center cursor-pointer">
                                    <input id="is_komisi" name="is_komisi" type="checkbox" value="1" class="sr-only peer" {{ old('is_komisi', $pengguna->dosen->is_komisi) ? 'checked' : '' }}>
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-500 peer-checked:bg-blue-600"></div>
                                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Jadikan Anggota Komisi KP</span>
                                </label>
                                @error('is_komisi') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center space-x-4 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                            Update Pengguna
                        </button>
                        <a href="{{ route('bapendik.pengguna.index', ['active_tab' => $pengguna->role]) }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
