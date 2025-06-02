@extends('main.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div class="p-4 sm:p-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8">
            Selamat Datang, {{ Auth::user()->name }}!
        </h1>

        {{-- Notifikasi Session --}}
        @if (session('success'))
            <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->has('profil_mahasiswa') || session('error'))
            <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Error!</span> {{ $errors->first('profil_mahasiswa') ?: session('error') }}
            </div>
        @endif
        @if (session('info'))
            <div class="p-4 mb-6 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                {{ session('info') }}
            </div>
        @endif

        {{-- Grid Utama --}}
        <div class="grid grid-cols-1 @if($pengajuanKpAktif) lg:grid-cols-3 @else lg:grid-cols-1 @endif gap-6">
            {{-- Kolom Kiri: Progress Stepper (Jika ada KP Aktif) --}}
            @if ($pengajuanKpAktif)
                <div class="lg:col-span-2 bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <h2 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Progres Kerja Praktek Anda</h2>
                    <ol class="relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">

                        {{-- TAHAP 1: SURAT PENGANTAR --}}
                        @php
                            $sp = $pengajuanKpAktif->suratPengantar;
                            $spStepDone = $sp && $sp->status_bapendik === 'disetujui';
                            $spStepCurrent = $sp && $sp->status_bapendik === 'menunggu';
                            $spStepFailed = $sp && $sp->status_bapendik === 'ditolak';
                        @endphp
                        <li class="mb-10 ms-6">
                    <span class="absolute flex items-center justify-center w-8 h-8 {{ $spStepDone ? 'bg-green-200 dark:bg-green-900' : ($spStepCurrent || (!$sp && !$pengajuanKpAktif->id) ? 'bg-blue-200 dark:bg-blue-900' : ($spStepFailed ? 'bg-red-200 dark:bg-red-900' : 'bg-gray-100 dark:bg-gray-700')) }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                        @if($spStepDone)
                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/></svg>
                        @elseif($spStepCurrent || (!$sp && !$pengajuanKpAktif->id)) {{-- Anggap ini step awal jika belum ada SP atau KP --}}
                        <svg class="w-3.5 h-3.5 text-blue-500 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.707 8.707-4 4a1 1 0 0 1-1.414-1.414L10.586 9H7a1 1 0 0 1 0-2h3.586l-2.293-2.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414Z"/></svg>
                        @elseif($spStepFailed)
                            <svg class="w-3.5 h-3.5 text-red-500 dark:text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                        @else
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16"><path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/></svg>
                        @endif
                    </span>
                            <h3 class="font-medium leading-tight text-gray-900 dark:text-white">1. Surat Pengantar</h3>
                            <p class="text-sm">
                                @if($sp) Status: {{ ucfirst($sp->status_bapendik) }} @if($sp->status_bapendik == 'disetujui' && $sp->tanggal_pengambilan) (Bisa diambil tgl: {{ \Carbon\Carbon::parse($sp->tanggal_pengambilan)->isoFormat('D MMM YY') }}) @elseif($sp->status_bapendik == 'ditolak' && $sp->catatan_bapendik) (Catatan: {{ Str::limit($sp->catatan_bapendik, 50) }}) @endif
                                @else Belum diajukan.
                                @endif
                            </p>
                            @if(!$sp || $sp->status_bapendik === 'ditolak')
                                <a href="{{ route('mahasiswa.surat-pengantar.create') }}" class="text-xs text-blue-600 hover:underline dark:text-blue-500">Ajukan Surat Pengantar &rarr;</a>
                            @elseif($sp->status_bapendik === 'menunggu')
                                <a href="{{ route('mahasiswa.surat-pengantar.index') }}" class="text-xs text-blue-600 hover:underline dark:text-blue-500">Lihat Detail &rarr;</a>
                            @endif
                        </li>

                        {{-- TAHAP 2: PENGAJUAN KP --}}
                        @php
                            $kpStepDone = $pengajuanKpAktif->status_komisi === 'diterima';
                            $kpStepCurrent = $pengajuanKpAktif->status_komisi === 'direview' || (!$pengajuanKpAktif->status_komisi && $spStepDone);
                            $kpStepFailed = $pengajuanKpAktif->status_komisi === 'ditolak';
                        @endphp
                        <li class="mb-10 ms-6">
                     <span class="absolute flex items-center justify-center w-8 h-8 {{ $kpStepDone ? 'bg-green-200 dark:bg-green-900' : ($kpStepCurrent ? 'bg-blue-200 dark:bg-blue-900' : ($kpStepFailed ? 'bg-red-200 dark:bg-red-900' : 'bg-gray-100 dark:bg-gray-700')) }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                        {{-- Ikon serupa dengan Surat Pengantar --}}
                         @if($kpStepDone) <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/></svg>
                         @elseif($kpStepCurrent) <svg class="w-3.5 h-3.5 text-blue-500 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.707 8.707-4 4a1 1 0 0 1-1.414-1.414L10.586 9H7a1 1 0 0 1 0-2h3.586l-2.293-2.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414Z"/></svg>
                         @elseif($kpStepFailed) <svg class="w-3.5 h-3.5 text-red-500 dark:text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                         @else <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/></svg>
                         @endif
                    </span>
                            <h3 class="font-medium leading-tight text-gray-900 dark:text-white">2. Pengajuan KP</h3>
                            <p class="text-sm">Status Komisi: {{ ucfirst(str_replace('_',' ',$pengajuanKpAktif->status_komisi)) }}
                                @if($pengajuanKpAktif->status_komisi == 'diterima' && $pengajuanKpAktif->tanggal_diterima_komisi)
                                    (Tgl. {{ \Carbon\Carbon::parse($pengajuanKpAktif->tanggal_diterima_komisi)->isoFormat('D MMM YY') }})
                                @elseif($pengajuanKpAktif->status_komisi == 'ditolak' && $pengajuanKpAktif->alasan_tidak_layak)
                                    (Alasan: {{ Str::limit($pengajuanKpAktif->alasan_tidak_layak, 50) }})
                                @endif
                            </p>
                            @if ($spStepDone && ($pengajuanKpAktif->status_komisi == 'direview' || $pengajuanKpAktif->status_komisi == 'ditolak' || !$pengajuanKpAktif->status_komisi) )
                                <a href="{{ route('mahasiswa.pengajuan-kp.create') }}" class="text-xs text-blue-600 hover:underline dark:text-blue-500">Ajukan/Revisi Pengajuan KP &rarr;</a>
                            @elseif($pengajuanKpAktif->status_komisi)
                                <a href="{{ route('mahasiswa.pengajuan-kp.index') }}" class="text-xs text-blue-600 hover:underline dark:text-blue-500">Lihat Detail &rarr;</a>
                            @endif
                        </li>

                        {{-- TAHAP 3: KONSULTASI --}}
                        @php
                            $konsulVerifiedCount = $pengajuanKpAktif->jumlah_konsultasi_verified;
                            $konsulStepDone = $konsulVerifiedCount >= $minKonsultasi;
                            $konsulStepCurrent = $pengajuanKpAktif->status_komisi === 'diterima' && $pengajuanKpAktif->status_kp === 'dalam_proses' && !$konsulStepDone;
                        @endphp
                        <li class="mb-10 ms-6">
                     <span class="absolute flex items-center justify-center w-8 h-8 {{ $konsulStepDone ? 'bg-green-200 dark:bg-green-900' : ($konsulStepCurrent ? 'bg-blue-200 dark:bg-blue-900' : 'bg-gray-100 dark:bg-gray-700') }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                        {{-- Ikon --}}
                         @if($konsulStepDone) <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/></svg>
                         @elseif($konsulStepCurrent) <svg class="w-3.5 h-3.5 text-blue-500 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.707 8.707-4 4a1 1 0 0 1-1.414-1.414L10.586 9H7a1 1 0 0 1 0-2h3.586l-2.293-2.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414Z"/></svg>
                         @else <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18"><path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/></svg>
                         @endif
                    </span>
                            <h3 class="font-medium leading-tight text-gray-900 dark:text-white">3. Konsultasi Bimbingan</h3>
                            <p class="text-sm">Terverifikasi: {{ $konsulVerifiedCount }}/{{$minKonsultasi}} sesi.</p>
                            @if ($pengajuanKpAktif->status_komisi === 'diterima' && $pengajuanKpAktif->status_kp === 'dalam_proses')
                                <a href="{{ route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuanKpAktif->id) }}" class="text-xs text-blue-600 hover:underline dark:text-blue-500">Lihat/Tambah Konsultasi &rarr;</a>
                            @endif
                        </li>

                        {{-- TAHAP 4: SEMINAR --}}
                        @php
                            $seminarStepDone = $seminarTerkini && $seminarTerkini->status_pengajuan === 'selesai_dinilai';
                            $seminarStepCurrent = $seminarTerkini && in_array($seminarTerkini->status_pengajuan, ['diajukan_mahasiswa', 'disetujui_dospem', 'dijadwalkan_komisi']);
                            $seminarStepFailed = $seminarTerkini && in_array($seminarTerkini->status_pengajuan, ['ditolak_dospem', 'dibatalkan', 'revisi_jadwal_komisi']);
                            $bisaAjukanSeminar = $konsulStepDone && !$pengajuanKpAktif->has_active_seminar;
                        @endphp
                        <li class="mb-10 ms-6">
                    <span class="absolute flex items-center justify-center w-8 h-8 {{ $seminarStepDone ? 'bg-green-200 dark:bg-green-900' : ($seminarStepCurrent ? 'bg-blue-200 dark:bg-blue-900' : ($seminarStepFailed ? 'bg-red-200 dark:bg-red-900' : ($bisaAjukanSeminar ? 'bg-yellow-200 dark:bg-yellow-900' : 'bg-gray-100 dark:bg-gray-700'))) }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                       {{-- Ikon --}}
                        @if($seminarStepDone) <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/></svg>
                        @elseif($seminarStepCurrent) <svg class="w-3.5 h-3.5 text-blue-500 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.707 8.707-4 4a1 1 0 0 1-1.414-1.414L10.586 9H7a1 1 0 0 1 0-2h3.586l-2.293-2.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414Z"/></svg>
                        @elseif($seminarStepFailed) <svg class="w-3.5 h-3.5 text-red-500 dark:text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                        @elseif($bisaAjukanSeminar) <svg class="w-3.5 h-3.5 text-yellow-600 dark:text-yellow-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 0 19 9.5 9.5 0 0 0 0-19ZM10 12a2 2 0 1 1 0-4 2 2 0 0 1 0 4Zm0-7a1 1 0 0 1 1 1v1a1 1 0 1 1-2 0V6a1 1 0 0 1 1-1Z"/></svg>
                        @else <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="M16 0H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0ZM13.75 17a1 1 0 0 1-1.729.686l-1.75-3.5a1 1 0 0 1 .353-1.353l3.5-1.75a1 1 0 0 1 1.353.353l1.75 3.5A1 1 0 0 1 17 17h-3.25Z"/></svg>
                        @endif
                    </span>
                            <h3 class="font-medium leading-tight text-gray-900 dark:text-white">4. Seminar KP</h3>
                            <p class="text-sm">
                                @if($seminarTerkini)
                                    Status: {{ ucfirst(str_replace('_',' ',$seminarTerkini->status_pengajuan)) }}
                                    @if($seminarTerkini->status_pengajuan == 'dijadwalkan_komisi')
                                        <br> Jadwal: {{ \Carbon\Carbon::parse($seminarTerkini->tanggal_seminar)->isoFormat('D MMM YY') }}, Pkl {{ \Carbon\Carbon::parse($seminarTerkini->jam_mulai)->format('H:i') }}
                                    @endif
                                @elseif($bisaAjukanSeminar)
                                    Anda sudah bisa mengajukan seminar.
                                @else
                                    Selesaikan tahap konsultasi.
                                @endif
                            </p>
                            @if ($bisaAjukanSeminar)
                                <a href="{{ route('mahasiswa.pengajuan-kp.seminar.create', $pengajuanKpAktif->id) }}" class="text-xs text-blue-600 hover:underline dark:text-blue-500">Ajukan Seminar &rarr;</a>
                            @elseif($seminarTerkini)
                                <a href="{{ route('mahasiswa.seminar.index') }}" class="text-xs text-blue-600 hover:underline dark:text-blue-500">Lihat Detail Seminar &rarr;</a>
                            @endif
                        </li>

                        {{-- TAHAP 5: PENYELESAIAN & NILAI --}}
                        @php
                            $selesaiStepDone = $pengajuanKpAktif->status_kp === 'lulus';
                            $selesaiStepFailed = $pengajuanKpAktif->status_kp === 'tidak_lulus';
                            $selesaiStepCurrent = $seminarTerkini && $seminarTerkini->status_pengajuan === 'selesai_dinilai';
                        @endphp
                        <li class="ms-6"> {{-- Hapus mb-10 untuk item terakhir --}}
                            <span class="absolute flex items-center justify-center w-8 h-8 {{ $selesaiStepDone ? 'bg-green-200 dark:bg-green-900' : ($selesaiStepCurrent ? 'bg-blue-200 dark:bg-blue-900' : ($selesaiStepFailed ? 'bg-red-200 dark:bg-red-900' : 'bg-gray-100 dark:bg-gray-700')) }} rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                       {{-- Ikon --}}
                                @if($selesaiStepDone) <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"><path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z"/></svg>
                                @elseif($selesaiStepCurrent) <svg class="w-3.5 h-3.5 text-blue-500 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.707 8.707-4 4a1 1 0 0 1-1.414-1.414L10.586 9H7a1 1 0 0 1 0-2h3.586l-2.293-2.293a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414Z"/></svg>
                                @elseif($selesaiStepFailed) <svg class="w-3.5 h-3.5 text-red-500 dark:text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                                @else <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M19.25 10a9.25 9.25 0 1 1-18.5 0 9.25 9.25 0 0 1 18.5 0ZM9.25 7a1 1 0 0 0-1 1v1a1 1 0 0 0 2 0V8a1 1 0 0 0-1-1Zm0 5a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0v-2a1 1 0 0 0-1-1Z"/></svg>
                                @endif
                    </span>
                            <h3 class="font-medium leading-tight text-gray-900 dark:text-white">5. Penyelesaian & Nilai KP</h3>
                            <p class="text-sm">
                                @if ($pengajuanKpAktif->status_kp === 'lulus' || $pengajuanKpAktif->status_kp === 'tidak_lulus')
                                    Status KP: <span class="font-semibold">{{ ucfirst($pengajuanKpAktif->status_kp) }}</span>
                                    @if($pengajuanKpAktif->sudah_upload_bukti_distribusi)
                                        <br>Nilai Akhir: {{ $pengajuanKpAktif->nilai_akhir_angka ?? 'N/A' }} / {{ $pengajuanKpAktif->nilai_akhir_huruf ?? 'N/A' }}
                                    @else
                                        <br><span class="italic">Upload bukti distribusi untuk lihat nilai final.</span>
                                    @endif
                                @elseif($selesaiStepCurrent && !$pengajuanKpAktif->sudah_upload_bukti_distribusi)
                                    Seminar telah dinilai. Silakan upload bukti distribusi laporan.
                                @elseif($selesaiStepCurrent && $pengajuanKpAktif->sudah_upload_bukti_distribusi)
                                    Distribusi Selesai. Nilai seminar (akhir) bisa dilihat di halaman seminar.
                                @else
                                    Menunggu hasil seminar.
                                @endif
                            </p>
                            @if ($selesaiStepCurrent && !$pengajuanKpAktif->sudah_upload_bukti_distribusi)
                                <a href="{{ route('mahasiswa.pengajuan-kp.distribusi.create', $pengajuanKpAktif->id) }}" class="text-xs text-blue-600 hover:underline dark:text-blue-500">Upload Bukti Distribusi &rarr;</a>
                            @endif
                        </li>
                    </ol>
                </div>

                <div class="lg:col-span-1 bg-white rounded-lg shadow p-6 dark:bg-gray-800 h-fit">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-3">Detail Kerja Praktek Aktif</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Judul KP:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKpAktif->judul_kp }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Lokasi/Instansi:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $pengajuanKpAktif->instansi_lokasi }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Dosen Pembimbing:</p>
                            <p class="text-gray-900 dark:text-white font-medium">
                                {{ $pengajuanKpAktif->dosenPembimbing->user->name ?? 'Belum ditentukan' }}
                                @if($pengajuanKpAktif->dosenPembimbing)
                                    <span class="text-xs"> (NIDN: {{ $pengajuanKpAktif->dosenPembimbing->nidn }})</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Periode Pelaksanaan:</p>
                            <p class="text-gray-900 dark:text-white font-medium">
                                @if($pengajuanKpAktif->tanggal_mulai && $pengajuanKpAktif->tanggal_selesai)
                                    {{ \Carbon\Carbon::parse($pengajuanKpAktif->tanggal_mulai)->isoFormat('D MMM YY') }} - {{ \Carbon\Carbon::parse($pengajuanKpAktif->tanggal_selesai)->isoFormat('D MMM YY') }}
                                @else
                                    Belum ditetapkan
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Status Pengajuan Komisi:</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ ucfirst(str_replace('_',' ',$pengajuanKpAktif->status_komisi)) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Status KP Keseluruhan:</p>
                            <p class="font-semibold {{ $pengajuanKpAktif->status_kp == 'lulus' ? 'text-green-600 dark:text-green-400' : ($pengajuanKpAktif->status_kp == 'tidak_lulus' ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white') }}">
                                {{ ucfirst(str_replace('_',' ',$pengajuanKpAktif->status_kp)) }}
                            </p>
                        </div>
                    </div>
                </div>

            @else {{-- Jika tidak ada pengajuan KP Aktif --}}
            <div class="lg:col-span-3 p-6 text-center bg-blue-50 rounded-lg dark:bg-gray-700">
                <svg class="w-12 h-12 mx-auto mb-3 text-blue-500 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <p class="text-gray-900 dark:text-white mb-3 font-semibold">Anda belum memiliki pengajuan Kerja Praktek yang aktif.</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Silakan mulai dengan mengajukan surat pengantar jika belum, atau buat pengajuan KP jika surat pengantar sudah disetujui.</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('mahasiswa.surat-pengantar.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Ajukan Surat Pengantar
                    </a>
                    <a href="{{ route('mahasiswa.pengajuan-kp.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Buat Pengajuan KP
                    </a>
                </div>
            </div>
            @endif
        </div>


        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Navigasi Cepat</h2>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('mahasiswa.surat-pengantar.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">
                    <div class="p-3 mb-2 text-indigo-600 bg-indigo-100 rounded-full dark:text-indigo-400 dark:bg-gray-700">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 19" xmlns="http://www.w3.org/2000/svg"><path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/><path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Riwayat Surat Pengantar</span>
                </a>
                <a href="{{ route('mahasiswa.pengajuan-kp.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">
                    <div class="p-3 mb-2 text-teal-600 bg-teal-100 rounded-full dark:text-teal-400 dark:bg-gray-700">
                        <svg class="shrink-0 w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.043.043C3.998-.344 0 3.092 0 7.347c0 2.008.786 3.844 2.09 5.207 1.44 1.475 3.34 2.362 5.403 2.452a1 1 0 0 0 .957-.957V8.348a1 1 0 0 0-.957-.957A3.443 3.443 0 0 1 4.093 4.09a3.427 3.427 0 0 1 .558-3.04C5.116.558 5.711.112 6.36.02c1.421-.208 2.87.208 3.888 1.225l.006.006a1.01 1.01 0 0 0 .706.293h2.029a1 1 0 0 0 .707-1.707A6.96 6.96 0 0 0 12.13 0H9.043ZM7 9.347a1 1 0 0 0-1 1v.003a1 1 0 1 0 2 0V10.35a1 1 0 0 0-1-1Z"/><path d="M17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Riwayat Pengajuan KP</span>
                </a>
                <a href="{{ route('mahasiswa.seminar.index') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">
                    <div class="p-3 mb-2 text-purple-600 bg-purple-100 rounded-full dark:text-purple-400 dark:bg-gray-700">
                        <svg class="shrink-0 w-8 h-8" fill="currentColor" viewBox="0 0 18 20" xmlns="http://www.w3.org/2000/svg"><path d="M16 0H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0ZM13.75 17a1 1 0 0 1-1.729.686l-1.75-3.5a1 1 0 0 1 .353-1.353l3.5-1.75a1 1 0 0 1 1.353.353l1.75 3.5A1 1 0 0 1 17 17h-3.25Z"/></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Riwayat Seminar KP</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 text-center transition-colors duration-150">
                    <div class="p-3 mb-2 text-pink-600 bg-pink-100 rounded-full dark:text-pink-400 dark:bg-gray-700">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-white">Profil Saya</span>
                </a>
            </div>
        </div>
    </div>
@endsection
