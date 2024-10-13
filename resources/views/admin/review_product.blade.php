{{-- resources/views/admin/review.blade.php --}}

@extends('layouts.admin_app')

@section('content')
    <h1>Review Product Request</h1>

    <div class="card">
        <div class="card-header">
            <h4 class="text-center">{{strtoupper($productData['name'])}}</h4>
        </div>
        <div class="card-body">
            @php
                $seller = \App\Models\User::find($productData['seller_id']);
                $category = \App\Models\Category::find($productData['category_id']);
                $unit = \App\Models\Unit::find($productData['unit_id']);
            @endphp

            <div class="row">
                <div class="col-md-8">
                    <p><strong>Seller Name:</strong> {{ $seller->name ?? 'N/A' }}</p>
                    <p><strong>Category:</strong> {{ $category->name }}</p>
                    <p><strong>Description:</strong> {{ $productData['description'] }}</p>
                    <p><strong>Price:</strong>TZs {{ $productData['price'] }}/=</p>
                    <p><strong>Stock Quantity:</strong> {{ $productData['stock_quantity'] }} {{ $unit->name }}.</p>
                    
                </div>
                <div class="col-md-4 text-end">
                    <p class="text-center"><strong>Image:</strong></p>
                    <img src="{{ asset('storage/'.$productData['image']) }}" alt="{{ $productData['name'] }}" class="img-fluid rounded">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        </div>
    </div>
@endsection
