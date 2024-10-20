{{-- agent/rejected_products.blade.php --}}
@extends('layouts.admin_app')
@section('content')
    <h2>Rejected Products by Admin</h2>
    <div class="row mt-4">
        @foreach ($rejectedProducts as $product)
        <div class="col-md-3 col-6 mb-3">
            <div class="card">
                <img src="{{ asset('images/products/' . $product['image']) }}" class="card-img-top rounded-circle" alt="{{ $product['name'] }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product['name'] }}</h5>
                    <p class="card-text">
                        {{ $product['description'] }} <br>
                        <strong>Price:</strong> TZs {{ $product['price'] }} /=<br>
                        <strong>Stock:</strong> {{ $product['stock_quantity'] }} <br>
                        <a href="#">why rejected</a>
                    </p>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@endsection
