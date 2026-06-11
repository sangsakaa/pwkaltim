<x-perfect-scrollbar
    as="nav"
    class="flex flex-col flex-1 gap-3 px-3 py-4 bg-white">

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
            <x-icons.dashboard class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>

    @endif
    @endauth


    {{-- =======================================================
    GUEST / PENGGUNA PUBLIK
    ======================================================== --}}
    @guest

    <div class="px-3 pt-3 text-xs font-bold tracking-wider text-green-700 uppercase">
        Menu Pengguna
    </div>

    <x-sidebar.link
        title="Reservasi Saya"
        href="{{ route('reservasi.create') }}"
        :isActive="request()->routeIs('reservasi.*')">

        <x-slot name="icon">
            <x-heroicon-o-qr-code class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link
        title="Cek Reservasi"
        href="{{ route('reservasi.lookup') }}"
        :isActive="request()->routeIs('reservasi.*')">

        <x-slot name="icon">
            <x-heroicon-o-magnifying-glass class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>

    @endguest


    {{-- =======================================================
    ADMIN PROVINSI / SUPER ADMIN
    ======================================================== --}}
    @hasanyrole('admin-provinsi|superAdmin')

    <div class="px-3 pt-4 text-xs font-bold tracking-wider text-green-700 uppercase">
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
            <x-heroicon-o-users class="w-5 h-5" />
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
            <x-heroicon-o-user-group class="w-5 h-5" />
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
            <x-heroicon-o-qr-code class="w-5 h-5" />
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
            title="Sudah Check-in"
            href="{{ route('admin.reservasi.checked-in') }}"
            :active="request()->routeIs('admin.reservasi.checked-in')" />

        <x-sidebar.sublink
            title="Belum Check-in"
            href="{{ route('admin.reservasi.pending') }}"
            :active="request()->routeIs('admin.reservasi.pending')" />

    </x-sidebar.dropdown>

    @endhasanyrole


    {{-- =======================================================
    ADMIN WILAYAH
    ======================================================== --}}
    @hasanyrole('admin-kabupaten|admin-kecamatan|admin-desa')

    <div class="px-3 pt-4 text-xs font-bold tracking-wider text-green-700 uppercase">
        Pengamal Wilayah
    </div>

    <x-sidebar.dropdown
        title="Pengamal Wilayah"
        :active="
            request()->routeIs('pengamal.*') ||
            request()->routeIs('post.*')
        ">

        <x-slot name="icon">
            <x-heroicon-o-users class="w-5 h-5" />
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


    @role('Sekretaris-DPRW')

    {{-- ============================
    ADMINISTRASI SURAT
============================ --}}
    <div
        x-data="{ open: {{ request()->routeIs('surat.*') || request()->routeIs('surat-masuk.*') || request()->routeIs('surat-tugas.*') ? 'true' : 'false' }} }"
        class="mb-2">

        <button
            @click="open = !open"
            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition">

            <div class="flex items-center gap-2">
                <x-heroicon-o-folder class="w-5 h-5 text-gray-600" />
                <span>Administrasi Surat</span>
            </div>

            <svg
                class="w-4 h-4 text-gray-500 transition-transform duration-200"
                :class="{ 'rotate-180': open }"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div
            x-show="open"
            x-transition
            class="mt-1 ml-6 pl-2 border-l border-gray-200 space-y-1">

            <x-sidebar.link
                title="Surat Masuk"
                href="{{ route('surat-masuk.index') }}"
                :isActive="request()->routeIs('surat-masuk.*')">

                <x-slot name="icon">
                    <x-heroicon-o-inbox class="w-4 h-4" />
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Surat Keluar"
                href="{{ route('surat.index') }}"
                :isActive="request()->routeIs('surat.*')">

                <x-slot name="icon">
                    <x-heroicon-o-paper-airplane class="w-4 h-4" />
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Surat Tugas"
                href="{{ route('surat-tugas.index') }}"
                :isActive="request()->routeIs('surat-tugas.*')">

                <x-slot name="icon">
                    <x-heroicon-o-clipboard-document-check class="w-4 h-4" />
                </x-slot>
            </x-sidebar.link>

        </div>
    </div>

    {{-- ============================
    PROGRAM KERJA
============================ --}}
    <div
        x-data="{ open: {{ request()->routeIs('program-kerja.*') ? 'true' : 'false' }} }">

        <button
            @click="open = !open"
            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition">

            <div class="flex items-center gap-2">
                <x-heroicon-o-briefcase class="w-5 h-5 text-gray-600" />
                <span>Program Kerja</span>
            </div>

            <svg
                class="w-4 h-4 text-gray-500 transition-transform duration-200"
                :class="{ 'rotate-180': open }"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div
            x-show="open"
            x-transition
            class="mt-1 ml-6 pl-2 border-l border-gray-200 space-y-1">

            <x-sidebar.link
                title="Daftar Program"
                href="{{ route('program-kerja.index') }}"
                :isActive="request()->routeIs('program-kerja.index')">

                <x-slot name="icon">
                    <x-heroicon-o-list-bullet class="w-4 h-4" />
                </x-slot>
            </x-sidebar.link>

            <x-sidebar.link
                title="Realisasi Program"
                href="{{ route('program-kerja.realisasi.index') }}"
                :isActive="request()->routeIs('program-kerja.realisasi.*')">

                <x-slot name="icon">
                    <x-heroicon-o-chart-bar class="w-4 h-4" />
                </x-slot>
            </x-sidebar.link>

        </div>
    </div>
    <div
        x-data="{ open: {{ request()->routeIs('periode-tahunan.*') ? 'true' : 'false' }} }">

        <button
            @click="open = !open"
            class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition">

            <div class="flex items-center gap-2">
                <x-heroicon-o-calendar-days class="w-5 h-5 text-gray-600" />
                <span>Periode Tahunan</span>
            </div>

            <svg
                class="w-4 h-4 text-gray-500 transition-transform duration-200"
                :class="{ 'rotate-180': open }"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div
            x-show="open"
            x-transition
            class="mt-1 ml-6 pl-2 border-l border-gray-200 space-y-1">

            <x-sidebar.link
                title="Periode Tahunan"
                href="{{ route('periode-tahunan.index') }}"
                :isActive="request()->routeIs('periode-tahunan.index')">

                <x-slot name="icon">
                    <x-heroicon-o-calendar class="w-4 h-4" />
                </x-slot>
            </x-sidebar.link>



        </div>
    </div>

    @endrole

</x-perfect-scrollbar>