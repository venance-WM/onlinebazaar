<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Review;
use App\Models\Product;
use App\Models\Service;
use App\Models\ShopSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{

    public function index(Request $request)
    {
        // Check if the user is logged in
        $customer = $request->user();

        if ($customer) {
            // Get IDs of subscribed shops for the logged-in user
            $subscribedShopIds = ShopSubscription::where('customer_id', $customer->id)->pluck('seller_id');

            // Fetch random products from subscribed shops
            $recentProducts = Product::with('seller')
                ->when($subscribedShopIds->isNotEmpty(), function ($query) use ($subscribedShopIds) {
                    $query->whereIn('seller_id', $subscribedShopIds);
                })
                ->inRandomOrder()
                ->limit(12)
                ->get();

            // Fetch random services from subscribed shops
            $recentServices = Service::with('seller')
                ->when($subscribedShopIds->isNotEmpty(), function ($query) use ($subscribedShopIds) {
                    $query->whereIn('seller_id', $subscribedShopIds);
                })
                ->inRandomOrder()
                ->limit(12)
                ->get();
        } else {
            // For users not logged in, fetch random products and services without filtering
            $recentProducts = Product::with('seller')
                ->inRandomOrder()
                ->limit(12)
                ->get();

            $recentServices = Service::with('seller')
                ->inRandomOrder()
                ->limit(12)
                ->get();
        }

        // Fetch categories (can remain unchanged)
        $categories = Category::latest('created_at')->limit(12)->paginate(12);

        return view('home', compact('recentServices', 'recentProducts', 'categories'));
    }

    // public function viewProducts($cat_id = null)
    // {
    //     $products = $cat_id ? Product::where('category_id', $cat_id)->paginate(12) : Product::paginate(12);

    //     return view('products', compact('products'));
    // }

    public function viewProducts(Request $request, $cat_id = null)
    {
        $customer = $request->user();

        if ($customer) {
            // Get IDs of subscribed shops
            $subscribedShopIds = ShopSubscription::where('customer_id', $customer->id)->pluck('seller_id');

            // Fetch products from subscribed shops first
            $products = Product::with('seller')
                ->when($subscribedShopIds->isNotEmpty(), function ($query) use ($subscribedShopIds) {
                    $query->whereIn('seller_id', $subscribedShopIds);
                })
                ->when($cat_id, function ($query) use ($cat_id) {
                    $query->where('category_id', $cat_id);
                })
                ->inRandomOrder()
                ->paginate(12);
        } else {
            // For users not logged in, fetch products without prioritizing subscriptions
            $products = Product::when($cat_id, function ($query) use ($cat_id) {
                $query->where('category_id', $cat_id);
            })
                ->inRandomOrder()
                ->paginate(12);
        }

        return view('products', compact('products'));
    }


    public function filterProducts(Request $request)
    {
        $cat_id = $request->input('cat_id');
        $sortBy = $request->input('sortBy');

        $query = Product::query();

        if ($cat_id) {
            $query->where('category_id', $cat_id);
        }

        switch ($sortBy) {
            case 'newest':
                $query->orderByDesc('created_at');
                break;
            case 'popular':
                //  Logic for popular sorting
                break;
            case 'most_sale':
                // Logic for most sale sorting
                break;
            case 'low_to_high':
                $query->orderBy('price');
                break;
            case 'high_to_low':
                $query->orderByDesc('price');
                break;
            case 'random':
                $query->inRandomOrder();
                break;
            default:
                $query->latest('created_at');
                break;
        }

        $products = $query->paginate(12);

        if ($request->ajax()) {
            $view = view('partials.product_list', compact('products'))->render();
            $filters = view('partials.product_filters')->render();

            return response()->json([
                'products' => $view,
                'filters' => $filters,
            ]);
        }

        return view('products', compact('products'));
    }

    public function showProduct($id)
    {
        $product = Product::with('unit')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->limit(12)
            ->get();
        $reviews = Review::where('product_id', $id)->get();

        return view('product_details', compact('product', 'relatedProducts', 'reviews'));
    }

    public function viewServices(Request $request)
    {
        $customer = $request->user();
    
        if ($customer) {
            // Get IDs of subscribed shops
            $subscribedShopIds = ShopSubscription::where('customer_id', $customer->id)->pluck('seller_id');
    
            // Fetch services from subscribed shops first
            $services = Service::with('seller')
                ->when($subscribedShopIds->isNotEmpty(), function ($query) use ($subscribedShopIds) {
                    $query->whereIn('seller_id', $subscribedShopIds);
                })
                ->inRandomOrder()
                ->paginate(12);
        } else {
            // For users not logged in, fetch services without prioritizing subscriptions
            $services = Service::inRandomOrder()
                ->paginate(12);
        }
    
        return view('services', compact('services'));
    }

    public function showService(Request $request, $id)
    {
        $seller = $request->user();
        // $sellerLocation = $seller->location;

        $service = Service::findOrFail($id);
        return view('service_details', compact('service'));
    }

    public function viewCategories()
    {
        $categories = Category::paginate(12);
        return view('categories', compact('categories'));
    }

    public function searchProductsOrServices(Request $request)
    {
        $searchQuery = $request->input('query');

        // Determine if the customer is logged in and has location information
        $user = auth()->user();
        $customerLocation = $user ? $user->location : null;

        if ($customerLocation) {
            // Prioritizing results based on customer's location
            $products = Product::where(function ($query) use ($searchQuery) {
                $query->where('products.name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('products.description', 'LIKE', "%{$searchQuery}%");
            })
                ->join('users', 'products.seller_id', '=', 'users.id')
                ->leftJoin('user_locations', 'users.id', '=', 'user_locations.user_id')
                ->select('products.*', 'user_locations.street_id', 'user_locations.ward_id', 'user_locations.district_id', 'user_locations.region_id')
                ->orderByRaw('CASE 
                            WHEN user_locations.street_id = ? THEN 1
                            WHEN user_locations.ward_id = ? THEN 2
                            WHEN user_locations.district_id = ? THEN 3
                            WHEN user_locations.region_id = ? THEN 4
                            ELSE 5 
                          END', [
                    $customerLocation->street_id,
                    $customerLocation->ward_id,
                    $customerLocation->district_id,
                    $customerLocation->region_id
                ])
                ->paginate(12);

            $services = Service::where(function ($query) use ($searchQuery) {
                $query->where('services.name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('services.description', 'LIKE', "%{$searchQuery}%");
            })
                ->join('users', 'services.seller_id', '=', 'users.id')
                ->leftJoin('user_locations', 'users.id', '=', 'user_locations.user_id')
                ->select('services.*', 'user_locations.street_id', 'user_locations.ward_id', 'user_locations.district_id', 'user_locations.region_id')
                ->orderByRaw('CASE 
                            WHEN user_locations.street_id = ? THEN 1
                            WHEN user_locations.ward_id = ? THEN 2
                            WHEN user_locations.district_id = ? THEN 3
                            WHEN user_locations.region_id = ? THEN 4
                            ELSE 5 
                          END', [
                    $customerLocation->street_id,
                    $customerLocation->ward_id,
                    $customerLocation->district_id,
                    $customerLocation->region_id
                ])
                ->paginate(12);
        } else {
            // Normal search without location priority
            $products = Product::where('name', 'LIKE', "%{$searchQuery}%")
                ->orWhere('description', 'LIKE', "%{$searchQuery}%")
                ->paginate(12);

            $services = Service::where('name', 'LIKE', "%{$searchQuery}%")
                ->orWhere('description', 'LIKE', "%{$searchQuery}%")
                ->paginate(12);
        }

        return view('search_results', compact('products', 'services', 'searchQuery'));
    }

    public function showSellerProfile($id)
    {
        $seller = User::findOrFail($id);
        $services = Service::where('seller_id', $id)->get();
        $products = Product::where('seller_id', $id)->get();

        return view('seller_profile', compact('services', 'products', 'seller'));
    }

    public function searchNearestSellers(Request $request)
    {
        $userLatitude = $request->query('lat');
        $userLongitude = $request->query('lng');

        $sellers = DB::table('seller_details')
            ->join('users', 'seller_details.user_id', '=', 'users.id')
            ->select(
                'seller_details.id',
                'users.name as seller_name',
                'seller_details.latitude',
                'seller_details.longitude',
                DB::raw("( 6371 * acos( cos( radians($userLatitude) ) * cos( radians( seller_details.latitude ) ) * cos( radians( seller_details.longitude ) - radians($userLongitude) ) + sin( radians($userLatitude) ) * sin( radians( seller_details.latitude ) ) ) ) AS distance")
            )
            ->having('distance', '<', 2) // Filter within 2 km radius
            ->orderBy('distance')
            ->get();

        return response()->json($sellers); // Return data as JSON
    }

    public function showMap()
    {
        return view('shops.map');
    }
    public function navigateToShop($id)
    {
        $seller = User::findOrFail($id);
        $services = Service::where('seller_id', $id)->get();
        $products = Product::where('seller_id', $id)->get();

        return view('seller_profile', compact('services', 'products', 'seller'));
    }

    public function show($id)
    {
        $shop = DB::table('seller_details')
            ->join('users', 'seller_details.user_id', '=', 'users.id')
            ->select('users.name as seller_name', 'seller_details.*')
            ->where('seller_details.id', $id)
            ->first();

        if (!$shop) {
            return redirect()->route('home')->with('error', 'Shop not found.');
        }

        return view('shops.show', compact('shop'));
    }
}
