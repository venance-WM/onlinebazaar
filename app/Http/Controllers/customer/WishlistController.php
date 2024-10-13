<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;


class WishlistController extends Controller
{

    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);
        return redirect()->back()->with('success', 'Product added to wishlist');
 
     }

     public function removeFromWishlist(Request $request)
     {
         $request->validate([
             'product_id' => 'required|exists:products,id',
         ]);
 
         $wishlist = Wishlist::where('user_id', Auth::id())
                             ->where('product_id', $request->product_id)
                             ->first();
 
         if ($wishlist) {
             $wishlist->delete();
             return redirect()->back()->with('success', 'Product removed from wishlist');
         }
 
         return redirect()->back()->with('error', 'Product not found in wishlist');
     }

    public function showWishlist()
    {
        $wishlists = Wishlist::with('product')->where('user_id', Auth::id())->get();

        return view('customers.wishlist', compact('wishlists'));
    }
}