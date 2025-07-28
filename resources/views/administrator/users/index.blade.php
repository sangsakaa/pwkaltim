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

        </div>
    </x-slot>

    <div class=" gap-2 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
        <div class="   overflow-hidden bg-white rounded-md shadow-md sm:dark:bg-gray-800 sm:dark:text-gray-200">
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
    <div class="  p-2 mt-2 overflow-hidden bg-white rounded-md shadow-md sm:dark:bg-gray-800 sm:dark:text-gray-200">
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
                    <!-- <x-heroicon-o-trash class="w-4 h-4" aria-hidden="true" /> -->
                    <span class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                        user
                    </span>
                </a>
            </div>
        </div>
        <div>
            <div class=" overflow-auto">
                <div class="container">
                    <div>
                        @if(session('reset_password_success'))
                        <div class="p-3 bg-green-100 border border-green-400 text-green-800 rounded mb-3">
                            <strong>Password berhasil di-reset!</strong><br>
                            Email: {{ session('reset_password_success')['email'] }}<br>
                            Password Baru: <code>{{ session('reset_password_success')['password'] }}</code><br>
                            <em>Silakan catat password ini karena tidak akan ditampilkan lagi.</em>
                        </div>
                        @endif
                    </div>
                    <table class="table table-bordered table-striped w-full">
                        <thead>
                            <tr class=" border bg-green-800 text-white ">
                                <th class=" text-left px-2 py-2">No</th>
                                <th class=" text-left px-2">Nama</th>
                                <th class=" text-left px-2">Email</th>
                                <th class=" text-left px-2">Role</th>
                                <th class=" text-left px-2">Domisili</th>
                                <th class=" text-center px-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                            <tr class=" border hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class=" px-2 py-2 text-left">{{ $index + 1 }}</td>
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

                                <td class="px-2 py-2 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        @php
                                        $isAdminProvinsi = auth()->user()->hasRole(['admin-provinsi', 'superAdmin']);
                                        @endphp
                                        <a
                                            href="{{ $isAdminProvinsi ? route('users.assign-role', $user) : '#' }}"
                                            class=" px-2 py-1 rounded 
        {{ $isAdminProvinsi ? 'bg-yellow-500 hover:bg-yellow-600 text-white cursor-pointer' : 'bg-gray-300 text-gray-600 cursor-not-allowed' }}"
                                            @if(!$isAdminProvinsi)
                                            title="Hanya bisa diakses oleh admin-provinsi"
                                            onclick="event.preventDefault();"
                                            @endif>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                        </a>
                                        @if($isAdminProvinsi)
                                        <form action="/users/reset-password" method="post">
                                            @csrf
                                            <input type="hidden" name="email" value="{{ $user->email }}">
                                            <button class="bg-slate-500 hover:bg-slate-300 px-2 py-1 rounded-md text-white" type="submit" title="Reset Password">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                </svg>
                                            </button>
                                        </form>

                                        @else
                                        <button
                                            class="bg-gray-300 text-gray-600 cursor-not-allowed px-2 py-1  rounded-md"
                                            title="Hanya bisa diakses oleh admin-provinsi"
                                            onclick="event.preventDefault();"
                                            disabled>

                                        </button>
                                        @endif
                                        <form action="{{ route('users.remove-role-permission', $user->id) }}" method="POST" class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-gray-300 text-gray-600 px-2 py-1 rounded-md" title="hapus role">
                                                <span class=" flex">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                                    </svg>

                                                </span>
                                            </button>
                                        </form>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="form-delete">
                                            @csrf
                                            @method('DELETE')

                                            @php
                                            $canDelete = auth()->user()->hasAnyRole(['superAdmin', 'admin-provinsi']);
                                            @endphp

                                            <button
                                                type="submit"
                                                class="px-2 py-1 text-white rounded transition
            {{ $canDelete ? 'bg-red-500 hover:bg-red-600' : 'bg-slate-500 cursor-not-allowed' }}" title="hapus user"
                                                {{ $canDelete ? '' : 'disabled' }}>

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>

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
    </div>

</x-app-layout>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.form-delete').on('submit', function(e) {
            e.preventDefault(); // Cegah langsung submit form

            const form = this;

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    toastr.info('Penghapusan dibatalkan.');
                }
            });
        });
    });
</script>