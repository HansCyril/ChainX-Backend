<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        // Check unique slug manually since brand slugs must be unique
        if (Brand::where('slug', $validated['slug'])->exists()) {
            return back()->withInput()->withErrors(['name' => 'This brand name creates a slug that already exists.']);
        }
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('brands', config('filesystems.default'));
        }

        Brand::create($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.brands.edit', $id);
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $slug = Str::slug($validated['name']);
        
        if ($slug !== $brand->slug && Brand::where('slug', $slug)->exists()) {
            return back()->withInput()->withErrors(['name' => 'This brand name creates a slug that exists on another brand.']);
        }

        $validated['slug'] = $slug;
        $validated['is_active'] = $request->has('is_active');
        
        if ($request->hasFile('image')) {
            if ($brand->image) {
                Storage::disk(config('filesystems.default'))->delete($brand->image);
            }
            $validated['image'] = $request->file('image')->store('brands', config('filesystems.default'));
        }

        $brand->update($validated);

        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        // Don't delete if it has products
        if ($brand->products()->count() > 0) {
            return redirect()->route('admin.brands.index')->with('error', 'Cannot delete a brand that contains products.');
        }
        
        if ($brand->image) {
            Storage::disk(config('filesystems.default'))->delete($brand->image);
        }
        
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully.');
    }
}
