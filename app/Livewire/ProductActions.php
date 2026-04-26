<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Wishlist;

class ProductActions extends Component
{
    public Product $product;
    public int $quantity = 1;
    public bool $isWishlisted = false;

    public function mount(Product $product)
    {
        $this->product = $product;
        if (auth()->check()) {
            $this->isWishlisted = Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->exists();
        }
    }

    public function increment()
    {
        if ($this->quantity < $this->product->quantity) {
            $this->quantity++;
        } else {
            $this->dispatch('show-toast', message: "Maximum stock reached! Only {$this->product->quantity} available.", type: 'error');
        }
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        $cart = session()->get('cart', []);
        $currentCartQty = isset($cart[$this->product->id]) ? $cart[$this->product->id]['quantity'] : 0;

        if ($currentCartQty + $this->quantity > $this->product->quantity) {
            $this->dispatch('show-toast', message: "Not enough stock! You already have some in your cart.", type: 'error');
            return;
        }

        if (isset($cart[$this->product->id])) {
            $cart[$this->product->id]['quantity'] += $this->quantity;
        } else {
            $cart[$this->product->id] = [
                'id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->price,
                'sale_price' => $this->product->sale_price,
                'quantity' => $this->quantity,
                'slug' => $this->product->slug,
                'image' => $this->product->image ? asset('storage/' . $this->product->image) : 'https://placehold.co/100x100?text=' . urlencode($this->product->name),
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');
        
        // Redirect to the cart page as requested
        return $this->redirect(route('cart'), navigate: true);
    }

    public function toggleWishlist()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($this->isWishlisted) {
            Wishlist::where('user_id', auth()->id())
                ->where('product_id', $this->product->id)
                ->delete();
            $this->isWishlisted = false;
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $this->product->id,
            ]);
            $this->isWishlisted = true;
        }

        $this->dispatch('wishlistUpdated');
        $this->dispatch('wishlist-updated');
    }

    public function render()
    {
        return view('livewire.product-actions');
    }
}
