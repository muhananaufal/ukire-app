<x-app-layout>
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

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            
            <aside class="lg:col-span-1 lg:sticky lg:top-28" data-aos="fade-right">
                <form id="filter-form" action="{{ route('catalog.index') }}" method="GET" class="lg:sticky">
                    <div class="space-y-8">
                        <div>
                            <label for="search" class="sr-only">Cari Produk</label>
                            <div class="relative">
                                <input type="text" name="search" id="search"
                                       class="block w-full rounded-md border-gray-300 bg-gray-50 pl-10 pr-4 py-3 text-base text-gray-900 placeholder-gray-500 shadow-sm focus:border-amber-500 focus:ring-amber-500"
                                       placeholder="Cari produk..."
                                       value="{{ request('search') }}">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-900 tracking-wider uppercase text-sm">Kategori</h3>
                            <div class="mt-4 space-y-2">
                                <a href="{{ route('catalog.index', ['sort' => request('sort')]) }}" 
                                   class="block text-sm transition-colors {{ !request('category') ? 'text-amber-600 font-bold' : 'text-gray-600 hover:text-gray-900' }}">
                                   Semua Kategori
                                </a>
                                @foreach ($categories as $category)
                                    <a href="{{ route('catalog.index', ['category' => $category->slug, 'sort' => request('sort')]) }}" 
                                       class="block text-sm transition-colors {{ request('category') == $category->slug ? 'text-amber-600 font-bold' : 'text-gray-600 hover:text-gray-900' }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="font-semibold text-gray-900 tracking-wider uppercase text-sm">Urutkan</h3>
                            <select name="sort" id="sort" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                                <option value="latest" @selected(request('sort', 'latest') == 'latest')>Terbaru</option>
                                <option value="price_asc" @selected(request('sort') == 'price_asc')>Harga: Terendah ke Tertinggi</option>
                                <option value="price_desc" @selected(request('sort') == 'price_desc')>Harga: Tertinggi ke Terendah</option>
                            </select>
                        </div>
                    </div>
                </form>
            </aside>

            <main class="lg:col-span-3">
                <div class="pb-4 border-b border-gray-200">
                    <p class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold">{{ $products->firstItem() }}-{{ $products->lastItem() }}</span> dari <span class="font-semibold">{{ $products->total() }}</span> hasil
                    </p>
                </div>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    @forelse ($products as $product)
                        <div data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                            <x-product-card :product="$product" />
                        </div>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <h3 class="text-xl font-semibold text-gray-800">Tidak Ada Produk Ditemukan</h3>
                            <p class="mt-2 text-gray-500">Coba ubah atau hapus filter Anda untuk melihat hasil lainnya.</p>
                            <a href="{{ route('catalog.index') }}" class="mt-6 inline-block bg-gray-800 text-white py-2 px-6 rounded-md hover:bg-gray-700">
                                Hapus Semua Filter
                            </a>
                        </div>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            </main>
        </div>
    </div>

    @push('scripts')
    <script>
        // Script untuk membuat filter bekerja secara otomatis
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('filter-form');
            const inputs = form.querySelectorAll('input, select');

            inputs.forEach(input => {
                input.addEventListener('change', function () {
                    form.submit();
                });
            });
        });
    </script>
    @endpush
</x-app-layout>