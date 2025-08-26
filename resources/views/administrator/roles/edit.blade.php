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

    <div class="p-4 sm:p-6 lg:p-8 space-y-6"> {{-- Added padding and spacing --}}
        <div class="bg-white rounded-md shadow-md overflow-hidden">
            <div class="flex flex-col md:flex-row items-center p-4"> {{-- Adjusted for better responsiveness --}}
                <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-4">
                    <img src="{{ asset('image/logofont.jpg') }}" width="200" alt="Logo">
                </div>
                <div class="w-full text-center">
                    <marquee behavior="scroll" direction="left">
                        Selamat datang di website kami!
                    </marquee>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-md shadow-md overflow-hidden p-4"> {{-- Consolidated styling --}}
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold">Edit Role: {{ $role->name }}</h1>
            </div>
            <div class="overflow-auto">
                <form action="{{ route('roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4"> {{-- Added margin-bottom for spacing --}}
                        <label for="roleName" class="block text-sm font-medium text-gray-700 mb-1">Nama Role</label>
                        <input type="text" name="name" id="roleName" value="{{ $role->name }}" required
                            class="w-full md:w-1/2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Masukkan nama role">
                    </div>

                    <div class="mb-6"> {{-- Added margin-bottom for spacing --}}
                        <label class="block text-sm font-medium text-gray-700 mb-2">Permission</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3"> {{-- Grid for permissions --}}
                            @foreach($permissions as $permission)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">{{ $permission->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center space-x-4"> {{-- Flexbox for buttons --}}
                        <button type="submit"
                            class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                            Simpan
                        </button>
                        <a href="/roles"
                            class="px-6 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition">
                            Kembali
                        </a>
                    </div>
                </form>
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