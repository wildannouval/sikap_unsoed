<aside aria-label="Sidebar" class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 fixed top-0 -translate-x-full border-r h-screen left-0 pt-20 sm:translate-x-0 transition-transform w-64 z-40" id="logo-sidebar">
    <div class="bg-white dark:bg-gray-800 h-full overflow-y-auto pb-4 px-4">
        <ul class="font-medium space-y-1.5">
            <li>
                <a href="{{ route('dosen-komisi.dashboard') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('dosen-komisi.dashboard')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg aria-hidden="true" class="w-5 h-5 transition duration-75 {{ Route::is('dosen-komisi.dashboard') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 22 21" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/><path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3 {{ Route::is('dosen-komisi.dashboard') ? 'font-semibold' : '' }}">Beranda</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dosen-komisi.validasi-kp.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('dosen-komisi.validasi-kp.*')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('dosen-komisi.validasi-kp.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.774 3.681A1.003 1.003 0 0 0 16.618 3H3.382a1 1 0 0 0-.95.681L1.226 7.5h17.548l-1.2-3.819ZM2.226 9a1 1 0 0 0-.95.681l-1.2 3.819A1.003 1.003 0 0 0 1.226 15H18.77a1 1 0 0 0 .95-.681l1.2-3.819A1.003 1.003 0 0 0 18.774 9H2.226Z M16.23 11.882 15.126 15H4.874L3.77 11.882h12.46Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('dosen-komisi.validasi-kp.*') ? 'font-semibold' : '' }}">Validasi Pengajuan KP</span>
                </a>
            </li>
            {{-- Menu Profil --}}
            <li>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('profile.edit')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('profile.edit') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('profile.edit') ? 'font-semibold' : '' }}">Profil Saya</span>
                </a>
            </li>
            {{-- Jika Dosen Komisi juga handle penjadwalan seminar, linknya bisa ditambahkan di sini juga --}}
            {{-- Contoh: (jika route 'dosen-komisi.penjadwalan-seminar.index' ada)
            <li>
                <a href="{{ route('dosen-komisi.penjadwalan-seminar.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('dosen-komisi.penjadwalan-seminar.*') ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('dosen-komisi.penjadwalan-seminar.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-1V1a1 1 0 0 0-2 0v1H5V1Zm10 5H5v8h10V6Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('dosen-komisi.penjadwalan-seminar.*') ? 'font-semibold' : '' }}">Penjadwalan Seminar</span>
                </a>
            </li>
            --}}
        </ul>
    </div>
</aside>
