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

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">
                @if($isPublic)
                Pendataan Pengamal
                @else
                Tambah Pengamal -
                <span class="text-green-700">{{ $wilayah }}</span>
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- VALIDATION ERROR --}}
        {{-- ERROR --}}
        @if ($errors->any())
        <div class="rounded-xl border border-red-300 bg-red-50 p-5">
            <div class="flex items-center mb-3">
                <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                </svg>

                <h3 class="font-bold text-red-700">
                    Terdapat kesalahan pada pengisian form
                </h3>
            </div>

            <ul class="list-disc ml-6 text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- SUCCESS --}}
        @if(session('success'))
        <div
            x-data="{ show:true }"
            x-show="show"
            x-transition
            class="rounded-xl border border-green-300 bg-green-50 p-5">

            <div class="flex justify-between items-start">

                <div class="flex">

                    <svg class="w-7 h-7 text-green-600 mr-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7" />

                    </svg>

                    <div>
                        <h3 class="font-bold text-green-700">
                            Pendaftaran Berhasil
                        </h3>

                        <p class="text-green-700 mt-1">
                            {{ session('success') }}
                        </p>

                        @if($isPublic)
                        <p class="text-sm text-green-600 mt-2">
                            Data Anda telah berhasil dikirim dan akan diverifikasi oleh administrator.
                        </p>
                        @endif

                    </div>

                </div>

                <button
                    type="button"
                    @click="show=false"
                    class="text-green-700 hover:text-green-900">
                    ✕
                </button>

            </div>
        </div>
        @endif

        {{-- MODE --}}
        @if($isPublic)
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-4">

            <div class="flex">

                <svg class="w-6 h-6 text-blue-600 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12A9 9 0 1112 3a9 9 0 019 9z" />

                </svg>

                <div>

                    <h3 class="font-semibold text-blue-800">
                        Form Pendataan Pengamal (Publik)
                    </h3>

                    <p class="text-sm text-blue-700 mt-1">
                        Silakan isi data dengan benar. Setelah data berhasil dikirim,
                        data akan masuk ke sistem dan diverifikasi oleh admin.
                    </p>

                </div>

            </div>

        </div>
        @else
        <div class="rounded-xl bg-green-100 text-green-700 p-4">
            Mode Admin
        </div>
        @endif

        {{-- HEADER CARD --}}
        <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-xl shadow flex overflow-hidden">
            <div class="bg-green-900 flex items-center justify-center p-4">
                <img src="{{ asset('image/logo.png') }}"
                    class="w-12 h-12"
                    alt="Logo">
            </div>

            <div class="p-4">
                <h3 class="text-lg font-bold uppercase">
                    {{ $isPublic ? 'Pendataan Pengamal' : 'PW ' . $wilayah }}
                </h3>

                <p class="text-sm text-green-100">
                    Form input data pengamal
                </p>
            </div>
        </div>

        {{-- NOTE --}}
        <div class="rounded-lg bg-yellow-50 border border-yellow-300 text-yellow-800 p-4 text-sm">
            <p class="font-bold">⚠️ Perhatian Pengisian Form</p>

            <ul class="list-disc ml-5 mt-2 space-y-1">
                <li>Kolom dengan tanda <span class="text-red-600 font-bold">*</span> wajib diisi.</li>
                <li>Kolom tanpa tanda adalah <b>opsional (boleh dikosongkan)</b>.</li>
                <li>Pastikan data sesuai KTP dan benar.</li>
            </ul>
        </div>

        <form action="{{ $isPublic ? route('pengamal.public.store') : route('pengamal.store') }}"
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

                        <input type="hidden"
                            name="nik"
                            maxlength="16"
                            value="{{ old('nik') }}">

                        <input type="text"
                            name="nama_lengkap"
                            value="{{ old('nama_lengkap') }}"
                            placeholder="Nama Lengkap sesuai KTP *"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-green-600 focus:ring-green-600">

                        <div class="grid grid-cols-2 gap-3">

                            <select name="jenis_kelamin"
                                required
                                class="rounded-lg border-gray-300">

                                <option value="">Jenis Kelamin *</option>

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

                                <option value="">Agama (Opsional)</option>

                                @foreach([
                                'Islam',
                                'Kristen',
                                'Katolik',
                                'Hindu',
                                'Buddha',
                                'Konghucu'
                                ] as $agama)

                                <option value="{{ $agama }}"
                                    {{ old('agama') == $agama ? 'selected' : '' }}>
                                    {{ $agama }}
                                </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="grid grid-cols-2 gap-3">

                            <input type="text"
                                name="tempat_lahir"
                                value="{{ old('tempat_lahir') }}"
                                placeholder="Tempat Lahir *"
                                required
                                class="rounded-lg border-gray-300">

                            <input type="date"
                                name="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}"
                                required
                                class="rounded-lg border-gray-300">

                        </div>

                        {{-- WILAYAH --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label class="block mb-1">Provinsi *</label>

                                <select id="province"
                                    name="province_code"
                                    required
                                    class="w-full rounded-lg border-gray-300">

                                    <option value="">Pilih Provinsi</option>

                                    @foreach ($provinces as $province)
                                    <option value="{{ $province->code }}"
                                        {{ old('province_code') == $province->code ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>

                            <div>
                                <label class="block mb-1">Kabupaten *</label>

                                <select id="regency"
                                    name="regency_code"
                                    required
                                    class="w-full rounded-lg border-gray-300">

                                    <option value="">Pilih Kabupaten</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-1">Kecamatan *</label>

                                <select id="district"
                                    name="district_code"
                                    required
                                    class="w-full rounded-lg border-gray-300">

                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-1">Desa *</label>

                                <select id="village"
                                    name="village_code"
                                    required
                                    class="w-full rounded-lg border-gray-300">

                                    <option value="">Pilih Desa</option>
                                </select>
                            </div>

                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="space-y-5">

                        <h3 class="font-semibold border-b pb-2">
                            Kontak & Tambahan
                        </h3>

                        <textarea
                            name="alamat"
                            rows="3"
                            placeholder="Alamat (Opsional)"
                            class="w-full rounded-lg border-gray-300">{{ old('alamat') }}</textarea>

                        <input type="tel"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            placeholder="No HP / WhatsApp (Opsional)"
                            class="w-full rounded-lg border-gray-300">

                        <div>
                            <label class="block mb-1">
                                Foto (Opsional)
                            </label>

                            <input type="file"
                                name="foto"
                                accept="image/*"
                                class="w-full border border-gray-300 rounded-lg p-2">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                            <select name="pekerjaan"
                                class="rounded-lg border-gray-300">

                                <option value="">Pekerjaan (Opsional)</option>

                                <option value="PNS" {{ old('pekerjaan')=='PNS' ? 'selected':'' }}>PNS</option>
                                <option value="Guru / Dosen" {{ old('pekerjaan')=='Guru / Dosen' ? 'selected':'' }}>Guru / Dosen</option>
                                <option value="Wiraswasta" {{ old('pekerjaan')=='Wiraswasta' ? 'selected':'' }}>Wiraswasta</option>
                                <option value="Lainnya" {{ old('pekerjaan')=='Lainnya' ? 'selected':'' }}>Lainnya</option>

                            </select>

                            <select name="status_perkawinan"
                                required
                                class="rounded-lg border-gray-300">

                                <option value="">Status *</option>

                                <option value="Belum Kawin"
                                    {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>
                                    Belum Kawin
                                </option>

                                <option value="Kawin"
                                    {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>
                                    Kawin
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                {{-- ACTION --}}
                <div class="flex gap-3 mt-6">

                    <button
                        type="submit"
                        id="btnSubmit"
                        class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg">
                        Simpan
                    </button>

                    @if($isPublic)
                    <a href="/"
                        class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">
                        Beranda
                    </a>
                    @else
                    <a href="{{ route('pengamal.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 px-6 py-2 rounded-lg">
                        Kembali
                    </a>
                    @endif

                </div>

            </div>

        </form>

    </div>

    <script>
        async function loadSelect(url, target, placeholder) {
            try {

                const response = await fetch(url);
                const data = await response.json();

                const select = document.getElementById(target);

                select.innerHTML = `<option value="">${placeholder}</option>`;

                data.forEach(item => {

                    select.insertAdjacentHTML(
                        'beforeend',
                        `<option value="${item.code}">
                            ${item.name}
                        </option>`
                    );

                });

            } catch (error) {
                console.error(error);
            }
        }

        const province = document.getElementById('province');
        const regency = document.getElementById('regency');
        const district = document.getElementById('district');
        const village = document.getElementById('village');

        province.addEventListener('change', function() {

            loadSelect(
                `/get-regencies/${this.value}`,
                'regency',
                'Pilih Kabupaten'
            );

            district.innerHTML =
                '<option value="">Pilih Kecamatan</option>';

            village.innerHTML =
                '<option value="">Pilih Desa</option>';
        });

        regency.addEventListener('change', function() {

            loadSelect(
                `/get-districts/${this.value}`,
                'district',
                'Pilih Kecamatan'
            );

            village.innerHTML =
                '<option value="">Pilih Desa</option>';
        });

        district.addEventListener('change', function() {

            loadSelect(
                `/get-villages/${this.value}`,
                'village',
                'Pilih Desa'
            );

        });
    </script>
    <script>
        const form = document.querySelector('form');

        if (form) {
            form.addEventListener('submit', function() {

                const btn = document.getElementById('btnSubmit');

                btn.disabled = true;

                btn.innerHTML = `
            <svg class="animate-spin h-5 w-5 inline mr-2"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4">
                </circle>
                <path class="opacity-75"
                      fill="currentColor"
                      d="M4 12a8 8 0 018-8v8H4z">
                </path>
            </svg>
            Menyimpan...
        `;
            });
        }
    </script>

</x-app-layout>