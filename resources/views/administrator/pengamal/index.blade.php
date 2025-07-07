<x-app-layout>
    <x-slot name="header">
        @php
        $user = auth()->user();

        if ($user->regency?->name) {
        if (Str::startsWith($user->regency->name, 'Kab.')) {
        $wilayah = 'Kabupaten ' . ltrim(substr($user->regency->name, 4));
        } else {
        $wilayah = $user->regency->name; // Biarkan 'Kota ...' atau lainnya
        }
        } elseif ($user->district?->name) {
        $wilayah = 'Kec. ' . $user->district->name;
        } elseif ($user->village?->name) {
        $wilayah = $user->village->name;
        } elseif ($user->province?->name) {
        $wilayah = $user->province->name;
        } else {
        $wilayah = 'Tidak diketahui';
        }
        @endphp
        @section('title', 'PW '. $wilayah )
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between ">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Management Pengamal') }}
            </h2>
        </div>
    </x-slot>

    <div class=" gap-2 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
        <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="  flex ">

                <div class="bg-green-800 flex flex-col items-center justify-center p-1">
                    <img src="{{ asset('image/logo.png') }}" width="50" alt="Logo">
                </div>

                <div class="bg-green-800 w-full sm:grid sm:grid-cols-1 flex flex-col items-center text-white fw-semibold p-4">
                    @php
                    $user = auth()->user();

                    if ($user->regency?->name) {
                    if (Str::startsWith($user->regency->name, 'Kab.')) {
                    $wilayah = 'Kabupaten ' . ltrim(substr($user->regency->name, 4));
                    } else {
                    $wilayah = $user->regency->name; // Biarkan 'Kota ...' atau lainnya
                    }
                    } elseif ($user->district?->name) {
                    $wilayah = 'Kec. ' . $user->district->name;
                    } elseif ($user->village?->name) {
                    $wilayah = $user->village->name;
                    } elseif ($user->province?->name) {
                    $wilayah = $user->province->name;
                    } else {
                    $wilayah = 'Tidak diketahui';
                    }
                    @endphp
                    <span class="uppercase text-lg fw-semibold">PW {{ $wilayah }}</span>
                </div>

            </div>
        </div>
    </div>
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="  sm:flex sm:justify-between grid grid-cols-1 gap-2">
            <div>
                <!-- <a href="/pengamal/create">
                    <button class=" text-white bg-blue-500 rounded hover:bg-blue-600 px-2 py-1">
                        Tambah Pengamal
                    </button>
                </a> -->
                @role('admin-provinsi')
                <a href="/pengamal/create"
                    class="inline-block text-white bg-blue-500 rounded hover:bg-blue-600 px-2 py-1">
                    Tambah Pengamal
                </a>
                @endrole

                @role('admin-kabupaten')
                <a href="/pengamal/create"
                    class="inline-block text-white bg-green-500 rounded hover:bg-green-600 px-2 py-1">
                    Tambah Pengamal
                </a>
                @endrole

                @role('admin-kecamatan')
                <a href="/pengamal/create"
                    class="inline-block text-white bg-purple-500 rounded hover:bg-purple-600 px-2 py-1">
                    Tambah Pengamal
                </a>
                @endrole
                <a href="/laporan" target="_blank">
                    <button class=" text-white bg-blue-500 rounded hover:bg-blue-600 px-2 py-1">
                        PDF
                    </button>
                </a>
            </div>
            <div>
                <form action="{{ route('pengamal.index') }}" method="GET" class="flex items-center gap-2 ">
                    <input type="text" name="search" placeholder="Cari nama atau NIK"
                        value="{{ request('search') }}"
                        class="rounded-md py-1 px-2 border w-64">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded-md">
                        Cari
                    </button>
                </form>
            </div>
        </div>
        <div>
            <div class=" overflow-auto ">
                <table class="  min-w-full divide-y divide-gray-200 border ">
                    <thead>
                        <tr class="bg-green-900 text-white py-4">
                            <th class=" py-2">No</th>

                            <th class=" text-left">Nama</th>
                            <th>Kabupaten</th>
                            <th>Kecamatan</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPengamal as $item)
                        <tr class="hover:bg-gray-100 border">
                            <td class=" text-center py-1">{{ $loop->iteration}}</td>

                            <td><a href="/pengamal/show/{{$item->id}}">{{ $item->nama_lengkap }}</a></td>
                            <td class=" text-left"> {{$item->regency->name??'-'}}</td>
                            <td class=" text-left">Kec. {{$item->district->name ??'-'}} </td>

                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-center">
                                {{ $dataPengamal->links() }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
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