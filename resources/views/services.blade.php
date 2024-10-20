@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Services</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Services List Start -->
    <div class="product-view">
        <div class="container-fluid">
            <div class="row px-2">
                
                @foreach ($services as $service)
                    <div class="col-lg-2 col-md-4 col-4 product-item">
                        <div onclick="redirectToProductDetails('{{ route('services.show', $service->id) }}')">
                            <div class="product-title">
                                <a href="{{ route('services.show', $service->id) }}">{{ $service->title }}</a>
                            </div>
                            <div class="product-image align-content-center">
                                <a href="{{ route('services.show', $service->id) }}">
                                    <img src="{{ asset('images/services/' . $service->image) }}" alt="Product Image">
                                </a>
                                {{-- <div class="product-action d-none d-md-flex d-lg-flex">
                                    <a href="#"><i class="fa fa-heart"></i></a>
                                    <a href="#"><i class="fa fa-search"></i></a>
                                </div> --}}
                            </div>
                            <div class="product-price">
                                <div class="d-flex justify-content-md-between px-0">
                                    <h3>TSh.{{ $service->price }}</h3>
                                    <a class="btn d-none d-md-block d-lg-block btn-sm"
                                        href="{{ route('services.show', $service->id) }}"><i
                                            class="fa fa-cart-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($services->isEmpty())
                    <div class="col-12 text-center">
                        <h4>No Services available.</h4>
                    </div>
                @endif

                <!-- Pagination Start -->
                @if ($services->total() > 9)
                    <div class="col-md-12 d-flex justify-content-center">
                        {{ $services->links() }}
                    </div>
                @endif
                <!-- Pagination End -->
            </div>
        </div>
    </div>
    <!-- Services List End -->
@endsection