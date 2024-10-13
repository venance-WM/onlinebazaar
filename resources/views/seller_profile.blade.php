@extends('layouts.home_app')
{{-- <img src="https://www.bootdey.com/image/1352x300/FF7F50/000000" alt="" class="img-fluid w-100"> --}}

@section('content')
    @php
        $businessType = $seller->sellerDetail->business_type;
        $isSeller = $businessType === 'seller';
        $route = $isSeller
            ? route('products.create', ['user_id' => $seller->id])
            : route('services.create', ['user_id' => $seller->id]);
    @endphp
    <header class="profile-header container overflow-hidden">
        <div class="card-body p-0">
            <!-- Carousel for Small Devices (scrolling 3 images) -->
            <div id="carouselControls" class="carousel slide carousel-fade d-md-none d-lg-none" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset($seller->sellerDetail->shop_image_one ? 'storage/' . $seller->sellerDetail->shop_image_one : 'app/placeholder-16-9.png') }}"
                            class="d-block w-100 img-fluid" alt="Shop Image 1" style="height: 250px; object-fit: cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset($seller->sellerDetail->shop_image_two ? 'storage/' . $seller->sellerDetail->shop_image_two : 'app/placeholder-16-9.png') }}"
                            class="d-block w-100 img-fluid" alt="Shop Image 2" style="height: 250px; object-fit: cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset($seller->sellerDetail->shop_image_three ? 'storage/' . $seller->sellerDetail->shop_image_three : 'app/placeholder-16-9.png') }}"
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
                    <img src="{{ asset($seller->sellerDetail->shop_image_one ? 'storage/' . $seller->sellerDetail->shop_image_one : 'app/placeholder-16-9.png') }}"
                        class="img-fluid border border-dark" alt="Shop Image 1" style="height: 250px; object-fit: cover;">
                </div>
                <div class="col-md-4">
                    <img src="{{ asset($seller->sellerDetail->shop_image_two ? 'storage/' . $seller->sellerDetail->shop_image_two : 'app/placeholder-16-9.png') }}"
                        class="img-fluid border border-dark" alt="Shop Image 2" style="height: 250px; object-fit: cover;">
                </div>
                <div class="col-md-4">
                    <img src="{{ asset($seller->sellerDetail->shop_image_three ? 'storage/' . $seller->sellerDetail->shop_image_three : 'app/placeholder-16-9.png') }}"
                        class="img-fluid border border-dark" alt="Shop Image 3" style="height: 250px; object-fit: cover;">
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
                            <h4 class="mb-0 fw-semibold lh-1">
                                @php
                                    $count =
                                        $seller->sellerDetail->business_type === 'seller'
                                            ? $seller->products->count()
                                            : $seller->services->count();
                                @endphp

                                {{ $count }}
                            </h4>
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
                                        <img src="{{ asset('storage/' . ($seller->profile_photo_path ?? 'user_profile_images/user.png')) }}"
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
                    @if (session('message'))
                        <div class="alert alert-success mt-3 alert-dismissible fade show" id="auto-dismiss-alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    @push('scripts')
                        <script>
                            // Auto-dismiss the alert after 3 seconds
                            setTimeout(function() {
                                var alert = document.getElementById('auto-dismiss-alert');
                                if (alert) {
                                    alert.classList.remove('show');
                                    alert.classList.add('fade');
                                }
                            }, 3000); // Adjust the time in milliseconds (3000 ms = 3 seconds)
                        </script>
                    @endpush
                    
                    <ul
                        class="list-unstyled d-flex align-items-center justify-content-center justify-content-lg-start my-3 gap-3">

                        <li> <!-- Navigate to shop Button -->
                            <div class="text-md-end text-lg-end text-center mt-3 mx-auto">
                                @if (Route::currentRouteName() == 'seller.profile')
                                    <a href="{{ route('seller.profile.navigate', $seller->id) }}" class="btn btn-primary">
                                        <i class="fa fa-location-arrow"></i> Navigate To
                                        {{ $isSeller ? 'Shop' : 'Service' }}
                                    </a>
                                @else
                                    <a href="{{ route('seller.profile', $seller->id) }}" class="btn btn-secondary">
                                        Back To Profile
                                    </a>
                                @endif
                                @php
                                    $isSubscribed = false;
                                    $customer = auth()->user() ?? null;
                                    if ($customer) {
                                        $isSubscribed = $customer
                                            ->shopSubscriptions()
                                            ->where('seller_id', $seller->id)
                                            ->exists(); // Check if the user is subscribed to the seller's shop
                                    }

                                @endphp

                                <form
                                    action="{{ $isSubscribed ? route('unsubscribe.seller', $seller->id) : route('subscribe.seller', $seller->id) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    @if ($isSubscribed)
                                        @method('DELETE') <!-- Use DELETE method for unsubscribe -->
                                    @endif
                                    <button type="submit"
                                        class="btn @if ($isSubscribed) btn-success @else btn-outline-primary @endif">
                                        @if ($isSubscribed)
                                            <i class="fa fa-check"></i> Subscribed
                                        @else
                                            <i class="fa fa-user-plus"></i> Subscribe
                                        @endif
                                    </button>
                                </form>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="location-details" class="card shadow-none border">
                <div class="card-body">
                    @if (Route::currentRouteName() == 'seller.profile')
                        <div class="row">
                            <!-- Personal Details Section -->
                            <div class="col-md-4 mb-4">
                                <h6 class="fw-semibold mb-3">Personal Details</h6>
                                <hr>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex align-items-center gap-3 mb-4">
                                        <i class="fa fa-briefcase text-dark fs-6"></i>
                                        <h6 class="fs-4 fw-semibold mb-0 mx-3"> {{ $seller->sellerDetail->trading_name }}
                                        </h6>
                                    </li>
                                    <li class="d-flex align-items-center gap-3 mb-4">
                                        <i class="fa fa-envelope text-dark fs-6"></i>
                                        <h6 class="fs-4 fw-semibold mb-0 mx-3">
                                            <a href="mailto:{{ $seller->email }}"
                                                class="text-dark text-decoration-none">{{ $seller->email }}</a>
                                        </h6>
                                    </li>

                                    <li class="d-flex align-items-center gap-3 mb-4">
                                        <i class="fa fa-phone text-dark fs-6"></i>
                                        <h6 class="fs-4 fw-semibold mb-0 mx-3">
                                            <a href="tel:{{ $seller->phone }}"
                                                class="text-dark text-decoration-none">{{ $seller->phone }}</a>
                                        </h6>
                                    </li>
                                    @if (isset($seller->sellerDetail->whatsapp_number))
                                        <li class="d-flex align-items-center gap-3 mb-4">
                                            <i class="fa fa-phone-square text-dark fs-6"></i>
                                            <h6 class="fs-4 fw-semibold mb-0 mx-3">
                                                <a href="https://wa.me/{{ preg_replace('/^0/', '255', ltrim($seller->sellerDetail->whatsapp_number, '+')) }}"
                                                    target="_blank" class="text-dark text-decoration-none">
                                                    {{ $seller->sellerDetail->whatsapp_number }}
                                                </a>
                                                {{-- <a href="https://wa.me/{{ preg_replace('/^0/', '255', ltrim($seller->sellerDetail->whatsapp_number, '+')) }}"
                                            target="_blank" class="ms-2 text-dark">
                                                <i class="fa fa-external-link"></i> Whatsapp
                                            </a> --}}
                                            </h6>
                                        </li>
                                    @endif

                                    <li class="d-flex align-items-center gap-3 mb-4">
                                        <i class="fa fa-info-circle text-dark fs-6"></i>
                                        <h6 class="fs-4 fw-semibold mb-0 mx-3">{{ $seller->gender }}</h6>
                                    </li>
                                </ul>
                            </div>

                            <!-- Business Details Section -->
                            <div class="col-md-4 mb-4">
                                <h6 class="fw-semibold mb-3">Business Details</h6>
                                <hr>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex align-items-center gap-3 mb-4">
                                        <i class="fa fa-shopping-bag text-dark fs-6"></i>
                                        <h6 class="fs-4 fw-semibold mb-0 mx-3">{{ $seller->sellerDetail->business_name }}
                                        </h6>
                                    </li>
                                    <li class="d-flex align-items-center gap-3 mb-4">
                                        <i class="fa fa-cogs text-dark fs-6"></i>
                                        <h6 class="fs-4 fw-semibold mb-0 mx-3">{{ $seller->sellerDetail->sector_of_shop }}
                                        </h6>
                                    </li>
                                </ul>
                            </div>

                            <!-- Location Section -->
                            <div class="col-md-4 mb-4">
                                <h6 class="fw-semibold mb-3">Shop Location</h6>
                                <hr>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex align-items-center gap-3 mb-4">
                                        <i class="fa fa-angle-right text-dark fs-6"></i>
                                        <h6 class="fs-4 fw-semibold mb-0 mx-3">Ward:
                                            {{ $seller->sellerDetail->ward->name }}
                                        </h6>
                                    </li>
                                    <li class="d-flex align-items-center gap-3 mb-4">
                                        <i class="fa fa-angle-right text-dark fs-6"></i>
                                        <h6 class="fs-4 fw-semibold mb-0 mx-3">Street:
                                            {{ $seller->sellerDetail->street->name }}</h6>
                                    </li>
                                    <li class="d-flex align-items-center gap-3 mb-4">
                                        <i class="fa fa-angle-right text-dark fs-6"></i>
                                        <h6 class="fs-4 fw-semibold mb-0 mx-3">Zone: {{ $seller->sellerDetail->zone }}
                                        </h6>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Map Section -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="fs-4 fw-semibold mb-0">Shop on Map:</h6>
                                <div id="map-container" class="mt-4">
                                    <div id="map" style="height: 250px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>

                        @push('scripts')
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
                                            zoom: 14,
                                            disableDefaultUI: true,
                                            gestureHandling: 'greedy',
                                        });

                                        // Add a marker at the given latitude and longitude
                                        var marker = new google.maps.Marker({
                                            position: {
                                                lat: latitude,
                                                lng: longitude
                                            },
                                            map: map,
                                            title: '{{ $seller->sellerDetail->trading_name ?? 'N/A' }}' + ' Location'
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
                        @endpush
                    @else
                        <!-- Map Section -->
                        <div id="now" class="row">
                            <div class="col-12 text-center">
                                <h6 class="fs-4 fw-semibold mb-0">Route Map:</h6>
                                <div id="routeInfo" class="pt-3"></div>
                                <div id="map-container" class="my-4">
                                    <div id="routingMap" style="height: 600px; width: 100%;"></div>
                                </div>

                                <select class="form-control" id="travelMode">
                                    <option value="DRIVING">Driving</option>
                                    <option value="WALKING">Walking</option>
                                    <option value="BICYCLING">Bicycling</option>
                                    <option value="TRANSIT">Transit</option>
                                </select>

                                <button id="startNavigating" class="btn btn-primary mt-3">Start Navigating</button>
                            </div>
                        </div>

                        @push('scripts')
                            <script>
                                let map;
                                let directionsService;
                                let directionsRenderer;

                                function initMap() {
                                    // Initialize the map
                                    map = new google.maps.Map(document.getElementById("routingMap"), {
                                        zoom: 14,
                                        center: {
                                            lat: -34.397,
                                            lng: 150.644
                                        } // Default center
                                    });

                                    directionsService = new google.maps.DirectionsService();
                                    directionsRenderer = new google.maps.DirectionsRenderer({
                                        suppressMarkers: true // To customize markers
                                    });
                                    directionsRenderer.setMap(map);

                                    // Prompt for location access
                                    if (navigator.geolocation) {
                                        navigator.geolocation.getCurrentPosition(showPosition, handleError);
                                    } else {
                                        alert("Geolocation is not supported by this browser.");
                                    }

                                    // Start navigation button event
                                    document.getElementById('startNavigating').addEventListener('click', function() {
                                        // Logic for starting navigation
                                        alert("Starting navigation...");
                                        // Optionally, open a navigation app with a link
                                        const sellerLocation = {
                                            lat: {{ $seller->sellerDetail->latitude ?? 'N/A' }},
                                            lng: {{ $seller->sellerDetail->longitude ?? 'N/A' }}
                                        };
                                        window.open(
                                            `https://www.google.com/maps/dir/?api=1&destination=${sellerLocation.lat},${sellerLocation.lng}`,
                                            '_blank');
                                    });
                                }

                                function showPosition(position) {
                                    const userLocation = {
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude
                                    };

                                    // Center the map on the user's location
                                    map.setCenter(userLocation);

                                    // Fetch seller coordinates
                                    const sellerLocation = {
                                        lat: {{ $seller->sellerDetail->latitude ?? 'N/A' }},
                                        lng: {{ $seller->sellerDetail->longitude ?? 'N/A' }}
                                    };

                                    // Draw the route
                                    calculateRoute(userLocation, sellerLocation);

                                    // Change route on travel mode change
                                    document.getElementById('travelMode').addEventListener('change', function() {
                                        calculateRoute(userLocation, sellerLocation);
                                    });
                                }

                                function calculateRoute(userLocation, sellerLocation) {
                                    const travelMode = document.getElementById('travelMode').value;

                                    const request = {
                                        origin: userLocation,
                                        destination: sellerLocation,
                                        travelMode: google.maps.TravelMode[travelMode],
                                    };

                                    directionsService.route(request, (result, status) => {
                                        if (status === 'OK') {
                                            directionsRenderer.setDirections(result);
                                            displayRouteInfo(result.routes[0]);
                                        } else {
                                            console.error('Directions request failed due to ' + status);
                                        }
                                    });
                                }

                                function displayRouteInfo(route) {
                                    const distance = route.legs[0].distance.text;
                                    const duration = route.legs[0].duration.text;

                                    // Display the distance and duration
                                    document.getElementById('routeInfo').innerHTML = `
                                        <span class="badge badge-primary">Distance: ${distance}</span>
                                        <span class="badge badge-secondary">Duration: ${duration}</span>
                                    `;

                                    // Add custom destination marker with logo
                                    const destinationMarker = new google.maps.Marker({
                                        position: route.legs[0].end_location,
                                        map: map,
                                        icon: {
                                            url: '{{ asset('home_temp/img/shop-on-map.png') }}',
                                            scaledSize: new google.maps.Size(50, 50)
                                        }
                                    });

                                    const originMarker = new google.maps.Marker({
                                        position: route.legs[0].start_location,
                                        map: map,
                                        icon: {
                                            url: '{{ asset('home_temp/img/customer-location.png') }}',
                                            scaledSize: new google.maps.Size(50, 50),
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 10,
                                            fillColor: 'blue',
                                            fillOpacity: 1,
                                            strokeColor: 'red',
                                            strokeWeight: 2
                                        }
                                    });
                                }

                                function handleError(error) {
                                    switch (error.code) {
                                        case error.PERMISSION_DENIED:
                                            alert("User denied the request for Geolocation.");
                                            break;
                                        case error.POSITION_UNAVAILABLE:
                                            alert("Location information is unavailable.");
                                            break;
                                        case error.TIMEOUT:
                                            alert("The request to get user location timed out.");
                                            break;
                                        case error.UNKNOWN_ERROR:
                                            alert("An unknown error occurred.");
                                            break;
                                    }
                                }
                            </script>
                        @endpush
                    @endif
                </div>
            </div>

        </div>
    </header>
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h6 class="fw-semibold mb-3">{{ $isSeller ? 'Products' : 'Services' }} List</h6>
                    <hr>
                    @include('partials.validation_message')

                    <!-- Products List -->
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 col-6 mb-3">
                                <div class="card h-100" style="min-height: 350px;">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                        alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title">{{ $product->name }}</h6>
                                        <p class="card-text flex-grow-w1">
                                            {{ Str::limit($product->description, 100) }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Price:</strong> Tshs. {{ number_format($product->price) }} /=<br>
                                            <strong>Stock:</strong> {{ $product->stock_quantity }}
                                            {{ $product->unit->name }}<br>
                                        </p>
                                        <!-- Product actions-->
                                        <form action="{{ route('cart.store', ['id' => $product->id]) }}" method="POST"
                                            id="addToCartForm">
                                            @csrf
                                            <input type="hidden" name="quantity" class="form-control input-number px-2"
                                                value="1">
                                        </form>
                                        <div class="card-footer border-top-0 bg-transparent text-md-nowrap">
                                            <div class="d-flex justify-content-md-between justify-content-sm-center row">
                                                <a class="btn btn-primary mb-md-0 mb-3"
                                                    href="{{ route('products.details', $product->id) }}">View Details</a>
                                                <button type="submit" class="btn btn-outline-dark mt-auto mx-auto"
                                                    id="addToCartBtn"><i class="fa fa-cart-plus"></i></button>
                                                <button class="btn btn-outline-dark mt-auto wishlist-button mx-auto"
                                                    data-product-id="{{ $product->id }}"><i
                                                        class="fa fa-heart"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach ($services as $service)
                            <div class="col-md-3 col-6 mb-3">
                                <div class="card h-100" style="min-height: 350px;">
                                    <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top"
                                        alt="{{ $service->name }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $service->name }}</h5>
                                        <p class="card-text flex-grow-1">
                                            {{ Str::limit($service->description, 100) }}
                                        </p>
                                        <p class="card-text">
                                            <strong>Price:</strong> TZs {{ number_format($service->price) }} /=<br>
                                        </p>
                                        <!-- Service actions-->
                                        <form action="{{ route('services.order', $service->id) }}" method="POST"
                                            id="orderServiceForm">
                                            @csrf
                                        </form>

                                        <div class="card-footer border-top-0 bg-transparent text-md-nowrap">
                                            <div class="d-flex justify-content-md-between justify-content-sm-center row">
                                                <a class="btn btn-primary mb-md-0 mb-3"
                                                    href="{{ route('services.show', $service->id) }}">View Details</a>
                                                <button class="btn btn-outline-dark mt-auto" id="orderServiceButton">Book
                                                    Service</button>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

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
        </style>
    @endpush

    @push('scripts')
        <script>
            document.getElementById('orderServiceButton').addEventListener('click', function() {
                document.getElementById('orderServiceForm').submit();
            });
        </script>

        <script>
            //wish lists
            $(document).ready(function() {
                $('.wishlist-button').on('click', function(event) {
                    event.preventDefault();

                    const productId = $(this).data('product-id');

                    $.ajax({
                        url: '{{ route('wishlist.add') }}',
                        type: 'POST',
                        data: {
                            product_id: productId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert(response.message);

                            // Update the wishlist count
                            let wishlistCount = parseInt($('#wishlist-count').text().replace('(',
                                '').replace(')', ''));
                            wishlistCount++;
                            $('#wishlist-count').text('(' + wishlistCount + ')');
                        },
                        error: function(xhr) {
                            alert(xhr.responseJSON.message);
                        }
                    });
                });
            });

            document.getElementById('addToCartBtn').addEventListener('click', function() {
                document.getElementById('addToCartForm').submit();
            });
        </script>

        <!-- Load the Google Maps API and call the initMap function -->
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&loading=async&callback=initMap&libraries=marker">
        </script>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
    @endpush
@endsection
