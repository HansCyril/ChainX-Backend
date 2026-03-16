<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sales' => \App\Models\Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_orders' => \App\Models\Order::count(),
            'total_products' => \App\Models\Product::count(),
            'recent_orders' => \App\Models\Order::with('user')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
