<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black"
                class="justify-center max-w-xs gap-2">
                <x-icons.github class="w-6 h-6" aria-hidden="true" />
                <span>Data Pengamal</span>
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
        <div class="  flex justify-between items-center ">

        </div>
        <div>
            <div class=" overflow-auto">
                <div class="container">
                    <div class="container">
                        <h2>Tambah User</h2>

                        <form action="/users/create" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label>Nama</label>
                                <input type="text" name="name" class=" w-full rounded-md px-2 form-control" value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class=" w-full rounded-md px-2 form-control" value="{{ old('email') }}" required>
                            </div>
                            <div>
                                <label for="code">Kode Daerah</label>
                                <input type="text" name="code" class=" w-full rounded-md px-2" value="{{ old('code') }}" required>
                                @error('code') <div>{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class=" w-full rounded-md px-2 form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class=" w-full rounded-md px-2 form-control" required>
                            </div>

                            <div class="flex gap-2">
                                <a
                                    href="/users/assign-role"
                                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Kembali
                                </a>

                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    Simpan
                                </button>
                            </div>



                        </form>
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>