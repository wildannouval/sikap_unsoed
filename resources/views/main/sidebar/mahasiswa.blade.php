<aside aria-label="Sidebar" class="bg-white dark:bg-gray-800 border-b sm:border-r sm:border-b-0 border-gray-200 dark:border-gray-700 fixed top-0 -translate-x-full h-screen left-0 pt-16 sm:pt-20 sm:translate-x-0 transition-transform w-64 z-40" id="logo-sidebar">
    <div class="h-full px-4 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-1.5 font-medium mt-5 sm:mt-0">
            <li>
                <a href="{{ route('mahasiswa.dashboard') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('mahasiswa.dashboard')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 transition duration-75 {{ Route::is('mahasiswa.dashboard') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 22 21"><path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/><path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/></svg>
                    <span class="ms-3 {{ Route::is('mahasiswa.dashboard') ? 'font-semibold' : '' }}">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('mahasiswa.surat-pengantar.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('mahasiswa.surat-pengantar.*') ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('mahasiswa.surat-pengantar.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 19"><path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/><path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('mahasiswa.surat-pengantar.*') ? 'font-semibold' : '' }}">Surat Pengantar</span>
                </a>
            </li>
            <li>
                <a href="{{ route('mahasiswa.pengajuan-kp.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('mahasiswa.pengajuan-kp.*') ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('mahasiswa.pengajuan-kp.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.043.043C3.998-.344 0 3.092 0 7.347c0 2.008.786 3.844 2.09 5.207 1.44 1.475 3.34 2.362 5.403 2.452a1 1 0 0 0 .957-.957V8.348a1 1 0 0 0-.957-.957A3.443 3.443 0 0 1 4.093 4.09a3.427 3.427 0 0 1 .558-3.04C5.116.558 5.711.112 6.36.02c1.421-.208 2.87.208 3.888 1.225l.006.006a1.01 1.01 0 0 0 .706.293h2.029a1 1 0 0 0 .707-1.707A6.96 6.96 0 0 0 12.13 0H9.043ZM7 9.347a1 1 0 0 0-1 1v.003a1 1 0 1 0 2 0V10.35a1 1 0 0 0-1-1Z"/><path d="M17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('mahasiswa.pengajuan-kp.*') ? 'font-semibold' : '' }}">Progres KP</span>
                </a>
            </li>
            <li>
                <a href="{{ route('mahasiswa.seminar.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('mahasiswa.seminar.*') ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('mahasiswa.seminar.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 18 20"><path d="M16 0H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0ZM13.75 17a1 1 0 0 1-1.729.686l-1.75-3.5a1 1 0 0 1 .353-1.353l3.5-1.75a1 1 0 0 1 1.353.353l1.75 3.5A1 1 0 0 1 17 17h-3.25Z"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('mahasiswa.seminar.*') ? 'font-semibold' : '' }}">Status Seminar Saya</span>
                </a>
            </li>
            <li>
                <a href="{{ route('mahasiswa.distribusi-laporan.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('mahasiswa.distribusi-laporan.*') ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('mahasiswa.distribusi-laporan.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M15.172 7.172a1 1 0 012.828 0l1.414 1.414a1 1 0 010 1.414l-1.414 1.414a1 1 0 01-1.414 0l-1.414-1.414a1 1 0 010-1.414l1.414-1.414zM10 2.586l4.293 4.293a1 1 0 11-1.414 1.414L10 5.414 7.121 8.293a1 1 0 01-1.414 0L2.293 4.879A1 1 0 013.707 3.464L10 9.757l6.293-6.293a1 1 0 011.414 0L20 6.172a1.001 1.001 0 010 1.414l-2.414 2.414a1 1 0 01-.707.293H8.828a1 1 0 01-.707-.293L3.414 5.121A1 1 0 013.414 3.707L6.293.879a1 1 0 011.414 0L10 2.586Z"/></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('mahasiswa.distribusi-laporan.*') ? 'font-semibold' : '' }}">Distribusi Laporan</span>
                </a>
            </li>


            {{-- MENU UMUM --}}
            <li class="pt-4 mt-4 space-y-1.5 font-medium border-t border-gray-200 dark:border-gray-700">
                <span class="ms-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Umum</span>
            </li>
            <li>
                <a href="{{ route('jadwal-seminar.publik.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('jadwal-seminar.publik.index') ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('jadwal-seminar.publik.index') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6 5V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h3V4a1 1 0 1 1 2 0v1h1a2 2 0 0 1 2 2v2H3V7a2 2 0 0 1 2-2h1ZM3 19v-8h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm5-6a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8Z" clip-rule="evenodd"/></svg>
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
