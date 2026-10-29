<x-perfect-scrollbar
    as="nav"
    aria-label="Menu utama"
    class="flex h-full min-h-0 w-full flex-1 flex-col gap-2 overflow-x-hidden overflow-y-auto overscroll-contain bg-white px-3 py-4 text-gray-700 dark:bg-dark-eval-1 dark:text-gray-200">

    {{-- =======================================================
        DASHBOARD
    ======================================================== --}}
    @auth
    @if(auth()->user()->roles->isNotEmpty())
    <x-sidebar.link
        title="Dashboard"
        href="{{ route('admin.dashboard') }}"
        :isActive="request()->routeIs('admin.dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="h-5 w-5 shrink-0" />
        </x-slot>
    </x-sidebar.link>
    @endif
    @endauth


    {{-- =======================================================
        MENU PENGGUNA PUBLIK
    ======================================================== --}}
    @guest
    <div class="px-3 pb-1 pt-3 text-xs font-bold uppercase tracking-wider text-green-700 dark:text-green-400">
        Menu Pengguna
    </div>

    <x-sidebar.link
        title="Reservasi Saya"
        href="{{ route('reservasi.create') }}"
        :isActive="request()->routeIs('reservasi.create')">
        <x-slot name="icon">
            <x-heroicon-o-qr-code class="h-5 w-5 shrink-0" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link
        title="Cek Reservasi"
        href="{{ route('reservasi.lookup') }}"
        :isActive="request()->routeIs('reservasi.lookup')">
        <x-slot name="icon">
            <x-heroicon-o-magnifying-glass class="h-5 w-5 shrink-0" />
        </x-slot>
    </x-sidebar.link>
    @endguest


    {{-- =======================================================
        ADMIN PROVINSI / SUPER ADMIN
    ======================================================== --}}
    @hasanyrole('admin-provinsi|superAdmin')

    <div class="px-3 pb-1 pt-4 text-xs font-bold uppercase tracking-wider text-green-700 dark:text-green-400">
        Admin Provinsi
    </div>

    {{-- DATA PENGAMAL --}}
    <x-sidebar.dropdown
        title="Data Pengamal"
        :active="
                request()->routeIs('pengamal.*') ||
                request()->routeIs('laporan-file.*') ||
                request()->routeIs('laporan.*')
            ">
        <x-slot name="icon">
            <x-heroicon-o-users class="h-5 w-5 shrink-0" />
        </x-slot>

        <x-sidebar.sublink
            title="Data Pengamal"
            href="{{ route('pengamal.index') }}"
            :active="request()->routeIs('pengamal.*')" />

        <x-sidebar.sublink
            title="Laporan File"
            href="{{ route('laporan-file.index') }}"
            :active="request()->routeIs('laporan-file.*')" />

        <x-sidebar.sublink
            title="Rekap Kabupaten"
            href="{{ route('laporan.rekap-kabupaten') }}"
            :active="request()->routeIs('laporan.rekap-kabupaten')" />

        <x-sidebar.sublink
            title="Wilayah Kosong"
            href="{{ route('laporan.wilayah-kosong') }}"
            :active="request()->routeIs('laporan.wilayah-kosong')" />
    </x-sidebar.dropdown>


    {{-- MANAJEMEN USER --}}
    <x-sidebar.dropdown
        title="Manajemen User"
        :active="
                request()->routeIs('users.*') ||
                request()->routeIs('roles.*')
            ">
        <x-slot name="icon">
            <x-heroicon-o-user-group class="h-5 w-5 shrink-0" />
        </x-slot>

        <x-sidebar.sublink
            title="Data User"
            href="{{ route('users.assign-role-index') }}"
            :active="request()->routeIs('users.assign-role-index')" />

        <x-sidebar.sublink
            title="Tambah User"
            href="{{ route('users.create') }}"
            :active="request()->routeIs('users.create')" />

        <x-sidebar.sublink
            title="Role & Permission"
            href="{{ route('roles.index') }}"
            :active="request()->routeIs('roles.*')" />
    </x-sidebar.dropdown>


    {{-- RESERVASI ADMIN --}}
    <x-sidebar.dropdown
        title="Reservasi (Admin)"
        :active="request()->routeIs('admin.reservasi.*')">
        <x-slot name="icon">
            <x-heroicon-o-qr-code class="h-5 w-5 shrink-0" />
        </x-slot>

        <x-sidebar.sublink
            title="Dashboard"
            href="{{ route('admin.reservasi.dashboard') }}"
            :active="request()->routeIs('admin.reservasi.dashboard')" />

        <x-sidebar.sublink
            title="Data Semua"
            href="{{ route('admin.reservasi.data') }}"
            :active="request()->routeIs('admin.reservasi.data')" />



        <x-sidebar.sublink
            title="Download PDF"
            href="{{ route('admin.reservasi.pdf') }}"
            :active="request()->routeIs('admin.reservasi.pdf')" />
    </x-sidebar.dropdown>

    @endhasanyrole


    {{-- =======================================================
        ADMIN WILAYAH
    ======================================================== --}}
    @hasanyrole('admin-kabupaten|admin-kecamatan|admin-desa')

    <div class="px-3 pb-1 pt-4 text-xs font-bold uppercase tracking-wider text-green-700 dark:text-green-400">
        Pengamal Wilayah
    </div>

    <x-sidebar.dropdown
        title="Pengamal Wilayah"
        :active="
                request()->routeIs('pengamal.*') ||
                request()->routeIs('post.*')
            ">
        <x-slot name="icon">
            <x-heroicon-o-users class="h-5 w-5 shrink-0" />
        </x-slot>

        <x-sidebar.sublink
            title="Data Pengamal"
            href="{{ route('pengamal.index') }}"
            :active="request()->routeIs('pengamal.*')" />

        <x-sidebar.sublink
            title="Posting"
            href="{{ route('post.create') }}"
            :active="request()->routeIs('post.*')" />
    </x-sidebar.dropdown>

    @endhasanyrole


    {{-- =======================================================
        SEKRETARIS DPRW
    ======================================================== --}}
    @role('Sekretaris-DPRW')

    {{-- ADMINISTRASI SURAT --}}
    <div
        x-data="{ open: {{ request()->routeIs('surat.*') || request()->routeIs('surat-masuk.*') || request()->routeIs('surat-tugas.*') ? 'true' : 'false' }} }"
        class="mb-1 min-w-0">
        <button
            type="button"
            @click="open = !open"
            :aria-expanded="open.toString()"
            class="flex w-full min-w-0 items-center justify-between gap-2 rounded-lg px-3 py-2 text-left text-sm font-medium transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500 dark:hover:bg-gray-700">
            <span class="flex min-w-0 items-center gap-2">
                <x-heroicon-o-folder class="h-5 w-5 shrink-0 text-gray-500" />
                <span class="truncate">Administrasi Surat</span>
            </span>

            <svg
                class="h-4 w-4 shrink-0 text-gray-500 transition-transform duration-200"
                :class="{ 'rotate-180': open }"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div
            x-cloak
            x-show="open"
            x-transition
            class="ml-4 mt-1 space-y-1 border-l border-gray-200 pl-2 dark:border-gray-600">
            <x-sidebar.link
                title="Surat Masuk"
                href="{{ route('surat-masuk.index') }}"
                :isActive="request()->routeIs('surat-masuk.*')">
                <x-slot name="icon">
                    <x-heroicon-o-inbox class="h-4 w-4 shrink-0" />
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Surat Keluar"
                href="{{ route('surat.index') }}"
                :isActive="request()->routeIs('surat.*')">
                <x-slot name="icon">
                    <x-heroicon-o-paper-airplane class="h-4 w-4 shrink-0" />
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Surat Tugas"
                href="{{ route('surat-tugas.index') }}"
                :isActive="request()->routeIs('surat-tugas.*')">
                <x-slot name="icon">
                    <x-heroicon-o-clipboard-document-check class="h-4 w-4 shrink-0" />
                </x-slot>
            </x-sidebar.link>
        </div>
    </div>


    {{-- PROGRAM KERJA --}}
    <div
        x-data="{ open: {{ request()->routeIs('program-kerja.*') ? 'true' : 'false' }} }"
        class="mb-1 min-w-0">
        <button
            type="button"
            @click="open = !open"
            :aria-expanded="open.toString()"
            class="flex w-full min-w-0 items-center justify-between gap-2 rounded-lg px-3 py-2 text-left text-sm font-medium transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500 dark:hover:bg-gray-700">
            <span class="flex min-w-0 items-center gap-2">
                <x-heroicon-o-briefcase class="h-5 w-5 shrink-0 text-gray-500" />
                <span class="truncate">Program Kerja</span>
            </span>

            <svg
                class="h-4 w-4 shrink-0 text-gray-500 transition-transform duration-200"
                :class="{ 'rotate-180': open }"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div
            x-cloak
            x-show="open"
            x-transition
            class="ml-4 mt-1 space-y-1 border-l border-gray-200 pl-2 dark:border-gray-600">
            <x-sidebar.link
                title="Daftar Program"
                href="{{ route('program-kerja.index') }}"
                :isActive="request()->routeIs('program-kerja.index')">
                <x-slot name="icon">
                    <x-heroicon-o-list-bullet class="h-4 w-4 shrink-0" />
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Realisasi Program"
                href="{{ route('program-kerja.realisasi.index') }}"
                :isActive="request()->routeIs('program-kerja.realisasi.*')">
                <x-slot name="icon">
                    <x-heroicon-o-chart-bar class="h-4 w-4 shrink-0" />
                </x-slot>
            </x-sidebar.link>
        </div>
    </div>


    {{-- PERIODE TAHUNAN --}}
    <div
        x-data="{ open: {{ request()->routeIs('periode-tahunan.*') ? 'true' : 'false' }} }"
        class="mb-1 min-w-0">
        <button
            type="button"
            @click="open = !open"
            :aria-expanded="open.toString()"
            class="flex w-full min-w-0 items-center justify-between gap-2 rounded-lg px-3 py-2 text-left text-sm font-medium transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500 dark:hover:bg-gray-700">
            <span class="flex min-w-0 items-center gap-2">
                <x-heroicon-o-calendar-days class="h-5 w-5 shrink-0 text-gray-500" />
                <span class="truncate">Periode Tahunan</span>
            </span>

            <svg
                class="h-4 w-4 shrink-0 text-gray-500 transition-transform duration-200"
                :class="{ 'rotate-180': open }"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div
            x-cloak
            x-show="open"
            x-transition
            class="ml-4 mt-1 space-y-1 border-l border-gray-200 pl-2 dark:border-gray-600">
            <x-sidebar.link
                title="Periode Tahunan"
                href="{{ route('periode-tahunan.index') }}"
                :isActive="request()->routeIs('periode-tahunan.index')">
                <x-slot name="icon">
                    <x-heroicon-o-calendar class="h-4 w-4 shrink-0" />
                </x-slot>
            </x-sidebar.link>
        </div>
    </div>

    @endrole

</x-perfect-scrollbar>