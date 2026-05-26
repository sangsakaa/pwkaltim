<x-app-layout>
    @section('title', 'Dashboard')

    @php
    $male = (int) ($genderStat['L'] ?? 0);
    $female = (int) ($genderStat['P'] ?? 0);
    $totalPengamal = $male + $female;

    $wilayahLabels = collect($wilayahStat['labels'] ?? [])->filter()->values()->toArray();
    $wilayahTotals = collect($wilayahStat['values'] ?? [])->map(fn($v) => (int)$v)->values()->toArray();

    $kabupatenCollection = collect($kabupatenStats ?? [])->map(fn($i) => (array) $i)->values();
    $kabupatenLabels = $kabupatenCollection->pluck('label')->filter()->values()->toArray();
    $kabupatenTotals = $kabupatenCollection->pluck('total')->map(fn($v) => (int)$v)->values()->toArray();

    $kategoriData = $kategoriStat ?? [];

    $roles = $user->roles->pluck('name')->implode(', ') ?: 'Tidak ada role';
    @endphp

    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-3xl border bg-emerald-800">
                    <img src="{{ asset('image/logo.png') }}" class="h-10 w-10 object-contain">
                </div>

                <div>
                    <h1 class="text-3xl font-bold">Dashboard</h1>

                    <div class="mt-2 flex gap-2">
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs">
                            PW {{ $wilayah ?? '-' }}
                        </span>
                        <span class="text-sm text-gray-500">
                            Sistem Informasi Pengamal Kaltim
                        </span>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border bg-white px-5 py-3">
                <p class="text-xs text-gray-400">Hari Ini</p>
                <p class="font-semibold">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 space-y-8">

        {{-- HERO --}}
        <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-emerald-950 via-green-800 to-green-600 p-8">

            <div class="relative z-10 flex flex-col lg:flex-row justify-between gap-6 text-white">

                <div>
                    <span class="bg-white/10 px-4 py-2 rounded-full text-sm">👋 Selamat Datang</span>
                    <h2 class="mt-5 text-4xl font-bold">{{ $user->name }}</h2>
                    <p class="mt-3 text-green-100">
                        Dashboard wilayah <b>{{ $wilayah ?? '-' }}</b>
                    </p>
                </div>

                <div class="rounded-2xl bg-white/10 p-6 backdrop-blur">
                    <p class="text-sm text-green-100">Role</p>
                    <h3 class="text-xl font-semibold">{{ $roles }}</h3>
                </div>
            </div>
        </section>

        {{-- CARDS --}}
        <section class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

            @php
            $cards = [
            ['title' => 'Total Pengamal', 'value' => number_format($totalPengamal), 'color' => 'text-gray-800', 'icon' => '👥'],
            ['title' => 'Laki-Laki', 'value' => number_format($male), 'color' => 'text-blue-600', 'icon' => '👨'],
            ['title' => 'Perempuan', 'value' => number_format($female), 'color' => 'text-pink-600', 'icon' => '👩'],
            ];
            @endphp

            @foreach ($cards as $card)
            <div class="rounded-2xl border bg-white p-6 shadow-sm">
                <p class="text-gray-500">{{ $card['title'] }}</p>
                <h3 class="mt-3 text-4xl font-bold {{ $card['color'] }}">{{ $card['value'] }}</h3>
                <div class="mt-4 text-2xl">{{ $card['icon'] }}</div>
            </div>
            @endforeach
        </section>

        {{-- CHART --}}
        <section class="grid xl:grid-cols-3 gap-6">

            <div class="xl:col-span-2 rounded-2xl border bg-white p-6">
                <h2 class="font-bold text-lg mb-4">Statistik Wilayah</h2>
                <div class="h-[400px]">
                    <canvas id="wilayahChart"></canvas>
                </div>
            </div>

            <div class="rounded-2xl border bg-white p-6">
                <h2 class="font-bold text-lg mb-4">Kabupaten</h2>
                <div class="h-[400px]">
                    <canvas id="kabupatenChart"></canvas>
                </div>
            </div>

        </section>

        {{-- CHART KATEGORI (FIX BARU) --}}
        <section class="rounded-2xl border bg-white p-6">
            <h2 class="font-bold text-lg mb-4">Kategori Usia</h2>
            <div class="h-[400px]">
                <canvas id="kategoriChart"></canvas>
            </div>
        </section>

    </div>

    {{-- SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const wilayahLabels = @json($wilayahLabels ?? []);
            const wilayahTotals = @json($wilayahTotals ?? []);

            const kabupatenLabels = @json($kabupatenLabels ?? []);
            const kabupatenTotals = @json($kabupatenTotals ?? []);

            const kategoriData = @json($kategoriData);

            // ================= WILAYAH =================
            if (wilayahLabels.length) {
                new Chart(document.getElementById('wilayahChart'), {
                    type: 'bar',
                    data: {
                        labels: wilayahLabels,
                        datasets: [{
                            label: 'Pengamal',
                            data: wilayahTotals,
                            backgroundColor: '#16a34a',
                            borderRadius: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // ================= KABUPATEN =================
            if (kabupatenLabels.length) {
                new Chart(document.getElementById('kabupatenChart'), {
                    type: 'doughnut',
                    data: {
                        labels: kabupatenLabels,
                        datasets: [{
                            data: kabupatenTotals,
                            backgroundColor: [
                                '#16a34a', '#2563eb', '#ec4899',
                                '#f59e0b', '#8b5cf6'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%'
                    }
                });
            }

            // ================= KATEGORI USIA =================
            if (Object.keys(kategoriData).length) {
                new Chart(document.getElementById('kategoriChart'), {
                    type: 'bar',
                    data: {
                        labels: Object.keys(kategoriData),
                        datasets: [{
                            label: 'Kategori Usia',
                            data: Object.values(kategoriData),
                            backgroundColor: '#10b981',
                            borderRadius: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

        });
    </script>

</x-app-layout>