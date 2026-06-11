<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Panel')</title>

    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100" x-data="{ isSidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}
        <aside
            class="bg-green-900 text-white w-64 p-4 space-y-4
               transform transition-transform duration-200"
            :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0 md:w-20'">

            <div class="text-xl font-bold mb-6">
                ADMIN PANEL
            </div>

            <nav class="space-y-2">

                <a href="/admin/dashboard"
                    class="block p-2 rounded hover:bg-green-700">
                    Dashboard
                </a>

                <a href="/admin/users"
                    class="block p-2 rounded hover:bg-green-700">
                    Users
                </a>

                <a href="/admin/roles"
                    class="block p-2 rounded hover:bg-green-700">
                    Roles
                </a>

            </nav>
        </aside>

        {{-- MAIN --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- TOPBAR --}}
            <header class="bg-white shadow px-4 py-3 flex items-center justify-between">

                {{-- Toggle Sidebar --}}
                <button
                    class="text-gray-700"
                    @click="isSidebarOpen = !isSidebarOpen">

                    <x-heroicon-o-bars-3 class="w-6 h-6" />

                </button>

                <h1 class="text-lg font-semibold">
                    @yield('page-title')
                </h1>

                {{-- Right side (bisa search/user menu nanti) --}}
                <div>
                    d
                </div>

            </header>

            {{-- CONTENT --}}
            <main class="flex-1 p-6 overflow-y-auto">

                @yield('content')

            </main>

        </div>

    </div>

</body>

</html>