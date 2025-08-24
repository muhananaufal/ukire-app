<x-app-layout>
    <div class="bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

            <!-- 1. Header Personal -->
            <div data-aos="fade-up">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Dashboard Anda
                </h1>
                <p class="mt-2 text-lg text-gray-600">
                    Selamat datang kembali, {{ Str::words(Auth::user()->name, 1, '') }}. Lacak pesanan aktif dan lihat
                    statistik belanja Anda di sini.
                </p>
            </div>

            <!-- 2. Konten Utama -->
            <div class="mt-10 gap-8 lg:gap-12 items-start">

                <!-- Kolom Kiri: Konten Dinamis -->
                <main class=" space-y-12">
                    <!-- WOW: Kartu Statistik (KPI Cards) -->
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

                    <!-- Pesanan Aktif -->
                    <section data-aos="fade-up" data-aos-delay="200">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Pesanan Aktif Anda</h2>
                        <div class="space-y-8">
                            @forelse ($activeOrders as $order)
                                <!-- Kartu Pesanan Interaktif -->
                                <div class="bg-white border border-gray-200 shadow-sm rounded-xl">
                                    <!-- Header Kartu -->
                                    <div
                                        class="p-6 border-b border-gray-200 grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <span class="font-semibold text-gray-800">Nomor Pesanan</span>
                                            <p class="text-gray-600 font-mono">#{{ $order->id }}</p>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-800">Tanggal</span>
                                            <p class="text-gray-600">{{ $order->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-800">Total</span>
                                            <p class="text-gray-600 font-bold">Rp
                                                {{ number_format($order->total_price / 100, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-gray-800">Status</span>
                                            <x-order-status :status="$order->status" />
                                        </div>
                                    </div>

                                    <!-- Linimasa Visual Progres Pesanan -->
                                    <div class="p-6">
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

                                    <!-- Detail & Aksi (Accordion) -->
                                    <div class="border-t border-gray-200" x-data="{ open: false }">
                                        <div @click="open = !open"
                                            class="p-6 cursor-pointer hover:bg-gray-50 flex justify-between items-center text-sm font-medium text-gray-700">
                                            <span>Lihat Detail Item</span>
                                            <svg class="h-5 w-5 transform transition-transform"
                                                :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div x-show="open" x-collapse.duration.500ms
                                            class="p-6 bg-gray-50 border-t border-gray-200">
                                            <div class="space-y-4">
                                                <div>
                                                    <h4 class="font-semibold text-gray-800 mb-2">Alamat Pengiriman:</h4>
                                                    <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $order->shipping_address }}
                                                    </p>                                    <h4 class="font-semibold text-gray-800 mb-2">Nomor Handphone:</h4>
                                                    <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $order->phone }}
                                                    </p>
                                                </div>
                                                @foreach ($order->items as $item)
                                                    <div class="flex justify-between items-start">
                                                        <div class="flex items-start space-x-4">
                                                            <img src="{{ asset('storage/' . $item->product->images->first()?->image_path) }}"
                                                                class="w-16 h-16 object-cover rounded-md">
                                                            <div>
                                                                <p class="font-semibold text-gray-900">
                                                                    {{ $item->product->name }}</p>
                                                                <p class="text-sm text-gray-500">{{ $item->quantity }}
                                                                    x Rp
                                                                    {{ number_format($item->price / 100, 0, ',', '.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <p class="text-sm font-medium text-gray-800">Rp
                                                            {{ number_format(($item->price / 100) * $item->quantity, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mt-4 pt-4 border-t border-gray-200 flex items-center justify-between">
                                                <div class="flex items-center space-x-6">
                                                    <button wire:click="reorder({{ $order->id }})"
                                                        class="flex items-center text-sm font-medium text-amber-600 hover:text-amber-500">
                                                        <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M4 4v5h5M20 12A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M4 12A8.966 8.966 0 0112 3a8.966 8.966 0 015.982 2.275" />
                                                        </svg>
                                                        <span>Pesan Lagi</span>
                                                    </button>
                                                    <a href="{{ route('invoice.download', $order) }}"
                                                        class="flex items-center text-sm font-medium text-amber-600 hover:text-amber-500">
                                                        <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                        </svg>
                                                        <span>Unduh Faktur</span>
                                                    </a>
                                                    <a href="{{ route('order.show', $order) }}"
                                                        class="flex items-center text-sm font-medium text-amber-600 hover:text-amber-500">
                                                        <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                        </svg>
                                                        <span>Lihat Detail</span>
                                                    </a>
                                                </div>
                                                @if ($order->status == 'unpaid')
                                                    <div>
                                                        <button
                                                            onclick="payOrder('{{ route('order.pay', $order) }}', '{{ route('checkout.success', $order) }}', this)"
                                                            class="inline-flex items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                                            Lanjutkan Pembayaran
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <!-- "Empty State" yang Menginspirasi -->
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

                    <!-- WOW: Grafik Pembelian -->

                </main>

                <!-- Kolom Kanan: Navigasi Akun (Sticky) -->
                {{-- <aside class="lg:sticky lg:top-28" data-aos="fade-left">
                    <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Pengaturan Akun</h3>
                        <nav class="space-y-2">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center p-3 text-sm font-medium rounded-lg transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                                <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <span>Edit Profil & Keamanan</span>
                            </a>
                            <a href="{{ route('order.history') }}"
                                class="flex items-center p-3 text-sm font-medium rounded-lg transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                                <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                                <span>Lihat Semua Riwayat Pesanan</span>
                            </a>
                        </nav>
                    </div>
                </aside> --}}
            </div>

        </div>
    </div>
    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
    @endpush
</x-app-layout>
