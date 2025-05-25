<aside aria-label="Sidebar" class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 fixed top-0 -translate-x-full border-r h-screen left-0 pt-20 sm:translate-x-0 transition-transform w-64 z-40" id="logo-sidebar">
    <div class="bg-white dark:bg-gray-800 h-full overflow-y-auto pb-4 px-3">
        <ul class="font-medium space-y-2">
            <!-- Menu lainnya untuk mahasiswa -->
            <li>
                <a class="flex items-center dark:hover:bg-gray-700 dark:text-white group hover:bg-gray-100 p-2 rounded-lg text-gray-900" href="{{ route('bapendik.dashboard') }}">
                    <svg aria-hidden="true" class="dark:text-gray-400 text-gray-500 dark:group-hover:text-white duration-75 group-hover:text-gray-900 h-5 transition w-5" fill="currentColor" viewBox="0 0 22 21" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Beranda</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bapendik.jurusan.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg
                        class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 18 18">
                        <path
                            d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Manage Jurusan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bapendik.pengguna.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 20 18">
                        <path
                            d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Manage Pengguna</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bapendik.validasi-surat.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Validasi Surat</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bapendik.spk.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 20 20">
                        <path d="M19.724 7.586H7.276C6.596 7.586 6.06 8.162 6.06 8.842V18.16c0 .68.536 1.256 1.216 1.256h12.448c.68 0 1.216-.576 1.216-1.256V8.842c0-.68-.536-1.256-1.216-1.256ZM18.212 9.256h1.184a.33.33 0 0 1 .33.33V18.16a.33.33 0 0 1-.33.33h-1.184a.33.33 0 0 1-.33-.33V9.586a.33.33 0 0 1 .33-.33ZM7.724 9.256h1.184a.33.33 0 0 1 .33.33V18.16a.33.33 0 0 1-.33.33H7.724a.33.33 0 0 1-.33-.33V9.586a.33.33 0 0 1 .33-.33Zm6.548-6.084A2.58 2.58 0 0 0 11.9 1.428a2.576 2.576 0 0 0-2.368 1.744 1.256 1.256 0 1 0 1.216 2.112 1.27 1.27 0 0 0 1.024-.504A1.256 1.256 0 0 0 14.272 3.172Zm-2.624-2.58a1.32 1.32 0 1 1-1.216 2.16 1.32 1.32 0 0 1 1.216-2.16Z M3.932 8.842V2.256a1.256 1.256 0 0 1 1.216-1.256h.36A2.576 2.576 0 0 0 3.14 3.172a2.58 2.58 0 0 0 2.368 1.744 1.256 1.256 0 0 0 .048 2.512H5.148A1.256 1.256 0 0 1 3.932 6.172V18.16a.33.33 0 0 0 .33.33h1.184a.33.33 0 0 0 .33-.33V8.842A1.256 1.256 0 0 0 3.932 8.842Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Manajemen SPK</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bapendik.penjadwalan-seminar.index') }}"
                   class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 20 20"> <path d="M5 1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V1a1 1 0 0 0-2 0v1H5V1Zm10 5H5v8h10V6Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Penjadwalan Seminar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
