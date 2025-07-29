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

        <!-- WELCOME CARD -->
        <div class="bg-white dark:bg-gray-800 dark:text-white rounded-md shadow-md p-4">
            <h1 class="text-xl font-bold text-center">Selamat Datang di Dashboard Administrator</h1>
            <p class="mt-2 text-justify text-gray-700 dark:text-gray-200 text-sm">
                Anda dapat mengelola data pengamal dan melakukan berbagai tugas administratif lainnya.
            </p>

            @role(['admin-provinsi', 'superAdmin'])
            <div class="mt-3 bg-blue-100 text-blue-800 p-3 rounded">🔐 Anda memiliki akses penuh ke data seluruh wilayah.</div>
            @elserole('admin-kabupaten')
            <div class="mt-3 bg-green-100 text-green-800 p-3 rounded">📌 Anda dapat mengelola data pada tingkat kabupaten.</div>
            @else
            <div class="mt-3 bg-yellow-100 text-yellow-800 p-3 rounded">⚠️ Peran Anda belum teridentifikasi. Hubungi administrator.</div>
            @endrole
        </div>

        <!-- STATISTIC BOXES -->
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

        <!-- CHARTS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-md shadow-md p-4">
                <h2 class="text-xl font-semibold mb-4">Statistik Pengamal</h2>
                <div class="w-[480px] h-[260px]">
                    <canvas id="barChart"></canvas>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('barChart').getContext('2d');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: @json($labels), // jadi sumbu Y (kategori)
                            datasets: [{
                                label: 'Jumlah Pengamal',
                                data: @json($values), // jadi sumbu X (nilai)
                                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                                borderColor: 'rgba(37, 99, 235, 1)',
                                borderWidth: 1,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            indexAxis: 'y', // menjadikan chart horizontal
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    },
                                    title: {
                                        display: true,
                                        text: 'Jumlah'
                                    }
                                },
                                y: {
                                    ticks: {
                                        autoSkip: false
                                    },
                                    title: {
                                        display: true,
                                        text: 'Wilayah'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                </script>
            </div>


            <div class=" rounded-md shadow-md p-4 bg-white">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">User ID</th>
                            <th class="px-4 py-2 border">IP Address</th>
                            <th class="px-4 py-2 border">User Agent</th>
                            <th class="px-4 py-2 border">Terakhir Aktif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($activeUsers as $session)
                        <tr>
                            <td class="px-4 py-2 border text-center">
                                {{ $session->user_id ?? '-' }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $session->ip_address }}
                            </td>
                            <td class="px-4 py-2 border text-sm">
                                {{ Str::limit($session->user_agent, 50) }}
                            </td>
                            <td class="px-4 py-2 border text-center">
                                {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 border text-center">Tidak ada user aktif saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- CHART.JS -->

</x-app-layout>