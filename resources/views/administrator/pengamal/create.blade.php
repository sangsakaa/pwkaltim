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
            <form action="/pengamal/store" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Kolom Kiri --}}
                    <div>
                        <div class="mb-2">
                            <label for="nik" class="w-full">Nomor Induk Kependudukan</label>
                            <input type="text" name="nik" id="nik" placeholder="Wajib diisi sesuai KTP / KIA"
                                class="w-full rounded-md" maxlength="16" value="{{ old('nik') }}" required>
                            @error('nik') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-2">
                            <label for="nama_lengkap" class="w-full">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap"
                                class="w-full rounded-md" value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2">

                            <div class="mb-2">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="w-full rounded-md" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-2">
                                <label for="agama" class="form-label">Agama</label>
                                <select name="agama" id="agama" class="w-full rounded-md" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                </select>
                                @error('agama') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-2">
                                <label for="tempat_lahir" class="w-full">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir"
                                    class="w-full rounded-md" value="{{ old('tempat_lahir') }}" required>
                                @error('tempat_lahir') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-2">
                                <label for="tanggal_lahir" class="w-full">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                    class="w-full rounded-md" value="{{ old('tanggal_lahir') }}" required>
                                @error('tanggal_lahir') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>


                            <div class="mb-2">
                                <label for="province" class="w-full">Provinsi</label>
                                <select class="w-full rounded-md" id="province" name="province_code" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{ $province->code }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="regency" class="w-full">Kabupaten / Kota</label>
                                <select class="w-full rounded-md" id="regency" name="regency_code" required>
                                    <option value="">Pilih Kabupaten / Kota</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="district" class="w-full">Kecamatan</label>
                                <select class="w-full rounded-md" id="district" name="district_code" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="village" class="w-full">Desa / Kelurahan</label>
                                <select class="w-full rounded-md" id="village" name="village_code" required>
                                    <option value="">Pilih Desa / Kelurahan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div>
                        <div class="grid grid-cols-2 gap-2">

                        </div>
                        <div class="mb-2">
                            <label for="alamat" class="w-full">Alamat</label>
                            <input type="text" name="alamat" id="alamat"
                                class="w-full rounded-md" value="{{ old('alamat') }}" required>
                            @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class=" grid grid-cols-2 gap-2">
                            <div class="mb-2">
                                <label for="no_hp" class="w-full">No. HP</label>
                                <input type="text" name="no_hp" id="no_hp" placeholder="Nomor Handphone"
                                    class="w-full rounded-md" value="{{ old('no_hp') }}">
                                @error('no_hp') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-2">
                                <label for="email" class="w-full">Email</label>
                                <input type="email" name="email" id="email"
                                    class="w-full rounded-md" value="{{ old('email') }}" placeholder="harus valid sesui format email">
                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-2">
                                <label for="rt" class="w-full">RT</label>
                                <input type="text" name="rt" id="rt"
                                    class="w-full rounded-md" value="{{ old('rt') }}">
                                @error('rt') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-2">
                                <label for="rw" class="w-full">RW</label>
                                <input type="text" name="rw" id="rw"
                                    class="w-full rounded-md" value="{{ old('rw') }}">
                                @error('rw') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                        </div>
                        <div class="mb-2">
                            <label for="foto" class="w-full">Foto </label>
                            <input type="file" name="foto" id="foto"
                                class="w-full " value="{{ old('foto') }}">
                            @error('foto') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <!-- Dropdown Pekerjaan -->


                        <!-- Dropdown Status Perkawinan -->
                        <div class=" grid grid-cols-2 gap-2">
                            <div class="mb-2">
                                <label for="pekerjaan" class="w-full">Pekerjaan</label>
                                <select name="pekerjaan" id="pekerjaan" class="w-full rounded-md" required>
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <option value="PNS" {{ old('pekerjaan') == 'PNS' ? 'selected' : '' }}>PNS</option>
                                    <option value="TNI/Polri" {{ old('pekerjaan') == 'TNI/Polri' ? 'selected' : '' }}>TNI/Polri</option>
                                    <option value="Karyawan Swasta" {{ old('pekerjaan') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="Wiraswasta" {{ old('pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                                    <option value="Petani" {{ old('pekerjaan') == 'Petani' ? 'selected' : '' }}>Petani</option>
                                    <option value="Nelayan" {{ old('pekerjaan') == 'Nelayan' ? 'selected' : '' }}>Nelayan</option>
                                    <option value="Pelajar/Mahasiswa" {{ old('pekerjaan') == 'Pelajar/Mahasiswa' ? 'selected' : '' }}>Pelajar/Mahasiswa</option>
                                    <option value="Ibu Rumah Tangga" {{ old('pekerjaan') == 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                                    <option value="Lainnya" {{ old('pekerjaan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('pekerjaan') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-2">
                                <label for="status_perkawinan" class="w-full">Status Perkawinan</label>
                                <select name="status_perkawinan" id="status_perkawinan" class="w-full rounded-md" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                    <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                                @error('status_perkawinan') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mt-4 flex space-x-2">
                            <button type="submit"
                                class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                Simpan
                            </button>
                            <a href="{{ route('pengamal.index') }}"
                                class="px-6 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>



            </form>
            <script>
                document.getElementById('province').addEventListener('change', function() {
                    let provinceCode = this.value;
                    fetch(`/get-regencies/${provinceCode}`)
                        .then(res => res.json())
                        .then(data => {
                            let regency = document.getElementById('regency');
                            regency.innerHTML = '<option value="">Pilih Kabupaten</option>';
                            data.forEach(item => {
                                regency.innerHTML += `<option value="${item.code}">${item.name}</option>`;
                            });

                            // Reset
                            document.getElementById('district').innerHTML = '<option value="">Pilih Kecamatan</option>';
                            document.getElementById('village').innerHTML = '<option value="">Pilih Desa</option>';
                        });
                });

                document.getElementById('regency').addEventListener('change', function() {
                    let regencyCode = this.value;
                    fetch(`/get-districts/${regencyCode}`)
                        .then(res => res.json())
                        .then(data => {
                            let district = document.getElementById('district');
                            district.innerHTML = '<option value="">Pilih Kecamatan</option>';
                            data.forEach(item => {
                                district.innerHTML += `<option value="${item.code}">${item.name}</option>`;
                            });

                            document.getElementById('village').innerHTML = '<option value="">Pilih Desa</option>';
                        });
                });

                document.getElementById('district').addEventListener('change', function() {
                    let districtCode = this.value;
                    fetch(`/get-villages/${districtCode}`)
                        .then(res => res.json())
                        .then(data => {
                            let village = document.getElementById('village');
                            village.innerHTML = '<option value="">Pilih Desa</option>';
                            data.forEach(item => {
                                village.innerHTML += `<option value="${item.code}">${item.name}</option>`;
                            });
                        });
                });
            </script>

        </div>
    </div>
</x-app-layout>