<div class="mt-auto space-y-4">
    <div class="flex gap-4">
        <div class="flex items-center bg-gray-100 rounded-2xl px-4 py-2 border border-blue-100/50 shadow-inner">
            <button wire:click="decrement" class="text-gray-400 hover:text-black font-black text-xl w-8 transition-colors">-</button>
            <input type="number" wire:model="quantity" readonly class="bg-transparent border-none focus:ring-0 text-center w-12 font-black text-gray-900 cursor-default">
            <button wire:click="increment" class="text-gray-400 hover:text-black font-black text-xl w-8 transition-colors">+</button>
        </div>
        <button wire:click="addToCart" 
                class="flex-1 bg-gradient-to-r from-red-600 to-orange-500 text-white font-black uppercase tracking-[0.2em] text-sm py-5 rounded-2xl hover:from-red-500 hover:to-orange-400 shadow-xl shadow-red-500/20 transition-all active:scale-95 group relative overflow-hidden">
            <span class="relative z-10 flex items-center justify-center gap-2">
                Add to Cart
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </span>
            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
        </button>
    </div>
    
    <button wire:click="toggleWishlist" 
            class="w-full bg-white text-gray-900 border-2 border-slate-100 font-black uppercase tracking-[0.2em] text-sm py-5 rounded-2xl hover:border-red-500 transition-all flex items-center justify-center gap-2 group {{ $isWishlisted ? 'text-red-500 border-red-500 shadow-lg shadow-red-500/10' : '' }}">
        <svg class="w-5 h-5 {{ $isWishlisted ? 'fill-current scale-110' : 'group-hover:fill-current group-hover:scale-110' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
        {{ $isWishlisted ? 'Wishlisted' : 'Add to Wishlist' }}
    </button>
</div>
