@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('services') }}">Services</a></li>
                <li class="breadcrumb-item active">Service Detail</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Detail Start -->
    <div class="product-detail">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-detail-top">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="product-slider-single normal-slider">
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="Product Image">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="product-content">
                                    <div class="title">
                                        <h1>{{ $service->title }}</h1>
                                    </div>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="price">
                                        <h4>Price:</h4>
                                        <h4>TSh.{{ $service->price }} <span></span></h4>
                                    </div>
                                    <div class="details">
                                        <h4>Location:</h4>
                                        <h4>
                                            <p class="text-muted font-size-sm text-capitalize">
                                                {{-- {{ ucwords(strtolower($sellerLocation->street->name)) }},
                                                {{ ucwords(strtolower($sellerLocation->ward->name)) }},
                                                {{ ucwords(strtolower($sellerLocation->district->name)) }}
                                                -
                                                {{ ucwords(strtolower($sellerLocation->region->name)) }} --}}
                                            </p>
                                        </h4>
                                    </div>
                                    <form action="{{ route('services.order', $service->id) }}" method="POST"
                                        id="orderServiceForm">
                                        @csrf
                                    </form>
                                    <div class="action">
                                        <button type="submit" class="btn mr-3 mr-md-2 mr-lg-2" id="orderServiceButton">
                                            <i class="fa fa-shopping-cart"></i> Order Service
                                        </button>
                                    </div>
                                    <a href="{{ route('seller.profile', $service->seller_id) }}"
                                        class="d-flex align-items-center px-0 mt-1 pt-1">
                                        <img src="{{ asset(empty($service->seller->profile_photo_path) ? 'storage/user_profile_images/user.png' : 'storage/' . $service->seller->profile_photo_path) }}"
                                            alt="Profile Picture" class="rounded-circle"
                                            style="width: 30px; height: 30px; margin-right: 8px;">
                                        <p
                                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0;">
                                            <span>{{ Str::limit($service->seller->name, 30, '...') }}</span>
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row product-detail-bottom">
                        <div class="col-lg-12">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#description">Description</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="description" class="container tab-pane active">
                                    <h4>Service description</h4>
                                    <p>{{ $service->description }}</p>
                                </div>
                              
                            </div>
                        </div>
                    </div>

          
                </div>
            </div>
        </div>
    </div>
    <!-- Product Detail End -->
@endsection

@section('script')
    <script>
        document.getElementById('orderServiceButton').addEventListener('click', function() {
            document.getElementById('orderServiceForm').submit();
        });
    </script>
@endsection
