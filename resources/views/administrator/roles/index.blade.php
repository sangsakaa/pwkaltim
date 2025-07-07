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
                {{ __('Roles Management') }}
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
        <div class="  flex justify-between items-center ">

        </div>
        <div>
            <div class=" overflow-auto">
                <h1>Manajemen Roles</h1>

                <div class=" py-2">
                    <a class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition" href="{{ route('roles.create') }}">+ Buat Role Baru</a>
                </div>

                <table class=" w-full border">
                    <thead>
                        <tr class=" border">
                            <th class=" border px-2 text-left">Nama Role</th>
                            <th class=" border px-2">Permissions</th>
                            <th class=" border px-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr class=" px-2 border-b">
                            <td class="  w-1/3 px-2">{{ $role->name }}</td>
                            <td class=" border px-2">{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                            <td class=" border px-2">
                                <a href="{{ route('roles.edit', $role) }}">Edit</a>
                                <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus role ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
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