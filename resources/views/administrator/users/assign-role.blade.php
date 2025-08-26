<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Dashboard') }}
            </h2>
            <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black"
                class="justify-center max-w-xs gap-2">
                <x-icons.github class="w-6 h-6" aria-hidden="true" />
                <span>Data Pengamal</span>
            </x-button>
        </div>
    </x-slot>

    <div class="py-6"> {{-- Added vertical padding to the main content area --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"> {{-- Centered content and added vertical space between sections --}}
            {{-- Header/Welcome Section --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> {{-- Consistent shadow and rounded corners --}}
                <div class="p-6 flex flex-col md:flex-row items-center gap-4"> {{-- Increased padding, improved flex layout for responsiveness --}}
                    <div>
                        <img src="{{ asset('image/logofont.jpg') }}" width="200" alt="Logo" class="max-w-full h-auto"> {{-- Ensure image is responsive --}}
                    </div>
                    <div class="w-full text-center md:text-left"> {{-- Centered text for smaller screens, left-aligned for larger --}}
                        <marquee behavior="scroll" direction="left" class="text-lg font-medium text-gray-700"> {{-- Improved marquee styling --}}
                            Selamat datang di website kami!
                        </marquee>
                    </div>
                </div>
            </div>

            {{-- Manajemen Roles Section --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6"> {{-- Consistent padding --}}
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">Manajemen Roles</h1> {{-- Stronger heading style --}}

                    <div class="mb-6"> {{-- Added bottom margin for spacing --}}
                        <a class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150" href="{{ route('roles.create') }}">
                            + Buat Role Baru
                        </a>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-md border border-gray-200"> {{-- Added a subtle background and border to the container --}}
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Assign Role ke: {{ $user->name }}</h2>

                        @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                        @endif

                        <form action="{{ route('users.assign-role.update', $user) }}" method="POST">
                            @csrf

                            <div class="mb-4"> {{-- Increased bottom margin for form group --}}
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Pilih Role:</label>
                                <select name="role" id="role" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('role') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex space-x-3"> {{-- Buttons side-by-side with spacing --}}
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Simpan
                                </button>
                                <a href="/users/assign-role"
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150">
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Toastr Script - moved outside of the main content div for better practice --}}
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