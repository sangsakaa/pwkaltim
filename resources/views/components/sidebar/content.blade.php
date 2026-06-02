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
        href="{{ route('reservations.create') }}"
        :isActive="request()->routeIs('reservations.*')">

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


    {{-- =======================================================
    SEKRETARIS DPRW
    ======================================================== --}}
    @role('Sekretaris-DPRW')

    <div class="px-3 pt-4 text-xs font-bold tracking-wider text-green-700 uppercase">
        Administrasi Surat
    </div>

    <x-sidebar.link
        title="Surat Masuk"
        href="{{ route('surat-masuk.index') }}"
        :isActive="request()->routeIs('surat-masuk.*')">

        <x-slot name="icon">
            <x-heroicon-o-inbox class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link
        title="Surat Keluar"
        href="{{ route('surat.index') }}"
        :isActive="request()->routeIs('surat.*')">

        <x-slot name="icon">
            <x-heroicon-o-paper-airplane class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link
        title="Surat Tugas"
        href="{{ route('surat-tugas.index') }}"
        :isActive="request()->routeIs('surat-tugas.*')">

        <x-slot name="icon">
            <x-heroicon-o-clipboard-document-check class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link
        title="Program Kerja"
        href="{{ route('program-kerja.index') }}"
        :isActive="request()->routeIs('program-kerja.*')">

        <x-slot name="icon">
            <x-heroicon-o-briefcase class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>

    @endrole

</x-perfect-scrollbar>