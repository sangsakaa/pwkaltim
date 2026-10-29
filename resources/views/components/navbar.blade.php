{{-- NAVBAR ATAS --}}
<nav
    aria-label="Navigasi sekunder"
    x-data="{ open: false }"
    class="sticky top-0 z-30 flex items-center justify-between bg-white px-4 py-4 transition-transform duration-300 dark:bg-dark-eval-1 sm:px-6"
    :class="{
        '-translate-y-full': typeof scrollingDown !== 'undefined' && scrollingDown,
        'translate-y-0': typeof scrollingUp === 'undefined' || scrollingUp
    }">
    {{-- KIRI --}}
    <div class="flex items-center gap-3">

        {{-- DARK MODE MOBILE --}}
        <x-button
            type="button"
            class="md:hidden"
            icon-only
            variant="secondary"
            sr-text="Ganti tema"
            x-on:click="toggleTheme">
            <x-heroicon-o-moon
                class="h-6 w-6"
                x-show="!isDarkMode" />
            <x-heroicon-o-sun
                class="h-6 w-6"
                x-show="isDarkMode" />
        </x-button>

        {{-- LOGO MOBILE --}}
        <a href="{{ url('/') }}" class="flex items-center gap-2 md:hidden">
            <x-application-logo class="h-8 w-8" />
            <span class="text-sm font-bold text-gray-800 dark:text-white">
                {{ config('app.name', 'Aplikasi') }}
            </span>
        </a>

    </div>

    {{-- KANAN --}}
    <div class="flex items-center gap-3">

        {{-- DARK MODE DESKTOP --}}
        <x-button
            type="button"
            class="hidden md:inline-flex"
            icon-only
            variant="secondary"
            sr-text="Ganti tema"
            x-on:click="toggleTheme">
            <x-heroicon-o-moon
                class="h-6 w-6"
                x-show="!isDarkMode" />
            <x-heroicon-o-sun
                class="h-6 w-6"
                x-show="isDarkMode" />
        </x-button>

        {{-- JIKA SUDAH LOGIN --}}
        @auth
        <x-dropdown align="right" width="56">

            <x-slot name="trigger">
                <button
                    type="button"
                    class="flex items-center rounded-lg p-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500 dark:text-gray-200 dark:hover:bg-gray-700">
                    <div class="text-left">
                        <div class="font-semibold">
                            {{ auth()->user()->name }}
                        </div>

                        <div class="text-xs text-gray-400">
                            {{ auth()->user()->getRoleNames()->first() ?? 'User' }}
                        </div>
                    </div>

                    <svg
                        class="ml-2 h-4 w-4 fill-current"
                        viewBox="0 0 20 20"
                        aria-hidden="true">
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">

                {{-- LABEL ROLE --}}
                @role('admin-provinsi')
                <div class="px-4 py-2 text-xs font-semibold text-gray-500">
                    Admin Provinsi
                </div>
                @endrole

                @role('admin-kabupaten')
                <div class="px-4 py-2 text-xs font-semibold text-gray-500">
                    Admin Kabupaten
                </div>
                @endrole

                @role('admin-kecamatan')
                <div class="px-4 py-2 text-xs font-semibold text-gray-500">
                    Admin Kecamatan
                </div>
                @endrole

                @role('admin-desa')
                <div class="px-4 py-2 text-xs font-semibold text-gray-500">
                    Admin Desa
                </div>
                @endrole

                <x-dropdown-link :href="route('profile.edit')">
                    Profil Saya
                </x-dropdown-link>

                {{-- DASHBOARD BERDASARKAN ROLE --}}
                @if(auth()->user()->hasRole('admin-provinsi'))
                @if(Route::has('admin.dashboard'))
                <x-dropdown-link :href="route('admin.dashboard')">
                    Dashboard Provinsi
                </x-dropdown-link>
                @endif
                @elseif(auth()->user()->hasRole('admin-kabupaten'))
                <x-dropdown-link href="{{ url('/dashboard') }}">
                    Dashboard Kabupaten
                </x-dropdown-link>
                @elseif(auth()->user()->hasRole('admin-kecamatan'))
                <x-dropdown-link href="{{ url('/dashboard') }}">
                    Dashboard Kecamatan
                </x-dropdown-link>
                @elseif(auth()->user()->hasRole('admin-desa'))
                <x-dropdown-link href="{{ url('/dashboard') }}">
                    Dashboard Desa
                </x-dropdown-link>
                @elseif(Route::has('dashboard'))
                <x-dropdown-link :href="route('dashboard')">
                    Dashboard
                </x-dropdown-link>
                @endif

                <div class="my-1 border-t border-gray-200 dark:border-gray-600"></div>

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="block w-full px-4 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                        Keluar
                    </button>
                </form>

            </x-slot>
        </x-dropdown>
        @endauth

        {{-- JIKA BELUM LOGIN --}}
        @guest
        <div class="flex items-center gap-2">
            <a
                href="{{ route('login') }}"
                class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700">
                Login
            </a>

            @if(Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="hidden rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 sm:inline-flex dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                Register
            </a>
            @endif
        </div>
        @endguest

    </div>
</nav>


{{-- NAVIGASI BAWAH MOBILE --}}
<div
    x-data="{ mobileMenuOpen: false }"
    class="fixed inset-x-0 bottom-0 z-40 flex items-center justify-around border-t border-gray-200 bg-white px-4 py-3 transition-transform duration-300 dark:border-gray-700 dark:bg-dark-eval-1 md:hidden">
    {{-- PENGUNJUNG BELUM LOGIN --}}
    @guest
    <a
        href="{{ url('/') }}"
        class="text-sm font-semibold text-gray-700 hover:text-green-600 dark:text-gray-200">
        Home
    </a>

    <a href="{{ route('pengamal.public.create') }}"
        class="flex items-center justify-center"
        aria-label="Pendaftaran">
        <x-application-logo class="h-9 w-9" />
    </a>

    <a
        href="{{ route('login') }}"
        class="text-sm font-semibold text-green-700 hover:text-green-800 dark:text-green-400">
        Login
    </a>
    @endguest

    {{-- PENGGUNA SUDAH LOGIN --}}
    @auth
    {{-- BERANDA --}}
    <a
        href="{{ url('/dashboard') }}"
        class="flex flex-col items-center gap-1 text-xs font-medium text-gray-600 hover:text-green-600 dark:text-gray-200">
        <x-heroicon-o-home class="h-6 w-6" />
        <span>Beranda</span>
    </a>

    {{-- LOGO / BERANDA --}}
    <a
        href="{{ url('/dashboard') }}"
        class="flex items-center justify-center"
        aria-label="Dashboard">
        <x-application-logo class="h-9 w-9" />
    </a>

    {{-- MENU MOBILE --}}
    <button
        type="button"
        class="flex flex-col items-center gap-1 text-xs font-medium text-gray-600 hover:text-green-600 dark:text-gray-200"
        x-on:click="mobileMenuOpen = !mobileMenuOpen"
        :aria-expanded="mobileMenuOpen.toString()"
        aria-label="Buka menu">
        <x-heroicon-o-bars-3 class="h-6 w-6" x-show="!mobileMenuOpen" />
        <x-heroicon-o-x-mark class="h-6 w-6" x-show="mobileMenuOpen" />
        <span>Menu</span>
    </button>

    {{-- PANEL MENU MOBILE --}}
    <div
        x-cloak
        x-show="mobileMenuOpen"
        x-transition
        x-on:click.outside="mobileMenuOpen = false"
        class="absolute bottom-full right-4 mb-3 w-60 rounded-xl border border-gray-200 bg-white p-2 shadow-xl dark:border-gray-700 dark:bg-gray-800">
        <a
            href="{{ route('profile.edit') }}"
            class="block rounded-lg px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
            Profil Saya
        </a>

        @if(auth()->user()->hasRole('admin-provinsi') && Route::has('admin.dashboard'))
        <a
            href="{{ route('admin.dashboard') }}"
            class="block rounded-lg px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
            Dashboard Provinsi
        </a>
        @elseif(auth()->user()->hasRole('admin-kabupaten'))
        <a
            href="{{ url('/dashboard') }}"
            class="block rounded-lg px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
            Dashboard Kabupaten
        </a>
        @elseif(auth()->user()->hasRole('admin-kecamatan'))
        <a
            href="{{ url('/dashboard') }}"
            class="block rounded-lg px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
            Dashboard Kecamatan
        </a>
        @elseif(auth()->user()->hasRole('admin-desa'))
        <a
            href="{{ url('/dashboard') }}"
            class="block rounded-lg px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
            Dashboard Desa
        </a>
        @elseif(Route::has('dashboard'))
        <a
            href="{{ route('dashboard') }}"
            class="block rounded-lg px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
            Dashboard
        </a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="block w-full rounded-lg px-4 py-3 text-left text-sm text-red-600 hover:bg-red-50 dark:hover:bg-gray-700">
                Keluar
            </button>
        </form>
    </div>
    @endauth
</div>