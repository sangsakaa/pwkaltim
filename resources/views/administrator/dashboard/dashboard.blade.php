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
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between ">
                    <h2 class="text-xl font-semibold leading-tight">
                        {{ __('Dashboard Pengamal') }}
                    </h2>
                </div>

            </h2>

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
                </div>

            </div>
        </div>
    </div>
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="flex items-center justify-center">
            <h1 class="sm:text-2xl font-bold text-xs">Selamat Datang di Dashboard Administrator</h1>
        </div>
        <div class="">
            <p class="text-gray-700 sm:text-sm  text-justify text-xs">Anda dapat mengelola data pengamal
                dan melakukan berbagai tugas administratif lainnya.</p>

        </div>
    </div>
    <div class=" mt-2  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class=" grid  grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="w-full  rounded-md shadow">

                <div class="grid grid-cols-1 gap-6 p-6 bg-white rounded-xl shadow-md">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Pengamal Terdaftar</h2>
                        <p class="text-gray-600">Jumlah pengamal yang terdaftar di sistem:</p>
                        <p class="text-3xl font-bold text-blue-600 mt-2">
                            <span class=" flex">
                                <x-heroicon-o-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                                {{ $values->sum() }}
                            </span>

                        </p>
                    </div>

                    <div class="flex items-center justify-between bg-blue-50 p-4 rounded-lg">
                        <div class="text-xl font-semibold text-gray-700">
                            <span class=" flex">
                                <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                                Laki-Laki
                            </span>
                        </div>
                        <div class="text-2xl font-bold text-blue-800">

                            {{ $jumlahByGender['L'] ?? 0 }}

                        </div>
                    </div>

                    <div class="flex items-center justify-between bg-pink-50 p-4 rounded-lg">
                        <div class="text-xl font-semibold text-gray-700">Perempuan</div>
                        <div class="text-2xl font-bold text-pink-700">
                            {{ $jumlahByGender['P'] ?? 0 }}
                        </div>
                    </div>
                </div>


            </div>
            <div class="w-full  rounded-md shadow">
                <div class="p-2 w-full  bg-white ">
                    {{ $wilayah }}
                    <canvas id="chartBar"></canvas>
                </div>
            </div>
            <div class="w-full  rounded-md shadow">
                <div class=" p-2 w-full">
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
</x-app-layout>
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
                borderRadius: 1
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
<!-- pie cart -->
<script>
    const pieCtx = document.getElementById('pieChart').getContext('2d');

    const data = {
        labels: @json(array_keys($persentaseKategori)),
        datasets: [{
            label: 'Persentase Kategori Usia',
            data: @json(array_values($persentaseKategori)),
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)', // Anak-anak
                'rgba(54, 162, 235, 0.6)', // Remaja–Dewasa Muda
                'rgba(255, 206, 86, 0.6)', // Dewasa
                'rgba(75, 192, 192, 0.6)', // Lanjut Usia
            ],
            borderColor: [
                'rgba(255, 255, 255, 1)',
            ],
            borderWidth: 1
        }]
    };

    const pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            }
        }
    });
</script>