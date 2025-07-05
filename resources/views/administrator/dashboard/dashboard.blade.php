<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">

                @php
                if ($user->regency?->name) {
                if (Str::startsWith($user->regency->name, 'Kab.')) {
                $wilayah = 'Kabupaten ' . ltrim(substr($user->regency->name, 4));
                } else {
                $wilayah = $user->regency->name; // Biarkan 'Kota ...' atau lainnya
                }
                } elseif ($user->district?->name) {
                $wilayah = 'Kec. ' . $user->district->name;
                } elseif ($user->village?->name) {
                $wilayah = $user->village->name;
                } elseif ($user->province?->name) {
                $wilayah = $user->province->name;
                } else {
                $wilayah = 'Tidak diketahui';
                }
                @endphp

                @section('title', 'PW ' . $wilayah)

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
                <div class="bg-green-800 flex flex-col items-center justify-center p-1">
                    <img src="{{ asset('image/logo.png') }}" width="50" alt="Logo">
                </div>

                <div class="bg-green-800 w-full sm:grid sm:grid-cols-1 flex flex-col items-center text-white fw-semibold p-4">
                    @php
                    if ($user->regency?->name) {
                    if (Str::startsWith($user->regency->name, 'Kab.')) {
                    $wilayah = 'Kabupaten ' . ltrim(substr($user->regency->name, 4));
                    } else {
                    $wilayah = $user->regency->name; // Biarkan 'Kota ...' atau lainnya
                    }
                    } elseif ($user->district?->name) {
                    $wilayah = 'Kec. ' . $user->district->name;
                    } elseif ($user->village?->name) {
                    $wilayah = $user->village->name;
                    } elseif ($user->province?->name) {
                    $wilayah = $user->province->name;
                    } else {
                    $wilayah = 'Tidak diketahui';
                    }
                    @endphp

                    <span class="uppercase text-lg fw-semibold">PW {{ $wilayah }}</span>

                    <!-- <div class="kop-surat">
                        <div class="yayasan text-lg font-bold">YAYASAN PERJUANGAN WAHIDIYAH DAN PONDOK PESANTREN KEDUNGLO</div>
                        <div class="departemen text-base mt-1">DEPARTEMEN PEMBINA WAHIDIYAH<br><span class="uppercase semibold text-lg"></span></div>
                        <div class="akta text-sm mt-1">AKTA NOMOR 09 TAHUN 2011 KEMENKUMHAM RI NOMOR : AHU-9371.AH.01.04 TAHUN 2011</div>
                    </div> -->
                </div>

            </div>
        </div>
    </div>
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="flex items-center justify-center">
            <h1 class="text-2xl font-bold">Selamat Datang di Dashboard Administrator</h1>
        </div>
        <div class="">
            <p class="text-gray-700">Ini adalah halaman dashboard untuk administrator. Anda dapat mengelola data pengamal
                dan melakukan berbagai tugas administratif lainnya.</p>
            @php
            $wilayah = $user->province->name
            ?? $user->regency->name
            ?? $user->district->name
            ?? $user->village->name
            ?? 'Tidak diketahui';
            @endphp
        </div>
    </div>
    <div class=" mt-2  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class=" grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 bg-blue-100 rounded-md shadow">
                <h2 class="text-lg font-semibold">Pengamal Terdaftar</h2>
                <p class="text-gray-600">Jumlah pengamal yang terdaftar di sistem: <span class="" style="font-size: large;">{{ $dataPengamal}}</span></p>
            </div>
            <div class="p-4 bg-green-100 rounded-md shadow">


                <head>
                    <title>Grafik Jumlah Se Kabupaten</title>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                </head>

                <body>
                    <h2>Grafik Jumlah per Kecamatan</h2>
                    <canvas id="barChart" width="600" height="400"></canvas>

                    <script>
                        const labels = @json($labels);
                        const data = @json($data);

                        // Fungsi untuk membuat warna acak
                        function getRandomColor() {
                            const r = Math.floor(Math.random() * 200);
                            const g = Math.floor(Math.random() * 200);
                            const b = Math.floor(Math.random() * 200);
                            return `rgba(${r}, ${g}, ${b}, 0.7)`;
                        }

                        // Buat array warna acak untuk setiap bar
                        const backgroundColors = labels.map(() => getRandomColor());

                        const ctx = document.getElementById('barChart').getContext('2d');

                        const barChart = new Chart(ctx, {
                            type: 'bar', // Jenis grafik bar
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Jumlah per Kecamatan',
                                    data: data,
                                    backgroundColor: backgroundColors,
                                    borderColor: backgroundColors.map(color => color.replace('0.7', '1')), // Versi opak untuk border
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                indexAxis: 'y', // Chart horizontal
                                responsive: true,
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    },
                                    y: {
                                        ticks: {
                                            autoSkip: false
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                </body>

            </div>
            <div class="p-4 bg-yellow-100 rounded-md shadow">
                <h2 class="text-lg font-semibold">Statistik Pengguna</h2>
                <p class="text-gray-600">Statistik pengguna dan aktivitas mereka di sistem.</p>
            </div>
        </div>
</x-app-layout>