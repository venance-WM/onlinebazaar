{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.home_app')

@section('content')
    @php
        // Check the current section
        $isOrdersSection = $section === 'dashboard';
        $isWishlistSection = $section === 'wishlist';
        $isAddressSection = $section === 'address';
        $isAccountDetailsSection = $section === 'account';
    @endphp

    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">My Account</li>
            </ul>
        </div>
    </div> <!-- Breadcrumb End -->

    <!-- My Account Start -->
    <div class="my-account">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                        <a class="nav-link {{ $isOrdersSection ? 'active' : '' }}" id="orders-nav" data-toggle="pill"
                            href="#orders-tab" role="tab">
                            <i class="fa fa-shopping-bag"></i> Orders
                        </a>
                        <a class="nav-link {{ $isWishlistSection ? 'active' : '' }}" id="wishlist-nav" data-toggle="pill"
                            href="#wishlist-tab" role="tab"><i class="fa fa-heart"></i>Wishlist</a>
                        <a class="nav-link {{ $isAddressSection ? 'active' : '' }}" id="address-nav" data-toggle="pill"
                            href="#address-tab" role="tab"><i class="fa fa-map-marker-alt"></i>Address</a>
                        <a class="nav-link {{ $isAccountDetailsSection ? 'active' : '' }}" id="account-nav"
                            data-toggle="pill" href="#account-tab" role="tab"><i class="fa fa-user"></i>Account
                            Details</a>
                    </div>
                </div>
                <div class="col-md-9">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="tab-content">
                        <div class="tab-pane fade {{ $isOrdersSection ? 'show active' : '' }}" id="orders-tab"
                            role="tabpanel" aria-labelledby="orders-nav">
                            <h4>My Orders</h4>
                            <!-- Order Start -->
                            <div class="cart-page">
                                <div class="row">
                                    @forelse ($orders as $order)
                                        <div class="col-lg-6">
                                            <div class="cart-page-inner">
                                                <div class="cart-summary">
                                                    <div class="cart-content">
                                                        <h1>{{ $order->service_id ? 'Service' : 'Products' }}
                                                            Order#{{ $order->id }} - <span
                                                                class="badge badge-secondary">{{ $order->status }}
                                                            </span></h1>
                                                        <p>Order
                                                            Date:<span>{{ $order->created_at->format('D, d M, Y') }}</span>
                                                        </p>
                                                        <p>Order
                                                            Time:<span>{{ $order->created_at->format('h:i A') }}</span></p>
                                                        @if ($order->service_id)
                                                            <p>Contacts:<span>{{ $order->seller ? $order->seller->phone : 'No Service Contacts' }}</span>
                                                            </p>
                                                        @else
                                                            <p>Total Amount:<span>Tshs. {{ $order->total_amount }}</span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="cart-btn d-flex justify-content-between">
                                                        <div class="pt-3">
                                                            <a href="{{ $order->service_id ? route('service-orders.show', $order->service_id) : route('orders.show', $order->id) }}"
                                                                class="btn btn-primary py-2">View
                                                                Details</a>
                                                        </div>

                                                        @if ($order->status === 'pending')
                                                            <form
                                                                action="{{ $order->service_id ? route('service-orders.destroy', $order->service_id) : route('orders.destroy', $order->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Cancel
                                                                    Order</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-start py-5">
                                            <h4>You have no orders yet.</h4>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            <!-- Order End -->
                        </div>
                        <div class="tab-pane fade {{ $isWishlistSection ? 'show active' : '' }}" id="wishlist-tab"
                            role="tabpanel" aria-labelledby="wishlist-nav">
                            <h4>Wishlist</h4>
                            <!-- Wishlist Start -->
                            @if ($wishlists->isEmpty())
                                <p>Your wishlist is empty.</p>
                            @else
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wishlists as $index => $wishlist)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <img class="rounded-circle"
                                                        style="width: 75px; height: 75px; object-fit: cover;"
                                                        src="{{ asset('images/products/' . $wishlist->product->image) }}"
                                                        alt="{{ $wishlist->product->name }}">
                                                </td>
                                                <td>{{ $wishlist->product->name }}</td>
                                                <td>{{ Str::limit($wishlist->product->description, 100) }}</td>
                                                <td>
                                                    <a href="{{ route('products.details', $wishlist->product->id) }}"
                                                        class="btn btn-primary">View </a>
                                                    <form action="{{ route('wishlist.remove') }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $wishlist->product->id }}">
                                                        <button type="submit" class="btn btn-danger">Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                            <!-- Wishlist End -->
                        </div>
                        <div class="tab-pane fade {{ $isAddressSection ? 'show active' : '' }}" id="address-tab"
                            role="tabpanel" aria-labelledby="address-nav">
                            <h4>Address</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    @if ($userLocation)
                                        <h5>{{ $userLocation->street->name }}, {{ $userLocation->ward->name }},</h5>
                                        <p>{{ $userLocation->district->name }}, {{ $userLocation->region->name }}</p>
                                    @else
                                        <p>Select Address</p>
                                    @endif
                                    <p>Mobile: {{ $user->phone }}</p>
                                </div>
                                <div class="col-md-8">
                                    <form method="POST" action="{{ route('profile.updateLocation', $user->id) }}"
                                        class="row">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-6">
                                            <select class="form-control" name="region" id="region">
                                                <option value="" hidden>Select Region</option>
                                                {{-- @foreach ($regions as $region)
                                                    <option value="{{ $region->id }}"
                                                        {{ $userLocation && $userLocation->region_id == $region->id ? 'selected hidden' : '' }}>
                                                        {{ $region->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="district" id="district">
                                                <option value="" hidden>Select District</option>
                                                {{-- @if ($userLocation && $userLocation->region_id == old('region', $userLocation->region_id))
                                                    @foreach ($districts as $district)
                                                        <option value="{{ $district->id }}"
                                                            {{ $userLocation && $userLocation->district_id == $district->id ? 'selected hidden' : '' }}>
                                                            {{ $district->name }}</option>
                                                    @endforeach
                                                @endif --}}
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="ward" id="ward">
                                                <option value="" hidden>Select Ward</option>
                                                {{-- @if ($userLocation && $userLocation->district_id == old('district', $userLocation->district_id))
                                                    @foreach ($wards as $ward)
                                                        <option value="{{ $ward->id }}"
                                                            {{ $userLocation && $userLocation->ward_id == $ward->id ? 'selected hidden' : '' }}>
                                                            {{ $ward->name }}</option>
                                                    @endforeach
                                                @endif --}}
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="street" id="street">
                                                <option value="" hidden>Select Street</option>
                                                {{-- @if ($userLocation && $userLocation->ward_id == old('ward', $userLocation->ward_id))
                                                    @foreach ($streets as $street)
                                                        <option value="{{ $street->id }}"
                                                            {{ $userLocation && $userLocation->street_id == $street->id ? 'selected hidden' : '' }}>
                                                            {{ $street->name }}</option>
                                                    @endforeach
                                                @endif --}}
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <input class="form-control" type="text" name="place"
                                                placeholder="Place">
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn" type="submit">Update Account</button>
                                            <br><br>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade {{ $isAccountDetailsSection ? 'show active' : '' }}" id="account-tab"
                            role="tabpanel" aria-labelledby="account-nav">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Account Details</h4>
                                    <form class="row mb-3" method="POST"
                                        action="{{ route('update-account-details') }}">
                                        @csrf
                                        <div class="col-md-12">
                                            <input class="form-control" name="name" value="{{ $user->name }}"
                                                type="text" placeholder="Name" autocomplete="name">
                                        </div>
                                        <div class="col-md-12">
                                            <input class="form-control" name="email" value="{{ $user->email }}"
                                                type="email" placeholder="Email">
                                        </div>
                                        <div class="col-md-12">
                                            <input class="form-control" name="phone" value="{{ $user->phone }}"
                                                type="text" placeholder="Phone number">
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Update Account</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <h4>Password change</h4>
                                    <form class="row" method="POST" action="{{ route('custom.password.update') }}">
                                        @csrf
                                        <div class="col-md-12">
                                            <input class="form-control" name="current_password" type="password"
                                                placeholder="Current Password">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" name="password" type="text"
                                                placeholder="New Password">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" name="password_confirmation" type="text"
                                                placeholder="Confirm Password">
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- My Account End -->

    @section('script')
        <script>
            $(document).ready(function() {
                // Fetch regions on page load
                $.get('/regions', function(data) {
                    $('#region').append('<option value="" hidden>Select Region</option>');
                    $.each(data, function(index, region) {
                        $('#region').append('<option value="' + region.id + '">' + region.name +
                            '</option>');
                    });
                });

                // Fetch districts when a region is selected
                $('#region').change(function() {
                    var regionId = $(this).val();
                    $('#district').empty().append('<option value="" hidden>Select District</option>');
                    $('#ward').empty().append('<option value="" hidden>Select Ward</option>');

                    if (regionId) {
                        $.get('/districts/' + regionId, function(data) {
                            $.each(data, function(index, district) {
                                $('#district').append('<option value="' + district.id + '">' +
                                    district.name + '</option>');
                            });
                        });
                    }
                });

                // Fetch wards when a district is selected
                $('#district').change(function() {
                    var districtId = $(this).val();
                    $('#ward').empty().append('<option value="" hidden>Select Ward</option>');

                    if (districtId) {
                        $.get('/wards/' + districtId, function(data) {
                            $.each(data, function(index, ward) {
                                $('#ward').append('<option value="' + ward.id + '">' + ward
                                    .name + '</option>');
                            });
                        });
                    }
                });

                // Fetch streets when a ward is selected
                $('#ward').change(function() {
                    var wardId = $(this).val();
                    $('#street').empty().append('<option value="" hidden>Select Street</option>');

                    if (wardId) {
                        $.get('/streets/' + wardId, function(data) {
                            $.each(data, function(index, street) {
                                $('#street').append('<option value="' + street.id + '">' +
                                    street
                                    .name + '</option>');
                            });
                        });
                    }
                });

                // Trigger initial fetch based on existing user location if available
                var initialRegionId = '{{ $userLocation ? $userLocation->region_id : '' }}';
                if (initialRegionId) {
                    $('#region').val(initialRegionId).trigger('change');
                }
            });
        </script>


        <script>
            $(document).ready(function() {
                $('.remove-wishlist-button').on('click', function(event) {
                    event.preventDefault();

                    const productId = $(this).data('product-id');

                    $.ajax({
                        url: '{{ route('wishlist.remove') }}',
                        type: 'POST',
                        data: {
                            product_id: productId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert(response.message);
                            location.reload();
                        },
                        error: function(xhr) {
                            alert(xhr.responseJSON.message);
                        }
                    });
                });
            });
        </script>
    @endsection
@endsection
