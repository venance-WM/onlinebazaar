@extends('layouts.admin_app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(auth()->user()->role == 0)
                    <!-- Admin: View all approved products -->
                    <h1>All Approved Products</h1>
                @else                  
                    <!-- Agent: Allow adding, editing, and deleting products -->
                    <h1>Your Approved Products</h1>
                @endif

                @if ($products->isEmpty())
                    <p>No approved products found.</p>
                @else
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Category</th>
                                @if(auth()->user()->role == 0) <!-- Admin -->
                                    <th>Agent</th>
                                    <th>Action</th>
                                @endif
                                @if(auth()->user()->role != 0) <!-- Agents can edit and delete -->
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product['name'] ?? 'N/A' }}</td>
                                    <td>{{ $product['description'] ?? 'No description' }}</td>
                                    <td>TZs {{ $product['price'] }} /=</td>
                                    <td>
                                        @if (!empty($product['image']))
                                            <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" width="50">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        {{ \App\Models\Category::find($product['category_id'])->name ?? 'Unknown Category' }}
                                    </td>
                                    @if(auth()->user()->role == 0) <!-- Admin -->
                                        <td>
                                            {{ \App\Models\User::find($product['agent_id'])->name ?? 'Unknown/Deleted Agent' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.products.approval.review', ['id' => $product['id']]) }}" class="btn btn-info btn-sm">View More</a>
                                        </td>
                                    @endif
                                    @if(auth()->user()->role != 0) <!-- Agents -->
                                        <td>
                                            <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('products.destroy', $product['id']) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')                                            
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                  
                <!-- Pagination Links -->
                <div class="d-flex justify-content-center mt-3">
                    @if(auth()->user()->role == 0)
                        {{ $productRequests->links() }}
                    @else
                        <!-- Agents don't have pagination links as they are mapped collection -->
                        {{ $products->links() }}
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>

@endsection
