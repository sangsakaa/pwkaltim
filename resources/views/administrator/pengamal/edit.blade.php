<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black"
                class="justify-center max-w-xs gap-2">
                <x-icons.github class="w-6 h-6" aria-hidden="true" />
                <span>Formulir Pengamal</span>
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
        <div>





            <form action="/pengamal/update/{{ $pengamal->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Kolom Kiri --}}
                    <div>
                        <div class="mb-3">
                            <label for="nik" class="w-full">NIK</label>
                            <input type="text" name="nik" id="nik" class="w-full rounded-md" maxlength="16"
                                value="{{ old('nik', $pengamal->nik) }}" required>
                            @error('nik') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_lengkap" class="w-full">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="w-full rounded-md"
                                value="{{ old('nama_lengkap', $pengamal->nama_lengkap) }}" required>
                            @error('nama_lengkap') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2">
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="w-full rounded-md">
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin', $pengamal->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $pengamal->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select name="agama" id="agama" class="w-full rounded-md">
                                    <option value="">-- Pilih --</option>
                                    <option value="Islam" {{ old('agama', $pengamal->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <!-- Tambahkan agama lain bila perlu -->
                                </select>
                                @error('agama') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tempat_lahir" class="w-full">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="w-full rounded-md"
                                    value="{{ old('tempat_lahir', $pengamal->tempat_lahir) }}">
                                @error('tempat_lahir') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_lahir" class="w-full">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="w-full rounded-md"
                                    value="{{ old('tanggal_lahir', $pengamal->tanggal_lahir) }}">
                                @error('tanggal_lahir') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="province" class="w-full">Provinsi</label>
                                <select class="w-full rounded-md" id="province" name="province_code">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{ $province->code }}" {{ old('province_code', $pengamal->provinsi) == $province->code ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="regency" class="w-full">Kabupaten / Kota</label>
                                <select class="w-full rounded-md" id="regency" name="regency_code">
                                    <option value="">Pilih Kabupaten / Kota</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="district" class="w-full">Kecamatan</label>
                                <select class="w-full rounded-md" id="district" name="district_code">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="village" class="w-full">Desa / Kelurahan</label>
                                <select class="w-full rounded-md" id="village" name="village_code">
                                    <option value="">Pilih Desa / Kelurahan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div>
                        <div class="mb-3">
                            <label for="alamat" class="w-full">Alamat</label>
                            <input type="text" name="alamat" id="alamat" class="w-full rounded-md"
                                value="{{ old('alamat', $pengamal->alamat) }}" required>
                            @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div class="mb-3">
                                <label for="no_hp" class="w-full">No. HP</label>
                                <input type="text" name="no_hp" id="no_hp" class="w-full rounded-md"
                                    value="{{ old('no_hp', $pengamal->no_hp) }}" required>
                                @error('no_hp') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="w-full">Email</label>
                                <input type="email" name="email" id="email" class="w-full rounded-md"
                                    value="{{ old('email', $pengamal->email) }}" required>
                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="rt" class="w-full">RT</label>
                                <input type="text" name="rt" id="rt" class="w-full rounded-md"
                                    value="{{ old('rt', $pengamal->rt) }}" required>
                                @error('rt') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="rw" class="w-full">RW</label>
                                <input type="text" name="rw" id="rw" class="w-full rounded-md"
                                    value="{{ old('rw', $pengamal->rw) }}" required>
                                @error('rw') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div>
                            <div class=" grid grid-cols-2">
                                <div class="">
                                    <div class="mb-3">
                                        <label for="foto" class="w-full">Foto</label>
                                        <input type="file" name="foto" id="foto" class="w-full">
                                        @error('foto') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                        Update
                                    </button>
                                    <a href="/pengamal/show/{{$pengamal->id}}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                                        Kembali
                                    </a>
                                </div>
                                <div>
                                    <div class="w-full ">
                                        @if ($pengamal->foto)
                                        <img src="{{ asset('storage/' . $pengamal->foto) }}" alt="Foto Pengamal" class="w-32 h-32 object-cover rounded">
                                        @else
                                        <p>Tidak ada foto.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
            <script>
                const province = document.getElementById('province');
                const regency = document.getElementById('regency');
                const district = document.getElementById('district');
                const village = document.getElementById('village');

                const selected = {
                    regency: '{{ old('
                    regency_code ', $pengamal->kabupaten) }}',
                    district: '{{ old('
                    district_code ', $pengamal->kecamatan) }}',
                    village: '{{ old('
                    village_code ', $pengamal->desa) }}'
                };

                province.addEventListener('change', async function() {
                    const provinceCode = this.value;
                    regency.innerHTML = '<option value="">Pilih Kabupaten</option>';
                    district.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    village.innerHTML = '<option value="">Pilih Desa</option>';

                    if (!provinceCode) return;

                    const response = await fetch(`/get-regencies/${provinceCode}`);
                    const data = await response.json();
                    data.forEach(item => {
                        const selectedAttr = item.code == selected.regency ? 'selected' : '';
                        regency.innerHTML += `<option value="${item.code}" ${selectedAttr}>${item.name}</option>`;
                    });

                    if (selected.regency) {
                        regency.dispatchEvent(new Event('change'));
                    }
                });

                regency.addEventListener('change', async function() {
                    const regencyCode = this.value;
                    district.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    village.innerHTML = '<option value="">Pilih Desa</option>';

                    if (!regencyCode) return;

                    const response = await fetch(`/get-districts/${regencyCode}`);
                    const data = await response.json();
                    data.forEach(item => {
                        const selectedAttr = item.code == selected.district ? 'selected' : '';
                        district.innerHTML += `<option value="${item.code}" ${selectedAttr}>${item.name}</option>`;
                    });

                    if (selected.district) {
                        district.dispatchEvent(new Event('change'));
                    }
                });

                district.addEventListener('change', async function() {
                    const districtCode = this.value;
                    village.innerHTML = '<option value="">Pilih Desa</option>';

                    if (!districtCode) return;

                    const response = await fetch(`/get-villages/${districtCode}`);
                    const data = await response.json();
                    data.forEach(item => {
                        const selectedAttr = item.code == selected.village ? 'selected' : '';
                        village.innerHTML += `<option value="${item.code}" ${selectedAttr}>${item.name}</option>`;
                    });
                });

                // Trigger initial load if province already selected
                if (province.value) {
                    province.dispatchEvent(new Event('change'));
                }
            </script>



        </div>
    </div>
</x-app-layout>