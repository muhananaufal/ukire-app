<header class="bg-white shadow-sm">
    <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">
                    Ukire.id
                </a>
            </div>

            <div class="hidden sm:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="{{ route('catalog.index') }}" class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Katalog</a>
                    {{-- Add other links here if needed --}}
                </div>
            </div>

            <div class="hidden sm:block">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-gray-800 text-white hover:bg-gray-700 px-4 py-2 rounded-md text-sm font-medium">Register</a>
                @endguest
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">My Account</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); this.closest('form').submit();" 
                           class="text-gray-500 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Logout
                        </a>
                    </form>
                @endauth
            </div>
        </div>
    </nav>
</header>