@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Order Start -->
    <div class="cart-page">
        <div class="container">
            <h2>My Orders</h2>
            <div class="row">
                @forelse ($orders as $order)
                    <div class="col-lg-6">
                        <div class="cart-page-inner">
                            <div class="cart-summary">
                                <div class="cart-content">
                                    <h1>{{ $order->service_id ? 'Service' : 'Products'}} Order#{{ $order->id }} - <span class="badge badge-secondary">{{ $order->status }}
                                        </span></h1>
                                    <p>Order Date:<span>{{ $order->created_at->format('D, d M, Y') }}</span></p>
                                    <p>Order Time:<span>{{ $order->created_at->format('h:i A') }}</span></p>
                                    @if ($order->service_id)
                                    <p>Contacts:<span>{{ $order->seller ? $order->seller->phone : 'No Service Contacts' }}</span></p> 
                                    @else
                                    <p>Total Amount:<span>Tshs. {{ $order->total_amount }}</span></p>                                        
                                    @endif
                                </div>
                                <div class="cart-btn d-flex justify-content-between">
                                    <div class="pt-3">
                                        <a href="{{ $order->service_id ? route('service-orders.show', $order->service_id) : route('orders.show', $order->id) }}" class="btn btn-primary py-2">View
                                            Details</a>
                                    </div>

                                    @if ($order->status === 'pending')
                                        <form action="{{ $order->service_id ? route('service-orders.destroy', $order->service_id) : route('orders.destroy', $order->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="col-12 text-start py-5">
                    <h4>You have no orders yet.</h4>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Order End -->
@endsection
