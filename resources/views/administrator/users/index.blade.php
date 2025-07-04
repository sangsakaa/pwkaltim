<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
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
                <div>
                    <img src="{{ asset('image/logofont.jpg') }}" width="200" alt="Logo">
                </div>
                <div class=" w-full flex items-center justify-center">
                    <marquee behavior="scroll" direction="left">
                        Selamat datang di website kami!
                    </marquee>
                </div>
            </div>
        </div>
    </div>
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <div class="  flex justify-between items-center ">
            <a href="/users/create">tambah user</a>
        </div>
        <div>
            <div class=" overflow-auto">
                <div class="container">
                    <h2>Daftar User</h2>

                    <table class="table table-bordered table-striped w-full">
                        <thead>
                            <tr class=" border ">
                                <th class=" text-left px-2">No</th>
                                <th class=" text-left px-2">Nama</th>
                                <th class=" text-left px-2">Email</th>
                                <th class=" text-left px-2">Role</th>
                                <th class=" text-left px-2">Domisil</th>
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
                                <td class=" px-2 text-left">
                                    <a href="{{ route('users.assign-role', $user) }}" class="btn btn-sm btn-warning">
                                        Atur Role
                                    </a>
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