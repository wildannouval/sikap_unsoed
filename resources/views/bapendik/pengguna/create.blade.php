@extends('main.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-4">
                <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-4">Tambah Pengguna Baru</h2>
                <form action="{{ route('bapendik.pengguna.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('name') }}" required>
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('email') }}" required>
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                            <select id="role" name="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="">Pilih Role</option>
                                <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            </select>
                            @error('role') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="jurusan_id" class="block mb-2 text-sm font-medium text-gray-900">Jurusan</label>
                            <select id="jurusan_id" name="jurusan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="">Pilih Jurusan</option>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                @endforeach
                            </select>
                            @error('jurusan_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Inputan dinamis untuk Mahasiswa --}}
                        <div id="mahasiswa_fields" class="grid gap-4 sm:grid-cols-2 sm:col-span-2" style="display: none;">
                            <div>
                                <label for="nim" class="block mb-2 text-sm font-medium text-gray-900">NIM</label>
                                <input type="text" name="nim" id="nim" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('nim') }}">
                                @error('nim') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            {{-- INI BAGIAN BARUNYA --}}
                            <div>
                                <label for="tahun_masuk" class="block mb-2 text-sm font-medium text-gray-900">Tahun Masuk</label>
                                <input type="number" name="tahun_masuk" id="tahun_masuk" placeholder="Contoh: 2021" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('tahun_masuk') }}">
                                @error('tahun_masuk') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Inputan dinamis untuk Dosen --}}
                        <div id="dosen_fields" class="sm:col-span-2" style="display: none;">
                            <label for="nidn" class="block mb-2 text-sm font-medium text-gray-900">NIDN</label>
                            <input type="text" name="nidn" id="nidn" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" value="{{ old('nidn') }}">
                            @error('nidn') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Simpan</button>
                    <a href="{{ route('bapendik.pengguna.index') }}" class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const mahasiswaFields = document.getElementById('mahasiswa_fields');
            const dosenFields = document.getElementById('dosen_fields');

            function toggleFields() {
                const selectedRole = roleSelect.value;
                if (selectedRole === 'mahasiswa') {
                    mahasiswaFields.style.display = 'block';
                    dosenFields.style.display = 'none';
                } else if (selectedRole === 'dosen') {
                    mahasiswaFields.style.display = 'none';
                    dosenFields.style.display = 'block';
                } else {
                    mahasiswaFields.style.display = 'none';
                    dosenFields.style.display = 'none';
                }
            }

            // Panggil saat halaman load untuk handle old value
            toggleFields();

            // Panggil saat pilihan role berubah
            roleSelect.addEventListener('change', toggleFields);
        });
    </script>
@endpush
