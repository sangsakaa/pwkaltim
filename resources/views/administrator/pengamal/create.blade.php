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
            <form action="/pengamal/store" method="POST">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="mb-3">
                            <label for="nik" class=" w-full">NIK</label>
                            <input type="text" name="nik" id="nik" placeholder="Wajib diisie sesui KTP / KIA" class=" w-full rounded-md" maxlength="16" value="{{ old('nik') }}" required>
                            @error('nik') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_lengkap" class=" w-full">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class=" w-full rounded-md" value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class=" grid gap-2 grid-cols-1 sm:grid-cols-2">
                            <div>
                                <div class="mb-3">
                                    <label for="tempat_lahir" class=" w-full">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class=" w-full rounded-md" value="{{ old('tempat_lahir') }}">
                                    @error('tempat_lahir') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div>
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class=" w-full">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class=" w-full rounded-md" value="{{ old('tanggal_lahir') }}">
                                    @error('tanggal_lahir') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>


                            </div>


                        </div>


                    </div>
                    <div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class=" w-full rounded-md"
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <select name="agama" id="agama" class=" w-full rounded-md"
                                <option value="">-- Pilih --</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : 'Islam' }}>Islam</option>
                                
                            </select>
                            @error('agama') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                            Simpan</button>
                        <a href="/pengamal" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">
                            Kembali</a>
                    </div>
                </div>


            </form>
        </div>
    </div>
</x-app-layout>