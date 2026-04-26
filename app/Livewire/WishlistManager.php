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

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product) return;

        $cart = session()->get('cart', []);
        $currentCartQty = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;

        if ($currentCartQty + 1 > $product->quantity) {
            $this->dispatch('show-toast', message: "Not enough stock! You already have maximum available in your cart.", type: 'error');
            return;
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'quantity' => 1,
                'slug' => $product->slug,
                'image' => $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/100x100?text=' . urlencode($product->name),
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');
        
        return $this->redirect(route('cart'), navigate: true);
    }

    public function render()
    {
        return view('livewire.wishlist-manager');
    }
}
