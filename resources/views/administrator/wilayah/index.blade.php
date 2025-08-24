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

    <!-- Welcome Section -->
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

    <!-- Data Tables Section -->
    <div class="mt-4 bg-white p-4 rounded-md shadow-md">
        <!-- Provinsi Table -->
        <h2 class="text-lg font-semibold mb-2">Kode Provinsi</h2>
        <div class="overflow-auto mb-6">
            <table class="table-auto w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-3 py-2 border">No</th>
                        <th class="text-left px-3 py-2 border">Nama</th>
                        <th class="text-left px-3 py-2 border">Kode Province</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prov as $index => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-3 py-2 border">{{ $user->name }}</td>
                        <td class="px-3 py-2 border">{{ $user->code }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Kabupaten Table -->
        <h2 class="text-lg font-semibold mb-2">Kode Kabupaten</h2>
        <div class="overflow-auto">
            <table class="table-auto w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-3 py-2 border">No</th>
                        <th class="text-left px-3 py-2 border">Nama</th>
                        <th class="text-left px-3 py-2 border">Kode Province</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kab as $index => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-3 py-2 border">
                            <a href="{{ url('/wilayah/' . $user->code) }}" class="text-blue-600 hover:underline">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td class="px-3 py-2 border">
                            <a href="{{ url('/wilayah/' . $user->code) }}" class="text-blue-600 hover:underline">
                                {{ $user->code }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>