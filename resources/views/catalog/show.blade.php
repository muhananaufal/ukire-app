<x-app-layout>
    <div class="bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <nav class="text-sm mb-8" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex space-x-2">
                    <li class="flex items-center"><a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Beranda</a></li>
                    <li class="flex items-center"><svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" /></svg><a href="{{ route('catalog.index') }}" class="text-gray-500 hover:text-gray-700">Katalog</a></li>
                    <li class="flex items-center"><svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" /></svg><a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="text-gray-500 hover:text-gray-700">{{ $product->category->name }}</a></li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
                
                <div x-data="{ 
                        images: {{ $product->images->pluck('image_path')->map(fn($path) => asset('storage/' . $path)) }},
                        activeIndex: 0,
                        next() { this.activeIndex = this.activeIndex === this.images.length - 1 ? 0 : this.activeIndex + 1; },
                        prev() { this.activeIndex = this.activeIndex === 0 ? this.images.length - 1 : this.activeIndex - 1; }
                     }" 
                     class="space-y-4 lg:sticky lg:top-28">
                    
                    <div class="relative aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border bg-gray-100" data-aos="fade-right">
                        <img :src="images[activeIndex]" alt="{{ $product->name }}" class="w-full h-full object-cover object-center transition-opacity duration-300">
                        <div x-show="images.length > 1" class="absolute inset-0 flex items-center justify-between px-4">
                            <button @click="prev()" class="bg-white/50 hover:bg-white/90 p-2 rounded-full transition-colors backdrop-blur-sm">
                                <svg class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                            </button>
                            <button @click="next()" class="bg-white/50 hover:bg-white/90 p-2 rounded-full transition-colors backdrop-blur-sm">
                                <svg class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                            </button>
                        </div>
                    </div>

                    <div x-show="images.length > 1" class="flex justify-center space-x-2">
                        <template x-for="(image, index) in images" :key="index">
                            <button @click="activeIndex = index" class="h-2 w-2 rounded-full transition-colors" :class="activeIndex === index ? 'bg-gray-900' : 'bg-gray-300 hover:bg-gray-500'"></button>
                        </template>
                    </div>

                    <div x-show="images.length > 1" class="grid grid-cols-5 gap-4">
                        <template x-for="(image, index) in images" :key="index">
                            <div @click="activeIndex = index" class="aspect-w-1 aspect-h-1 rounded-md overflow-hidden cursor-pointer border-2" :class="activeIndex === index ? 'border-amber-500' : 'border-transparent'">
                                <img :src="image" alt="" class="w-full h-full object-cover object-center">
                            </div>
                        </template>
                    </div>
                </div>

                <div data-aos="fade-left">
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}</h1>
                    <p class="mt-4 text-3xl text-gray-800">Rp {{ number_format($product->price / 100, 0, ',', '.') }}</p>
                    
                    <div class="mt-6 prose prose-lg max-w-none text-gray-600">
                        <p>{!! Str::limit(strip_tags($product->description), 180) !!}</p>
                    </div>

                    <form action="{{ route('cart.store') }}" method="POST" class="mt-8" x-data="{ quantity: 1 }">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <button @click.prevent="quantity = Math.max(1, quantity - 1)" type="button" class="px-3 py-2 text-gray-500 hover:text-gray-800">&minus;</button>
                                <input x-model="quantity" type="number" name="quantity" id="quantity" min="1" class="w-28 text-center border-l border-r border-gray-300 focus:ring-0 focus:border-gray-300">
                                <button @click.prevent="quantity++" type="button" class="px-3 py-2 text-gray-500 hover:text-gray-800">&plus;</button>
                            </div>
                            <button type="submit" class="flex-1 bg-gray-900 text-white py-3 px-8 rounded-md text-base font-semibold hover:bg-gray-700 transition-colors">
                                Pre-Order Sekarang
                            </button>
                        </div>
                    </form>

                    <div x-data="{ openAccordions: ['description', 'details'] }" class="mt-10 border-t border-gray-200 divide-y divide-gray-200">
                        {{-- Accordion 1: Deskripsi --}}
                        <div>
                            <h2>
                                <button @click="openAccordions.includes('description') ? openAccordions = openAccordions.filter(i => i !== 'description') : openAccordions.push('description')" type="button" class="flex items-center justify-between w-full py-4 font-medium text-left">
                                    <span class="text-base text-gray-900">Deskripsi Lengkap</span>
                                    <svg class="h-6 w-6 transform transition-transform" :class="{ '-rotate-180': openAccordions.includes('description') }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                            </h2>
                            <div x-show="openAccordions.includes('description')" x-collapse.duration.500ms class="pb-4 prose prose-sm max-w-none text-gray-600">
                                {!! $product->description !!}
                            </div>
                        </div>
                        {{-- Accordion 2: Detail Produk --}}
                        <div>
                            <h2>
                                <button @click="openAccordions.includes('details') ? openAccordions = openAccordions.filter(i => i !== 'details') : openAccordions.push('details')" type="button" class="flex items-center justify-between w-full py-4 font-medium text-left">
                                    <span class="text-base text-gray-900">Detail Produk</span>
                                    <svg class="h-6 w-6 transform transition-transform" :class="{ '-rotate-180': openAccordions.includes('details') }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                            </h2>
                            <div x-show="openAccordions.includes('details')" x-collapse.duration.500ms class="pb-4 text-sm text-gray-600">
                                <dl class="space-y-2">
                                    <div class="flex justify-between"><dt>Material:</dt><dd class="font-medium text-gray-900">{{ $product->material }}</dd></div>
                                    <div class="flex justify-between"><dt>Dimensi:</dt><dd class="font-medium text-gray-900">{{ $product->dimensions }}</dd></div>
                                    <div class="flex justify-between"><dt>Estimasi Pre-Order:</dt><dd class="font-medium text-gray-900">{{ $product->preorder_estimate }}</dd></div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-gray-50 py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div data-aos="fade-up">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Anda Mungkin Juga Suka</h2>
                <p class="mt-2 text-gray-600">Produk lain dari koleksi {{ $product->category->name }} kami.</p>
            </div>
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($relatedProducts as $relatedProduct)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <x-product-card :product="$relatedProduct" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>