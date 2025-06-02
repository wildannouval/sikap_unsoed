@extends('main.app')

@section('title', 'Riwayat Pengajuan Kerja Praktek Saya')

@section('content')
    <section class="p-3 sm:p-5 antialiased">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Riwayat Pengajuan Kerja Praktek</h2>
                    <a href="{{ route('mahasiswa.pengajuan-kp.create') }}" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Buat Pengajuan KP Baru
                    </a>
                </div>

                @if (session('success'))
                    <div class="p-4 mx-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="p-4 mx-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('info'))
                    <div class="p-4 mx-4 mt-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                        {{ session('info') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Tgl. Ajuan</th>
                            <th scope="col" class="px-4 py-3">Judul KP</th>
                            <th scope="col" class="px-4 py-3">Instansi</th>
                            <th scope="col" class="px-4 py-3">Status Komisi</th>
                            <th scope="col" class="px-4 py-3">Status KP</th>
                            <th scope="col" class="px-4 py-3">Nilai Akhir</th>
                            <th scope="col" class="px-4 py-3">Dosbing</th>
                            <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($pengajuanKps as $pengajuan)
                            <tr class="border-b dark:border-gray-700">
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->isoFormat('D MMM YY') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ Str::limit($pengajuan->judul_kp, 35) }}</td>
                                <td class="px-4 py-3">{{ Str::limit($pengajuan->instansi_lokasi, 30) }}</td>
                                <td class="px-4 py-3">
                                    @if($pengajuan->status_komisi == 'direview')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Direview</span>
                                    @elseif($pengajuan->status_komisi == 'diterima')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Diterima</span>
                                        @if($pengajuan->tanggal_diterima_komisi)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tgl: {{ \Carbon\Carbon::parse($pengajuan->tanggal_diterima_komisi)->isoFormat('D MMM YY') }}</p>
                                        @endif
                                    @elseif($pengajuan->status_komisi == 'ditolak')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Ditolak</span>
                                        @if($pengajuan->alasan_tidak_layak)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Alasan: {{ Str::limit($pengajuan->alasan_tidak_layak, 50) }}</p>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($pengajuan->status_kp == 'lulus')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Lulus</span>
                                    @elseif($pengajuan->status_kp == 'tidak_lulus')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Tidak Lulus</span>
                                    @else
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ ucfirst(str_replace('_', ' ', $pengajuan->status_kp)) }}</span>
                                    @endif

                                    @php
                                        $seminarSelesaiDinilai = $pengajuan->seminars->firstWhere('status_pengajuan', 'selesai_dinilai');
                                    @endphp

                                    @if($seminarSelesaiDinilai && !$pengajuan->sudah_upload_bukti_distribusi)
                                        <span class="block mt-1 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Segera Upload Bukti Distribusi</span>
                                    @elseif($pengajuan->sudah_upload_bukti_distribusi)
                                        <span class="block mt-1 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Distribusi Selesai</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($pengajuan->status_kp == 'lulus' || $pengajuan->status_kp == 'tidak_lulus')
                                        @if($pengajuan->sudah_upload_bukti_distribusi)
                                            <span class="font-semibold">{{ $pengajuan->nilai_akhir_angka ?? 'N/A' }} / {{ $pengajuan->nilai_akhir_huruf ?? 'N/A' }}</span>
                                        @else
                                            <span class="text-xs italic">Upload bukti distribusi utk lihat nilai</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $pengajuan->dosenPembimbing->user->name ?? 'Belum Ditentukan' }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if ($pengajuan->status_komisi == 'diterima' && ($pengajuan->status_kp == 'dalam_proses' || $pengajuan->status_kp == 'pengajuan' ))
                                        <a href="{{ route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuan->id) }}" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-xs px-3 py-1.5 mb-1 inline-block">
                                            Konsultasi ({{ $pengajuan->jumlah_konsultasi_verified }})
                                        </a>

                                        @php
                                            // Ambil seminar terbaru yang terkait dengan pengajuan KP ini
                                            $seminarTerkini = $pengajuan->seminars()->orderBy('created_at', 'desc')->first();
                                            // Cek apakah bisa ajukan seminar baru
                                            $bisaAjukanSeminar = $pengajuan->jumlah_konsultasi_verified >= \App\Http\Controllers\Mahasiswa\SeminarKpController::MIN_KONSULTASI_VERIFIED &&
                                                                (!$seminarTerkini || !in_array($seminarTerkini->status_pengajuan, ['diajukan_mahasiswa', 'disetujui_dospem', 'dijadwalkan_komisi']));
                                        @endphp

                                        @if ($bisaAjukanSeminar)
                                            <a href="{{ route('mahasiswa.pengajuan-kp.seminar.create', $pengajuan->id) }}" class="text-white bg-teal-600 hover:bg-teal-700 font-medium rounded-lg text-xs px-3 py-1.5 mb-1 inline-block">
                                                Ajukan Seminar
                                            </a>
                                        @elseif($seminarTerkini && in_array($seminarTerkini->status_pengajuan, ['diajukan_mahasiswa', 'disetujui_dospem', 'dijadwalkan_komisi']))
                                            <span class="text-xs text-gray-500 dark:text-gray-400 block">(Seminar: {{ ucfirst(str_replace('_',' ',$seminarTerkini->status_pengajuan)) }})</span>
                                        @elseif ($pengajuan->jumlah_konsultasi_verified < \App\Http\Controllers\Mahasiswa\SeminarKpController::MIN_KONSULTASI_VERIFIED && $pengajuan->status_kp == 'dalam_proses' && (!$seminarTerkini || $seminarTerkini->status_pengajuan == 'selesai_dinilai' || $seminarTerkini->status_pengajuan == 'ditolak_dospem' || $seminarTerkini->status_pengajuan == 'dibatalkan' ))
                                            <span class="text-xs text-gray-500 dark:text-gray-400 block">(Syarat Konsul Seminar: {{ $pengajuan->jumlah_konsultasi_verified }}/{{ \App\Http\Controllers\Mahasiswa\SeminarKpController::MIN_KONSULTASI_VERIFIED }})</span>
                                        @endif
                                    @endif

                                    @if ($seminarSelesaiDinilai && !$pengajuan->sudah_upload_bukti_distribusi)
                                        <a href="{{ route('mahasiswa.pengajuan-kp.distribusi.create', $pengajuan->id) }}" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-xs px-3 py-1.5 mb-1 inline-block">
                                            Upload Bukti Distribusi
                                        </a>
                                    @endif

                                    @if(empty($pengajuan->status_komisi) && $pengajuan->status_kp == 'pengajuan' && $pengajuan->status_komisi != 'diterima' && $pengajuan->status_kp != 'dalam_proses' && !$seminarSelesaiDinilai && !$pengajuan->sudah_upload_bukti_distribusi)
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada pengajuan kerja praktek. Klik "Buat Pengajuan KP Baru" untuk memulai.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $pengajuanKps->links() }}
                </nav>
            </div>
        </div>
    </section>
@endsection
