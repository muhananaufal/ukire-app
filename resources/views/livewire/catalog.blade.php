<div>
    {{-- 1. Header Halaman yang Imersif --}}
    <section class="relative bg-gray-800 h-64 flex items-center justify-center text-center">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=2070" 
                 alt="Latar belakang tekstur kayu atau interior yang elegan" 
                 class="w-full h-full object-cover opacity-20">
        </div>
        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
            <h1 class="text-4xl font-extrabold text-white tracking-tight">Jelajahi Koleksi Kami</h1>
            <p class="mt-4 text-lg text-white/80">Temukan karya yang akan melengkapi kisah di rumah Anda.</p>
        </div>
    </section>

    {{-- 2. Konten Utama Katalog --}}
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            
            {{-- Kolom Kiri: Filter Interaktif --}}
            <aside class="lg:sticky lg:top-28 space-y-8" data-aos="fade-right">
                {{-- Filter Pencarian --}}
                <div>
                    <label for="search" class="sr-only">Cari Produk</label>
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.500ms="search" id="search"
                               class="block w-full rounded-md border-gray-300 bg-gray-50 pl-10 pr-4 py-3 text-base text-gray-900 placeholder-gray-500 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                               placeholder="Cari produk...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                        </div>
                    </div>
                </div>

                {{-- Filter Kategori --}}
                <div>
                    <h3 class="font-semibold text-gray-900 tracking-wider uppercase text-sm">Kategori</h3>
                    <div class="mt-4 space-y-2">
                        <a href="#" wire:click.prevent="$set('category', '')" 
                           class="block text-sm transition-colors {{ !$category ? 'text-amber-600 font-bold' : 'text-gray-600 hover:text-gray-900' }}">
                           Semua Kategori
                        </a>
                        @foreach ($categories as $cat)
                            <a href="#" wire:click.prevent="$set('category', '{{ $cat->slug }}')" 
                               class="block text-sm transition-colors {{ $category == $cat->slug ? 'text-amber-600 font-bold' : 'text-gray-600 hover:text-gray-900' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                
                {{-- Filter Pengurutan --}}
                <div>
                    <h3 class="font-semibold text-gray-900 tracking-wider uppercase text-sm">Urutkan</h3>
                    <select wire:model.live="sort" id="sort" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                        <option value="latest">Terbaru</option>
                        <option value="price_asc">Harga: Terendah ke Tertinggi</option>
                        <option value="price_desc">Harga: Tertinggi ke Terendah</option>
                    </select>
                </div>
            </aside>

            {{-- Kolom Kanan: Grid Produk --}}
            <main class="lg:col-span-3">
                {{-- WOW: Active Filter Pills & View Toggle --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-4 border-b border-gray-200">
                    <div class="flex items-center space-x-2 flex-wrap gap-y-2">
                        @if($search || $category)
                            <span class="text-sm font-semibold text-gray-700">Filter Aktif:</span>
                            @if($search)
                                <span class="inline-flex items-center py-1 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Cari: {{ $search }}
                                    <button wire:click="$set('search', '')" class="ml-2 text-gray-500 hover:text-gray-800 font-bold">&times;</button>
                                </span>
                            @endif
                            @if($category)
                                <span class="inline-flex items-center py-1 px-3 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ \App\Models\Category::where('slug', $category)->first()->name ?? '' }}
                                    <button wire:click="$set('category', '')" class="ml-2 text-gray-500 hover:text-gray-800 font-bold">&times;</button>
                                </span>
                            @endif
                            <a href="#" wire:click.prevent="clearFilters" class="text-sm font-medium text-amber-600 hover:text-amber-500">
                                Hapus Semua
                            </a>
                        @else
                             <p class="text-sm text-gray-600">
                                Menampilkan <span class="font-semibold">{{ $products->total() }}</span> produk.
                            </p>
                        @endif
                    </div>
                    {{-- WOW: View Toggle --}}
                    <div class="flex items-center space-x-1 mt-4 sm:mt-0">
                        <button wire:click="$set('viewType', 'grid')" class="{{ $viewType == 'grid' ? 'bg-gray-800 text-white' : 'bg-white text-gray-500 hover:bg-gray-100' }} p-2 rounded-md border border-gray-300 transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </button>
                        <button wire:click="$set('viewType', 'list')" class="{{ $viewType == 'list' ? 'bg-gray-800 text-white' : 'bg-white text-gray-500 hover:bg-gray-100' }} p-2 rounded-md border border-gray-300 transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                </div>

                {{-- Grid Produk & Indikator Loading --}}
                <div class="mt-8" wire:loading.class.delay="opacity-50 transition-opacity">
                    @if($viewType === 'grid')
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                            @forelse ($products as $product)
                                <div data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 50 }}">
                                    <x-product-card :product="$product" />
                                    <button wire:click="quickView({{ $product->id }})" class="w-full mt-2 text-sm font-semibold text-center text-gray-600 bg-gray-100 hover:bg-gray-200 py-2 rounded-md transition-colors">Lihat Cepat</button>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-16">
                                    <h3 class="text-xl font-semibold text-gray-800">Tidak Ada Produk Ditemukan</h3>
                                    <p class="mt-2 text-gray-500">Coba ubah atau hapus filter Anda.</p>
                                    <a href="#" wire:click.prevent="clearFilters" class="mt-6 inline-block bg-gray-800 text-white py-2 px-6 rounded-md hover:bg-gray-700">
                                        Hapus Semua Filter
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    @else
                        <div class="space-y-8">
                            @forelse ($products as $product)
                                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-6 p-4 border rounded-lg" data-aos="fade-up">
                                    <a href="{{ route('catalog.show', $product) }}" class="block sm:w-40 sm:flex-shrink-0">
                                        <img src="{{ asset('storage/' . $product->images->first()?->image_path) }}" class="w-full h-auto object-cover rounded-md">
                                    </a>
                                    <div class="flex-grow">
                                        <a href="{{ route('catalog.show', $product) }}" class="block">
                                            <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                                            <h3 class="text-lg font-bold text-gray-900 hover:text-amber-600">{{ $product->name }}</h3>
                                        </a>
                                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">{!! Str::limit(strip_tags($product->description), 200) !!}</p>
                                    </div>
                                    <div class="sm:w-48 sm:flex-shrink-0 sm:text-right flex flex-col items-start sm:items-end">
                                        <p class="text-xl font-bold text-gray-800">Rp {{ number_format($product->price / 100, 0, ',', '.') }}</p>
                                        <button wire:click="quickView({{ $product->id }})" class="w-full sm:w-auto mt-4 text-sm font-semibold text-center text-gray-600 bg-gray-100 hover:bg-gray-200 py-2 px-4 rounded-md transition-colors">Lihat Cepat</button>
                                    </div>
                                </div>
                            @empty
                                {{-- ... Status Kosong ... --}}
                            @endforelse
                        </div>
                    @endif
                </div>
                <div class="mt-12">{{ $products->links() }}</div>
            </main>
        </div>
    </div>

    @if($quickViewProduct)
        <div class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4" 
             x-data="{ open: true }" 
             x-show="open" 
             @keydown.escape.window="open = false; setTimeout(() => $wire.closeQuickView(), 300)"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-cloak>
            <div class="bg-white rounded-lg max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 overflow-hidden" 
                 @click.away="open = false; setTimeout(() => $wire.closeQuickView(), 300)"
                 x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="h-64 md:h-full bg-gray-100">
                    <img src="{{ asset('storage/' . $quickViewProduct->images->first()?->image_path) }}" class="w-full h-full object-cover">
                </div>
                <div class="p-8 flex flex-col">
                    <div class="flex-grow">
                        <p class="text-sm text-gray-500">{{ $quickViewProduct->category->name }}</p>
                        <h2 class="text-2xl font-bold mt-1">{{ $quickViewProduct->name }}</h2>
                        <div class="mt-4 prose prose-sm max-w-none text-gray-600">
                            {!! $quickViewProduct->description !!}
                        </div>
                    </div>
                    <div class="mt-8 border-t pt-6">
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($quickViewProduct->price / 100, 0, ',', '.') }}</p>
                        <a href="{{ route('catalog.show', $quickViewProduct) }}" class="mt-2 block text-sm text-amber-600 hover:text-amber-500 font-medium">Lihat detail lengkap &rarr;</a>
                        <form action="{{ route('cart.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $quickViewProduct->id }}">
                            <button type="submit" class="w-full bg-gray-800 text-white py-3 px-6 rounded-md text-base font-semibold hover:bg-gray-700 transition-colors">
                                Pre-Order Sekarang
                            </button>
                        </form>
                    </div>
                </div>
                <button @click="open = false; setTimeout(() => $wire.closeQuickView(), 300)" class="absolute top-4 right-4 text-gray-400 hover:text-gray-800">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    @endif
</div>