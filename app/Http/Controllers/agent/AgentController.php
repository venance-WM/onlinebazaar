<?php

namespace App\Http\Controllers\agent;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\LipaAccount;
use App\Models\SellerDetail;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SellerRequest;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    public function index()
    {
       
        $user = Auth::user();

        if (Hash::check('123456', $user->password)) {
            session(['login-alert' => 'Change your password to continue.']);
        }
        $agent = auth()->user();
        $totalSellers = SellerRequest::where('agent_id', $agent->id)->count();

        $totalProducts = ProductRequest::where('agent_id', $agent->id)->count();

        $pendingApprovals = ProductRequest::where('agent_id', $agent->id)
            ->where('status', 'pending')
            ->count();

        return view('agent.index', compact('totalSellers', 'totalProducts', 'pendingApprovals'));
    }
    //DASHOARD
  public function viewSellers()
{
    $agent = auth()->user();

    // Get sellers from the users table who have role 2 and are referenced in the SellerRequest table by their IDs
    $sellers = User::where('role', 2)
                   ->whereIn('id', SellerRequest::where('agent_id', $agent->id)->pluck('seller_id')) // Assuming seller_id is the reference to users table in SellerRequest
                   ->get();

    return view('agent.seller', compact('sellers'));
}
public function view_product_service()
{
    $agent = auth()->user();

    $products = ProductRequest::where('agent_id', $agent->id)->get();
    $services = ServiceRequest::where('agent_id', $agent->id)->get();

    $products = $products->map(function($productRequest) {
        $productRequest->data = json_decode($productRequest->data);
        return $productRequest;
    });

    $services = $services->map(function($serviceRequest) {
        $serviceRequest->data = json_decode($serviceRequest->service_data); 
        return $serviceRequest;
    });

    return view('agent.products_service', compact('products', 'services'));
}

