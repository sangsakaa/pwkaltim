<x-app-layout>
    <x-slot name="header">
        @php
        $user = auth()->user();
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

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-10 h-10 sm:w-12 sm:h-12 object-contain">
                <div>
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-800 leading-tight">
                        Dashboard - <span class="text-green-700">PW {{ $wilayah }}</span>
                    </h2>
                    <p class="text-xs text-green-600 hidden sm:block">Selamat datang di dashboard PW {{ $wilayah }}</p>
                </div>
            </div>

            <div class="flex gap-2 items-center">
                <!-- Tombol aksi header (jika diperlukan) -->
                <!-- <a href="{{ route('surat-masuk.create') }}"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded shadow text-sm">
                    + Tambah Surat Masuk
                </a> -->
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-4">

        <!-- HEADER CARD -->
        <div class="space-y-4 p-4 sm:p-6">
            <!-- Header Card (ringkasan) -->
            <div class="bg-gradient-to-r from-green-800 to-green-700 text-white rounded-md shadow-md p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-12 h-12 sm:w-14 sm:h-14 object-contain">
                    <div>
                        <h3 class="uppercase text-base sm:text-lg font-semibold">PW {{ $wilayah }}</h3>
                        <p class="text-sm text-green-100 hidden sm:block">Selamat datang di dashboard PW {{ $wilayah }}</p>
                    </div>
                </div>
                <div class="text-sm text-green-100">
                    <!-- Contoh ringkasan kecil (bisa diganti dengan statistik) -->
                    <div class="flex gap-4">
                        <div class="flex flex-col">
                            <span class="font-semibold">Surat</span>
                            <span class="text-xs">Terbaru & Terkelola</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-semibold">Anggota</span>
                            <span class="text-xs">{{ now()->translatedFormat('l, d F Y') }}</span>
                        </div>
                    </div>
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
                <h1 class="text-xl font-bold text-center">DPRW PROVINSI KALIMANTAN TIMUR</h1>
                <p class="mt-2 text-gray-700 dark:text-gray-200 text-sm text-justify">
                    Anda memiliki akses terbatas untuk mengelola surat-menyurat dan dokumen wilayah.
                </p>
            </div>
            <!-- PROGRAM KERJA & BIAYA SECTION -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-6">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <h2 class="font-bold text-lg">Program Kerja</h2>
                    <p class="text-2xl">{{ $programKerja }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <h2 class="font-bold text-lg">Biaya Bulanan</h2>
                    <p class="text-2xl">Rp {{ number_format($biaya['bulanan'] ?? 0, 0, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <h2 class="font-bold text-lg">Biaya Triwulan</h2>
                    <p class="text-2xl">Rp {{ number_format($biaya['triwulan'] ?? 0, 0, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <h2 class="font-bold text-lg">Biaya Semester</h2>
                    <p class="text-2xl">Rp {{ number_format($biaya['semester'] ?? 0, 0, ',', '.') }}</p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                    <h2 class="font-bold text-lg">Biaya Tahunan</h2>
                    <p class="text-2xl">Rp {{ number_format($biaya['tahunan'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- SURAT SECTION -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <!-- Surat Masuk -->
                <div class="bg-purple-50 p-6 rounded-xl shadow-md">
                    <h2 class="text-lg font-semibold text-purple-800">📨 Surat Masuk</h2>
                    <p class="text-gray-600 text-sm mt-1">Kelola daftar surat masuk wilayah Anda.</p>
                    <a href="{{ route('surat-masuk.index') }}"
                        class="mt-3 inline-block bg-purple-600 text-white px-4 py-2 rounded-md text-sm hover:bg-purple-700">
                        Lihat Surat Masuk
                    </a>
                </div>

                <!-- Surat Keluar -->
                <div class="bg-purple-50 p-6 rounded-xl shadow-md">
                    <h2 class="text-lg font-semibold text-purple-800">📤 Surat Keluar</h2>
                    <p class="text-gray-600 text-sm mt-1">Kelola surat keluar dan dokumen resmi.</p>
                    <a href="{{ route('surat.index') }}"
                        class="mt-3 inline-block bg-purple-600 text-white px-4 py-2 rounded-md text-sm hover:bg-purple-700">
                        Lihat Surat Keluar
                    </a>
                </div>
            </div>

            <!-- COUNTER SECTION -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <!-- Total Surat Masuk -->
                <div class="bg-white p-6 rounded-xl shadow-md border border-purple-200">
                    <h3 class="text-lg font-semibold text-gray-700">Total Surat Masuk</h3>
                    <p class="text-3xl font-bold text-purple-700 mt-2">
                        {{ $totalSuratMasuk }}
                    </p>
                </div>

                <!-- Total Surat Keluar -->
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