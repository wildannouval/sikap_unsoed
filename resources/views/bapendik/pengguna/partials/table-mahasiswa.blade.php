{{-- Form Search dan Filter untuk Mahasiswa --}}
<form method="GET" action="{{ route('bapendik.pengguna.index') }}">
    <input type="hidden" name="mahasiswa_page" value="{{ $request->input('mahasiswa_page', 1) }}">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 p-4 bg-white dark:bg-gray-900 rounded-lg shadow">
        <div>
            <label for="search_mahasiswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari Mahasiswa (Nama, Email, NIM)</label>
            <input type="text" name="search_mahasiswa" id="search_mahasiswa" value="{{ $request->search_mahasiswa }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ketik kata kunci...">
        </div>
        <div>
            <label for="jurusan_mahasiswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter Jurusan</label>
            <select name="jurusan_mahasiswa" id="jurusan_mahasiswa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Semua Jurusan</option>
                @foreach ($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}" {{ $request->jurusan_mahasiswa == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Terapkan</button>
        </div>
    </div>
</form>

<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-4 py-3">Nama</th>
            <th scope="col" class="px-4 py-3">Email</th>
            <th scope="col" class="px-4 py-3">NIM</th>
            <th scope="col" class="px-4 py-3">Jurusan</th>
            <th scope="col" class="px-4 py-3 text-right">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($users as $user) {{-- users di sini adalah $mahasiswas dari controller --}}
        <tr class="border-b dark:border-gray-700">
            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->name }}</th>
            <td class="px-4 py-3">{{ $user->email }}</td>
            <td class="px-4 py-3">{{ $user->mahasiswa->nim ?? '-' }}</td>
            <td class="px-4 py-3">{{ $user->mahasiswa->jurusan->nama ?? '-' }}</td>
            <td class="px-4 py-3 flex items-center justify-end">
                <button id="mahasiswa-dropdown-button-{{$user->id}}" data-dropdown-toggle="mahasiswa-dropdown-{{$user->id}}" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 rounded-lg" type="button">
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" /></svg>
                </button>
                <div id="mahasiswa-dropdown-{{$user->id}}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow">
                    <ul class="py-1 text-sm">
                        <li><a href="{{ route('bapendik.pengguna.edit', $user->id) }}" class="block py-2 px-4 hover:bg-gray-100">Edit</a></li>
                        <li><button type="button" data-modal-target="deleteModal" data-modal-toggle="deleteModal" data-url="{{ route('bapendik.pengguna.destroy', $user->id) }}" class="w-full text-left py-2 px-4 hover:bg-gray-100 text-red-500">Hapus</button></li>
                    </ul>
                </div>
            </td>
        </tr>
        @empty
            <tr><td colspan="5" class="px-4 py-3 text-center">Data mahasiswa tidak ditemukan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<nav class="p-4">
    {{ $users->appends(request()->except('mahasiswa_page'))->links() }}
</nav>
