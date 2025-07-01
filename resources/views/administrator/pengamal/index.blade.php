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
        <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="  flex ">
                <div>
                    <img src="{{ asset('image/logofont.jpg') }}" width="200" alt="Logo">
                </div>
                <div class=" w-full flex items-center justify-center">
                    <marquee behavior="scroll" direction="left">
                        Selamat datang di website kami!
                    </marquee>
                </div>
            </div>
        </div>
    </div>
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div>
            <a href="/pengamal/create">
                <button class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                    Tambah Pengamal
                </button>
            </a>
        </div>
        <div>
            <div class="">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th class=" text-left">Nama Lengkap</th>
                            <th>Alamat Lengkap</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPengamal as $item)
                        <tr>
                            <td class=" text-center">{{ $item->nik }}</td>
                            <td><a href="/pengamal/show/{{$item->id}}">{{ $item->nama_lengkap }}</a></td>
                            <td class=" text-center"> Kec. {{$item->district->name}} - Desa . {{$item->village->name}}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>