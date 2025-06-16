<section class="flex flex-col items-center p-4 sm:p-6 text-center">
    {{-- Tampilan Foto Profil dengan Live Preview --}}
    <div class="relative">
        <img id="photo-preview" class="w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-lg"
             src="{{ Auth::user()->profile_photo_url }}"
             alt="{{ Auth::user()->name }}">

        {{-- Tombol Lapis untuk Ganti Foto --}}
        <label for="photo" class="absolute -bottom-2 -right-2 p-2 bg-blue-600 rounded-full cursor-pointer hover:bg-blue-700 transition-colors" title="Ganti Foto Profil">
            {{-- Flowbite Icon: camera --}}
            <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.5 12a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 6.5h15a1 1 0 0 0 1-1V7.5a1 1 0 0 0-1-1h-2.5l-1.6-2.4a1 1 0 0 0-.8-.4H9.9a1 1 0 0 0-.8.4l-1.6 2.4H5a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1Z"/>
            </svg>
            {{-- Input file ini terhubung ke form utama di 'edit.blade.php' --}}
            <input type="file" name="photo" id="photo" form="profile-information-form" class="hidden" accept="image/*">
        </label>
    </div>

    {{-- Info Dasar Pengguna --}}
    <div class="mt-4">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
        <span class="mt-2 inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ ucfirst(Auth::user()->role) }}</span>
    </div>

    {{-- Tombol Aksi Hapus Foto (hanya muncul jika ada foto) --}}
    @if(Auth::user()->profile_photo_path)
        <div class="mt-4">
            {{-- Tombol ini akan men-submit form tersembunyi di bawah --}}
            <button type="submit" form="delete-photo-form" class="text-xs text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-500 hover:underline">
                Hapus Foto
            </button>
        </div>
    @endif
</section>

{{-- Form tersembunyi KHUSUS untuk aksi hapus foto --}}
<form id="delete-photo-form" action="{{ route('profile.photo.destroy') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
