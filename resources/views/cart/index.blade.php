<x-app-layout>
    <div class="bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            @if (\Cart::isEmpty())
                <div class="text-center" data-aos="fade-up">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c.51 0 .962-.343 1.087-.835l1.823-6.44a1.125 1.125 0 00-1.087-1.462H6.31M15 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                    </svg>
                    <h1 class="mt-4 text-3xl font-extrabold text-gray-900 tracking-tight">Keranjang Belanja Anda Kosong
                    </h1>
                    <p class="mt-4 text-base text-gray-500">Sepertinya Anda belum menemukan karya yang tepat. Mari kita
                        cari bersama.</p>
                    <a href="{{ route('catalog.index') }}"
                        class="mt-8 inline-block bg-gray-900 text-white font-bold py-3 px-10 rounded-lg text-lg hover:bg-gray-700 transition-colors">
                        Mulai Berbelanja
                    </a>
                </div>
            @else
                <div class="text-center" data-aos="fade-up">
                    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Keranjang Belanja</h1>
                    <p class="mt-2 max-w-2xl mx-auto text-lg text-gray-600">Harap periksa kembali pesanan Anda sebelum
                        melanjutkan.</p>
                </div>

                <div class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16 items-start">
                    <div class="lg:col-span-2 space-y-6" data-aos="fade-right">
                        @foreach ($cartItems as $item)
                            <div class="flex items-start bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                <a href="{{ route('catalog.show', $item->attributes->slug) }}" class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $item->attributes->image) }}"
                                        alt="{{ $item->name }}"
                                        class="w-24 h-24 sm:w-32 sm:h-32 object-cover rounded-md">
                                </a>
                                <div class="ml-6 flex-grow">
                                    <a href="{{ route('catalog.show', $item->attributes->slug) }}" class="block">
                                        <h3 class="text-lg font-bold text-gray-900 hover:text-amber-600">
                                            {{ $item->name }}</h3>
                                    </a>
                                    <p class="mt-1 text-base font-semibold text-gray-800">Rp
                                        {{ number_format($item->price, 0, ',', '.') }}</p>
                                    <div class="mt-4 flex items-center">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <label for="quantity-{{ $item->id }}" class="sr-only">Kuantitas</label>
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                min="1" id="quantity-{{ $item->id }}"
                                                class="w-16 text-center rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                                            <button type="submit"
                                                class="ml-3 text-xs font-semibold text-amber-600 hover:text-amber-500">Update</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-gray-400 hover:text-red-500 transition-colors"
                                            aria-label="Hapus item">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <aside class="lg:col-span-1 lg:sticky lg:top-28" data-aos="fade-left">
                        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 border-b pb-4">Ringkasan Pesanan</h2>
                            <div class="space-y-4 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal ({{ \Cart::getTotalQuantity() }} item)</span>
                                    <span class="font-medium text-gray-900">Rp
                                        {{ number_format(\Cart::getSubTotal(), 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Biaya Pengiriman</span>
                                    <span class="font-medium text-gray-900">Dihitung saat checkout</span>
                                </div>
                            </div>
                            <div class="border-t my-6"></div>
                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span>Total</span>
                                <span>Rp {{ number_format(\Cart::getTotal(), 0, ',', '.') }}</span>
                            </div>

                            @auth
                                <a href="{{ route('checkout.index') }}"
                                    class="mt-8 w-full block text-center bg-gray-900 text-white py-3 px-4 rounded-md hover:bg-gray-700 transition-colors font-semibold">
                                    Lanjutkan ke Checkout
                                </a>
                            @else
                                <a href="{{ route('login', ['redirect' => 'cart.index']) }}"
                                    class="mt-8 w-full block text-center bg-gray-900 text-white py-3 px-4 rounded-md hover:bg-gray-700 transition-colors font-semibold">
                                    Masuk untuk Melanjutkan
                                </a>
                            @endauth
                            <div class="mt-6 text-center">
                                <p class="text-xs text-gray-500">Pembayaran aman dan terenkripsi</p>
                            </div>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
