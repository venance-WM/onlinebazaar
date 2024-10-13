@extends('layouts.admin_app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    {{ auth()->user()->role == 0 ? 'Approved Products' : 'Your Approved Products' }}
                </h4>
                <p class="card-description">
                    {{ auth()->user()->role == 0 ? 'Below is a list of all approved products.' : 'Below is a list of approved products you submitted.' }}
                </p>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Seller</th>
                                @if(auth()->user()->role == 0) <!-- Admin -->
                                    <th>Agent</th>
                                @endif
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                @php
                                    // Decode the JSON data and access it as an array
                                    $productData = json_decode($product->data, true);
                                    $seller = \App\Models\User::find($productData['seller_id']);
                                    $agent = \App\Models\User::find($productData['agent_id']);
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $productData['name'] }}</td>
                                    <td>{{ $seller ? $seller->name : 'N/A' }}</td>
                                    @if(auth()->user()->role == 0) <!-- Admin -->
                                        <td>{{ $agent ? $agent->name : 'N/A' }}</td>
                                    @endif
                                    <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d M, Y') }}</td>
                                    <td>
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                                        @if(auth()->user()->role == 0 || auth()->user()->id == $product->agent_id)
                                            <!-- Admin or the agent who added the product can edit or delete -->
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role == 0 ? '6' : '5' }}" class="text-center">No approved products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
