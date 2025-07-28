<x-app-layout>
    <x-slot name="header">
        @php
        $user = auth()->user();
        $wilayah = 'Tidak diketahui';

        if ($user->regency?->name) {
        $wilayah = Str::startsWith($user->regency->name, 'Kab.')
        ? 'Kabupaten ' . ltrim(substr($user->regency->name, 4))
        : $user->regency->name;
        } elseif ($user->district?->name) {
        $wilayah = 'Kec. ' . $user->district->name;
        } elseif ($user->village?->name) {
        $wilayah = $user->village->name;
        } elseif ($user->province?->name) {
        $wilayah = $user->province->name;
        }
        @endphp

        @section('title', 'PW ' . $wilayah)

        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Detail - <span class="text-green-700">PW {{ $wilayah }}</span>
            </h2>
        </div>
    </x-slot>

    <!-- Wilayah Card -->
    <div class="mb-4  bg-green-800 rounded-md shadow-md flex items-center">
        <div class="bg-green-800 p-2 rounded-md">
            <img src="{{ asset('image/logo.png') }}" alt="Logo" width="50">
        </div>
        <div class="ml-4 text-white">
            <h3 class="uppercase text-lg font-semibold">PW {{ $wilayah }}</h3>
        </div>
    </div>

    <!-- Detail Pengamal -->
    <div class="bg-white p-4 rounded-md shadow-md">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Foto -->
            <div class="md:w-1/4 w-full flex items-center justify-center">
                @if ($pengamal->foto && Storage::disk('public')->exists($pengamal->foto))
                <img src="{{ asset('storage/' . $pengamal->foto) }}" alt="Foto Pengamal" class="w-48 h-48 object-cover rounded shadow">
                @else
                <img src="{{ asset('image/foto.png') }}" alt="Foto Default" class="w-48 h-48 object-cover rounded shadow">
                @endif
            </div>

            <!-- Info -->
            <div class="md:w-3/4 w-full">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Data Pribadi</h3>

                @php
                $rows = [
                'NIK' => substr($pengamal->nik, 0, 4) . str_repeat('*', strlen($pengamal->nik) - 4),
                'Nama' => $pengamal->nama_lengkap,
                'Agama' => $pengamal->agama,
                'Tempat Lahir' => $pengamal->tempat_lahir,
                'Tanggal Lahir' => $pengamal->tanggal_lahir,
                'Jenis Kelamin' => $pengamal->jenis_kelamin,
                'Pekerjaan' => $pengamal->pekerjaan,
                'Status' => $pengamal->status_perkawinan,
                'Provinsi' => $pengamal->province->name ?? '-',
                'Kabupaten' => $pengamal->regency->name ?? '-',
                'Kecamatan' => $pengamal->district->name ?? '-',
                'Desa' => $pengamal->village->name ?? '-',
                'RT / RW' => 'RT ' . ($pengamal->rt ?? '-') . ', RW ' . ($pengamal->rw ?? '-'),
                'Usia' => \Carbon\Carbon::parse($pengamal->tanggal_lahir)->age . ' tahun'
                ];
                @endphp

                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    @foreach ($rows as $label => $value)
                    <div class="flex">
                        <div class=" w-28 font-medium text-gray-600">{{ $label }}</div>
                        <div class="w-3 text-gray-600">:</div>
                        <div class="text-gray-800">{{ $value }}</div>
                    </div>
                    @endforeach
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-6 flex flex-wrap gap-2">
                    <a href="/pengamal/edit/{{ $pengamal->id }}">
                        <button class="px-4 py-1 text-white bg-blue-500 rounded hover:bg-blue-600">Edit</button>
                    </a>
                    <a href="/pengamal">
                        <button class="px-4 py-1 text-white bg-gray-500 rounded hover:bg-gray-600">Kembali</button>
                    </a>

                    @php
                    $canDelete = auth()->user()->hasAnyRole(['superAdmin', 'admin-provinsi', 'admin-kabupaten']);
                    @endphp

                    <form action="/pengamal/show/{{ $pengamal->id }}" method="POST" class="form-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-1 text-white rounded {{ $canDelete ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-400 cursor-not-allowed' }}"
                            {{ $canDelete ? '' : 'disabled' }}>
                            Hapus
                        </button>
                    </form>

                    <a href="https://wa.me/{{ $pengamal->no_hp }}?text=Halo%20saya%20tertarik%20dengan%20layanan%20Anda"
                        target="_blank"
                        class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">
                        WA
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.form-delete').on('submit', function(e) {
                e.preventDefault();
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
</x-app-layout>