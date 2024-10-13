<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ServiceOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Each user can see is own orders & this help
    public function index()
    {
        // Get product orders
        $productsOrders = Order::where('customer_id', Auth::id())->latest()->get();
    
        // Get service orders
        $serviceOrders = ServiceOrder::where('customer_id', Auth::id())->latest()->get();
    
        // Merge orders and service orders
        $mergedOrders = $productsOrders->merge($serviceOrders);
    
        // Sort merged orders by created_at date in descending order
        $sortedOrders = $mergedOrders->sortByDesc('created_at');
    
        return view('customers.orders.index', ['orders' => $sortedOrders]);
    }

    // Show a specific order details
    public function show($id)
    {
        $order = Order::where('customer_id', Auth::id())->with('orderItems.product')->findOrFail($id);
    
        // Get all unique category IDs from order items
        $categoryIds = $order->orderItems->pluck('product.category_id')->unique()->toArray();
    
        // Fetch related products from the same categories, excluding those already in order
        $relatedProducts = Product::where(function ($query) use ($categoryIds) {
            foreach ($categoryIds as $categoryId) {
                $query->orWhere('category_id', $categoryId);
            }
        })->whereNotIn('id', $order->orderItems->pluck('product.id')->toArray())
          ->limit(12)
          ->get();

        return view('customers.orders.show', compact('order', 'relatedProducts'));
    }

    // Place order & clear cart items
    public function placeOrder()
    {
        $userId = Auth::id();
        $cartItems = Cart::where('customer_id', $userId)->get();
    
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
    
        DB::transaction(function () use ($userId, $cartItems) {
            // Assuming all cart items belong to products from the same seller
            $sellerId = $cartItems->first()->product->seller_id;
    
            // Create order
            $order = Order::create([
                'customer_id' => $userId,
                'seller_id' => $sellerId,
                'total_amount' => $cartItems->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                }),
                'status' => 'pending',
            ]);
    
            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
    
                // Update product stock
                $product = Product::find($cartItem->product_id);
                $product->stock_quantity -= $cartItem->quantity;
                $product->save();
            }
    
            // Clear the cart after order creation
            Cart::where('customer_id', $userId)->delete();
        });
    
        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
     }

    // Delete an order
    public function destroy($id)
    {
        $order = Order::where('customer_id', Auth::id())->findOrFail($id);

        // Restore products quantity after order cancel
        foreach ($order->orderItems as $orderItem) {
            // Update product stock
            $product = Product::find($orderItem->product_id);
            $product->stock_quantity += $orderItem->quantity;
            $product->save();
        }

        // Delete the order items first
        $order->orderItems()->delete();

        // Delete the order
        $order->delete();

        return redirect()->route('profile.show', 'orders')->with('success', 'Order deleted successfully!');
    }
}