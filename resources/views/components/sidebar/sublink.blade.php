@props([
'title' => '',
'active' => false,
'isActive' => false,
])

@php
$active = $active || $isActive;

$classes = $active
? 'bg-green-100 text-green-700 font-semibold border-l-4 border-green-600 shadow-sm dark:bg-green-900/30 dark:text-green-400'
: 'text-gray-500 hover:bg-green-50 hover:text-green-700 dark:text-gray-400 dark:hover:bg-green-900/20 dark:hover:text-green-400';

$classes .= '
flex items-center
w-full
px-4 py-2.5
rounded-xl
transition-all duration-200 ease-in-out
text-sm
overflow-hidden
';
@endphp

<li class="list-none my-1">
    <a {{ $attributes->merge(['class' => $classes]) }}>

        {{-- Dot Indicator --}}
        <span class="
            w-2 h-2 rounded-full mr-3 flex-shrink-0
            {{ $active ? 'bg-green-600' : 'bg-gray-300 dark:bg-gray-600' }}
        ">
        </span>

        <span class="truncate">
            {{ $title }}
        </span>
    </a>
</li>