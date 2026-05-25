<x-app-layout>

    @php
    $auth = auth()->user();
    $wilayah = 'Tidak diketahui';

    if ($auth->regency?->name) {
    $wilayah = Str::startsWith($auth->regency->name, 'Kab.')
    ? 'Kabupaten ' . ltrim(substr($auth->regency->name, 4))
    : $auth->regency->name;
    } elseif ($auth->district?->name) {
    $wilayah = 'Kecamatan ' . $auth->district->name;
    } elseif ($auth->village?->name) {
    $wilayah = $auth->village->name;
    } elseif ($auth->province?->name) {
    $wilayah = $auth->province->name;
    }
    @endphp

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold text-gray-800">
                Tambah User
                <span class="text-green-600 font-semibold">({{ $wilayah }})</span>
            </h2>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 py-6 space-y-6">

        {{-- HERO CARD --}}
        <div class="rounded-2xl overflow-hidden shadow-md bg-gradient-to-r from-green-700 to-green-500 text-white">

            <div class="flex items-center gap-4 p-5">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('image/logo.png') }}" class="w-8 h-8">
                </div>

                <div>
                    <h3 class="text-lg font-bold uppercase">
                        PW {{ $wilayah }}
                    </h3>
                    <p class="text-sm text-white/80">
                        Form pembuatan user baru sistem
                    </p>
                </div>
            </div>

        </div>

        {{-- FORM CARD --}}
        <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">

            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800">
                    Form Tambah User
                </h2>
                <p class="text-sm text-gray-500">
                    Isi data dengan benar untuk membuat akun baru
                </p>
            </div>

            <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                {{-- GRID --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- NAME --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name"
                            value="{{ old('name') }}"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200"
                            placeholder="Nama lengkap" required>
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email"
                            value="{{ old('email') }}"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200"
                            placeholder="email@domain.com" required>
                    </div>

                    {{-- CODE --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Kode Daerah</label>
                        <input type="text" name="code"
                            value="{{ old('code') }}"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200"
                            placeholder="Contoh: KT-01" required>

                        @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- EMPTY SLOT (for balance layout) --}}
                    <div></div>

                    {{-- PASSWORD --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200"
                            placeholder="••••••••" required>
                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200"
                            placeholder="••••••••" required>
                    </div>

                </div>

                {{-- ACTION BUTTON --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t">

                    <a href="{{ route('users.assign-role-index') }}"
                        class="px-5 py-2.5 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 text-center transition">
                        Kembali
                    </a>

                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-green-600 text-white hover:bg-green-700 shadow-sm transition">
                        Simpan User
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>