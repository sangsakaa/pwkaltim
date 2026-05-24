<x-app-layout>

    @php
    /*
    |--------------------------------------------------------------------------
    | WILAYAH USER
    |--------------------------------------------------------------------------
    */
    $wilayah =
    $user->regency?->name ??
    $user->district?->name ??
    $user->village?->name ??
    $user->province?->name ??
    $user->code ??
    'Tidak diketahui';

    /*
    |--------------------------------------------------------------------------
    | GENDER
    |--------------------------------------------------------------------------
    */
    $male = (int) ($genderStat['L'] ?? 0);
    $female = (int) ($genderStat['P'] ?? 0);
    $totalPengamal = $male + $female;

    /*
    |--------------------------------------------------------------------------
    | CHART DATA
    |--------------------------------------------------------------------------
    */
    $chartLabels = collect($wilayahStat['labels'] ?? [])
    ->filter()
    ->values()
    ->toArray();

    $chartValues = collect($wilayahStat['values'] ?? [])
    ->map(fn($v) => (int) $v)
    ->values()
    ->toArray();

    $kabupatenStats = collect($kabupatenStats ?? [])
    ->map(fn($item) => (array) $item)
    ->values();

    $kabupatenLabels = $kabupatenStats
    ->pluck('label')
    ->filter()
    ->values()
    ->toArray();

    $kabupatenTotals = $kabupatenStats
    ->pluck('total')
    ->map(fn($v) => (int) $v)
    ->values()
    ->toArray();
    @endphp

    <x-slot name="header">
        @section('title', 'Dashboard - ' . $wilayah)

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            <div class="flex items-center gap-4">

                <div
                    class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center overflow-hidden shadow-sm">
                    <img
                        src="{{ asset('image/logo.png') }}"
                        alt="Logo"
                        class="w-10 h-10 object-contain">
                </div>

                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                        Dashboard
                    </h1>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        PW {{ $wilayah }}
                    </p>

                    <p class="text-xs text-gray-400">
                        Sistem Informasi Terpadu Pengamal Kalimantan Timur
                    </p>
                </div>
            </div>

            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>

        </div>
    </x-slot>

    <div class="py-6">
        <div class="space-y-6">

            {{-- HERO --}}
            <div
                class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-green-800 via-green-700 to-green-600 shadow-xl">

                <div class="absolute inset-0 opacity-10">
                    <div class="absolute -top-10 right-0 w-64 h-64 rounded-full bg-white"></div>
                </div>

                <div class="relative p-8 text-white">

                    <div class="flex flex-col lg:flex-row lg:justify-between gap-5">

                        <div>
                            <h2 class="text-2xl font-bold">
                                Selamat Datang, {{ $user->name }}
                            </h2>

                            <p class="mt-2 text-green-100">
                                Anda sedang mengakses dashboard wilayah
                                <span class="font-semibold">
                                    {{ $wilayah }}
                                </span>
                            </p>
                        </div>

                        <div
                            class="rounded-2xl border border-white/20 bg-white/10 px-5 py-4 backdrop-blur">

                            <p class="text-sm text-green-100">
                                Role Aktif
                            </p>

                            <p class="font-semibold">
                                {{ $user->roles->pluck('name')->implode(', ') }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>

            {{-- STAT CARD --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                <div
                    class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Total Pengamal
                    </p>

                    <h3 class="mt-2 text-4xl font-bold text-gray-800 dark:text-white">
                        {{ number_format($totalPengamal) }}
                    </h3>
                </div>

                <div
                    class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Laki-Laki
                    </p>

                    <h3 class="mt-2 text-4xl font-bold text-blue-600">
                        {{ number_format($male) }}
                    </h3>
                </div>

                <div
                    class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Perempuan
                    </p>

                    <h3 class="mt-2 text-4xl font-bold text-pink-600">
                        {{ number_format($female) }}
                    </h3>
                </div>

            </div>

            {{-- CHART --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                {{-- Statistik Wilayah --}}
                <div
                    class="xl:col-span-2 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                    <h2 class="mb-5 font-semibold text-gray-800 dark:text-white">
                        Statistik Wilayah
                    </h2>

                    <div class="relative h-[380px]">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                {{-- Kabupaten --}}
                <div
                    class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                    <h2 class="mb-5 font-semibold text-gray-800 dark:text-white">
                        Pengamal per Kabupaten
                    </h2>

                    <div class="relative h-[380px]">
                        <canvas id="kabupatenChart"></canvas>
                    </div>

                </div>

            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | Statistik Wilayah
            |--------------------------------------------------------------------------
            */
            const wilayahLabels = @json($chartLabels);
            const wilayahValues = @json($chartValues);

            const barCanvas = document.getElementById('barChart');

            if (barCanvas && wilayahLabels.length) {
                new Chart(barCanvas, {
                    type: 'bar',

                    data: {
                        labels: wilayahLabels,
                        datasets: [{
                            label: 'Jumlah Pengamal',
                            data: wilayahValues,
                            borderWidth: 1,
                            borderRadius: 12,
                            maxBarThickness: 42,
                            backgroundColor: 'rgba(59,130,246,.25)',
                            borderColor: 'rgb(37,99,235)'
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        },

                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },

                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }

            /*
            |--------------------------------------------------------------------------
            | Kabupaten
            |--------------------------------------------------------------------------
            */
            const kabupatenLabels = @json($kabupatenLabels);
            const kabupatenTotals = @json($kabupatenTotals);

            const kabupatenCanvas =
                document.getElementById('kabupatenChart');

            if (kabupatenCanvas && kabupatenLabels.length) {

                new Chart(kabupatenCanvas, {
                    type: 'bar',

                    data: {
                        labels: kabupatenLabels,

                        datasets: [{
                            label: 'Jumlah Pengamal',
                            data: kabupatenTotals,
                            borderWidth: 1,
                            borderRadius: 12,
                            maxBarThickness: 42,

                            backgroundColor: 'rgba(34,197,94,.25)',

                            borderColor: 'rgb(22,163,74)'
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        },

                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },

                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush

</x-app-layout>