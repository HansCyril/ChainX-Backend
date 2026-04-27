<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col gap-8">
            <!-- Top Filters -->
            <div class="w-full">
                <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl p-6">
                    <h3 class="font-bold text-xl text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filters
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wider">Search</label>
                            <div class="relative">
                                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search components..." class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pl-4 py-3 text-sm">
                            </div>
                        </div>

                        <!-- Categories -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wider">Category</label>
                            <select wire:model.live="selectedCategory" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 text-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brands -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wider">Brand</label>
                            <select wire:model.live="selectedBrand" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 text-sm">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wider">Price Range</label>
                            <div class="flex items-center gap-3">
                                <input type="number" wire:model.live="minPrice" placeholder="Min" class="w-1/2 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 text-sm text-center">
                                <span class="text-gray-400 font-bold">-</span>
                                <input type="number" wire:model.live="maxPrice" placeholder="Max" class="w-1/2 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 text-sm text-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="w-full">
                <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                        <div>
                            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Product Catalog</h2>
                            <p class="text-gray-500 mt-1 text-sm font-medium">Found {{ $products->total() }} results</p>
                        </div>
                        <div class="bg-gray-50 p-1 rounded-xl border border-gray-100">
                            <select wire:model.live="sortBy" class="bg-transparent border-none focus:ring-0 text-sm font-semibold text-gray-700 px-4 py-2">
                                <option value="created_at">Latest Releases</option>
                                <option value="price">Price: Low to High</option>
                                <option value="price_desc">Price: High to Low</option>
                                <option value="name">Name: A-Z</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($products as $product)
                            <div class="group flex flex-col bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                                <div class="relative aspect-square w-full overflow-hidden bg-gray-50 flex items-center justify-center">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x600/f3f4f6/374151?text=' . urlencode($product->name) }}" alt="{{ $product->name }}" class="h-full w-full object-cover p-0 group-hover:scale-110 transition-transform duration-500">
                                    @if($product->sale_price)
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-red-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-lg">Sale</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6 flex flex-col flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.2em]">{{ $product->category?->name ?? 'Uncategorized' }}</span>
                                            @if($product->quantity > 10)
                                                <span class="text-[9px] font-black text-green-600 uppercase tracking-tighter bg-green-50 px-2 py-0.5 rounded-md border border-green-100">In Stock: {{ $product->quantity }}</span>
                                            @elseif($product->quantity > 0)
                                                <span class="text-[9px] font-black text-orange-600 uppercase tracking-tighter bg-orange-50 px-2 py-0.5 rounded-md border border-orange-100 italic">Only {{ $product->quantity }} left!</span>
                                            @else
                                                <span class="text-[9px] font-black text-red-600 uppercase tracking-tighter bg-red-50 px-2 py-0.5 rounded-md border border-red-100">Out of Stock</span>
                                            @endif
                                        </div>
                                        <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2">
                                            <a href="{{ route('products.show', $product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center gap-1 mt-1">
                                            @php $avg = $product->reviews()->avg('rating') ?: 0; @endphp
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= floor($avg) ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                            <span class="text-[10px] font-bold text-gray-400 ml-1">({{ $product->reviews()->count() }})</span>
                                        </div>
                                        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between">
                                            <div class="flex flex-col">
                                                @if($product->sale_price)
                                                    <span class="text-xs text-gray-400 line-through">₱{{ number_format($product->price, 2) }}</span>
                                                    <span class="text-xl font-black text-gray-900">₱{{ number_format($product->sale_price, 2) }}</span>
                                                @else
                                                    <span class="text-xl font-black text-gray-900">₱{{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2">
                                                @livewire('wishlist-toggle', ['productId' => $product->id], key('wishlist-'.$product->id))
                                                
                                                @if($product->quantity > 0)
                                                    <button wire:click="addToCart({{ $product->id }})" class="p-3 bg-gray-900 text-white rounded-xl hover:bg-indigo-600 transition-colors shadow-lg shadow-gray-200" title="Add to Cart">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                                    </button>
                                                @else
                                                    <button disabled class="p-3 bg-gray-100 text-gray-400 rounded-xl cursor-not-allowed border border-gray-200" title="Out of Stock">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @empty
                            <div class="col-span-full py-20 text-center bg-gray-50 rounded-3xl border-2 border-dashed border-gray-100">
                                <div class="mb-4 inline-flex p-4 bg-white rounded-full shadow-sm">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">No products found</h3>
                                <p class="text-gray-500 mt-2 max-w-xs mx-auto text-sm">We couldn't find anything matching your current filters. Try adjusting your search or categories.</p>
                                <button wire:click="$set('search', '')" class="mt-6 text-sm font-bold text-indigo-600 hover:text-indigo-700">Clear all filters</button>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
