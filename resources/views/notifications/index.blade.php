@extends('main.app')

@section('title', 'Semua Notifikasi')

@section('content')
    <section class="antialiased">
        <div class="mx-auto max-w-none px-4 lg:px-6 py-4">
            <div class="bg-white dark:bg-gray-800 relative shadow-xl sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Riwayat Notifikasi</h2>
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">Tandai semua dibaca</button>
                    </form>
                </div>

                <div class="px-4 pt-4">
                    @include('partials.session-messages')
                </div>

                <div class="overflow-x-auto">
                    @if($notifications->isEmpty())
                        <p class="p-6 text-center text-gray-500 dark:text-gray-400">Anda tidak memiliki riwayat notifikasi.</p>
                    @else
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($notifications as $notification)
                                <a href="{{ route('notifications.show', $notification->id) }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700
                            {{ is_null($notification->read_at) ? 'bg-blue-50 dark:bg-blue-900/20 font-bold' : 'font-normal' }}">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                {{-- Ganti dengan ikon dari data notifikasi jika ada --}}
                                                <i class="fa-solid {{ $notification->data['icon'] ?? 'fa-bell' }} text-blue-600 dark:text-blue-400 text-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $notification->data['message'] ?? 'Notifikasi Baru' }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        @if(is_null($notification->read_at))
                                            <div class="flex-shrink-0 flex items-center">
                                                <div class="w-2.5 h-2.5 bg-blue-500 rounded-full" title="Belum dibaca"></div>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if($notifications->hasPages())
                    <nav class="p-4" aria-label="Table navigation">
                        {{ $notifications->links() }}
                    </nav>
                @endif
            </div>
        </div>
    </section>
@endsection
