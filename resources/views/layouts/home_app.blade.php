<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Online Bazaar</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Online Bazaar, eCommerce, Shopping, Marketplace" name="keywords">
    <meta
        content="Welcome to Online Bazaar, your one-stop shop for all your shopping needs. Explore our marketplace for a wide variety of products at great prices."
        name="description">

    <!-- Favicon -->
    <link href="{{ asset('home_temp/img/logo1.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('home_temp/lib/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('home_temp/lib/slick/slick-theme.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('home_temp/css/style.css') }}" rel="stylesheet">
    @stack('styles')
    


</head>

<body>
    <!-- Nav Bar Start -->
    <div class="nav fixed-top">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                <a href="{{ route('home') }}" class="navbar-brand">
                    <img src="{{ asset('home_temp/img/logo1.png') }}" alt="Online Bazaar Logo" width="55px">
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto">
                        <a href="{{ route('home') }}"
                            class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                        <a href="{{ route('categories') }}"
                            class="nav-item nav-link {{ request()->routeIs('categories') ? 'active' : '' }}">Categories</a>
                        <a href="{{ route('products') }}"
                            class="nav-item nav-link {{ request()->routeIs('products', 'products.details') ? 'active' : '' }}">Products</a>
                        <a href="{{ route('services') }}"
                            class="nav-item nav-link {{ request()->routeIs('services', 'services.show') ? 'active' : '' }}">Services</a>
                        <a href="{{ route('cart.index') }}"
                            class="nav-item nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}">Cart</a>

                        <a href="{{ route('about_us') }}" class="nav-item nav-link">About Us</a>

                        <a href="{{ route('showMap') }}"  class="nav-item nav-link">
                            <i class="fas fa-map-marker-alt location-icon"></i>
                            Find Nearest Shops
                        </a>
                    </div>
                    <div class="navbar-nav ml-auto">
                        @if (Route::has('login'))
                            @auth
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle"
                                        data-toggle="dropdown">{{ Auth::User()->name }}</a>
                                    <div class="dropdown-menu">
                                        @if (Auth::user()->role === 3)
                                            <a href="{{ route('profile.show', 'dashboard') }}" class="dropdown-item">My
                                                Account</a>
                                        @endif

                                        @if (Auth::user()->role == 0)
                                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Dashboard</a>
                                        @elseif (Auth()->user()->role == 1)
                                            <a href="{{ route('agent.dashboard') }}" class="dropdown-item">Dashboard</a>
                                        @elseif (Auth()->user()->role == 2)
                                            <a href="{{ route('seller.dashboard') }}" class="dropdown-item">Dashboard</a>
                                        @endif

                                        <a href="{{ route('logout') }}" class="dropdown-item"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}"
                                    class="nav-item nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="nav-item nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Nav Bar End -->

    <!-- Bottom Bar Start -->
    <div class="bottom-bar mt-5">
        <div class="container-fluid mt-lg-0 mt-md-0 mt-3">
            <div class="row align-items-center">
                <div class="col-md-3 d-md-block d-none">
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('home_temp/img/logo1.png') }}" alt="Online Bazaar Logo">
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="search">
                        <form action="{{ route('search') }}" method="GET">
                            <input type="text" name="query" placeholder="Search a product or service"
                                autocomplete="off">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="user">
                        <a href="{{ route('profile.show', 'wishlist') }}" class="btn wishlist"
                            title="My Wishlist Items">
                            <i class="fa fa-heart"></i>
                            @if (Route::has('login'))
                                @auth
                                    <span id="wishlist-count">({{ Auth::user()->wishlists->count() }})</span>
                                @endauth
                            @endif
                        </a>
                        <a href="{{ route('cart.index') }}" class="btn cart" title="Cart Items">
                            <i class="fa fa-shopping-cart"></i>
                            @if (Route::has('login'))
                                @auth
                                    <span>({{ $cartItemCount }})</span>
                                @endauth
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Bar End -->
    @yield('content')

    <!-- Footer Start -->
    <div class="footer d-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5>Get in Touch with us</h5>
                        <div class="contact-info">
                            <p>
                                <a href="https://www.google.com/maps/search/?api=1&query=MBEYA,NZOVWE" target="_blank" class="text-dark text-decoration-none">
                                    <i class="fa fa-map-marker"></i> MBEYA, NZOVWE
                                </a>
                            </p>
                            
                            <p>
                                <a href="mailto:bazaarmobilestore@gmail.com" class="text-dark text-decoration-none">
                                    <i class="fa fa-envelope"></i> bazaarmobilestore@gmail.com
                                </a>
                            </p>
                            <p>
                                <a href="tel:+255653494068" class="text-dark text-decoration-none">
                                    <i class="fa fa-phone"></i> +255 653 494 068
                                </a>
                            </p>
                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5>Follow Us</h5>
                        <div class="contact-info">
                            <div class="social">
                                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.facebook.com" target="_blank"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a href="https://www.instagram.com" target="_blank"><i
                                        class="fab fa-instagram"></i></a>
                                        <a href="https://www.youtube.com/@bazaarmobilestore" target="_blank">
                                            <i class="fab fa-youtube"></i>
                                        </a>
                                        
                                <a href="https://wa.me/+255653494068" target="_blank"><i
                                        class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5>Bazaar Info</h5>
                        <ul>
                            <li><a href="{{ route('about_us') }}">About Us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Condition</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5>Purchase Info</h5>
                        <ul>
                            <li><a href="#">Payment Policy</a></li>
                            <li><a href="#">Shipping Policy</a></li>
                            <li><a href="#">Return Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row payment align-items-center">
                {{-- <div class="col-md-6">
                    <div class="payment-method">
                        <h6>We Accept:</h6>
                        <img src="{{ asset('home_temp/img/payment-method.png') }}" alt="Payment Method" />
                    </div>
                </div> --}}
                {{-- <div class="col-md-6">
                    <div class="payment-security">
                        <h6>Secured By:</h6>
                        <img src="{{ asset('home_temp/img/godaddy.svg') }}" alt="Payment Security" />
                        <img src="{{ asset('home_temp/img/norton.svg') }}" alt="Payment Security" />
                        <img src="{{ asset('home_temp/img/ssl.svg') }}" alt="Payment Security" />
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Footer Bottom Start -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 copyright">
                    <p>Copyright &copy; <a href="#" class="text-white">Online bazaar</a>. All Rights Reserved
                    </p>
                </div>

                <div class="col-md-6 template-by">
                    <p>Buy with <a href="#" class="text-white">online bazaar</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom End -->

    <!-- Back to Top -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript Libraries -->
    <script defer src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script defer src="{{ asset('home_temp/lib/easing/easing.min.js') }}"></script>
    <script defer src="{{ asset('home_temp/lib/slick/slick.min.js') }}"></script>

    <!-- Template Javascript -->
    <script defer src="{{ asset('home_temp/js/main.js') }}"></script>

    {{-- Custom Javascripts --}}
    @yield('script')
    @stack('scripts')

    <script>
        function redirectToProductDetails(url) {
            window.location.href = url;
        }
    </script>
</body>

</html>
