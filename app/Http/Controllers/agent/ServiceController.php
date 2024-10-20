<?php

namespace App\Http\Controllers\agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\User;
use App\Models\ServiceOrder;
use Illuminate\Support\Facades\Log;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class ServiceController extends Controller
{
    public function index()
{
    $sellerId = auth()->user()->id;
    $services = Service::where('seller_id', $sellerId)->get();
    return view('agent.services.index', compact('services'));
}

public function create($user_id)
{
    $seller = User::find($user_id);
    if (!$seller || $seller->role !== User::ROLE_SELLER) {
        return redirect()->back()->with('error', 'Seller not found.');
    }
    return view('agent.services.create', compact('seller'));
}


public function store(Request $request)
{
    // Validate the form data
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'nullable|numeric',
        'seller_id' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image upload
        'cropped_image' => 'nullable|string',
    ]);

    // Prepare the input data
    $input = $request->all();

    // Handle the image upload
    if ($image = $request->file('image')) {
        $destinationPath = 'images/services'; // Destination path for images
        $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension(); // Create a unique file name
        $image->move($destinationPath, $profileImage); // Move the file to the destination folder
        $input['image'] = "$profileImage"; // Save image name in input array to be stored in the database
    }

    // Prepare the service data with the image path
    $serviceData = [
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'seller_id' => $request->seller_id,
        'image' => $input['image'], // Save the image path in the database
    ];

    Log::info('Service Data:', $serviceData);

    // Log the entire request data
    Log::info('Request Data:', $request->all());

    // Store the service request
    $serviceRequest = ServiceRequest::create([
        'action' => 'add',
        'agent_id' => auth()->user()->id,
        'service_id' => null, // The service ID is created after admin approval
        'status' => 'pending',
        'service_data' => json_encode($serviceData),
    ]);

    Log::info('Service Request Created:', $serviceRequest->toArray());

    // Redirect with success message
    return redirect()->route('services.index')->with('success', 'Service request submitted successfully.');
}

    
    
    public function viewApprovedServices() {
        $userId = auth()->id();
        $approvedServices = ServiceRequest::where('status', 'approved')
                                         ->where('agent_id', $userId)
                                         ->get();
        return view('admin.approved_services', compact('approvedServices'));
      }

      public function viewDeclinedServices() {
        $userId = auth()->id();
        // Fetch all service requests with status 'declined'
        $declinedServices = ServiceRequest::where('status', 'declined')->where('agent_id', $userId)->get();
      
        return view('admin.declined_services', compact('declinedServices'));
      }
    // public function edit(Service $service)
    // {
    //     return view('agent.services.edit', compact('service'));
    // }

    // public function update(Request $request, Service $service)
    // {
    //     $request->validate([  
    //         'name' => 'required',
    //         'image' => 'nullable|image|max:2048',
    //         'description' => 'required',
    //         'price' => 'nullable|numeric',
    //     ]);
        
    //     $data = $request->all();
    //     $data['seller_id'] = auth()->user()->id;
         
    //     if ($request->hasFile('image')) {
    //         // Delete the old image if it exists
    //         if ($service->image && Storage::exists('public/' . $service->image)) {
    //             Storage::delete('public/' . $service->image);
    //         }

    //         $imagePath = $request->file('image')->store('services_images', 'public');
    //         $data['image'] = $imagePath;
    //     }
        
    //     $service->update($data);

    //     return redirect()->route('services.index')
    //                      ->with('success', 'Service updated successfully.');
    // }

    // public function destroy(Service $service)
    // {
    //     $service->delete();

    //     return redirect()->route('services.index')
    //                      ->with('success', 'Service deleted successfully.');
    // } 
    
    public function serviceOrdes()
    {
        $serviceOrders = ServiceOrder::with('service', 'user')
            ->whereHas('service', function($query) {
                $query->where('seller_id', Auth::id());
            })
            ->get();

        return view('seller.orders.orders', compact('serviceOrders'));
    }
    public function viewPendingService()
    {
        // Get the authenticated user's ID
        $userId = auth()->id();
        
        // Get all pending service requests for the authenticated agent
        $serviceRequests = ServiceRequest::where('status', 'pending')
                                         ->where('agent_id', $userId)
                                         ->get();
      
        return view('agent.services.service_requests', compact('serviceRequests'));
    }
    
}