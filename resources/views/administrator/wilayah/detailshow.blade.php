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

    <!-- Header Section with Logo and Back Button -->
    <div class="grid grid-cols-1 gap-2">
        <div class="p-4 bg-white rounded-md shadow-md flex items-center justify-between">
            <img src="{{ asset('image/logofont.jpg') }}" width="200" alt="Logo">
            <a href="/wilayah/{{ substr($regency, 0, -3) }}"
                class="px-6 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                Kembali
            </a>
        </div>
    </div>

    <!-- Data Table -->
    <div class="mt-4 p-4 bg-white rounded-md shadow-md">
        <h2 class="text-lg font-semibold mb-3">Kode Desa</h2>

        <div class="overflow-auto">
            <table class="table-auto w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-3 py-1 border">No</th>
                        <th class="text-left px-3 py-1 border">Nama</th>
                        <th class="text-left px-3 py-1 border">Kode Kecamatan</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($desa as $index => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-1 py-1 border">{{ $index + 1 }}</td>
                        <td class="px-1 py-1 border">{{ $user->name }}</td>
                        <td class="px-1 py-1 border">{{ $user->code }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>