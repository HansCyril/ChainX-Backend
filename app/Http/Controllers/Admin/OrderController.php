<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

use App\Models\Rider;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'rider'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        $orders = $query->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product', 'rider');
        $riders = Rider::where('is_active', true)->get();
        return view('admin.orders.show', compact('order', 'riders'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'tracking_number' => 'nullable|string|max:100',
            'shipping_carrier' => 'nullable|string|max:100',
            'estimated_delivery_at' => 'nullable|date',
            'rider_id' => 'nullable|exists:riders,id',
        ]);

        if ($data['status'] === 'shipped' && $order->status !== 'shipped') {
            $data['shipped_at'] = now();
        }

        if ($data['status'] === 'delivered' && $order->status !== 'delivered') {
            $data['delivered_at'] = now();
        }

        $order->update($data);

        return back()->with('success', 'Order updated successfully.');
    }
}
