<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\AgentDetail;
use App\Models\User;
use App\Models\SellerDetail;
use App\Models\LipaAccount;
use App\Models\SellerRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductRequest;
use App\Models\Product;
use App\Models\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isEmpty;

class AdminController extends Controller
{
  public function index()
  {
    $userCount = User::whereIn('role', [1, 2, 3])->count();
    return view('admin.home', compact('userCount'));
  }

  // ! ******************* FUNCTIONS OF ADMIN ON AGENTS ***********************

  public function manage_agents()
  {
    $agents = User::where('role', User::ROLE_AGENT)->get();
    return view('admin.users.view_agents', compact('agents'));
  }

  public function show_register_agent()
  {
    return view('admin.users.register_agent');
  }

  public function show_agent_form($id = null)
  {
    $agent = null;
    $agentDetails = null;

    if ($id) {
      $agent = User::findOrFail($id);
      $agentDetails = AgentDetail::where('user_id', $id)->first();
    }

    return view('admin.users.register_agent', compact('agent', 'agentDetails'));
  }

  public function register_agent(Request $request, User $user)
  {
    $input = $request->all();

    Validator::make($input, [
      'name' => ['required', 'string', 'max:255'],
      'phone' => ['required', 'string', 'max:15'],
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->whereNull('deleted_at')],
      'region' => ['required', 'integer'],
      'district' => ['required', 'integer'],
      'ward' => ['required', 'integer'],
      'place' => ['nullable', 'string', 'max:255'],
      'profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Validate the profile photo
    ])->validate();

    // Handle the file upload
    $profilePhotoPath = null;

    // Get the base64 data
    $croppedImage = $request->input('cropped_image');

    if ($croppedImage) {
      // Extract the image data from the base64 string
      $imageData = explode(',', $croppedImage);
      $imageBase64 = $imageData[1];

      // Decode the image data
      $image = base64_decode($imageBase64);

      // Create a unique file name for the image
      $fileName = base64_encode('agent_' . $input['name'] . time()) . '.png';
      $profilePhotoPath = "user_profile_images/$fileName";

      // Save the image to a file
      Storage::disk('public')->put($profilePhotoPath, $image);
    }

    // Register agent into users
    $agent = User::create([
      'role' => 1, // Default role for Agent
      'name' => $input['name'],
      'phone' => $input['phone'],
      'email' => $input['email'],
      'password' => Hash::make(123456), // Default password of newly registered agent is 123456
      'profile_photo_path' => $profilePhotoPath, // Save the profile photo path
    ]);
    // Save the agent details
    $agent_details = new AgentDetail([
      'user_id' => $agent->id,
      'region_id' => $input['region'],
      'district_id' => $input['district'],
      'ward_id' => $input['ward'],
      'street_id' => $input['street'],
      'place' => $input['place'],
    ]);
    $agent_details->save();

