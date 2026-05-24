<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('image/logo.png') }}" type="image/x-icon">

    <title>@yield('title', 'Admin Panel')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <div
        x-data="mainState"
        :class="{ dark: isDarkMode }"
        x-on:resize.window="handleWindowResize"
        x-cloak>

        <div class="min-h-screen bg-gray-100 dark:bg-dark-eval-0 dark:text-gray-200 text-gray-900">

            {{-- SIDEBAR --}}
            <x-sidebar.sidebar />

            {{-- WRAPPER --}}
            <div
                class="flex flex-col min-h-screen transition-all duration-150"
                :class="{
                'lg:ml-64': isSidebarOpen,
                'md:ml-16': !isSidebarOpen
            }">

                {{-- NAVBAR --}}
                <x-navbar />

                {{-- HEADER --}}
                <header>
                    <div class="p-4 sm:p-6">
                        {{ $header ?? '' }}
                    </div>
                </header>

                {{-- CONTENT --}}
                <main class="px-4 sm:px-6 flex-1">
                    {{ $slot }}
                </main>

                {{-- FOOTER --}}
                <x-footer />

            </div>
        </div>
    </div>

</body>

</html>