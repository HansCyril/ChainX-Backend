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
    public function export()
    {
        $fileName = 'ChainX_Business_Report_' . date('Y-m-d') . '.csv';

        // Monthly Revenue data
        $dateFunc = DB::getDriverName() === 'sqlite' 
            ? "strftime('%Y-%m', created_at)" 
            : "DATE_FORMAT(created_at, '%Y-%m')";

        $revenueByMonth = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw("{$dateFunc} as month, SUM(total_amount) as revenue, COUNT(*) as orders")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $topProducts = OrderItem::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_sold, SUM(quantity * price) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(20)
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($revenueByMonth, $topProducts) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['CHAINX BUSINESS REPORT - ' . date('F d, Y')]);
            fputcsv($file, []);

            // Overall Stats
            fputcsv($file, ['OVERALL PERFORMANCE']);
            fputcsv($file, ['Total Revenue', '₱' . number_format(Order::where('payment_status', 'paid')->sum('total_amount'), 2)]);
            fputcsv($file, ['Total Orders', Order::count()]);
            fputcsv($file, ['Avg Order Value', '₱' . number_format(Order::where('payment_status', 'paid')->avg('total_amount') ?? 0, 2)]);
            fputcsv($file, []);

            // Monthly Data
            fputcsv($file, ['MONTHLY REVENUE TREND (Last 6 Months)']);
            fputcsv($file, ['Month', 'Revenue', 'Orders']);
            foreach ($revenueByMonth as $row) {
                fputcsv($file, [$row->month, $row->revenue, $row->orders]);
            }
            fputcsv($file, []);

            // Product Data
            fputcsv($file, ['TOP SELLING PRODUCTS']);
            fputcsv($file, ['Product Name', 'Units Sold', 'Total Revenue']);
            foreach ($topProducts as $tp) {
                fputcsv($file, [$tp->product->name ?? 'N/A', $tp->total_sold, $tp->total_revenue]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function index()
    {
        // Revenue by month (last 6 months)
        $dateFunc = DB::getDriverName() === 'sqlite' 
            ? "strftime('%Y-%m', created_at)" 
            : "DATE_FORMAT(created_at, '%Y-%m')";

        $revenueByMonth = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw("{$dateFunc} as month, SUM(total_amount) as revenue, COUNT(*) as orders")
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
