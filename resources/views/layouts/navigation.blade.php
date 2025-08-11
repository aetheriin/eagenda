<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-6 w-auto"> <!-- Sesuaikan tinggi di sini -->
                    <span class="text-white text-sm font-semibold">E-Agenda BPS Dumai</span>
                </a>


                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">

                <!-- Dashboard -->
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>

                <!-- Master -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                        Master
                        <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute top-full left-0 mt-2 w-56 bg-white dark:bg-gray-800 shadow-lg rounded z-50">
                        <x-dropdown-link href="#">Klasifikasi Naskah Dinas</x-dropdown-link>
                        <x-dropdown-link :href="route('keamanan-surat.index')" :active="request()->routeIs('keamanan-surat.*')">
                            Keamanan/Akses Surat
                        </x-dropdown-link>
                        <x-dropdown-link href="#">Bagian/Fungsi</x-dropdown-link>
                        <x-dropdown-link href="#">Tim/Subtim Kerja</x-dropdown-link>
                    </div>
                </div>

                <!-- Naskah Keluar -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                        Naskah Keluar
                        <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute top-full left-0 mt-2 w-56 bg-white dark:bg-gray-800 shadow-lg rounded z-50">
                        <x-dropdown-link :href="route('memorandum-keluar.index')" :active="request()->routeIs('memorandum-keluar.*')">
                            Memorandum
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('belanja-keluar.index')" :active="request()->routeIs('belanja-keluar.*')">
                            Nota Dinas/KAK/Form Kerja
                        </x-dropdown-link>
                        <x-dropdown-link href="#">Surat Tugas</x-dropdown-link>
                        <x-dropdown-link href="#">Surat Dinas</x-dropdown-link>
                        <x-dropdown-link href="#">Undangan Internal</x-dropdown-link>
                        <x-dropdown-link href="#">Undangan Eksternal</x-dropdown-link>
                        <x-dropdown-link href="#">SOP</x-dropdown-link>
                    </div>
                </div>

                <!-- Naskah Masuk -->
                <x-nav-link :href="route('naskah-masuk.index')" :active="request()->routeIs('naskah-masuk.*')">
                    {{ __('Naskah Masuk') }}
                </x-nav-link>


                <!-- Laporan Agenda -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                        Laporan Agenda
                        <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute top-full left-0 mt-2 w-56 bg-white dark:bg-gray-800 shadow-lg rounded z-50">
                        <x-dropdown-link href="#">Naskah Dinas Keluar</x-dropdown-link>
                        <x-dropdown-link href="#">Naskah Dinas Masuk</x-dropdown-link>
                    </div>
                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
