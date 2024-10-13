@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                <li class="breadcrumb-item active">Order Details</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- services-order Start -->
    <div class="container">
        <h2>Order Details:</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Order#{{ $serviceOrder->id }} - {{ $serviceOrder->service->title }}</h1>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            <strong>Order Date:</strong> {{ $serviceOrder->created_at->format('D, d M, Y') }}<br>
                            <strong>Order Time:</strong> {{ $serviceOrder->created_at->format('h:i A') }}<br>
                            <strong>Price:</strong> Tshs. {{ $serviceOrder->service->price }}<br>
                        </p>
                        <blockquote class="blockquote">
                            {{ $serviceOrder->service->description }}
                        </blockquote>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('profile.show', 'orders') }}" class="btn btn-secondary">Back to Orders</a>
                        <form action="{{ route('service-orders.destroy', $serviceOrder->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- service-orders End -->

    <!-- Related Services Start -->
    <div class="recent-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Related Services</h1>
            </div>
            <div class="row align-items-center product-slider product-slider-4">
                <!-- Related Services content -->
            </div>
        </div>
    </div>
    <!-- Related Services End -->
@endsection
