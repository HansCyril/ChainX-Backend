<div class="py-12 bg-gray-50/30">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2rem] border border-gray-100">
            <div class="p-8 md:p-12">
                <div class="flex items-center justify-between mb-12">
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight flex items-center gap-4">
                        Shopping Cart
                        <span class="text-lg font-bold text-gray-400 bg-gray-100 px-4 py-1 rounded-full">{{ count($cart) }} Items</span>
                    </h1>
                    <a href="{{ route('products.index') }}" class="text-indigo-600 font-bold hover:text-indigo-700 flex items-center gap-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Continue Shopping
                    </a>
                </div>

                @if(count($cart) > 0)
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        <!-- Cart Items -->
                        <div class="lg:col-span-2 space-y-6">
                            @foreach($cart as $id => $item)
                                <div class="flex items-center gap-6 p-6 bg-white border border-gray-100 rounded-[1.5rem] hover:shadow-xl hover:border-indigo-100 transition-all group">
                                    <div class="w-24 h-24 bg-gray-50 rounded-2xl overflow-hidden flex-shrink-0">
                                        <img src="{{ $item['image'] }}" class="w-full h-full object-contain p-2 group-hover:scale-110 transition-transform">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start mb-1">
                                            <h3 class="font-bold text-gray-900 truncate pr-4">{{ $item['name'] }}</h3>
                                            <button wire:click="removeFromCart({{ $id }})" class="text-gray-300 hover:text-red-500 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                        <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-4">SKU: {{ $item['slug'] }}</p>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center bg-gray-50 rounded-xl px-2 py-1 border border-gray-100">
                                                <button wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-900 font-bold">-</button>
                                                <span class="w-10 text-center text-sm font-black text-gray-900">{{ $item['quantity'] }}</span>
                                                <button wire:click="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-900 font-bold">+</button>
                                            </div>
                                            <div class="text-right">
                                                <span class="block text-sm font-bold text-gray-400 line-through">
                                                    @if($item['sale_price'])
                                                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                                    @endif
                                                </span>
                                                <span class="text-lg font-black text-gray-900">
                                                    ${{ number_format(($item['sale_price'] ?? $item['price']) * $item['quantity'], 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Summary -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-900 rounded-[2rem] p-8 text-white sticky top-8 shadow-2xl">
                                <h2 class="text-2xl font-black mb-8 tracking-tight uppercase">Order Summary</h2>
                                
                                <div class="space-y-4 mb-8">
                                    <div class="flex justify-between text-gray-400 font-bold">
                                        <span>Subtotal</span>
                                        <span class="text-white">${{ number_format($total, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-400 font-bold">
                                        <span>Shipping</span>
                                        <span class="text-green-400 uppercase text-xs tracking-widest bg-green-400/10 px-2 py-1 rounded">Free</span>
                                    </div>
                                    <div class="flex justify-between text-gray-400 font-bold">
                                        <span>Tax (Estimated)</span>
                                        <span class="text-white">$0.00</span>
                                    </div>
                                </div>

                                <div class="border-t border-white/10 pt-6 mb-8">
                                    <div class="flex justify-between items-baseline">
                                        <span class="text-lg font-bold text-gray-400">Total Amount</span>
                                        <span class="text-4xl font-black text-white tracking-tighter">${{ number_format($total, 2) }}</span>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <a href="{{ route('checkout') }}" class="w-full bg-indigo-600 text-white font-black uppercase tracking-[0.2em] text-sm py-5 rounded-2xl hover:bg-indigo-500 shadow-xl shadow-indigo-900/50 transition-all flex items-center justify-center gap-3 active:scale-95">
                                        Checkout Now
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                    <p class="text-center text-[10px] text-gray-500 font-bold uppercase tracking-widest">Secure SSL Encrypted Checkout</p>
                                </div>

                                <!-- Promo Code -->
                                <div class="mt-8 pt-8 border-t border-white/10">
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Promo Code</label>
                                    <div class="flex gap-2">
                                        <input type="text" placeholder="Enter code" class="bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm focus:ring-indigo-500 focus:border-indigo-500 flex-1">
                                        <button class="px-6 bg-white/10 rounded-xl font-bold text-sm hover:bg-white/20 transition-colors">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="py-24 text-center">
                        <div class="mb-8 inline-flex p-8 bg-gray-50 rounded-full">
                            <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h2 class="text-3xl font-black text-gray-900 mb-4">Your cart is empty</h2>
                        <p class="text-gray-500 mb-8 max-w-sm mx-auto font-medium">Looks like you haven't added any bike components to your cart yet.</p>
                        <a href="{{ route('products.index') }}" class="inline-flex bg-gray-900 text-white font-black uppercase tracking-[0.2em] text-sm px-10 py-5 rounded-2xl hover:bg-indigo-600 shadow-2xl shadow-gray-200 transition-all active:scale-95">
                            Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
