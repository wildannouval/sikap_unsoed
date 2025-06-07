@extends('main.app')

@section('title', 'Riwayat Pengajuan Kerja Praktek Saya')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4"> {{-- Container agar memenuhi ruang --}}
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat Pengajuan Kerja Praktek</h2>
                    <a href="{{ route('mahasiswa.pengajuan-kp.create') }}" class="inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-150">
                        <svg class="h-4 w-4 mr-2 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" /></svg>
                        Buat Pengajuan KP Baru
                    </a>
                </div>

                <div class="px-4 pt-4">
                    @include('partials.session-messages')
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Tgl. Ajuan</th>
                            <th scope="col" class="px-6 py-3">Judul KP</th>
                            <th scope="col" class="px-6 py-3">Instansi</th>
                            <th scope="col" class="px-6 py-3">Status Komisi</th>
                            <th scope="col" class="px-6 py-3">Status SPK</th>
                            <th scope="col" class="px-6 py-3">Status KP & Distribusi</th>
                            <th scope="col" class="px-6 py-3">Nilai Akhir</th>
                            <th scope="col" class="px-6 py-3">Dosen Pembimbing</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($pengajuanKps as $pengajuan)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $loop->iteration + $pengajuanKps->firstItem() - 1 }}
                                </td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->isoFormat('D MMM YY') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ Str::limit($pengajuan->judul_kp, 30) }}</td>
                                <td class="px-6 py-4">{{ Str::limit($pengajuan->instansi_lokasi, 25) }}</td>
                                <td class="px-6 py-4">
                                    @if($pengajuan->status_komisi == 'direview')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Direview</span>
                                    @elseif($pengajuan->status_komisi == 'diterima')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Diterima Komisi</span>
                                        @if($pengajuan->tanggal_diterima_komisi)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Tgl: {{ \Carbon\Carbon::parse($pengajuan->tanggal_diterima_komisi)->isoFormat('D MMM YY') }}</p>
                                        @endif
                                    @elseif($pengajuan->status_komisi == 'ditolak')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Ditolak Komisi</span>
                                        @if($pengajuan->alasan_tidak_layak)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Alasan: {{ Str::limit($pengajuan->alasan_tidak_layak, 50) }}</p>
                                        @endif
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_',' ',$pengajuan->status_komisi ?? 'Belum Diajukan')) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($pengajuan->spk_dicetak_at)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Siap Diambil</span>
                                        @if($pengajuan->spk_diambil_at)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Mulai Tgl: {{ \Carbon\Carbon::parse($pengajuan->spk_diambil_at)->isoFormat('D MMM YY') }}</p>
                                        @else
                                            <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">Hubungi Bapendik</p>
                                        @endif
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">Diproses</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($pengajuan->status_kp == 'lulus')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Lulus</span>
                                    @elseif($pengajuan->status_kp == 'tidak_lulus')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Tidak Lulus</span>
                                    @else
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ ucfirst(str_replace('_', ' ', $pengajuan->status_kp)) }}</span>
                                    @endif

                                    @php
                                        $seminarSelesaiDinilai = $pengajuan->seminars()->where('status_pengajuan', 'selesai_dinilai')->exists();
                                    @endphp

                                    @if($seminarSelesaiDinilai && !$pengajuan->sudah_upload_bukti_distribusi)
                                        <span class="block mt-1 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Upload Bukti Distribusi</span>
                                    @elseif($pengajuan->sudah_upload_bukti_distribusi)
                                        <span class="block mt-1 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Distribusi Selesai</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($pengajuan->status_kp == 'lulus' || $pengajuan->status_kp == 'tidak_lulus')
                                        @if($pengajuan->sudah_upload_bukti_distribusi)
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $pengajuan->nilai_akhir_angka ?? 'N/A' }} / {{ $pengajuan->nilai_akhir_huruf ?? 'N/A' }}</span>
                                        @else
                                            <span class="text-xs italic text-gray-500 dark:text-gray-400">Upload bukti distribusi</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $pengajuan->dosenPembimbing->user->name ?? 'Belum Ditentukan' }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if ($pengajuan->status_komisi == 'diterima' && in_array($pengajuan->status_kp, ['dalam_proses', 'pengajuan']))
                                        <a href="{{ route('mahasiswa.pengajuan-kp.konsultasi.index', $pengajuan->id) }}" class="inline-flex items-center text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-xs px-3 py-1.5 mb-1 md:mb-0 md:me-1 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none dark:focus:ring-indigo-800 transition-colors duration-150" title="Lihat atau Tambah Konsultasi">
                                            <svg class="w-3.5 h-3.5 mr-1 -ml-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M18 5.923A1.99 1.99 0 0 0 16.084 4H3.916A1.99 1.99 0 0 0 2 5.923V14.08A1.99 1.99 0 0 0 3.916 16h12.168A1.99 1.99 0 0 0 18 14.079V5.923Zm-7.15.619L14.084 10h-3.5L7.15 6.542ZM5.014 13.318a1.001 1.001 0 0 1-.992-.993V7.671a1 1 0 0 1 .992-.993l4.893-2.446a1 1 0 0 1 1.21.001l4.893 2.446a1 1 0 0 1 .992.993v4.654a1.001 1.001 0 0 1-.992.993L5.014 13.318Z"/></svg>
                                            Konsultasi ({{ $pengajuan->jumlah_konsultasi_verified }})
                                        </a>

