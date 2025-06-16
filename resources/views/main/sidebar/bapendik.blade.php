<aside aria-label="Sidebar" class="bg-white dark:bg-gray-800 border-b sm:border-r sm:border-b-0 border-gray-200 dark:border-gray-700 fixed top-0 -translate-x-full h-screen left-0 pt-16 sm:pt-20 sm:translate-x-0 transition-transform w-64 z-20" id="logo-sidebar">
    <div class="h-full px-4 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-1.5 font-medium mt-5 sm:mt-0">
            <li>
                <a href="{{ route('bapendik.dashboard') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('bapendik.dashboard')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 transition duration-75 {{ Route::is('bapendik.dashboard') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 22 21"><path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/><path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/></svg>
                    <span class="ms-3 {{ Route::is('bapendik.dashboard') ? 'font-semibold' : '' }}">Dashboard</span>
                </a>
            </li>

            {{-- Menu Multi-Level untuk Data Master --}}
            <li>
                <button type="button"
                        class="flex items-center w-full p-3 text-base rounded-lg group transition duration-75
                               {{ Route::is('bapendik.jurusan.*') || Route::is('bapendik.pengguna.*') || Route::is('bapendik.ruangan.*')
                                  ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                                  : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                        aria-controls="dropdown-master-data" data-collapse-toggle="dropdown-master-data">
                    <svg class="shrink-0 w-5 h-5 transition duration-75
                                {{ Route::is('bapendik.jurusan.*') || Route::is('bapendik.pengguna.*') || Route::is('bapendik.ruangan.*')
                                   ? 'text-blue-700 dark:text-blue-300'
                                   : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                         fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2ZM10 4h4v2h-4V4Zm10 16H4V8h16v12Z"></path></svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap {{ Route::is('bapendik.jurusan.*') || Route::is('bapendik.pengguna.*') || Route::is('bapendik.ruangan.*') ? 'font-semibold' : '' }}">Data Master</span>
                    <svg class="w-3 h-3 transition-transform duration-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <ul id="dropdown-master-data" class="{{ (Route::is('bapendik.jurusan.*') || Route::is('bapendik.pengguna.*') || Route::is('bapendik.ruangan.*')) ? '' : 'hidden' }} py-1 space-y-1.5">
                    <li><a href="{{ route('bapendik.jurusan.index') }}" class="flex items-center w-full p-3 text-sm rounded-lg pl-11 group transition duration-75 {{ Route::is('bapendik.jurusan.*') ? 'text-blue-700 dark:text-blue-300 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">Jurusan</a></li>
                    <li><a href="{{ route('bapendik.pengguna.index') }}" class="flex items-center w-full p-3 text-sm rounded-lg pl-11 group transition duration-75 {{ Route::is('bapendik.pengguna.*') ? 'text-blue-700 dark:text-blue-300 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">Pengguna</a></li>
                    <li><a href="{{ route('bapendik.ruangan.index') }}" class="flex items-center w-full p-3 text-sm rounded-lg pl-11 group transition duration-75 {{ Route::is('bapendik.ruangan.*') ? 'text-blue-700 dark:text-blue-300 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">Ruangan</a></li>
                </ul>
            </li>

            {{-- Menu Proses KP --}}
            <li class="pt-4 mt-4 space-y-1.5 font-medium border-t border-gray-200 dark:border-gray-700">
                <span class="ms-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Proses Kerja Praktek</span>
            </li>
            <li>
                <a href="{{ route('bapendik.validasi-surat.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('bapendik.validasi-surat.*')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    {{-- Ikon --}}
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('bapendik.validasi-surat.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20"><path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('bapendik.validasi-surat.*') ? 'font-semibold' : '' }}">Validasi Surat</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bapendik.spk.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('bapendik.spk.*')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    {{-- Ikon --}}
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('bapendik.spk.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M19.724 7.586H7.276C6.596 7.586 6.06 8.162 6.06 8.842V18.16c0 .68.536 1.256 1.216 1.256h12.448c.68 0 1.216-.576 1.216-1.256V8.842c0-.68-.536-1.256-1.216-1.256ZM18.212 9.256h1.184a.33.33 0 0 1 .33.33V18.16a.33.33 0 0 1-.33.33h-1.184a.33.33 0 0 1-.33-.33V9.586a.33.33 0 0 1 .33-.33ZM7.724 9.256h1.184a.33.33 0 0 1 .33.33V18.16a.33.33 0 0 1-.33.33H7.724a.33.33 0 0 1-.33-.33V9.586a.33.33 0 0 1 .33-.33Zm6.548-6.084A2.58 2.58 0 0 0 11.9 1.428a2.576 2.576 0 0 0-2.368 1.744 1.256 1.256 0 1 0 1.216 2.112 1.27 1.27 0 0 0 1.024-.504A1.256 1.256 0 0 0 14.272 3.172Zm-2.624-2.58a1.32 1.32 0 1 1-1.216 2.16 1.32 1.32 0 0 1 1.216-2.16Z M3.932 8.842V2.256a1.256 1.256 0 0 1 1.216-1.256h.36A2.576 2.576 0 0 0 3.14 3.172a2.58 2.58 0 0 0 2.368 1.744 1.256 1.256 0 0 0 .048 2.512H5.148A1.256 1.256 0 0 1 3.932 6.172V18.16a.33.33 0 0 0 .33.33h1.184a.33.33 0 0 0 .33-.33V8.842A1.256 1.256 0 0 0 3.932 8.842Z"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('bapendik.spk.*') ? 'font-semibold' : '' }}">Manajemen SPK</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bapendik.penjadwalan-seminar.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('bapendik.penjadwalan-seminar.*')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    {{-- Ikon --}}
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('bapendik.penjadwalan-seminar.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M5 1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V1a1 1 0 0 0-2 0v1H5V1Zm10 5H5v8h10V6Z"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('bapendik.penjadwalan-seminar.*') ? 'font-semibold' : '' }}">Penjadwalan Seminar</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bapendik.laporan.index') }}"
                   class="flex items-center p-3 rounded-lg group
              {{ Route::is('bapendik.laporan.*')
                 ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                 : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    {{-- Flowbite Icon: document-chart-bar --}}
                    <svg class="shrink-0 w-5 h-5 transition duration-75
                    {{ Route::is('bapendik.laporan.*')
                       ? 'text-blue-700 dark:text-blue-300'
                       : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h0m0 4h0m0-8v8"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('bapendik.laporan.*') ? 'font-semibold' : '' }}">Export Laporan</span>
                </a>
            </li>
            {{-- Menu Umum (termasuk Semua Jadwal Seminar dan Profil) --}}
            <li class="pt-4 mt-4 space-y-1.5 font-medium border-t border-gray-200 dark:border-gray-700">
                <span class="ms-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Umum</span>
            </li>
            <li>
                <a href="{{ route('jadwal-seminar.publik.index') }}"
                   class="flex items-center p-3 rounded-lg group
                            {{ Route::is('jadwal-seminar.publik.index')
                                ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                                : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75
                                {{ Route::is('jadwal-seminar.publik.index')
                                ? 'text-blue-700 dark:text-blue-300'
                                : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                         fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6 5V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h1a2 2 0 0 1 2 2v2H3V7a2 2 0 0 1 2-2h1ZM3 19v-8h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm5-6a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8Z" clip-rule="evenodd"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('jadwal-seminar.publik.index') ? 'font-semibold' : '' }}">Semua Jadwal Seminar</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center p-3 rounded-lg group {{ Route::is('profile.edit') ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('profile.edit') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('profile.edit') ? 'font-semibold' : '' }}">Profil</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
