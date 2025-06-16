@extends('main.app')

@section('title', 'Edit Profil')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Notifikasi Sukses --}}
            @if (session('status'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-300" role="alert">
                    @if (session('status') === 'profile-updated')
                        Profil berhasil diperbarui.
                    @elseif (session('status') === 'password-updated')
                        Password berhasil diperbarui.
                    @endif
                </div>
            @endif

            {{-- Grid Utama Dua Kolom --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- ======================================================================= --}}
                {{-- KOLOM KIRI: KARTU FOTO PROFIL & INFO DASAR --}}
                {{-- ======================================================================= --}}
                <div class="md:col-span-1">
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl">
                        <section class="flex flex-col items-center text-center">

                            {{-- Tampilan Foto Profil dengan Live Preview --}}
                            <div class="relative">
                                <img id="photo-preview" class="w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-lg"
                                     src="{{ Auth::user()->getProfilePhotoUrlAttribute() }}"
                                     alt="{{ Auth::user()->name }}">
                            </div>

                            @error('photo')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror

                            {{-- Info Dasar Pengguna --}}
                            <div class="mt-4">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                                <span class="mt-2 inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ ucfirst(Auth::user()->role) }}</span>
                            </div>

                            {{-- Tombol Aksi Foto --}}
                            <div class="mt-6 w-full space-y-2">
                                <label for="photo" class="w-full inline-block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center cursor-pointer dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Ganti Foto
                                </label>
                                @if(Auth::user()->profile_photo_path)
                                    <button type="submit" form="delete-photo-form" class="w-full text-xs text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400 hover:underline">
                                        Hapus Foto
                                    </button>
                                @endif
                            </div>
                        </section>
                    </div>
                </div>

                {{-- ======================================================================= --}}
                {{-- KOLOM KANAN: FORM-FORM PENGATURAN --}}
                {{-- ======================================================================= --}}
                <div class="md:col-span-2 space-y-6">

                    {{-- KARTU FORM UTAMA: INFORMASI PROFIL & DETAIL PERAN --}}
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl">
                        <form id="profile-update-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            {{-- Input file tersembunyi yang dipicu oleh tombol "Ganti Foto" --}}
                            <input type="file" name="photo" id="photo" class="hidden" accept="image/*">

                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informasi Profil</h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Perbarui informasi dasar dan detail peran Anda.</p>
                            </header>

                            <div class="mt-6 space-y-6">
                                {{-- Nama & Email --}}
                                <div>
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                                    <input id="name" name="name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('name', $user->name) }}" required>
                                    @error('name') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                    <input id="email" name="email" type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" value="{{ old('email', $user->email) }}" required>
                                    @error('email') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                </div>

                                {{-- DATA SPESIFIK MAHASISWA --}}
                                @if ($user->role === 'mahasiswa' && $user->mahasiswa)
                                    <hr class="dark:border-gray-600">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label for="nim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM</label>
                                            <input id="nim" name="nim" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('nim', $user->mahasiswa->nim) }}" required>
                                        </div>
                                        <div>
                                            <label for="tahun_masuk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Masuk</label>
                                            <input id="tahun_masuk" name="tahun_masuk" type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tahun_masuk', $user->mahasiswa->tahun_masuk) }}" required>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label for="jurusan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan</label>
                                            <select id="jurusan_id" name="jurusan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                                                @foreach ($jurusans as $jurusan)
                                                    <option value="{{ $jurusan->id }}" {{ (old('jurusan_id', $user->mahasiswa->jurusan_id) == $jurusan->id) ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="no_hp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. HP</label>
                                            <input id="no_hp" name="no_hp" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('no_hp', $user->mahasiswa->no_hp) }}">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                                            <textarea id="alamat" name="alamat" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">{{ old('alamat', $user->mahasiswa->alamat) }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                {{-- DATA SPESIFIK DOSEN --}}
                                @if ($user->role === 'dosen' && $user->dosen)
                                    <hr class="dark:border-gray-600">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label for="nidn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIDN/NIP</label>
                                            <input id="nidn" name="nidn" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('nidn', $user->dosen->nidn) }}" required>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label for="jurusan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan Homebase</label>
                                            <select id="jurusan_id" name="jurusan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                                                @foreach ($jurusans as $jurusan)
                                                    <option value="{{ $jurusan->id }}" {{ (old('jurusan_id', $user->dosen->jurusan_id) == $jurusan->id) ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label for="bidang_keahlian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bidang Keahlian</label>
                                            <input id="bidang_keahlian" name="bidang_keahlian" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('bidang_keahlian', $user->dosen->bidang_keahlian) }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                    </div>
                    </form>

                    {{-- KARTU UBAH PASSWORD --}}
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl">
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Tombol simpan global untuk Form Profil Utama --}}
                    <div class="flex justify-end">
                        <button type="submit" form="profile-update-form" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            <svg class="w-5 h-5 mr-2 -ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-14 4h14m-14-8h14H5Zm7 12a9 9 0 1 1 0-18 9 9 0 0 1 0 18Z"/></svg>
                            Simpan Semua Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form tersembunyi HANYA untuk aksi hapus foto --}}
    <form id="delete-photo-form" action="{{ route('profile.photo.destroy') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photo-preview');

            if (photoInput && photoPreview) {
                photoInput.addEventListener('change', function(event) {
                    if (event.target.files && event.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            photoPreview.src = e.target.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }
                });
            }
        });
    </script>
@endpush
