{{-- resources/views/admin/seller_requests/review.blade.php --}}

@extends('layouts.admin_app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-10">
                        <h4 class="card-title">View {{ ucfirst($request->action) }} Seller Request</h4>
                        <p class="card-description">
                            @if (Auth()->user()->role == 0)
                                Review the details of the seller request before making a decision.
                            @else
                                Your request is still in Pending Status.
                            @endif
                        </p>
                    </div>
                    <div class="col-md-2">
                        <img src="{{ isset(json_decode($request->data)->profile_photo_path) && json_decode($request->data)->profile_photo_path
                        ? asset('images/user_profile_images/' . json_decode($request->data)->profile_photo_path)
                        : (isset($request->seller->profile_photo_path) && $request->seller->profile_photo_path
                            ? asset('images/user_profile_images/' . $request->seller->profile_photo_path)
                            : asset('admin_temp/images/faces/user.png')) }}"
                 alt="image" class="img-fluid" />
            
                    </div>
                </div>
                <div class="row">

                    {{-- Display request details --}}
                    <div class="form-group col-md-6 col-lg-6 col-12 col-md-6 col-12">
                        <label for="sellerName">Seller Name:</label>
                        <input type="text" class="form-control" id="sellerName"
                            value="{{ json_decode($request->data)->name ?? ($request->seller->name ?? 'N/A') }}" readonly>
                    </div>

                    <div class="form-group col-md-6 col-lg-6 col-12">
                        <label for="agentName">Agent:</label>
                        <input type="text" class="form-control" id="agentName"
                            value="{{ $request->agent->name ?? 'N/A' }}" readonly>
                    </div>

                    <div class="form-group col-md-6 col-lg-6 col-12">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" id="phone"
                            value="{{ json_decode($request->data)->phone ?? ($request->seller->phone ?? 'N/A') }}" readonly>
                    </div>

                    <div class="form-group col-md-6 col-lg-6 col-12">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email"
                            value="{{ json_decode($request->data)->email ?? ($request->seller->email ?? 'N/A') }}" readonly>
                    </div>

                    {{-- <div class="form-group col-md-6 col-lg-6 col-12">
                    <label for="region">Region:</label>
                    <input type="text" class="form-control" id="region" value="{{ json_decode($request->data)->region }}" readonly>
                </div>

                <div class="form-group col-md-6 col-lg-6 col-12">
                    <label for="district">District:</label>
                    <input type="text" class="form-control" id="district" value="{{ json_decode($request->data)->district }}" readonly>
                </div>

                <div class="form-group col-md-6 col-lg-6 col-12">
                    <label for="ward">Ward:</label>
                    <input type="text" class="form-control" id="ward" value="{{ json_decode($request->data)->ward }}" readonly>
                </div>

                <div class="form-group col-md-6 col-lg-6 col-12">
                    <label for="street">Street:</label>
                    <input type="text" class="form-control" id="street" value="{{ json_decode($request->data)->street ?? 'N/A' }}" readonly>
                </div> --}}

                    <div class="form-group col-md-6 col-lg-6 col-12">
                        <label for="zone">Zone:</label>
                        <input type="text" class="form-control" id="zone"
                            value="{{ json_decode($request->data)->zone ?? ($request->seller->sellerDetail->zone ?? 'N/A') }}"
                            readonly>
                    </div>

                    <div class="form-group col-md-6 col-lg-6 col-12">
                        <label for="businessType">Business Type:</label>
                        <input type="text" class="form-control" id="businessType"
                            value="{{ json_decode($request->data)->business_type ?? ($request->seller->sellerDetail->business_type ?? 'N/A') }}"
                            readonly>
                    </div>


                    <div class="form-group col-md-6 col-lg-6 col-12">

                        <label for="businessName">Business Name:</label>
                        <input type="text" class="form-control" id="businessName"
                            value="{{ json_decode($request->data)->business_name ?? ($request->seller->sellerDetail->business_name ?? 'N/A') }}"
                            readonly>
                    </div>

                    <div class="form-group col-md-6 col-lg-6 col-12">
                        <label for="tradingName">Trading Name:</label>
                        <input type="text" class="form-control" id="tradingName"
                            value="{{ json_decode($request->data)->trading_name ?? ($request->seller->sellerDetail->trading_name ?? 'N/A') }}"
                            readonly>
                    </div>

                    <div class="form-group col-md-6 col-lg-6 col-12">
                        <label for="sectorOfShop">Sector of Shop:</label>
                        <input type="text" class="form-control" id="sectorOfShop"
                            value="{{ json_decode($request->data)->sector_of_shop ?? ($request->seller->sellerDetail->sector_of_shop ?? 'N/A') }}"
                            readonly>
                    </div>

                    <div class="form-group col-md-6 col-lg-6 col-12">
                        <label for="whatsapp">Whatsapp:</label>
                        <input type="text" class="form-control" id="whatsapp_number"
                            value="{{ json_decode($request->data)->whatsapp_number ?? ($request->seller->sellerDetail->whatsapp_number ?? 'N/A') }}"
                            readonly>
                    </div>

                    @foreach (json_decode($request->data)->lipa_accounts ?? ($request->seller->lipaAccounts ?? 'N/A') as $network => $account)
                        @if (!empty($account->name) && !empty($account->number))
                            <div class="col-md-6 col-lg-6 col-12">
                                <div class="form-group">
                                    <label
                                        for="lipa_accounts_{{ $account->network ?? ($network ?? 'N/A') }}">{{ $account->network ?? ($network ?? 'N/A') }}
                                        Lipa Number:</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="{{ $account->name ?? 'N/A' }}"
                                            placeholder="Lipa Name" readonly>
                                        <input type="text" class="form-control" value="{{ $account->number ?? 'N/A' }}"
                                            placeholder="Lipa Number" readonly>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <div class="form-group col-md-6 col-lg-6 col-12">
                        <label for="dateSubmitted">Date Submitted:</label>
                        <input type="text" class="form-control" id="dateSubmitted"
                            value="{{ $request->created_at->format('d M, Y') }}" readonly>
                    </div>

                    <div class="form-group col-md-6 col-lg-6 col-12">
                        <label for="map">Location info: <div class="fw-bold" id="location-info"></div></label>
                        <div id="map-container" style="margin-top: 10px;">
                            <div id="map" style="height: 400px; width: 100%;"></div>
                        </div>
                    </div>

                    @php
                        $coverImages = [
                            'croppedCoverImageOne' => 'Shop Image One (1)',
                            'croppedCoverImageTwo' => 'Shop Image Two (2)',
                            'croppedCoverImageThree' => 'Shop Image Three (3)',
                        ];
                    @endphp
