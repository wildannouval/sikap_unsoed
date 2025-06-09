@extends('main.app')

@section('title', 'Riwayat & Pengajuan Seminar KP')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat & Pengajuan Seminar Kerja Praktek</h2>
                        {{-- Pesan informatif mengenai syarat pengajuan seminar --}}
                        @if (!$bisaAjukanSeminarBaru && !empty($pesanSyaratSeminar))
                            <p class="text-sm text-yellow-600 dark:text-yellow-400 mt-1 italic">{{ $pesanSyaratSeminar }}</p>
                        @elseif($bisaAjukanSeminarBaru && $pengajuanKpAktif)
                            <p class="text-sm text-green-600 dark:text-green-400 mt-1">Anda sudah memenuhi syarat untuk mengajukan seminar KP: <span class="font-semibold">"{{ Str::limit($pengajuanKpAktif->judul_kp, 50) }}"</span>.</p>
                        @endif
                    </div>

                    {{-- Tombol Ajukan Seminar Baru --}}
                    @if ($bisaAjukanSeminarBaru && $pengajuanKpAktif)
                        <a href="{{ route('mahasiswa.pengajuan-kp.seminar.create', $pengajuanKpAktif->id) }}" class="inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none dark:focus:ring-blue-800 transition-colors duration-150 whitespace-nowrap">
                            <svg class="h-4 w-4 mr-2 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" /></svg>
                            Ajukan Seminar Baru
                        </a>
                    @endif
                </div>

                <div class="px-4 pt-4">
                    @include('partials.session-messages')
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Tgl. Diajukan</th>
                            <th scope="col" class="px-6 py-3">Judul KP Final</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Jadwal Final</th>
                            <th scope="col" class="px-6 py-3">Nilai</th>
                            <th scope="col" class="px-6 py-3">Info Tambahan</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($seminars as $seminar)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $loop->iteration + $seminars->firstItem() - 1 }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($seminar->tanggal_pengajuan_seminar)->isoFormat('D MMM YY, HH:mm') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $seminar->judul_kp_final }}</td>
                                <td class="px-6 py-4">
                                    {{-- ... (Badge status yang sudah kita perbaiki sebelumnya) ... --}}
                                    @if($seminar->status_pengajuan == 'diajukan_mahasiswa')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Menunggu Persetujuan Dospem</span>
                                    @elseif($seminar->status_pengajuan == 'disetujui_dospem')
                                        <span class="bg-sky-100 text-sky-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-sky-900 dark:text-sky-300">Disetujui Dospem (Menunggu Jadwal)</span>
                                    @elseif($seminar->status_pengajuan == 'ditolak_dospem')
                                        <span class="bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-pink-900 dark:text-pink-300">Ditolak Dospem</span>
                                    @elseif($seminar->status_pengajuan == 'dijadwalkan_bapendik')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Dijadwalkan</span>
                                    @elseif($seminar->status_pengajuan == 'revisi_jadwal_bapendik')
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-orange-900 dark:text-orange-300">Diminta Revisi Jadwal</span>
                                    @elseif($seminar->status_pengajuan == 'selesai_dinilai')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Selesai Dinilai</span>
                                    @elseif($seminar->status_pengajuan == 'dibatalkan')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($seminar->status_pengajuan == 'dijadwalkan_bapendik' || $seminar->status_pengajuan == 'selesai_dinilai')
                                        {{ $seminar->tanggal_seminar ? \Carbon\Carbon::parse($seminar->tanggal_seminar)->isoFormat('dddd, D MMM YY') : '' }}<br>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $seminar->jam_mulai ? \Carbon\Carbon::parse($seminar->jam_mulai)->format('H:i') : '' }}{{ $seminar->jam_selesai ? ' - ' . \Carbon\Carbon::parse($seminar->jam_selesai)->format('H:i') : '' }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($seminar->status_pengajuan == 'selesai_dinilai')
                                        @if($seminar->pengajuanKp && $seminar->pengajuanKp->sudah_upload_bukti_distribusi)
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $seminar->nilai_seminar_angka ?? 'N/A' }} / {{ $seminar->nilai_seminar_huruf ?? 'N/A' }}</span>
                                        @else
                                            <span class="text-xs text-yellow-600 dark:text-yellow-400 italic">Upload bukti distribusi</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-600 dark:text-gray-300">
                                    @if($seminar->ba_tanggal_pengambilan)
                                        <p class="font-semibold">Ambil Berita Acara:</p>
                                        <p>{{ \Carbon\Carbon::parse($seminar->ba_tanggal_pengambilan)->isoFormat('D MMM YY') }}</p>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="border-b dark:border-gray-700">
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada riwayat pengajuan seminar.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">
                    {{ $seminars->links() }}
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
