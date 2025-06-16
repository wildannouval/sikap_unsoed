@extends('main.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div class="p-4 sm:p-6 space-y-8">
        {{-- Header & Kartu Status Utama --}}
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Selamat Datang, {{ Auth::user()->name }}!
            </h1>

            {{-- Kartu Status & Aksi Berikutnya yang menonjol --}}
            <div class="mt-4 p-6 bg-gradient-to-br from-blue-600 to-blue-800 dark:bg-gray-800 dark:border dark:border-gray-700 rounded-2xl shadow-lg text-white">
                <p class="text-sm font-medium text-blue-200 dark:text-blue-300 uppercase tracking-wider">Status Anda Saat Ini</p>
                <p class="text-2xl font-semibold mt-1">{{ $statusRingkas }}</p>
                @if($pesanTambahan)
                    <p class="text-sm text-blue-200 dark:text-blue-300 mt-2 opacity-90">{{ $pesanTambahan }}</p>
                @endif
                <a href="{{ $aksiBerikutnyaRoute }}" class="inline-block mt-5 bg-white text-blue-700 font-bold text-sm px-6 py-2.5 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:text-gray-900 dark:bg-gray-100 dark:hover:bg-gray-200 dark:focus:ring-gray-400 transition-all duration-200 transform hover:scale-105">
                    {{ $aksiBerikutnyaText }} &rarr;
                </a>
            </div>
        </div>

        @include('partials.session-messages')

        {{-- Tampilkan Timeline & Detail jika ada KP Aktif --}}
        @if ($pengajuanKpAktif)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Kolom Kiri (Lebar): Timeline/Stepper --}}
                <div class="lg:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Timeline Proses Kerja Praktek</h2>
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md border dark:border-gray-700">
                        {{-- Stepper Anda yang sudah sangat bagus, diletakkan di sini dengan sedikit polesan --}}
                        <ol class="relative border-s border-gray-200 dark:border-gray-700">
                            {{-- TAHAP 1: SURAT PENGANTAR --}}
                            <li class="mb-10 ms-6">
                                <span class="absolute flex items-center justify-center w-8 h-8 {{ $pengajuanKpAktif->suratPengantar && $pengajuanKpAktif->suratPengantar->status_bapendik === 'disetujui' ? 'bg-green-200 dark:bg-green-900' : 'bg-blue-200 dark:bg-blue-900' }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                                    <svg class="w-3.5 h-3.5 {{ $pengajuanKpAktif->suratPengantar && $pengajuanKpAktif->suratPengantar->status_bapendik === 'disetujui' ? 'text-green-500 dark:text-green-400' : 'text-blue-500 dark:text-blue-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/></svg>
                                </span>
                                <h3 class="font-semibold leading-tight text-gray-900 dark:text-white">1. Surat Pengantar Disetujui</h3>
                                <p class="text-sm">Lokasi: {{ $pengajuanKpAktif->suratPengantar->lokasi_penelitian }}</p>
                            </li>

                            {{-- TAHAP 2: PENGAJUAN KP --}}
                            @php $kpStepDone = $pengajuanKpAktif->status_komisi === 'diterima'; @endphp
                            <li class="mb-10 ms-6">
                                 <span class="absolute flex items-center justify-center w-8 h-8 {{ $kpStepDone ? 'bg-green-200 dark:bg-green-900' : 'bg-blue-200 dark:bg-blue-900' }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                                    @if($kpStepDone)
                                         <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/></svg>
                                     @else
                                         <svg class="w-3.5 h-3.5 text-blue-500 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.707 8.707-4 4a1 1 0 0 1-1.414-1.414L10.586 9H7a1 1 0 0 1 0-2h3.586l-2.293-2.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414Z"/></svg>
                                     @endif
                                </span>
                                <h3 class="font-semibold leading-tight text-gray-900 dark:text-white">2. Pengajuan KP Divalidasi</h3>
                                <p class="text-sm">Status: {{ ucfirst(str_replace('_',' ',$pengajuanKpAktif->status_komisi)) }}. Dospem: {{ $pengajuanKpAktif->dosenPembimbing->user->name ?? 'Belum Ditentukan' }}</p>
                            </li>

                            {{-- TAHAP 3: KONSULTASI --}}
                            @php $konsulStepDone = $pengajuanKpAktif->jumlah_konsultasi_verified >= $minKonsultasi; @endphp
                            <li class="mb-10 ms-6">
                                 <span class="absolute flex items-center justify-center w-8 h-8 {{ $konsulStepDone ? 'bg-green-200 dark:bg-green-900' : 'bg-blue-200 dark:bg-blue-900' }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                                     {{-- ... Ikon ... --}}
                                </span>
                                <h3 class="font-semibold leading-tight text-gray-900 dark:text-white">3. Bimbingan Konsultasi</h3>
                                <p class="text-sm">Terverifikasi: {{ $pengajuanKpAktif->jumlah_konsultasi_verified }} dari {{ $minKonsultasi }} sesi.</p>
                                <a href="{{ route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKpAktif->id) }}" class="mt-1 inline-block text-xs font-semibold text-blue-600 hover:underline dark:text-blue-500">Lihat Riwayat &rarr;</a>
                            </li>

                            {{-- TAHAP 4: SEMINAR --}}
                            @php $seminarStepDone = $seminarTerkini && $seminarTerkini->status_pengajuan === 'selesai_dinilai'; @endphp
                            <li class="mb-10 ms-6">
                                 <span class="absolute flex items-center justify-center w-8 h-8 {{ $seminarStepDone ? 'bg-green-200 dark:bg-green-900' : (!$seminarTerkini ? 'bg-gray-100 dark:bg-gray-700' : 'bg-blue-200 dark:bg-blue-900') }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                                     {{-- ... Ikon ... --}}
                                </span>
                                <h3 class="font-semibold leading-tight text-gray-900 dark:text-white">4. Seminar KP</h3>
                                <p class="text-sm">Status: {{ $seminarTerkini ? ucfirst(str_replace('_',' ',$seminarTerkini->status_pengajuan)) : 'Belum Diajukan' }}</p>
                                <a href="{{ route('mahasiswa.seminar.index') }}" class="mt-1 inline-block text-xs font-semibold text-blue-600 hover:underline dark:text-blue-500">Lihat Detail Seminar &rarr;</a>
                            </li>

                            {{-- TAHAP 5: PENYELESAIAN --}}
                            @php $selesaiStepDone = $pengajuanKpAktif->status_kp === 'lulus'; @endphp
                            <li class="ms-6">
                                <span class="absolute flex items-center justify-center w-8 h-8 {{ $selesaiStepDone ? 'bg-green-200 dark:bg-green-900' : 'bg-gray-100 dark:bg-gray-700' }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                                     {{-- ... Ikon ... --}}
                                </span>
                                <h3 class="font-semibold leading-tight text-gray-900 dark:text-white">5. Penyelesaian</h3>
                                <p class="text-sm">{{ $pengajuanKpAktif->sudah_upload_bukti_distribusi ? 'Bukti distribusi sudah diupload.' : 'Menunggu upload bukti distribusi.' }}</p>
                            </li>
                        </ol>
                    </div>
                </div>

                {{-- Kolom Kanan: Detail KP Aktif --}}
                <div class="lg:col-span-1">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Detail KP Aktif</h2>
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md space-y-4 text-sm border dark:border-gray-700">
                        {{-- ... (Salin konten detail KP aktif dari file asli Anda) ... --}}
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Judul KP:</p>
                                    <p class="text-gray-900 dark:text-white font-semibold">{{ $pengajuanKpAktif->judul_kp }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Lokasi/Instansi:</p>
                                    <p class="text-gray-900 dark:text-white font-semibold">{{ $pengajuanKpAktif->instansi_lokasi }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Dosen Pembimbing:</p>
                                    <p class="text-gray-900 dark:text-white font-semibold">{{ $pengajuanKpAktif->dosenPembimbing->user->name ?? 'Belum ditentukan' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Periode Pelaksanaan:</p>
                                    <p class="text-gray-900 dark:text-white font-semibold">
                                        @if($pengajuanKpAktif->tanggal_mulai && $pengajuanKpAktif->tanggal_selesai)
                                            {{ \Carbon\Carbon::parse($pengajuanKpAktif->tanggal_mulai)->isoFormat('D MMM YY') }} - {{ \Carbon\Carbon::parse($pengajuanKpAktif->tanggal_selesai)->isoFormat('D MMM YY') }}
                                        @else
                                            Belum ditetapkan
                                        @endif
                                    </p>
                                </div>
                                <div class="pt-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Status KP Keseluruhan:</p>
                                    <span class="text-sm font-bold {{ $pengajuanKpAktif->status_kp == 'lulus' ? 'text-green-600 dark:text-green-400' : ($pengajuanKpAktif->status_kp == 'tidak_lulus' ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white') }}">
                                {{ ucfirst(str_replace('_',' ',$pengajuanKpAktif->status_kp)) }}
                                    </span>
                                </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Tampilan jika tidak ada KP Aktif --}}
            <div class="text-center p-10 bg-white dark:bg-gray-800 rounded-xl shadow-md border dark:border-gray-700">
                <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-500 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>
                <p class="text-gray-900 dark:text-white mb-2 font-semibold">Anda belum memulai proses Kerja Praktek.</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Silakan mulai dengan mengajukan surat pengantar jika belum, atau buat pengajuan KP jika surat sudah disetujui.</p>
                <a href="{{ route('mahasiswa.surat-pengantar.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800 transition-colors">
                    Ajukan Surat Pengantar
                </a>
            </div>
        @endif
    </div>
@endsection
