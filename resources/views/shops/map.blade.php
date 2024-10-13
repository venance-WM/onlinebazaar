@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Nearest Shops</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <h2 class="text-center">Near shops</h2>
    <div id="map" style="height: 500px; width: 100%;"></div>

    <!-- Include Google Maps API -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
    </script>

    <script>
        let map;

        function initMap() {
            // Initialize the map with a default location
            const defaultLocation = { lat: -6.369028, lng: 34.888822 }; // Tanzania coordinates
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: defaultLocation, 
            });

            // Check if geolocation is available and get user's position
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, handleLocationError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            const userLatitude = position.coords.latitude;
            const userLongitude = position.coords.longitude;
            const userLocation = { lat: userLatitude, lng: userLongitude };

            // Center map on user's location
            map.setCenter(userLocation);

            // Add marker for user's location
            new google.maps.Marker({
                position: userLocation,
                map: map,
                title: "Your Location",
            });

           
            fetch(`/search-nearest-sellers?lat=${userLatitude}&lng=${userLongitude}`)
                .then(response => response.json())
                .then(data => {
                   
                    data.forEach(seller => {
                        const sellerLocation = {
                            lat: parseFloat(seller.latitude),
                            lng: parseFloat(seller.longitude)
                        };

                        // Create a marker for each seller
                        const marker = new google.maps.Marker({
                            position: sellerLocation,
                            map: map,
                            title: seller.seller_name,
                        });

                        // Create an infoWindow with a clickable link to view the shop
                        const infoWindow = new google.maps.InfoWindow({
                            content: `<div>
                                        <h6>${seller.seller_name}</h6>
                                        <p><a href="/shop/${seller.id}">View Shop</a></p>
                                      </div>`
                        });

                        // Show infoWindow on marker click
                        marker.addListener('click', () => {
                            infoWindow.open(map, marker);
                        });
                    });
                })
                .catch(error => console.error('Error fetching seller data:', error));
        }

        function handleLocationError(error) {
            console.error('Error with geolocation:', error);
        }
    </script>
@endsection
