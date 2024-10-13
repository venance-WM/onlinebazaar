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
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'cropped_image' => 'required|string',
            'seller_id' => 'required|exists:users,id' // Capture seller_id
        ]);

        // Handle the file upload
        $imagePath = null;

        // Get the base64 data
        $croppedImage = $request->input('cropped_image');

        if ($croppedImage) {
            // Extract the image data from the base64 string
            $imageData = explode(',', $croppedImage);
            $imageBase64 = $imageData[1];

            // Decode the image data
            $image = base64_decode($imageBase64);

            // Create a unique file name for the image
            $fileName = base64_encode('product_' . rand(1000, 9999) . time()) . '.png';
            $imagePath = "images/$fileName";

            // Save the image to a file
            Storage::disk('public')->put($imagePath, $image);
        }

        // Capture the authenticated agent's ID
        $agentId = Auth::user()->id;
        $sellerId = $request->input('seller_id');


        // Store the product request data in JSON format
        ProductRequest::create([
            'action' => 'add', // Indicating a ADD action
            'data' => json_encode([
                'seller_id' =>  $sellerId,
                'category_id' => $request->category_id,
                'name' => $request->product_name,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $imagePath,
                'stock_quantity' => $request->stock,
                'unit_id' => $request->unit,
            ]),
            'agent_id' => $agentId,
            'status' => 'pending', // Status is pending until approved by admin
        ]);

        return redirect()->route('view_seller', ['id' => $sellerId])->with('success', 'Product request submitted successfully. Awaiting admin approval.');
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'cropped_image' => 'nullable|string',
        ]);

        // Handle the file upload
        $imagePath = null;

        // Get the base64 data
        $croppedImage = $request->input('cropped_image');

        if ($croppedImage) {

            // Delete the old image if it exists
            if (!empty($productData['image'])) {
                Storage::disk('public')->delete($productData['image']);
            }

            // Extract the image data from the base64 string
            $imageData = explode(',', $croppedImage);
            $imageBase64 = $imageData[1];

            // Decode the image data
            $image = base64_decode($imageBase64);

            // Create a unique file name for the image
            $fileName = base64_encode('product_' . rand(1000, 9999) . time()) . '.png';
            $imagePath = "images/$fileName";

            // Save the image to a file
            Storage::disk('public')->put($imagePath, $image);
        } else {
            // Keep the old image if no new one was uploaded
            $imagePath = $productData['image'] ?? null;
        }

        // Update the product data array
        $updatedProductData = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'category_id' => $request->category_id,
            'stock_quantity' => $productData['stock_quantity'],
            'unit_id' => $productData['unit_id'],
            'seller_id' => $productData['seller_id'],
        ];
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
        if (!empty($productData['image'])) {
            Storage::disk('public')->delete($productData['image']);
        }

        $productRequest->delete();
        
        return redirect()->route('agent.products.approved')->with('success', 'Product request deleted successfully.');
    }
}
