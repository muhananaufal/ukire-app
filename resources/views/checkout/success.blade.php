<x-checkout-layout>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <div class="max-w-2xl mx-auto">
            <!-- Header Halaman -->
            <div class="text-center" data-aos="zoom-in">
                <svg class="mx-auto h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h1 class="mt-4 text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Pembayaran Berhasil
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Terima kasih! Pra-pesan Anda telah kami terima dan akan segera kami proses.
                </p>
            </div>

            <!-- WOW: Struk Nota Pembelian -->
            <div class="mt-12 bg-white border border-gray-200 rounded-lg shadow-sm" data-aos="fade-up"
                data-aos-delay="200">
                <!-- Header Struk -->
                <div class="p-6 sm:p-8 border-b border-gray-200 flex justify-between items-start">
                    <div>
                        <a href="{{ route('home') }}">
                            {{-- Menggunakan logo dengan teks untuk formalitas --}}
                            <img src="{{ asset('image/logo.png') }}" alt="Logo Ukire.id" class="h-8" />
                        </a>
                        <p class="mt-4 text-sm text-gray-500">Struk untuk Pesanan #{{ $order->id }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">Waktu Pesanan</p>
                        <p class="text-sm text-gray-500">
                            {{ $order->created_at->format('l, d F Y') }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $order->created_at->format('H:i:s') }}
                        </p>
                    </div>
                </div>

                <!-- Detail Item -->
                <div class="p-6 sm:p-8">
                    <div class="flow-root">
                        <ul role="list" class="-my-4 divide-y divide-gray-200">
                            @foreach ($order->items as $item)
                                <li class="flex items-center py-4">
                                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border bg-gray-100">
                                        <img src="{{ asset('storage/' . $item->product->images->first()?->image_path) }}"
                                            alt="{{ $item->product->name }}"
                                            class="h-full w-full object-cover object-center">
                                    </div>
                                    <div class="ml-4 flex flex-1 flex-col">
                                        <div>
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>{{ $item->product->name }}</h3>
                                                <p class="ml-4">Rp
                                                    {{ number_format(($item->price / 100) * $item->quantity, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">Kuantitas: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Total Harga -->
                <div class="border-t border-gray-200 p-6 sm:p-8">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Subtotal</dt>
                            <dd class="font-medium text-gray-900">Rp
                                {{ number_format($order->total_price / 100, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Biaya Pengiriman</dt>
                            <dd class="font-medium text-gray-900">Gratis</dd>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-between border-t border-gray-200 pt-6">
                        <p class="text-base font-bold text-gray-900">Total Pembayaran</p>
                        <p class="text-base font-bold text-gray-900">Rp
                            {{ number_format($order->total_price / 100, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-10 text-center ">
                <a href="{{ route('invoice.download', $order) }}"
                class="text-sm font-medium text-amber-600 hover:text-amber-500 block mb-5">Unduh
                Faktur (PDF)</a>
                <a href="{{ route('dashboard') }}"
                    class="inline-block bg-gray-900 text-white font-bold py-3 px-10 rounded-lg text-lg hover:bg-gray-700 transition-colors">
                    Lacak Pesanan di Dashboard
                </a>
            </div>
        </div>
    </div>
</x-checkout-layout>