{{--                                        @php--}}
{{--                                            // $seminarTerkiniUntukAksi sudah kita ambil di controller PengajuanKpController@index--}}
{{--                                            // dan sudah di-pass ke view sebagai bagian dari $pengajuanKps ($pengajuan->seminars->first())--}}
{{--                                            $seminarTerkiniUntukAksi = $pengajuan->seminars->first();--}}
{{--                                            $bisaAjukanSeminar = $pengajuan->jumlah_konsultasi_verified >= \App\Http\Controllers\Mahasiswa\SeminarKpController::MIN_KONSULTASI_VERIFIED &&--}}
{{--                                                                (!$seminarTerkiniUntukAksi || !in_array($seminarTerkiniUntukAksi->status_pengajuan, ['diajukan_mahasiswa', 'disetujui_dospem', 'dijadwalkan_komisi']));--}}
{{--                                        @endphp--}}

{{--                                        @if ($bisaAjukanSeminar)--}}
{{--                                            <a href="{{ route('mahasiswa.pengajuan-kp.seminar.create', $pengajuan->id) }}" class="inline-flex items-center text-white bg-teal-600 hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 font-medium rounded-lg text-xs px-3 py-1.5 mb-1 md:mb-0 md:me-1 dark:bg-teal-500 dark:hover:bg-teal-600 focus:outline-none dark:focus:ring-teal-800 transition-colors duration-150" title="Ajukan Seminar KP">--}}
{{--                                                <svg class="w-3.5 h-3.5 mr-1 -ml-0.5" fill="currentColor" viewBox="0 0 18 20" xmlns="http://www.w3.org/2000/svg"><path d="M16 0H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0ZM13.75 17a1 1 0 0 1-1.729.686l-1.75-3.5a1 1 0 0 1 .353-1.353l3.5-1.75a1 1 0 0 1 1.353.353l1.75 3.5A1 1 0 0 1 17 17h-3.25Z"/></svg>--}}
{{--                                                Ajukan Seminar--}}
{{--                                            </a>--}}
{{--                                        @elseif($seminarTerkiniUntukAksi && in_array($seminarTerkiniUntukAksi->status_pengajuan, ['diajukan_mahasiswa', 'disetujui_dospem', 'dijadwalkan_komisi']))--}}
{{--                                            <span class="text-xs text-gray-500 dark:text-gray-400 block mt-1">(Seminar: {{ ucfirst(str_replace('_',' ',$seminarTerkiniUntukAksi->status_pengajuan)) }})</span>--}}
{{--                                        @elseif ($pengajuan->jumlah_konsultasi_verified < \App\Http\Controllers\Mahasiswa\SeminarKpController::MIN_KONSULTASI_VERIFIED && $pengajuan->status_kp == 'dalam_proses' && (!$seminarTerkiniUntukAksi || !in_array($seminarTerkiniUntukAksi->status_pengajuan, ['diajukan_mahasiswa', 'disetujui_dospem', 'dijadwalkan_komisi'])))--}}
{{--                                            <span class="text-xs text-gray-500 dark:text-gray-400 block mt-1">(Syarat Seminar: {{ $pengajuan->jumlah_konsultasi_verified }}/{{ \App\Http\Controllers\Mahasiswa\SeminarKpController::MIN_KONSULTASI_VERIFIED }})</span>--}}
{{--                                        @endif--}}
                                    @endif

                                    @if ($seminarSelesaiDinilai && !$pengajuan->sudah_upload_bukti_distribusi)
                                        <a href="{{ route('mahasiswa.pengajuan-kp.distribusi.create', $pengajuan->id) }}" class="inline-flex items-center text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 mb-1 md:mb-0 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none dark:focus:ring-green-800 transition-colors duration-150" title="Upload Bukti Distribusi Laporan">
                                            <svg class="w-3.5 h-3.5 mr-1 -ml-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M15.172 7.172a1 1 0 012.828 0l1.414 1.414a1 1 0 010 1.414l-1.414 1.414a1 1 0 01-1.414 0l-1.414-1.414a1 1 0 010-1.414l1.414-1.414zM10 2.586l4.293 4.293a1 1 0 11-1.414 1.414L10 5.414 7.121 8.293a1 1 0 01-1.414 0L2.293 4.879A1 1 0 013.707 3.464L10 9.757l6.293-6.293a1 1 0 011.414 0L20 6.172a1.001 1.001 0 010 1.414l-2.414 2.414a1 1 0 01-.707.293H8.828a1 1 0 01-.707-.293L3.414 5.121A1 1 0 013.414 3.707L6.293.879a1 1 0 011.414 0L10 2.586Z"/></svg>
                                            Upload Distribusi
                                        </a>
                                    @endif

                                    @if(!($pengajuan->status_komisi == 'diterima' && in_array($pengajuan->status_kp, ['dalam_proses', 'pengajuan'])) && !($seminarSelesaiDinilai && !$pengajuan->sudah_upload_bukti_distribusi))
                                        <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada pengajuan kerja praktek. Klik "Buat Pengajuan KP Baru" untuk memulai.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $pengajuanKps->appends(request()->query())->links() }}
                </nav>
            </div>
        </div>
    </section>

    @if(session('success_modal_message'))
        @include('partials.modal-success')
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success_modal_message'))
            const successModalEl = document.getElementById('successModal');
            const successModalMessageEl = document.getElementById('successModalMessage');
            if (successModalEl && successModalMessageEl) {
                successModalMessageEl.textContent = @json(session('success_modal_message'));
                const successModal = new Modal(successModalEl, {});
                successModal.show();
            }
            @endif
        });
    </script>
@endpush
