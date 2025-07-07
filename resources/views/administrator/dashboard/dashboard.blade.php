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

        </div>
    </div>
    <div class=" mt-2  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class=" grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 bg-blue-100 rounded-md shadow">
                <h2 class="text-lg font-semibold">Pengamal Terdaftar</h2>
                <p class="text-gray-600">Jumlah pengamal yang terdaftar di sistem: <span class="" style="font-size: large;"></span></p>
            </div>
            <div class=" bg-green-100 rounded-md shadow">
                <div class="w-full p-4 bg-white rounded shadow">
                    <canvas id="chartBar"></canvas>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('chartBar').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @json($labels), // Label akan tampil di sumbu Y
                            datasets: [{
                                label: 'Jumlah',
                                data: @json($values),
                                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 1,
                                borderRadius: 4
                            }]
                        },
                        options: {
                            indexAxis: 'y', // Ini yang bikin bar jadi horizontal
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.raw + ' data';
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                </script>









            </div>
            <div class="p-4 bg-yellow-100 rounded-md shadow">
                <h2 class="text-lg font-semibold">Statistik Pengguna</h2>
                <p class="text-gray-600">Statistik pengguna dan aktivitas mereka di sistem.</p>
            </div>
        </div>
</x-app-layout>