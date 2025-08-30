@props(['atTop' => false])

<header
    :class="{
        'bg-white/80 backdrop-blur-lg shadow-sm border-b border-gray-200/80': atTop,
        'text-gray-900 bg-white/30 backdrop-blur-lg shadow-sm': !atTop
    }"
    class="sticky top-0 z-50 transition-all duration-300" x-data="{ mobileMenuOpen: false, profileDropdownOpen: false }"
    @click.away="profileDropdownOpen = false">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8 z-99">
        <div class="flex justify-between items-center h-20">
            <div class="flex-shrink-0" style="z-index: 99;">
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight text-gray-800">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Ukire" class="h-8" /> </a>
            </div>

            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                <a href="{{ route('catalog.index') }}"
                    class="text-sm font-medium transition-colors pb-1 border-b-2 {{ request()->routeIs('catalog.*') ? 'border-amber-500' : 'border-transparent' }}"
                    :class="{
                        'text-gray-900 hover:border-gray-300': atTop,
                        'text-gray-900 hover:border-gray-300':
                            !atTop
                    }">Katalog</a>
                <a href="{{ route('static.page', 'about-us') }}"
                    class="text-sm font-medium transition-colors pb-1 border-b-2 {{ request()->routeIs('static.page') ? 'border-amber-500' : 'border-transparent' }}"
                    :class="{
                        'text-gray-900 hover:border-gray-300': atTop,
                        'text-gray-900 hover:border-gray-300':
                            !atTop
                    }">Tentang
                    Kami</a>
            </div>

            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                <a href="{{ route('cart.index') }}" class="relative p-2 rounded-full"
                    :class="{ 'text-gray-500 hover:text-gray-900': atTop, 'text-gray-900 hover:text-gray-500': !atTop }">
                    <svg class="h-6 w-6" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.658-.463 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z">
                        </path>
                    </svg>

                    @if (isset($cartCount) && $cartCount > 0)
                        <span class="absolute top-1 right-1 block h-2 w-2 rounded-full bg-amber-500 ring-2"
                            :class="{ 'ring-white': atTop, 'ring-gray-900': !atTop }"></span>
                    @endif
                </a>
                @guest
                    <a href="{{ route('login') }}"
                        :class="{ 'text-gray-500 hover:text-gray-900': atTop, 'text-gray-900 hover:text-gray-500': !atTop }"
                        class="text-sm font-medium transition-colors">Masuk</a>

                    <a href="{{ route('register') }}"
                        :class="{
                            'bg-gray-900 text-white hover:bg-gray-700': atTop,
                            'bg-gray-300 text-gray-900 hover:bg-gray-200':
                                !atTop
                        }"
                        class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-300">Daftar</a>
                @endguest
                @auth
                    <div class="relative">
                        <button @click="profileDropdownOpen = !profileDropdownOpen"
                            class="flex items-center space-x-2 text-sm font-medium transition-colors"
                            :class="{
                                'text-gray-500 hover:text-gray-900': atTop,
                                'text-gray-900/80 hover:text-gray-500': !
                                    atTop
                            }">
                            <span>{{ Str::words(Auth::user()->name, 1, '') }}</span>
                            <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': profileDropdownOpen }"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="profileDropdownOpen" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-64 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            x-cloak>

                            <div class="px-4 py-3 border-b border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold">
                                        {{ Auth::user()->initials }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('dashboard') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('order.history') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    <span>Riwayat Pesanan</span>
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Profil</span>
                                </a>
                            </div>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">
                                    <svg class="mr-3 h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                    <span>Logout</span>
                                </a>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="inline-flex items-center justify-center p-2 rounded-md focus:outline-none"
                    :class="{ 'text-gray-900': atTop, 'text-gray-900 ': !atTop }">
                    <span class="sr-only">Buka menu utama</span>
                    <svg x-show="!mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24"
                        style="z-index: 99;" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <div x-show="mobileMenuOpen" x-transition:enter="duration-300 ease-out" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="duration-200 ease-in"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="sm:hidden fixed inset-0 bg-white/75 backdrop-blur-lg shadow-sm z-40 pb-6">
        <div class="flex flex-col h-full justify-between">
            <div class="space-y-4 pt-20 text-center bg-white/75 backdrop-blur-lg shadow-sm">
                <a href="{{ route('catalog.index') }}"
                    class="block text-2xl font-bold text-gray-800 hover:text-amber-600">Katalog</a>
                <a href="{{ route('static.page', 'about-us') }}"
                    class="block text-2xl font-bold text-gray-800 hover:text-amber-600">Tentang Kami</a>
                <a href="{{ route('cart.index') }}"
                    class="block text-2xl font-bold text-gray-800 hover:text-amber-600">Keranjang</a>
            </div>
            <div class="py-6 text-center bg-white/75 backdrop-blur-lg shadow-sm">
                @guest
                    <div class="flex justify-center">

                        <a href="{{ route('register') }}"
                            class="w-full max-w-40 block bg-slate-900 text-white hover:bg-slate-700 px-4 py-3 rounded-md font-medium transition-colors mx-6">Daftar</a>
                    </div>
                    <a href="{{ route('login') }}"
                        class="mt-4 block text-slate-800 hover:text-slate-900 font-medium transition-colors">Sudah punya
                        akun?
                        Masuk</a>
                @endguest
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="block text-2xl font-bold text-gray-800 hover:text-amber-600">Dashboard</a>
                    <a href="{{ route('profile.edit') }}"
                        class="block text-2xl font-bold text-gray-800 hover:text-amber-600 mt-4">Profil</a>
                    <a href="{{ route('order.history') }}"
                        class="block text-2xl font-bold text-gray-800 hover:text-amber-600 mt-4">Riwayat Pesanan</a>

                    <div class="mt-8 flex justify-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="w-full block bg-gray-900 max-w-40 text-white hover:bg-gray-700 px-4 py-3 rounded-md font-medium transition-colors">
                                Logout
                            </a>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</header>
