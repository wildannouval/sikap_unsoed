<aside aria-label="Sidebar" class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 fixed top-0 -translate-x-full border-r h-screen left-0 pt-20 sm:translate-x-0 transition-transform w-64 z-40" id="logo-sidebar">
    <div class="bg-white dark:bg-gray-800 h-full overflow-y-auto pb-4 px-3">
        <ul class="font-medium space-y-2">
            <!-- Menu lainnya untuk mahasiswa -->
            <li>
                <a class="flex items-center dark:hover:bg-gray-700 dark:text-white group hover:bg-gray-100 p-2 rounded-lg text-gray-900" href="{{ route('dosen-pembimbing.dashboard') }}">
                    <svg aria-hidden="true" class="dark:text-gray-400 text-gray-500 dark:group-hover:text-white duration-75 group-hover:text-gray-900 h-5 transition w-5" fill="currentColor" viewBox="0 0 22 21" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Beranda</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dosen-pembimbing.bimbingan-kp.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 20 18">
                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Bimbingan KP</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dosen-pembimbing.seminar-approval.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 20 20"> {{-- Ganti dengan icon yang sesuai --}}
                        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.707 8.707-4 4a1 1 0 0 1-1.414-1.414L10.586 9H7a1 1 0 0 1 0-2h3.586l-2.293-2.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Persetujuan Seminar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
