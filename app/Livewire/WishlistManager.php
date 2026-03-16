<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistManager extends Component
{
    public $wishlistItems = [];

    public function mount()
    {
        $this->loadWishlist();
    }

    public function loadWishlist()
    {
        if (auth()->check()) {
            $this->wishlistItems = Wishlist::with('product')
                ->where('user_id', auth()->id())
                ->get();
        }
    }

    public function toggleWishlist($productId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $productId,
            ]);
        }

        $this->loadWishlist();
        $this->dispatch('wishlistUpdated');
    }

    public function render()
    {
        return view('livewire.wishlist-manager');
    }
}
