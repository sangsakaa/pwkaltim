<nav
    aria-label="secondary"
    x-data="{ open: false }"
    class="sticky top-0 z-10 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white dark:bg-dark-eval-1"
    :class="{
        '-translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }">

    <div class="flex items-center gap-3">

        {{-- DARK MODE MOBILE --}}
        <x-button
            type="button"
            class="md:hidden"
            icon-only
            variant="secondary"
            sr-text="Toggle dark mode"
            x-on:click="toggleTheme">

            <x-heroicon-o-moon class="w-6 h-6" x-show="!isDarkMode" />
            <x-heroicon-o-sun class="w-6 h-6" x-show="isDarkMode" />
        </x-button>

    </div>

    <div class="flex items-center gap-3">

        {{-- DARK MODE DESKTOP --}}
        <x-button
            type="button"
            class="hidden md:inline-flex"
            icon-only
            variant="secondary"
            sr-text="Toggle dark mode"
            x-on:click="toggleTheme">

            <x-heroicon-o-moon class="w-6 h-6" x-show="!isDarkMode" />
            <x-heroicon-o-sun class="w-6 h-6" x-show="isDarkMode" />

        </x-button>

        {{-- ========================= --}}
        {{-- MODE LOGIN / ROLE --}}
        {{-- ========================= --}}
        @auth

        <x-dropdown align="right" width="56">

            <x-slot name="trigger">
                <button
                    class="flex items-center p-2 text-sm font-medium text-gray-500 rounded-md transition hover:text-gray-700 focus:outline-none">

                    <div class="text-left">

                        <div class="font-semibold">
                            {{ auth()->user()->name }}
                        </div>

                        <div class="text-xs text-gray-400">
                            {{ auth()->user()->getRoleNames()->first() ?? 'User' }}
                        </div>

                    </div>

                    <div class="ml-2">
                        <svg class="w-4 h-4 fill-current"
                            viewBox="0 0 20 20">

                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>

                </button>
            </x-slot>

            <x-slot name="content">

                {{-- ROLE MENU --}}
                @role('admin-provinsi')
                <div class="px-4 py-2 text-xs text-gray-500">
                    Admin Provinsi
                </div>
                @endrole

                @role('admin-kabupaten')
                <div class="px-4 py-2 text-xs text-gray-500">
                    Admin Kabupaten
                </div>
                @endrole

                @role('admin-kecamatan')
                <div class="px-4 py-2 text-xs text-gray-500">
                    Admin Kecamatan
                </div>
                @endrole

                @role('admin-desa')
                <div class="px-4 py-2 text-xs text-gray-500">
                    Admin Desa
                </div>
                @endrole

                <x-dropdown-link :href="route('profile.edit')">
                    Profile
                </x-dropdown-link>

                {{-- DASHBOARD SESUAI ROLE --}}
                @role('admin-provinsi')
                <x-dropdown-link :href="route('admin.dashboard')">
                    Dashboard
                </x-dropdown-link>
                @endrole

                @role('admin-kabupaten')
                <x-dropdown-link href="/dashboard">
                    Dashboard Kabupaten
                </x-dropdown-link>
                @endrole

                <form method="POST"
                    action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link
                        :href="route('logout')"
                        onclick="event.preventDefault();
                            this.closest('form').submit();">

                        Log Out

                    </x-dropdown-link>
                </form>

            </x-slot>

        </x-dropdown>

        @endauth

        {{-- ========================= --}}
        {{-- MODE PUBLIC --}}
        {{-- ========================= --}}
        @guest

        <div class="flex items-center gap-2">

            <a href="{{ route('login') }}"
                class="px-4 py-2 text-sm rounded-lg bg-green-600 text-white hover:bg-green-700">

                Login

            </a>

            @if(Route::has('register'))
            <a href="{{ route('register') }}"
                class="px-4 py-2 text-sm rounded-lg border border-gray-300 hover:bg-gray-100">

                Register

            </a>
            @endif

        </div>

        @endguest

    </div>
</nav>

{{-- MOBILE BOTTOM BAR --}}
<div
    class="fixed inset-x-0 bottom-0 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white md:hidden dark:bg-dark-eval-1"
    :class="{
        'translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }">

    {{-- PUBLIC --}}
    @guest

    <a href="/"
        class="text-sm font-semibold">
        Home
    </a>

    <a href="{{ route('pengamal.public.create') }}">
        <x-application-logo class="w-10 h-10" />
    </a>

    <a href="{{ route('login') }}"
        class="text-sm font-semibold">
        Login
    </a>

    @endguest

    {{-- LOGIN --}}
    @auth

    {{-- SEARCH --}}
    <x-button
        type="button"
        icon-only
        variant="secondary"
        sr-text="Search">

        <x-heroicon-o-magnifying-glass class="w-6 h-6" />
    </x-button>

    {{-- LOGO --}}
    <a href="{{ route('admin.dashboard') }}">
        <x-application-logo class="w-10 h-10" />
    </a>

    {{-- MENU --}}
    <x-button
        type="button"
        icon-only
        variant="secondary"
        sr-text="Open main menu"
        x-on:click="isSidebarOpen = !isSidebarOpen">

        <x-heroicon-o-bars-3 class="w-6 h-6"
            x-show="!isSidebarOpen" />

        <x-heroicon-o-x-mark class="w-6 h-6"
            x-show="isSidebarOpen" />

    </x-button>

    @endauth

</div>