<div class="row">
                    @foreach ($coverImages as $key => $label)
                        @php
                            $imageData = json_decode($request->data)->$key ?? null;
                            $imageSrc = $imageData
                                ? asset('images/shop_cover_images/' . $imageData)
                                : (isset($request->seller->$key) && $request->seller->$key
                                    ? asset('images/shop_cover_images/' . $request->seller->$key)
                                    : null);
                        @endphp

                        @if ($imageSrc)
                            <div class="form-group col-md-4 col-lg-4 col-12">
                                <label for="{{ $key }}">{{ $label }}:</label>
                                <img src="{{ $imageSrc }}" alt="{{ $label }}" class="img-fluid" />
                            </div>
                        @endif
                    @endforeach
                </div>
                </div>

                <a href="{{ Auth::user()->role == 0 ? url('/manage-sellers/requests/' . $request->status) : url('/agent/sellers/' . $request->status) }}"
                    class="btn btn-primary mx-auto">Back to Requests</a>

                @if (Auth()->user()->role == 0)
                    @if ($request->status == 'pending')
                        <button type="button" class="btn btn-success float-end ms-3"
                            onclick="confirmAction('{{ route('admin.handle.seller.request', $request->id) }}', 'approve')">Approve</button>

                        <button type="button" class="btn btn-danger float-md-end mt-3 mt-md-0 mt-lg-0"
                            onclick="confirmAction('{{ route('admin.handle.seller.request', $request->id) }}', 'decline')">Decline</button>
                    @elseif ($request->status == 'approved')
                        <div class="btn-group float-end ms-3" role="group">
                            <button type="button"
                                class="btn @switch($request->seller->status)
                                                    @case('enabled')
                                                        btn-success
                                                        @break
                                                    @case('disabled')
                                                        btn-secondary
                                                        @break                                            
                                                    @default
                                                        btn-danger                                                    
                                                @endswitch dropdown-toggle"
                                id="status-{{ $request->seller_id }}" data-toggle="dropdown" aria-expanded="false"
                                aria-haspopup="true">
                                {{ ucfirst($request->seller->status) }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="status-{{ $request->seller_id }}">
                                <a class="dropdown-item change-status" href="#"
                                    data-id="{{ $request->seller_id }}"
                                    data-status="{{ $request->seller->status == 'enabled' ? 'disabled' : 'enabled' }}">
                                    {{ $request->seller->status == 'enabled' ? 'Disable seller' : 'Enable seller' }}
                                </a>
                            </div>
                        </div>

                        <!-- Edit seller -->
                        <a href="{{ route('edit_seller', $request->seller_id) }}"
                            class="btn btn-warning float-md-end mt-3 mt-md-0 mt-lg-0 ms-3">Edit</a>

                        <!-- Delete seller -->
                        <button class="btn btn-danger delete-seller float-md-end mt-3 mt-md-0 mt-lg-0 ms-3"
                            data-id="{{ $request->seller_id }}" data-name="{{ $request->seller->name }}">
                            Delete
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('admin_temp/vendors/base/sweetalert2.min.css') }}">
    @endpush

    @push('script')
        {{-- SweetAlert modals --}}
        <script src="{{ asset('admin_temp/vendors/base/sweetalert2.all.min.js') }}"></script>
        @if (Auth::user()->role == 0)
            <script>
                function confirmAction(url, action) {
                    let actionText = action === 'approve' ? 'Approve' : 'Decline';
                    let buttonColor = action === 'approve' ? '#28a745' : '#dc3545';

                    Swal.fire({
                        title: `Are you sure?`,
                        text: `You are about to ${actionText.toLowerCase()} this request.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: buttonColor,
                        cancelButtonColor: '#808080',
                        confirmButtonText: `Yes, ${actionText}!`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let form = document.createElement('form');
                            form.action = url;
                            form.method = 'POST';
                            form.innerHTML = `
                            @csrf
                            <input type="hidden" name="action" value="${action}">
                        `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }

                $(document).on('click', '.change-status', function(e) {
                    e.preventDefault();
                    var sellerId = $(this).data('id');
                    var newStatus = $(this).data('status');
                    var statusText = newStatus == 'enabled' ? 'enable' : 'disable';

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You are about to " + statusText + " this seller.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#808080",
                        confirmButtonText: "Yes, " + statusText + "!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ url('/manage-sellers') }}/" + sellerId + "/status",
                                method: 'PUT',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    status: newStatus
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            title: "Updated!",
                                            text: response.message,
                                            icon: "success"
                                        }).then(() => {
                                            location
                                                .reload(); // Reload the page to reflect the changes
                                        });
                                    } else {
                                        Swal.fire("Error!",
                                            "Failed to update the status. Please try again.",
                                            "error");
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire("Error!",
                                        "There was an error updating the status. Please try again.",
                                        "error");
                                }
                            });
                        }
                    });
                });
                // Delete seller modal
                $(document).on('click', '.delete-seller', function(e) {
                    e.preventDefault();
                    var sellerId = $(this).data('id');
                    var sellerName = $(this).data('name');

                    Swal.fire({
                        title: "Delete seller?",
                        text: "Once you delete seller " + sellerName + ", you won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#808080",
                        confirmButtonText: "Yes, delete this seller!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ url('/manage-sellers') }}/" + sellerId,
                                method: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: response.message,
                                            icon: "success"
                                        }).then(() => {
                                            location
                                                .reload(); // Reload the page to reflect the changes
                                        });
                                    } else {
                                        Swal.fire("Error!",
                                            "There was an error deleting the seller. Please try again.",
                                            "error");
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire("Error!",
                                        "There was an error deleting the seller. Please try again.",
                                        "error");
                                }
                            });
                        }
                    });
                });
            </script>
        @elseif (Auth::user()->role == 1)
            <script>
                // Delete seller modal
                $(document).on('click', '.delete-seller', function(e) {
                    e.preventDefault();
                    var sellerId = $(this).data('id');
                    var sellerName = $(this).data('name');

                    Swal.fire({
                        title: "Request to Delete Seller?",
                        text: "Once the request to delete " + sellerName +
                            " is approved, you won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#808080",
                        confirmButtonText: "Yes, request DELETE!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ url('/agent/sellers/delete') }}/" + sellerId,
                                method: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: response.message,
                                            icon: "success"
                                        }).then(() => {
                                            location
                                                .reload(); // Reload the page to reflect the changes
                                        });
                                    } else {
                                        Swal.fire("Error!",
                                            "There was an error deleting the seller. Please try again.",
                                            "error");
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire("Error!",
                                        "There was an error deleting the seller. Please try again.",
                                        "error");
                                }
                            });
                        }
                    });
                });

                // Cancel register seller request modal
                $(document).on('click', '.delete-request', function(e) {
                    e.preventDefault();
                    var sellerId = $(this).data('id');
                    var sellerName = $(this).data('name');
                    var request = $(this).data('request');

                    Swal.fire({
                        title: "Cancel Request?",
                        text: "Once you cancel the request to " + request + " " + sellerName +
                            ", you won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: 'Don\'t Cancel',
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#808080",
                        confirmButtonText: "Yes, CANCEL the request!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ url('/agent/sellers/delete') }}/" + sellerId + "/request",
                                method: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            title: "Cancelled!",
                                            text: response.message,
                                            icon: "success"
                                        }).then(() => {
                                            location
                                                .reload(); // Reload the page to reflect the changes
                                        });
                                    } else {
                                        Swal.fire("Error!",
                                            "There was an error deleting the seller. Please try again.",
                                            "error");
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire("Error!",
                                        "There was an error deleting the seller. Please try again.",
                                        "error");
                                }
                            });
                        }
                    });
                });
            </script>
        @endif

        <script>
            function initMap() {
                // Get the latitude and longitude values passed from Blade
                var latitude = {{ json_decode($request->data)->latitude ?? ($request->seller->latitude ?? 'N/A') }};
                var longitude = {{ json_decode($request->data)->longitude ?? ($request->seller->longitude ?? 'N/A') }};

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


        {{-- JS for dropdown status button --}}
        <script src="{{ asset('admin_temp/vendors/base/popper.min.js') }}"></script>
        <script src="{{ asset('admin_temp/vendors/base/bootstrap.min.js') }}"></script>
    @endpush
@endsection
