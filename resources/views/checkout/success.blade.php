<x-app-layout>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="max-w-2xl mx-auto text-center">
          <h1 class="text-4xl font-extrabold text-green-600">Thank You!</h1>
          <p class="mt-4 text-lg text-gray-600">Your pre-order has been placed successfully.</p>
          <div class="mt-8 bg-white border border-gray-200 rounded-lg p-6 text-left">
              <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
              <div class="space-y-2">
                  <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                  <p><strong>Date:</strong> {{ $order->created_at->format('d F Y') }}</p>
                  <p><strong>Total:</strong> Rp {{ number_format($order->total_price / 100, 0, ',', '.') }}</p>
                  <p><strong>Status:</strong> <span class="font-semibold text-blue-600">{{ Str::ucfirst($order->status) }}</span></p>
              </div>
              <p class="mt-6 text-sm text-gray-500">You can track the status of your order in your account dashboard. We will start production soon.</p>
          </div>
          <a href="{{ route('dashboard') }}" class="mt-8 inline-block w-full sm:w-auto bg-gray-800 text-white py-3 px-6 rounded-md hover:bg-gray-700">
              Go to My Account
          </a>
      </div>
  </div>
</x-app-layout>