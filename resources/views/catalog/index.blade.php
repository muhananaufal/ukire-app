<x-app-layout>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="text-center mb-12">
          <h1 class="text-4xl font-extrabold text-gray-900">Our Collection</h1>
          <p class="mt-2 text-lg text-gray-600">Discover furniture that tells a story.</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
          <aside class="lg:col-span-1">
              <form action="{{ route('catalog.index') }}" method="GET">
                  <div class="space-y-6">
                      <div>
                          <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                          <div class="mt-1">
                              <input type="text" name="search" id="search"
                                     class="block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-800 focus:ring-gray-800 sm:text-sm"
                                     placeholder="e.g. Modern Table"
                                     value="{{ request('search') }}">
                          </div>
                      </div>

                      <div>
                          <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                          <select id="category" name="category"
                                  class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-gray-800 focus:outline-none focus:ring-gray-800 sm:text-sm">
                              <option value="">All Categories</option>
                              @foreach ($categories as $category)
                                  <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                      {{ $category->name }}
                                  </option>
                              @endforeach
                          </select>
                      </div>

                      <div>
                          <button type="submit" class="w-full bg-gray-800 text-white py-2 px-4 rounded-md hover:bg-gray-700">Apply Filters</button>
                      </div>
                  </div>
              </form>
          </aside>

          <main class="lg:col-span-3">
              <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                  @forelse ($products as $product)
                  <x-product-card :product="$product" />
                  @empty
                      <div class="col-span-full text-center py-12">
                          <p class="text-gray-500 text-lg">No products found matching your criteria.</p>
                      </div>
                  @endforelse
              </div>

              <div class="mt-12">
                  {{ $products->links() }}
              </div>
          </main>
      </div>
  </div>
</x-app-layout>