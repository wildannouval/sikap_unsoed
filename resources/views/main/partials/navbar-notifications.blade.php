@auth
    @php
        $unreadNotifications = Auth::user()->unreadNotifications;
        $notifications = Auth::user()->notifications()->latest()->take(5)->get();
        $unreadCount = $unreadNotifications->count();
    @endphp

    <button type="button" data-dropdown-toggle="notification-dropdown"
            class="p-2 me-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 relative">
        <span class="sr-only">Lihat notifikasi</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
             viewBox="0 0 14 20">
            <path
                d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924c.538 0 .538-.6.538-1.193 0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z"/>
        </svg>
        @if($unreadCount > 0)
            <div
                class="absolute inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-1 -end-1 dark:border-gray-900">
                {{ $unreadCount }}
            </div>
        @endif
    </button>

    <div
        class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-white rounded-lg divide-y divide-gray-100 shadow-lg dark:bg-gray-700 dark:divide-gray-600"
        id="notification-dropdown">
        <div
            class="flex justify-between items-center py-2 px-4 text-base font-medium text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <span>Notifikasi</span>
            @if($unreadCount > 0)
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-blue-600 dark:text-blue-500 hover:underline">Tandai semua
                        dibaca
                    </button>
                </form>
            @endif
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-600">
            @forelse ($notifications as $notification)
                <a href="{{ route('notifications.show', $notification->id) }}"
                   class="flex py-3 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 {{ is_null($notification->read_at) ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                    <div class="pl-3 w-full">
                        <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                            {{ $notification->data['message'] ?? 'Anda memiliki notifikasi baru.' }}
                        </div>
                        <div class="text-xs font-medium text-blue-600 dark:text-blue-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @if(is_null($notification->read_at))
                        <div class="flex-shrink-0 flex items-center ms-4">
                            <div class="w-2.5 h-2.5 bg-blue-500 rounded-full" title="Belum dibaca"></div>
                        </div>
                    @endif
                </a>
            @empty
                <div class="py-3 px-4 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi.</p>
                </div>
            @endforelse
        </div>
        <a href="{{ route('notifications.index') }}"
           class="block py-2 text-sm font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
            <div class="inline-flex items-center ">
                <svg class="mr-2 w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                    <path fill-rule="evenodd"
                          d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                          clip-rule="evenodd"/>
                </svg>
                Lihat Semua Notifikasi
            </div>
        </a>
    </div>
@endauth
