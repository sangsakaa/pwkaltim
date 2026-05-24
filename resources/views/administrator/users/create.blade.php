<x-app-layout>

    @php
    $auth = auth()->user();

    $wilayah = 'Tidak diketahui';

    if ($auth->regency?->name) {
    if (Str::startsWith($auth->regency->name, 'Kab.')) {
    $wilayah = 'Kabupaten ' . ltrim(substr($auth->regency->name, 4));
    } else {
    $wilayah = $auth->regency->name;
    }
    } elseif ($auth->district?->name) {
    $wilayah = 'Kec. ' . $auth->district->name;
    } elseif ($auth->village?->name) {
    $wilayah = $auth->village->name;
    } elseif ($auth->province?->name) {
    $wilayah = $auth->province->name;
    }
    @endphp

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="text-xl font-bold text-gray-800">
                Tambah User
                <span class="text-green-700">({{ $wilayah }})</span>
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-4">

        {{-- CARD HEADER --}}
        <div class="bg-white shadow rounded-xl overflow-hidden border border-green-100">

            <div class="flex items-center bg-green-700 text-white">
                <div class="p-3 bg-green-800">
                    <img src="{{ asset('image/logo.png') }}" width="50">
                </div>

                <div class="px-4 font-bold uppercase">
                    PW {{ $wilayah }}
                </div>
            </div>

        </div>

        {{-- FORM --}}
        <div class="mt-4 bg-white shadow rounded-xl p-6 border border-gray-100">

            <h2 class="text-lg font-semibold mb-4 text-gray-800">
                Form Tambah User
            </h2>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="text-sm font-medium">Nama</label>
                    <input type="text" name="name"
                        class="w-full border rounded px-3 py-2"
                        value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="text-sm font-medium">Email</label>
                    <input type="email" name="email"
                        class="w-full border rounded px-3 py-2"
                        value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="text-sm font-medium">Kode Daerah</label>
                    <input type="text" name="code"
                        class="w-full border rounded px-3 py-2"
                        value="{{ old('code') }}" required>

                    @error('code')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                    <div>
                        <label class="text-sm font-medium">Password</label>
                        <input type="password" name="password"
                            class="w-full border rounded px-3 py-2"
                            required>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full border rounded px-3 py-2"
                            required>
                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="flex gap-2 mt-5">

                    <a href="{{ route('users.assign-role-index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Kembali
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>