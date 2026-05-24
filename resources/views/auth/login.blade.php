<x-guest-layout>
    <x-auth-card>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

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

                <!-- REGISTER -->
                @if (Route::has('register'))
                <p class="text-sm text-center text-gray-600">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}"
                        class="text-blue-600 hover:underline">
                        {{ __('Register') }}
                    </a>
                </p>
                @endif

            </div>
        </form>

    </x-auth-card>
</x-guest-layout>