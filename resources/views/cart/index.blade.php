<x-app-layout>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 class="text-3xl font-bold text-gray-800 mb-8">Shopping Cart</h1>

      @if (session('success'))
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
              <span class="block sm:inline">{{ session('success') }}</span>
          </div>
      @endif

      @if (\Cart::isEmpty())
          <div class="text-center py-12">
              <p class="text-gray-500 text-lg">Your cart is empty.</p>
              <a href="{{ route('catalog.index') }}" class="mt-4 inline-block bg-gray-800 text-white py-2 px-4 rounded-md hover:bg-gray-700">Continue Shopping</a>
          </div>
      @else
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
              <div class="lg:col-span-2 space-y-4">
                  @foreach ($cartItems as $item)
                      <div class="flex items-center bg-white border border-gray-200 rounded-lg p-4">
                          <img src="{{ asset('storage/' . $item->attributes->image) }}" alt="" class="w-24 h-24 object-cover rounded-md mr-4">
                          <div class="flex-grow">
                              <a href="{{ route('catalog.show', $item->attributes->slug) }}" class="font-semibold text-lg hover:text-gray-700">{{ $item->name }}</a>
                              <p class="text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                          </div>
                          <div class="flex items-center space-x-4">
                              <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                  @csrf
                                  @method('PATCH')
                                  <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 rounded-md border-gray-300">
                                  <button type="submit" class="text-xs text-gray-500 hover:text-gray-800">Update</button>
                              </form>
                              <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="text-red-500 hover:text-red-700">&times;</button>
                              </form>
                          </div>
                      </div>
                  @endforeach
              </div>

              <aside class="lg:col-span-1">
                  <div class="bg-white border border-gray-200 rounded-lg p-6">
                      <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                      <div class="flex justify-between text-lg">
                          <span>Total</span>
                          <span class="font-bold">Rp {{ number_format(\Cart::getTotal(), 0, ',', '.') }}</span>
                      </div>
                      <a href="{{ route('checkout.index') }}" class="mt-6 w-full block text-center bg-gray-800 text-white py-3 px-4 rounded-md hover:bg-gray-700">
                        Proceed to Checkout
                    </a>
                  </div>
              </aside>
          </div>
      @endif
  </div>
</x-app-layout>