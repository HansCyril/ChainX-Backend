<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        // Revenue by month (last 6 months) — MySQL syntax
        $revenueByMonth = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_amount) as revenue, COUNT(*) as orders")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top selling products
        $topProducts = OrderItem::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_sold, SUM(quantity * price) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(8)
            ->get();

        // Order status breakdown
        $statusBreakdown = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $stats = [
            'total_revenue'     => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_orders'      => Order::count(),
            'total_customers'   => User::where('is_admin', false)->count(),
            'total_products'    => Product::count(),
            'avg_order_value'   => Order::where('payment_status', 'paid')->avg('total_amount') ?? 0,
            'pending_orders'    => Order::where('status', 'pending')->count(),
        ];

        // Most wishlisted products
        $mostWishlisted = Product::withCount('wishlists')
            ->orderByDesc('wishlists_count')
            ->take(8)
            ->get();

        return view('admin.reports.index', compact('stats', 'revenueByMonth', 'topProducts', 'statusBreakdown', 'mostWishlisted'));
    }
}
