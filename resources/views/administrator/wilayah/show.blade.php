<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black"
                class="justify-center max-w-xs gap-2">
                <x-icons.github class="w-6 h-6" aria-hidden="true" />
                <span>Data Pengamal</span>
            </x-button>
        </div>
    </x-slot>

    <div class=" gap-2 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
        <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md">
            <div class="  flex ">
                <div>
                    <img src="{{ asset('image/logofont.jpg') }}" width="200" alt="Logo">
                </div>
                <div class=" w-full flex items-center justify-end">
                    <a href="/wilayah"
                        class="px-6 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md">
        <div class="  flex justify-between items-center ">

        </div>
        <div>
            <div class=" overflow-auto">


                <h2>Kode Kecamatan</h2>

                <table class="table table-bordered table-striped w-full">
                    <thead>
                        <tr class=" border ">
                            <th class=" text-left px-2">No</th>
                            <th class=" text-left px-2">Nama</th>
                            <th class=" text-left px-2">Kode Kecamatan</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kec as $index => $user)
                        <tr class=" border ">
                            <td class=" px-2 text-left">{{ $index + 1 }}</td>
                            <td>
                                <a href="/wilayah-desa/{{$user->code}}">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class=" px-2 text-left">{{ $user->code }}</td>
                            <td class=" px-2 text-left">{{ $user->province_code }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    </div>

</x-app-layout>