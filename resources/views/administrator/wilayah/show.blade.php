<x-app-layout>

    <x-slot name="header">

        @php
        $wilayah = \Illuminate\Support\Str::startsWith($regency->name, 'Kab.')
        ? 'Kabupaten ' . ltrim(substr($regency->name, 4))
        : $regency->name;
        @endphp

        @section('title', $wilayah)

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="text-xl font-bold text-gray-800">
                Dashboard -
                <span class="text-green-700">
                    {{ $wilayah }}
                </span>
            </h2>
        </div>

    </x-slot>

    {{-- WRAPPER --}}
    <div class="space-y-4">

        {{-- HEADER CARD --}}
        <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-xl shadow-lg p-4 flex items-center gap-4">

            <img src="{{ asset('image/favicon.png') }}"
                class="w-12 h-12 p-1">

            <div>
                <h3 class="text-lg font-bold uppercase">
                    {{ $wilayah }}
                </h3>

                <p class="text-sm text-green-100">
                    Data Kecamatan Terintegrasi
                </p>
            </div>

        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 p-4">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">

                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                    Kode Kecamatan
                </h2>

                <a href="{{ route('wilayah.province', $regency->province_code) }}"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg text-sm transition">

                    ← Kembali
                </a>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto rounded-lg border">

                <table class="min-w-full text-sm">

                    <thead class="bg-green-900 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">
                                No
                            </th>

                            <th class="px-4 py-3 text-left">
                                Nama Kecamatan
                            </th>

                            <th class="px-4 py-3 text-left">
                                Kode
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($kec as $index => $item)

                        <tr class="hover:bg-green-50 transition">

                            <td class="px-4 py-3 text-gray-500">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-4 py-3">
                                <a href="{{ route('wilayah.detail', $item->code) }}"
                                    class="text-green-700 font-medium hover:underline">

                                    {{ $item->name }}
                                </a>
                            </td>

                            <td class="px-4 py-3 text-gray-700 font-semibold">
                                {{ $item->code }}
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="3" class="text-center py-6 text-gray-500">
                                Data kecamatan tidak ditemukan
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>