    return redirect()->route('admin.agents.manage')->with('success', 'Agent Registered successfully!');
  }

  public function show_edit_agent($id)
  {
    $agent = User::findOrFail($id);
    $agentDetails = AgentDetail::findOrFail($agent->id);
    return view('admin.users.register_agent', compact('agent', 'ageentDetails'));
  }

  public function update_agent(Request $request, $id)
  {
    // Find the agent and agent details
    $agent = User::findOrFail($id);
    $agentDetails = AgentDetail::where('user_id', $id)->firstOrFail();

    // Validate the request data
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => "required|email|max:255|unique:users,email,$id",
      'phone' => 'nullable|string|max:15',
      'profile' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
      'region' => 'required|integer|exists:regions,id',
      'district' => 'required|integer|exists:districts,id',
      'ward' => 'required|integer|exists:wards,id',
      'street' => 'required|integer|exists:streets,id',
      'place' => 'nullable|string|max:255',
    ]);

    // Update agent data
    $agent->name = $request->input('name');
    $agent->email = $request->input('email');
    $agent->phone = $request->input('phone');

    // Get the base64 data
    $croppedImage = $request->input('cropped_image');

    if ($croppedImage) {
      // Extract the image data from the base64 string
      $imageData = explode(',', $croppedImage);
      $imageBase64 = $imageData[1];

      // Decode the image data
      $image = base64_decode($imageBase64);

      // Create a unique file name for the image
      $fileName = base64_encode('agent_' . $agent->name . time()) . '.png';
      $filePath = "user_profile_images/$fileName";

      // Save the image to a file
      Storage::disk('public')->put($filePath, $image);

      // Delete the old profile photo if it exists
      if ($agent->profile_photo_path) {
        Storage::disk('public')->delete($agent->profile_photo_path);
      }

      // Save the new file path to the database
      $agent->forceFill([
        'profile_photo_path' => $filePath,
      ])->save();
    }

    // Update agent details
    $agentDetails->region_id = $request->input('region');
    $agentDetails->district_id = $request->input('district');
    $agentDetails->ward_id = $request->input('ward');
    $agentDetails->street_id = $request->input('street');
    $agentDetails->place = $request->input('place');

    // Save the changes
    $agent->save();
    $agentDetails->save();

    // Redirect with a success message
    return redirect()->route('admin.agents.manage')->with('success', 'Agent updated successfully!');
  }


  public function update_agent_status($id)
  {
    $agent = User::findOrFail($id);

    // Toggle the agent status
    $agent->status = $agent->status === 'enabled' ? 'disabled' : 'enabled';

    $agent->save();

    // Return a JSON response
    return response()->json([
      'success' => true,
      'message' => 'Agent status updated successfully!',
      'new_status' => $agent->status
    ]);
  }

  public function delete_agent($id)
  {
    $agent = User::findOrFail($id);

    // Perform soft delete
    $agent->delete();

    // Return a JSON response
    return response()->json([
      'success' => true,
      'message' => 'Agent deleted successfully!'
    ]);
  }

  // ! ******************* FUNCTIONS OF ADMIN ON SELLERS ***********************

  public function update_seller_status($id)
  {
    $seller = User::findOrFail($id);

    // Toggle the seller status
    $seller->status = $seller->status === 'enabled' ? 'disabled' : 'enabled';

    $seller->save();

    // Return a JSON response
    return response()->json([
      'success' => true,
      'message' => 'Seller status updated successfully!',
      'new_status' => $seller->status
    ]);
  }

  public function delete_seller($id)
  {
    $seller = User::findOrFail($id);
    $seller->SellerDetail()->delete();

    $seller->delete();

    // Return a JSON response
    return response()->json([
      'success' => true,
      'message' => 'Seller deleted successfully!'
    ]);
  }

  public function sellers_list()
  {
    $sellers = User::where('role', User::ROLE_SELLER)->get();
    return view('admin.users.view_sellers', compact('sellers'));
  }

  public function customers_list()
  {
    $customers = User::where('role', User::ROLE_CUSTOMER)->get();
    return view('admin.users.view_customers', compact('customers'));
  }

  // ! ******************* END OF FUNCTIONS OF ADMIN ON SELLERS ***********************

  /**
   * Show the Seller profile setting screen.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\View\View
   */

  public function ProfileDetailsSettings(Request $request)
  {

    $user = $request->user();

    return view('profile.settings.profile-details', [
      'request' => $request,
      'user' => $user,

    ]);
  }

  public function updateAdminDetails(Request $request)
  {
    $updater = new UpdateUserProfileInformation;

    $updater->update(
      auth()->user(),
      $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', Rule::unique('users')->whereNull('deleted_at')->ignore(auth()->user()->id)],
        'phone' => ['nullable', 'string', 'max:15'],
        'profile' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
        'cropped_image' => ['nullable', 'string'],
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


  public function approved_sellers()
  {
    $sellers = User::where('role', User::ROLE_SELLER)->with('sellerDetail')->get();
    return view('admin.manage_sellers', compact('sellers'));
  }

  // !! APPROVE OR DECLINE REQUESTS !! //

  // View all seller requests
  public function showPendingRequests()
  {
    $requests = SellerRequest::where('status', 'pending')->get();

    return view('admin.users.view_seller_requests', [
      'requests' => $requests,
      'status' => 'pending'
    ]);
  }


  public function showApprovedRequests()
  {
    $requests = SellerRequest::where('status', 'approved')->get();
    return view('admin.users.view_seller_requests', ['requests' => $requests, 'status' => 'approved']);
  }

  public function showDeclinedRequests()
  {
    $requests = SellerRequest::where('status', 'declined')->get();
    return view('admin.users.view_seller_requests', ['requests' => $requests, 'status' => 'declined']);
  }

  public function showSellerDetails($id)
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

  // Approve or decline seller request
  public function handleSellerRequest(Request $request, SellerRequest $sellerRequest)
  {
    $action = $request->input('action'); // 'approve' or 'decline'

    if ($action == 'approve') {
      $this->approveSellerRequest($sellerRequest);
      return redirect()->back()->with('success', 'Seller request approved successfully.');
    } elseif ($action == 'decline') {
      $sellerRequest->update([
        'status' => 'declined',
        'admin_id' => auth()->id()
      ]);
      return redirect()->back()->with('info', 'Seller request declined.');
    }
  }

  // Method to approve seller request (already discussed)
  private function approveSellerRequest(SellerRequest $request)
  {
    $sellerData = json_decode($request->data, true);

    switch ($request->action) {
      case 'update':
        $seller = User::where('email', $sellerData['email'])->first();

        // Update existing seller
        $seller->update([
          'role' => User::ROLE_SELLER,
          'status' => 'enabled',
          'name' => $sellerData['name'],
          'phone' => $sellerData['phone'],
          'gender' => $sellerData['gender'],
          'nida' => $sellerData['nida'],
          'profile_photo_path' => $sellerData['profile_photo_path'],
        ]);

        // Update or create SellerDetail
        SellerDetail::updateOrCreate(
          ['user_id' => $seller->id],
          [
            'region_id' => $sellerData['region_id'],
            'district_id' => $sellerData['district_id'],
            'ward_id' => $sellerData['ward_id'],
            'street_id' => $sellerData['street_id'],
            'zone' => $sellerData['zone'],
            'business_type' => $sellerData['business_type'],
            'business_name' => $sellerData['business_name'],
            'trading_name' => $sellerData['trading_name'],
            'sector_of_shop' => $sellerData['sector_of_shop'],
            'whatsapp_number' => $sellerData['whatsapp_number'],
            'latitude' => $sellerData['latitude'],
            'longitude' => $sellerData['longitude'],
            'shop_image_one' => $sellerData['croppedCoverImageOne'],
            'shop_image_two' => $sellerData['croppedCoverImageTwo'],
            'shop_image_three' => $sellerData['croppedCoverImageThree'],
          ]
        );
        break;
      case 'add':
        $seller = User::create([
          'role' => User::ROLE_SELLER,
          'status' => 'enabled',
          'name' => $sellerData['name'],
          'phone' => $sellerData['phone'],
          'email' => $sellerData['email'],
          'gender' => $sellerData['gender'],
          'nida' => $sellerData['nida'],
          'password' => Hash::make(123456),
          'profile_photo_path' => $sellerData['profile_photo_path'],
        ]);

        SellerDetail::create([
          'user_id' => $seller->id,
          'region_id' => $sellerData['region_id'],
          'district_id' => $sellerData['district_id'],
          'ward_id' => $sellerData['ward_id'],
          'street_id' => $sellerData['street_id'],
          'zone' => $sellerData['zone'],
          'business_type' => $sellerData['business_type'],
          'business_name' => $sellerData['business_name'],
          'trading_name' => $sellerData['trading_name'],
          'sector_of_shop' => $sellerData['sector_of_shop'],
          'whatsapp_number' => $sellerData['whatsapp_number'],
          'latitude' => $sellerData['latitude'],
          'longitude' => $sellerData['longitude'],
          'shop_image_one' => $sellerData['croppedCoverImageOne'] ?? null,
          'shop_image_two' => $sellerData['croppedCoverImageTwo'] ?? null,
          'shop_image_three' => $sellerData['croppedCoverImageThree'] ?? null,
        ]);
        break;
      case 'delete':
        $seller = User::findOrFail($request->seller_id);
        $seller->SellerDetail()->delete();
        $seller->requests()->delete();

        $seller->delete();

        break;
    }

    // Handle Lipa Accounts
    $lipaAccounts = $sellerData['lipa_accounts'] ?? [];
    foreach ($lipaAccounts as $network => $account) {
      if (!empty($account['name']) && !empty($account['number'])) {
        LipaAccount::updateOrCreate(
          [
            'user_id' => $seller->id,
            'network' => $network,
          ],
          [
            'name' => $account['name'],
            'number' => $account['number'],
          ]
        );
      }
    }

    // Update the seller request status to approved
    $request->update([
      'status' => 'approved',
      'admin_id' => auth()->id(),
      'seller_id' => $seller->id,
    ]);
  }

  // !! APPROVE OR DECLINE REQUESTS OF PRODUCTS AND SERVICES !! //--------------------------------------------------------------------


  public function productRequestApproval()
  {
    $productRequests = ProductRequest::where('status', 'pending')->get();
    return view('agent.products.approve_product_request', compact('productRequests'));
  }
  public function reviewProduct($id)
  {
    $request = ProductRequest::findOrFail($id);
    $productData = json_decode($request->data, true);
    return view('admin.review_product', compact('request', 'productData'));
  }

  public function approve($id)
  {
    $productRequest = ProductRequest::findOrFail($id);

    // Decode the stored JSON data
    $productData = json_decode($productRequest->data, true);

    // Move data to the products table
    Product::create([
      'seller_id' => $productData['seller_id'],
      'agent_id' => $productRequest->agent_id, // Get agent_id directly from the model
      'category_id' => $productData['category_id'],
      'name' => $productData['name'],
      'description' => $productData['description'],
      'price' => $productData['price'],
      'image' => $productData['image'],
      'stock_quantity' => $productData['stock_quantity'],
      'unit_id' => $productData['unit_id'],
    ]);

    // Update the status of the product request
    $productRequest->update([
      'status' => 'approved',
      'admin_id' => auth()->user()->id,
    ]);

    return redirect()->route('admin.products.approval')->with('success', 'Product approved successfully.');
  }

  public function reject($id)
  {
    $productRequest = ProductRequest::findOrFail($id);

    // Optionally, delete the image if it was uploaded
    $productData = json_decode($productRequest->data, true);
    if (isset($productData['image']) && Storage::disk('public')->exists($productData['image'])) {
      Storage::disk('public')->delete($productData['image']);
    }

    // Delete the product request
    $productRequest->delete();

    return redirect()->route('admin.products.approval')->with('success', 'Product rejected and deleted.');
  }

  public function showRejectedProducts()
  {
    $rejectedRequests = ProductRequest::where('status', 'declined')->get();

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

    return view('admin.rejected_products', compact('rejectedProducts'));
  }
  public function viewApprovedProducts()
  {
    $user = auth()->user();

    // Admin: Fetch all approved products
    if ($user->role == 0) {
      $productRequests = ProductRequest::where('status', 'approved')->paginate(10); // Admin sees all products
    }
    // Agent: Fetch only their own approved products
    else {
      $productRequests = ProductRequest::where('status', 'approved')
        ->where('agent_id', $user->id)
        ->paginate(10); // Agent sees only their own products
    }

    // Decode the JSON data for each product
    $products = $productRequests->map(function ($request) {
      $productData = json_decode($request->data, true);
      return [
        'name' => $productData['name'],
        'description' => $productData['description'] ?? 'No description',
        'image' => $productData['image'] ?? null,
        'category_id' => $productData['category_id'],
        'price' => $productData['price'],
        'agent_id' => $request->agent_id,
        'created_at' => $request->created_at,
        'id' => $request->id,
      ];
    });

    return view('agent.products.index', compact('products', 'productRequests'));
  }


  // public function showRejectedProducts()
  // {
  //     // Fetch all rejected products
  //     $rejectedProducts = ProductRequest::where('status', 'declined')->get();

  //     return view('admin.rejected_products', compact('rejectedProducts'));
  // }

  //-----------------------ADMIN SERVICE APROVAL-----------------
  public function viewPendingService()
  {
    // Get all pending service requests
    $serviceRequests = ServiceRequest::where('status', 'pending')->get();

    return view('agent.services.service_requests', compact('serviceRequests'));
  }
  public function approveService($id)
  {
    // Find the service request by ID
    $serviceRequest = ServiceRequest::find($id);

    // Handle case where service request is not found
    if (!$serviceRequest) {
      return redirect()->back()->with('error', 'Service request not found.');
    }

    // Decode service_data if it's not already an array
    $serviceData = is_array($serviceRequest->service_data)
      ? $serviceRequest->service_data
      : json_decode($serviceRequest->service_data, true);

    // Ensure serviceData is an array before accessing its elements
    if (!is_array($serviceData)) {
      return redirect()->back()->with('error', 'Invalid service data.');
    }

    // Handle 'add' action: Create a new service
    if ($serviceRequest->action === 'add') {
      $service = Service::create([
        'agent_id' => $serviceRequest->agent_id,
        'seller_id' => $serviceData['seller_id'], // Ensure seller_id is included
        'name' => $serviceData['name'],
        'description' => $serviceData['description'],
        'price' => $serviceData['price'],
        'image' => $serviceData['image'] ?? null, // Optional image
      ]);

      // Update the service request with the newly created service ID
      $serviceRequest->update([
        'service_id' => $service->id, // Store the service ID in the service request
        'status' => 'approved',
        'admin_id' => auth()->user()->id,
      ]);
    } else {
      $serviceRequest->delete();
    }

    return redirect()->back()->with('success', 'Service approved successfully.');
  }

  public function rejectService($id)
  {
    $serviceRequest = ServiceRequest::find($id);
    $serviceRequest->update([
      'status' => 'declined',
      'admin_id' => auth()->user()->id,
    ]);

    return redirect()->back()->with('success', 'Service rejected successfully.');
  }

  public function reviewServiceRequest($id)
  {
    $serviceRequest = ServiceRequest::findOrFail($id);

    // Assuming 'service_data' is a JSON column
    $serviceData = json_decode($serviceRequest->service_data, true);

    return view('admin.review_service', compact('serviceRequest', 'serviceData'));
  }
  public function viewApprovedServices()
  {
    // Fetch all service requests with status 'approved'
    $approvedServices = ServiceRequest::where('status', 'approved')->get();

    return view('admin.approved_services', compact('approvedServices'));
  }
  public function viewDeclinedServices()
  {
    // Fetch all service requests with status 'declined'
    $declinedServices = ServiceRequest::where('status', 'declined')->get();

    return view('admin.declined_services', compact('declinedServices'));
  }
}
