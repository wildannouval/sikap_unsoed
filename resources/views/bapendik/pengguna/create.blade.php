@extends('main.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <section class="antialiased"> {{-- Hapus padding dari section --}}
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Gunakan max-w-none dan padding yang sama --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden p-4 sm:p-6">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-6">Tambah Pengguna Baru</h2>
                <form action="{{ route('bapendik.pengguna.store') }}" method="POST">
                    @csrf
                    {{-- ... sisa field form ... --}}
                    <div class="grid gap-6 mb-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                            @error('name') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        {{-- Tambahkan field lainnya dengan styling yang konsisten --}}
                        <div class="sm:col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
                            @error('email') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('password') border-red-500 @enderror" required>
                            @error('password') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                            <select id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                                <option value="">Pilih Role</option>
                                <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="bapendik" {{ old('role') == 'bapendik' ? 'selected' : '' }}>Bapendik</option>
                                {{-- Pastikan role bapendik juga bisa dibuat jika perlu --}}
                            </select>
                            @error('role') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="jurusan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan (Wajib untuk Mahasiswa & Dosen)</label>
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
                                <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM</label>
                                <input type="text" name="nim" id="nim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('nim') }}">
                                @error('nim') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="tahun_masuk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Masuk</label>
                                <input type="number" name="tahun_masuk" id="tahun_masuk" placeholder="Contoh: 2021" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tahun_masuk') }}">
                                @error('tahun_masuk') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Inputan dinamis untuk Dosen --}}
                        <div id="dosen_fields" class="grid gap-4 sm:grid-cols-1 sm:col-span-2" style="{{ old('role') == 'dosen' ? 'display: grid;' : 'display: none;' }}">
                            <div>
                                <label for="nidn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIDN</label>
                                <input type="text" name="nidn" id="nidn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('nidn') }}">
                                @error('nidn') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- Tambahkan toggle is_komisi untuk dosen di sini jika perlu saat create, atau hanya di edit --}}
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 mt-6">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan Pengguna</button>
                        <a href="{{ route('bapendik.pengguna.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- Script toggle field mahasiswa/dosen tetap sama --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const mahasiswaFields = document.getElementById('mahasiswa_fields');
            const dosenFields = document.getElementById('dosen_fields');

            function toggleFields() {
                const selectedRole = roleSelect.value;
                if (selectedRole === 'mahasiswa') {
                    mahasiswaFields.style.display = 'grid'; // Gunakan grid agar sesuai dengan layout
                    dosenFields.style.display = 'none';
                } else if (selectedRole === 'dosen') {
                    mahasiswaFields.style.display = 'none';
                    dosenFields.style.display = 'grid'; // Gunakan grid
                } else {
                    mahasiswaFields.style.display = 'none';
                    dosenFields.style.display = 'none';
                }
            }
            if(roleSelect) { // Pastikan roleSelect ada sebelum menambahkan event listener
                toggleFields(); // Panggil saat halaman load untuk handle old value
                roleSelect.addEventListener('change', toggleFields);
            }
        });
    </script>
@endpush
