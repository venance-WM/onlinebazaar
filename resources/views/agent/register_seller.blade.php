@extends('layouts.admin_app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <h4 class="card-title">{{ isset($seller) ? 'Edit Seller' : 'New Registration' }}</h4>
                        <p class="card-description">
                            {{ isset($seller) ? 'Edit the details of this seller, including business information.' : 'This seller will be registered with the specified business information.' }}
                            The <span class="text-danger">***</span> Indicate required field.
                        </p>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
                <hr>

                {{-- Alert message for error or success --}}
                @include('partials.validation_message')

                <form action="{{ isset($seller) ? route('update_seller', $seller->id) : route('store_seller') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($seller))
                        @method('PUT')
                    @endif
                    <blockquote>
                        <h4 class="card-title text-muted">PERSONAL DETAILS</h4>
                    </blockquote>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-12">
                            <div class="form-group">
                                <label for="name">Full Name: <span class="text-danger">***</span></label>
                                <input type="text" name="name" value="{{ old('name', $seller->name ?? '') }}"
                                    class="form-control" id="name" required>
                            </div>
                        </div>

                        <div class="col-md-2 col-lg-2 col-12">
                            <div class="form-group">
                                <label for="business_type">Gender: <span class="text-danger">***</span></label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value="" hidden>Select Gender</option>
                                    <option value="male"
                                        @if (isset($seller)) @if ($seller->gender == 'male')
                                            selected @endif
                                        @endif>Male</option>
                                    <option value="female"
                                        @if (isset($seller)) @if ($seller->gender == 'female')
                                            selected @endif
                                        @endif>Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="email">Email: <span class="text-danger">***</span></label>
                                <input type="text" name="email" value="{{ old('email', $seller->email ?? '') }}"
                                    class="form-control" id="email" required>
                            </div>
                        </div>

                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="email">NIDA NO:</label>
                                <input type="number" name="nida" value="{{ old('nida', $seller->nida ?? '') }}"
                                    class="form-control" id="nida" maxlength="20">
                            </div>
                        </div>

                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="phone">Phone Number: <span class="text-danger">***</span></label>
                                <input type="tel" name="phone" value="{{ old('phone', $seller->phone ?? '') }}"
                                    class="form-control" placeholder="Start with 255..." maxlength="12" id="phone"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="phone">WhatsApp Number:</label>
                                <input type="tel" name="whatsapp_number"
                                    value="{{ old('whatsapp_number', $seller->SellerDetail->whatsapp_number ?? '') }}"
                                    class="form-control" placeholder="Start with 255...">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="profile_photo_path">Profile Picture: <span
                                        class="text-danger">***</span></label>
                                <input type="file" class="custom-file-input form-control" id="fileUpload" name="profile"
                                    required>
                                <input type="hidden" name="cropped_image" id="croppedImage">
                                @if (isset($seller->profile_photo_path))
                                    <img src="{{ asset('images/user_profile_images/' . $seller->profile_photo_path) }}" alt="Profile Picture!"
                                        width="100">
                                @endif
                            </div>
                        </div>

                        <blockquote>
                            <h4 class="card-title text-muted pt-3">ZONE DETAILS</h4>
                        </blockquote>

                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="region">Region: <span class="text-danger">***</span></label>
                                <select class="form-control" name="region"
                                    value="{{ old('region', $seller->SellerDetail->region_id ?? '') }}" id="region"
                                    required>
                                    <option value="" hidden>Select Region</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="district">Teritory: <span class="text-danger">***</span></label>
                                <select class="form-control" name="district" id="district" required>
                                    <option value="" hidden>Select Teritory</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="ward">Cluster: <span class="text-danger">***</span></label>
                                <select class="form-control" name="ward" id="ward" required>
                                    <option value="" hidden>Select Cluster</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="street">Street: <span class="text-danger">***</span></label>
                                <select class="form-control" name="street" id="street" required>
                                    <option value="" hidden>Select Street</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-12">
                            <div class="form-group">
                                <label for="zone">Zone: <span class="text-danger">***</span></label>
                                <input class="form-control" type="text"
                                    value="{{ old('zone', $seller->SellerDetail->zone ?? '') }}" name="zone"
                                    id="zone" placeholder="zone" required>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-8 col-12">
                            <div class="form-group">
                                <label for="load-location">Mark Shop Location: <span
                                        class="text-danger">***</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-secondary" id="load-location"><i
                                                class="fas fa-map-marker-alt fs-6" aria-hidden="true"></i>&nbsp; Load
                                            Location</button>
                                    </div>
                                </div>
                                <!-- The map will be hidden initially and displayed when the button is clicked -->
                                <div id="map-container" style="display: none; margin-top: 10px;">
                                    <div id="map" style="height: 400px; width: 100%;"></div>
                                    <div id="location-info" style="margin-top: 10px;"></div>
                                </div>
                                <!-- Hidden inputs to store latitude and longitude -->
                                <input type="hidden"
                                    value="{{ old('latitude', $seller->SellerDetail->latitude ?? '') }}" id="latitude"
                                    name="latitude">
                                <input type="hidden"
                                    value="{{ old('longitude', $seller->SellerDetail->longitude ?? '') }}" id="longitude"
                                    name="longitude">
                            </div>
                        </div>

                        <blockquote>
                            <h4 class="card-title text-muted pt-3">BUSINESS DETAILS</h4>
                        </blockquote>

                        <div class="col-md-6 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="business_type">Business Type: <span class="text-danger">***</span></label>
                                <select class="form-control" name="business_type" id="business_type" required>
                                    <option value="" hidden>Select Business Type</option>
                                    <option value="seller"
                                        @if (isset($seller)) @if ($seller->SellerDetail->business_type == 'seller')
                                            selected @endif
                                        @endif>Shop Seller</option>
                                    <option value="service"
                                        @if (isset($seller)) @if ($seller->SellerDetail->business_type == 'service')
                                            selected @endif
                                        @endif>Service Provider</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="business_name">Business Name: <span class="text-danger">***</span></label>
                                <input class="form-control" type="text"
                                    value="{{ old('business_name', $seller->SellerDetail->business_name ?? '') }}"
                                    name="business_name" id="business_name" placeholder="Business Name" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="trading_name">Trading Name: <span class="text-danger">***</span></label>
                                <input class="form-control" type="text"
                                    value="{{ old('trading_name', $seller->SellerDetail->trading_name ?? '') }}"
                                    name="trading_name" id="trading_name" placeholder="Trading Name" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="sector_of_shop">Sector of Shop: <span class="text-danger">***</span></label>
                                <input class="form-control" type="text"
                                    value="{{ old('sector_of_shop', $seller->SellerDetail->sector_of_shop ?? '') }}"
                                    name="sector_of_shop" id="sector_of_shop" placeholder="Sector of Shop" required>
                            </div>
                        </div>

                        <blockquote>
                            <h4 class="card-title text-muted pt-3">LIPA NAMBA</h4>
                        </blockquote>

                        @php
                            $networks = ['Vodacom', 'TIGO', 'Airtel', 'Halotel'];
                            $lipaAccounts = $seller->lipaAccounts ?? [];
                        @endphp

                        @foreach ($networks as $network)
                            @php
                                $account = isset($lipaAccounts[$network])
                                    ? $lipaAccounts[$network]
                                    : ['name' => '', 'number' => ''];
                            @endphp
                            <div class="col-md-6 col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="lipa_accounts_{{ $network }}">{{ $network }}:</label>
                                    <div class="input-group mb-3">
                                        <input type="text" name="lipa_accounts[{{ $network }}][name]"
                                            class="form-control"
                                            value="{{ old('lipa_accounts[' . $network . '][name]', $account['name']) }}"
                                            placeholder="Lipa Name">
                                        <input type="text" name="lipa_accounts[{{ $network }}][number]"
                                            class="form-control"
                                            value="{{ old('lipa_accounts[' . $network . '][number]', $account['number']) }}"
                                            placeholder="Lipa Number">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <button type="submit" id="submitButton" class="btn btn-primary text-white">
                        {{ isset($seller) ? 'Submit Update' : 'Submit Register' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('admin_temp/vendors/base/sweetalert2.min.css') }}">
        <style>
            #map {
                height: 400px;
                width: 100%;
                margin-top: 10px;
            }

            #location-info {
                margin-top: 10px;
                font-size: 14px;
                color: #333;
            }
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&loading=async&callback=initMap">
        </script>
        <script>
            function initMap() {
                var map, marker;

                // Handle the location fetching when the button is clicked
                $('#load-location').on('click', function() {

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                // Show the map container
                                $('#map-container').slideDown('slow');
                                var userLocation = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude
                                };

                                // Populate the hidden inputs with the latitude and longitude
                                $('#latitude').val(userLocation.lat);
                                $('#longitude').val(userLocation.lng);

                                if (!map) {
                                    // Initialize the map centered at the user's location
                                    map = new google.maps.Map(document.getElementById('map'), {
                                        center: userLocation,
                                        zoom: 18,
                                        mapTypeControl: false,
                                        streetViewControl: false,
                                        fullscreenControl: false,
                                        zoomControl: true
                                    });

                                    // Add a marker at the user's location
                                    marker = new google.maps.Marker({
                                        position: userLocation,
                                        map: map,
                                        title: 'You are here!'
                                    });
                                } else {
                                    // If map already exists, just update its center and marker position
                                    map.setCenter(userLocation);
                                    marker.setPosition(userLocation);
                                }

                                // Use reverse geocoding to get the location name (street, ward, etc.)
                                var geocoder = new google.maps.Geocoder();
                                geocoder.geocode({
                                    'location': userLocation
                                }, function(results, status) {
                                    if (status === 'OK') {
                                        if (results[0]) {
                                            $('#location-info').text('Location: ' + results[0]
                                                .formatted_address);
                                        } else {
                                            $('#location-info').text('No results found');
                                        }
                                    } else {
                                        $('#location-info').text('Geocoder failed: ' + status);
                                    }
                                });
                            },
                            function(error) {
                                handleLocationError(true, error);
                            }, {
                                enableHighAccuracy: true,
                                timeout: 10000,
                                maximumAge: 0
                            }
                        );
                    } else {
                        handleLocationError(false);
                    }
                });
            }

            function handleLocationError(browserHasGeolocation, error) {
                var errorMsg = browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.';

                if (error) {
                    console.error("Geolocation error: ", error);
                    errorMsg = 'Geolocation error: ' + error.message;
                }

                alert(errorMsg);
            }

            // Initialize the map when the page loads
            $(document).ready(function() {
                initMap();
            });
        </script>
    @endpush

    @include('partials.crop_image_modal')

    @include('partials.fetch_location_scripts')

    @push('script')
        <script src="{{ asset('admin_temp/vendors/base/sweetalert2.all.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#submitButton').click(function(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Confirm Seller Details',
                        text: "Please confirm that all the details entered are correct. All details will be reviewed by the zone admin before registration. You will be informed once the review is complete.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#808080',
                        confirmButtonText: 'OK',
                        cancelButtonText: 'Cancel',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If user clicks OK, submit the form
                            $('form').off('submit')
                                .submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
