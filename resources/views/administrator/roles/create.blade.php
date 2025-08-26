<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="https://github.com/kamona-wd/kui-laravel-breeze" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 justify-center max-w-xs gap-2">
                <x-icons.github class="w-6 h-6" aria-hidden="true" />
                <span>Data Pengamal</span>
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-1">
        <div class="p-4 bg-white rounded-md shadow-md">
            <div class="flex flex-col md:flex-row items-center gap-4">
                <div>
                    <img src="{{ asset('image/logofont.jpg') }}" width="200" alt="Logo" class="rounded-md">
                </div>
                <div class="flex-1 w-full text-center md:text-left">
                    <marquee behavior="scroll" direction="left" class="text-lg font-medium text-gray-700">
                        Selamat datang di website kami!
                    </marquee>
                </div>
            </div>
        </div>
    </div>

    <div class="p-4 mt-4 bg-white rounded-md shadow-md">
        <h1 class="text-2xl font-bold mb-4">Buat Role Baru</h1>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="role-name" class="block text-gray-700 text-sm font-bold mb-2">Nama Role</label>
                <input type="text" name="name" id="role-name" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Masukkan nama role">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Permission</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                    @foreach($permissions as $permission)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="ml-2 text-gray-700">{{ $permission->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-start gap-4">
                <button type="submit"
                    class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                    Simpan
                </button>
                <a href="/roles"
                    class="px-6 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                    Kembali
                </a>
            </div>
        </form>
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