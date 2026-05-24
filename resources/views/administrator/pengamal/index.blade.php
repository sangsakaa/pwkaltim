<x-app-layout>

    {{-- HEADER --}}
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

        @section('title', 'PW ' . $wilayah)

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

            <img src="{{ asset('image/logo.png') }}" class="w-12 h-12  rounded-full p-1">

            <div>
                <h3 class="text-lg font-bold uppercase">
                    PW {{ $wilayah }}
                </h3>
                <p class="text-sm text-green-100">
                    Sistem Data Pengamal Terintegrasi
                </p>
            </div>

        </div>

        {{-- TOOLBAR --}}
        <div class="bg-white rounded-xl shadow p-4 border border-gray-100">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">

                {{-- BUTTONS --}}
                <div class="flex flex-wrap gap-2">

                    @role('admin-provinsi')
                    <a href="/pengamal/create"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow">
                        + Tambah Pengamal
                    </a>
                    @endrole

                    @role('admin-kabupaten')
                    <a href="/pengamal/create"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm shadow">
                        + Tambah Pengamal
                    </a>
                    @endrole

                    @role('admin-kecamatan')
                    <a href="/pengamal/create"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm shadow">
                        + Tambah Pengamal
                    </a>
                    @endrole

                    <a href="/laporan" target="_blank"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm shadow">
                        Export PDF
                    </a>

                </div>

                {{-- SEARCH --}}
                <form action="{{ route('pengamal.index') }}" method="GET"
                    class="flex items-center gap-2">

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama / NIK..."
                        class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">

                    <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm">
                        Cari
                    </button>

                    @if(request('search'))
                    <a href="{{ route('pengamal.index') }}"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg text-sm">
                        Reset
                    </a>
                    @endif

                </form>

            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-green-900 text-white">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Kabupaten</th>
                            <th class="px-4 py-3 text-left">Kecamatan</th>
                            <th class="px-4 py-3 text-left">Desa</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse ($dataPengamal as $item)
                        <tr class="hover:bg-green-50 transition">

                            <td class="px-4 py-3 text-center text-gray-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-medium">
                                <a href="/pengamal/show/{{ $item->id }}"
                                    class="text-green-700 hover:underline">
                                    {{ $item->nama_lengkap }}
                                </a>
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $item->regency->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $item->district->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $item->village->name ?? '-' }}
                            </td>

                        </tr>
                        @empty

                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                Tidak ada data ditemukan
                            </td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>

            </div>

            {{-- PAGINATION --}}
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

        @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
        @endif

        @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
        @endif
    </script>

</x-app-layout>