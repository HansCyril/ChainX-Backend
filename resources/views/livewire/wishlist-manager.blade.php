<div class="py-12 bg-gray-50/30 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col gap-10">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <h2 class="text-5xl font-black text-gray-900 tracking-tighter uppercase italic leading-none">Your Wishlist</h2>
                    <p class="text-gray-500 mt-4 font-bold text-lg">You have {{ count($wishlistItems) }} items saved for later.</p>
                </div>
                <a href="{{ route('products.index') }}" class="group flex items-center gap-3 bg-white text-gray-900 font-black uppercase tracking-[0.2em] text-xs px-8 py-5 rounded-2xl shadow-xl hover:bg-gray-900 hover:text-white transition-all">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Continue Shopping
                </a>
            </div>

            @if(count($wishlistItems) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($wishlistItems as $item)
                        <div class="group relative bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden hover:-translate-y-2 transition-all duration-500">
                            <!-- Image Section -->
                            <div class="relative aspect-[4/3] bg-gray-50 overflow-hidden flex items-center justify-center p-8">
                                <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://placehold.co/600x450/f3f4f6/374151?text='.urlencode($item->product->name) }}" class="h-full w-full object-contain group-hover:scale-110 transition-transform duration-700">
                                
                                <div class="absolute top-6 right-6 flex flex-col gap-3">
                                    <button wire:click="toggleWishlist({{ $item->product_id }})" class="p-4 bg-red-500 text-white rounded-2xl shadow-2xl hover:bg-red-600 transition-colors">
                                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                                    </button>
                                    
                                    <button wire:click="addToCart({{ $item->product_id }})" class="p-4 bg-slate-900 text-white rounded-2xl shadow-2xl hover:bg-slate-800 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </button>
                                </div>

                                @if($item->product->sale_price)
                                    <div class="absolute top-6 left-6">
                                        <span class="bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-full shadow-lg">Sale Item</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Content Section -->
                            <div class="p-10 flex flex-col h-full">
                                <div class="mb-6">
                                    <span class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] block mb-2">{{ $item->product->category->name ?? 'Premium Component' }}</span>
                                    <h3 class="text-2xl font-black text-gray-900 group-hover:text-indigo-600 transition-colors leading-tight">
                                        <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                    </h3>
                                </div>

                                <div class="mt-auto flex items-center justify-between gap-6 pt-5">
                                    <span class="text-lg font-black text-gray-900 tracking-tighter">
                                        ₱{{ number_format($item->product->sale_price ?? $item->product->price, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-[3rem] shadow-2xl border border-gray-100 py-40 text-center">
                    <div class="mb-12 inline-flex p-12 bg-red-50 rounded-full text-red-500 animate-bounce">
                        <svg class="w-24 h-24 stroke-current fill-current opacity-20" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h2 class="text-4xl font-black text-gray-900 mb-6 tracking-tight italic uppercase">Your wishlist is empty</h2>
                    <p class="text-gray-500 mb-12 max-w-sm mx-auto font-bold text-lg leading-relaxed">Don't let your favorite high-performance parts slip away!</p>
                    <a href="{{ route('products.index') }}" class="inline-flex bg-gray-900 text-white font-black uppercase tracking-[0.3em] text-sm px-14 py-7 rounded-3xl hover:bg-indigo-600 shadow-2xl shadow-indigo-100 transition-all active:scale-95">
                        Start Exploring
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
