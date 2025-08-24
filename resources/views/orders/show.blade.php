<x-app-layout>
  <div class="bg-gray-50">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
          
          <!-- Header Halaman -->
          <div data-aos="fade-up">
              <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                  <div>
                      <a href="{{ route('order.history') }}" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 mb-2">
                          <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                          Kembali ke Riwayat Pesanan
                      </a>
                      <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                          Detail Pesanan <span class="font-mono">#{{ $order->id }}</span>
                      </h1>
                  </div>
                  <div class="mt-4 sm:mt-0 flex space-x-3">
                      <a href="{{ route('invoice.download', $order) }}" class="inline-flex items-center justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                          Unduh Faktur
                      </a>
                  </div>
              </div>
              <div class="mt-6 border-b border-gray-200 pb-6">
                  <p class="text-sm text-gray-600">Dipesan pada {{ $order->created_at->format('d F Y') }}</p>
              </div>
          </div>

          <!-- Konten Utama -->
          <div class="mt-8">
              <!-- WOW: Linimasa Visual Progres -->
              <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="100">
                  @php
                      $statusSteps = ['unpaid' => 1, 'processing' => 2, 'shipped' => 3, 'completed' => 4];
                      $currentStep = $statusSteps[$order->status] ?? 0;
                  @endphp
                  <ol class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center text-sm">
                      <li class="flex flex-col items-center"><div class="w-full h-1 {{ $currentStep >= 1 ? 'bg-amber-500' : 'bg-gray-200' }}"></div><p class="mt-2 font-medium {{ $currentStep >= 1 ? 'text-amber-600' : 'text-gray-500' }}">Pesanan Dibuat</p></li>
                      <li class="flex flex-col items-center"><div class="w-full h-1 {{ $currentStep >= 2 ? 'bg-amber-500' : 'bg-gray-200' }}"></div><p class="mt-2 font-medium {{ $currentStep >= 2 ? 'text-amber-600' : 'text-gray-500' }}">Dalam Produksi</p></li>
                      <li class="flex flex-col items-center"><div class="w-full h-1 {{ $currentStep >= 3 ? 'bg-amber-500' : 'bg-gray-200' }}"></div><p class="mt-2 font-medium {{ $currentStep >= 3 ? 'text-amber-600' : 'text-gray-500' }}">Dikirim</p></li>
                      <li class="flex flex-col items-center"><div class="w-full h-1 {{ $currentStep >= 4 ? 'bg-amber-500' : 'bg-gray-200' }}"></div><p class="mt-2 font-medium {{ $currentStep >= 4 ? 'text-amber-600' : 'text-gray-500' }}">Selesai</p></li>
                  </ol>
              </div>

              <!-- Grid Detail -->
              <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                  <!-- Kolom Kiri: Daftar Item -->
                  <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="200">
                      <h2 class="text-lg font-bold text-gray-900 mb-4">Item Pesanan ({{ $order->items->count() }})</h2>
                      <ul role="list" class="divide-y divide-gray-200">
                          @foreach ($order->items as $item)
                              <li class="py-4 flex">
                                  <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border bg-gray-100">
                                      <img src="{{ asset('storage/' . $item->product->images->first()?->image_path) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center">
                                  </div>
                                  <div class="ml-4 flex flex-1 flex-col">
                                      <div>
                                          <div class="flex justify-between text-base font-medium text-gray-900">
                                              <h3><a href="{{ route('catalog.show', $item->product) }}">{{ $item->product->name }}</a></h3>
                                              <p class="ml-4">Rp {{ number_format(($item->price / 100) * $item->quantity, 0, ',', '.') }}</p>
                                          </div>
                                          <p class="mt-1 text-sm text-gray-500">Kuantitas: {{ $item->quantity }}</p>
                                      </div>
                                  </div>
                              </li>
                          @endforeach
                      </ul>
                  </div>

                  <!-- Kolom Kanan: Info Pengiriman & Pembayaran -->
                  <div class="space-y-8">
                      <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="300">
                          <h2 class="text-lg font-bold text-gray-900 mb-4">Informasi Pengiriman</h2>
                          <div class="text-sm space-y-2 text-gray-600">
                              <p><strong>Penerima:</strong> {{ $order->recipient_name }}</p>
                              <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
                              <p><strong>Telepon:</strong> {{ $order->phone }}</p>
                          </div>
                      </div>
                      <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="400">
                          <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h2>
                          <div class="space-y-3 text-sm">
                              <div class="flex justify-between"><span class="text-gray-600">Subtotal</span><span class="font-medium text-gray-900">Rp {{ number_format($order->total_price / 100, 0, ',', '.') }}</span></div>
                              <div class="flex justify-between"><span class="text-gray-600">Pengiriman</span><span class="font-medium text-gray-900">Gratis</span></div>
                              <div class="mt-4 pt-4 border-t flex justify-between text-base font-bold text-gray-900">
                                  <span>Total</span>
                                  <span>Rp {{ number_format($order->total_price / 100, 0, ',', '.') }}</span>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>