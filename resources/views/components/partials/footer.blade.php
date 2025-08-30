<footer class="bg-gray-50 border-t border-gray-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-16 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="md:col-span-1" data-aos="fade-up">
                <a href="{{ route('home') }}" class="block">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Ukire" class="h-8" />
                </a>
                <p class="mt-4 text-sm text-gray-600 max-w-xs">
                    Furnitur kayu premium yang dirancang untuk melengkapi kisah unik di rumah Anda.
                </p>
                <div class="mt-6 flex space-x-4">
                    <a href="#"
                        class="text-gray-500 hover:text-gray-900 transition-colors flex justify-center items-center gap-x-1">
                        <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-instagram-icon lucide-instagram">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                        </svg>
                        <span class="inline">@ukirefurniture</span>
                    </a>
                </div>
            </div>

            <div data-aos="fade-up" data-aos-delay="100">
                <h4 class="font-semibold text-gray-900 tracking-wider uppercase text-sm">Belanja</h4>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="{{ route('catalog.index') }}"
                            class="text-gray-600 hover:text-gray-900 transition-colors">Semua Koleksi</a></li>
                    <li><a href="{{ route('catalog.index', ['category' => 'meja']) }}"
                            class="text-gray-600 hover:text-gray-900 transition-colors">Meja</a></li>
                    <li><a href="{{ route('catalog.index', ['category' => 'kursi']) }}"
                            class="text-gray-600 hover:text-gray-900 transition-colors">Kursi</a></li>
                    <li><a href="{{ route('catalog.index', ['category' => 'lemari']) }}"
                            class="text-gray-600 hover:text-gray-900 transition-colors">Lemari</a></li>
                </ul>
            </div>

            <div data-aos="fade-up" data-aos-delay="200">
                <h4 class="font-semibold text-gray-900 tracking-wider uppercase text-sm">Perusahaan</h4>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="{{ route('static.page', 'about-us') }}"
                            class="text-gray-600 hover:text-gray-900 transition-colors">Tentang Kami</a></li>
                    <li><a href="https://wa.me/{{ config('ukire.whatsapp_number') }}"
                            class="text-gray-600 hover:text-gray-900 transition-colors">Layanan Pelanggan</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-gray-900 transition-colors">Kerja Sama</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="py-8 border-t border-gray-200 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Ukire. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>
