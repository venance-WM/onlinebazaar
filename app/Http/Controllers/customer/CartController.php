<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    // Display the cart page with all the items
    public function index()
    {
        $user = auth()->user();
        $cartItems = Cart::where('customer_id', $user->id)->with('product')->latest()->get();
    
        // Get all unique category IDs from cart items
        $categoryIds = $cartItems->pluck('product.category_id')->unique()->toArray();
    
        // Fetch related products from the same categories, excluding those already in cart
        $relatedProducts = Product::where(function ($query) use ($categoryIds) {
            foreach ($categoryIds as $categoryId) {
                $query->orWhere('category_id', $categoryId);
            }
        })->whereNotIn('id', $cartItems->pluck('product.id')->toArray())
          ->limit(12)
          ->get();
    
        return view('customers.cart', compact('cartItems', 'relatedProducts'));
    }

    // Add a product to cart
    public function store(Request $request, $id)
    {
        $user = auth()->user();
        $quantity = $request->input('quantity', 1);

        // Create a new cart item
        $cart = new Cart();
        $cart->customer_id = $user->id;
        $cart->product_id = $id;
        $cart->quantity = $quantity;
        $cart->save();

        return redirect()->route('cart.index');
    }

    // Update a product item quantity direct from cart page
    public function update(Request $request, $id)
    {
        $cartItem = Cart::find($id);
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    // Total costs
    public function getTotals()
    {
        $cartItems = Cart::where('customer_id', auth()->id())->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'subtotal' => $subtotal,
            'grandTotal' => $subtotal // Assuming no additional costs
        ]);
    }

    // Remove an item from cart
    public function destroy($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index');
    }

    /**
     * THIS FUNCTION IS FOR LOGGING JS ERRORS FROM CARTS Javascripts, if any
     * error occur and store to Storage/laravel.log
     */
    public function logJSError(Request $request)
    {
        Log::error('JS Error:', [
            'message' => $request->message,
            'url' => $request->url,
            'line' => $request->line,
            'column' => $request->column,
            'error' => $request->error
        ]);

        return response()->json(['success' => true]);
    }
}
