@extends('main.app') {{-- Sesuaikan dengan layout utama aplikasimu --}}

@section('title', 'Edit Profil')

@section('content')
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6"> {{-- max-w-3xl agar tidak terlalu lebar --}}

            {{-- Notifikasi Sukses Update Profil --}}
            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                     class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                    Profil berhasil diperbarui.
                </div>
            @endif
            {{-- Notifikasi Sukses Update Password (jika dari controller password) --}}
            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                     class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                    Password berhasil diperbarui.
                </div>
            @endif


            {{-- FORM UPDATE INFORMASI PROFIL --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Informasi Profil
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Perbarui informasi profil akun Anda dan alamat email.
                            </p>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            {{-- Nama --}}
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Lengkap</label>
                                <input id="name" name="name" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @error('name') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input id="email" name="email" type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                {{-- Jika pakai verifikasi email Breeze
                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div><p class="text-sm mt-2 text-gray-800 dark:text-gray-200">Email Anda belum terverifikasi. <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">Kirim ulang email verifikasi.</button></p> @if (session('status') === 'verification-link-sent')<p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">Link verifikasi baru telah dikirim.</p>@endif</div>
                                @endif
                                --}}
                            </div>

                            {{-- DATA SPESIFIK MAHASISWA --}}
                            @if ($user->role === 'mahasiswa' && $profileData)
                                <hr class="my-6 border-gray-200 dark:border-gray-700">
                                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-1">Data Kemahasiswaan</h3>
                                <div>
                                    <label for="nim" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">NIM</label>
                                    <input id="nim" name="nim" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('nim', $profileData->nim) }}" required>
                                    @error('nim') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="tahun_masuk" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun Masuk</label>
                                    <input id="tahun_masuk" name="tahun_masuk" type="number" placeholder="YYYY" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('tahun_masuk', $profileData->tahun_masuk) }}" required>
                                    @error('tahun_masuk') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="jurusan_id_mahasiswa" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan</label>
                                    <select id="jurusan_id_mahasiswa" name="jurusan_id_mahasiswa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                                        @foreach ($jurusans as $jurusan)
                                            <option value="{{ $jurusan->id }}" {{ (old('jurusan_id_mahasiswa', $profileData->jurusan_id) == $jurusan->id) ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id_mahasiswa') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="no_hp" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">No. HP</label>
                                    <input id="no_hp" name="no_hp" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('no_hp', $profileData->no_hp) }}">
                                    @error('no_hp') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="alamat" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                                    <textarea id="alamat" name="alamat" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">{{ old('alamat', $profileData->alamat) }}</textarea>
                                    @error('alamat') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                </div>
                            @endif

                            {{-- DATA SPESIFIK DOSEN --}}
                            @if ($user->role === 'dosen' && $profileData)
                                <hr class="my-6 border-gray-200 dark:border-gray-700">
                                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-1">Data Kedosenan</h3>
                                <div>
                                    <label for="nidn" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">NIDN/NIP</label>
                                    <input id="nidn" name="nidn" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('nidn', $profileData->nidn) }}" required>
                                    @error('nidn') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="jurusan_id_dosen" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Jurusan Homebase</label>
                                    <select id="jurusan_id_dosen" name="jurusan_id_dosen" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600">
                                        @foreach ($jurusans as $jurusan)
                                            <option value="{{ $jurusan->id }}" {{ (old('jurusan_id_dosen', $profileData->jurusan_id) == $jurusan->id) ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id_dosen') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="bidang_keahlian" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Bidang Keahlian</label>
                                    <input id="bidang_keahlian" name="bidang_keahlian" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600" value="{{ old('bidang_keahlian', $profileData->bidang_keahlian) }}">
                                    @error('bidang_keahlian') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                                </div>
                                @if($profileData->is_komisi)
                                    <div class="mt-4 p-3 bg-blue-50 dark:bg-gray-700 rounded-md">
                                        <p class="text-sm font-medium text-blue-700 dark:text-blue-300">Anda juga terdaftar sebagai Anggota Komisi KP.</p>
                                    </div>
                                @endif
                            @endif

                            {{-- Tombol Simpan Profil --}}
                            <div class="flex items-center gap-4 mt-6">
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Profil</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            {{-- FORM UPDATE PASSWORD (Gunakan partial dari Breeze jika ada) --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form') {{-- Sesuaikan path jika berbeda --}}
                </div>
            </div>

            {{-- FORM HAPUS AKUN (Gunakan partial dari Breeze jika ada) --}}
            {{--
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form') // Sesuaikan path jika berbeda
                </div>
            </div>
            --}}
        </div>
    </div>
@endsection
{{--<x-app-layout>--}}
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
{{--            {{ __('Profile') }}--}}
{{--        </h2>--}}
{{--    </x-slot>--}}

{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">--}}
{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="max-w-xl">--}}
{{--                    @include('profile.partials.update-profile-information-form')--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="max-w-xl">--}}
{{--                    @include('profile.partials.update-password-form')--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">--}}
{{--                <div class="max-w-xl">--}}
{{--                    @include('profile.partials.delete-user-form')--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</x-app-layout>--}}
