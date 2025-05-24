<nav class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 fixed top-0 border-b w-full z-50">
    <div class="px-3 lg:pl-3 lg:px-5 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button class="hover:bg-gray-100 dark:hover:bg-gray-700 items-center p-2 rounded-lg dark:focus:ring-gray-600 dark:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 inline-flex sm:hidden text-gray-500 text-sm" type="button" aria-controls="logo-sidebar" data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar">
                    <span class="sr-only">Open sidebar</span>
                    <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
                <a class="flex md:me-24 ms-2" href="/">
                    <img alt="Logo" class="h-8 me-3" src="https://flowbite.com/docs/images/logo.svg">
                    <span class="whitespace-nowrap dark:text-white font-semibold self-center sm:text-2xl text-xl">SIKAP</span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button class="flex bg-gray-800 dark:focus:ring-gray-600 focus:ring-4 focus:ring-gray-300 rounded-full text-sm" type="button" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img alt="user photo" class="h-8 rounded-full w-8" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg">
                        </button>
                    </div>
                    <div class="bg-white z-50 dark:bg-gray-700 dark:divide-gray-600 divide-gray-100 divide-y hidden list-none my-4 rounded-sm shadow-sm text-base" id="dropdown-user">
                        <div class="py-3 px-4" role="none">
                            <p class="text-sm text-gray-900 dark:text-white" role="none">{{ auth()->user()->name }}</p>
                            <p class="text-sm dark:text-gray-300 font-medium text-gray-900 truncate" role="none">{{ auth()->user()->email }}</p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a class="hover:bg-gray-100 text-sm block dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-300 px-4 py-2 text-gray-700" href="#" role="menuitem">Profile</a>
                            </li>
                            <li>
                                <a class="hover:bg-gray-100 text-sm block dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-300 px-4 py-2 text-gray-700" href="#" role="menuitem">Settings</a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <a class="hover:bg-gray-100 text-sm block dark:hover:bg-gray-600 dark:hover:text-white dark:text-gray-300 px-4 py-2 text-gray-700" href="{{ route('logout') }}" role="menuitem" onclick='event.preventDefault(),this.closest("form").submit()'>Log out</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
