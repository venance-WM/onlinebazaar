@extends('layouts.admin_app')
{{-- <img src="https://www.bootdey.com/image/1352x300/FF7F50/000000" alt="" class="img-fluid w-100"> --}}

@section('content')
    <div class="card overflow-hidden">
        <div class="card-body p-0">
            <!-- Carousel for Small Devices (scrolling 3 images) -->
            <div id="carouselControls" class="carousel slide carousel-fade d-md-none d-lg-none" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ $seller->sellerDetail->shop_image_one ? asset('images/shop_cover_images/' . $seller->sellerDetail->shop_image_one) : asset('app/placeholder-16-9.png') }}" 
                            class="d-block w-100 img-fluid" alt="Shop Image 1" style="height: 250px; object-fit: cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ $seller->sellerDetail->shop_image_two ? asset('images/shop_cover_images/' . $seller->sellerDetail->shop_image_two) : asset('app/placeholder-16-9.png') }}" 
                            class="d-block w-100 img-fluid" alt="Shop Image 2" style="height: 250px; object-fit: cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ $seller->sellerDetail->shop_image_three ? asset('images/shop_cover_images/' . $seller->sellerDetail->shop_image_three) : asset('app/placeholder-16-9.png') }}" 
                            class="d-block w-100 img-fluid" alt="Shop Image 3" style="height: 250px; object-fit: cover;">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            
            <!-- Row of 3 images for Medium and Large Devices -->
            <div class="row no-gutters d-none d-md-flex d-lg-flex">
                <div class="col-md-4">
                    <img src="{{ $seller->sellerDetail->shop_image_one ? asset('images/shop_cover_images/' . $seller->sellerDetail->shop_image_one) : asset('app/placeholder-16-9.png') }}" 
                        class="img-fluid border border-dark" alt="Shop Image 1" style="height: 250px; object-fit: cover;">
                </div>
                <div class="col-md-4">
                    <img src="{{ $seller->sellerDetail->shop_image_two ? asset('images/shop_cover_images/' . $seller->sellerDetail->shop_image_two) : asset('app/placeholder-16-9.png') }}" 
                        class="img-fluid border border-dark" alt="Shop Image 2" style="height: 250px; object-fit: cover;">
                </div>
                <div class="col-md-4">
                    <img src="{{ $seller->sellerDetail->shop_image_three ? asset('images/shop_cover_images/' . $seller->sellerDetail->shop_image_three) : asset('app/placeholder-16-9.png') }}" 
                        class="img-fluid border border-dark" alt="Shop Image 3" style="height: 250px; object-fit: cover;">
                </div>
            </div>
            
            </div>
            <div class="row align-items-center">
                <div class="col-lg-4 order-lg-1 order-2">
                    <div class="d-flex align-items-center justify-content-around m-4">
                        <div class="text-center">
                            <i class="fa fa-users fs-6 d-block mb-2"></i>
                            <h4 class="mb-0 fw-semibold lh-1">0</h4>
                            <p class="mb-0 fs-4">Customers</p>
                        </div>
                        <div class="text-center">
                            <i class="fa fa-user fs-6 d-block mb-2"></i>
                            <h4 class="mb-0 fw-semibold lh-1">0</h4>
                            <p class="mb-0 fs-4">
                                {{ $seller->sellerDetail->business_type == 'seller' ? 'Products' : 'Services' }}</p>
                        </div>
                        <div class="text-center">
                            <i class="fa fa-check fs-6 d-block mb-2"></i>
                            <h4 class="mb-0 fw-semibold lh-1">0</h4>
                            <p class="mb-0 fs-4">Orders</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-n3 order-lg-2 order-1">
                    <div class="mt-n5">
                        <div class="position-relative user-profile-img"
                            style="top: 0; left: 50%; transform: translateX(-50%); z-index: 10;">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <div class="linear-gradient d-flex align-items-center justify-content-center rounded-circle"
                                    style="width: 110px; height: 110px;">
                                    <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden"
                                        style="width: 100px; height: 100px;">
                                        <img src="{{ asset('images/user_profile_images/' . ($seller->profile_photo_path ?? 'user_profile_images/user.png')) }}"
                                            alt="" class="w-100 h-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="fs-5 mb-0 fw-semibold">{{ $seller->name }}</h5>
                            <p class="mb-0 fs-4">{{ ucfirst($seller->sellerDetail->business_type) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-last float-md-right float-lg-right">
                    <ul
                        class="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-start my-3 gap-3">

                        <li>
                            <!-- Add New Product/Service Button -->
                            <div class="text-md-end text-lg-end text-center mt-3 mx-auto">
                                @php
                                    $businessType = $seller->sellerDetail->business_type;
                                    $isSeller = $businessType === 'seller';
                                    $route = $isSeller
                                        ? route('products.create', ['user_id' => $seller->id])
                                        : route('services.create', ['user_id' => $seller->id]);
                                @endphp

                                <a href="{{ $route }}" class="btn btn-primary">
                                    Add New {{ $isSeller ? 'Product' : 'Service' }}
                                </a>
                                <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#form">Edit
                                    Cover</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
            tabindex="0">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card shadow-none border">
                        <div class="card-body">
                            <h4 class="fw-semibold mb-3">Personal Details</h4>
                            <hr>
                            {{-- <p>{{ $seller->sellerDetail->trading_name }} | {{ $seller->sellerDetail->business_type }}</p> --}}
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-briefcase text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">{{ $seller->sellerDetail->trading_name }}</h6>
                                </li>
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-envelope text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">{{ $seller->email }}</h6>
                                </li>
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-phone text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">{{ $seller->phone }}</h6>
                                </li>
                                @if (isset($seller->sellerDetail->whatsapp_number))
                                    <li class="d-flex align-items-center gap-3 mb-2">
                                        <i class="fa fa-phone-square text-dark fs-6"></i>
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $seller->sellerDetail->whatsapp_number }}
                                            <a href="https://wa.me/{{ preg_replace('/^0/', '255', ltrim($seller->sellerDetail->whatsapp_number, '+')) }}"
                                                target="_blank">
                                                <i class="mdi mdi-open-in-new"></i>
                                            </a>
                                        </h6>
                                    </li>
                                @endif
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-info-circle text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">{{ $seller->gender }}</h6>
                                </li>
                                <h4 class="fw-semibold mb-3">Business Details</h4>
                                <hr>
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-shopping-bag text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">{{ $seller->sellerDetail->business_name }}</h6>
                                </li>
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-cogs text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">{{ $seller->sellerDetail->sector_of_shop }}</h6>
                                </li>
                                <h4 class="fw-semibold mb-3">Location</h4>
                                <hr>
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-angle-right text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">Ward: {{ $seller->sellerDetail->ward->name }}</h6>
                                </li>
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-angle-right text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">Street: {{ $seller->sellerDetail->street->name }}
                                    </h6>
                                </li>
                                <li class="d-flex align-items-center gap-3 mb-4">
                                    <i class="fa fa-angle-right text-dark fs-6"></i>
                                    <h6 class="fs-4 fw-semibold mb-0">Zone: {{ $seller->sellerDetail->zone }}</h6>
                                </li>
                                <h6 class="fs-4 fw-semibold mb-0">Info: <div id="location-info"></div>
                                </h6>
                                <div id="map-container" style="margin-top: 10px;">
                                    <div id="map" style="height: 400px; width: 100%;"></div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    @include('partials.validation_message')

                    <!-- Products List -->
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-3 col-6 mb-3">
                                <div class="card h-100" style="min-height: 350px;">
                                    <img src="{{ asset('images/products/' . $product->image) }}" class="card-img-top"
                                        alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text flex-grow-1">
                                            {{ Str::limit($product->description, 100) }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Price:</strong> TZs {{ number_format($product->price) }} /=<br>
                                            <strong>Stock:</strong> {{ $product->stock_quantity }} <br>
                                        </p>
                                        <a href="#">view in detail</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($services as $service)
                            <div class="col-md-3 col-6 mb-3">
                                <div class="card h-100" style="min-height: 350px;">
                                    <img src="{{ asset('images/services/' . $service->image) }}" class="card-img-top"
                                        alt="{{ $service->name }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $service->name }}</h5>
                                        <p class="card-text flex-grow-1">
                                            {{ Str::limit($service->description, 100) }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Price:</strong> TZs {{ number_format($service->price) }} /=<br>
                                        </p>
                                        <a href="#">view in detail</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title" id="exampleModalLabel">Set Shop Cover Images</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('update_shop_cover_images', $seller->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for=">coverImageOne">Cover One</label>
                                <input type="file" class="form-control" name="coverImageOne" id="coverImageOne" accept="image/*" capture="environment">
                                <input type="hidden" name="croppedCoverImageOne" id="croppedCoverImageOne">
                            </div>

                            <div class="form-group">
                                <label for="coverImageTwo">Cover Two</label>
                                <input type="file" class="form-control" name="coverImageTwo" id="coverImageTwo" accept="image/*" capture="environment">
                                <input type="hidden" name="croppedCoverImageTwo" id="croppedCoverImageTwo">
                            </div>

                            <div class="form-group">
                                <label for="coverImageThree">Cover Three</label>
                                <input type="file" class="form-control" name="coverImageThree" id="coverImageThree" accept="image/*" capture="environment">
                                <input type="hidden" name="croppedCoverImageThree" id="croppedCoverImageThree">
                            </div>
                        </div>

                        <div class="modal-footer border-top-0 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">Save Images</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        @include('partials.crop_image_modal')

        @push('styles')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
            <style>
                .user-profile-img {
                    z-index: 10;
                    /* Ensure the user profile image is above everything */
                }

                body {
                    padding-top: 20px;
                }

                .img-fluid {
                    max-width: 100%;
                    height: auto;
                }

                .card {
                    margin-bottom: 30px;
                }

                .overflow-hidden {
                    overflow: hidden !important;
                }

                .p-0 {
                    padding: 0 !important;
                }

                .mt-n5 {
                    margin-top: -3rem !important;
                }

                .linear-gradient {
                    background-image: linear-gradient(#50b2fc, #f44c66);
                }

                .rounded-circle {
                    border-radius: 50% !important;
                }

                .align-items-center {
                    align-items: center !important;
                }

                .justify-content-center {
                    justify-content: center !important;
                }

                .d-flex {
                    display: flex !important;
                }

                .rounded-2 {
                    border-radius: 7px !important;
                }

                .bg-light-info {
                    --bs-bg-opacity: 1;
                    background-color: rgba(235, 243, 254, 1) !important;
                }

                .card {
                    margin-bottom: 30px;
                }

                .position-relative {
                    position: relative !important;
                }

                .shadow-none {
                    box-shadow: none !important;
                }

                .overflow-hidden {
                    overflow: hidden !important;
                }

                .border {
                    border: 1px solid #ebf1f6 !important;
                }

                .fs-6 {
                    font-size: 1.25rem !important;
                }

                .mb-2 {
                    margin-bottom: 0.5rem !important;
                }

                .d-block {
                    display: block !important;
                }

                a {
                    text-decoration: none;
                }

                .user-profile-tab .nav-item .nav-link.active {
                    color: #5d87ff;
                    border-bottom: 2px solid #5d87ff;
                }

                .mb-9 {
                    margin-bottom: 20px !important;
                }

                .fw-semibold {
                    font-weight: 600 !important;
                }

                .fs-4 {
                    font-size: 1rem !important;
                }

                .card,
                .bg-light {
                    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
                }

                .fs-2 {
                    font-size: .75rem !important;
                }

                .rounded-4 {
                    border-radius: 4px !important;
                }

                .ms-7 {
                    margin-left: 30px !important;
                }

                .container {
                    padding: 2rem 0rem;
                }

                h4 {
                    margin: 2rem 0rem;
                }

                .panel {
                    border-radius: 4px;
                    padding: 1rem;
                    margin-top: 0.2rem;

                    &.panel-big-height {
                        min-height: 150px;
                    }
                }

                .item {
                    border-radius: 4px;
                    padding: 0.5rem;
                    margin: 0.2rem;
                }
            </style>
        @endpush

        @push('script')
            <script>
                function initMap() {
                    // Get the latitude and longitude values passed from Blade
                    var latitude = {{ $seller->sellerDetail->latitude ?? 'N/A' }};
                    var longitude = {{ $seller->sellerDetail->longitude ?? 'N/A' }};

                    // Check if the latitude and longitude values are valid
                    if (latitude && longitude) {
                        // Create a map centered at the given latitude and longitude
                        var map = new google.maps.Map(document.getElementById('map'), {
                            center: {
                                lat: latitude,
                                lng: longitude
                            },
                            zoom: 14, // Adjust zoom level as needed
                            disableDefaultUI: true, // Hide map controls for read-only behavior
                            gestureHandling: 'greedy', // Allows zoom and pan
                        });

                        // Add a marker at the given latitude and longitude
                        var marker = new google.maps.Marker({
                            position: {
                                lat: latitude,
                                lng: longitude
                            },
                            map: map,
                            title: "Seller Location"
                        });

                        // Create a Geocoder instance to reverse geocode the location
                        var geocoder = new google.maps.Geocoder();
                        var latLng = {
                            lat: latitude,
                            lng: longitude
                        };

                        // Use the Geocoder to get the address based on latitude and longitude
                        geocoder.geocode({
                            'location': latLng
                        }, function(results, status) {
                            if (status === 'OK') {
                                if (results[0]) {
                                    // Display the formatted address in the location-info div
                                    document.getElementById('location-info').textContent = results[0].formatted_address;
                                } else {
                                    document.getElementById('location-info').textContent =
                                        'No address results found for this location.';
                                }
                            } else {
                                document.getElementById('location-info').textContent =
                                    'Geocoder failed: ' + status;
                            }
                        });
                    } else {
                        document.getElementById('location-info').textContent = 'Invalid location data provided.';
                    }
                }
            </script>

            <!-- Load the Google Maps API and call the initMap function -->
            <script async defer
                src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&loading=async&callback=initMap">
            </script>

            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
        @endpush
    @endsection
