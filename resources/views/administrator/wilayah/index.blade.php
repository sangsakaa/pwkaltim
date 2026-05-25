<x-app-layout>

    <div class="p-6 space-y-6">

        {{-- HEADER --}}
        <div class="bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-xl p-6 shadow-md">

            <h1 class="text-2xl font-bold">
                Data Wilayah Administrasi
            </h1>

            <p class="text-sm text-green-100 mt-1">
                Klik provinsi untuk melihat kabupaten/kota
            </p>

        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-xl shadow border overflow-hidden">

            {{-- TABLE HEADER --}}
            <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50">

                <h2 class="font-semibold text-gray-700">
                    Daftar Provinsi
                </h2>

                <span class="text-xs text-gray-500">
                    Total: {{ count($prov) }}
                </span>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left w-12">No</th>
                            <th class="px-4 py-3 text-left">Nama Provinsi</th>
                            <th class="px-4 py-3 text-left">Kode</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse ($prov as $index => $province)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-4 py-3 text-gray-500">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $province->name }}
                            </td>

                            <td class="px-4 py-3 text-gray-500">
                                {{ $province->code }}
                            </td>

                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('wilayah.province', $province->code) }}"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition shadow-sm">

                                    Lihat Kabupaten →
                                </a>
                            </td>

                        </tr>
                        @empty

                        <tr>
                            <td colspan="4" class="text-center py-10 text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="text-lg">📍</span>
                                    <span>Tidak ada data provinsi</span>
                                </div>
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>