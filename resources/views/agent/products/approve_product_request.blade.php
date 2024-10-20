{{-- resources/views/admin/approve.blade.php --}}

@extends('layouts.admin_app')

@section('content')
    <h1>{{ auth()->user()->role == 0 ? 'Products Pending ADMIN Approval' : 'Your Submitted Product Requests' }}</h1>

    @if($productRequests->isEmpty())
        <p>No {{ auth()->user()->role == 0 ? 'pending' : 'submitted' }} product requests.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Seller</th>
                    <th>Category</th>
                    <th> Image </th>
                    <th>price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productRequests as $request)
                    @php
                        $productData = json_decode($request->data, true);
                        $seller = \App\Models\User::find($productData['seller_id']);
                        $category = \App\Models\Category::find($productData['category_id']);
                    @endphp
                    <tr>
                        <td>{{ $productData['name'] }}</td>
                        <td>{{ $seller->name }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if ($productData['image'])
                                <img src="{{ asset('images/products/' . $productData['image']) }}" alt="{{ $productData['name'] }}" width="50">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>TZs{{ $productData['price'] }}/=</td>
                        <td>
                            @if(auth()->user()->role == 0) {{-- Admin --}}
                                <a href="{{ route('admin.products.approval.review', $request->id) }}" class="btn btn-info">Review</a>
                                <form action="{{ route('admin.products.approval.approve', $request->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                                <form action="{{ route('admin.products.approval.reject', $request->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            @else {{-- Agent --}}
                                <!-- Edit Button -->
                                    <a href="#" class="btn btn-warning">Edit</a>          
                                <!-- Cancel Button -->
                                    <a href="#" class="btn btn-danger">Cancel Request</a>  
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
