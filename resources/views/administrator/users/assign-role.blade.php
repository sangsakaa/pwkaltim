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
        <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md">
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
    <div class="  p-2 overflow-hidden bg-white rounded-md shadow-md">
        <div class="  flex justify-between items-center ">

        </div>
        <div>
            <div class=" overflow-auto w-full">
                <h1>Manajemen Roles</h1>

                <div class=" py-2">
                    <a class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition" href="{{ route('roles.create') }}">+ Buat Role Baru</a>
                </div>

                <div class="container">
                    <h2>Assign Role ke: {{ $user->name }}</h2>

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('users.assign-role.update', $user) }}" method="POST">
                        @csrf

                        <div class="form-group mb-3 w-full">
                            <label for="role">Pilih Role:</label>
                            <select name="role" id="role" class="form-control w-full">
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                                @endforeach
                            </select>
                            @error('role') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <button class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition" type="submit" class="btn btn-primary">Simpan</button>
                        <a href="/users/assign-role"
                            class="px-6 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                            Kembali
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
        @endif

        @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
        @endif
    </script>
</x-app-layout>