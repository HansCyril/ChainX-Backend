<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', config('filesystems.default'));
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.products.edit', $id);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', config('filesystems.default'));
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
