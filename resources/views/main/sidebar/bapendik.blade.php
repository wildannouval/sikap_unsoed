<aside aria-label="Sidebar" class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 fixed top-0 -translate-x-full border-r h-screen left-0 pt-20 sm:translate-x-0 transition-transform w-64 z-40" id="logo-sidebar">
    <div class="bg-white dark:bg-gray-800 h-full overflow-y-auto pb-4 px-4"> {{-- Padding horizontal sidebar diubah ke px-4 --}}
        <ul class="font-medium space-y-1.5"> {{-- Sedikit mengurangi space antar menu utama --}}

            {{-- Menu Beranda --}}
            <li>
                <a href="{{ route('bapendik.dashboard') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('bapendik.dashboard')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg aria-hidden="true"
                         class="w-5 h-5 transition duration-75
                                {{ Route::is('bapendik.dashboard')
                                   ? 'text-blue-700 dark:text-blue-300'
                                   : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                         fill="currentColor" viewBox="0 0 22 21" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3 {{ Route::is('bapendik.dashboard') ? 'font-semibold' : '' }}">Beranda</span>
                </a>
            </li>

            {{-- Menu Manajemen Jurusan --}}
            <li>
                <a href="{{ route('bapendik.jurusan.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('bapendik.jurusan.*')  // '*' mencakup semua sub-route dari jurusan
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75
                                {{ Route::is('bapendik.jurusan.*')
                                   ? 'text-blue-700 dark:text-blue-300'
                                   : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('bapendik.jurusan.*') ? 'font-semibold' : '' }}">Manajemen Jurusan</span>
                </a>
            </li>

            {{-- Menu Manajemen Pengguna --}}
            <li>
                <a href="{{ route('bapendik.pengguna.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('bapendik.pengguna.*')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75
                                {{ Route::is('bapendik.pengguna.*')
                                   ? 'text-blue-700 dark:text-blue-300'
                                   : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('bapendik.pengguna.*') ? 'font-semibold' : '' }}">Manajemen Pengguna</span>
                </a>
            </li>

            {{-- Menu Validasi Surat Pengantar --}}
            <li>
                <a href="{{ route('bapendik.validasi-surat.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('bapendik.validasi-surat.*')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75
                                {{ Route::is('bapendik.validasi-surat.*')
                                   ? 'text-blue-700 dark:text-blue-300'
                                   : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('bapendik.validasi-surat.*') ? 'font-semibold' : '' }}">Validasi Surat</span>
                </a>
            </li>

            {{-- Menu Penjadwalan Seminar --}}
            <li>
                <a href="{{ route('bapendik.penjadwalan-seminar.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('bapendik.penjadwalan-seminar.*')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75
                                {{ Route::is('bapendik.penjadwalan-seminar.*')
                                   ? 'text-blue-700 dark:text-blue-300'
                                   : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V1a1 1 0 0 0-2 0v1H5V1Zm10 5H5v8h10V6Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('bapendik.penjadwalan-seminar.*') ? 'font-semibold' : '' }}">Penjadwalan Seminar</span>
                </a>
            </li>
            {{-- Tambahkan menu lain dengan pola yang sama --}}
            <li>
                <a href="{{ route('bapendik.spk.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('bapendik.spk.*')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75
                                {{ Route::is('bapendik.spk.*')
                                   ? 'text-blue-700 dark:text-blue-300'
                                   : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         viewBox="0 0 20 20"> <path d="M19.724 7.586H7.276C6.596 7.586 6.06 8.162 6.06 8.842V18.16c0 .68.536 1.256 1.216 1.256h12.448c.68 0 1.216-.576 1.216-1.256V8.842c0-.68-.536-1.256-1.216-1.256ZM18.212 9.256h1.184a.33.33 0 0 1 .33.33V18.16a.33.33 0 0 1-.33.33h-1.184a.33.33 0 0 1-.33-.33V9.586a.33.33 0 0 1 .33-.33ZM7.724 9.256h1.184a.33.33 0 0 1 .33.33V18.16a.33.33 0 0 1-.33.33H7.724a.33.33 0 0 1-.33-.33V9.586a.33.33 0 0 1 .33-.33Zm6.548-6.084A2.58 2.58 0 0 0 11.9 1.428a2.576 2.576 0 0 0-2.368 1.744 1.256 1.256 0 1 0 1.216 2.112 1.27 1.27 0 0 0 1.024-.504A1.256 1.256 0 0 0 14.272 3.172Zm-2.624-2.58a1.32 1.32 0 1 1-1.216 2.16 1.32 1.32 0 0 1 1.216-2.16Z M3.932 8.842V2.256a1.256 1.256 0 0 1 1.216-1.256h.36A2.576 2.576 0 0 0 3.14 3.172a2.58 2.58 0 0 0 2.368 1.744 1.256 1.256 0 0 0 .048 2.512H5.148A1.256 1.256 0 0 1 3.932 6.172V18.16a.33.33 0 0 0 .33.33h1.184a.33.33 0 0 0 .33-.33V8.842A1.256 1.256 0 0 0 3.932 8.842Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('bapendik.spk.*') ? 'font-semibold' : '' }}">Manajemen SPK</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bapendik.ruangan.index') }}"
                   class="flex items-center p-3 rounded-lg group {{ Route::is('bapendik.ruangan.*') ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('bapendik.ruangan.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M4 3a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4Zm10 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-4 4a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-4 4a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('bapendik.ruangan.*') ? 'font-semibold' : '' }}">Manajemen Ruangan</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
