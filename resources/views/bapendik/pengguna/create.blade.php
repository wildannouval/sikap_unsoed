@extends('main.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden p-4 sm:p-6">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-6">Tambah Pengguna Baru</h2>
                <form action="{{ route('bapendik.pengguna.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-6 mb-4 sm:grid-cols-2">
                        {{-- Field Akun Dasar --}}
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                            @error('name') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                            @error('email') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('password') border-red-500 @enderror" required>
                            @error('password') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role <span class="text-red-500">*</span></label>
                            <select id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                                <option value="">Pilih Role</option>
                                <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            </select>
                            @error('role') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="jurusan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan (Wajib untuk Mahasiswa & Dosen) <span class="text-red-500">*</span></label>
                            <select id="jurusan_id" name="jurusan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                @endforeach
                            </select>
                            @error('jurusan_id') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Inputan dinamis untuk Mahasiswa --}}
                        <div id="mahasiswa_fields" class="grid gap-4 sm:grid-cols-2 sm:col-span-2" style="{{ old('role') == 'mahasiswa' ? 'display: grid;' : 'display: none;' }}">
                            <div>
                                <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM <span class="text-red-500">*</span></label>
                                <input type="text" name="nim" id="nim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('nim') }}">
                                @error('nim') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="tahun_masuk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Masuk <span class="text-red-500">*</span></label>
                                <input type="number" name="tahun_masuk" id="tahun_masuk" placeholder="Contoh: 2021" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tahun_masuk') }}">
                                @error('tahun_masuk') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- TAMBAHAN: FIELD NO HP --}}
                            <div class="sm:col-span-2">
                                <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. HP (Opsional)</label>
                                <input type="text" name="no_hp" id="no_hp" placeholder="08..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('no_hp') }}">
                                @error('no_hp') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- TAMBAHAN: FIELD ALAMAT --}}
                            <div class="sm:col-span-2">
                                <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat (Opsional)</label>
                                <textarea name="alamat" id="alamat" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" placeholder="Alamat lengkap...">{{ old('alamat') }}</textarea>
                                @error('alamat') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Inputan dinamis untuk Dosen --}}
                        <div id="dosen_fields" class="grid gap-4 sm:grid-cols-1 sm:col-span-2" style="{{ old('role') == 'dosen' ? 'display: grid;' : 'display: none;' }}">
                            <div>
                                <label for="nidn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIDN <span class="text-red-500">*</span></label>
                                <input type="text" name="nidn" id="nidn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('nidn') }}">
                                @error('nidn') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- TAMBAHAN: FIELD BIDANG KEAHLIAN --}}
                            <div>
                                <label for="bidang_keahlian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bidang Keahlian (Opsional)</label>
                                <input type="text" name="bidang_keahlian" id="bidang_keahlian" placeholder="Contoh: Rekayasa Perangkat Lunak, Jaringan Komputer" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('bidang_keahlian') }}">
                                @error('bidang_keahlian') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    {{-- Tombol Aksi --}}
                    <div class="flex items-center space-x-4 mt-6">
                        <button type="submit" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Simpan Pengguna
                        </button>
                        <a href="{{ route('bapendik.pengguna.index') }}" class="inline-flex items-center text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- Script untuk toggle field, sekarang menghandle textarea juga --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const mahasiswaFields = document.getElementById('mahasiswa_fields');
            const dosenFields = document.getElementById('dosen_fields');
            // PERBAIKAN: Sertakan textarea saat memilih elemen input
            const mahasiswaInputs = mahasiswaFields.querySelectorAll('input, textarea');
            const dosenInputs = dosenFields.querySelectorAll('input, textarea');

            function toggleFields() {
                const selectedRole = roleSelect.value;
                if (selectedRole === 'mahasiswa') {
                    mahasiswaFields.style.display = 'grid';
                    mahasiswaInputs.forEach(input => input.disabled = false);
                    dosenFields.style.display = 'none';
                    dosenInputs.forEach(input => input.disabled = true);
                } else if (selectedRole === 'dosen') {
                    mahasiswaFields.style.display = 'none';
                    mahasiswaInputs.forEach(input => input.disabled = true);
                    dosenFields.style.display = 'grid';
                    dosenInputs.forEach(input => input.disabled = false);
                } else {
                    mahasiswaFields.style.display = 'none';
                    mahasiswaInputs.forEach(input => input.disabled = true);
                    dosenFields.style.display = 'none';
                    dosenInputs.forEach(input => input.disabled = true);
                }
            }

            if(roleSelect) {
                toggleFields();
                roleSelect.addEventListener('change', toggleFields);
            }
        });
    </script>
@endpush
