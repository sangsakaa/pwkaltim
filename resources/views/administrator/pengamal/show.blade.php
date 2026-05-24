<x-app-layout>

    @php
    $user = auth()->user();
    $wilayah = 'Pendaftaran Pengamal';

    if ($user) {
    if ($user->regency?->name) {
    $wilayah = \Illuminate\Support\Str::startsWith($user->regency->name, 'Kab.')
    ? 'Kabupaten ' . ltrim(substr($user->regency->name, 4))
    : $user->regency->name;
    } elseif ($user->district?->name) {
    $wilayah = 'Kecamatan ' . $user->district->name;
    } elseif ($user->village?->name) {
    $wilayah = $user->village->name;
    } elseif ($user->province?->name) {
    $wilayah = $user->province->name;
    }
    }

    $isPublic = !auth()->check();

    // NIK MASKING
    $nikMasked = $pengamal->nik
    ? substr($pengamal->nik, 0, 4) .
    str_repeat('*', max(strlen($pengamal->nik) - 4, 0))
    : '-';

    // TTL
    $ttl = '-';

    if ($pengamal->tempat_lahir || $pengamal->tanggal_lahir) {
    $tempat = $pengamal->tempat_lahir ?? '-';

    $tanggal = $pengamal->tanggal_lahir
    ? \Carbon\Carbon::parse($pengamal->tanggal_lahir)
    ->translatedFormat('d F Y')
    : '-';

    $ttl = $tempat . ', ' . $tanggal;
    }

    // USIA
    $usia = $pengamal->tanggal_lahir
    ? \Carbon\Carbon::parse($pengamal->tanggal_lahir)->age . ' Tahun'
    : '-';

    // RT RW
    $rtRw =
    $pengamal->rt || $pengamal->rw
    ? 'RT ' .
    ($pengamal->rt ?? '-') .
    ' / RW ' .
    ($pengamal->rw ?? '-')
    : '-';

    $rows = [
    'NIK' => $nikMasked,
    'Nama Lengkap' => $pengamal->nama_lengkap ?? '-',
    'Agama' => $pengamal->agama ?? '-',
    'Tempat, Tanggal Lahir' => $ttl,
    'Jenis Kelamin' => $pengamal->jenis_kelamin ?? '-',
    'Pekerjaan' => $pengamal->pekerjaan ?? '-',
    'Status Perkawinan' => $pengamal->status_perkawinan ?? '-',
    'Provinsi' => $pengamal->province->name ?? '-',
    'Kabupaten' => $pengamal->regency->name ?? '-',
    'Kecamatan' => $pengamal->district->name ?? '-',
    'Desa' => $pengamal->village->name ?? '-',
    'RT / RW' => $rtRw,
    'Usia' => $usia,
    'Alamat' => $pengamal->alamat ?? '-',
    'No HP' => $pengamal->no_hp ?? '-',
    'Email' => $pengamal->email ?? '-',
    ];
    @endphp

    @section('title', $isPublic ? 'Detail Pengamal' : 'PW ' . $wilayah)

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="text-xl font-bold text-gray-800">
                Detail Pengamal
                @if (!$isPublic)
                -
                <span class="text-green-700">
                    {{ $wilayah }}
                </span>
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="space-y-4">

        {{-- HEADER CARD --}}
        <div
            class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-xl shadow-md flex items-center overflow-hidden">

            <div class="bg-green-900 p-3 flex items-center justify-center">
                <img src="{{ asset('image/logo.png') }}"
                    width="50">
            </div>

            <div class="p-4">
                <h3 class="text-lg font-bold uppercase">
                    {{ $isPublic ? 'Pendaftaran Pengamal' : 'PW ' . $wilayah }}
                </h3>

                <p class="text-sm text-green-100">
                    Detail Data Pengamal
                </p>
            </div>
        </div>

        {{-- MAIN CARD --}}
        <div class="bg-white rounded-xl shadow-md p-6">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- FOTO --}}
                <div class="flex justify-center lg:justify-start">

                    <div
                        class="w-48 h-48 rounded-xl overflow-hidden border shadow-sm">

                        @if ($pengamal->foto &&
                        Storage::disk('public')->exists($pengamal->foto))
                        <img src="{{ asset('storage/' . $pengamal->foto) }}"
                            class="w-full h-full object-cover">
                        @else
                        <img src="{{ asset('image/foto.png') }}"
                            class="w-full h-full object-cover">
                        @endif

                    </div>

                </div>

                {{-- DATA --}}
                <div class="lg:col-span-2">

                    <h3
                        class="text-lg font-bold text-gray-800 mb-4">
                        Data Pengamal
                    </h3>

                    <div
                        class="grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">

                        @foreach ($rows as $label => $value)
                        <div class="flex gap-2">

                            <div
                                class="w-40 text-gray-500 font-medium">
                                {{ $label }}
                            </div>

                            <div
                                class="text-gray-800 font-semibold">
                                {{ $value }}
                            </div>

                        </div>
                        @endforeach

                    </div>

                    {{-- ACTION --}}
                    <div class="flex flex-wrap gap-2 mt-6">

                        {{-- ADMIN ONLY --}}
                        @auth

                        <a href="/pengamal/edit/{{ $pengamal->id }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Edit
                        </a>

                        <a href="/pengamal"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                            Kembali
                        </a>

                        @php
                        $canDelete = auth()->user()?->hasAnyRole([
                        'superAdmin',
                        'admin-provinsi',
                        'admin-kabupaten',
                        ]);
                        @endphp

                        <form action="/pengamal/show/{{ $pengamal->id }}"
                            method="POST"
                            class="form-delete">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="px-4 py-2 rounded-lg text-white transition
                                    {{ $canDelete ? 'bg-red-600 hover:bg-red-700' : 'bg-gray-400 cursor-not-allowed' }}"
                                {{ $canDelete ? '' : 'disabled' }}>

                                Hapus

                            </button>

                        </form>

                        @endauth

                        {{-- WHATSAPP --}}
                        @if ($pengamal->no_hp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengamal->no_hp) }}"
                            target="_blank"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">

                            WhatsApp

                        </a>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>