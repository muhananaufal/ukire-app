<x-app-layout>
  <section class="relative bg-gray-900 text-white h-[60vh] flex items-center justify-center">
      <div class="absolute inset-0">
          <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=2070" 
               alt="Elegant furniture background" 
               class="w-full h-full object-cover opacity-40">
      </div>
      <div class="relative z-10 text-center px-4">
          <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight">Crafted for Life</h1>
          <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-300">Experience timeless design and unparalleled craftsmanship with our pre-order wood furniture.</p>
          <a href="{{ route('catalog.index') }}" 
             class="mt-8 inline-block bg-white text-gray-900 font-bold py-3 px-8 rounded-lg text-lg hover:bg-gray-200 transition-colors">
             Explore Collection
          </a>
      </div>
  </section>

  <section class="py-16 sm:py-24">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
          <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Featured Collection</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
              @foreach ($featuredProducts as $product)
                  <x-product-card :product="$product" />
              @endforeach
          </div>
      </div>
  </section>

  <section class="bg-gray-50 py-16 sm:py-24">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
          <div class="text-center mb-12">
              <h2 class="text-3xl font-bold text-gray-900">Why Ukire.id?</h2>
              <p class="mt-2 text-lg text-gray-600">The art of wood, perfected for you.</p>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
              <div>
                  <h3 class="text-xl font-semibold text-gray-900">Handcrafted Quality</h3>
                  <p class="mt-2 text-gray-600">Each piece is meticulously crafted by skilled artisans, ensuring a unique and durable product.</p>
              </div>
              <div>
                  <h3 class="text-xl font-semibold text-gray-900">Sustainable Wood</h3>
                  <p class="mt-2 text-gray-600">We source our materials responsibly, honoring nature and bringing its beauty into your home.</p>
              </div>
              <div>
                  <h3 class="text-xl font-semibold text-gray-900">Custom Pre-Orders</h3>
                  <p class="mt-2 text-gray-600">Your furniture is made for you. Our pre-order system ensures quality and exclusivity.</p>
              </div>
          </div>
      </div>
  </section>

  <section class="py-16 sm:py-24">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
          <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">New Arrivals</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
              @foreach ($newestProducts as $product)
                  <x-product-card :product="$product" />
              @endforeach
          </div>
      </div>
  </section>

  <section class="bg-gray-900 text-white py-16 sm:py-24">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 class="text-3xl font-bold mb-8">What Our Customers Say</h2>
          <div class="max-w-3xl mx-auto">
              <p class="text-xl italic">"The craftsmanship is simply breathtaking. My dining table from Ukire.id has become the heart of our home. The pre-order wait was absolutely worth it."</p>
              <p class="mt-4 font-semibold text-gray-300">- Alex Johnson, Jakarta</p>
          </div>
      </div>
  </section>
</x-app-layout>