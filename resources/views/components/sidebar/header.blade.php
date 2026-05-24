<div class="flex items-center justify-between flex-shrink-0 px-3">

    {{-- LOGO --}}
    <a href="{{ route('admin.dashboard') }}"
        class="inline-flex items-center gap-2">

        <x-application-logo class="w-10 h-auto" />

        <span class="sr-only">Dashboard</span>
    </a>

    {{-- TOGGLE BUTTON --}}
    <x-button
        type="button"
        icon-only
        sr-text="Toggle sidebar"
        variant="secondary"
        x-on:click="isSidebarOpen = !isSidebarOpen">

        {{-- ICON COLLAPSED --}}
        <x-icons.menu-fold-right
            x-show="!isSidebarOpen"
            class="w-6 h-6"
            aria-hidden="true" />

        {{-- ICON OPEN --}}
        <x-icons.menu-fold-left
            x-show="isSidebarOpen"
            class="w-6 h-6"
            aria-hidden="true" />

        {{-- MOBILE CLOSE ICON --}}
        <x-heroicon-o-x-mark
            x-show="!isSidebarOpen && isMobile"
            class="w-6 h-6"
            aria-hidden="true" />

    </x-button>

</div>