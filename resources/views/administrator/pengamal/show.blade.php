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
    ? substr($pengamal->nik, 0, 4) . str_repeat('*', max(strlen($pengamal->nik) - 4, 0))
    : '-';

    // TTL
    $ttl = $pengamal->tempat_lahir || $pengamal->tanggal_lahir
    ? ($pengamal->tempat_lahir ?? '-') . ', ' .
    ($pengamal->tanggal_lahir
    ? \Carbon\Carbon::parse($pengamal->tanggal_lahir)->translatedFormat('d F Y')
    : '-')
    : '-';

    // USIA
    $usia = $pengamal->tanggal_lahir
    ? \Carbon\Carbon::parse($pengamal->tanggal_lahir)->age . ' Tahun'
    : '-';

    $rtRw = ($pengamal->rt || $pengamal->rw)
    ? 'RT ' . ($pengamal->rt ?? '-') . ' / RW ' . ($pengamal->rw ?? '-')
    : '-';

    $rows = [
    'NIK' => $nikMasked,
    'Nama' => $pengamal->nama_lengkap ?? '-',
    'Agama' => $pengamal->agama ?? '-',
    'TTL' => $ttl,
    'Jenis Kelamin' => $pengamal->jenis_kelamin ?? '-',
    'Pekerjaan' => $pengamal->pekerjaan ?? '-',
    'Status' => $pengamal->status_perkawinan ?? '-',
    'Provinsi' => $pengamal->province->name ?? '-',
    'Kabupaten' => $pengamal->regency->name ?? '-',
    'Kecamatan' => $pengamal->district->name ?? '-',
    'Desa' => $pengamal->village->name ?? '-',
    'RT/RW' => $rtRw,
    'Usia' => $usia,
    'Alamat' => $pengamal->alamat ?? '-',
    'HP' => $pengamal->no_hp ?? '-',
    'Email' => $pengamal->email ?? '-',
    ];
    @endphp

    @section('title', $isPublic ? 'Detail Pengamal' : 'PW ' . $wilayah)

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="text-xl font-bold text-gray-800">
                Detail Pengamal
                @if(!$isPublic)
                <span class="text-green-600 font-semibold">• {{ $wilayah }}</span>
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6">

        {{-- HERO CARD --}}
        <div class="relative overflow-hidden rounded-2xl shadow-lg bg-gradient-to-r from-green-700 to-green-500 text-white">

            <div class="flex items-center gap-4 p-6">
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('image/logo.png') }}" class="w-10 h-10">
                </div>

                <div>
                    <h3 class="text-lg font-bold uppercase">
                        {{ $isPublic ? 'Pendaftaran Pengamal' : 'PW ' . $wilayah }}
                    </h3>
                    <p class="text-sm text-white/80">
                        Detail informasi data pengamal
                    </p>
                </div>
            </div>
        </div>

        {{-- CONTENT CARD --}}
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">

            <div class="grid lg:grid-cols-3 gap-6 p-6">

                {{-- FOTO --}}
                <div class="flex justify-center">
                    <div class="w-52 h-52 rounded-2xl overflow-hidden border shadow-sm bg-gray-50">
                        @if($pengamal->foto && Storage::disk('public')->exists($pengamal->foto))
                        <img src="{{ asset('storage/'.$pengamal->foto) }}"
                            class="w-full h-full object-cover">
                        @else
                        <img src="{{ asset('image/foto.png') }}"
                            class="w-full h-full object-cover">
                        @endif
                    </div>
                </div>

                {{-- DATA --}}
                <div class="lg:col-span-2 space-y-5">

                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800">
                            Data Pribadi
                        </h3>

                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                            {{ $isPublic ? 'Publik' : 'Admin View' }}
                        </span>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 text-sm">

                        @foreach($rows as $label => $value)
                        <div class="flex flex-col">
                            <span class="text-gray-500 text-xs">{{ $label }}</span>
                            <span class="font-semibold text-gray-800">{{ $value }}</span>
                        </div>
                        @endforeach

                    </div>

                    {{-- ACTION --}}
                    <div class="flex flex-wrap gap-3 pt-4 border-t">

                        @auth
                        <a href="/pengamal/{{ $pengamal->id }}/edit"
                            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                            Edit
                        </a>

                        <a href="/pengamal"
                            class="px-4 py-2 rounded-lg bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
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
                            method="POST">

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

                        @if($pengamal->no_hp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$pengamal->no_hp) }}"
                            target="_blank"
                            class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
                            WhatsApp
                        </a>
                        @endif

                    </div>

                </div>
            </div>

        </div>

    </div>

</x-app-layout>