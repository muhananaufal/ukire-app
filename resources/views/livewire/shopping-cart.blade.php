<div class="bg-gray-50" x-data>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        @if ($cartItems->isEmpty())
            {{-- Tampilan Keranjang Kosong --}}
            <div class="text-center" data-aos="fade-up">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c.51 0 .962-.343 1.087-.835l1.823-6.44a1.125 1.125 0 00-1.087-1.462H6.31M15 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" /></svg>
                <h1 class="mt-4 text-3xl font-extrabold text-gray-900 tracking-tight">Keranjang Belanja Anda Kosong</h1>
                <p class="mt-4 text-base text-gray-500">Sepertinya Anda belum menemukan karya yang tepat. Mari kita cari bersama.</p>
                <a href="{{ route('catalog.index') }}" class="mt-8 inline-block bg-gray-900 text-white font-bold py-3 px-10 rounded-lg text-lg hover:bg-gray-700 transition-colors">
                    Mulai Berbelanja
                </a>
            </div>
        @else
            {{-- Tampilan Keranjang Jika Ada Isinya --}}
            <div class="text-center" data-aos="fade-up">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Keranjang Belanja</h1>
                <p class="mt-2 max-w-2xl mx-auto text-lg text-gray-600">Pilih item yang ingin Anda checkout, atau perbarui pesanan Anda.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-16 items-start">
                <div class="lg:col-span-2 space-y-6" data-aos="fade-right">
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox"
                                   @change="$wire.toggleAll($event.target.checked)"
                                   class="h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500"
                                   :checked="Object.values(@js($selectedItems)).every(value => value === true) && Object.values(@js($selectedItems)).length > 0">
                            <label class="text-sm font-medium text-gray-700">Pilih Semua</label>
                        </div>
                    </div>

                    @foreach ($cartItems as $item)
                        {{-- INI DIA SOLUSINYA: wire:key memastikan Livewire tahu item mana yang harus diupdate --}}
                        <div class="flex items-start bg-white border border-gray-200 rounded-lg p-6 shadow-sm" wire:key="cart-item-{{ $item->id }}">
                            <input type="checkbox" wire:model.live="selectedItems.{{ $item->id }}" class="h-4 w-4 mt-1 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                            
                            <a href="{{ route('catalog.show', $item->attributes->slug) }}" class="flex-shrink-0 ml-4">
                                <img src="{{ asset('storage/' . $item->attributes->image) }}" alt="{{ $item->name }}" class="w-24 h-24 sm:w-32 sm:h-32 object-cover rounded-md">
                            </a>

                            <div class="ml-6 flex-grow">
                                <a href="{{ route('catalog.show', $item->attributes->slug) }}"><h3 class="text-lg font-bold text-gray-900 hover:text-amber-600">{{ $item->name }}</h3></a>
                                <p class="mt-1 text-base font-semibold text-gray-800">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                <div class="mt-4 flex items-center">
                                    <label for="quantity-{{ $item->id }}" class="sr-only">Kuantitas</label>
                                    <input type="number" value="{{ $item->quantity }}" min="1" 
                                           wire:change="updateQuantity('{{ $item->id }}', $event.target.value)" 
                                           id="quantity-{{ $item->id }}" 
                                           class="w-20 text-center rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                                </div>
                            </div>

                            <div class="ml-4 flex-shrink-0">
                                <button wire:click="removeItem('{{ $item->id }}')" class="text-gray-400 hover:text-red-500 transition-colors" aria-label="Hapus item">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <aside class="lg:col-span-1 lg:sticky lg:top-28" data-aos="fade-left">
                    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 border-b pb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Pengiriman</span>
                                <span class="font-medium text-gray-900">Dihitung saat checkout</span>
                            </div>
                        </div>

                        <div class="border-t my-6"></div>

                        <div class="flex justify-between text-lg font-bold text-gray-900">
                            <span>Total</span>
                            <span class="text-right">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
                        </div>
                        
                        {{-- Logika Tombol Cerdas --}}
                        <div class="mt-8">
                            @if (collect($selectedItems)->filter()->count() > 0)
                                <button wire:click="proceedToCheckout" wire:loading.attr="disabled" class="w-full block text-center bg-gray-900 text-white py-3 px-4 rounded-md hover:bg-gray-700 transition-colors font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                                    Lanjutkan ke Checkout ({{ collect($selectedItems)->filter()->count() }} item)
                                </button>
                            @else
                                <button class="w-full block text-center bg-gray-300 text-gray-500 py-3 px-4 rounded-md font-semibold cursor-not-allowed">
                                    Pilih Item Dahulu
                                </button>
                            @endif
                        </div>
                        
                        <div class="mt-6 text-center">
                            <p class="text-xs text-gray-500">Pembayaran aman dan terenkripsi</p>
                        </div>
                    </div>
                </aside>
            </div>
        @endif
    </div>
</div>