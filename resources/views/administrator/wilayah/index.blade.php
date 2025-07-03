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
        <div class="  flex justify-between items-center ">

        </div>
        <div>
            <div class=" overflow-auto">
                <div class="container">
                    <h2>Kode Provinsi</h2>
                    <table class="table table-bordered table-striped w-full">
                        <thead>
                            <tr class=" border ">
                                <th class=" text-left px-2">No</th>
                                <th class=" text-left px-2">Nama</th>
                                <th class=" text-left px-2">Kode Province</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prov as $index => $user)
                            <tr class=" border ">
                                <td class=" px-2 text-left">{{ $index + 1 }}</td>
                                <td class=" px-2 text-left">{{ $user->name }}</td>
                                <td class=" px-2 text-left">{{ $user->code }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h2>Kode Kabupaten</h2>
                    <table class="table table-bordered table-striped w-full">
                        <thead>
                            <tr class=" border ">
                                <th class=" text-left px-2">No</th>
                                <th class=" text-left px-2">Nama</th>
                                <th class=" text-left px-2">Kode Province</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kab as $index => $user)
                            <tr class=" border ">
                                <td class=" px-2 text-left">{{ $index + 1 }}</td>
                                <td class=" px-2 text-left">
                                    <a href="/wilayah/{{$user->code}}">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <!-- <td class=" px-2 text-left">{{ $user->province_code }}</td> -->
                                <td class=" px-2 text-left">
                                    <a href="/wilayah/{{$user->code}}">
                                        {{ $user->code }}
                                </td>
                                </a>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>