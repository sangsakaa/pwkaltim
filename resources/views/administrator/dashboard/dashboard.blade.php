<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black"
                class="justify-center max-w-xs gap-2">
                <x-icons.github class="w-6 h-6" aria-hidden="true" />
                <span>Star on Github</span>
            </x-button>
        </div>
    </x-slot>

    <div class=" gap-2 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
        <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="  flex ">
                <div>
                    <img src="{{ asset('image/logofont.jpg') }}" width="200" alt="Logo">
                </div>
                <div class=" w-full flex items-center justify-center">
                    <marquee behavior="scroll" direction="left">
                        Selamat datang di website kami!
                    </marquee>
                </div>
            </div>
        </div>
    </div>
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="flex items-center justify-center">
            <h1 class="text-2xl font-bold">Selamat Datang di Dashboard Administrator</h1>
        </div>
        <div class="mt-4">
            <p class="text-gray-700">Ini adalah halaman dashboard untuk administrator. Anda dapat mengelola data pengamal
                dan melakukan berbagai tugas administratif lainnya.</p>
        </div>
    </div>
    <div class=" mt-2  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class=" grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 bg-blue-100 rounded-md shadow">
                <h2 class="text-lg font-semibold">Pengamal Terdaftar</h2>
                <p class="text-gray-600">Jumlah pengamal yang terdaftar di sistem: <span class="" style="font-size: large;">{{ $dataPengamal}}</span></p>
            </div>
            <div class="p-4 bg-green-100 rounded-md shadow">
                <h2 class="text-lg font-semibold">Aktivitas Terakhir</h2>
                <p class="text-gray-600">Aktivitas terakhir yang dilakukan oleh administrator.</p>
            </div>
            <div class="p-4 bg-yellow-100 rounded-md shadow">
                <h2 class="text-lg font-semibold">Statistik Pengguna</h2>
                <p class="text-gray-600">Statistik pengguna dan aktivitas mereka di sistem.</p>
            </div>
        </div>
</x-app-layout>