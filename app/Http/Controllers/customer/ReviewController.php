<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required',
        ]);

        $user = Auth::user(); 

        $review = new Review();
        $review->product_id = $productId;
        $review->name = $user->name; 
        $review->email = $user->email; 
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->save();

        // Increment review count in product model
        // $product = Product::findOrFail($productId);
        // $product->reviews_count = $product->reviews()->count();
        // $product->save();

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}