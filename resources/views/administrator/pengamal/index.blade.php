@php
use Illuminate\Support\Str;

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

<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="text-xl font-bold text-gray-800">
                Dashboard - <span class="text-green-700">PW {{ $wilayah }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="space-y-4">

        {{-- HEADER CARD --}}
        <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-xl shadow-lg p-4 flex items-center gap-4">
            <img src="{{ asset('image/logo.png') }}" class="w-12 h-12 rounded-full p-1">

            <div>
                <h3 class="text-lg font-bold uppercase">{{ $wilayah }}</h3>
                <p class="text-sm text-green-100">Sistem Data Pengamal Terintegrasi</p>
            </div>
        </div>

        {{-- TOOLBAR --}}
        <div class="bg-white rounded-xl shadow p-4 border border-gray-100">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">

                <div class="flex flex-wrap gap-2">

                    @role('admin-provinsi')
                    <a href="/pengamal/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                        + Tambah Pengamal
                    </a>
                    <!-- <div class="flex gap-2 mb-4">

                        <a
                            href="{{ route('pengamal.sync') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                            onclick="return confirm('Sinkronkan data pengamal dari server?')">
                            🔄 Sinkron Data
                        </a>

                    </div> -->
                    @endrole

                    @role('admin-kabupaten')
                    <a href="/pengamal/create" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                        + Tambah Pengamal
                    </a>
                    @endrole

                    @role('admin-kecamatan')
                    <a href="/pengamal/create" class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm">
                        + Tambah Pengamal
                    </a>
                    @endrole

                    <a href="/laporan" target="_blank" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                        Export PDF
                    </a>

                </div>

                {{-- SEARCH --}}
                <form action="{{ route('pengamal.index') }}" method="GET" class="flex items-center gap-2">

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama / NIK..."
                        class="w-64 px-4 py-2 rounded-lg border">

                    <button class="bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                        Cari
                    </button>

                </form>

            </div>
        </div>

        {{-- CHART --}}
        <div class="bg-white rounded-xl shadow p-4 border border-gray-100">

            <h3 class="text-lg font-bold text-gray-700 mb-4">
                {{ $chartTitle ?? 'Grafik Pengamal' }}
            </h3>

            <div style="height: 300px;">
                <canvas id="chartKabupaten"></canvas>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-green-900 text-white">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Kabupaten</th>
                            <th class="px-4 py-3 text-left">Kecamatan</th>
                            <th class="px-4 py-3 text-left">Desa</th>
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
                                    class="{{ $item->tanggal_lahir ? 'text-green-700' : 'text-red-600 font-semibold' }}">

                                    {{ $item->nama_lengkap }}

                                </a>
                            </td>

                            <td class="px-4 py-2">{{ $item->regency->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->district->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $item->village->name ?? '-' }}</td>

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

        @if(Session::has('success')) toastr.success("{{ Session::get('success') }}");
        @endif
        @if(Session::has('error')) toastr.error("{{ Session::get('error') }}");
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
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Pengamal',
                        data: values,
                        backgroundColor: 'rgba(34, 197, 94, 0.7)',
                        borderWidth: 1
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