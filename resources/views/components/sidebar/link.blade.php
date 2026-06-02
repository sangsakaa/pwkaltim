@props([
'isActive' => false,
'title' => '',
'collapsible' => false
])

@php
$isActiveClasses = $isActive
? 'bg-green-600 text-white shadow-lg border-l-4 border-green-300'
: 'text-gray-600 hover:bg-green-50 hover:text-green-700 dark:text-gray-300 dark:hover:bg-green-900/20 dark:hover:text-green-400';

$classes = '
flex-shrink-0
flex items-center gap-3
px-3 py-3
rounded-xl
overflow-hidden
transition-all duration-300 ease-in-out
group
' . $isActiveClasses;

if ($collapsible) {
$classes .= ' w-full';
}
@endphp

@if ($collapsible)

<button
    type="button"
    {{ $attributes->merge(['class' => $classes]) }}>

    {{-- ICON --}}
    @if ($icon ?? false)
    <span class="flex-shrink-0 transition duration-200">
        {{ $icon }}
    </span>
    @else
    <x-icons.empty-circle
        class="flex-shrink-0 w-5 h-5"
        aria-hidden="true" />
    @endif

    {{-- TITLE --}}
    <span
        class="text-sm font-semibold whitespace-nowrap"
        x-show="isSidebarOpen || isSidebarHovered">

        {{ $title }}
    </span>

    {{-- COLLAPSE ICON --}}
    <span
        x-show="isSidebarOpen || isSidebarHovered"
        aria-hidden="true"
        class="relative block ml-auto w-5 h-5">

        <span
            :class="open ? '-rotate-45' : 'rotate-45'"
            class="absolute right-[8px] top-1/2 -translate-y-1/2 bg-current h-2.5 w-[2px] transition-all duration-200">
        </span>

        <span
            :class="open ? 'rotate-45' : '-rotate-45'"
            class="absolute left-[8px] top-1/2 -translate-y-1/2 bg-current h-2.5 w-[2px] transition-all duration-200">
        </span>
    </span>

</button>

@else

<a {{ $attributes->merge(['class' => $classes]) }}>

    {{-- ICON --}}
    @if ($icon ?? false)
    <span class="flex-shrink-0 transition duration-200">
        {{ $icon }}
    </span>
    @else
    <x-icons.empty-circle
        class="flex-shrink-0 w-5 h-5"
        aria-hidden="true" />
    @endif

    {{-- TITLE --}}
    <span
        class="text-sm font-semibold whitespace-nowrap"
        x-show="isSidebarOpen || isSidebarHovered">

        {{ $title }}
    </span>

</a>

@endif