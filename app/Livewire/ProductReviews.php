<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Review;

class ProductReviews extends Component
{
    public Product $product;
    public $rating = 5;
    public $comment = '';
    public $showForm = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|min:5|max:1000',
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function submitReview()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate();

        // Check if user already reviewed
        $exists = Review::where('user_id', auth()->id())
            ->where('product_id', $this->product->id)
            ->exists();

        if ($exists) {
            $this->dispatch('show-toast', message: "You already reviewed this product!", type: 'error');
            return;
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $this->product->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->comment = '';
        $this->showForm = false;
        $this->product->load('reviews');
        $this->dispatch('show-toast', message: "Review submitted successfully!", type: 'success');
    }

    public function render()
    {
        $reviews = $this->product->reviews()->with('user')->latest()->get();
        $averageRating = $reviews->avg('rating');

        return view('livewire.product-reviews', [
            'reviews' => $reviews,
            'averageRating' => $averageRating,
        ]);
    }
}
