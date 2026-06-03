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

    $isAdmin = $auth->hasAnyRole([
    'admin-provinsi',
    'superAdmin',
    ]);

    $totalUsers = $users->count();

    $adminProvinsi = $users->filter(
    fn($u) => $u->hasRole('admin-provinsi')
    )->count();

    $adminKabupaten = $users->filter(
    fn($u) => $u->hasRole('admin-kabupaten')
    )->count();

    $adminKecamatan = $users->filter(
    fn($u) => $u->hasRole('admin-kecamatan')
    )->count();

    $noRole = $users->filter(
    fn($u) => $u->roles->count() === 0
    )->count();

    $tabs = [
    'all' => 'Semua User',
    'superAdmin' => 'Super Admin',
    'admin-provinsi' => 'Admin Provinsi',
    'admin-kabupaten' => 'Admin Kabupaten',
    'admin-kecamatan' => 'Admin Kecamatan',
    'Sekretaris-DPRW' => 'Sekretaris DPRW',
    'no-role' => 'Tanpa Role',
    ];
    @endphp

    <div
        x-data="{
            tab: 'all',
            showModal: false,
            resetEmail: '',
            resetPassword: '',
            waMessage: '',

            copyPassword() {
                navigator.clipboard.writeText(this.resetPassword)
                alert('Password berhasil dicopy')
            },

            copyWA() {
                navigator.clipboard.writeText(this.waMessage)
                alert('Pesan WhatsApp berhasil dicopy')
            }
        }"

        @if(session('reset_password_success'))
        x-init="
                showModal = true;
                resetEmail = '{{ session('reset_password_success.email') }}';
                resetPassword = '{{ session('reset_password_success.password') }}';

                waMessage =
