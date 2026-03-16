<x-app-layout>
    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-gray-100">
                <div class="p-8 md:p-16">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                        <!-- Left: Image Gallery -->
                        <div class="space-y-6">
                            <div class="aspect-square bg-gray-50 rounded-[2rem] overflow-hidden border border-gray-100">
                                <img src="{{ $product->images->where('is_primary', true)->first()?->image_path ?? 'https://placehold.co/800x800/f3f4f6/374151?text=' . urlencode($product->name) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-contain p-8 drop-shadow-2xl">
                            </div>
                            <!-- Thumbnails -->
                            @if($product->images->count() > 1)
                                <div class="grid grid-cols-4 gap-4">
                                    @foreach($product->images as $image)
                                        <div class="aspect-square bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 hover:border-indigo-500 cursor-pointer transition-colors">
                                            <img src="{{ $image->image_path }}" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Right: Product Info -->
                        <div class="flex flex-col h-full">
                            <div class="flex flex-col gap-2 mb-8">
                                <span class="text-xs font-black text-indigo-600 uppercase tracking-[0.3em] inline-block mb-1">{{ $product->category?->name }}</span>
                                <h1 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">
                                    {{ $product->name }}
                                </h1>
                                <div class="flex items-center gap-4 mt-2">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full border border-gray-200">{{ $product->brand?->name }}</span>
                                    <span class="text-gray-300">|</span>
                                    <div class="flex items-center gap-1">
                                        @for($i = 0; $i < 5; $i++)
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @endfor
                                        <span class="text-sm font-bold text-gray-400 ml-1">(12 Reviews)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50/50 p-6 rounded-3xl border border-gray-100 mb-8">
                                <div class="flex items-baseline gap-4 mb-4">
                                    @if($product->sale_price)
                                        <span class="text-4xl font-black text-gray-900 tracking-tight">${{ number_format($product->sale_price, 2) }}</span>
                                        <span class="text-lg text-gray-400 line-through font-bold">${{ number_format($product->price, 2) }}</span>
                                        <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-black uppercase tracking-wider rounded-lg">Save {{ round((1 - $product->sale_price / $product->price) * 100) }}%</span>
                                    @else
                                        <span class="text-4xl font-black text-gray-900 tracking-tight">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                <p class="text-gray-500 text-sm leading-relaxed">
                                    {{ $product->description }}
                                </p>
                            </div>

                            <!-- Attributes -->
                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="bg-white p-4 rounded-2xl border border-gray-100">
                                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">SKU</span>
                                    <span class="text-sm font-bold text-gray-700">{{ $product->sku ?? 'N/A' }}</span>
                                </div>
                                <div class="bg-white p-4 rounded-2xl border border-gray-100">
                                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Weight</span>
                                    <span class="text-sm font-bold text-gray-700">{{ $product->weight ?? 'N/A' }}</span>
                                </div>
                                <div class="bg-white p-4 rounded-2xl border border-gray-100">
                                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Material</span>
                                    <span class="text-sm font-bold text-gray-700">{{ $product->material ?? 'N/A' }}</span>
                                </div>
                                <div class="bg-white p-4 rounded-2xl border border-gray-100">
                                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Compatibility</span>
                                    <span class="text-sm font-bold text-gray-700 ">{{ $product->compatibility ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-auto space-y-4">
                                <div class="flex gap-4">
                                    <div class="flex items-center bg-gray-100 rounded-2xl px-4 py-2 border border-gray-200">
                                        <button class="text-gray-500 hover:text-gray-900 font-black text-xl w-8">-</button>
                                        <input type="number" value="1" class="bg-transparent border-none focus:ring-0 text-center w-12 font-black text-gray-900">
                                        <button class="text-gray-500 hover:text-gray-900 font-black text-xl w-8">+</button>
                                    </div>
                                    <button class="flex-1 bg-gray-900 text-white font-black uppercase tracking-[0.2em] text-sm py-5 rounded-2xl hover:bg-indigo-600 shadow-2xl shadow-indigo-200 transition-all active:scale-95">
                                        Add to Cart
                                    </button>
                                </div>
                                <button class="w-full bg-white text-gray-900 border-2 border-gray-100 font-black uppercase tracking-[0.2em] text-sm py-5 rounded-2xl hover:border-red-500 hover:text-red-500 transition-all flex items-center justify-center gap-2 group">
                                    <svg class="w-5 h-5 group-hover:fill-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    Add to Wishlist
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Related Products -->
                    @if($relatedProducts->count() > 0)
                        <div class="mt-24">
                            <h2 class="text-3xl font-black text-gray-900 mb-12 tracking-tight">You might also like</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                                @foreach($relatedProducts as $rel)
                                    <div class="group bg-white border border-gray-100 rounded-3xl overflow-hidden hover:shadow-xl transition-all">
                                        <div class="aspect-square bg-gray-50 overflow-hidden p-6">
                                            <img src="https://placehold.co/400x400/f3f4f6/374151?text={{ urlencode($rel->name) }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform">
                                        </div>
                                        <div class="p-6">
                                            <h3 class="font-bold text-gray-900 text-sm line-clamp-1 mb-2">{{ $rel->name }}</h3>
                                            <span class="font-black text-gray-900">${{ number_format($rel->price, 2) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
