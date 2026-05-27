<x-guest-layout>
    <x-auth-card>

        {{-- HEADER LOGO SYSTEM --}}
        <div class="text-center bg-green-800 text-white py-6 rounded-lg mb-6">

            <div class="flex justify-center mb-3">
                <img src="{{ asset('image/logo.png') }}" width="90" alt="logo">
            </div>

            <p class="font-bold text-3xl tracking-wide">
                SINTAK
            </p>

            <p class="uppercase text-sm mt-1">
                Sistem Informasi Terpadu Pengamal <br>
                Kalimantan Timur
            </p>

        </div>

        {{-- INFO NOTICE --}}
        <div class="mb-4 rounded-lg bg-yellow-50 border border-yellow-300 text-yellow-800 p-4 text-sm">
            <p class="font-bold">Keterangan Akses Sistem</p>

            <ul class="list-disc ml-5 mt-2 space-y-1">
                <li>Akun <b>hanya untuk admin / operator</b></li>
                <li>User umum <b>tidak perlu register</b> untuk mengisi data pengamal</li>
                <li>Gunakan fitur <b>Pendaftaran Pengamal (Publik)</b></li>
            </ul>

            <div class="mt-3">
                <a href="{{ route('pengamal.public.create') }}"
                    class="inline-block text-green-700 font-semibold hover:underline">
                    ➜ Klik di sini untuk Pendataan Pengamal
                </a>
            </div>
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid gap-6">

                <!-- Name -->
                <div class="space-y-2">
                    <x-form.label for="name" :value="__('Name')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-user class="w-5 h-5" aria-hidden="true" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="name"
                            class="block w-full"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                            placeholder="Name" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Email Address -->
                <div class="space-y-2">
                    <x-form.label for="email" :value="__('Email')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-envelope class="w-5 h-5" aria-hidden="true" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="email"
                            class="block w-full"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            placeholder="Email" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <x-form.label for="password" :value="__('Password')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-lock-closed class="w-5 h-5" aria-hidden="true" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="password"
                            class="block w-full"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Password" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <x-form.label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-lock-closed class="w-5 h-5" aria-hidden="true" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="password_confirmation"
                            class="block w-full"
                            type="password"
                            name="password_confirmation"
                            required
                            placeholder="Confirm Password" />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Button -->
                <div>
                    <x-button class="justify-center w-full gap-2 bg-green-700 hover:bg-green-800">
                        <x-heroicon-o-user-plus class="w-6 h-6" aria-hidden="true" />
                        <span>{{ __('Register') }}</span>
                    </x-button>
                </div>

                <!-- Login Link -->
                <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                    {{ __('Already registered?') }}
                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">
                        {{ __('Login') }}
                    </a>
                </p>

            </div>
        </form>

    </x-auth-card>
</x-guest-layout>