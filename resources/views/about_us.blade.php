@extends('layouts.home_app')

@section('content')
<div class="container mb-3" style="background-color: bisque; ">
    <div class="row">
        <div class="col-md-6 order-md-2 mb-4">
          <img src="{{ asset('home_temp/img/logo1.png') }}" alt="Online Bazaar Logo" class="img-fluid rounded-circle mx-auto d-block" style="width: 200px; height: 200px;">
          
        </div>
        <div class="col-md-6 order-md-1">
          <h2>About Online Bazaar</h2>
          <p>Welcome to Online Bazaar, a one-stop destination for all your shopping needs. Our platform brings together a diverse range of products from various sellers, providing you with an unparalleled shopping experience.</p>
          <span class="text-center text-info">**Our Mission:**</span>
          <p>Our mission at Online Bazaar is to create a seamless, enjoyable, and convenient shopping experience for our customers while supporting businesses of all sizes.</p>
          <ul>
            <li><i class="fas fa-check-circle"></i> <i>Wide range of products</i></li>
            <li><i class="fas fa-smile"></i> <i>User-friendly interface</i></li>
            <li><i class="fas fa-shield-alt"></i> <i>Secure payment options</i></li>
            <li><i class="fas fa-shipping-fast"></i> <i>Fast and reliable delivery</i></li>
          </ul>
          <p>At Online Bazaar, we partner with trusted sellers who offer high-quality products and exceptional customer service, ensuring that you have a satisfying shopping experience.</p>
        </div>
      </div>
</div>
@endsection