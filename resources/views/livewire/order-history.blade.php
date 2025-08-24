<div> {{-- <<-- INI ADALAH "NAMPAN" UTAMA KITA --}}
    <div class="bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">

            <div data-aos="fade-up">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Riwayat Pesanan</h1>
                <p class="mt-2 text-lg text-gray-600">Arsip lengkap perjalanan Anda bersama Ukire.id.</p>
            </div>

            <div class="mt-8 bg-white border border-gray-200 rounded-xl shadow-sm p-6" data-aos="fade-up"
                data-aos-delay="100">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 items-end">
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Pesanan</label>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="ID Pesanan atau Nama Produk..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    </div>
                    <div>
                        <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select wire:model.live="statusFilter"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="">Semua Status</option>
                            <option value="completed">Selesai</option>
                            <option value="shipped">Dikirim</option>
                            <option value="processing">Dalam Produksi</option>
                            <option value="unpaid">Belum Dibayar</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    <div>
                        <label for="dateFrom" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" wire:model.live="dateFrom"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    </div>
                    <div>
                        <label for="dateTo" class="block text-sm font-medium text-gray-700 mb-1">Sampai
                            Tanggal</label>
                        <input type="date" wire:model.live="dateTo"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    </div>
                </div>
            </div>

            <div class="mt-8" wire:loading.class.delay="opacity-50 transition-opacity">
                <div class="space-y-6">
                    @forelse ($orders as $order)
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm" x-data="{ open: false }"
                            wire:key="order-{{ $order->id }}">
                            <div @click="open = !open"
                                class="px-6 py-5 flex items-center justify-between cursor-pointer hover:bg-gray-50">
                                <div class="min-w-0 flex-1 grid grid-cols-2 sm:grid-cols-4 gap-4 items-center">
                                    <div class="text-sm">
                                        <p class="font-semibold text-gray-800">Nomor Pesanan</p>
                                        <p class="text-gray-600 font-mono">#{{ $order->id }}</p>
                                    </div>
                                    <div class="text-sm">
                                        <p class="font-semibold text-gray-800">Tanggal</p>
                                        <p class="text-gray-600">{{ $order->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div class="hidden sm:block text-sm">
                                        <p class="font-semibold text-gray-800">Total</p>
                                        <p class="text-gray-800 font-bold">Rp
                                            {{ number_format($order->total_price / 100, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-sm">
                                        <p class="font-semibold text-gray-800">Status</p><x-order-status
                                            :status="$order->status" />
                                    </div>
                                </div>
                                <div class="ml-4 flex items-center space-x-4">
                                    <svg class="h-5 w-5 text-gray-400 transform transition-transform"
                                        :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <div x-show="open" x-collapse.duration.500ms
                                class="px-6 pb-6 border-t border-gray-200 bg-gray-50/50">
                                <div class="py-6 gap-8">
                                    <div>
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
                                        <h4 class="text-sm font-medium text-gray-700 border-t py-6">Detail Item:</h4>
                                        <div class="border-t pt-6">
                                            <h4 class="font-semibold text-gray-800 mb-2">Alamat Pengiriman:</h4>
                                            <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $order->shipping_address }}
                                            </p>
                                            <h4 class="font-semibold text-gray-800 mb-2">Nomor Handphone:</h4>
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
                    @empty
                        <div class="text-center py-16 text-gray-500 border-2 border-dashed border-gray-300 rounded-xl">
                            <p>Tidak ada pesanan yang cocok dengan filter Anda.</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-8">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>

    {{-- Script dipindahkan ke dalam "nampan" utama --}}
    @push('scripts')
        <script>
            // Fungsi payOrder sekarang sudah global dari app.blade.php,
            // jadi kita tidak perlu menuliskannya lagi di sini.
            // Jika belum, pastikan Anda sudah memindahkannya.
        </script>
    @endpush
</div>
