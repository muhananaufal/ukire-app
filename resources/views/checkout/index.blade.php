<x-checkout-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-start">
                <div class="bg-white border border-gray-200 rounded-lg p-6 lg:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Kontak & Pengiriman</h2>
                        <a href="{{ route('cart.index') }}"
                            class="flex items-center text-sm font-medium text-amber-600 hover:text-amber-500">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Keranjang
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md"
                            role="alert">
                            <p class="font-bold">Terjadi Kesalahan</p>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-6">
                        <x-forms.floating-input type="email" name="email" label="Email" :value="old('email', auth()->user()->email)"
                            required />
                        <x-forms.floating-input type="text" name="name" label="Nama Lengkap" :value="old('name', auth()->user()->name)"
                            required />
                        <x-forms.floating-input type="text" name="shipping_address" label="Alamat Lengkap"
                            :value="old('shipping_address')" required placeholder="Jalan, Kota, Provinsi, Kode Pos" />
                        <x-forms.floating-input type="tel" name="phone" label="Nomor Telepon" :value="old('phone')"
                            required />
                    </div>
                </div>

                <aside class="lg:sticky lg:top-8">
                    <div class="bg-white border border-gray-200 rounded-lg p-6 lg:p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>
                        <div class="space-y-4">
                            @foreach ($cartItems as $item)
                                <div class="flex justify-between items-start">
                                    <div class="flex items-start space-x-4">
                                        <img src="{{ asset('storage/' . $item->attributes->image) }}"
                                            alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded-md">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $item->name }}</p>
                                            <p class="text-sm text-gray-500">Kuantitas: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <p class="text-sm font-medium text-gray-800">Rp
                                        {{ number_format($item->getPriceSum(), 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="border-t my-6"></div>
                        <div class="space-y-3 text-sm">
                            @php
                                $subtotal = $cartItems->sum(function ($item) {
                                    return $item->getPriceSum();
                                });
                            @endphp
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium text-gray-900">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Pengiriman</span>
                                <span class="font-medium text-gray-900">Gratis</span>
                            </div>
                        </div>
                        <div class="border-t my-6"></div>
                        <div class="flex justify-between text-lg font-bold text-gray-900">
                            <span>Total</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center rounded-md bg-gray-900 px-8 py-4 text-base font-semibold text-white shadow-sm hover:bg-gray-700 transition-colors">
                            Lanjutkan ke Pembayaran
                        </button>
                    </div>
                    <div class="mt-6 flex items-center justify-center space-x-2 text-gray-500">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">Checkout Aman & Terenkripsi</span>
                    </div>
                </aside>
            </div>
        </form>
    </div>
</x-checkout-layout>