public function viewPendingApprovals()
{
    $agent = auth()->user();

    // Fetch pending product requests for the agent
    $pendingProducts = ProductRequest::where('agent_id', $agent->id)
                                    ->where('status', 'pending')
                                    ->get();

    // Decode the JSON data for each pending product request
    $pendingProducts = $pendingProducts->map(function($productRequest) {
        $productRequest->data = json_decode($productRequest->data); // Assuming 'data' stores JSON
        return $productRequest;
    });

    return view('agent.pending-approvals', compact('pendingProducts'));
}



    /**********           ADDING SELLER                   ************/

    public function manage_sellers()
    {
        $sellers = User::where('role', User::ROLE_SELLER)->with('sellerDetail')->get();
        return view('agent.manage_seller', compact('sellers'));
    }

    // View all seller requests
    public function showPendingRequests()
    {
        $agentId = auth()->user()->id;

        // Fetch requests with status 'pending' and belonging to the authenticated agent
        $requests = SellerRequest::where('status', 'pending')
            ->where('agent_id', $agentId)
            ->get();

        return view('admin.users.view_seller_requests', [
            'requests' => $requests,
            'status' => 'pending'
        ]);
    }

    public function showApprovedRequests()
    {
        $agentId = auth()->user()->id;

        // Fetch requests with status 'approved' and belonging to the authenticated agent
        $requests = SellerRequest::where('status', 'approved')
            ->where('agent_id', $agentId)
            ->get();

        return view('admin.users.view_seller_requests', [
            'requests' => $requests,
            'status' => 'approved'
        ]);
    }

    public function showDeclinedRequests()
    {
        $agentId = auth()->user()->id;

        // Fetch requests with status 'declined' and belonging to the authenticated agent
        $requests = SellerRequest::where('status', 'declined')
            ->where('agent_id', $agentId)
            ->get();

        return view('admin.users.view_seller_requests', [
            'requests' => $requests,
            'status' => 'declined'
        ]);
    }

    public function create()
    {
        return view('agent.register_seller');
    }

    // !! REQUESTS TO ADMIN FOR APPROVAL !! //

    public function storeSeller(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->whereNull('deleted_at')],
            'region' => 'required|exists:regions,id',
            'district' => 'required|exists:districts,id',
            'ward' => 'required|exists:wards,id',
            'street' => 'nullable|exists:streets,id',
            'zone' => ['required', 'string'],
            'cropped_image' => ['nullable', 'string'],
            'profile' => 'nullable|image|max:2048',
            'business_type' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'trading_name' => 'required|string|max:255',
            'sector_of_shop' => 'required|string|max:255',
            'lipa_accounts.*.name' => 'nullable|string|max:255',
            'lipa_accounts.*.number' => 'nullable|string|max:15',
            'nida' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:15',
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        // Handle the file upload
        $profilePhotoPath = null;

        // Get the base64 data
        $croppedImage = $validated['cropped_image'];

        if ($croppedImage) {
            // Extract the image data from the base64 string
            $imageData = explode(',', $croppedImage);
            $imageBase64 = $imageData[1];

            // Decode the image data
            $image = base64_decode($imageBase64);

            // Create a unique file name for the image
            $fileName = base64_encode('agent_' . $validated['name'] . time()) . '.png';
            $profilePhotoPath = "user_profile_images/$fileName";

            // Save the image to a file
            Storage::disk('public')->put($profilePhotoPath, $image);
        }

        // Create a new seller request
        $sellerRequest = SellerRequest::create([
            'agent_id' => auth()->id(),
            'data' => json_encode([
                'role' => User::ROLE_SELLER,
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'gender' => $input['gender'],
                'nida' => $input['nida'],
                'profile_photo_path' => $profilePhotoPath,
                'region_id' => $validated['region'],
                'district_id' => $validated['district'],
                'ward_id' => $validated['ward'],
                'street_id' => $validated['street'],
                'zone' => $validated['zone'],
                'business_type' => $validated['business_type'],
                'business_name' => $validated['business_name'],
                'trading_name' => $validated['trading_name'],
                'sector_of_shop' => $validated['sector_of_shop'],
                'whatsapp_number' => $validated['whatsapp_number'],
                'lipa_accounts' => $validated['lipa_accounts'] ?? [],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]),
            'action' => 'add',
            'status' => 'pending',
        ]);

        return redirect()->route('pending_sellers')->with('success', 'Congrats! New registration submitted successfully, awaiting admin approval.');
    }

    public function view_seller_request($id)
    {
        // Find the seller request by ID
        $request = SellerRequest::with('agent', 'seller')->findOrFail($id);

        // Decode the request data from JSON
        $requestData = json_decode($request->data);

        // Pass the request and request data to the view
        return view('admin.review_seller', [
            'request' => $request,
            'requestData' => $requestData,
        ]);
    }

    public function editSeller($id)
    {
        $seller = User::findOrFail($id);
        $lipaAccounts = LipaAccount::where('user_id', $seller->id)->get();
        return view('agent.register_seller', compact('seller', 'lipaAccounts'));
    }

    public function updateSeller(Request $request, $id)
    {
        // Retrieve the existing seller request by ID
        $sellerRequest = SellerRequest::where('seller_id', $id)->firstOrFail();

        // Get all input data
        $input = $request->all();

        // Validate the incoming request data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'email' => Rule::unique('users')->ignore($id)->whereNull('deleted_at'), // Exclude the current email from uniqueness check
            'region' => 'required|exists:regions,id',
            'district' => 'required|exists:districts,id',
            'ward' => 'required|exists:wards,id',
            'street' => 'nullable|exists:streets,id',
            'zone' => ['required', 'string'],
            'cropped_image' => ['nullable', 'string'],
            'profile' => 'nullable|image|max:2048',
            'business_type' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'trading_name' => 'required|string|max:255',
            'sector_of_shop' => 'required|string|max:255',
            'lipa_accounts.*.name' => 'nullable|string|max:255',
            'lipa_accounts.*.number' => 'nullable|string|max:15',
            'nida' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:15',
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        // Handle the file upload
        $profilePhotoPath = $sellerRequest->data['profile_photo_path'] ?? null;

        // Get the base64 data
        $croppedImage = $validated['cropped_image'];

        if ($croppedImage) {
            // Extract the image data from the base64 string
            $imageData = explode(',', $croppedImage);
            $imageBase64 = $imageData[1];

            // Decode the image data
            $image = base64_decode($imageBase64);

            // Create a unique file name for the image
            $fileName = base64_encode('agent_' . $validated['name'] . time()) . '.png';
            $profilePhotoPath = "user_profile_images/$fileName";

            // Save the image to a file
            Storage::disk('public')->put($profilePhotoPath, $image);
        }

        // Update the existing seller request with the new data
        $sellerRequest->update([
            'data' => json_encode([
                'role' => User::ROLE_SELLER,
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'gender' => $input['gender'],
                'nida' => $input['nida'],
                'profile_photo_path' => $profilePhotoPath,
                'region_id' => $validated['region'],
                'district_id' => $validated['district'],
                'ward_id' => $validated['ward'],
                'street_id' => $validated['street'],
                'zone' => $validated['zone'],
                'business_type' => $validated['business_type'],
                'business_name' => $validated['business_name'],
                'trading_name' => $validated['trading_name'],
                'sector_of_shop' => $validated['sector_of_shop'],
                'whatsapp_number' => $validated['whatsapp_number'],
                'lipa_accounts' => $validated['lipa_accounts'] ?? [],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]),
            'action' => 'update',
            'status' => 'pending',
        ]);

        return redirect()->route('pending_sellers')->with('success', 'Update Seller request submitted successfully, awaiting review.');
    }

    public function updateShopCoverImages(Request $request, $id)
    {
        // Retrieve the existing seller request by ID
        $sellerRequest = SellerRequest::where('seller_id', $id)->firstOrFail();

        // Validate the incoming request data for the uploaded images
        $validated = $request->validate([
            'croppedCoverImageOne' => ['nullable', 'string'], // base64 string
            'croppedCoverImageTwo' => ['nullable', 'string'], // base64 string
            'croppedCoverImageThree' => ['nullable', 'string'], // base64 string
        ]);

        // Decode the existing JSON data from the `data` column, or start with an empty array if null
        $existingData = json_decode($sellerRequest->data, true) ?? [];

        // Function to handle the base64 image upload
        $uploadPath = 'shop_cover_images/';

        // Process each image
        foreach (['croppedCoverImageOne', 'croppedCoverImageTwo', 'croppedCoverImageThree'] as $index => $imageField) {
            if (isset($validated[$imageField]) && !empty($validated[$imageField])) {
                // Extract the base64 data
                $imageData = explode(',', $validated[$imageField]);
                if (count($imageData) > 1) {
                    $imageBase64 = $imageData[1];

                    // Decode the image data
                    $image = base64_decode($imageBase64);

                    // Create a unique file name for the image
                    $fileName = ($index + 1) . '_' . time() . '_' . uniqid() . '.jpg'; // +1 for human-friendly index
                    $filePath = "$uploadPath$fileName";

                    // Save the image to a file
                    Storage::disk('public')->put($filePath, $image);

                    // Store the path in the existing data array
                    $existingData[$imageField] = $filePath;
                }
            }
        }

        // Update the seller request with the updated JSON data
        $sellerRequest->update([
            'data' => json_encode($existingData),
            'action' => 'update',
            'status' => 'pending',
        ]);

        return redirect()->route('pending_sellers')->with('success', 'Shop cover images updated successfully, awaiting review.');
    }

    public function deleteSeller($sellerId)
    {
        $seller = User::where('id', $sellerId)->where('role', User::ROLE_SELLER)->firstOrFail();

        // Create a delete seller request
        SellerRequest::create([
            'seller_id' => $seller->id,
            'agent_id' => auth()->id(),
            'data' => json_encode([]),
            'action' => 'delete',
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Seller delete request submitted successfully, wait for review.'
        ]);
    }


    // !! END OF REQUESTS TO ADMIN FOR APPROVAL !! //

    public function deleteSellerRequest($id) // This is for deleting a request that has sent to admin
    {
        $seller = SellerRequest::findOrFail($id);

        $seller->delete();

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Seller Request cancelled successfully!'
        ]);
    }

    public function ProfileDetailsSettings(Request $request)
    {

        $user = $request->user();

        return view('profile.settings.profile-details', [
            'request' => $request,
            'user' => $user,

        ]);
    }

    public function updateAgentDetails(Request $request)
    {

        $updater = new UpdateUserProfileInformation;

        $updater->update(
            auth()->user(),
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'exists:users,name'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user()->id)->whereNull('deleted_at')],
                'phone' => ['nullable', 'string', 'max:15'],
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

    // Open Seller and view products/services


    public function viewApprovedSeller($id)
    {
        $seller = User::findOrFail($id);
        // Get the authenticated agent's ID
        $agentId = Auth::id();
        // Fetch products added by this agent
        $products = Product::where('agent_id', $agentId)->where('seller_id', $seller->id)->get();

        // Fetch services added by this agent
        $services = Service::where('agent_id', $agentId)->where('seller_id', $seller->id)->get();
        return view('agent.view_seller', compact('seller', 'products', 'services'));
    }

    public function productRequestApproval()
    {
        $productRequests = ProductRequest::where('status', 'pending')->get();
        return view('agent.products.approve_product_request', compact('productRequests'));
    }

    public function showRejectedProducts()
    {
        $rejectedRequests = ProductRequest::where('status', 'declined')
            ->where('agent_id', auth()->user()->id)
            ->get();

        $rejectedProducts = $rejectedRequests->map(function ($request) {
            $data = json_decode($request->data, true);
            return [
                'id' => $request->id,
                'seller_id' => $data['seller_id'],
                'agent_id' => $request->agent_id,
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'image' => $data['image'],
                'stock_quantity' => $data['stock_quantity'],
                'unit_id' => $data['unit_id'],
            ];
        });

        return view('agent.rejected_products', compact('rejectedProducts'));
    }


    // public function showRejectedProducts()
    // {
    //     $agentId = auth()->user()->id; // Assuming the agent is logged in

    //     // Fetch rejected products for the specific agent
    //     $rejectedProducts = ProductRequest::where('status', 'declined')->where('agent_id', $agentId)->get();

    //     return view('agent.rejected_products', compact('rejectedProducts'));
    // }
}
