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
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    User Management
                </h2>
                <p class="text-sm text-gray-500">
                    Wilayah: <span class="font-semibold text-green-700">{{ $wilayah }}</span>
                </p>
            </div>

        </div>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- HERO CARD --}}
        <div class="bg-gradient-to-r from-green-700 to-emerald-600 text-white rounded-xl shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-80">Wilayah Aktif</p>
                    <h3 class="text-lg font-bold uppercase">
                        PW {{ $wilayah }}
                    </h3>
                </div>

                <img src="{{ asset('image/logo.png') }}" class="w-12 h-12">
            </div>
        </div>

        {{-- ACTION BAR --}}
        <div class="bg-white rounded-xl shadow-sm border p-4 flex justify-between items-center">

            <div class="font-semibold text-gray-700">
                Daftar User
            </div>

            @php
            $isAdmin = auth()->user()->hasAnyRole(['admin-provinsi','superAdmin']);
            @endphp

            <a href="{{ $isAdmin ? '/users/create' : '#' }}"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition
               {{ $isAdmin ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}"
                @if(!$isAdmin) onclick="event.preventDefault();" @endif>
                + Tambah User
            </a>

        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow-sm border overflow-x-auto">

            {{-- USER ROLE TABS --}}
            <div
                x-data="{ tab: 'all' }"
                class="bg-white rounded-xl shadow-sm border overflow-hidden">

                {{-- HEADER TABS --}}
                <div class="border-b bg-gray-50 p-4 flex flex-wrap gap-2">

                    <button
                        @click="tab='all'"
                        :class="tab==='all'
                ? 'bg-green-600 text-white'
                : 'bg-gray-100 text-gray-700'"
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Semua User
                    </button>

                    <button
                        @click="tab='admin-kabupaten'"
                        :class="tab==='admin-kabupaten'
                ? 'bg-green-600 text-white'
                : 'bg-gray-100 text-gray-700'"
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Admin Kabupaten
                    </button>

                    <button
                        @click="tab='admin-kecamatan'"
                        :class="tab==='admin-kecamatan'
                ? 'bg-green-600 text-white'
                : 'bg-gray-100 text-gray-700'"
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Admin Kecamatan
                    </button>

                    <button
                        @click="tab='Sekretaris-DPRW'"
                        :class="tab==='Sekretaris-DPRW'
                ? 'bg-green-600 text-white'
                : 'bg-gray-100 text-gray-700'"
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Sekretaris DPRW
                    </button>

                    <button
                        @click="tab='no-role'"
                        :class="tab==='no-role'
                ? 'bg-green-600 text-white'
                : 'bg-gray-100 text-gray-700'"
                        class="px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Tanpa Role
                    </button>

                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="p-3 text-left">Nama</th>
                                <th class="p-3 text-left">Email</th>
                                <th class="p-3 text-left">Role</th>
                                <th class="p-3 text-left">Wilayah</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                            @foreach($users as $u)

                            @php
                            $roles = $u->roles->pluck('name')->toArray();

                            $showRole = count($roles)
                            ? $roles[0]
                            : 'no-role';

                            $wil = $u->regency?->name
                            ? (Str::startsWith($u->regency->name,'Kab.')
                            ? 'Kabupaten '.substr($u->regency->name,4)
                            : $u->regency->name)
                            : ($u->district?->name
                            ? 'Kec. '.$u->district->name
                            : ($u->village?->name
                            ?? ($u->province?->name ?? '-')));
                            @endphp

                            <tr
                                x-show="tab === 'all' || tab === '{{ $showRole }}'"
                                class="hover:bg-gray-50 transition">

                                {{-- Nama --}}
                                <td class="p-3 font-medium text-gray-800">
                                    {{ $u->name }}
                                </td>

                                {{-- Email --}}
                                <td class="p-3 text-gray-600">
                                    {{ $u->email }}
                                </td>

                                {{-- Role --}}
                                <td class="p-3">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($u->roles as $role)
                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                            {{ $role->name }}
                                        </span>
                                        @empty
                                        <span class="text-xs text-gray-400">
                                            No Role
                                        </span>
                                        @endforelse
                                    </div>
                                </td>

                                {{-- Wilayah --}}
                                <td class="p-3 text-gray-600">
                                    {{ $wil }}
                                </td>

                                {{-- Aksi --}}
                                <td class="p-3">
                                    <div class="flex justify-center gap-2 flex-wrap">

                                        <a href="{{ route('users.assign-role',$u) }}"
                                            class="px-2 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded text-xs">
                                            Role
                                        </a>

                                        <form method="POST" action="/users/reset-password">
                                            @csrf
                                            <input
                                                type="hidden"
                                                name="email"
                                                value="{{ $u->email }}">

                                            <button
                                                class="px-2 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded text-xs">
                                                Reset
                                            </button>
                                        </form>

                                        @php
                                        $canDelete = auth()->user()
                                        ->hasAnyRole([
                                        'superAdmin',
                                        'admin-provinsi'
                                        ]);
                                        @endphp

                                        <form
                                            method="POST"
                                            action="{{ route('users.destroy',$u->id) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="px-2 py-1 text-xs text-white rounded
                                    {{ $canDelete
                                        ? 'bg-red-500 hover:bg-red-600'
                                        : 'bg-gray-400 cursor-not-allowed' }}"
                                                {{ $canDelete ? '' : 'disabled' }}>
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                            @endforeach

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
                    timeOut: 4000,
                };
            </script>

            {{-- RESET PASSWORD POPUP --}}
            @if(session('reset_password_success'))
            <script>
                const data = @json(session('reset_password_success'));

                toastr.success(
                    `Email: ${data.email}<br>Password: <b>${data.password}</b><br><small>Disarankan segera dicatat</small>`,
                    "Password Baru", {
                        escapeHtml: false,
                        timeOut: 8000
                    }
                );
            </script>
            @endif
            @if(session('reset_password_success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const data = @json(session('reset_password_success'));

                    setTimeout(() => {
                        toastr.success(
                            `Email: ${data.email}<br>Password: <b>${data.password}</b>`,
                            "Password Baru", {
                                escapeHtml: false,
                                timeOut: 8000
                            }
                        );
                    }, 300);
                });
            </script>
            @endif
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</x-app-layout>