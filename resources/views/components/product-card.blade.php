@props(['product'])

<div class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden">
    <a href="{{ route('catalog.show', $product) }}">
        <div class="aspect-w-1 aspect-h-1 bg-gray-100">
            <img src="{{ asset('storage/' . $product->images->first()?->image_path) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover object-center group-hover:opacity-75 transition-opacity">
        </div>
        <div class="p-4">
            <h3 class="text-sm text-gray-500">{{ $product->category->name }}</h3>
            <p class="mt-1 text-lg font-medium text-gray-900">{{ $product->name }}</p>
            <p class="mt-1 text-md font-semibold text-gray-700">Rp {{ number_format($product->price / 100, 0, ',', '.') }}</p>
        </div>
    </a>
</div>