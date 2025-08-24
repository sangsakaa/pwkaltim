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
        $wilayah = 'Kec. ' . $user->district->name;
        } elseif ($user->village?->name) {
        $wilayah = $user->village->name;
        } elseif ($user->province?->name) {
        $wilayah = $user->province->name;
        }
        @endphp

        @section('title', 'PW ' . $wilayah)
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Dashboard - <span class="text-green-700">PW {{ $wilayah }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="grid gap-4">
        <!-- Logo dan Tombol Kembali -->
        <div class="grid grid-cols-1 gap-2">
            <div class="bg-green-800  text-white rounded-md shadow-md flex items-center">
                <div class="bg-green-800 p-2 rounded-md flex items-center justify-center">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo" width="50">
                </div>
                <div class="ml-4">
                    <h3 class="uppercase text-lg font-semibold ">PW {{ $wilayah }}</h3>
                </div>
            </div>
        </div>

        <!-- Tabel Data Kecamatan -->
        <div class="p-6 bg-white rounded-md shadow-md">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Kode Kecamatan</h2>
                <a href="/wilayah"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                    Kembali
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-auto border border-gray-300 text-sm">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">Kode Kecamatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kec as $index => $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">
                                <a href="/wilayah-desa/{{ $user->code }}" class="text-blue-600 hover:underline">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class="px-4 py-2 border">{{ $user->code }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>