<?php

namespace App\Http\Controllers\agent;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\User;
use App\Models\ProductRequest;

class ProductController extends Controller
{

    public function create($user_id)
    {
        $seller = User::find($user_id);
        if (!$seller || $seller->role !== User::ROLE_SELLER) {
            return redirect()->back()->with('error', 'Seller not found.');
        }
        $categories = Category::all();
        $units = Unit::all();
        return view('agent.products.create', compact('categories', 'units', 'seller'));
    }


    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'unit' => 'required|exists:units,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image upload
            'cropped_image' => 'nullable|string',
            'seller_id' => 'required|exists:users,id' // Capture seller_id
        ]);
    
        // Prepare the input data
        $input = $request->all();
    
        // Handle the image upload
        if ($image = $request->file('image')) {
            $destinationPath = 'images/products'; // Destination path for images
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension(); // Create a unique file name
            $image->move($destinationPath, $profileImage); // Move the file to the destination folder
            $input['image'] = "$profileImage"; // Save image name in input array to be stored in the database
        }
    
        // Capture the authenticated agent's ID
        $agentId = Auth::user()->id;
        $sellerId = $request->input('seller_id');
    
        // Store the product request data in JSON format using $input for image data
        ProductRequest::create([
            'action' => 'add', // Indicating an ADD action
            'data' => json_encode([
                'seller_id' => $sellerId,
                'category_id' => $request->category_id,
                'name' => $request->product_name,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $input['image'], // Save the image path in the database
                'stock_quantity' => $request->stock,
                'unit_id' => $request->unit,
            ]),
            'agent_id' => $agentId,
            'status' => 'pending', // Status is pending until approved by admin
        ]);
    
        // Redirect with success message
        return redirect()->route('view_seller', ['id' => $sellerId])
                         ->with('success', 'Product request submitted successfully. Awaiting admin approval.');
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




    public function show()
    {
        $agentId = auth()->user()->id;

        // Retrieve products that belong to the authenticated agent and have 'approved' status
        $products = ProductRequest::with('category')
            ->where('agent_id', $agentId)
            ->where('status', 'approved') // Filter by 'approved' status
            ->paginate(4);

        return view('agent.products.index', compact('products'));
    }


    public function edit($id)
    {
        $productRequest = ProductRequest::findOrFail($id);
        $productData = json_decode($productRequest->data, true);
        $categories = Category::all();
        return view('agent.products.edit', compact('productData', 'productRequest', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $productRequest = ProductRequest::findOrFail($id);
        $productData = json_decode($productRequest->data, true);
    
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cropped_image' => 'nullable|string',
        ]);
    
        // Handle the file upload (traditional method)
        $imagePath = $productData['image'] ?? null;
    
        // Check if a new image is uploaded via cropping (base64)
        if ($request->has('cropped_image')) {
            // Delete the old image if it exists
            if (!empty($productData['image']) && file_exists(public_path("images/products/{$productData['image']}"))) {
                unlink(public_path("images/products/{$productData['image']}"));
            }
    
            // Extract the image data from the base64 string
            $imageData = explode(',', $request->input('cropped_image'));
    
            // Check if the image data has the expected number of elements
            if (count($imageData) > 1) {
                $imageBase64 = $imageData[1];
    
                // Decode the base64 image
                $image = base64_decode($imageBase64);
    
                // Create a unique file name for the image
                $fileName = 'product_' . rand(1000, 9999) . time() . '.png';
    
                // Set the image path where the image will be stored
                $imagePath = "products/$fileName";
    
                // Save the image to the traditional file system
                file_put_contents(public_path("images/$imagePath"), $image);
            } else {
                // Handle the error: the base64 string is not in the expected format
                return redirect()->back()->withErrors(['cropped_image' => 'Invalid image data format.']);
            }
        }
        // Check if a new image is uploaded via a file upload
        elseif ($request->hasFile('image')) {
            // Delete the old image if it exists
            if (!empty($productData['image']) && file_exists(public_path("images/products/{$productData['image']}"))) {
                unlink(public_path("images/products/{$productData['image']}"));
            }
    
            // Get the uploaded image file
            $image = $request->file('image');
    
            // Create a unique file name for the image
            $fileName = 'product_' . rand(1000, 9999) . time() . '.' . $image->getClientOriginalExtension();
    
            // Set the image path where the image will be stored
            $imagePath = "products/$fileName";
    
            // Move the uploaded image to the "images/products" directory
            $image->move(public_path('images/products'), $fileName);
        }
    
        // If no new image is provided, retain the old image path
        $imagePath = $imagePath ?? $productData['image'];
    
        // Update the product data array with new values
        $updatedProductData = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath, // Store only the file name in the database
            'category_id' => $request->category_id,
            'stock_quantity' => $productData['stock_quantity'],
            'unit_id' => $productData['unit_id'],
            'seller_id' => $productData['seller_id'],
        ];
    
        // Update the product request with new data and status
        $productRequest->update([
            'data' => json_encode($updatedProductData),
            'status' => 'pending',
        ]);
    
        return redirect()->route('agent.products.approved')->with('success', 'Product updated successfully. Awaiting admin approval.');
    }
    

    public function destroy($id)
    {
        $productRequest = ProductRequest::findOrFail($id);
        $productData = json_decode($productRequest->data, true);
    
        // Check if an image exists and delete it using the traditional method
        if (!empty($productData['image']) && file_exists(public_path("images/products/{$productData['image']}"))) {
            unlink(public_path("images/products/{$productData['image']}"));
        }
    
      
        $productRequest->delete();
    
        return redirect()->route('agent.products.approved')->with('success', 'Product request deleted successfully.');
    }
    
}
