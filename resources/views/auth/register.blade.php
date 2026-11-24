<x-guest-layout>
    <div class="mb-5 text-center">
        <h2 class="text-xl font-bold text-gray-800">Daftar Akun Baru</h2>
        <p class="text-xs text-gray-500 mt-1">Buat akun untuk memesan layanan laundry</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full border-pink-200 focus:border-pink-500 focus:ring-pink-200 rounded-xl" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-600" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-pink-200 focus:border-pink-500 focus:ring-pink-200 rounded-xl" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-600" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />

            <x-text-input id="password" class="block mt-1 w-full border-pink-200 focus:border-pink-500 focus:ring-pink-200 rounded-xl"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-600" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-pink-200 focus:border-pink-500 focus:ring-pink-200 rounded-xl"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-rose-600" />
        </div>

        <div class="flex items-center justify-between mt-6 pt-2 border-t border-pink-100">
            <a class="text-xs text-pink-600 hover:text-pink-700 font-medium" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
