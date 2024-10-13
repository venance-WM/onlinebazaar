@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Search Results</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product List Start -->
    <div class="product-view">
        <div class="container-fluid">
            <div class="row px-2">
                <div class="col-md-12">
                    <div class="product-view-top">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-2 col-6">
                                <div class="product-short">
                                    <div class="dropdown">
                                        <div class="dropdown-toggle" data-toggle="dropdown">Short by</div>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item">Newest</a>
                                            <a href="#" class="dropdown-item">Popular</a>
                                            <a href="#" class="dropdown-item">Most sale</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="product-price-range">
                                    <div class="dropdown">
                                        <div class="dropdown-toggle" data-toggle="dropdown">Filter by Price
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item">Low to High</a>
                                            <a href="#" class="dropdown-item">High to Low</a>
                                            <a href="#" class="dropdown-item">Random</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (isset($searchQuery))
                    <div class="col-md-12">
                        <h2>Search Results for "{{ $searchQuery }}"</h2>
                    </div>
                @endif

                <!-- Display Products -->
                @forelse ($products as $product)
                    <div class="col-lg-2 col-md-4 col-4 product-item">
                        <div onclick="redirectToProductDetails('{{ route('products.details', $product->id) }}')">
                            <div class="product-title">
                                <a href="{{ route('products.details', $product->id) }}">{{ $product->name }}</a>
                            </div>
                            <div class="product-image align-content-center">
                                <a href="{{ route('products.details', $product->id) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
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
                @endforelse

                <!-- Display Services -->
                @forelse ($services as $service)
                    <div class="col-lg-2 col-md-4 col-4 product-item">
                        <div onclick="redirectToProductDetails('{{ route('services.show', $service->id) }}')">
                            <div class="product-title">
                                {{-- <a href="{{ route('services.show', $service->id) }}">{{ $service->name }}</a> --}}
                            </div>
                            <div class="product-image align-content-center">
                                <a href="{{ route('services.show', $service->id) }}">
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="Product Image">
                                </a>
                                <div class="product-action d-none d-md-flex d-lg-flex">
                                    <a href="#"><i class="fa fa-heart"></i></a>
                                    <a href="#"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="product-price">
                                <div class="d-flex justify-content-md-between px-0">
                                    <h3>{{ $service->title }}</h3>
                                    <a class="btn d-none d-md-block d-lg-block btn-sm"
                                        href="{{ route('services.show', $service->id) }}"><i
                                            class="fa fa-cart-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

                @if ($services->isEmpty() && $products->isEmpty())
                    <div class="col-12 text-start">
                        <h4>No product or service found.</h4>
                    </div>
                @endempty


                <!-- Pagination for Products and Services -->
                @if ($products->total() > 9 || $services->total() > 9)
                    <div class="col-md-12 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                @endif
                <!-- Pagination End -->
        </div>
    </div>
</div>
<!-- Product List End -->
@endsection
