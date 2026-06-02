<x-app-layout>

    @php
    $user = auth()->user();

    $wilayah = 'Pengamal';

    if ($user?->regency?->name) {
    $wilayah = \Illuminate\Support\Str::startsWith($user->regency->name, 'Kab.')
    ? 'Kabupaten ' . ltrim(substr($user->regency->name, 4))
    : $user->regency->name;
    } elseif ($user?->district?->name) {
    $wilayah = 'Kecamatan ' . $user->district->name;
    } elseif ($user?->village?->name) {
    $wilayah = $user->village->name;
    } elseif ($user?->province?->name) {
    $wilayah = $user->province->name;
    }

    $isEdit = isset($pengamal);
    @endphp

    @section('title', $isEdit ? 'Edit Pengamal' : 'Tambah Pengamal')

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $isEdit ? 'Edit Pengamal' : 'Tambah Pengamal' }}
                </h2>

                <p class="text-sm text-gray-500">
                    Wilayah:
                    <span class="font-semibold text-green-600">
                        {{ $wilayah }}
                    </span>
                </p>
            </div>
        </div>
    </x-slot>
    {{-- NOTIFIKASI --}}
    <div class="space-y-4 mb-5">

        {{-- Success --}}
        @if(session('success'))
        <div
            class="flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 p-4 shadow-sm">

            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100">
                ✅
            </div>

            <div>
                <h4 class="font-semibold text-green-800">
                    Berhasil
                </h4>

                <p class="text-sm text-green-700">
                    {{ session('success') }}
                </p>
            </div>
        </div>
        @endif

        {{-- Error --}}
        @if(session('error'))
        <div
            class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 shadow-sm">

            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100">
                ❌
            </div>

            <div>
                <h4 class="font-semibold text-red-800">
                    Gagal
                </h4>

                <p class="text-sm text-red-700">
                    {{ session('error') }}
                </p>
            </div>
        </div>
        @endif

        {{-- Validation Error --}}
        @if ($errors->any())
        <div
            class="rounded-2xl border border-yellow-200 bg-yellow-50 p-4 shadow-sm">

            <div class="flex items-center gap-2 mb-2">
                <span class="text-lg">⚠️</span>

                <h4 class="font-semibold text-yellow-800">
                    Ada kesalahan input
                </h4>
            </div>

            <ul class="list-disc ml-5 text-sm text-yellow-700 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- CARD --}}
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">

                {{-- HEADER --}}
                <div class="bg-gradient-to-r from-green-700 via-green-600 to-green-500 p-6">

                    <div class="flex items-center gap-4">

                        <div
                            class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center shadow">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8 text-white"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-white text-xl font-bold">
                                {{ $isEdit ? 'Edit Data Pengamal' : 'Tambah Data Pengamal' }}
                            </h3>

                            <p class="text-green-100 text-sm">
                                Lengkapi informasi data pengamal dengan benar
                            </p>
                        </div>
                    </div>
                </div>

                {{-- FORM --}}
                <form
                    action="{{ $isEdit ? route('pengamal.update', $pengamal->id) : route('pengamal.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-5 sm:p-8">

                    @csrf
                    @if($isEdit)
                    @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

                        {{-- ================= LEFT ================= --}}
                        <div class="space-y-6">

                            <div class="border-b pb-3">
                                <h4 class="font-bold text-gray-800">
                                    Informasi Pribadi
                                </h4>
                            </div>

                            {{-- Nama Lengkap --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap
                                </label>

                                <input
                                    type="text"
                                    name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $pengamal->nama_lengkap ?? '') }}"
                                    class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    placeholder="Masukkan nama lengkap">

                                @error('nama_lengkap')
                                <small class="text-red-500">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- JK & Agama --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Jenis Kelamin
                                    </label>

                                    <select
                                        name="jenis_kelamin"
                                        class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500">

                                        <option value="">
                                            Pilih Jenis Kelamin
                                        </option>

                                        <option value="L"
                                            @selected(old('jenis_kelamin', $pengamal->jenis_kelamin ?? '') == 'L')>
                                            Laki-laki
                                        </option>

                                        <option value="P"
                                            @selected(old('jenis_kelamin', $pengamal->jenis_kelamin ?? '') == 'P')>
                                            Perempuan
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Agama
                                    </label>

                                    <select
                                        name="agama"
                                        class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500">

                                        <option value="Islam"
                                            @selected(old('agama', $pengamal->agama ?? '') == 'Islam')>
                                            Islam
                                        </option>
                                    </select>
                                </div>
                            </div>

                            {{-- Tempat/Tanggal Lahir --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Tempat Lahir
                                    </label>

                                    <input
                                        type="text"
                                        name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $pengamal->tempat_lahir ?? '') }}"
                                        class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                                        placeholder="Tempat lahir">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Tanggal Lahir
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', isset($pengamal->tanggal_lahir) ? \Carbon\Carbon::parse($pengamal->tanggal_lahir)->format('Y-m-d') : '') }}"
                                        class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500">
                                </div>
                            </div>

                            {{-- Wilayah --}}
                            <div class="border-b pb-3 pt-2">
                                <h4 class="font-bold text-gray-800">
                                    Wilayah
                                </h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Provinsi
                                    </label>

                                    <select id="province"
                                        name="province_code"
                                        class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500">

                                        <option value="">
                                            Pilih Provinsi
                                        </option>

                                        @foreach ($provinces as $p)
                                        <option value="{{ $p->code }}"
                                            @selected(old('province_code', $pengamal->provinsi ?? '') == $p->code)>
                                            {{ $p->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Kabupaten
                                    </label>

                                    <select id="regency"
                                        name="regency_code"
                                        class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500">

                                        <option value="">
                                            Pilih Kabupaten
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Kecamatan
                                    </label>

                                    <select id="district"
                                        name="district_code"
                                        class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500">

                                        <option value="">
                                            Pilih Kecamatan
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Desa
                                    </label>

                                    <select id="village"
                                        name="village_code"
                                        class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500">

                                        <option value="">
                                            Pilih Desa
                                        </option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        {{-- ================= RIGHT ================= --}}
                        <div class="space-y-6">

                            <div class="border-b pb-3">
                                <h4 class="font-bold text-gray-800">
                                    Kontak & Lampiran
                                </h4>
                            </div>

                            {{-- Alamat --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Alamat
                                </label>

                                <textarea
                                    name="alamat"
                                    rows="4"
                                    class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    placeholder="Masukkan alamat lengkap">{{ old('alamat', $pengamal->alamat ?? '') }}</textarea>
                            </div>

                            {{-- No HP --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor HP
                                </label>

                                <input
                                    type="text"
                                    name="no_hp"
                                    value="{{ old('no_hp', $pengamal->no_hp ?? '') }}"
                                    class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    placeholder="08xxxxxxxxxx">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $pengamal->email ?? '') }}"
                                    class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                                    placeholder="contoh@email.com">
                            </div>

                            {{-- Foto --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Upload Foto
                                </label>

                                <input
                                    type="file"
                                    name="foto"
                                    class="w-full text-sm border rounded-2xl p-3 border-gray-300
                                    file:mr-4 file:rounded-xl file:border-0
                                    file:bg-green-100 file:px-4 file:py-2
                                    file:text-green-700 hover:file:bg-green-200">

                                @if($isEdit && $pengamal->foto)
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">
                                        Foto Saat Ini
                                    </p>

                                    <img
                                        src="{{ asset('storage/' . $pengamal->foto) }}"
                                        class="w-32 h-32 rounded-2xl object-cover border shadow">
                                </div>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Status Perkawinan <span class="text-red-500">*</span>
                                </label>

                                <select
                                    name="status_perkawinan"
                                    class="w-full rounded-2xl border-gray-300 focus:border-green-500 focus:ring-green-500">

                                    <option value="">
                                        Pilih Status Perkawinan
                                    </option>

                                    <option value="Belum Kawin"
                                        @selected(old('status_perkawinan', $pengamal->status_perkawinan ?? '') == 'Belum Kawin')>
                                        Belum Kawin
                                    </option>

                                    <option value="Kawin"
                                        @selected(old('status_perkawinan', $pengamal->status_perkawinan ?? '') == 'Kawin')>
                                        Kawin
                                    </option>

                                    <option value="Cerai Hidup"
                                        @selected(old('status_perkawinan', $pengamal->status_perkawinan ?? '') == 'Cerai Hidup')>
                                        Cerai Hidup
                                    </option>

                                    <option value="Cerai Mati"
                                        @selected(old('status_perkawinan', $pengamal->status_perkawinan ?? '') == 'Cerai Mati')>
                                        Cerai Mati
                                    </option>

                                </select>

                                @error('status_perkawinan')
                                <small class="text-red-500">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>

                            {{-- BUTTON --}}
                            <div class="pt-4 flex flex-col sm:flex-row gap-3">

                                <button
                                    type="submit"
                                    class="flex-1 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white py-3 rounded-2xl font-semibold shadow-lg transition">

                                    {{ $isEdit ? 'Update Data' : 'Simpan Data' }}
                                </button>

                                <a href="{{ route('pengamal.index') }}"
                                    class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-2xl font-semibold transition">
                                    Kembali
                                </a>
                            </div>

                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- JS WILAYAH --}}
    <script>
        const province = document.getElementById('province');
        const regency = document.getElementById('regency');
        const district = document.getElementById('district');
        const village = document.getElementById('village');

        async function load(url, target, placeholder) {
            const res = await fetch(url);
            const data = await res.json();

            target.innerHTML = `<option value="">${placeholder}</option>`;

            data.forEach(i => {
                target.innerHTML += `<option value="${i.code}">${i.name}</option>`;
            });
        }

        async function initEdit() {

            @if($isEdit)
            await load(`/get-regencies/${province.value}`, regency, 'Pilih Kabupaten');
            regency.value = "{{ $pengamal->kabupaten }}";

            await load(`/get-districts/${regency.value}`, district, 'Pilih Kecamatan');
            district.value = "{{ $pengamal->kecamatan }}";

            await load(`/get-villages/${district.value}`, village, 'Pilih Desa');
            village.value = "{{ $pengamal->desa }}";
            @endif
        }

        province.addEventListener('change', () => {
            load(`/get-regencies/${province.value}`, regency, 'Pilih Kabupaten');
            district.innerHTML = '<option value="">Pilih Kecamatan</option>';
            village.innerHTML = '<option value="">Pilih Desa</option>';
        });

        regency.addEventListener('change', () => {
            load(`/get-districts/${regency.value}`, district, 'Pilih Kecamatan');
        });

        district.addEventListener('change', () => {
            load(`/get-villages/${district.value}`, village, 'Pilih Desa');
        });

        initEdit();
    </script>

</x-app-layout>