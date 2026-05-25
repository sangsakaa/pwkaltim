<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">

        @php
        $wilayah = 'Kecamatan ' . $district->name;
        @endphp

        @section('title', $wilayah)

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Dashboard
                </h2>

                <p class="text-sm text-gray-500">
                    {{ $wilayah }}
                </p>
            </div>
        </div>

    </x-slot>

    <div class="space-y-5">

        {{-- HERO HEADER --}}
        <div
            class="bg-gradient-to-r from-green-800 via-green-700 to-green-600 rounded-2xl shadow-lg p-5 text-white">

            <div class="flex flex-col md:flex-row items-center justify-between gap-4">

                <div class="flex items-center gap-4">

                    <img src="{{ asset('image/favicon.png') }}"
                        class="h-14 md:h-16 object-contain p-2"
                        alt="Logo">

                    <div>

                        <h3 class="text-xl font-bold">
                            Data Desa
                        </h3>

                        <p class="text-green-100 text-sm">
                            Daftar kode desa wilayah {{ $wilayah }}
                        </p>

                    </div>
                </div>

                {{-- KEMBALI KE HALAMAN KECAMATAN --}}
                <a href="{{ route('wilayah.show', $district->regency_code) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/20 hover:bg-white/30 transition text-white font-medium border border-white/20">

                    ← Kembali
                </a>

            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            {{-- TITLE --}}
            <div class="px-6 py-4 border-b bg-gray-50">

                <h2 class="font-semibold text-gray-800">
                    Kode Desa
                </h2>

                <p class="text-sm text-gray-500">
                    Total data: {{ $desa->count() }}
                </p>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-green-800 text-white">
                        <tr>
                            <th class="px-4 py-3 text-center w-20">
                                No
                            </th>

                            <th class="px-4 py-3 text-left">
                                Nama Desa
                            </th>

                            <th class="px-4 py-3 text-left">
                                Kode Desa
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($desa as $index => $item)

                        <tr class="hover:bg-green-50 transition duration-200">

                            <td class="px-4 py-3 text-center text-gray-500">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $item->name }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 font-medium">
                                    {{ $item->code }}
                                </span>
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="3"
                                class="text-center py-10 text-gray-500">

                                Tidak ada data desa ditemukan
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>