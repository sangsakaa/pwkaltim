<x-app-layout>

    @php
    $male = (int) ($genderStat['L'] ?? 0);
    $female = (int) ($genderStat['P'] ?? 0);
    $totalPengamal = $male + $female;

    $wilayahLabels = collect($wilayahStat['labels'] ?? [])->values()->toArray();
    $wilayahTotals = collect($wilayahStat['values'] ?? [])->map(fn($v) => (int)$v)->values()->toArray();

    $kategoriData = $kategoriStat ?? [];

    /**
    * KABUPATEN DETAIL (USIA)
    */
    $kabupatenStats = collect($kabupatenStats ?? []);

    $kabupatenLabels = $kabupatenStats->pluck('label')->toArray();

    $bapakData = $kabupatenStats->pluck('bapak')->map(fn($v) => (int)$v)->toArray();
    $ibuData = $kabupatenStats->pluck('ibu')->map(fn($v) => (int)$v)->toArray();
    $remajaData = $kabupatenStats->pluck('remaja')->map(fn($v) => (int)$v)->toArray();
    $anakData = $kabupatenStats->pluck('anak')->map(fn($v) => (int)$v)->toArray();
    @endphp

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800">
                    Dashboard
                </h1>
                <p class="text-sm text-slate-500">
                    Sistem Informasi Pengamal Kaltim
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 space-y-6">

        {{-- KPI --}}
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            @foreach([
            ['Total Pengamal', $totalPengamal],
            ['Laki-laki', $male],
            ['Perempuan', $female],
            ] as $c)

            <div class="rounded-2xl border bg-white p-5 shadow-sm">
                <p class="text-xs text-slate-500">{{ $c[0] }}</p>
                <h2 class="text-2xl font-bold text-emerald-600">
                    {{ number_format($c[1]) }}
                </h2>
            </div>

            @endforeach

        </section>

        {{-- WILAYAH --}}
        <section class="rounded-2xl border bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold mb-4 text-slate-700">
                Statistik Wilayah
            </h2>

            <div class="h-[320px]">
                <canvas id="wilayahChart"></canvas>
            </div>
        </section>

        {{-- KABUPATEN (GROUPED - FIX HERE) --}}
        <section class="rounded-2xl border bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold mb-4 text-slate-700">
                Statistik Kabupaten Berdasarkan Usia
            </h2>

            <div class="h-[420px]">
                <canvas id="kabupatenChart"></canvas>
            </div>
        </section>

        {{-- KATEGORI --}}
        <section class="rounded-2xl border bg-white p-5 shadow-sm">
            <h2 class="text-sm font-semibold mb-4 text-slate-700">
                Kategori Usia
            </h2>

            <div class="h-[340px]">
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

            const bapak = @json($bapakData);
            const ibu = @json($ibuData);
            const remaja = @json($remajaData);
            const anak = @json($anakData);

            const kategoriData = @json($kategoriData);

            const base = '#16a34a';

            /* ================= WILAYAH ================= */
            new Chart(document.getElementById('wilayahChart'), {
                type: 'bar',
                data: {
                    labels: wilayahLabels,
                    datasets: [{
                        label: 'Total',
                        data: wilayahTotals,
                        backgroundColor: base + 'cc',
                        borderRadius: 6
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            /* ================= KABUPATEN (GROUPED BAR - FIX) ================= */
            new Chart(document.getElementById('kabupatenChart'), {
                type: 'bar',
                data: {
                    labels: kabupatenLabels,
                    datasets: [{
                            label: 'Bapak',
                            data: bapak,
                            backgroundColor: '#16a34a'
                        },
                        {
                            label: 'Ibu',
                            data: ibu,
                            backgroundColor: '#22c55e'
                        },
                        {
                            label: 'Remaja',
                            data: remaja,
                            backgroundColor: '#4ade80'
                        },
                        {
                            label: 'Anak',
                            data: anak,
                            backgroundColor: '#86efac'
                        }
                    ]
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
                            stacked: false // 🔥 IMPORTANT FIX
                        },
                        y: {
                            stacked: false, // 🔥 IMPORTANT FIX
                            beginAtZero: true
                        }
                    }
                }
            });

            /* ================= KATEGORI ================= */
            new Chart(document.getElementById('kategoriChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(kategoriData),
                    datasets: [{
                        data: Object.values(kategoriData),
                        backgroundColor: base + 'cc',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

        });
    </script>

</x-app-layout>