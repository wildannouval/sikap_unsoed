@if (session('success'))
    <div class="p-4 mx-4 mt-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <span class="font-medium">Berhasil!</span> {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="p-4 mx-4 mt-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
        <span class="font-medium">Error!</span> {{ session('error') }}
    </div>
@endif

@if (session('info'))
    <div class="p-4 mx-4 mt-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
        <span class="font-medium">Info:</span> {{ session('info') }}
    </div>
@endif

@if (session('warning'))
    <div class="p-4 mx-4 mt-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400" role="alert">
        <span class="font-medium">Perhatian!</span> {{ session('warning') }}
    </div>
@endif

{{-- Untuk menampilkan error validasi dari variabel $errors --}}
@if ($errors->any())
    <div class="p-4 mx-4 mt-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
        <div class="font-medium">{{ __('Whoops! Ada yang salah dengan inputan Anda.') }}</div>
        <ul class="mt-1.5 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
