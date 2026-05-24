<x-app-layout>

    @php

    $auth = auth()->user();
    $wilayah = 'Tidak diketahui';

    if ($auth->regency?->name) {
    $wilayah = Str::startsWith($auth->regency->name, 'Kab.')
    ? 'Kabupaten ' . substr($auth->regency->name, 4)
    : $auth->regency->name;
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
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <h2 class="text-xl font-bold text-gray-800">
                Manajemen User
                <span class="text-green-700">({{ $wilayah }})</span>
            </h2>
        </div>
    </x-slot>

    {{-- CARD --}}
    <div class="max-w-7xl mx-auto px-4 py-4">

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

        {{-- CONTENT --}}
        <div class="mt-4 bg-white shadow rounded-xl p-6 border border-gray-100">

            <div class="flex justify-between items-center mb-4">

                <h2 class="text-lg font-semibold text-gray-800">
                    Assign Role: <span class="text-green-700">{{ $user->name }}</span>
                </h2>

                {{-- 🔵 KEMBALI BUTTON --}}
                <a href="{{ url('/users/assign-role') }}"
                    class="px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded text-sm">
                    ← Kembali
                </a>

            </div>

            @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-700 border border-green-300">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('users.assign-role.update', $user) }}" method="POST">
                @csrf

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Role
                </label>

                <select name="role"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">

                    <option value="" disabled {{ $user->roles->isEmpty() ? 'selected' : '' }}>
                        -- Pilih Role --
                    </option>

                    @foreach($roles as $role)
                    <option value="{{ $role->name }}"
                        {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                    @endforeach

                </select>

                @error('role')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror

                <div class="mt-5 flex gap-3">
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</x-app-layout>