<x-app-layout>

    @php
    

    $user = auth()->user();

    $wilayah = 'Tidak diketahui';

    if ($user?->regency?->name) {
    $wilayah = Str::startsWith($user->regency->name, 'Kab.')
    ? 'Kabupaten ' . trim(substr($user->regency->name, 4))
    : $user->regency->name;

    } elseif ($user?->district?->name) {
    $wilayah = 'Kec. ' . $user->district->name;

    } elseif ($user?->village?->name) {
    $wilayah = $user->village->name;

    } elseif ($user?->province?->name) {
    $wilayah = $user->province->name;
    }
    @endphp

    @section('title', 'PW ' . $wilayah)

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Edit Pengamal -
                <span class="text-green-700">{{ $wilayah }}</span>
            </h2>
        </div>
    </x-slot>

    {{-- HEADER CARD --}}
    <div class="mb-6 bg-gradient-to-r from-green-800 to-green-600 rounded-xl shadow flex items-center text-white overflow-hidden">
        <div class="p-3 bg-green-900">
            <img src="{{ asset('image/logo.png') }}" width="50" alt="Logo">
        </div>
        <div class="px-4 font-semibold uppercase tracking-wide">
            PW {{ $wilayah }}
        </div>
    </div>

    {{-- FORM --}}
    <div class="bg-white p-6 rounded-xl shadow">

        <form action="/pengamal/update/{{ $pengamal->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- LEFT --}}
                <div class="space-y-4">

                    <div>
                        <label class="text-sm text-gray-600">NIK</label>
                        <input type="text" name="nik" maxlength="16"
                            class="w-full rounded-lg border-gray-300"
                            value="{{ old('nik', $pengamal->nik) }}">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap"
                            class="w-full rounded-lg border-gray-300"
                            value="{{ old('nama_lengkap', $pengamal->nama_lengkap) }}">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <select name="jenis_kelamin" class="rounded-lg border-gray-300">
                            <option value="L" @selected(old('jenis_kelamin',$pengamal->jenis_kelamin)=='L')>Laki-laki</option>
                            <option value="P" @selected(old('jenis_kelamin',$pengamal->jenis_kelamin)=='P')>Perempuan</option>
                        </select>

                        <select name="agama" class="rounded-lg border-gray-300">
                            <option value="Islam" @selected(old('agama',$pengamal->agama)=='Islam')>Islam</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="tempat_lahir"
                            class="rounded-lg border-gray-300"
                            value="{{ old('tempat_lahir',$pengamal->tempat_lahir) }}">

                        <input type="date" name="tanggal_lahir"
                            class="rounded-lg border-gray-300"
                            value="{{ old('tanggal_lahir',$pengamal->tanggal_lahir) }}">
                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="space-y-4">

                    <input type="text" name="alamat"
                        class="w-full rounded-lg border-gray-300"
                        value="{{ old('alamat',$pengamal->alamat) }}">

                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" name="no_hp" class="rounded-lg border-gray-300"
                            value="{{ old('no_hp',$pengamal->no_hp) }}">

                        <input type="email" name="email" class="rounded-lg border-gray-300"
                            value="{{ old('email',$pengamal->email) }}">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <input type="number" name="rt" class="rounded-lg border-gray-300"
                            value="{{ old('rt',$pengamal->rt) }}">

                        <input type="number" name="rw" class="rounded-lg border-gray-300"
                            value="{{ old('rw',$pengamal->rw) }}">
                    </div>

                    {{-- FOTO --}}
                    <div class="flex items-center gap-4">
                        <input type="file" name="foto">

                        @if($pengamal->foto)
                        <img src="{{ asset('storage/'.$pengamal->foto) }}"
                            class="w-20 h-20 rounded-lg object-cover">
                        @endif
                    </div>

                    {{-- ACTION --}}
                    <div class="flex gap-2 pt-3">
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                            Update
                        </button>

                        <a href="/pengamal/show/{{ $pengamal->id }}"
                            class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
                            Kembali
                        </a>
                    </div>

                </div>
            </div>
        </form>
    </div>

    {{-- FIX JS (SAFE & NO ERROR) --}}
    <script>
        const province = document.getElementById('province');
        const regency = document.getElementById('regency');
        const district = document.getElementById('district');
        const village = document.getElementById('village');

        const selected = {
            regency: @json($pengamal -> regency_code ?? null),
            district: @json($pengamal -> district_code ?? null),
            village: @json($pengamal -> village_code ?? null),
        };

        async function load(url, target, placeholder) {
            const res = await fetch(url);
            const data = await res.json();

            target.innerHTML = `<option value="">${placeholder}</option>`;
            data.forEach(i => {
                target.innerHTML += `<option value="${i.code}">${i.name}</option>`;
            });
        }

        province?.addEventListener('change', function() {
            if (!this.value) return;
            load(`/get-regencies/${this.value}`, regency, 'Pilih Kabupaten');
        });

        regency?.addEventListener('change', function() {
            if (!this.value) return;
            load(`/get-districts/${this.value}`, district, 'Pilih Kecamatan');
        });

        district?.addEventListener('change', function() {
            if (!this.value) return;
            load(`/get-villages/${this.value}`, village, 'Pilih Desa');
        });

        if (province?.value) province.dispatchEvent(new Event('change'));
    </script>

</x-app-layout>