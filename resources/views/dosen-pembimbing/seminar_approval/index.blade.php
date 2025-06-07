@extends('main.app')

@section('title', 'Persetujuan Pengajuan Seminar KP')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Persetujuan Pengajuan Seminar KP</h2>
                </div>
                <div class="px-4 pt-4">@include('partials.session-messages')</div>
                <form method="GET" action="{{ route('dosen-pembimbing.seminar-approval.index') }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-4">
                        <div class="md:col-span-1">
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari (Nama Mhs/NIM/Judul)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                </div>
                                <input type="text" name="search" id="search" value="{{ $request->search ?? '' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Kata kunci...">
                            </div>
                        </div>
                        <div class="md:col-span-1">
                            <label for="status_pengajuan_filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter Status</label>
                            @php
                                // Tentukan nilai terpilih: jika parameter tidak ada, default ke 'diajukan_mahasiswa'.
                                $selectedValue = request()->has('status_pengajuan_filter')
                                                ? request('status_pengajuan_filter')
                                                : 'diajukan_mahasiswa';
                            @endphp
                            <select name="status_pengajuan_filter" id="status_pengajuan_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="" {{ $selectedValue == '' ? 'selected' : '' }}>Semua Status</option>
                                @foreach ($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ $selectedValue == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full md:w-auto text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Filter</button>
                            @if(request()->filled('search') || request()->filled('status_pengajuan_filter'))
                                <a href="{{ route('dosen-pembimbing.seminar-approval.index') }}" class="ml-2 w-full md:w-auto text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-gray-600 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Tgl. Ajuan</th>
                            <th scope="col" class="px-6 py-3">Mahasiswa</th>
                            <th scope="col" class="px-6 py-3">Judul KP Final</th>
                            <th scope="col" class="px-6 py-3">Status Persetujuan</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($seminarApplications as $seminar)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($seminar->tanggal_pengajuan_seminar)->isoFormat('D MMM YY') }}</td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $seminar->mahasiswa->user->name ?? 'N/A' }}</span><br>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">NIM: {{ $seminar->mahasiswa->nim ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4">{{ Str::limit($seminar->judul_kp_final, 35) }}</td>
                                <td class="px-6 py-4">
                                    @if($seminar->status_pengajuan == 'diajukan_mahasiswa')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Menunggu Persetujuan Anda</span>
                                    @elseif($seminar->status_pengajuan == 'disetujui_dospem')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">Telah Anda Setujui</span>
                                    @elseif($seminar->status_pengajuan == 'ditolak_dospem')
                                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">Telah Anda Tolak</span>
                                    @elseif($seminar->status_pengajuan == 'dijadwalkan_bapendik')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Dijadwalkan Bapendik</span>
                                    @elseif($seminar->status_pengajuan == 'selesai_dinilai')
                                        <span class="bg-purple-100 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">Selesai Dinilai</span>
                                    @elseif($seminar->status_pengajuan == 'dibatalkan')
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300">Dibatalkan</span>
                                    @else
                                        <span class="bg-orange-100 text-orange-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-orange-900 dark:text-orange-300">{{ ucfirst(str_replace('_', ' ', $seminar->status_pengajuan)) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('dosen-pembimbing.seminar-approval.showForm', $seminar->id) }}" class="inline-flex items-center text-white {{ $seminar->status_pengajuan == 'diajukan_mahasiswa' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-500 hover:bg-gray-600' }} focus:ring-4 font-medium rounded-lg text-xs px-3 py-1.5 transition-colors duration-150">
                                        <svg class="w-3.5 h-3.5 mr-1 -ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        {{ $seminar->status_pengajuan == 'diajukan_mahasiswa' ? 'Proses' : 'Lihat Detail' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada pengajuan seminar yang sesuai.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <nav class="p-4" aria-label="Table navigation">{{ $seminarApplications->appends(request()->query())->links() }}</nav>
            </div>
        </div>
    </section>

    @if(session('success_modal_message'))
        @include('partials.modal-success')
    @endif
@endsection

@push('scripts')
    {{-- Script untuk modal sukses --}}
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
