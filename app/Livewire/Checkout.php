<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\Wishlist;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Checkout extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $notes = '';
    public $paymentMethod = 'cod';
    public $cart = [];
    public $promoCodeId = null;
    public $discount = 0;
    public $subtotal = 0;
    public $total = 0;

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        
        if (count($this->cart) === 0) {
            return redirect()->route('products.index');
        }

        if (auth()->check()) {
            $user = auth()->user();
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->address = $user->address;
        }

        $this->calculateTotals();
    }

    protected function calculateTotals()
    {
        $this->subtotal = collect($this->cart)->sum(function ($item) {
            return ($item['sale_price'] ?? $item['price']) * $item['quantity'];
        });

        $this->discount = 0;
        $this->promoCodeId = null;

        if (session()->has('promo_code')) {
            $promo = PromoCode::find(session('promo_code')['id']);
            if ($promo && $promo->isValid($this->subtotal)) {
                $this->promoCodeId = $promo->id;
                $this->discount = $promo->calculateDiscount($this->subtotal);
            } else {
                session()->forget('promo_code');
            }
        }

        $this->total = max(0, $this->subtotal - $this->discount);
    }

    public function placeOrder()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|min:10',
            'paymentMethod' => 'required',
        ]);

        $this->calculateTotals(); // Final check before order

        try {
            DB::beginTransaction();

            // 1. Create Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'status' => 'pending',
                'subtotal' => $this->subtotal,
                'discount_amount' => $this->discount,
                'total_amount' => $this->total,
                'promo_code_id' => $this->promoCodeId,
                'payment_status' => 'pending', // Simulating pending until payment
                'payment_method' => $this->paymentMethod,
                'shipping_address' => $this->address,
                'notes' => $this->notes,
            ]);

            // 2. Create Order Items & Update Stock (With Locking for Race Conditions)
            foreach ($this->cart as $cartItem) {
                $product = Product::where('id', $cartItem['id'])->lockForUpdate()->first();
                
                if (!$product || $product->quantity < $cartItem['quantity']) {
                    throw new \Exception("Insufficient stock for " . ($product->name ?? 'unknown product'));
                }

                // Create Order Item
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $cartItem['quantity'],
                    'price' => $cartItem['sale_price'] ?? $cartItem['price'],
                ]);

                // Decrement Stock
                $product->decrement('quantity', $cartItem['quantity']);
            }

            // 3. Mark Promo as used
            if ($this->promoCodeId) {
                $promo = PromoCode::where('id', $this->promoCodeId)->lockForUpdate()->first();
                if ($promo) {
                    $promo->increment('used_count');
                }
            }

            // 4. Remove ordered items from Wishlist
            Wishlist::where('user_id', auth()->id())
                ->whereIn('product_id', collect($this->cart)->pluck('id'))
                ->delete();

            $this->dispatch('wishlist-updated');

            // 5. Log high-value action for security audit
            \Illuminate\Support\Facades\Log::info("SECURITY_AUDIT: Order placed", [
                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'total' => $this->total
            ]);

            DB::commit();

            session()->forget(['cart', 'promo_code']);
            session()->flash('success', 'Order placed successfully!');

            return redirect()->route('orders.index');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('payment', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
