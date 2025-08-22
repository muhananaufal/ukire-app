<x-app-layout>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>

      <form action="{{ route('checkout.store') }}" method="POST">
          @csrf
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
              <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg p-6">
                  <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>

                  @if ($errors->any())
                      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif

                  <div class="space-y-4">
                      <div>
                          <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                          <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" required
                                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800 sm:text-sm">
                      </div>
                      <div>
                          <label for="shipping_address" class="block text-sm font-medium text-gray-700">Full Address</label>
                          <textarea name="shipping_address" id="shipping_address" rows="4" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800 sm:text-sm"
                                    placeholder="Street, City, Province, Postal Code"></textarea>
                      </div>
                      <div>
                          <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                          <input type="tel" name="phone" id="phone" required
                                 class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800 sm:text-sm">
                      </div>
                  </div>
              </div>

              <aside class="lg:col-span-1">
                  <div class="bg-white border border-gray-200 rounded-lg p-6">
                      <h2 class="text-xl font-semibold mb-4">Your Order</h2>
                      <div class="space-y-3">
                          @foreach ($cartItems as $item)
                              <div class="flex justify-between">
                                  <span>{{ $item->name }} <span class="text-sm">x {{ $item->quantity }}</span></span>
                                  <span>Rp {{ number_format($item->getPriceSum(), 0, ',', '.') }}</span>
                              </div>
                          @endforeach
                      </div>
                      <div class="border-t my-4"></div>
                      <div class="flex justify-between text-lg font-bold">
                          <span>Total</span>
                          <span>Rp {{ number_format(\Cart::getTotal(), 0, ',', '.') }}</span>
                      </div>
                      <button type="submit" class="mt-6 w-full text-center bg-gray-800 text-white py-3 px-4 rounded-md hover:bg-gray-700">
                          Place Pre-Order
                      </button>
                  </div>
              </aside>
          </div>
      </form>
  </div>
</x-app-layout>