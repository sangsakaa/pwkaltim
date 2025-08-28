<x-app-layout>
    <x-slot name="header">
        @php
        $wilayah = 'Tidak diketahui';
        if ($user->regency?->name) {
        $wilayah = Str::startsWith($user->regency->name, 'Kab.')
        ? 'Kabupaten ' . ltrim(substr($user->regency->name, 4))
        : $user->regency->name;
        } elseif ($user->district?->name) {
        $wilayah = 'Kec. ' . $user->district->name;
        } elseif ($user->village?->name) {
        $wilayah = $user->village->name;
        } elseif ($user->province?->name) {
        $wilayah = $user->province->name;
        }
        @endphp
        @section('title', 'PW ' . $wilayah)

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard  - ') }}<span class="text-green-700">{{ $wilayah }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-4">

        <!-- HEADER CARD -->
        <div class="bg-green-800 text-white rounded-md shadow flex items-center p-4">
            <img src="{{ asset('image/logo.png') }}" width="50" alt="Logo" class="mr-4">
            <div>
                <div class="uppercase text-lg font-bold">PW {{ $wilayah }}</div>
                <div class="text-sm">{{ now()->translatedFormat('l, d F Y') }}</div>
            </div>
        </div>

        <!-- ROLE BASED CONTENT -->
        @role(['admin-provinsi', 'superAdmin', 'admin-kabupaten'])
        <!-- ADMIN DASHBOARD -->
        <div class="bg-white dark:bg-gray-800 dark:text-white rounded-md shadow-md p-4">
            <h1 class="text-xl font-bold text-center">Dashboard Administrator</h1>
            <p class="mt-2 text-gray-700 dark:text-gray-200 text-sm text-justify">
                Anda memiliki akses penuh untuk mengelola data pengamal sesuai wilayah Anda.
            </p>
        </div>

        <!-- STATISTICS -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-lg font-semibold text-gray-800">Total Pengamal</h2>
                <p class="text-3xl font-bold text-blue-600 mt-2 flex items-center">
                    <x-heroicon-o-users class="w-6 h-6 mr-2" />
                    {{ ($jumlahByGender['L'] ?? 0) + ($jumlahByGender['P'] ?? 0) }}
                </p>
            </div>
            <div class="bg-blue-50 p-6 rounded-xl shadow-md">
                <h3 class="text-xl text-blue-700 font-semibold">Laki-Laki</h3>
                <p class="text-2xl mt-2 font-bold">{{ $jumlahByGender['L'] ?? 0 }}</p>
            </div>
            <div class="bg-pink-50 p-6 rounded-xl shadow-md">
                <h3 class="text-xl text-pink-700 font-semibold">Perempuan</h3>
                <p class="text-2xl mt-2 font-bold">{{ $jumlahByGender['P'] ?? 0 }}</p>
            </div>
        </div>

        <!-- CHART -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-md shadow-md p-4">
                <h2 class="text-xl font-semibold mb-2">Statistik Pengamal</h2>
                <div class="w-full max-w-md mx-auto">
                    <div class="aspect-[16/9]">
                        <canvas id="barChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-md shadow-md p-4">
                <h2 class="text-xl font-semibold mb-2">Info Lain</h2>
                <p class="text-sm text-gray-600">Ruang kosong untuk data tambahan.</p>
            </div>
        </div>
        @elserole('Sekretaris-DPRW')
        <!-- SEKRETARIS DASHBOARD -->
        <div class="bg-white dark:bg-gray-800 dark:text-white rounded-md shadow-md p-4">
            <h1 class="text-xl font-bold text-center">Dashboard Sekretaris DPRW</h1>
            <p class="mt-2 text-gray-700 dark:text-gray-200 text-sm text-justify">
                Anda memiliki akses terbatas untuk mengelola surat-menyurat dan dokumen wilayah.
            </p>
        </div>

        <!-- SURAT SECTION -->
        <!-- SURAT SECTION -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-purple-50 p-6 rounded-xl shadow-md">
                <h2 class="text-lg font-semibold text-purple-800">📨 Surat Masuk</h2>
                <p class="text-gray-600 text-sm mt-1">Kelola daftar surat masuk wilayah Anda.</p>
                <a href=""
                    class="mt-2 inline-block bg-purple-600 text-white px-4 py-2 rounded-md text-sm">Lihat Surat Masuk</a>
            </div>

            <div class="bg-purple-50 p-6 rounded-xl shadow-md">
                <h2 class="text-lg font-semibold text-purple-800">📤 Surat Keluar</h2>
                <p class="text-gray-600 text-sm mt-1">Kelola surat keluar dan dokumen resmi.</p>
                <a href="{{ route('surat.index') }}"
                    class="mt-2 inline-block bg-purple-600 text-white px-4 py-2 rounded-md text-sm">Lihat Surat Keluar</a>
            </div>

            <!-- COUNTER SURAT KELUAR -->
            <div class="bg-white p-6 rounded-xl shadow-md border border-purple-200">
                <h3 class="text-lg font-semibold text-gray-700">Total Surat Keluar</h3>
                <p class="text-3xl font-bold text-purple-700 mt-2">
                    {{ $totalSuratKeluar }}
                </p>
            </div>
        </div>

        @else
        <!-- DEFAULT -->
        <div class="bg-yellow-100 text-yellow-800 p-3 rounded">
            ⚠️ Peran Anda belum teridentifikasi. Hubungi administrator.
        </div>
        @endrole
    </div>
</x-app-layout>