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
    @endphp

    @section('title', $isPublic ? 'Pendaftaran Pengamal' : 'PW ' . $wilayah)

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">
                @if($isPublic)
                Pendaftaran Pengamal
                @else
                Tambah Pengamal -
                <span class="text-green-700">{{ $wilayah }}</span>
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- FLASH MESSAGE --}}
        @if(session('success'))
        <div class="rounded-lg bg-green-100 border border-green-200 text-green-700 p-4">
            {{ session('success') }}
        </div>
        @endif

        {{-- MODE INFO --}}
        @if($isPublic)
        <div class="rounded-lg bg-blue-100 text-blue-700 p-4">
            Form pendaftaran pengamal (Publik)
        </div>
        @else
        <div class="rounded-lg bg-green-100 text-green-700 p-4">
            Mode Admin
        </div>
        @endif

        {{-- HEADER CARD --}}
        <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-xl shadow flex overflow-hidden">

            <div class="bg-green-900 flex items-center justify-center p-4">
                <img src="{{ asset('image/logo.png') }}"
                    class="w-12 h-12"
                    alt="logo">
            </div>

            <div class="p-4">
                <h3 class="text-lg font-bold uppercase">
                    {{ $isPublic ? 'Pendaftaran Pengamal' : 'PW ' . $wilayah }}
                </h3>

                <p class="text-sm text-green-100">
                    Form input data pengamal
                </p>
            </div>
        </div>

        {{-- FORM --}}
        <form action="{{ route('pengamal.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="bg-white rounded-xl shadow p-6">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- LEFT --}}
                    <div class="space-y-5">

                        <h3 class="font-semibold border-b pb-2">
                            Data Pribadi
                        </h3>

                        <input hidden type="text"
                            name="nik"
                            maxlength="16"
                            placeholder="NIK"
                            value="{{ old('nik') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">

                        <input type="text"
                            name="nama_lengkap"
                            placeholder="Nama Lengkap"
                            value="{{ old('nama_lengkap') }}"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">

                        <div class="grid grid-cols-2 gap-3">

                            <select name="jenis_kelamin"
                                class="rounded-lg border-gray-300">

                                <option value="">
                                    Jenis Kelamin
                                </option>

                                <option value="L"
                                    {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>

                                <option value="P"
                                    {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>

                            </select>

                            <select name="agama"
                                class="rounded-lg border-gray-300">
                                <option value="Islam">
                                    Islam
                                </option>

                            </select>

                        </div>

                        <div class="grid grid-cols-2 gap-3">

                            <input type="text"
                                name="tempat_lahir"
                                placeholder="Tempat Lahir"
                                value="{{ old('tempat_lahir') }}"
                                class="rounded-lg border-gray-300">

                            <input type="date"
                                name="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}"
                                class="rounded-lg border-gray-300">

                        </div>

                        {{-- WILAYAH --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- PROVINSI --}}
                            <div>
                                <label class="text-sm text-gray-600">
                                    Provinsi
                                </label>

                                <select id="province"
                                    name="province_code"
                                    class="w-full rounded-lg border-gray-300">

                                    <option value="">
                                        Pilih Provinsi
                                    </option>

                                    @foreach ($provinces as $province)
                                    <option value="{{ $province->code }}">
                                        {{ $province->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- KABUPATEN --}}
                            <div>
                                <label class="text-sm text-gray-600">
                                    Kabupaten
                                </label>

                                <select id="regency"
                                    name="regency_code"
                                    class="w-full rounded-lg border-gray-300">

                                    <option value="">
                                        Pilih Kabupaten
                                    </option>

                                </select>
                            </div>

                            {{-- KECAMATAN --}}
                            <div>
                                <label class="text-sm text-gray-600">
                                    Kecamatan
                                </label>

                                <select id="district"
                                    name="district_code"
                                    class="w-full rounded-lg border-gray-300">

                                    <option value="">
                                        Pilih Kecamatan
                                    </option>

                                </select>
                            </div>

                            {{-- DESA --}}
                            <div>
                                <label class="text-sm text-gray-600">
                                    Desa
                                </label>

                                <select id="village"
                                    name="village_code"
                                    class="w-full rounded-lg border-gray-300">

                                    <option value="">
                                        Pilih Desa
                                    </option>

                                </select>
                            </div>

                        </div>
                    </div>

                    {{-- RIGHT --}}
                    <div class="space-y-5 ">

                        <h3 class="font-semibold border-b pb-2">
                            Kontak & Tambahan
                        </h3>

                        <input type="text"
                            name="alamat"
                            placeholder="Alamat"
                            value="{{ old('alamat') }}"
                            class="w-full rounded-lg border-gray-300">

                        <div class="grid grid-cols-1 gap-3">

                            <input type="text"
                                name="no_hp"
                                placeholder="No HP"
                                value="{{ old('no_hp') }}"
                                class="rounded-lg border-gray-300">
                        </div>



                        <input type="file"
                            name="foto"
                            class="w-full border rounded-lg p-2">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                            <select name="pekerjaan" class="rounded-lg border-gray-300">
                                <option value="">Pilih Pekerjaan</option>

                                <option value="PNS">PNS</option>

                                <option value="Guru/Dosen">Guru / Dosen</option>
                                <option value="Pelajar/Mahasiswa">Pelajar / Mahasiswa</option>
                                <option value="Karyawan Swasta">Karyawan Swasta</option>

                                <option value="Wiraswasta">Wiraswasta</option>
                                <option value="Pedagang">Pedagang</option>
                                <option value="Petani">Petani</option>
                                <option value="Peternak">Peternak</option>
                                <option value="Nelayan">Nelayan</option>
                                <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                <option value="Tidak Bekerja">Tidak Bekerja</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>

                            <select name="status_perkawinan"
                                class="rounded-lg border-gray-300">

                                <option value="">
                                    Status
                                </option>

                                <option>Belum Kawin</option>
                                <option>Kawin</option>

                            </select>

                        </div>
                    </div>
                </div>

                {{-- ACTION --}}
                <div class="flex gap-3 mt-6">

                    <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg">

                        Simpan

                    </button>

                    @if($isPublic)

                    <a href="/"
                        class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">
                        Beranda
                    </a>

                    @else

                    @role('admin-provinsi')
                    <a href="{{ route('pengamal.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">
                        Kembali
                    </a>
                    @endrole

                    @role('admin-kabupaten')
                    <a href="/dashboard"
                        class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">
                        Dashboard
                    </a>
                    @endrole

                    @endif

                </div>
            </div>
        </form>
    </div>

    {{-- AJAX --}}
    <script>
        function loadSelect(url, target, placeholder) {
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    let el = document.getElementById(target);

                    el.innerHTML =
                        `<option value="">${placeholder}</option>`;

                    data.forEach(i => {
                        el.innerHTML += `
                            <option value="${i.code}">
                                ${i.name}
                            </option>
                        `;
                    });
                });
        }

        document.getElementById('province')
            .addEventListener('change', function() {

                loadSelect(
                    `/get-regencies/${this.value}`,
                    'regency',
                    'Pilih Kabupaten'
                );

                document.getElementById('district').innerHTML =
                    '<option value="">Pilih Kecamatan</option>';

                document.getElementById('village').innerHTML =
                    '<option value="">Pilih Desa</option>';
            });

        document.getElementById('regency')
            .addEventListener('change', function() {

                loadSelect(
                    `/get-districts/${this.value}`,
                    'district',
                    'Pilih Kecamatan'
                );
            });

        document.getElementById('district')
            .addEventListener('change', function() {

                loadSelect(
                    `/get-villages/${this.value}`,
                    'village',
                    'Pilih Desa'
                );
            });
    </script>

</x-app-layout>