<x-perfect-scrollbar as="nav" class="flex flex-col flex-1 gap-4 px-3">

    {{-- ================= DASHBOARD (HANYA USER BERLOGIN + PUNYA ROLE) ================= --}}
    @auth
    @if(auth()->user()->roles->isNotEmpty())
    <x-sidebar.link
        title="Dashboard"
        href="{{ route('admin.dashboard') }}"
        :isActive="request()->routeIs('admin.dashboard')">

        <x-slot name="icon">
            <x-icons.dashboard class="w-6 h-6" />
        </x-slot>
    </x-sidebar.link>
    @endif
    @endauth


    {{-- ================= GUEST / USER PUBLIK ================= --}}
    @guest
    <div class="px-3 pt-2 text-xs font-semibold tracking-wider text-gray-400 uppercase">
        Menu Pengguna
    </div>

    <x-sidebar.link
        title="Reservasi Saya"
        href="{{ route('reservations.create') }}"
        :isActive="request()->routeIs('reservations.*')">

        <x-slot name="icon">
            <x-heroicon-o-qr-code class="w-6 h-6" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.link
        title="Cek Reservasi"
        href="{{ route('reservasi.lookup') }}"
        :isActive="request()->routeIs('reservasi.*')">

        <x-slot name="icon">
            <x-heroicon-o-magnifying-glass class="w-6 h-6" />
        </x-slot>
    </x-sidebar.link>
    @endguest


    {{-- ================= ADMIN PROVINSI ================= --}}
    @hasanyrole('admin-provinsi|superAdmin')

    <div class="px-3 pt-2 text-xs font-semibold tracking-wider text-gray-400 uppercase">
        Admin Provinsi
    </div>

    <x-sidebar.dropdown title="Data Pengamal" :active="request()->routeIs('pengamal.*')">
        <x-slot name="icon">
            <x-heroicon-o-users class="w-6 h-6" />
        </x-slot>

        <x-sidebar.sublink title="Data Pengamal" href="{{ route('pengamal.index') }}" />
        <x-sidebar.sublink title="Laporan File" href="{{ route('laporan-file.index') }}" />
        <x-sidebar.sublink title="Rekap Kabupaten" href="{{ route('laporan.rekap-kabupaten') }}" />
        <x-sidebar.sublink title="Wilayah Kosong" href="{{ route('laporan.wilayah-kosong') }}" />
    </x-sidebar.dropdown>

    <x-sidebar.dropdown title="Reservasi (Admin)" :active="request()->routeIs('admin.reservasi.*')">
        <x-slot name="icon">
            <x-heroicon-o-qr-code class="w-6 h-6" />
        </x-slot>

        <x-sidebar.sublink title="Dashboard" href="{{ route('admin.reservasi.dashboard') }}" />
        <x-sidebar.sublink title="Data Semua" href="{{ route('admin.reservasi.data') }}" />
        <x-sidebar.sublink title="Sudah Check-in" href="{{ route('admin.reservasi.checked-in') }}" />
        <x-sidebar.sublink title="Belum Check-in" href="{{ route('admin.reservasi.pending') }}" />
    </x-sidebar.dropdown>

    @endhasanyrole


    {{-- ================= ADMIN WILAYAH ================= --}}
    @hasanyrole('admin-kabupaten|admin-kecamatan|admin-desa')

    <x-sidebar.dropdown title="Pengamal Wilayah" :active="request()->routeIs('pengamal.*')">
        <x-slot name="icon">
            <x-heroicon-o-users class="w-6 h-6" />
        </x-slot>

        <x-sidebar.sublink title="Data Pengamal" href="{{ route('pengamal.index') }}" />
        <x-sidebar.sublink title="Posting" href="{{ route('post.create') }}" />
    </x-sidebar.dropdown>

    @endhasanyrole


    {{-- ================= SEKRETARIS ================= --}}
    @role('Sekretaris-DPRW')

    <div class="px-3 pt-2 text-xs font-semibold tracking-wider text-gray-400 uppercase">
        Administrasi Surat
    </div>

    <x-sidebar.link title="Surat Masuk" href="{{ route('surat-masuk.index') }}">
        <x-slot name="icon"><x-heroicon-o-inbox class="w-5 h-5" /></x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Surat Keluar" href="{{ route('surat.index') }}">
        <x-slot name="icon"><x-heroicon-o-paper-airplane class="w-5 h-5" /></x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Surat Tugas" href="{{ route('surat-tugas.index') }}">
        <x-slot name="icon"><x-heroicon-o-clipboard-document-check class="w-5 h-5" /></x-slot>
    </x-sidebar.link>

    <x-sidebar.link title="Program Kerja" href="{{ route('program-kerja.index') }}">
        <x-slot name="icon"><x-heroicon-o-briefcase class="w-5 h-5" /></x-slot>
    </x-sidebar.link>

    @endrole

</x-perfect-scrollbar>