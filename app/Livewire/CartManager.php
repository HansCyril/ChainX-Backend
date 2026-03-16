<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class CartManager extends Component
{
    public $cart = [];

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = session()->get('cart', []);
    }

    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::find($productId);
        if (!$product) return;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'quantity' => $quantity,
                'slug' => $product->slug,
                'image' => $product->images->where('is_primary', true)->first()?->image_path ?? 'https://placehold.co/100x100?text=' . urlencode($product->name),
            ];
        }

        session()->put('cart', $cart);
        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function updateQuantity($productId, $quantity)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            if ($cart[$productId]['quantity'] <= 0) {
                unset($cart[$productId]);
            }
            session()->put('cart', $cart);
            $this->loadCart();
            $this->dispatch('cartUpdated');
        }
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            $this->loadCart();
            $this->dispatch('cartUpdated');
        }
    }

    public function getTotalProperty()
    {
        return collect($this->cart)->sum(function ($item) {
            return ($item['sale_price'] ?? $item['price']) * $item['quantity'];
        });
    }

    public function render()
    {
        return view('livewire.cart-manager', [
            'total' => $this->getTotalProperty()
        ]);
    }
}
