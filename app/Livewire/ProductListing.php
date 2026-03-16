<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;

class ProductListing extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = null;
    public $selectedBrand = null;
    public $minPrice = 0;
    public $maxPrice = 10000;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => null],
        'selectedBrand' => ['except' => null],
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 10000],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product) return;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'quantity' => 1,
                'slug' => $product->slug,
                'image' => $product->images->where('is_primary', true)->first()?->image_path ?? 'https://placehold.co/100x100?text=' . urlencode($product->name),
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        $products = Product::query()
            ->where('is_active', true)
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->when($this->selectedBrand, function ($query) {
                $query->where('brand_id', $this->selectedBrand);
            })
            ->whereBetween('price', [$this->minPrice, $this->maxPrice])
            ->when($this->sortBy === 'price', function ($query) {
                $query->orderBy('price', 'asc');
            })
            ->when($this->sortBy === 'price_desc', function ($query) {
                $query->orderBy('price', 'desc');
            })
            ->when($this->sortBy === 'name', function ($query) {
                $query->orderBy('name', 'asc');
            })
            ->when($this->sortBy === 'created_at', function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->paginate(12);

        return view('livewire.product-listing', [
            'products' => $products,
            'categories' => Category::where('is_active', true)->get(),
            'brands' => Brand::where('is_active', true)->get(),
        ]);
    }
}
