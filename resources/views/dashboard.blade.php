<x-app-layout>
    <div class="bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div data-aos="fade-up">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Dashboard Anda
                </h1>
                <p class="mt-2 text-lg text-gray-600">
                    Selamat datang kembali, {{ Str::words(Auth::user()->name, 1, '') }}. Lacak pesanan aktif dan lihat
                    statistik belanja Anda di sini.
                </p>
            </div>
            <div class="mt-10 gap-8 lg:gap-12 items-start">
                <main class=" space-y-12">
                    <section data-aos="fade-up">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik Seumur Hidup</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                                <p class="text-sm font-medium text-gray-500">Total Pengeluaran</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">Rp
                                    {{ number_format($stats['total_spent'] / 100, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                                <p class="text-sm font-medium text-gray-500">Jumlah Pesanan</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                            </div>
                            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                                <p class="text-sm font-medium text-gray-500">Produk Dibeli</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_items'] }}</p>
                            </div>
                        </div>
                        <section data-aos="fade-up" data-aos-delay="400" class="mt-7">
                            @livewire('user.purchase-chart')
                        </section>
                    </section>

                    <section data-aos="fade-up" data-aos-delay="200">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Pesanan Aktif Anda</h2>
                        <div class="space-y-8">
                            @forelse ($activeOrders as $order)
                                <div class="bg-white border border-gray-200 rounded-xl shadow-sm"
                                    wire:key="order-{{ $order->id }}">
                                    <div
                                        class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div class="flex items-center gap-4">
                                            <div>
                                                <p class="font-semibold text-gray-900">Pesanan #{{ $order->id }}</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $order->created_at->format('d F Y') }}</p>
                                            </div>
                                            <x-order-status :status="$order->status" />
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <a href="{{ route('invoice.download', $order) }}"
                                                class="flex text-sm font-medium text-amber-600 hover:text-amber-500">
                                                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                </svg>
                                                Unduh Faktur
                                            </a>
                                            <a href="{{ route('order.show', $order) }}"
                                                class="flex items-center text-sm font-medium text-amber-600 hover:text-amber-500">
                                                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                                <span>Lihat Detail</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <div class="flow-root">
                                            <ul class="-my-6 divide-y divide-gray-200">
                                                @foreach ($order->items as $item)
                                                    <li class="flex py-6">
                                                        <div
                                                            class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                            <img src="{{ asset('storage/' . $item->product->images->first()?->image_path) }}"
                                                                alt="{{ $item->product->name }}"
                                                                class="h-full w-full object-cover object-center">
                                                        </div>
                                                        <div class="ml-4 flex flex-1 flex-col">
                                                            <div>
                                                                <div
                                                                    class="flex justify-between text-base font-medium text-gray-900">
                                                                    <h3><a
                                                                            href="{{ route('catalog.show', $item->product) }}">{{ $item->product->name }}</a>
                                                                    </h3>
                                                                    <p class="ml-4">Rp
                                                                        {{ number_format(($item->price / 100) * $item->quantity, 0, ',', '.') }}
                                                                    </p>
                                                                </div>
                                                                <p class="mt-1 text-sm text-gray-500">Kuantitas:
                                                                    {{ $item->quantity }}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="px-6 py-5 border-t border-gray-200 bg-gray-50/70">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                            <div>
                                                <h4 class="flex items-center text-sm font-semibold text-gray-900 mb-2">

                                                    <svg xmlns="https://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="h-5 w-5 mr-2 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                                    </svg>

                                                    Informasi Pengiriman
                                                </h4>
                                                <div class="text-sm text-gray-600 space-y-1 pl-7">
                                                    <p><strong>Penerima:</strong> {{ $order->recipient_name }}</p>
                                                    <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
                                                    <p><strong>Telepon:</strong> {{ $order->phone }}</p>
                                                </div>
                                            </div>
                                            <div class="text-left md:text-right">
                                                <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                                                <p class="text-2xl font-bold text-gray-900">
                                                    Rp {{ number_format($order->total_price / 100, 0, ',', '.') }}
                                                </p>
                                                <div class="mt-4 flex items-center md:justify-end space-x-4">
                                                    @if ($order->status == 'unpaid')
                                                        <button
                                                            onclick="payOrder('{{ route('order.pay', $order) }}', '{{ route('checkout.success', $order) }}', this)"
                                                            class="inline-flex items-center justify-center rounded-md bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-amber-600 transition-colors">
                                                            Bayar Sekarang
                                                        </button>
                                                    @endif
                                                    <button wire:click="reorder({{ $order->id }})"
                                                        class="inline-flex items-center justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                                        <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 4v5h5M20 12A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M4 12A8.966 8.966 0 0112 3a8.966 8.966 0 015.982 2.275" />
                                                        </svg>
                                                        Pesan Lagi
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-t border-gray-200" x-data="{ open: false }">
                                        <div @click="open = !open"
                                            class="px-6 py-3 cursor-pointer hover:bg-gray-50 flex justify-between items-center text-xs font-medium text-gray-500">
                                            <span>Lihat Detail Perjalanan Pesanan</span>
                                            <svg class="h-4 w-4 transform transition-transform"
                                                :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div x-show="open" x-collapse.duration.500ms class="p-6 bg-gray-50/50">
                                            @php
                                                $statusSteps = [
                                                    'unpaid' => 1,
                                                    'processing' => 2,
                                                    'shipped' => 3,
                                                    'completed' => 4,
                                                ];
                                                $currentStep = $statusSteps[$order->status] ?? 0;
                                            @endphp
                                            <ol class="grid grid-cols-4 gap-4 text-center text-sm">
                                                <li class="flex flex-col items-center">
                                                    <div
                                                        class="w-full h-1 {{ $currentStep >= 1 ? 'bg-amber-500' : 'bg-gray-200' }}">
                                                    </div>
                                                    <p
                                                        class="mt-2 font-medium {{ $currentStep >= 1 ? 'text-amber-600' : 'text-gray-500' }}">
                                                        Pesanan Dibuat</p>
                                                </li>
                                                <li class="flex flex-col items-center">
                                                    <div
                                                        class="w-full h-1 {{ $currentStep >= 2 ? 'bg-amber-500' : 'bg-gray-200' }}">
                                                    </div>
                                                    <p
                                                        class="mt-2 font-medium {{ $currentStep >= 2 ? 'text-amber-600' : 'text-gray-500' }}">
                                                        Dalam Produksi</p>
                                                </li>
                                                <li class="flex flex-col items-center">
                                                    <div
                                                        class="w-full h-1 {{ $currentStep >= 3 ? 'bg-amber-500' : 'bg-gray-200' }}">
                                                    </div>
                                                    <p
                                                        class="mt-2 font-medium {{ $currentStep >= 3 ? 'text-amber-600' : 'text-gray-500' }}">
                                                        Dikirim</p>
                                                </li>
                                                <li class="flex flex-col items-center">
                                                    <div
                                                        class="w-full h-1 {{ $currentStep >= 4 ? 'bg-amber-500' : 'bg-gray-200' }}">
                                                    </div>
                                                    <p
                                                        class="mt-2 font-medium {{ $currentStep >= 4 ? 'text-amber-600' : 'text-gray-500' }}">
                                                        Selesai</p>
                                                </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center border-2 border-dashed border-gray-300 rounded-xl p-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M12 6.253v11.494m-5.747-5.747h11.494" />
                                    </svg>
                                <h3 class="mt-4 text-xl font-semibold text-gray-900">Anda Tidak Memiliki Pesanan
                                        Aktif</h3>
                                    <p class="mt-2 text-gray-500">Semua pesanan Anda sudah selesai, atau mungkin
                                        petualangan Anda baru akan dimulai.</p>
                                    <a href="{{ route('catalog.index') }}"
                                        class="mt-6 inline-block bg-gray-900 text-white font-bold py-3 px-8 rounded-lg text-lg hover:bg-gray-700 transition-colors">
                                        Jelajahi Koleksi
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
    @endpush
</x-app-layout>
