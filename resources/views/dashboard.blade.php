<x-app-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Welcome, {{ Auth::user()->name }}!
        </h1>

        <div class="bg-white border border-gray-200 shadow-lg rounded-xl">
            <div class="p-6 md:p-8 border-b">
                <h2 class="text-2xl font-semibold text-gray-900">My Order History</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse ($orders as $order)
                    <div x-data="{ open: false }">
                        <!-- Order Summary (Clickable Header) -->
                        <div @click="open = !open" class="p-6 cursor-pointer hover:bg-gray-50 flex justify-between items-center">
                            <div class="flex-grow grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="font-semibold text-gray-800">Order ID</span>
                                    <p class="text-gray-600">#{{ $order->id }}</p>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">Date</span>
                                    <p class="text-gray-600">{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">Total</span>
                                    <p class="text-gray-600 font-bold">Rp {{ number_format($order->total_price / 100, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800">Status</span>
                                    <x-order-status :status="$order->status" />
                                </div>
                            </div>
                            <div class="ml-4">
                                <svg class="w-6 h-6 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Order Details (Collapsible) -->
                        <div x-show="open" x-transition class="p-6 bg-gray-50 border-t">
                            <h3 class="font-semibold text-lg mb-4">Order Details</h3>
                            <div class="space-y-4">
                                @foreach ($order->items as $item)
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $item->quantity }} x Rp {{ number_format($item->price / 100, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="font-medium">Rp {{ number_format(($item->price / 100) * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-t my-4"></div>
                            <div class="mt-4">
                                <h4 class="font-semibold">Shipping Address</h4>
                                <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $order->shipping_address }}</p>
                            </div>

                            @if ($order->status == 'unpaid')
                                <div class="mt-6">
                                    <button onclick="payOrder('{{ route('order.pay', $order) }}', this)" class="w-full sm:w-auto bg-gray-800 text-white py-2 px-6 rounded-md hover:bg-gray-700 transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Pay Now
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center p-12">
                        <p class="text-gray-500">You haven't placed any orders yet.</p>
                        <a href="{{ route('catalog.index') }}" class="mt-4 inline-block bg-gray-800 text-white py-2 px-4 rounded-md hover:bg-gray-700">Shop Now</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        function payOrder(url, button) {
            // Nonaktifkan tombol untuk mencegah klik ganda
            button.disabled = true;
            button.textContent = 'Processing...';

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        button.disabled = false;
                        button.textContent = 'Pay Now';
                        return;
                    }

                    // Logika baru untuk menangani respons cerdas dari controller
                    if (data.status === 'paid_on_midtrans' || data.status === 'already_processed') {
                        alert(data.message + ' The page will now refresh.');
                        window.location.reload();
                        return;
                    }

                    if (data.status === 'token_generated') {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result){ 
                                // Alihkan ke halaman sukses untuk pengalaman yang lebih baik
                                window.location.href = result.finish_redirect_url; 
                            },
                            onPending: function(result){ alert("Waiting for your payment!"); },
                            onError: function(result){ alert("Payment failed!"); },
                            onClose: function(){
                                // Aktifkan kembali tombol jika popup ditutup
                                button.disabled = false;
                                button.textContent = 'Pay Now';
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Could not initiate payment. Please try again later.');
                    button.disabled = false;
                    button.textContent = 'Pay Now';
                });
        }
    </script>
    @endpush
</x-app-layout>