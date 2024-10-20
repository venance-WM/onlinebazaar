@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profile.show', 'orders') }}">Orders</a></li>
                <li class="breadcrumb-item active">Order Details</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Cart Start -->
    <div class="cart-page">
        <div class="container pt-3">
            <h2>Order Details:</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-page-inner">
                        <div class="cart-summary">
                            <div class="cart-content">
                                <h2>Order#{{ $order->id }} <span class="badge badge-secondary">{{ $order->status }}
                                    </span></h2>
                                <p>Order Date:<span>{{ $order->created_at->format('D, d M, Y') }}</span></p>
                                <p>Order Time:<span>{{ $order->created_at->format('h:i A') }}</span></p>
                                <p>Total Amount:<span>Tshs. {{ $order->total_amount }}</span></p>
                                <h2>Order Items:</h2>

                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Seller</th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="align-middle">
                                            @forelse($order->orderItems as $item)
                                                <tr>
                                                    <td>{{ $item->product->seller->name }}</td>
                                                    <td>
                                                        <div class="img">
                                                            <a href="#"><img
                                                                    src="{{ asset('images/products/' . $item->product->image) }}"
                                                                    alt="Image"></a>
                                                            <p>{{ $item->product->name }}</p>
                                                        </div>
                                                    </td>
                                                    <td>Tshs. {{ $item->product->price }}</td>
                                                    <td>
                                                        <p>{{ $item->quantity }}</p>
                                                    </td>
                                                    <td>Tshs. {{ $item->product->price * $item->quantity }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5">Invalid Order.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cart-btn d-flex justify-content-between">
                                    <div class="pt-3">
                                        <a href="{{ route('profile.show', 'orders') }}" class="btn btn-secondary">Back to Orders</a>
                                    </div>
    
                                    @if ($order->status === 'pending')
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

    <!-- Related Products Start -->
    <div class="recent-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Related Products</h1>
            </div>

            <div class="row align-items-center product-slider @if ($relatedProducts->count() >= 4) product-slider-3 @endif">
                @forelse ($relatedProducts as $product)
                    <div class="col-lg-3 col-md-4 col-4 product-item">
                        <div onclick="redirectToProductDetails('{{ route('products.details', $product->id) }}')">
                            <div class="product-title">
                                <a href="{{ route('products.details', $product->id) }}">{{ $product->name }}</a>
                            </div>
                            <div class="product-image align-content-center">
                                <a href="{{ route('products.details', $product->id) }}">
                                    <img src="{{ asset('images/products/' . $product->image) }}" alt="Product Image">
                                </a>
                                <div class="product-action d-none d-md-flex d-lg-flex">
                                    <a href="#"><i class="fa fa-heart"></i></a>
                                    <a href="#"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="product-price">
                                <div class="d-flex justify-content-between px-0">
                                    <h3>TSh.{{ $product->price }}</h3>
                                    <a class="btn d-none d-md-block d-lg-block btn-sm"
                                        href="{{ route('products.details', $product->id) }}"><i
                                            class="fa fa-cart-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <h4>No related products available.</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Related Products End -->
@endsection
