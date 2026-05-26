<x-guest-layout>
    <x-auth-card>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        {{-- INFO NOTICE --}}
        <div class="mb-4 rounded-lg bg-yellow-50 border border-yellow-300 text-yellow-800 p-4 text-sm">
            <p class="font-bold">Keterangan Akses Sistem</p>

            <ul class="list-disc ml-5 mt-2 space-y-1">
                <li><b>Admin / Operator</b> dapat login menggunakan akun resmi</li>
                <li><b>Pengguna umum</b> tidak perlu login untuk input data</li>
                <li>Gunakan link pendaftaran untuk mengisi data pengamal</li>
            </ul>

            <div class="mt-3">
                <a href="{{ route('pengamal.public.create') }}"
                    class="inline-block text-green-700 font-semibold hover:underline">
                    ➜ Klik di sini untuk Pendaftaran Pengamal
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="grid gap-6">

                <!-- HEADER -->
                <div class="text-center bg-green-800 text-white py-6 rounded-lg">
                    <div class="flex justify-center mb-2">
                        <img src="{{ asset('image/logo.png') }}" width="90">
                    </div>

                    <p class="font-bold text-3xl tracking-wide">
                        SINTAK
                    </p>

                    <p class="uppercase text-sm mt-1">
                        Sistem Informasi Terpadu Pengamal <br>
                        Kalimantan Timur
                    </p>
                </div>

                <!-- EMAIL -->
                <div class="space-y-2">
                    <x-form.label for="email" :value="__('Email')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-envelope class="w-5 h-5 text-gray-500" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="email"
                            class="block w-full"
                            type="email"
                            name="email"
                            :value="old('email')"
                            placeholder="Email"
                            required
                            autofocus />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- PASSWORD -->
                <div class="space-y-2">
                    <x-form.label for="password" :value="__('Password')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-500" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="password"
                            class="block w-full"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Password" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- REMEMBER + FORGOT -->
                <div class="flex items-center justify-between">

                    <label class="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                            name="remember">

                        <span class="ml-2 text-sm text-gray-600">
                            {{ __('Remember me') }}
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:underline"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                    @endif

                </div>

                <!-- LOGIN BUTTON -->
                <div>
                    <x-button class="w-full justify-center gap-2 bg-green-700 hover:bg-green-800">

                        <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5" />

                        <span>{{ __('Log in') }}</span>

                    </x-button>
                </div>

            </div>
        </form>

    </x-auth-card>
</x-guest-layout>