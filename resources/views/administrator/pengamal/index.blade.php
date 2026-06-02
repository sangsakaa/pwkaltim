<x-app-layout>

    @php


    $user = auth()->user();

    $wilayah = 'Tidak diketahui';

    if ($user->regency?->name) {
    $wilayah = Str::startsWith($user->regency->name, 'Kab.')
    ? 'Kabupaten ' . ltrim(substr($user->regency->name, 4))
    : $user->regency->name;

    } elseif ($user->district?->name) {
    $wilayah = 'Kecamatan ' . $user->district->name;

    } elseif ($user->village?->name) {
    $wilayah = $user->village->name;

    } elseif ($user->province?->name) {
    $wilayah = $user->province->name;
    }
    @endphp

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-lg sm:text-2xl font-bold text-slate-800">
                    Dashboard
                </h1>
                <p class="text-sm text-slate-500">
                    <span class="text-green-700 font-semibold">{{ $wilayah }}</span>
                </p>
            </div>

        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 space-y-6">

        {{-- HERO CARD --}}
        <div class="rounded-2xl bg-gradient-to-r from-green-800 to-green-600 text-white p-5 sm:p-6 flex items-center gap-4 shadow">

            <img src="{{ asset('image/logo.png') }}" class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-white/10 p-1">

            <div>
                <h2 class="text-lg sm:text-xl font-bold uppercase">
                    {{ $wilayah }}
                </h2>
                <p class="text-sm text-green-100">
                    Sistem Data Pengamal Terintegrasi
                </p>
            </div>

        </div>

        {{-- TOOLBAR --}}
        <div class="bg-white rounded-2xl shadow border p-4 space-y-3">

            {{-- ACTION BUTTONS --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div class="flex flex-wrap gap-2">

                    @role('admin-provinsi')
                    <a href="/pengamal/create"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm transition">
                        + Tambah
                    </a>
                    @endrole

                    @role('admin-kabupaten')
                    <a href="/pengamal/create"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm transition">
                        + Tambah
                    </a>
                    @endrole

                    @role('admin-kecamatan')
                    <a href="/pengamal/create"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl text-sm transition">
                        + Tambah
                    </a>
                    @endrole

                    <a href="/laporan" target="_blank"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm transition">
                        Export PDF
                    </a>

                </div>

                {{-- SEARCH --}}
                <form action="{{ route('pengamal.index') }}" method="GET"
                    class="flex w-full sm:w-auto items-center gap-2">

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama / NIK..."
                        class="w-full sm:w-64 px-4 py-2 rounded-xl border focus:ring-2 focus:ring-green-500">

                    <button class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-xl text-sm">
                        Cari
                    </button>

                </form>

            </div>

        </div>

        {{-- CHART --}}
        <!-- <div class="bg-white rounded-2xl shadow border p-5">

            <h3 class="text-sm font-semibold text-slate-700 mb-3">
                {{ $chartTitle ?? 'Grafik Pengamal' }}
            </h3>

            <div class="h-[260px] sm:h-[320px]">
                <canvas id="chartKabupaten"></canvas>
            </div>

        </div> -->

        {{-- TABLE --}}
        <div class="bg-white rounded-2xl shadow border overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-green-900 text-white">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left hidden sm:table-cell">Kabupaten</th>
                            <th class="px-4 py-3 text-left hidden md:table-cell">Kecamatan</th>
                            <th class="px-4 py-3 text-left hidden lg:table-cell">Desa</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse ($dataPengamal as $item)
                        <tr class="hover:bg-green-50">

                            <td class="px-4 py-2 text-center">
                                {{ $dataPengamal->firstItem() + $loop->index }}
                            </td>

                            <td class="px-4 py-2">
                                <a href="/pengamal/{{ $item->id }}"
                                    class="font-medium {{ $item->tanggal_lahir ? 'text-green-700' : 'text-red-600' }}">
                                    {{ $item->nama_lengkap }}
                                </a>
                            </td>

                            <td class="px-4 py-2 hidden sm:table-cell">
                                {{ $item->regency->name ?? '-' }}
                            </td>

                            <td class="px-4 py-2 hidden md:table-cell">
                                {{ $item->district->name ?? '-' }}
                            </td>

                            <td class="px-4 py-2 hidden lg:table-cell">
                                {{ $item->village->name ?? '-' }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                Tidak ada data
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="p-4 border-t">
                {{ $dataPengamal->links() }}
            </div>

        </div>

    </div>

    {{-- TOASTR --}}
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: "4000",
        };

        @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
        @endif
    </script>

    {{-- CHART --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const data = @json($chartKabupaten ?? []);

            const labels = data.map(i => i.label ?? '-');
            const values = data.map(i => i.total ?? 0);

            const canvas = document.getElementById('chartKabupaten');
            if (!canvas) return;

            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Jumlah Pengamal',
                        data: values,
                        backgroundColor: 'rgba(34, 197, 94, 0.7)',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

        });
    </script>

</x-app-layout>