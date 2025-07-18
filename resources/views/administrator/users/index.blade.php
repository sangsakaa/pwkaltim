<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
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
                        {{ __('User Management') }}
                    </h2>
                </div>
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
            <div>
                <h2>Daftar User</h2>
            </div>
            <div>
                @php
                $isAdminProvinsi = auth()->user()->hasRole(['admin-provinsi','superAdmin']);
                @endphp

                <a href="{{ $isAdminProvinsi ? '/users/create' : '#' }}"
                    class="inline-block px-2 py-1 rounded 
        {{ $isAdminProvinsi ? 'bg-blue-500 hover:bg-blue-600 text-white cursor-pointer' : 'bg-gray-300 text-gray-600 cursor-not-allowed' }}"
                    @if(!$isAdminProvinsi)
                    title="Hanya bisa diakses oleh admin-provinsi"
                    onclick="event.preventDefault();"
                    @endif>
                    Tambah User
                </a>
            </div>
        </div>
        <div>
            <div class=" overflow-auto mt-2">
                <div class="container">
                    <table class="table table-bordered table-striped w-full">
                        <thead>
                            <tr class=" border ">
                                <th class=" text-left px-2">No</th>
                                <th class=" text-left px-2">Nama</th>
                                <th class=" text-left px-2">Email</th>
                                <th class=" text-left px-2">Role</th>
                                <th class=" text-left px-2">Domisili</th>
                                <th class=" text-left px-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                            <tr class=" border ">
                                <td class=" px-2 text-left">{{ $index + 1 }}</td>
                                <td class=" px-2 text-left">{{ $user->name }}</td>
                                <td class=" px-2 text-left">{{ $user->email }}</td>
                                <td class=" px-2 text-left">
                                    @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                    @else
                                    <span class="text-muted">Belum ada role</span>
                                    @endif
                                </td>
                                <td class=" px-2 text-left">
                                    @php
                                    if ($user->regency?->name) {
                                    // Hilangkan 4 karakter pertama dan tambahkan 'Kabupaten '
                                    $wilayah = 'Kabupaten ' . ltrim(substr($user->regency->name, 4));
                                    } elseif ($user->district?->name) {
                                    // Tambahkan 'Kecamatan ' di depan nama
                                    $wilayah = 'Kecamatan ' . $user->district->name;
                                    } elseif ($user->village?->name) {
                                    $wilayah = $user->village->name;
                                    } elseif ($user->province?->name) {
                                    $wilayah = $user->province->name;
                                    } else {
                                    $wilayah = 'Tidak diketahui';
                                    }
                                    @endphp
                                    {{ $wilayah }}

                                </td>
                                @php
                                $isAdminProvinsi = auth()->user()->hasRole(['admin-provinsi', 'superAdmin']);
                                @endphp

                                <td class="px-2 text-left">
                                    <a
                                        href="{{ $isAdminProvinsi ? route('users.assign-role', $user) : '#' }}"
                                        class="inline-block px-2 py-1 rounded 
        {{ $isAdminProvinsi ? 'bg-yellow-500 hover:bg-yellow-600 text-white cursor-pointer' : 'bg-gray-300 text-gray-600 cursor-not-allowed' }}"
                                        @if(!$isAdminProvinsi)
                                        title="Hanya bisa diakses oleh admin-provinsi"
                                        onclick="event.preventDefault();"
                                        @endif>
                                        Atur Role
                                    </a>
                                </td>

                                <td class="px-2 text-left">
                                    @if($isAdminProvinsi)
                                    <form action="/users/reset-password" method="post">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ $user->email }}">
                                        <input type="hidden" name="password" value="{{ $user->password }}">
                                        <button class="bg-slate-500 hover:bg-slate-300 px-2 py-1  rounded-md text-white" type="submit">
                                            Reset Password
                                        </button>
                                    </form>
                                    @else
                                    <button
                                        class="bg-gray-300 text-gray-600 cursor-not-allowed px-2 py-1  rounded-md"
                                        title="Hanya bisa diakses oleh admin-provinsi"
                                        onclick="event.preventDefault();"
                                        disabled>
                                        Reset Password
                                    </button>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>