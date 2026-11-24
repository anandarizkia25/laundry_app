<x-guest-layout>
    <div class="mb-5 text-center">
        <h2 class="text-xl font-bold text-gray-800">Selamat Datang Kembali</h2>
        <p class="text-xs text-gray-500 mt-1">Masuk untuk mengelola laundry Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-pink-200 focus:border-pink-500 focus:ring-pink-200 rounded-xl" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-600" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />

            <x-text-input id="password" class="block mt-1 w-full border-pink-200 focus:border-pink-500 focus:ring-pink-200 rounded-xl"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-600" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-md border-pink-300 text-pink-500 shadow-xs focus:ring-pink-200" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6 pt-2 border-t border-pink-100">
            @if (Route::has('password.request'))
                <a class="text-xs text-pink-600 hover:text-pink-700 font-medium" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @else
                <span></span>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="mt-5 text-center text-xs text-gray-500">
            Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-pink-600 hover:text-pink-700 underline">Daftar sekarang</a>
        </div>
    </form>
</x-guest-layout>
