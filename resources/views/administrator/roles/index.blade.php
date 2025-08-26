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

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1 mb-4"> {{-- Added mb-4 for spacing --}}
        <div class="p-4 overflow-hidden bg-white rounded-md shadow-md"> {{-- Increased padding to p-4 --}}
            <div class="flex">
                <div class="bg-green-800 flex flex-col items-center justify-center p-2"> {{-- Increased padding to p-2 --}}

                </div>
                <div class="bg-green-800 flex-1 flex flex-col items-center justify-center text-white font-semibold p-4"> {{-- Used flex-1 to make it take remaining space, p-4 for consistent padding --}}
                    @php
                    $user = auth()->user();

                    if ($user->regency?->name) {
                    if (Str::startsWith($user->regency->name, 'Kab.')) {
                    $wilayah = 'Kabupaten ' . ltrim(substr($user->regency->name, 4));
                    } else {
                    $wilayah = $user->regency->name;
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
                    <span class="uppercase text-lg font-semibold text-center">PW {{ $wilayah }}</span> {{-- Added text-center for better alignment --}}
                </div>
            </div>
        </div>
    </div>

    <div class="p-4 overflow-hidden bg-white rounded-md shadow-md"> {{-- Increased padding to p-4 --}}
        <h1 class="text-2xl font-bold mb-4">Manajemen Roles</h1> {{-- Added text-2xl, font-bold, mb-4 for better heading styling and spacing --}}

        <div class="mb-4"> {{-- Added mb-4 for spacing --}}
            <a class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300 ease-in-out" href="{{ route('roles.create') }}">+ Buat Role Baru</a> {{-- Added duration and ease for smooth transition --}}
        </div>

        <div class="overflow-x-auto"> {{-- Added overflow-x-auto for responsive table scrolling --}}
            <table class="min-w-full border-collapse border border-gray-200"> {{-- Used min-w-full and border-collapse for better table styling --}}
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200"> {{-- Added bg-gray-100 for header background --}}
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Nama Role</th> {{-- Consistent padding and text styling --}}
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Permissions</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr class="border-b border-gray-200 hover:bg-gray-50"> {{-- Added hover effect --}}
                        <td class="py-3 px-4 whitespace-nowrap border-r border-gray-200">{{ $role->name }}</td> {{-- Added whitespace-nowrap to prevent text wrapping in narrow columns --}}
                        <td class="py-3 px-4 border-r border-gray-200">{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                        <td class="py-3 px-4">
                            <a class="text-blue-600 hover:text-blue-800 mr-2" href="{{ route('roles.edit', $role) }}">Edit</a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline-block"> {{-- Used inline-block for form to align better --}}
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Hapus role ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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