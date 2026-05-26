<x-app-layout>
    @section('title', 'Dashboard')

    @php
    $male = (int) ($genderStat['L'] ?? 0);
    $female = (int) ($genderStat['P'] ?? 0);
    $totalPengamal = $male + $female;

    $wilayahLabels = collect($wilayahStat['labels'] ?? [])->filter()->values()->toArray();
    $wilayahTotals = collect($wilayahStat['values'] ?? [])->map(fn($v) => (int)$v)->values()->toArray();

    $kabupatenCollection = collect($kabupatenStats ?? [])->map(fn($i) => (array) $i)->values();
    $kabupatenLabels = $kabupatenCollection->pluck('label')->toArray();
    $kabupatenTotals = $kabupatenCollection->pluck('total')->map(fn($v) => (int)$v)->toArray();

    $kategoriData = $kategoriStat ?? [];

    $roles = $user->roles->pluck('name')->implode(', ') ?: 'Tidak ada role';
    @endphp

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <p class="text-sm text-gray-500">Sistem Informasi Pengamal Kaltim</p>
            </div>

            <div class="text-right">
                <p class="font-semibold">{{ $user->name }}</p>
                <p class="text-xs text-gray-400">{{ now()->translatedFormat('d M Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 space-y-6">

        {{-- KPI CARDS --}}
        <section class="grid grid-cols-3 gap-4">
            @php
            $cards = [
            ['label' => 'Total', 'val' => $totalPengamal],
            ['label' => 'Laki-laki', 'val' => $male],
            ['label' => 'Perempuan', 'val' => $female],
            ];
            @endphp

            @foreach ($cards as $c)
            <div class="rounded-xl border bg-white p-4">
                <p class="text-xs text-gray-500">{{ $c['label'] }}</p>
                <h2 class="text-2xl font-bold text-emerald-600">
                    {{ number_format($c['val']) }}
                </h2>
            </div>
            @endforeach
        </section>

        {{-- CHART ROW 1 --}}
        <section class="grid grid-cols-3 gap-4">

            {{-- WILAYAH (BAR HORIZONTAL) --}}
            <div class="col-span-2 rounded-xl border bg-white p-4">
                <h2 class="text-sm font-semibold mb-2">Statistik Wilayah</h2>
                <div class="h-[300px]">
                    <canvas id="wilayahChart"></canvas>
                </div>
            </div>

            {{-- KABUPATEN (DOUGHNUT) --}}
            <div class="rounded-xl border bg-white p-4">
                <h2 class="text-sm font-semibold mb-2">Kabupaten</h2>
                <div class="h-[300px]">
                    <canvas id="kabupatenChart"></canvas>
                </div>
            </div>

        </section>

        {{-- CHART ROW 2 --}}
        <section class="rounded-xl border bg-white p-4">
            <h2 class="text-sm font-semibold mb-2">Kategori Usia</h2>
            <div class="h-[280px]">
                <canvas id="kategoriChart"></canvas>
            </div>
        </section>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const wilayahLabels = @json($wilayahLabels);
            const wilayahTotals = @json($wilayahTotals);

            const kabupatenLabels = @json($kabupatenLabels);
            const kabupatenTotals = @json($kabupatenTotals);

            const kategoriData = @json($kategoriData);

            const baseColor = '#16a34a';

            // ================= WILAYAH (HORIZONTAL BAR) =================
            new Chart(document.getElementById('wilayahChart'), {
                type: 'bar',
                data: {
                    labels: wilayahLabels,
                    datasets: [{
                        label: 'Jumlah',
                        data: wilayahTotals,
                        backgroundColor: baseColor + 'cc',
                        borderRadius: 6
                    }]
                },
                options: {
                    indexAxis: 'y', // 🔥 horizontal
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            ticks: {
                                autoSkip: false
                            }
                        }
                    }
                }
            });

            // ================= KABUPATEN (DOUGHNUT CLEAN) =================
            new Chart(document.getElementById('kabupatenChart'), {
                type: 'doughnut',
                data: {
                    labels: kabupatenLabels,
                    datasets: [{
                        data: kabupatenTotals,
                        backgroundColor: [
                            baseColor,
                            '#22c55e',
                            '#4ade80',
                            '#86efac',
                            '#bbf7d0'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // ================= KATEGORI USIA =================
            new Chart(document.getElementById('kategoriChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(kategoriData),
                    datasets: [{
                        label: 'Jumlah',
                        data: Object.values(kategoriData),
                        backgroundColor: baseColor + 'cc',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });
    </script>

</x-app-layout>