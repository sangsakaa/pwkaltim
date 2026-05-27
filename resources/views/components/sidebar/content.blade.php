<x-perfect-scrollbar as="nav" class="flex flex-col flex-1 gap-4 px-3">

    {{-- DASHBOARD --}}
    <x-sidebar.link
        title="Dashboard"
        href="{{ route('admin.dashboard') }}"
        :isActive="request()->routeIs('admin.dashboard')">

        <x-slot name="icon">
            <x-icons.dashboard class="w-6 h-6" />
        </x-slot>
    </x-sidebar.link>

    {{-- ================= ADMIN PROVINSI ================= --}}
    @hasanyrole('admin-provinsi|superAdmin')

    @php
    $pengamalActive = request()->routeIs('pengamal.*');
    $postActive = request()->routeIs('post.*');
    $settingActive = request()->routeIs('roles.*')
    || request()->routeIs('users.*')
    || request()->routeIs('wilayah.*');
    @endphp

    {{-- DATA PENGAMAL --}}
    <x-sidebar.dropdown
        title="Data Pengamal"
        :active="$pengamalActive">

        <x-slot name="icon">
            <x-heroicon-o-users class="w-6 h-6" />
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
            title="Laporan Per Kabupaten"
            href="{{ route('laporan.rekap-kabupaten') }}"
            :active="request()->routeIs('laporan.rekap-kabupaten.*')" />
    </x-sidebar.dropdown>

    {{-- POSTING --}}
    <x-sidebar.dropdown
        title="Posting"
        :active="$postActive">

        <x-slot name="icon">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </x-slot>

        <x-sidebar.sublink
            title="Buat Postingan"
            href="{{ route('post.create') }}"
            :active="request()->routeIs('post.create')" />

        <x-sidebar.sublink
            title="Approval"
            href="{{ route('post.approval') }}"
            :active="request()->routeIs('post.approval')" />
    </x-sidebar.dropdown>

    {{-- PENGATURAN --}}
    <x-sidebar.dropdown
        title="Pengaturan"
        :active="$settingActive">

        <x-slot name="icon">
            <x-heroicon-o-cog-6-tooth class="w-6 h-6" />
        </x-slot>

        <x-sidebar.sublink
            title="Role Management"
            href="{{ route('roles.index') }}"
            :active="request()->routeIs('roles.*')" />

        <x-sidebar.sublink
            title="User Management"
            href="{{ route('users.assign-role-index') }}"
            :active="request()->routeIs('users.*')" />

        <x-sidebar.sublink
            title="Wilayah"
            href="{{ route('wilayah.index') }}"
            :active="request()->routeIs('wilayah.*')" />
    </x-sidebar.dropdown>

    @endhasanyrole


    {{-- ================= ADMIN WILAYAH ================= --}}
    @hasanyrole('admin-kabupaten|admin-kecamatan|admin-desa')

    @php
    $user = auth()->user();

    $wilayahId =
    $user->regency_id ??
    $user->district_id ??
    $user->village_id;

    $wilayahActive = request()->routeIs('pengamal.*') || request()->routeIs('post.*');
    @endphp

    <x-sidebar.dropdown
        title="Pengamal Wilayah"
        :active="$wilayahActive">

        <x-slot name="icon">
            <x-heroicon-o-users class="w-6 h-6" />
        </x-slot>

        <x-sidebar.sublink
            title="Data Pengamal"
            href="{{ route('pengamal.index', ['wilayah' => $wilayahId]) }}"
            :active="request()->routeIs('pengamal.*')" />

        <x-sidebar.sublink
            title="Posting Umum"
            href="{{ route('post.create') }}"
            :active="request()->routeIs('post.create')" />

    </x-sidebar.dropdown>

    @endhasanyrole


    {{-- ================= SEKRETARIS ================= --}}
    @role('Sekretaris-DPRW')

    @php
    $suratActive = request()->routeIs('surat-masuk.*', 'surat.*', 'surat-tugas.*', 'program-kerja.*');
    @endphp

    {{-- GROUP HEADER (optional tapi bikin modern) --}}
    <div class="px-3 pt-2 text-xs font-semibold tracking-wider text-gray-400 uppercase">
        Administrasi Surat
    </div>

    {{-- SURAT MASUK --}}
    <x-sidebar.link
        title="Surat Masuk"
        href="{{ route('surat-masuk.index') }}"
        :isActive="request()->routeIs('surat-masuk.*')">

        <x-slot name="icon">
            <x-heroicon-o-inbox class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>

    {{-- SURAT KELUAR --}}
    <x-sidebar.link
        title="Surat Keluar"
        href="{{ route('surat.index') }}"
        :isActive="request()->routeIs('surat.index', 'surat.*')">

        <x-slot name="icon">
            <x-heroicon-o-paper-airplane class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>

    {{-- SURAT TUGAS --}}
    <x-sidebar.link
        title="Surat Tugas"
        href="{{ route('surat-tugas.index') }}"
        :isActive="request()->routeIs('surat-tugas.*')">

        <x-slot name="icon">
            <x-heroicon-o-clipboard-document-check class="w-5 h-5" />
        </x-slot>
    </x-sidebar.link>

    {{-- PROGRAM KERJA --}}
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