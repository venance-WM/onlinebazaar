@extends('layouts.admin_app')
@section('content')
    <div class="row">
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="{{ $user->profile_photo_path != null ? asset('storage/' . $user->profile_photo_path) : asset('admin_temp/images/faces/user.png') }}"
                            alt="User Profile Image" class="rounded-circle p-1 bg-primary" width="110" height="110"
                            style="object-fit: cover;">
                        @if ($user->role == 0 && $user->profile_photo_path != null)
                            <a href="@if ($user->role == 0) {{ route('remove-admin-profile-picture') }} @elseif ($user->role == 1){{ route('remove-agent-profile-picture') }} @elseif ($user->role == 2){{ route('remove-seller-profile-picture') }} @endif"
                                class="btn btn-outline-danger btn-sm mt-3"
                                onclick="event.preventDefault(); document.getElementById('remove-profile-form').submit();">
                                Remove Picture
                            </a>
                            <form id="remove-profile-form"
                                action="@if ($user->role == 0) {{ route('remove-admin-profile-picture') }} @elseif ($user->role == 1){{ route('remove-agent-profile-picture') }} @elseif ($user->role == 2){{ route('remove-seller-profile-picture') }} @endif"
                                method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                        <div class="mt-3">
                            <h4>{{ $user->name }}</h4>
                            <p class="text-secondary mb-1">
                                @if ($user->role == 0)
                                    Admin
                                @elseif ($user->role == 1)
                                    Agent
                                @elseif ($user->role == 2)
                                    Seller
                                @else
                                    Unknown Role
                                @endif
                            </p>

                            {{-- <address>
                                <p class="text-muted font-size-sm text-capitalize">
                                    {{ $userLocation ? ucwords(strtolower($userLocation->street->name)) . ',' : '' }}
                                    {{ $userLocation ? ucwords(strtolower($userLocation->ward->name)) . ',' : '' }}
                                    {{ $userLocation ? ucwords(strtolower($userLocation->district->name)) : '' }}
                                </p>
                                <p class="text-muted font-size-sm text-capitalize">
                                    @if ($userLocation)
                                        {{ ucwords(strtolower($userLocation->region->name)) }}
                                    @else
                                        <a class="btn btn-inverse-warning btn-sm btn-icon-text" href="#address"><i
                                                class="mdi mdi-alert btn-icon-prepend"></i>Click Here to Add your
                                            Address</a>
                                    @endif
                                    </>
                            </address> --}}
                            {{-- <button class="btn btn-primary">Follow</button>
                            <button class="btn btn-outline-primary">Message</button> --}}
                        </div>
                    </div>
                    <hr class="my-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">Email:</h6>
                            <span class="text-secondary">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0">Phone:</h6><span class="text-secondary">
                                @if (empty($user->phone))
                                    <em>No Phone Added</em>
                                @else
                                    {{ $user->phone }}
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                @include('partials.validation_message')
                @if ($user->role == 0)
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Profile Information</h4>
                                <form class="forms-sample" method="POST"
                                    action="@if ($user->role == 0) {{ route('update-admin-details') }}
                            @elseif($user->role == 1) {{ route('update-agent-details') }} @else {{ route('update-seller-details') }} @endif"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $user->name }}" id="name" placeholder="Name"
                                            @if ($user->role != 0) readonly @endif>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ $user->email }}" id="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="tel" class="form-control" name="phone"
                                            value="{{ $user->phone }}" id="phone" placeholder="Phone number">
                                    </div>
                                    @if ($user->role == 2)
                                        <div class="form-group">
                                            <label for="phone">WhatsApp Number</label>
                                            <input type="tel" class="form-control" name="whatsapp"
                                                value="{{ $user->sellerDetail->whatsapp_number }}" id="whatsapp"
                                                placeholder="WhatsApp number">
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="profile">Profile Picture</label>
                                        <input type="file" class="custom-file-input form-control" id="fileUpload"
                                            name="profile">
                                        <input type="hidden" name="cropped_image" id="croppedImage">
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2 text-white">Update Profile</button>
                                    <button type="reset" class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- <div class="col-md-12 grid-margin stretch-card" id="address">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Address Information</h4>
                            <p class="card-description">
                                Your shop or service address location
                            </p>
                            <form method="POST" action="{{ route('update-seller-location', $user->id) }}" class="row">
                                @csrf
                                @method('PUT')
                                <div class="col-md-6 form-group">
                                    <label for="region">Region</label>
                                    <select class="form-control" name="region" id="region">
                                        <option value="" hidden>Select Region</option>
                                        @if ($userLocation)
                                            @foreach ($regions as $region)
                                                <option value="{{ $region->id }}"
                                                    {{ $userLocation && $userLocation->region_id == $region->id ? 'selected hidden' : '' }}>
                                                    {{ $region->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="district">District</label>
                                    <select class="form-control" name="district" id="district">
                                        <option value="" hidden>Select District</option>
                                        @if ($userLocation && $userLocation->region_id == old('region', $userLocation->region_id))
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ $userLocation && $userLocation->district_id == $district->id ? 'selected hidden' : '' }}>
                                                    {{ $district->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="ward">Ward</label>
                                    <select class="form-control" name="ward" id="ward">
                                        <option value="" hidden>Select Ward</option>
                                        @if ($userLocation && $userLocation->district_id == old('district', $userLocation->district_id))
                                            @foreach ($wards as $ward)
                                                <option value="{{ $ward->id }}"
                                                    {{ $userLocation && $userLocation->ward_id == $ward->id ? 'selected' : '' }}>
                                                    {{ $ward->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="street">Street</label>
                                    <select class="form-control" name="street" id="street">
                                        <option value="" hidden>Select Street</option>
                                        @if ($userLocation && $userLocation->ward_id == old('ward', $userLocation->ward_id))
                                            @foreach ($streets as $street)
                                                <option value="{{ $street->id }}"
                                                    {{ $userLocation && $userLocation->street_id == $street->id ? 'selected' : '' }}>
                                                    {{ $street->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="place">Place</label>
                                    <input class="form-control" type="text"
                                        value="{{ $userLocation ? $userLocation->place : '' }}" id="place"
                                        name="place" placeholder="Your place">
                                </div>
                                <div class="col-md-12 form-group">
                                    <button class="btn btn-primary me-2 text-white" type="submit">Update Address</button>
                                    <button type="reset" class="btn btn-light">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-12 grid-margin stretch-card">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ __('Update Password') }}</h4>

                            <form method="POST" action="{{ route('custom.password.update') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="current_password">{{ __('Current Password') }}</label>
                                    <input type="password" class="form-control" id="current_password"
                                        name="current_password" required>
                                </div>

                                <div class="form-group">
                                    <label for="password">{{ __('New Password') }}</label>
                                    <input type="password" class="form-control" id="password" name="password" required
                                        autocomplete="new-password">
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">{{ __('Confirm New Password') }}</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <button type="submit"
                                    class="btn btn-primary text-white">{{ __('Update Password') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-12 grid-margin stretch-card">
                    <div class="card border-danger">
                        <div class="card-body">
                            <h4 class="card-title text-danger">DANGER ZONE</h4>
                            <p class="card-description">
                                Be very careful when attempting these changes!
                            </p>
                            <ul class="list-group">
                                @if ($userLocation)
                                    <li
                                        class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center py-3">
                                        <div>
                                            <strong>Remove address location</strong>
                                            <br>
                                            <small class="text-muted">This may lead to losing some of your customers. You
                                                may update it instead.</small>
                                        </div>
                                        <form action="{{ route('seller-location.destroy') }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-inverse-danger btn-sm fw-bold mt-2 mt-md-0">Remove my
                                                location</button>
                                        </form>
                                    </li>
                                @endif
                                <li
                                    class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center py-3">
                                    <div>
                                        <strong>Delete account</strong>
                                        <br>
                                        <small class="text-muted">Once you delete your account, there is no going back.
                                            Please be certain.</small>
                                    </div>
                                    <form action="{{ route('seller-account.destroy') }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-inverse-danger btn-sm fw-bold mt-2 mt-md-0">Delete my
                                            account</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    @include('partials.crop_image_modal')

    @include('partials.fetch_location_scripts')

@endsection
