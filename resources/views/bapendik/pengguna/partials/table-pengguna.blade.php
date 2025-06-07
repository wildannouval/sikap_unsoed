{{-- resources/views/bapendik/pengguna/partials/table-pengguna.blade.php --}}
<form method="GET" action="{{ route('bapendik.pengguna.index') }}">
    {{-- Input hidden untuk membawa informasi tab yang sedang aktif --}}
    <input type="hidden" name="active_tab" value="{{ $filterRoleName }}">

    {{-- Input hidden untuk paginasi yang benar per tab --}}
    <input type="hidden" name="{{ $filterRoleName }}_page" value="{{ $request->input($filterRoleName.'_page', 1) }}">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 p-0">
        <div>
            <label for="search_{{ $filterRoleName }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cari {{ $roleName }}</label>
            <input type="text" name="search_{{ $filterRoleName }}" id="search_{{ $filterRoleName }}" value="{{ $request->input('search_'.$filterRoleName) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Nama, Email, NIM/NIDN...">
        </div>
        <div>
            <label for="jurusan_{{ $filterRoleName }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter Jurusan</label>
            <select name="jurusan_{{ $filterRoleName }}" id="jurusan_{{ $filterRoleName }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <option value="">Semua Jurusan</option>
                @foreach ($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}" {{ $request->input('jurusan_'.$filterRoleName) == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Filter</button>
        </div>
    </div>
</form>

<div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase {{ $filterRoleName === 'mahasiswa' ? 'bg-gray-100 dark:bg-gray-700' : 'bg-gray-100 dark:bg-gray-700' }}"> {{-- Kelas bg bisa disamakan atau dibedakan sedikit --}}
        <tr>
            <th scope="col" class="px-4 py-3">Nama</th>
            <th scope="col" class="px-4 py-3">Email</th>
            <th scope="col" class="px-4 py-3">{{ $filterRoleName === 'mahasiswa' ? 'NIM' : 'NIDN' }}</th>
            <th scope="col" class="px-4 py-3">Jurusan</th>
            @if ($filterRoleName === 'dosen')
                <th scope="col" class="px-4 py-3">Anggota Komisi?</th>
            @endif
            <th scope="col" class="px-4 py-3 text-right">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($users as $user)
            <tr class="border-b dark:border-gray-700">
                <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->name }}</th>
                <td class="px-4 py-3">{{ $user->email }}</td>
                @if ($user->role == 'mahasiswa' && $user->mahasiswa)
                    <td class="px-4 py-3">{{ $user->mahasiswa->nim ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $user->mahasiswa->jurusan->nama ?? '-' }}</td>
                @elseif ($user->role == 'dosen' && $user->dosen)
                    <td class="px-4 py-3">{{ $user->dosen->nidn ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $user->dosen->jurusan->nama ?? '-' }}</td>
                @else
                    <td class="px-4 py-3">-</td>
                    <td class="px-4 py-3">-</td>
                @endif
                @if ($filterRoleName === 'dosen')
                    <td class="px-4 py-3">
                        @if($user->dosen && $user->dosen->is_komisi)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Ya</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Tidak</span>
                        @endif
                    </td>
                @endif
                <td class="px-4 py-3 text-right">
                    {{-- TOMBOL EDIT --}}
                    <a href="{{ route('bapendik.jurusan.edit', $jurusan->id) }}" class="inline-flex items-center text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 dark:bg-yellow-500 dark:hover:bg-yellow-600 focus:outline-none dark:focus:ring-yellow-800 transition-colors duration-150">
                        <svg class="w-3.5 h-3.5 mr-1 -ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                        Edit
                    </a>
                    {{-- TOMBOL HAPUS (dengan atribut untuk modal) --}}
                    <button type="button"
                            data-modal-target="deleteModal"
                            data-modal-toggle="deleteModal"
                            data-delete-url="{{ route('bapendik.jurusan.destroy', $jurusan->id) }}"
                            class="inline-flex items-center text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-red-500 dark:hover:bg-red-600 focus:outline-none dark:focus:ring-red-900 transition-colors duration-150">
                        <svg class="w-3.5 h-3.5 mr-1 -ml-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        Hapus
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ $filterRoleName === 'dosen' ? 6 : 5 }}" class="px-4 py-3 text-center">Data {{ strtolower($roleName) }} tidak ditemukan.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
<nav class="p-4">
    {{-- Penting: appends SEMUA request query kecuali parameter halaman untuk tab LAIN --}}
    @php
        $queryParams = $request->query();
        if ($filterRoleName === 'mahasiswa') {
            unset($queryParams['dosen_page']);
        } else {
            unset($queryParams['mahasiswa_page']);
        }
    @endphp
    {{ $users->appends($queryParams)->links() }}
</nav>
