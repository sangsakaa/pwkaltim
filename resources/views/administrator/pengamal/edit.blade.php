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
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">
                {{ $isEdit ? 'Edit Pengamal' : 'Tambah Pengamal' }}
                <span class="text-green-600">- {{ $wilayah }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white border border-gray-100 shadow-xl rounded-2xl overflow-hidden">

                {{-- HEADER --}}
                <div class="bg-gradient-to-r from-green-600 to-green-500 px-6 py-4">
                    <h3 class="text-white font-semibold text-lg">
                        Form {{ $isEdit ? 'Edit' : 'Tambah' }} Data Pengamal
                    </h3>
                </div>

                <form
                    action="{{ $isEdit ? route('pengamal.update', $pengamal->id) : route('pengamal.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-6 space-y-6">

                    @csrf
                    @if($isEdit)
                    @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        {{-- ================= LEFT ================= --}}
                        <div class="space-y-4">

                            <input type="text" name="nama_lengkap"
                                value="{{ old('nama_lengkap', $pengamal->nama_lengkap ?? '') }}"
                                class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                placeholder="Nama Lengkap">

                            <div class="grid grid-cols-2 gap-3">

                                <select name="jenis_kelamin"
                                    class="rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500">

                                    <option value="">Jenis Kelamin</option>
                                    <option value="L" @selected(old('jenis_kelamin', $pengamal->jenis_kelamin ?? '')=='L')>Laki-laki</option>
                                    <option value="P" @selected(old('jenis_kelamin', $pengamal->jenis_kelamin ?? '')=='P')>Perempuan</option>
                                </select>

                                <select name="agama"
                                    class="rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500">
                                    <option value="Islam" @selected(old('agama', $pengamal->agama ?? '')=='Islam')>Islam</option>
                                </select>

                            </div>

                            <div class="grid grid-cols-2 gap-3">

                                <input type="text" name="tempat_lahir"
                                    value="{{ old('tempat_lahir', $pengamal->tempat_lahir ?? '') }}"
                                    class="rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                    placeholder="Tempat Lahir">

                                <input type="date" name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir', $pengamal->tanggal_lahir ?? '') }}"
                                    class="rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500">

                            </div>

                            {{-- WILAYAH --}}
                            <div class=" grid grid-cols-2 gap-2">
                                <select id="province" name="province_code"
                                    class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500">
                                    <option value="">Provinsi</option>
                                    @foreach ($provinces as $p)
                                    <option value="{{ $p->code }}"
                                        @selected(old('province_code', $pengamal->provinsi ?? '') == $p->code)>
                                        {{ $p->name }}
                                    </option>
                                    @endforeach
                                </select>

                                <select id="regency" name="regency_code"
                                    class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500">
                                    <option value="">Kabupaten</option>
                                </select>

                                <select id="district" name="district_code"
                                    class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500">
                                    <option value="">Kecamatan</option>
                                </select>

                                <select id="village" name="village_code"
                                    class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500">
                                    <option value="">Desa</option>
                                </select>
                            </div>


                        </div>

                        {{-- ================= RIGHT ================= --}}
                        <div class="space-y-4">

                            <input type="text" name="alamat"
                                value="{{ old('alamat', $pengamal->alamat ?? '') }}"
                                class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                placeholder="Alamat">

                            <input type="text" name="no_hp"
                                value="{{ old('no_hp', $pengamal->no_hp ?? '') }}"
                                class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                placeholder="No HP">

                            <input type="email" name="email"
                                value="{{ old('email', $pengamal->email ?? '') }}"
                                class="w-full rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500"
                                placeholder="Email (opsional)">

                            <div class="space-y-2">
                                <input type="file"
                                    name="foto"
                                    class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 hover:file:bg-green-100">

                                @if($isEdit && $pengamal->foto)
                                <img src="{{ asset('storage/'.$pengamal->foto) }}"
                                    class="w-24 h-24 rounded-xl object-cover border">
                                @endif
                            </div>

                            {{-- BUTTON --}}
                            <button
                                class="w-full bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold py-2.5 rounded-xl shadow-md transition">
                                {{ $isEdit ? 'Update Data' : 'Simpan Data' }}
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>
    </div>

    {{-- ================= JS ================= --}}
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
            await load(`/get-regencies/${province.value}`, regency, 'Kabupaten');
            regency.value = "{{ $pengamal->kabupaten }}";

            await load(`/get-districts/${regency.value}`, district, 'Kecamatan');
            district.value = "{{ $pengamal->kecamatan }}";

            await load(`/get-villages/${district.value}`, village, 'Desa');
            village.value = "{{ $pengamal->desa }}";
            @endif
        }

        province.addEventListener('change', () => {
            load(`/get-regencies/${province.value}`, regency, 'Kabupaten');
            district.innerHTML = '<option value="">Kecamatan</option>';
            village.innerHTML = '<option value="">Desa</option>';
        });

        regency.addEventListener('change', () => {
            load(`/get-districts/${regency.value}`, district, 'Kecamatan');
        });

        district.addEventListener('change', () => {
            load(`/get-villages/${district.value}`, village, 'Desa');
        });

        initEdit();
    </script>

</x-app-layout>