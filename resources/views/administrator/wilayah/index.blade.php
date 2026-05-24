<x-app-layout>

    <x-slot name="header">
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

        @section('title' . $wilayah)

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="text-xl font-bold text-gray-800">
                Dashboard - <span class="text-green-700">PW {{ $wilayah }}</span>
            </h2>
        </div>
    </x-slot>

    {{-- WRAPPER --}}
    <div class="space-y-4">

        {{-- HEADER CARD --}}
        <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-xl shadow-lg p-4 flex items-center gap-4">

            <img src="{{ asset('image/favicon.png') }}"
                class="w-12 h-12 bg-white rounded-full p-1">

            <div>
                <h3 class="text-lg font-bold uppercase">
                    {{ $wilayah }}
                </h3>
                <p class="text-sm text-green-100">
                    Data Wilayah Administrasi Terintegrasi
                </p>
            </div>

        </div>

        {{-- TABLE SECTION --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 p-4 space-y-8">

            {{-- PROVINSI --}}
            <div>
                <h2 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                    Kode Provinsi
                </h2>

                <div class="overflow-x-auto rounded-lg border">
                    <table class="min-w-full text-sm">

                        <thead class="bg-green-900 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama Provinsi</th>
                                <th class="px-4 py-3 text-left">Kode</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach($prov as $index => $item)
                            <tr class="hover:bg-green-50 transition">

                                <td class="px-4 py-3 text-gray-500">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $item->name }}
                                </td>

                                <td class="px-4 py-3 text-green-700 font-semibold">
                                    {{ $item->code }}
                                </td>

                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>

            {{-- KABUPATEN --}}
            <div>
                <h2 class="text-lg font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                    Kode Kabupaten
                </h2>

                <div class="overflow-x-auto rounded-lg border">
                    <table class="min-w-full text-sm">

                        <thead class="bg-green-900 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Nama Kabupaten</th>
                                <th class="px-4 py-3 text-left">Kode</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @foreach($kab as $index => $item)
                            <tr class="hover:bg-green-50 transition">

                                <td class="px-4 py-3 text-gray-500">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-4 py-3">
                                    <a href="{{ url('/wilayah/' . $item->code) }}"
                                        class="text-green-700 font-medium hover:underline">
                                        {{ $item->name }}
                                    </a>
                                </td>

                                <td class="px-4 py-3">
                                    <a href="{{ url('/wilayah/' . $item->code) }}"
                                        class="text-blue-600 font-semibold hover:underline">
                                        {{ $item->code }}
                                    </a>
                                </td>

                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>

        </div>

    </div>

</x-app-layout>