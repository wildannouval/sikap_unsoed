<aside aria-label="Sidebar" class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 fixed top-0 -translate-x-full border-r h-screen left-0 pt-20 sm:translate-x-0 transition-transform w-64 z-40" id="logo-sidebar">
    <div class="bg-white dark:bg-gray-800 h-full overflow-y-auto pb-4 px-4">
        <ul class="font-medium space-y-1.5">
            <li>
                <a href="{{ route('dosen-pembimbing.dashboard') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('dosen-pembimbing.dashboard')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg aria-hidden="true" class="w-5 h-5 transition duration-75 {{ Route::is('dosen-pembimbing.dashboard') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 22 21" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/><path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3 {{ Route::is('dosen-pembimbing.dashboard') ? 'font-semibold' : '' }}">Beranda</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dosen-pembimbing.bimbingan-kp.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('dosen-pembimbing.bimbingan-kp.*') || Route::is('dosen-pembimbing.konsultasi.show')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('dosen-pembimbing.bimbingan-kp.*') || Route::is('dosen-pembimbing.konsultasi.show') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('dosen-pembimbing.bimbingan-kp.*') || Route::is('dosen-pembimbing.konsultasi.show') ? 'font-semibold' : '' }}">Bimbingan KP & Konsultasi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dosen-pembimbing.seminar-approval.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('dosen-pembimbing.seminar-approval.*')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('dosen-pembimbing.seminar-approval.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 0 19 9.5 9.5 0 0 0 0-19ZM13.707 8.707l-4 4a1 1 0 0 1-1.414-1.414L10.586 9H7a1 1 0 0 1 0-2h3.586l-2.293-2.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('dosen-pembimbing.seminar-approval.*') ? 'font-semibold' : '' }}">Persetujuan Seminar</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dosen-pembimbing.penilaian-seminar.index') }}"
                   class="flex items-center p-3 rounded-lg group
                          {{ Route::is('dosen-pembimbing.penilaian-seminar.*')
                             ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300'
                             : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('dosen-pembimbing.penilaian-seminar.*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17 4a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4Zm-2.5 7.5a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm-5 4a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Zm0-2a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 .5.5Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('dosen-pembimbing.penilaian-seminar.*') ? 'font-semibold' : '' }}">Penilaian Seminar</span>
                </a>
            </li>

            {{-- MENU KHUSUS JIKA DOSEN JUGA ANGGOTA KOMISI --}}
            @if(Auth::check() && Auth::user()->role === 'dosen' && Auth::user()->dosen && Auth::user()->dosen->is_komisi)
                <li class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
                    <span class="ms-3 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Menu Dosen Komisi</span>
                </li>
                <li>
                    <a href="{{ route('dosen-komisi.dashboard') }}"
                       class="flex items-center p-3 rounded-lg group {{ Route::is('dosen-komisi.dashboard') ? 'bg-purple-100 text-purple-700 dark:bg-gray-700 dark:text-purple-300' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        {{-- SVG Dashboard Komisi --}}
                        <svg class="w-5 h-5 transition duration-75 {{ Route::is('dosen-komisi.dashboard') ? 'text-purple-700 dark:text-purple-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" fill="currentColor" viewBox="0 0 22 21"> <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/><path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/></svg>
                        <span class="ms-3 {{ Route::is('dosen-komisi.dashboard') ? 'font-semibold' : '' }}">Beranda Komisi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dosen-komisi.validasi-kp.index') }}"
                       class="flex items-center p-3 rounded-lg group {{ Route::is('dosen-komisi.validasi-kp.*') ? 'bg-purple-100 text-purple-700 dark:bg-gray-700 dark:text-purple-300' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        {{-- SVG Validasi KP Komisi --}}
                        <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('dosen-komisi.validasi-kp.*') ? 'text-purple-700 dark:text-purple-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M17.774 3.681A1.003 1.003 0 0 0 16.618 3H3.382a1 1 0 0 0-.95.681L1.226 7.5h17.548l-1.2-3.819ZM2.226 9a1 1 0 0 0-.95.681l-1.2 3.819A1.003 1.003 0 0 0 1.226 15H18.77a1 1 0 0 0 .95-.681l1.2-3.819A1.003 1.003 0 0 0 18.774 9H2.226Z M16.23 11.882 15.126 15H4.874L3.77 11.882h12.46Z"/></svg>
                        <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('dosen-komisi.validasi-kp.*') ? 'font-semibold' : '' }}">Validasi Pengajuan KP (Komisi)</span>
                    </a>
                </li>
                {{-- Jika ada menu lain untuk Dosen Komisi, tambahkan di sini --}}
            @endif
            {{-- Menu Profil --}}
            <li class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center p-3 rounded-lg group {{ Route::is('profile.edit') ? 'bg-blue-100 text-blue-700 dark:bg-gray-700 dark:text-blue-300' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="shrink-0 w-5 h-5 transition duration-75 {{ Route::is('profile.edit') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap {{ Route::is('profile.edit') ? 'font-semibold' : '' }}">Profil Saya</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
