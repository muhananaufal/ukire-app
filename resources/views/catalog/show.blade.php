<x-app-layout>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
          <div>
              <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border">
                  <img src="{{ asset('storage/' . $product->images->first()?->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center">
              </div>
              <div class="mt-4 grid grid-cols-4 gap-4">
                  @foreach ($product->images as $image)
                      <div class="aspect-w-1 aspect-h-1 rounded-lg overflow-hidden border">
                          <img src="{{ asset('storage/' . $image->image_path) }}" alt="" class="w-full h-full object-cover object-center">
                      </div>
                  @endforeach
              </div>
          </div>

          <div>
              <div class="mb-4">
                  <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="text-sm text-gray-500 hover:text-gray-700">{{ $product->category->name }}</a>
              </div>

              <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->name }}</h1>
              
              <div class="mt-4">
                  <p class="text-3xl text-gray-900">Rp {{ number_format($product->price / 100, 0, ',', '.') }}</p>
              </div>

              <div class="mt-6 prose max-w-none">
                  {!! $product->description !!}
              </div>

              <div class="mt-8 border-t pt-6">
                  <h3 class="text-md font-medium text-gray-900">Details</h3>
                  <dl class="mt-2 text-sm text-gray-500 space-y-2">
                      <div class="flex justify-between">
                          <dt>Material:</dt>
                          <dd>{{ $product->material }}</dd>
                      </div>
                      <div class="flex justify-between">
                          <dt>Dimensions:</dt>
                          <dd>{{ $product->dimensions }}</dd>
                      </div>
                      <div class="flex justify-between border-t pt-2 mt-2">
                          <dt class="font-semibold text-gray-900">Pre-Order Estimate:</dt>
                          <dd class="font-semibold text-red-600">{{ $product->preorder_estimate }}</dd>
                      </div>
                  </dl>
              </div>
              
              <div class="mt-8 space-y-4">
                  <button class="w-full bg-gray-800 text-white py-3 px-6 rounded-md text-lg hover:bg-gray-700">Pre-Order Sekarang</button>
                  <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->name) }}"
                     target="_blank" 
                     class="w-full flex items-center justify-center bg-green-500 text-white py-3 px-6 rounded-md text-lg hover:bg-green-600">
                      <span class="mr-2">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                      </span>
                      Tanya via WA
                  </a>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>