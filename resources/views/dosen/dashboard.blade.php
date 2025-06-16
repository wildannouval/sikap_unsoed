@extends('main.app')

@section('title', 'Dashboard Dosen')

@section('content')
    <div class="p-4 sm:p-6 space-y-8">
        {{-- Header Sambutan --}}
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Dashboard Dosen</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Selamat datang, {{ Auth::user()->name }}. Kelola semua tugas bimbingan dan komisi Anda di sini.</p>
        </div>

        @include('partials.session-messages')

        {{-- Bagian Tugas Mendesak --}}
        <section>
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Tugas Mendesak</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Kartu Validasi KP (Khusus Komisi) --}}
                @if($is_komisi)
                    <a href="{{ route('dosen.komisi.validasi-kp.index', ['status_komisi' => 'direview']) }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700/50 transition-all duration-300">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Validasi KP</p>
                                <h5 class="text-4xl font-bold tracking-tight text-purple-600 dark:text-purple-400">{{ $countPengajuanKpMenungguValidasi }}</h5>
                            </div>
                            <span class="inline-flex items-center justify-center p-3 bg-purple-100 rounded-full dark:bg-purple-900/50">
                                {{-- Flowbite Icon: clipboard-check --}}
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6.45 4.5 2.45 2.45 4-4M18 3v4h-4V3h4Z"/>
                                </svg>
                            </span>
                        </div>
                    </a>
                @endif
                {{-- Kartu Persetujuan Seminar --}}
                <a href="{{ route('dosen.pembimbing.seminar-approval.index', ['status_pengajuan_filter' => 'diajukan_mahasiswa']) }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700/50 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Persetujuan Seminar</p>
                            <h5 class="text-4xl font-bold tracking-tight text-blue-600 dark:text-blue-400">{{ $countSeminarMenungguPersetujuan }}</h5>
                        </div>
                        <span class="inline-flex items-center justify-center p-3 bg-blue-100 rounded-full dark:bg-blue-900/50">
                             {{-- Flowbite Icon: user-check --}}
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </span>
                    </div>
                </a>
                {{-- Kartu Verifikasi Konsultasi --}}
                <a href="{{ route('dosen.pembimbing.bimbingan-kp.index') }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700/50 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Verifikasi Konsultasi</p>
                            <h5 class="text-4xl font-bold tracking-tight text-orange-600 dark:text-orange-400">{{ $countKonsultasiMenungguVerifikasi }}</h5>
                        </div>
                        <span class="inline-flex items-center justify-center p-3 bg-orange-100 rounded-full dark:bg-orange-900/50">
                            {{-- Flowbite Icon: messages --}}
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 10.5h.01M12 14.5h.01M8 10.5h.01M5 5h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-6.6a1 1 0 0 0-.69.275l-2.866 2.723A.5.5 0 0 1 8 20.5V17a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
                            </svg>
                        </span>
                    </div>
                </a>
                {{-- Kartu Penilaian Seminar --}}
                <a href="{{ route('dosen.pembimbing.penilaian-seminar.index') }}" class="block p-6 bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700/50 transition-all duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Penilaian Seminar</p>
                            <h5 class="text-4xl font-bold tracking-tight text-red-600 dark:text-red-400">{{ $countSeminarMenungguPenilaian }}</h5>
                        </div>
                        <span class="inline-flex items-center justify-center p-3 bg-red-100 rounded-full dark:bg-red-900/50">
                            {{-- Flowbite Icon: academic-cap --}}
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.03v13m0-13c-2.819-.831-4.715-1.476-6.052-1.94C4.612 3.682 3.796 3.878 3 4.505M12 6.03v13m0-13c2.819-.831 4.715-1.476 6.052-1.94C19.388 3.682 20.204 3.878 21 4.505M12 6.03V4.5m0 14.532v-1.532M4.048 5.455c.61-.599 1.48-.82 2.344-.735A21.22 21.22 0 0 0 12 6.03m7.608-.57c.864-.085 1.734.136 2.344.735M3 4.505c0-1.102.39-1.55 1.048-1.045M21 4.505c0-1.102-.39-1.55-1.048-1.045"/>
                            </svg>
                        </span>
                    </div>
                </a>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Kiri (Lebar): Mahasiswa Bimbingan --}}
            <div class="lg:col-span-2">
                <section>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Mahasiswa Bimbingan Aktif</h2>
                        @if(!$mahasiswaBimbingan->isEmpty())
                            <a href="{{ route('dosen.pembimbing.bimbingan-kp.index') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-500">
                                Lihat Semua
                            </a>
                        @endif
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border dark:border-gray-700">
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($mahasiswaBimbingan as $bimbingan)
                                <li class="p-4 flex flex-col sm:flex-row justify-between sm:items-center hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <div class="flex items-center gap-x-4">
                                        <div class="hidden sm:inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 dark:bg-gray-900">
                                            {{-- Flowbite Icon: user --}}
                                            <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $bimbingan->mahasiswa->user->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Judul: {{ Str::limit($bimbingan->judul_kp, 60) }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('dosen.pembimbing.bimbingan-kp.konsultasi.show', $bimbingan->id) }}" class="mt-3 sm:mt-0 shrink-0 text-xs font-semibold text-blue-600 dark:text-blue-500 hover:underline">
                                        Lihat Konsultasi &rarr;
                                    </a>
                                </li>
                            @empty
                                <li class="p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada mahasiswa bimbingan yang aktif saat ini.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </section>
            </div>
            {{-- Kolom Kanan (Sempit): Jadwal Mendatang --}}
            <div class="lg:col-span-1">
                <section>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Jadwal Seminar Mendatang</h2>
                    <div class="space-y-4">
                        @forelse($seminarMendatang as $seminar)
                            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $seminar->mahasiswa->user->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Pukul {{ \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') }} di {{ $seminar->ruangan }}</p>
                            </div>
                        @empty
                            <div class="p-6 text-center text-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700">
                                <p>Tidak ada jadwal seminar mendatang.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
