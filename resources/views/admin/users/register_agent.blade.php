@extends('layouts.admin_app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <h4 class="card-title">{{ isset($agent) ? 'Edit Agent' : 'Register New Agent' }}</h4>
                        <p class="card-description">
                            {{ isset($agent) ? 'Edit the details of this agent, Make sure you fill the working area.' : 'This agent will be registered to work on the zone specified' }}
                        </p>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('admin.agents.manage') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
                <hr>

                {{-- Alert message for error or success --}}
                @include('partials.validation_message')

                <form
                    action="{{ isset($agent) ? route('admin.agents.update', $agent->id) : route('admin.agents.register-action') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($agent))
                        @method('PUT')
                    @endif
                    <blockquote>
                        <h4 class="card-title text-muted">PERSONAL DETAILS</h4>
                    </blockquote>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="name">Full Name:</label>
                                <input type="text" name="name" value="{{ old('name', $agent->name ?? '') }}"
                                    class="form-control" id="name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" name="email" value="{{ old('email', $agent->email ?? '') }}"
                                    class="form-control" id="email" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="phone">Phone Number:</label>
                                <input type="tel" name="phone" value="{{ old('phone', $agent->phone ?? '') }}"
                                    class="form-control" placeholder="Start with 255..." maxlength="12" id="phone"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-12">
                            <div class="form-group">
                                <label for="fileUpload">Profile Picture:</label>
                                <input type="file" class="custom-file-input form-control" id="fileUpload" name="profile">
                                <input type="hidden" name="cropped_image" id="croppedImage">
                                @if (isset($agent->profile_photo_path))
                                    <img src="{{ asset('storage/' . $agent->profile_photo_path) }}" class="mt-3 text-center"
                                        alt="Profile Picture" width="100">
                                @endif
                            </div>
                        </div>

                        <blockquote>
                            <h4 class="card-title text-muted pt-3">WORKING AREA</h4>
                        </blockquote>

                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="title">Region:</label>
                                <select class="form-control" name="region" value="{{ old('region') }}" id="region"
                                    required>
                                    <option value="" hidden>Select Region</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="title">District:</label>
                                <select class="form-control" name="district" id="district" required>
                                    <option value="" hidden>Select District</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="title">Ward:</label>
                                <select class="form-control" name="ward" id="ward" required>
                                    <option value="" hidden>Select Ward</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-12">
                            <div class="form-group">
                                <label for="title">Street:</label>
                                <select class="form-control" name="street" id="street">
                                    <option value="" hidden>Select Street</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-12">
                            <div class="form-group">
                                <label for="title">Place:</label>
                                <input class="form-control" type="text"
                                    value="{{ old('place', $agent->agentDetail->place ?? '') }}" name="place"
                                    placeholder="Place">
                            </div>
                        </div>

                    </div>
                    <button type="submit"
                        class="btn btn-primary text-white">{{ isset($agent) ? 'Update' : 'Register' }}</button>
                </form>
            </div>
        </div>
    </div>

    @include('partials.crop_image_modal')

    @include('partials.fetch_location_scripts')
    
@endsection
