<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistToggle extends Component
{
    public $productId;
    public $isWishlisted = false;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->isWishlisted = Auth::check() && Wishlist::where('user_id', Auth::id())
            ->where('product_id', $this->productId)
            ->exists();
    }

    public function toggle()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $this->productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $this->isWishlisted = false;
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $this->productId,
            ]);
            $this->isWishlisted = true;
        }

        $this->dispatch('wishlist-updated');
    }

    public function render()
    {
        return <<<'HTML'
        <button wire:click.stop="toggle" 
                class="absolute top-4 right-4 p-3 rounded-2xl backdrop-blur-md transition-all duration-300 group z-10
                {{ $isWishlisted ? 'bg-red-500 text-white shadow-xl shadow-red-200' : 'bg-white/90 text-gray-400 hover:text-red-500 hover:bg-white shadow-lg' }}">
            <svg class="w-5 h-5 transition-transform group-hover:scale-125 {{ $isWishlisted ? 'fill-current' : 'fill-none' }}" 
                 stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </button>
        HTML;
    }
}
