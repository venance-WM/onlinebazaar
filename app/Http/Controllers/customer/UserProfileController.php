<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\ShopSubscription;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use Illuminate\Validation\Rule;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\District;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserLocation;
use App\Models\Region;
use App\Models\Street;
use App\Models\Ward;
use App\Models\ServiceOrder;


class UserProfileController extends Controller
{
    /**
     * Show the user profile screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $section)
    {
        $user = $request->user();
        $userLocation = $user->location;

        // Orders
        $productsOrders = Order::where('customer_id', Auth::id())->latest()->get();
        $serviceOrders = ServiceOrder::where('customer_id', Auth::id())->latest()->get();

        // Merge orders and service orders
        $mergedOrders = $productsOrders->merge($serviceOrders);
        $sortedOrders = $mergedOrders->sortByDesc('created_at');

        return view('profile.show', [
            'request' => $request,
            'user' => $user,
            'orders' => $sortedOrders,
            'section' => $section,
            'userLocation' => $userLocation,
            'regions' => Region::all(),
            'districts' => District::all(),
            'wards' => Ward::all(),
            'streets' => Street::all(),
            'wishlists' => Wishlist::with('product')->where('user_id', Auth::id())->get(),

        ]);
    }
    public function updateAccountDetails(Request $request)
    {

        $updater = new UpdateUserProfileInformation; // Create an instance

        $updater->update(
            auth()->user(),
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user()->id)],
                'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
                'phone' => ['nullable', 'string'],
            ])
        );

        return redirect()->route('profile.show', 'account')->with('message', 'Address updated successfully!');
    }

    public function updateLocation(Request $request, User $user)
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

        return redirect()->route('profile.show', 'address')->with('message', 'Address updated successfully!');
    }

    public function subscribe(Request $request, $sellerId)
    {

        // Create or update the subscription
        ShopSubscription::updateOrCreate(
            ['customer_id' => $request->user()->id, 'seller_id' => $sellerId]
        );

        return redirect()->back()->with('message', 'Subscribed successfully');
    }

    public function unsubscribe(Request $request, $sellerId)
    {
        ShopSubscription::where('customer_id', $request->user()->id)->where('seller_id', $sellerId)->delete();

        return redirect()->back()->with('message', 'Unsubscribed successfully');
    }
}
