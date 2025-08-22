<footer class="bg-gray-800 text-white mt-16">
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center space-x-6 mb-4">
            <a href="{{ route('static.page', 'about-us') }}" class="text-gray-400 hover:text-white transition-colors">About Us</a>
            {{-- <a href="{{ route('static.page', 'terms-and-conditions') }}" class="text-gray-400 hover:text-white transition-colors">Terms</a> --}}
            {{-- <a href="{{ route('static.page', 'privacy-policy') }}" class="text-gray-400 hover:text-white transition-colors">Privacy</a> --}}
        </div>
        <div class="text-center">
            <p>&copy; {{ date('Y') }} Ukire.id. All Rights Reserved.</p>
            <p class="text-sm text-gray-400 mt-2">Premium Wood Furniture, Crafted for You.</p>
        </div>
    </div>
</footer>