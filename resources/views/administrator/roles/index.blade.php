<x-app-layout>
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

    <x-slot name="header">
        @section('title', 'PW ' . $wilayah)

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Roles Management
                </h2>
                <p class="text-sm text-gray-500">
                    Kelola role dan permission pengguna sistem
                </p>
            </div>
        </div>
    </x-slot>

    {{-- HERO / WILAYAH CARD --}}
    <div class="mb-6">
        <div class="bg-gradient-to-r from-green-700 to-emerald-600 rounded-xl shadow-md p-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Wilayah Aktif</p>
                    <h3 class="text-xl font-bold uppercase">
                        {{ $wilayah }}
                    </h3>
                </div>
                <div class="text-right text-sm opacity-80">
                    {{ now()->format('d M Y') }}
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">

        {{-- HEADER ACTION --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">
                Daftar Roles
            </h3>

            <a href="{{ route('roles.create') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                + Buat Role Baru
            </a>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="text-left px-6 py-3">Nama Role</th>
                        <th class="text-left px-6 py-3">Permissions</th>
                        <th class="text-left px-6 py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($roles as $role)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                            {{ $role->name }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            <div class="flex flex-wrap gap-1">
                                @forelse($role->permissions as $perm)
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded-md">
                                    {{ $perm->name }}
                                </span>
                                @empty
                                <span class="text-gray-400">-</span>
                                @endforelse
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('roles.edit', $role) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                    Edit
                                </a>

                                <form action="{{ route('roles.destroy', $role) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus role ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                            Tidak ada data role
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TOAST --}}
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: "4000",
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