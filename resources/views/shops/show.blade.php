@extends('layouts.home_app')

@section('content')
    <div class="container">
        <h2>{{ $shop->seller_name }}'s Shop</h2>
        <p id="location">Location of Shop: Loading...</p>
        <a href="{{ route('seller.profile', ['id' => $shop->user_id]) }}">More details about the shop here...</a>
    </div>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
    </script>

    <script>
        function initMap() {
            const latitude = {{ $shop->latitude }};
            const longitude = {{ $shop->longitude }};
            const latlng = { lat: latitude, lng: longitude };

            // Use Google Maps Geocoding API to get the real place name
            const geocoder = new google.maps.Geocoder();

            geocoder.geocode({ location: latlng }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById("location").innerHTML = "Location of Shop: " + results[0].formatted_address;
                    } else {
                        document.getElementById("location").innerHTML = "Location not found.";
                    }
                } else {
                    document.getElementById("location").innerHTML = "Geocoder failed: " + status;
                }
            });
        }
    </script>
@endsection
