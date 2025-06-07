{{-- resources/views/partials/modal-verifikasi-konsultasi.blade.php --}}
<div id="verifikasiKonsultasiModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full"> {{-- Anda bisa ganti max-w-lg menjadi max-w-xl atau max-w-2xl jika butuh lebih lebar --}}
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Proses Catatan & Verifikasi Konsultasi
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="verifikasiKonsultasiModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>
            {{-- Form akan diatur action-nya oleh JavaScript --}}
            <form id="verifikasiForm" action="" method="POST" class="p-4 md:p-5">
                @csrf
                {{-- Karena route kita adalah POST, @csrf saja cukup. Jika route-nya PUT/PATCH, tambahkan @method('PUT') atau @method('PATCH') --}}
                {{-- Untuk route `dosen-pembimbing.konsultasi.verifikasi` yang kita definisikan sebagai POST, ini sudah benar. --}}

                <div class="grid gap-y-4">
                    <div>
                        <label for="modal_catatan_dosen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan Dosen Pembimbing:</label>
                        <textarea name="catatan_dosen" id="modal_catatan_dosen" rows="5" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Berikan catatan atau feedback untuk sesi konsultasi ini..."></textarea>
                        {{-- Pesan error validasi untuk catatan_dosen bisa ditambahkan di sini jika diperlukan setelah submit --}}
                        {{-- @error('catatan_dosen') <p class="mt-2 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror --}}
                    </div>
                    <div class="flex items-center">
                        <input id="modal_diverifikasi" name="diverifikasi" type="checkbox" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="modal_diverifikasi" class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Tandai Sudah Diverifikasi</label>
                    </div>
                </div>

                {{-- Tombol Aksi Modal --}}
                <div class="flex items-center justify-end space-x-4 pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
                    <button data-modal-hide="verifikasiKonsultasiModal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors duration-150">
                        Batal
                    </button>
                    <button type="submit" class="text-white inline-flex items-center bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
