@props(['product'])
<div
    class="group relative bg-white border border-gray-200/80 rounded-lg overflow-hidden transition-shadow duration-300 hover:shadow-xl">
    <a href="{{ route('catalog.show', $product) }}">
        <div class="aspect-w-1 aspect-h-1 bg-gray-100 overflow-hidden">
            <img src="{{ asset('storage/' . $product->images->first()?->image_path) }}" alt="{{ $product->name }}"
                class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105">
        </div>
        <div class="p-4">
            <h3 class="text-sm text-gray-500">{{ $product->category->name }}</h3>
            <p class="mt-1 text-base font-semibold text-gray-900">{{ $product->name }}</p>
            <p class="mt-1 text-base font-medium text-gray-700">Rp
                {{ number_format($product->price / 100, 0, ',', '.') }}</p>
        </div>
    </a>
</div>
