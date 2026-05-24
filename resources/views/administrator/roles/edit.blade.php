<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-bold text-gray-800">
                Edit Role
            </h2>

            <div class="text-sm text-gray-500">
                Manage role & permissions
            </div>
        </div>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- WELCOME CARD --}}
        <div class="mb-6">
            <div class="bg-gradient-to-r from-green-700 to-emerald-600 rounded-xl shadow-md p-5 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-80">Wilayah Aktif</p>
                        <h3 class="text-xl font-bold uppercase">
                            {{ auth()->user()->wilayah }}
                        </h3>
                    </div>
                    <div class="text-right text-sm opacity-80">
                        {{ now()->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM CARD --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">

            {{-- HEADER --}}
            <div class="p-5 border-b border-gray-100">
                <h1 class="text-lg font-semibold text-gray-800">
                    Edit Role: <span class="text-blue-600">{{ $role->name }}</span>
                </h1>
            </div>

            {{-- FORM --}}
            <form action="{{ route('roles.update', $role) }}" method="POST" class="p-5 space-y-6">
                @csrf
                @method('PUT')

                {{-- ROLE NAME --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Role
                    </label>

                    <input type="text"
                        name="name"
                        value="{{ $role->name }}"
                        required
                        class="w-full md:w-1/2 rounded-lg border-gray-200 shadow-sm
                                  focus:border-blue-500 focus:ring focus:ring-blue-200"
                        placeholder="Masukkan nama role">
                </div>

                {{-- PERMISSIONS --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Permissions
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">

                        @foreach($permissions as $permission)
                        <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-100 hover:bg-gray-50 cursor-pointer">

                            <input type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->name }}"
                                {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600
                                          focus:ring-blue-200">

                            <span class="text-sm text-gray-700">
                                {{ $permission->name }}
                            </span>
                        </label>
                        @endforeach

                    </div>
                </div>

                {{-- ACTION --}}
                <div class="flex flex-col md:flex-row gap-3 md:items-center">

                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('roles.index') }}"
                        class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-center">
                        Kembali
                    </a>

                </div>

            </form>
        </div>
    </div>

    {{-- TOAST --}}
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: "4000",
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