`Assalamu'alaikum Wr. Wb.
Berikut akun login Anda untuk aplikasi {{$wilayah}}
untuk wilayah *{{ session('reset_password_success.wilayah') }}*.
Email: ${resetEmail}
Password Baru: ${resetPassword}
=============================
*Silakan login dan segera ganti password Anda demi keamanan akun.*
Terima kasih.
Wassalamu'alaikum Wr. Wb.`;
            "
        @endif>

        <x-slot name="header">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    User Management
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Wilayah aktif:
                    <span class="font-semibold text-emerald-700">
                        {{ $wilayah }}
                    </span>
                </p>
            </div>
        </x-slot>

        <div class="p-6 space-y-6">

            {{-- HERO --}}
            <div class="rounded-[2rem] bg-gradient-to-r from-emerald-700 via-green-700 to-teal-700 p-8 shadow-xl text-white">
                <div class="flex justify-between items-center">

                    <div>
                        <p class="uppercase tracking-[4px] text-xs opacity-80">
                            Dashboard User
                        </p>

                        <h1 class="text-3xl font-bold mt-2 uppercase">
                            PW {{ $wilayah }}
                        </h1>

                        <p class="mt-3 text-sm text-white/80">
                            Kelola akun pengguna wilayah secara terpusat.
                        </p>
                    </div>

                    <img
                        src="{{ asset('image/logo.png') }}"
                        alt="logo"
                        class="hidden lg:block w-24 h-24 object-contain">
                </div>
            </div>

            {{-- STATS --}}
            <div class="grid grid-cols-2 xl:grid-cols-5 gap-4">

                <div class="bg-white rounded-3xl border p-5 shadow-sm">
                    <p class="text-xs text-slate-500">Total User</p>
                    <h3 class="text-2xl font-bold mt-1">
                        {{ $totalUsers }}
                    </h3>
                </div>

                <div class="bg-white rounded-3xl border p-5 shadow-sm">
                    <p class="text-xs text-slate-500">Admin Provinsi</p>
                    <h3 class="text-2xl font-bold mt-1 text-green-700">
                        {{ $adminProvinsi }}
                    </h3>
                </div>

                <div class="bg-white rounded-3xl border p-5 shadow-sm">
                    <p class="text-xs text-slate-500">Admin Kabupaten</p>
                    <h3 class="text-2xl font-bold mt-1 text-blue-700">
                        {{ $adminKabupaten }}
                    </h3>
                </div>

                <div class="bg-white rounded-3xl border p-5 shadow-sm">
                    <p class="text-xs text-slate-500">Admin Kecamatan</p>
                    <h3 class="text-2xl font-bold mt-1 text-amber-600">
                        {{ $adminKecamatan }}
                    </h3>
                </div>

                <div class="bg-white rounded-3xl border p-5 shadow-sm">
                    <p class="text-xs text-slate-500">Tanpa Role</p>
                    <h3 class="text-2xl font-bold mt-1 text-red-600">
                        {{ $noRole }}
                    </h3>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="bg-white rounded-[2rem] border shadow-sm overflow-hidden">

                <div class="p-5 border-b flex justify-between items-center">

                    <div>
                        <h3 class="text-lg font-bold text-slate-800">
                            Daftar User
                        </h3>

                        <p class="text-xs text-slate-500">
                            Kelola user berdasarkan role dan wilayah
                        </p>
                    </div>

                    @if($isAdmin)
                    <a
                        href="{{ route('users.create') }}"
                        class="px-4 py-2 rounded-2xl bg-green-600 hover:bg-green-700 text-white text-sm font-semibold">
                        + Tambah User
                    </a>
                    @endif
                </div>

                {{-- FILTER --}}
                <div class="p-4 border-b bg-slate-50 flex flex-wrap gap-2">
                    @foreach($tabs as $key => $label)
                    <button
                        @click="tab = '{{ $key }}'"
                        :class="tab === '{{ $key }}'
                                ? 'bg-green-600 text-white'
                                : 'bg-white border text-slate-700'"
                        class="px-4 py-2 rounded-xl text-xs font-medium">

                        {{ $label }}
                    </button>
                    @endforeach
                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full min-w-[900px]">

                        <thead class="bg-slate-50 border-b text-[11px] uppercase text-slate-500">
                            <tr>
                                <th class="px-5 py-4 text-left">Nama</th>
                                <th class="px-5 py-4 text-left">Informasi</th>
                                <th class="px-5 py-4 text-center">Aksi</th>
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
                            ? (
                            Str::startsWith($u->regency->name, 'Kab.')
                            ? 'Kabupaten ' . substr($u->regency->name, 4)
                            : $u->regency->name
                            )
                            : (
                            $u->district?->name
                            ? 'Kec. ' . $u->district->name
                            : ($u->village?->name ?? ($u->province?->name ?? '-'))
                            );
                            @endphp

                            <tr
                                x-show="tab === 'all' || tab === '{{ $showRole }}'"
                                class="hover:bg-slate-50">

                                <td class="px-5 py-4">
                                    <div class="font-semibold text-sm text-slate-800">
                                        {{ $u->name }}
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-xs text-slate-600">

                                    {{ $u->email }}

                                    <br>

                                    @forelse($u->roles as $role)
                                    <span class="inline-block mt-1 px-2 py-1 rounded-full bg-green-100 text-green-700 text-[10px]">
                                        {{ $role->name }}
                                    </span>
                                    @empty
                                    <span class="inline-block mt-1 px-2 py-1 rounded-full bg-red-100 text-red-600 text-[10px]">
                                        No Role
                                    </span>
                                    @endforelse

                                    <div class="text-[11px] text-slate-400 mt-1">
                                        {{ $wil }}
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex justify-center gap-2 flex-wrap">

                                        <a
                                            href="{{ route('users.profile.edit', $u->id) }}"
                                            class="px-3 py-2 rounded-xl bg-blue-600 text-white text-[11px]">
                                            Profil
                                        </a>

                                        <a
                                            href="{{ route('users.assign-role', $u) }}"
                                            class="px-3 py-2 rounded-xl bg-yellow-500 text-white text-[11px]">
                                            Role
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('users.reset-password') }}">

                                            @csrf

                                            <input
                                                type="hidden"
                                                name="email"
                                                value="{{ $u->email }}">

                                            <button
                                                type="submit"
                                                class="px-3 py-2 rounded-xl bg-slate-700 text-white text-[11px]">
                                                Reset
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
        </div>

        {{-- MODAL RESET PASSWORD --}}
        <div
            x-show="showModal"
            x-transition
            class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-5">

            <div
                @click.outside="showModal = false"
                class="bg-white w-full max-w-lg rounded-[2rem] p-6 shadow-2xl">

                <h2 class="text-xl font-bold text-slate-800">
                    Password Berhasil Direset
                </h2>

                <div class="mt-5 space-y-4">

                    <div>
                        <label class="text-sm font-medium">
                            Email
                        </label>

                        <input
                            type="text"
                            x-model="resetEmail"
                            readonly
                            class="w-full mt-1 rounded-xl border text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Password Baru
                        </label>

                        <div class="flex gap-2 mt-1">
                            <input
                                type="text"
                                x-model="resetPassword"
                                readonly
                                class="flex-1 rounded-xl border text-sm">

                            <button
                                @click="copyPassword()"
                                class="px-4 rounded-xl bg-blue-600 text-white text-sm">
                                Copy
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Pesan WhatsApp
                        </label>

                        <textarea
                            x-model="waMessage"
                            rows="10"
                            class="w-full rounded-xl border text-sm"></textarea>

                        <button
                            @click="copyWA()"
                            class="mt-3 w-full py-3 rounded-xl bg-green-600 text-white font-semibold">
                            Copy Pesan WhatsApp
                        </button>
                    </div>

                    <button
                        @click="showModal = false"
                        class="w-full py-3 rounded-xl bg-slate-700 text-white">
                        Tutup
                    </button>

                </div>
            </div>
        </div>

    </div>

</x-app-layout>