<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class Checkout extends Component
{
    public $address = '';
    public $notes = '';
    public $paymentMethod = 'stripe';
    public $cart = [];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        if (count($this->cart) === 0) {
            return redirect()->route('products.index');
        }
    }

    public function placeOrder()
    {
        $this->validate([
            'address' => 'required|min:10',
            'paymentMethod' => 'required',
        ]);

        $total = collect($this->cart)->sum(function ($item) {
            return ($item['sale_price'] ?? $item['price']) * $item['quantity'];
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'status' => 'pending',
            'total_amount' => $total,
            'payment_status' => 'pending',
            'payment_method' => $this->paymentMethod,
            'shipping_address' => $this->address,
            'notes' => $this->notes,
        ]);

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['sale_price'] ?? $item['price'],
            ]);
        }

        session()->forget('cart');
        
        return redirect()->route('dashboard')->with('success', 'Order placed successfully!');
    }

    public function render()
    {
        $total = collect($this->cart)->sum(function ($item) {
            return ($item['sale_price'] ?? $item['price']) * $item['quantity'];
        });

        return view('livewire.checkout', [
            'total' => $total
        ]);
    }
}
