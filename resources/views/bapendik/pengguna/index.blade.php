@extends('main.app')

@section('title', 'Manajemen Pengguna SIKAP')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Data Pengguna Sistem</h2>
                    <a href="{{ route('bapendik.pengguna.create') }}" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" /></svg>
                        Tambah Pengguna Baru
                    </a>
                </div>

                <div class="px-4">
                    @include('partials.session-messages')
                </div>

                <div class="mb-4 border-b border-gray-200 dark:border-gray-700 px-4 pt-4">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="penggunaTab" data-tabs-toggle="#penggunaTabContent" role="tablist">
                        <li class="me-2" role="presentation">
                            {{-- Tombol tab sekarang tidak perlu atribut aria-selected secara eksplisit, JS yang akan atur --}}
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="mahasiswa-tab-btn" data-tabs-target="#mahasiswa-tab-content" type="button" role="tab" aria-controls="mahasiswa-tab-content">Mahasiswa</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="dosen-tab-btn" data-tabs-target="#dosen-tab-content" type="button" role="tab" aria-controls="dosen-tab-content">Dosen</button>
                        </li>
                    </ul>
                </div>
                <div id="penggunaTabContent">
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="mahasiswa-tab-content" role="tabpanel" aria-labelledby="mahasiswa-tab-btn">
                        @include('bapendik.pengguna.partials.table-pengguna', ['users' => $mahasiswas, 'roleName' => 'Mahasiswa', 'filterRoleName' => 'mahasiswa', 'jurusans' => $jurusans, 'request' => $request])
                    </div>
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dosen-tab-content" role="tabpanel" aria-labelledby="dosen-tab-btn">
                        @include('bapendik.pengguna.partials.table-pengguna', ['users' => $dosens, 'roleName' => 'Dosen', 'filterRoleName' => 'dosen', 'jurusans' => $jurusans, 'request' => $request])
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.modal-delete-confirmation')
    @include('partials.modal-success')

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabsElement = document.getElementById('penggunaTabContent'); // Target konten tab
            if (tabsElement) {
                const tabButtons = [ // Definisikan elemen pemicu dan target
                    { id: 'mahasiswa', triggerEl: document.getElementById('mahasiswa-tab-btn'), targetEl: document.getElementById('mahasiswa-tab-content') },
                    { id: 'dosen', triggerEl: document.getElementById('dosen-tab-btn'), targetEl: document.getElementById('dosen-tab-content') }
                ];

                // Ambil tab aktif dari URL query parameter, default ke 'mahasiswa'
                const urlParams = new URLSearchParams(window.location.search);
                let activeTabId = urlParams.get('active_tab') || 'mahasiswa';

                // Pastikan activeTabId valid, jika tidak, kembali ke default
                const validTabIds = tabButtons.map(t => t.id);
                if (!validTabIds.includes(activeTabId)) {
                    activeTabId = 'mahasiswa';
                }

                const options = {
                    defaultTabId: activeTabId,
                    activeClasses: 'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-400 border-blue-600 dark:border-blue-500',
                    inactiveClasses: 'text-gray-500 hover:text-gray-600 dark:text-gray-400 border-transparent hover:border-gray-300 dark:hover:text-gray-300',
                    onShow: (tabsInstance, tab) => {
                        // Update URL dengan tab aktif agar bisa di-bookmark atau di-refresh
                        // hanya jika tab yang ditampilkan berbeda dari yang ada di URL (atau jika parameter belum ada)
                        const currentUrlParams = new URLSearchParams(window.location.search);
                        if (currentUrlParams.get('active_tab') !== tab.id) {
                            currentUrlParams.set('active_tab', tab.id);
                            // Hapus parameter halaman untuk tab yang tidak aktif untuk menghindari konflik pagination
                            if (tab.id === 'mahasiswa') {
                                currentUrlParams.delete('dosen_page');
                            } else if (tab.id === 'dosen') {
                                currentUrlParams.delete('mahasiswa_page');
                            }
                            // Ganti history state agar tidak menambah history baru setiap ganti tab, tapi update URL
                            window.history.replaceState({}, '', `${window.location.pathname}?${currentUrlParams.toString()}`);
                        }
                    }
                };
                const instanceOptions = {
                    id: 'penggunaTabParent', // ID unik untuk instance Tabs
                    overrideInstance: true
                };

                // Inisialisasi komponen Tabs dari Flowbite
                const tabs = new Tabs(tabsElement, tabButtons, options, instanceOptions);

                // Tampilkan tab yang sesuai berdasarkan activeTabId
                // Perlu memastikan triggerEl yang sesuai juga mendapatkan kelas 'active'
                tabs.show(activeTabId);
                tabButtons.forEach(tb => {
                    if (tb.id === activeTabId) {
                        tb.triggerEl.classList.remove(...options.inactiveClasses.split(' '));
                        tb.triggerEl.classList.add(...options.activeClasses.split(' '));
                        tb.triggerEl.setAttribute('aria-selected', 'true');
                    } else {
                        tb.triggerEl.classList.remove(...options.activeClasses.split(' '));
                        tb.triggerEl.classList.add(...options.inactiveClasses.split(' '));
                        tb.triggerEl.setAttribute('aria-selected', 'false');
                    }
                });
            }

            // Script untuk Modal Delete (tetap sama)
            const deleteModalEl = document.getElementById('deleteModal');
            if (deleteModalEl) {
                document.querySelectorAll('button[data-modal-toggle="deleteModal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const url = this.dataset.deleteUrl;
                        const form = document.getElementById('deleteRecordForm');
                        if (form) {
                            form.action = url;
                        }
                    });
                });
            }

            // Script untuk Modal Sukses (tetap sama)
            @if(session('success_modal_message'))
            const successModalElement = document.getElementById('successModal');
            const successModalMessageParagraph = document.getElementById('successModalMessage');

            if (successModalElement && successModalMessageParagraph) {
                successModalMessageParagraph.textContent = "{{ session('success_modal_message') }}";
                const modalInstance = new Modal(successModalElement, {});
                modalInstance.show();
            } else {
                if (!successModalElement) console.error('Elemen modal sukses dengan ID "successModal" tidak ditemukan.');
                if (!successModalMessageParagraph) console.error('Elemen pesan di modal sukses dengan ID "successModalMessage" tidak ditemukan.');
            }
            @endif
        });
    </script>
@endpush
