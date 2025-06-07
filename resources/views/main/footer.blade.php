{{-- resources/views/main/footer.blade.php --}}
<footer class="p-4 bg-white dark:bg-gray-800 shadow-inner {{-- shadow-inner atau biarkan shadow biasa --}} md:px-6 md:py-6 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto {{-- Tambah mt-auto --}}">
    <div class="mx-auto max-w-screen-xl">
        <p class="text-sm text-center text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} <a href="{{ url('/') }}" class="hover:underline">{{ config('app.name', 'SIKAP FT Unsoed') }}</a>. Hak Cipta Dilindungi.
        </p>
    </div>
</footer>
