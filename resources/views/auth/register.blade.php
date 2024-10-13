@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Register</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

   <!-- Register Start -->
<div class="login">
    <div class="container">
        <div class="row">
            <div class="col-12">    
                <form method="POST" action="{{ route('register') }}" class="register-form">
                    @csrf

                    <div class="row">
                        <div class="col-12">
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
                        </div>
                        
                        <div class="col-md-6">
                            <label>Name</label>
                            <input class="form-control" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Your Name">
                        </div>
                        <div class="col-md-6">
                            <label>Phone Number</label>
                            <input class="form-control" name="phone" value="{{ old('phone') }}" required autofocus autocomplete="phone" placeholder="Your phone">
                        </div>
                        <div class="col-md-6">
                            <label>E-mail</label>
                            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required placeholder="E-mail">
                        </div>
                        <div class="col-md-6">
                            <label>Password</label>
                            <input class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Password">
                        </div>
                        <div class="col-md-6">
                            <label>Confirm Password</label>
                            <input class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="custom-control custom-checkbox col-md-12">
                                <input type="checkbox" class="custom-control-input" id="newaccount" name="terms">
                                <label class="custom-control-label" for="newaccount">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                            ]) !!}
                                </label>
                            </div>
                        @endif

                        <div class="col-md-12 text-center pt-3">
                            <button class="btn w-25" type="submit">Register</button>
                        </div>

                        <div class="col-md-12 text-center pt-3">
                            <p>Already Registered? <a href="{{ route('login') }}">Login Here</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Register End -->

@endsection

