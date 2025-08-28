<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link
        title="Dashboard"
        href="{{ route('admin.dashboard') }}"
        :isActive="request()->routeIs('admin.dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>



    <div
        x-transition
        x-show="isSidebarOpen || isSidebarHovered"
        class="text-sm text-gray-500">
        Dummy Links
    </div>


    @role(['admin-provinsi', 'superAdmin'])
    <x-sidebar.dropdown
        title="Data Pengamal"
        :active="Str::startsWith(request()->route()->uri(), 'pengamal')">
        <x-slot name="icon">
            <x-heroicon-o-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
        <x-sidebar.sublink
            title="Data Pengamal"
            href="{{ route('pengamal.index') }}"
            :active="request()->routeIs('pengamal.index')" />
    </x-sidebar.dropdown>
    <x-sidebar.dropdown
        title="Posting"
        :active="Str::startsWith(request()->route()->uri(), 'post')">
        <x-slot name="icon">
            <!-- <x-heroicon-o-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" /> -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </x-slot>
        <x-sidebar.sublink
            title="Buat Postingan"
            href="{{ route('post.create') }}"
            :active="request()->routeIs('post.create')" />
        <x-sidebar.sublink
            title="Persetujuan Postingan"
            href="{{ route('post.approval') }}"
            :active="request()->routeIs('post.approval')" />
        <x-sidebar.sublink
            title="Postingan Disetujui"
            href="{{ route('post.approved') }}"
            :active="request()->routeIs('post.approved')" />
        <x-sidebar.sublink
            title="Postingan Ditolak"
            href="{{ route('post.rejected.after.approval') }}"
            :active="request()->routeIs('post.rejected.after.approval')" />

    </x-sidebar.dropdown>
    <x-sidebar.dropdown
        title="Pengaturan"
        :active="Str::startsWith(request()->route()->uri(), 'roles') || Str::startsWith(request()->route()->uri(), 'users') || Str::startsWith(request()->route()->uri(), 'wilayah')">
        <x-slot name="icon">
            <!-- <x-heroicon-o-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" /> -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </x-slot>
        <x-sidebar.sublink
            title="Role Management"
            href="{{ route('roles.index') }}"
            :active="request()->routeIs('roles.index')" />
        <x-sidebar.sublink
            title="User Management"
            href="{{ route('users.assign-role-index') }}"
            :active="request()->routeIs('users.assign-role-index')" />
        <x-sidebar.sublink
            title="Management Wilayah"
            href="{{ route('wilayah.index') }}"
            :active="request()->routeIs('wilayah.index')" />
    </x-sidebar.dropdown>
    @endrole
    @role (['admin-kabupaten', 'admin-kecamatan', 'admin-desa'])
    <x-sidebar.dropdown
        title="Posting"
        :active="Str::startsWith(request()->route()->uri(), 'post') || Str::startsWith(request()->route()->uri(), 'pengamal')">

        <x-slot name="icon">
            <x-heroicon-o-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" />

        </x-slot>

        {{-- Submenu untuk membuat postingan pengamal --}}
        <x-sidebar.sublink
            title="Tambah Pengamal"
            href="{{ route('pengamal.create') }}"
            :active="request()->routeIs('pengamal.create')" />

        {{-- Submenu untuk membuat postingan umum --}}
        <x-sidebar.sublink
            title="Posting Umum"
            href="{{ route('post.create') }}"
            :active="request()->routeIs('post.create')" />

    </x-sidebar.dropdown>
    @endrole
    @role(['Sekretaris-DPRW'])
    <x-sidebar.link
        title="Surat Keluar"
        href="{{ route('surat.index') }}"
        :isActive="request()->routeIs('surat.index')">
        <x-slot name="icon">
            <!-- <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" /> -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </x-slot>
    </x-sidebar.link>
    <x-sidebar.link
        title="Program Kerja"
        href="{{ route('program-kerja.index') }}"
        :isActive="request()->routeIs('program-kerja.index')">
        <x-slot name="icon">
            <!-- Ikon contoh (Clipboard List) -->
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 
                         2 0 012-2h2l1-2h4l1 2h2a2 2 0 012 
                         2v12a2 2 0 01-2 2z" />
            </svg>
        </x-slot>
    </x-sidebar.link>

    @endrole
































    <!-- @php
    $links = array_fill(0, 20, '');
    @endphp

    @foreach ($links as $index => $link)
    <x-sidebar.link title="Dummy link {{ $index + 1 }}" href="#" />
    @endforeach -->

</x-perfect-scrollbar>