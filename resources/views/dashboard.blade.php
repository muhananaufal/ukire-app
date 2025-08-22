<x-app-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Welcome, {{ Auth::user()->name }}!
        </h1>

        <div class="bg-white border border-gray-200 shadow-lg rounded-xl p-6 md:p-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">My Order History</h2>
            <div class="space-y-6">
                @forelse ($orders as $order)
                    <div class="border-b pb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-bold text-lg text-gray-800">Order #{{ $order->id }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d F Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-lg text-gray-800">Rp {{ number_format($order->total_price / 100, 0, ',', '.') }}</p>
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">
                                    {{ Str::ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-gray-500">You haven't placed any orders yet.</p>
                        <a href="{{ route('catalog.index') }}" class="mt-4 inline-block bg-gray-800 text-white py-2 px-4 rounded-md hover:bg-gray-700">Shop Now</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>