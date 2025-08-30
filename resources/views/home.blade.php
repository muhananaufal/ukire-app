<x-app-layout>
    <section class="relative bg-gray-900 text-white min-h-screen flex items-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1616047006789-b7af5afb8c20?q=80&w=2080"
                alt="Detail sambungan kayu pada furnitur premium"
                class="w-full h-full object-cover opacity-40 animate-slow-zoom">
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent"></div>
        </div>
        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold tracking-tight" data-aos="fade-up">
                Seni di Setiap Serat Kayu.
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-lg md:text-xl text-gray-200" data-aos="fade-up" data-aos-delay="200">
                Temukan furnitur yang tidak hanya mengisi ruang, tetapi juga memberikan jiwa. Dibuat dengan presisi,
                didesain untuk selamanya.
            </p>
            <a href="{{ route('catalog.index') }}"
                class="mt-10 inline-block bg-amber-500 text-gray-900 font-bold py-3 px-10 rounded-lg text-lg transform hover:scale-105 transition-transform duration-300 animate-subtle-pulse"
                data-aos="fade-up" data-aos-delay="400">
                Jelajahi Koleksi
            </a>
        </div>
    </section>

    <section class="bg-white py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-semibold text-gray-500 tracking-wider">DIPERCAYA OLEH DESAINER INTERIOR
                TERNAMA</p>
            <div class="mt-6 flex justify-center items-center space-x-8 md:space-x-12 grayscale opacity-60">
                <p class="font-bold text-xl">Vogue</p>
                <p class="font-bold text-xl">DEZEEN</p>
                <p class="font-bold text-xl">ARCHDAILY</p>
                <p class="font-bold text-xl">ELLE DECOR</p>
            </div>
        </div>
    </section>

    <section class="bg-white py-16 sm:py-24 space-y-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 lg:gap-24 items-center">
                <div class="rounded-lg overflow-hidden" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1616047006789-b7af5afb8c20?q=80&w=2080"
                        alt="Pengrajin sedang mengerjakan detail furnitur">
                </div>
                <div data-aos="fade-left">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Kualitas Pengerjaan Tangan
                    </h2>
                    <p class="mt-6 text-lg text-gray-600">Setiap sambungan, setiap lengkungan, dan setiap lapisan akhir
                        dikerjakan oleh tangan-tangan ahli yang berdedikasi. Kami tidak merakit, kami menciptakan.
                        Proses pra-pesan kami memastikan setiap karya mendapatkan perhatian penuh yang layak
                        diterimanya.</p>
                </div>
            </div>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 lg:gap-24 items-center">
                <div class="rounded-lg overflow-hidden md:order-last" data-aos="fade-left">
                    <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=2000"
                        alt="Ruang tamu modern dengan furnitur kayu minimalis">
                </div>
                <div data-aos="fade-right">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Desain yang Abadi</h2>
                    <p class="mt-6 text-lg text-gray-600">Kami percaya pada desain minimalis yang melampaui tren.
                        Menggunakan kayu solid dari sumber lestari, furnitur kami dirancang untuk menjadi pusaka
                        keluarga yang keindahannya akan terus bertumbuh seiring berjalannya waktu.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center" data-aos="fade-up">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Koleksi Unggulan</h2>
                <p class="mt-4 text-lg text-gray-600">Estetika dan fungsi berpadu dalam karya-karya pilihan kami.</p>
            </div>
            <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($featuredProducts as $index => $product)
                    <div data-aos="zoom-in" data-aos-delay="{{ 100 * $index }}">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Dari Hutan ke Rumah Anda</h2>
                <p class="mt-4 text-lg text-gray-600">Kami percaya pada proses yang teliti. Setiap karya Ukire adalah
                    hasil dari dedikasi pada kualitas di setiap langkahnya.</p>
            </div>
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                <div data-aos="fade-up" data-aos-delay="100">
                    <div class="mx-auto bg-amber-100 rounded-full h-20 w-20 flex items-center justify-center">
                        <svg class="h-10 w-10 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 4.5v15m7.5-7.5h-15"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900">1. Pemilihan Material</h3>
                    <p class="mt-2 text-gray-600">Kami hanya menggunakan kayu solid dari sumber lestari yang dipilih
                        sendiri untuk memastikan setiap serat memiliki karakter dan kekuatan yang optimal.</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="200">
                    <div class="mx-auto bg-amber-100 rounded-full h-20 w-20 flex items-center justify-center">
                        <svg class="h-10 w-10 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900">2. Pengerjaan Tangan</h3>
                    <p class="mt-2 text-gray-600">Pengrajin kami memadukan teknik tradisional dengan presisi modern
                        untuk membentuk, menyambung, dan menghaluskan setiap komponen.</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="300">
                    <div class="mx-auto bg-amber-100 rounded-full h-20 w-20 flex items-center justify-center">
                        <svg class="h-10 w-10 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h.008v.008h-.008v-.008zm-3 0H12m9 0H9.375a1.125 1.125 0 01-1.125-1.125V9.75">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900">3. Finishing Sempurna</h3>
                    <p class="mt-2 text-gray-600">Setiap produk dilindungi dengan lapisan akhir berkualitas tinggi yang
                        tidak hanya tahan lama, tapi juga menonjolkan keindahan alami dari kayu.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Jelajahi Berdasarkan Ruang</h2>
                <p class="mt-4 text-lg text-gray-600">Temukan inspirasi dan ciptakan harmoni di setiap sudut rumah
                    Anda.</p>
            </div>
            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="group relative rounded-lg overflow-hidden" data-aos="zoom-in">
                    <a href="{{ route('catalog.index', ['category' => 'meja']) }}">
                        <div class="absolute inset-0">
                            <img src="https://images.unsplash.com/photo-1616047006789-b7af5afb8c20?q=80&w=2080"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                alt="Ruang makan elegan dengan meja kayu">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="relative p-8 h-80 flex flex-col justify-end">
                            <h3 class="text-3xl font-bold text-white">Ruang Makan</h3>
                            <p class="mt-2 text-white/90">Ciptakan momen tak terlupakan di pusat kehangatan rumah.</p>
                        </div>
                    </a>
                </div>
                <div class="group relative rounded-lg overflow-hidden" data-aos="zoom-in" data-aos-delay="200">
                    <a href="{{ route('catalog.index', ['category' => 'kursi']) }}">
                        <div class="absolute inset-0">
                            <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=2000"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                alt="Ruang kerja minimalis dengan kursi kayu yang nyaman">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="relative p-8 h-80 flex flex-col justify-end">
                            <h3 class="text-3xl font-bold text-white">Ruang Kerja</h3>
                            <p class="mt-2 text-white/90">Fokus dan inspirasi berawal dari ruang yang tertata.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-amber-50 py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Kisah dari Ruang Mereka</h2>
                <p class="mt-4 text-lg text-gray-600">Dengarkan bagaimana Ukire menjadi bagian dari cerita di rumah
                    para pelanggan kami.</p>
            </div>

            <div class="mt-16 max-w-4xl mx-auto relative">
                <div class="swiper-container overflow-hidden" style="visibility: hidden;">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide text-center">
                            <div class="max-w-3xl mx-auto">
                                <svg class="mx-auto h-12 w-12 text-amber-300" fill="currentColor" viewBox="0 0 32 32"
                                    aria-hidden="true">
                                    <path
                                        d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L25.864 4z" />
                                </svg>
                                <p class="mt-6 text-2xl italic text-gray-800">"Setiap sudut rumah saya terasa lebih
                                    hangat berkat Ukire. Kualitasnya benar-benar berbicara. Ini bukan sekadar membeli
                                    furnitur, ini adalah sebuah investasi seni."</p>
                                <p class="mt-6 font-bold text-gray-900">- Riana S., Surakarta</p>
                            </div>
                        </div>
                        <div class="swiper-slide text-center">
                            <div class="max-w-3xl mx-auto">
                                <svg class="mx-auto h-12 w-12 text-amber-300" fill="currentColor" viewBox="0 0 32 32"
                                    aria-hidden="true">
                                    <path
                                        d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L25.864 4z" />
                                </svg>
                                <p class="mt-6 text-2xl italic text-gray-800">"Proses pra-pesan awalnya membuat saya
                                    ragu, tapi hasilnya jauh melampaui ekspektasi. Meja kerja saya kokoh, indah, dan
                                    ukurannya pas sekali. Layanan pelanggan juga sangat membantu."</p>
                                <p class="mt-6 font-bold text-gray-900">- Budi Hartono, Bandung</p>
                            </div>
                        </div>
                        <div class="swiper-slide text-center">
                            <div class="max-w-3xl mx-auto">
                                <svg class="mx-auto h-12 w-12 text-amber-300" fill="currentColor" viewBox="0 0 32 32"
                                    aria-hidden="true">
                                    <path
                                        d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.896 3.456-8.352 9.12-8.352 15.36 0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L25.864 4z" />
                                </svg>
                                <p class="mt-6 text-2xl italic text-gray-800">"Akhirnya menemukan toko furnitur lokal
                                    yang kualitasnya setara brand internasional. Desainnya minimalis dan modern, persis
                                    seperti yang saya cari."</p>
                                <p class="mt-6 font-bold text-gray-900">- Citra Lestari, Surabaya</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination mt-8 relative"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 text-center" data-aos="zoom-in">
            <h2 class="text-3xl font-bold text-white sm:text-4xl">Mulailah Kisah Anda</h2>
            <p class="mt-4 text-lg text-gray-300">Setiap ruangan memiliki potensi. Temukan kepingan yang hilang dalam
                koleksi kami.</p>
            <a href="{{ route('catalog.index') }}"
                class="mt-10 inline-block bg-amber-500 text-gray-900 font-bold py-3 px-10 rounded-lg text-lg transform hover:scale-105 transition-transform duration-300 animate-subtle-pulse"
                data-aos="fade-up" data-aos-delay="400">
                Jelajahi Sekarang
            </a>
        </div>
    </section>
</x-app-layout>
