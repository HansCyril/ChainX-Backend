<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->latest('updated_at');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $stockFilter = $request->stock ?? 'all';
        if ($stockFilter === 'out') {
            $query->where('quantity', '<=', 0);
        } elseif ($stockFilter === 'low') {
            $query->where('quantity', '>', 0)->where('quantity', '<=', 5);
        }

        $products = $query->paginate(20)->withQueryString();

        return view('admin.inventory.index', compact('products', 'stockFilter'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $product->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Stock updated for ' . escapeshellarg($product->name));
    }
}
