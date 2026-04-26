<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\PromoCode;

class CartManager extends Component
{
    public $cart = [];
    public $promoInput = '';
    public $promoCode = null;
    public $promoError = '';
    public $discount = 0;

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
        // Restore promo from session
        $savedCode = session('promo_code');
        if ($savedCode) {
            $this->promoCode = PromoCode::where('code', $savedCode)->first();
            if ($this->promoCode) {
                $this->promoInput = $this->promoCode->code;
                $this->recalcDiscount();
            }
        }
    }

    public function loadCart()
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $id => &$item) {
            $product = Product::find($id);
            if ($product) {
                $item['image'] = $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/100x100?text=' . urlencode($product->name);
            }
        }

        $this->cart = $cart;
        session()->put('cart', $cart);
        $this->recalcDiscount();
    }

    public function addToCart($productId, $quantity = 1)
    {
        $product = Product::find($productId);
        if (!$product) return;

        $cart = session()->get('cart', []);
        $currentQty = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;

        if ($currentQty + $quantity > $product->quantity) {
             $this->dispatch('show-toast', message: "Maximum stock reached! Only {$product->quantity} units available.", type: 'error');
             return;
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id'         => $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'sale_price' => $product->sale_price,
                'quantity'   => $quantity,
                'slug'       => $product->slug,
                'image'      => $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/100x100?text=' . urlencode($product->name),
            ];
        }

        session()->put('cart', $cart);
        $this->loadCart();
        $this->dispatch('cartUpdated');
        $this->dispatch('cart-added',
            name: $product->name,
            image: $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/80x80?text=' . urlencode($product->name),
        );
    }

    public function updateQuantity($productId, $quantity)
    {
        $product = Product::find($productId);
        if (!$product) return;

        if ($quantity > $product->quantity) {
            $this->dispatch('show-toast', message: "Only {$product->quantity} units available in stock.", type: 'error');
            return;
        }

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

    public function applyPromo()
    {
        $this->promoError = '';
        $code = PromoCode::where('code', strtoupper(trim($this->promoInput)))->first();

        if (!$code) {
            $this->promoError = 'Invalid promo code.';
            $this->promoCode = null;
            $this->discount = 0;
            session()->forget('promo_code');
            return;
        }

        if (!$code->isValid()) {
            $this->promoError = 'This promo code is expired or no longer valid.';
            $this->promoCode = null;
            $this->discount = 0;
            session()->forget('promo_code');
            return;
        }

        if ($this->getSubtotalProperty() < $code->min_order_amount) {
            $this->promoError = 'Minimum order of ₱' . number_format($code->min_order_amount, 2) . ' required.';
            $this->promoCode = null;
            $this->discount = 0;
            session()->forget('promo_code');
            return;
        }

        $this->promoCode = $code;
        session()->put('promo_code', $code->code);
        $this->recalcDiscount();
    }

    public function removePromo()
    {
        $this->promoCode = null;
        $this->promoInput = '';
        $this->promoError = '';
        $this->discount = 0;
        session()->forget('promo_code');
    }

    protected function recalcDiscount()
    {
        if ($this->promoCode) {
            $this->discount = $this->promoCode->calculateDiscount($this->getSubtotalProperty());
        } else {
            $this->discount = 0;
        }
    }

    public function getSubtotalProperty()
    {
        return collect($this->cart)->sum(function ($item) {
            return ($item['sale_price'] ?? $item['price']) * $item['quantity'];
        });
    }

    public function getTotalProperty()
    {
        return max(0, $this->getSubtotalProperty() - $this->discount);
    }

    public function render()
    {
        return view('livewire.cart-manager', [
            'subtotal' => $this->getSubtotalProperty(),
            'total'    => $this->getTotalProperty(),
        ]);
    }
}
