@section('hide_floating_whatsapp', true)

<x-app-layout>

    <div class="bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <nav class="text-sm mb-8" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex space-x-2">
                    <li class="flex items-center"><a href="{{ route('home') }}"
                            class="text-gray-500 hover:text-gray-700">Beranda</a></li>
                    <li class="flex items-center"><svg class="h-5 w-5 text-gray-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" />
                        </svg><a href="{{ route('catalog.index') }}"
                            class="text-gray-500 hover:text-gray-700">Katalog</a></li>
                    <li class="flex items-center"><svg class="h-5 w-5 text-gray-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" />
                        </svg><a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}"
                            class="text-gray-500 hover:text-gray-700">{{ $product->category->name }}</a></li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">

                <div x-data="{
                    images: {{ $product->images->pluck('image_path')->map(fn($path) => asset('storage/' . $path)) }},
                    activeIndex: 0,
                    next() { this.activeIndex = this.activeIndex === this.images.length - 1 ? 0 : this.activeIndex + 1; },
                    prev() { this.activeIndex = this.activeIndex === 0 ? this.images.length - 1 : this.activeIndex - 1; }
                }" class="space-y-4 lg:sticky lg:top-28">

                    <div class="relative aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border bg-gray-100"
                        data-aos="fade-right">
                        <img :src="images[activeIndex]" alt="{{ $product->name }}"
                            class="w-full h-full object-cover object-center transition-opacity duration-300">
                        <div x-show="images.length > 1" class="absolute inset-0 flex items-center justify-between px-4">
                            <button @click="prev()"
                                class="bg-white/50 hover:bg-white/90 p-2 rounded-full transition-colors backdrop-blur-sm">
                                <svg class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </button>
                            <button @click="next()"
                                class="bg-white/50 hover:bg-white/90 p-2 rounded-full transition-colors backdrop-blur-sm">
                                <svg class="h-6 w-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div x-show="images.length > 1" class="flex justify-center space-x-2">
                        <template x-for="(image, index) in images" :key="index">
                            <button @click="activeIndex = index" class="h-2 w-2 rounded-full transition-colors"
                                :class="activeIndex === index ? 'bg-gray-900' : 'bg-gray-300 hover:bg-gray-500'"></button>
                        </template>
                    </div>

                    <div x-show="images.length > 1" class="grid grid-cols-5 gap-4">
                        <template x-for="(image, index) in images" :key="index">
                            <div @click="activeIndex = index"
                                class="aspect-w-1 aspect-h-1 rounded-md overflow-hidden cursor-pointer border-2"
                                :class="activeIndex === index ? 'border-amber-500' : 'border-transparent'">
                                <img :src="image" alt=""
                                    class="w-full h-full object-cover object-center">
                            </div>
                        </template>
                    </div>
                </div>

                <div data-aos="fade-left">
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}
                    </h1>
                    <p class="mt-4 text-3xl text-gray-800">Rp {{ number_format($product->price / 100, 0, ',', '.') }}
                    </p>

                    <div class="mt-6 prose prose-lg max-w-none text-gray-600">
                        <p>{!! Str::limit(strip_tags($product->description), 180) !!}</p>
                    </div>

                    <form action="{{ route('cart.store') }}" method="POST" class="mt-8" x-data="{ quantity: 1 }">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="flex items-center space-x-4">
                            <div class="flex items-center border border-gray-300 rounded-md">
                                <button @click.prevent="quantity = Math.max(1, quantity - 1)" type="button"
                                    class="px-3 py-2 text-gray-500 hover:text-gray-800">&minus;</button>
                                <input x-model="quantity" type="number" name="quantity" id="quantity" min="1"
                                    class="w-28 text-center border-l border-r border-gray-300 focus:ring-0 focus:border-gray-300">
                                <button @click.prevent="quantity++" type="button"
                                    class="px-3 py-2 text-gray-500 hover:text-gray-800">&plus;</button>
                            </div>
                            <button type="submit"
                                class="flex-1 bg-gray-900 text-white py-3 px-8 rounded-md text-base font-semibold hover:bg-gray-700 transition-colors">
                                Pre-Order Sekarang
                            </button>
                        </div>
                    </form>

                    <a href="https://wa.me/{{ config('ukire.whatsapp_number') }}?text={{ urlencode('Halo Ukire.id, saya tertarik dengan produk ' . $product->name) }}"
                        target="_blank"
                        class="mt-3 w-full flex items-center justify-center bg-green-500 text-white py-2 px-8 rounded-md text-base font-semibold hover:bg-green-600 transition-colors gap-x-1">
                        <svg xmlns="https://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100"
                            viewBox="0 0 48 48" class="h-8 w-8">
                            <path fill="#fff"
                                d="M4.9,43.3l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5c5.1,0,9.8,2,13.4,5.6	C41,14.2,43,18.9,43,24c0,10.5-8.5,19-19,19c0,0,0,0,0,0h0c-3.2,0-6.3-0.8-9.1-2.3L4.9,43.3z">
                            </path>
                            <path fill="#fff"
                                d="M4.9,43.8c-0.1,0-0.3-0.1-0.4-0.1c-0.1-0.1-0.2-0.3-0.1-0.5L7,33.5c-1.6-2.9-2.5-6.2-2.5-9.6	C4.5,13.2,13.3,4.5,24,4.5c5.2,0,10.1,2,13.8,5.7c3.7,3.7,5.7,8.6,5.7,13.8c0,10.7-8.7,19.5-19.5,19.5c-3.2,0-6.3-0.8-9.1-2.3	L5,43.8C5,43.8,4.9,43.8,4.9,43.8z">
                            </path>
                            <path fill="#cfd8dc"
                                d="M24,5c5.1,0,9.8,2,13.4,5.6C41,14.2,43,18.9,43,24c0,10.5-8.5,19-19,19h0c-3.2,0-6.3-0.8-9.1-2.3	L4.9,43.3l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5 M24,43L24,43L24,43 M24,43L24,43L24,43 M24,4L24,4C13,4,4,13,4,24	c0,3.4,0.8,6.7,2.5,9.6L3.9,43c-0.1,0.3,0,0.7,0.3,1c0.2,0.2,0.4,0.3,0.7,0.3c0.1,0,0.2,0,0.3,0l9.7-2.5c2.8,1.5,6,2.2,9.2,2.2	c11,0,20-9,20-20c0-5.3-2.1-10.4-5.8-14.1C34.4,6.1,29.4,4,24,4L24,4z">
                            </path>
                            <path fill="#40c351"
                                d="M35.2,12.8c-3-3-6.9-4.6-11.2-4.6C15.3,8.2,8.2,15.3,8.2,24c0,3,0.8,5.9,2.4,8.4L11,33l-1.6,5.8	l6-1.6l0.6,0.3c2.4,1.4,5.2,2.2,8,2.2h0c8.7,0,15.8-7.1,15.8-15.8C39.8,19.8,38.2,15.8,35.2,12.8z">
                            </path>
                            <path fill="#fff" fill-rule="evenodd"
                                d="M19.3,16c-0.4-0.8-0.7-0.8-1.1-0.8c-0.3,0-0.6,0-0.9,0	s-0.8,0.1-1.3,0.6c-0.4,0.5-1.7,1.6-1.7,4s1.7,4.6,1.9,4.9s3.3,5.3,8.1,7.2c4,1.6,4.8,1.3,5.7,1.2c0.9-0.1,2.8-1.1,3.2-2.3	c0.4-1.1,0.4-2.1,0.3-2.3c-0.1-0.2-0.4-0.3-0.9-0.6s-2.8-1.4-3.2-1.5c-0.4-0.2-0.8-0.2-1.1,0.2c-0.3,0.5-1.2,1.5-1.5,1.9	c-0.3,0.3-0.6,0.4-1,0.1c-0.5-0.2-2-0.7-3.8-2.4c-1.4-1.3-2.4-2.8-2.6-3.3c-0.3-0.5,0-0.7,0.2-1c0.2-0.2,0.5-0.6,0.7-0.8	c0.2-0.3,0.3-0.5,0.5-0.8c0.2-0.3,0.1-0.6,0-0.8C20.6,19.3,19.7,17,19.3,16z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Tanya via WhatsApp
                    </a>

                    <div x-data="{ openAccordions: ['description', 'details'] }" class="mt-10 border-t border-gray-200 divide-y divide-gray-200">
                        <div>
                            <h2>
                                <button
                                    @click="openAccordions.includes('description') ? openAccordions = openAccordions.filter(i => i !== 'description') : openAccordions.push('description')"
                                    type="button"
                                    class="flex items-center justify-between w-full py-4 font-medium text-left">
                                    <span class="text-base text-gray-900">Deskripsi Lengkap</span>
                                    <svg class="h-6 w-6 transform transition-transform"
                                        :class="{ '-rotate-180': openAccordions.includes('description') }"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </h2>
                            <div x-show="openAccordions.includes('description')" x-collapse.duration.500ms
                                class="pb-4 prose prose-sm max-w-none text-gray-600">
                                {!! $product->description !!}
                            </div>
                        </div>
                        <div>
                            <h2>
                                <button
                                    @click="openAccordions.includes('details') ? openAccordions = openAccordions.filter(i => i !== 'details') : openAccordions.push('details')"
                                    type="button"
                                    class="flex items-center justify-between w-full py-4 font-medium text-left">
                                    <span class="text-base text-gray-900">Detail Produk</span>
                                    <svg class="h-6 w-6 transform transition-transform"
                                        :class="{ '-rotate-180': openAccordions.includes('details') }" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </h2>
                            <div x-show="openAccordions.includes('details')" x-collapse.duration.500ms
                                class="pb-4 text-sm text-gray-600">
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt>Material:</dt>
                                        <dd class="font-medium text-gray-900">{{ $product->material }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt>Dimensi:</dt>
                                        <dd class="font-medium text-gray-900">{{ $product->dimensions }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt>Estimasi Pre-Order:</dt>
                                        <dd class="font-medium text-gray-900">{{ $product->preorder_estimate }}</dd>
                                    </div>
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
