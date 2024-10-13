<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\ServiceOrder;
use App\Models\Review;
use App\Models\District;
use App\Models\Street;
use App\Models\Ward;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\Facades\Validator;
use App\Models\UserLocation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{

    public function dashboard()
    {
        $user = Auth::user();

        // Check if the user's password is '123456' (default password)
        if (Hash::check('123456', $user->password)) {
            session(['login-alert' => 'Change your password to continue.']);
        }

        //cutomers
        $sellerId = Auth::id();
        $customers = User::whereHas('orders.orderItems.product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })
            ->where('role', User::ROLE_CUSTOMER)
            ->distinct()
            ->count();
        //reviews
        $reviews = Review::whereHas('product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })
            ->with(['product', 'user' => function ($query) {
                $query->where('role', User::ROLE_CUSTOMER);
            }])
            ->count();
        //product orders
        $productOrders = Order::whereHas('orderItems.product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->with(['user', 'orderItems' => function ($query) use ($sellerId) {
            $query->whereHas('product', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId);
            });
        }, 'orderItems.product'])->count();
        //service orders
        $serviceOrders = ServiceOrder::with('service', 'user')
            ->whereHas('service', function ($query) {
                $query->where('seller_id', Auth::id());
            })
            ->count();

        return view('seller.home', compact('customers', 'reviews', 'productOrders', 'serviceOrders'));
    }

    public function reviews()
    {
        $sellerId = auth()->user()->id; // Assuming the seller is authenticated

        $reviews = Review::whereHas('product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })
            ->with(['product', 'user' => function ($query) {
                $query->where('role', User::ROLE_CUSTOMER);
            }])
            ->get();

        return view('seller.reviews', compact('reviews'));
    }


    public function documentation()
    {
        return view('documentation');
    }


    /**  
     * A function to join tables and filter users with role 2 (customers) 
     * who have orders with order items that include products added 
     * by the logged-in seller 
     */
    public function customers()
    {
        $sellerId = Auth::id();

        $customers = User::whereHas('orders.orderItems.product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })
            ->where('role', User::ROLE_CUSTOMER)
            ->distinct()
            ->get();

        return view('seller.view_customers', compact('customers'));
    }

    /**
     * Show the Seller profile setting screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */

    public function ProfileDetailsSettings(Request $request)
    {

        $user = $request->user();
        $userLocation = $user->location;

        return view('profile.settings.profile-details', [
            'request' => $request,
            'user' => $user,
            'userLocation' => $userLocation,
            'regions' => Region::all(),
            'districts' => District::all(),
            'wards' => Ward::all(),
            'streets' => Street::all(),

        ]);
    }

    public function updateSellerDetails(Request $request)
    {
        $updater = new UpdateUserProfileInformation;

        $updater->update(
            auth()->user(),
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->whereNull('deleted_at')->ignore(auth()->user()->id)],
                'phone' => ['nullable', 'string', 'max:15'],
                'whatsapp' => ['nullable', 'string', 'max:15'],
                'profile' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
            ])
        );

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function removeProfilePicture()
    {
        $remove = new UpdateUserProfileInformation;

        $remove->removeProfilePicture(auth()->user());

        return redirect()->back()->with('success', 'Profile picture removed successfully.');
    }

    public function updateSellerLocation(Request $request, User $user)
    {
        $input = $request->all();

        Validator::make($input, [
            'region' => ['required', 'integer'],
            'district' => ['required', 'integer'],
            'ward' => ['required', 'integer'],
            'place' => ['nullable', 'string', 'max:255'],
        ])->validate();

        // Retrieve or create the user's location
        $location = $user->location ?? new UserLocation();
        $location->user_id = $user->id;
        $location->region_id = $input['region'];
        $location->district_id = $input['district'];
        $location->ward_id = $input['ward'];
        $location->street_id = $input['street'];
        $location->place = $input['place'];
        $location->save();

        return redirect()->route('seller.settings.profile-details')->with('message', 'Address updated successfully!');
    }

    public function securitySettings(Request $request)
    {
        $sessions = DB::table('sessions')
            ->where('user_id', Auth::id())
            ->orderBy('last_activity', 'desc')
            ->get();

        return view('profile.settings.security', [
            'sessions' => $sessions,
            'request' => $request,
        ]);
    }

    public function view_orders()
    {
        $sellerId = auth()->user()->id;

        $orders = Order::whereHas('orderItems.product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->with(['user', 'orderItems' => function ($query) use ($sellerId) {
            $query->whereHas('product', function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId);
            });
        }, 'orderItems.product'])->get();

        return view('seller.orders.index', compact('orders'));
    }

    public function removeSellerLocation()
    {
        $sellerId = auth()->user()->id;

        $sellerLocation = UserLocation::where('user_id', $sellerId)->first();

        if ($sellerLocation) {
            $sellerLocation->delete();
            return redirect()->back()->with('success', 'Your location has been removed successfully');
        }

        return redirect()->back()->with('error', 'You have not yet added any location to remove');
    }


    public function deleteSellerAccount()
    {
        $sellerId = auth()->user()->id;

        $seller = User::find($sellerId);

        if ($seller) {

            // $seller->delete();

            return redirect('/')->with('success', 'Your account has been deleted successfully');
        }

        return redirect()->back()->with('error', 'User not found');
    }
}
