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
                @section('title', 'PW '. $wilayah .' - User Management' )
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between ">
                    <h2 class="text-xl font-semibold leading-tight">
                        {{ __('User Management') }}
                    </h2>
                </div>
            </h2>
        </div>
    </x-slot>
    <div class=" gap-2 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
        <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md">
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
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md">
        <div class="  flex justify-between items-center ">

        </div>
        <div>
            <div class=" overflow-auto">
                <div class="container">
                    <div class="container px-2">
                        <h2>Tambah User</h2>

                        <form action="/users/create" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" name="name" class=" w-full rounded-md px-2 form-control" value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class=" w-full rounded-md px-2 form-control" value="{{ old('email') }}" required>
                            </div>
                            <div>
                                <label for="code">Kode Daerah</label>
                                <input type="text" name="code" class=" w-full rounded-md px-2" value="{{ old('code') }}" required>
                                @error('code') <div>{{ $message }}</div> @enderror
                            </div>

                            <div class=" grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" class=" w-full rounded-md px-2 form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class=" w-full rounded-md px-2 form-control" required>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a
                                    href="/users/assign-role"
                                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Kembali
                                </a>

                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    Simpan
                                </button>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>