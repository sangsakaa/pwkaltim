<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link
        title="Dashboard"
        href="{{ route('dashboard') }}"
        :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.dropdown
        title="Data Pengamal"
        :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
        <x-sidebar.sublink
            title="Data Pengamal"
            href="{{ route('pengamal.index') }}"
            :active="request()->routeIs('pengamal.index')" />
    </x-sidebar.dropdown>
    @role(['admin-provinsi', 'superAdmin'])
    <x-sidebar.dropdown
        title="Pengaturan"
        :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
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








































    <!-- bawaan -->
    <!-- <x-sidebar.dropdown
        title="Buttons"
        :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink
            title="Text button"
            href="{{ route('buttons.text') }}"
            :active="request()->routeIs('buttons.text')" />
        <x-sidebar.sublink
            title="Icon button"
            href="{{ route('buttons.icon') }}"
            :active="request()->routeIs('buttons.icon')" />
        <x-sidebar.sublink
            title="Text with icon"
            href="{{ route('buttons.text-icon') }}"
            :active="request()->routeIs('buttons.text-icon')" />
    </x-sidebar.dropdown> -->

    <!-- <div
        x-transition
        x-show="isSidebarOpen || isSidebarHovered"
        class="text-sm text-gray-500">
        Dummy Links
    </div> -->

    <!-- @php
        $links = array_fill(0, 20, '');
    @endphp

    @foreach ($links as $index => $link)
        <x-sidebar.link title="Dummy link {{ $index + 1 }}" href="#" />
    @endforeach -->

</x-perfect-scrollbar>