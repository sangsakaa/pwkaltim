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

    <!-- Card Wilayah -->
    <div class="grid gap-2">
        <div class="bg-green-800  text-white rounded-md shadow-md flex items-center">
            <div class="bg-green-800 p-2 rounded-md flex items-center justify-center">
                <img src="{{ asset('image/logo.png') }}" alt="Logo" width="50">
            </div>
            <div class="ml-4">
                <h3 class="uppercase text-lg font-semibold ">PW {{ $wilayah }}</h3>
            </div>
        </div>

        <!-- Tools -->
        <div class="bg-white p-4 rounded-md shadow-md">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div class="flex gap-2 flex-wrap">
                    @role('admin-provinsi')
                    <a href="/pengamal/create" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                        Tambah Pengamal
                    </a>
                    @endrole

                    @role('admin-kabupaten')
                    <a href="/pengamal/create" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                        Tambah Pengamal
                    </a>
                    @endrole

                    @role('admin-kecamatan')
                    <a href="/pengamal/create" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded">
                        Tambah Pengamal
                    </a>
                    @endrole

                    <a href="/laporan" target="_blank" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                        PDF
                    </a>
                </div>

                <form action="{{ route('pengamal.index') }}" method="GET" class="mb-4 flex items-center gap-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau NIK..."
                        class="border border-gray-300 rounded px-3 py-2 w-64">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Cari
                    </button>

                    @if(request('search'))
                    <a
                        href="{{ route('pengamal.index') }}"
                        class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                        Reset
                    </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Tabel Data Pengamal -->
        <div class="bg-white p-4 rounded-md shadow-md overflow-x-auto">
            <table class="min-w-full table-auto border divide-y divide-gray-200">
                <thead class="bg-green-900 text-white">
                    <tr>
                        <th class="py-2 px-3 text-center">No</th>
                        <th class="py-2 px-3 text-left">Nama</th>
                        <th class="py-2 px-3 text-left">Kabupaten</th>
                        <th class="py-2 px-3 text-left">Kecamatan</th>
                        <th class="py-2 px-3 text-left">Desa</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse ($dataPengamal as $item)
                    <tr class="hover:bg-gray-50 border-b">
                        <td class="py-2 px-3 text-center">{{ $loop->iteration }}</td>
                        <td class="py-2 px-3">
                            <a href="/pengamal/show/{{ $item->id }}" class="text-blue-600 hover:underline">
                                {{ $item->nama_lengkap }}
                            </a>
                        </td>
                        <td class="py-2 px-3">{{ $item->regency->name ?? '-' }}</td>
                        <td class="py-2 px-3">Kec. {{ $item->district->name ?? '-' }}</td>
                        <td class="py-2 px-3">{{ $item->village->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Data tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $dataPengamal->links() }}
            </div>
        </div>
    </div>

    <!-- Toastr JS -->
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: "5000",
        };

        @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
        @endif
        @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
        @endif
        @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
        @endif
        @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
        @endif
    </script>
</x-app-layout>