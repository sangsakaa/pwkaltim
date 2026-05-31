<x-app-layout>

    @php


    $user = auth()->user();
    $isPublic = $isPublic ?? false;

    $wilayah = match (true) {
    $user?->village?->name =>
    $user->village->name,

    $user?->district?->name =>
    'Kecamatan ' . $user->district->name,

    $user?->regency?->name =>
    Str::startsWith(
    $user->regency->name,
    'Kab.'
    )
    ? 'Kabupaten ' .
    trim(substr(
    $user->regency->name,
    4
    ))
    : $user->regency->name,

    $user?->province?->name =>
    $user->province->name,

    default =>
    'Pendataan Pengamal',
    };

    $inputClass =
    'w-full rounded-xl border-gray-300 shadow-sm
    focus:border-green-600 focus:ring-green-600';

    $errorClass =
    'border-red-500 ring-2 ring-red-100';
    @endphp

    @section(
    'title',
    $isPublic
    ? 'Pendataan Pengamal'
    : $wilayah
    )

    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">
            {{ $isPublic
                ? 'Pendataan Pengamal'
                : 'Tambah Pengamal - ' . $wilayah }}
        </h2>
    </x-slot>

    <div class="space-y-6">

        {{-- SUCCESS --}}
        @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>
        @endif

        {{-- HEADER --}}
        <div class="overflow-hidden rounded-2xl bg-gradient-to-r from-green-800 to-green-600 text-white shadow-lg">
            <div class="flex items-center gap-4 p-5">

                <div class=" ">
                    <img
                        src="{{ asset('image/logo.png') }}"
                        class="h-14 w-14"
                        alt="Logo">
                </div>

                <div>
                    <h3 class="text-lg font-bold uppercase">
                        {{ $isPublic
                            ? 'Pendataan Pengamal'
                            :  $wilayah }}
                    </h3>

                    <p class="text-sm text-green-100">
                        Silakan isi data pengamal dengan benar
                    </p>
                </div>
            </div>
        </div>

        {{-- NOTE --}}
        <div class="rounded-xl border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-800">
            <p class="font-semibold">
                ⚠️ Informasi Pengisian
            </p>

            <ul class="ml-5 mt-2 list-disc space-y-1">
                <li>
                    Kolom bertanda
                    <span class="font-bold text-red-500">*</span>
                    wajib diisi
                </li>
                <li>
                    Pesan kesalahan akan tampil di bawah kolom
                </li>
                <li>
                    Pastikan data sesuai identitas
                </li>
            </ul>
        </div>

        @php
        $inputClass =
        'w-full rounded-xl border-gray-300 bg-white shadow-sm
        focus:border-green-600 focus:ring-green-600';

        $errorClass =
        'border-red-500 ring-2 ring-red-100';
        @endphp

        <form
            action="{{ route('pengamal.store') }}"
            method="POST"
            enctype="multipart/form-data"
            novalidate>

            @csrf

            <div class="rounded-2xl bg-white p-6 shadow-lg">

                <div class="grid gap-10 lg:grid-cols-2">

                    {{-- LEFT --}}
                    <div class="space-y-5">

                        <h3 class="border-b pb-2 text-lg font-semibold">
                            Data Pribadi
                        </h3>

                        {{-- Nama --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium">
                                Nama Lengkap
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                name="nama_lengkap"
                                value="{{ old('nama_lengkap') }}"
                                placeholder="Masukkan nama lengkap"
                                class="{{ $inputClass }}
                        @error('nama_lengkap')
                            {{ $errorClass }}
                        @enderror">

                            @error('nama_lengkap')
                            <p class="mt-1 text-sm text-red-500">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- JK + Agama --}}
                        <div class="grid gap-4 sm:grid-cols-2">

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium">
                                    Jenis Kelamin
                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="jenis_kelamin"
                                    class="{{ $inputClass }}
                            @error('jenis_kelamin')
                                {{ $errorClass }}
                            @enderror">

                                    <option value="">
                                        Pilih Jenis Kelamin
                                    </option>

                                    <option
                                        value="L"
                                        @selected(old('jenis_kelamin')==='L' )>
                                        Laki-laki
                                    </option>

                                    <option
                                        value="P"
                                        @selected(old('jenis_kelamin')==='P' )>
                                        Perempuan
                                    </option>
                                </select>

                                @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            {{-- Agama --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium">
                                    Agama
                                </label>

                                <select
                                    name="agama"
                                    class="{{ $inputClass }}">

                                    @foreach([
                                    'Islam',
                                    'Kristen',
                                    'Katolik',
                                    'Hindu',
                                    'Buddha',
                                    'Konghucu'
                                    ] as $agama)

                                    <option
                                        value="{{ $agama }}"
                                        @selected(old('agama', 'Islam' )==$agama)>
                                        {{ $agama }}
                                    </option>

                                    @endforeach
                                </select>

                                <p class="mt-1 text-xs text-gray-400">
                                    Default agama: Islam
                                </p>
                            </div>
                        </div>

                        {{-- TTL --}}
                        <div class="grid gap-4 sm:grid-cols-2">

                            <div>
                                <label class="mb-2 block text-sm font-medium">
                                    Tempat Lahir
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="tempat_lahir"
                                    value="{{ old('tempat_lahir') }}"
                                    placeholder="Masukkan tempat lahir"
                                    class="{{ $inputClass }}
                            @error('tempat_lahir')
                                {{ $errorClass }}
                            @enderror">

                                @error('tempat_lahir')
                                <p class="mt-1 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-medium">
                                    Tanggal Lahir
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir') }}"
                                    class="{{ $inputClass }}
                            @error('tanggal_lahir')
                                {{ $errorClass }}
                            @enderror">

                                @error('tanggal_lahir')
                                <p class="mt-1 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Wilayah --}}
                        <div class="grid gap-4 md:grid-cols-2">

                            @foreach([
                            [
                            'id'=>'province',
                            'name'=>'province_code',
                            'label'=>'Provinsi'
                            ],
                            [
                            'id'=>'regency',
                            'name'=>'regency_code',
                            'label'=>'Kabupaten'
                            ],
                            [
                            'id'=>'district',
                            'name'=>'district_code',
                            'label'=>'Kecamatan'
                            ],
                            [
                            'id'=>'village',
                            'name'=>'village_code',
                            'label'=>'Desa'
                            ],
                            ] as $select)

                            <div>
                                <label class="mb-2 block text-sm font-medium">
                                    {{ $select['label'] }}
                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="{{ $select['id'] }}"
                                    name="{{ $select['name'] }}"
                                    class="{{ $inputClass }}
                                @error($select['name'])
                                    {{ $errorClass }}
                                @enderror">

                                    <option value="">
                                        Pilih {{ $select['label'] }}
                                    </option>

                                    @if($select['id'] === 'province')
                                    @foreach($provinces as $province)
                                    <option
                                        value="{{ $province->code }}"
                                        @selected(old('province_code')==$province->code)>
                                        {{ $province->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>

                                @error($select['name'])
                                <p class="mt-1 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            @endforeach
                        </div>
                    </div>

                    {{-- RIGHT --}}
                    <div class="space-y-5">

                        <h3 class="border-b pb-2 text-lg font-semibold">
                            Kontak & Tambahan
                        </h3>

                        {{-- OPSIONAL --}}
                        <input
                            type="text"
                            name="alamat"
                            value="{{ old('alamat') }}"
                            placeholder="Alamat (Opsional)"
                            class="{{ $inputClass }}">

                        <input
                            type="text"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            placeholder="Nomor HP / WhatsApp"
                            class="{{ $inputClass }}">

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Alamat Email"
                            class="{{ $inputClass }}">

                        <input
                            type="file"
                            name="foto"
                            class="{{ $inputClass }}">

                        <div class="grid gap-4 sm:grid-cols-2">

                            {{-- Pekerjaan --}}
                            <select
                                name="pekerjaan"
                                class="{{ $inputClass }}">

                                <option value="">
                                    Pilih Pekerjaan
                                </option>

                                @foreach([
                                'PNS',
                                'Guru / Dosen',
                                'Wiraswasta',
                                'Lainnya'
                                ] as $job)

                                <option
                                    value="{{ $job }}"
                                    @selected(old('pekerjaan')==$job)>
                                    {{ $job }}
                                </option>

                                @endforeach
                            </select>

                            {{-- Status --}}
                            <div>
                                <select
                                    name="status_perkawinan"
                                    class="{{ $inputClass }}
                            @error('status_perkawinan')
                                {{ $errorClass }}
                            @enderror">

                                    <option value="">
                                        Status Perkawinan
                                    </option>

                                    <option
                                        value="Belum Kawin"
                                        @selected(old('status_perkawinan')=='Belum Kawin' )>
                                        Belum Kawin
                                    </option>

                                    <option
                                        value="Kawin"
                                        @selected(old('status_perkawinan')=='Kawin' )>
                                        Kawin
                                    </option>
                                </select>

                                @error('status_perkawinan')
                                <p class="mt-1 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="mt-8 flex gap-3 border-t pt-6">

                    <button
                        type="submit"
                        class="rounded-xl bg-green-700 px-6 py-3 font-medium text-white transition hover:bg-green-800">

                        Simpan Data
                    </button>

                    <a
                        href="{{ $isPublic ? '/' : route('pengamal.index') }}"
                        class="rounded-xl bg-gray-200 px-6 py-3 transition hover:bg-gray-300">

                        Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>