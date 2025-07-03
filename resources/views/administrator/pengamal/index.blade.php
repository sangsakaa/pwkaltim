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
                <div class=" w-full py-2 px-2">

                </div>
            </div>
        </div>
    </div>
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="  sm:flex sm:justify-between grid grid-cols-1 gap-2">
            <div>
                <a href="/pengamal/create">
                    <button class=" text-white bg-blue-500 rounded hover:bg-blue-600 px-2 py-1">
                        Tambah Pengamal
                    </button>
                </a>
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