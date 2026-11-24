<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-sm border-b border-pink-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->can('admin') ? route('dashboard') : route('customer.index') }}" class="flex items-center gap-2">
                        <span class="w-9 h-9 rounded-xl bg-pink-100 text-pink-600 font-bold flex items-center justify-center border border-pink-200">
                            🧺
                        </span>
                        <span class="font-extrabold text-base tracking-tight text-gray-800">Laundry <span class="text-pink-500">Express</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-8 sm:flex">
                    @can('admin')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-sm font-semibold text-gray-700 hover:text-pink-600 border-b-2 border-transparent hover:border-pink-300">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')" class="text-sm font-semibold text-gray-700 hover:text-pink-600 border-b-2 border-transparent hover:border-pink-300">
                            {{ __('Kelola Layanan') }}
                        </x-nav-link>
                    @endcan
                    <x-nav-link :href="route('customer.index')" class="text-sm font-semibold text-pink-600 hover:text-pink-700 flex items-center gap-1">
                        {{ __('Halaman Pelanggan') }} <span class="text-xs">&rarr;</span>
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3.5 py-2 border border-pink-100 text-sm leading-4 font-semibold rounded-xl text-gray-700 bg-pink-50/50 hover:bg-pink-100/50 hover:text-pink-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1.5">
                                <svg class="fill-current h-4 w-4 text-pink-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="text-rose-600 hover:text-rose-700">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-pink-600 hover:text-pink-700 hover:bg-pink-50 focus:outline-none focus:bg-pink-50 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-pink-100">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @can('admin')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')">
                    {{ __('Kelola Layanan') }}
                </x-responsive-nav-link>
            @endcan
            <x-responsive-nav-link :href="route('customer.index')" class="text-pink-600">
                {{ __('Halaman Pelanggan') }} &rarr;
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-pink-100 px-4 bg-pink-50/30">
            <div>
                <div class="font-semibold text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-pink-600">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-rose-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
