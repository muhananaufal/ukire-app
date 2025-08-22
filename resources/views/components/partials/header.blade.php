<header x-data="{ open: false }" class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">
                    Ukire.id
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                <a href="{{ route('catalog.index') }}" class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors">Katalog</a>
                <a href="{{ route('cart.index') }}" class="relative text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                    Cart
                    @if (isset($cartCount) && $cartCount > 0)
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-gray-800 text-white hover:bg-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors">Register</a>
                    @endguest
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors">My Account</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <a href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); this.closest('form').submit();" 
                               class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                Logout
                            </a>
                        </form>
                    @endauth
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center sm:hidden">
                <a href="{{ route('cart.index') }}" class="relative text-gray-500 hover:text-gray-900 p-2 rounded-md mr-2">
                    <!-- Cart Icon -->
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    @if (isset($cartCount) && $cartCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-500">
                    <span class="sr-only">Open main menu</span>
                    <svg x-show="!open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu, show/hide based on menu state. -->
    <div x-show="open" x-transition class="sm:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('catalog.index') }}" class="text-gray-700 hover:bg-gray-200 block px-3 py-2 rounded-md text-base font-medium">Katalog</a>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="px-2 space-y-1">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:bg-gray-200 block px-3 py-2 rounded-md text-base font-medium">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:bg-gray-200 block px-3 py-2 rounded-md text-base font-medium">Register</a>
                @endguest
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:bg-gray-200 block px-3 py-2 rounded-md text-base font-medium">My Account</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-700 hover:bg-gray-200 block px-3 py-2 rounded-md text-base font-medium">
                            Logout
                        </a>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</header>