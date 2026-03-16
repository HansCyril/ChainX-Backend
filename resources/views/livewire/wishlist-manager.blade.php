<div class="py-12 bg-gray-50/30">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2rem] border border-gray-100 p-8 md:p-12">
            <h1 class="text-4xl font-black text-gray-900 tracking-tight mb-12 flex items-center gap-4">
                My Wishlist
                <span class="text-lg font-bold text-gray-400 bg-gray-100 px-4 py-1 rounded-full">{{ count($wishlistItems) }} Items</span>
            </h1>

            @if(count($wishlistItems) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($wishlistItems as $item)
                        <div class="group bg-white border border-gray-100 rounded-[2rem] overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                            <div class="relative aspect-square bg-gray-50 overflow-hidden p-6">
                                <img src="https://placehold.co/600x600/f3f4f6/374151?text={{ urlencode($item->product->name) }}" class="w-full h-full object-contain group-hover:scale-110 transition-transform">
                                <button wire:click="toggleWishlist({{ $item->product_id }})" class="absolute top-4 right-4 p-2 bg-white/80 backdrop-blur rounded-full text-red-500 hover:bg-white shadow-lg transition-colors">
                                    <svg class="w-5 h-5 fill-current" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </button>
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 line-clamp-1 mb-2 group-hover:text-indigo-600">
                                    <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                </h3>
                                <div class="flex items-center justify-between mt-4">
                                    <span class="font-black text-xl text-gray-900">${{ number_format($item->product->price, 2) }}</span>
                                    <button class="text-indigo-600 font-bold text-sm hover:underline">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-24 text-center">
                    <div class="mb-8 inline-flex p-8 bg-gray-50 rounded-full">
                        <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h2 class="text-3xl font-black text-gray-900 mb-4">Your wishlist is empty</h2>
                    <a href="{{ route('products.index') }}" class="inline-flex bg-gray-900 text-white font-black uppercase tracking-[0.2em] text-sm px-10 py-5 rounded-2xl hover:bg-indigo-600 shadow-2xl transition-all">Start Exploring</a>
                </div>
            @endif
        </div>
    </div>
</div>
