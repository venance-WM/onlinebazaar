@extends('layouts.home_app')

@section('content')
    <!-- Products Slider Start -->
    <div class="header mb-4">
        <div class="container-fluid">
            <div class="header-slider normal-slider">
                <a href="{{ route('products') }}">
                    <div class="header-slider-item d-flex justify-content-center align-items-center">
                        <img src="{{ asset('home_temp/img/slider-1.jpg') }}" class="slider-image" alt="Slider Image" />
                        {{-- <div class="header-slider-caption">
                        <a class="btn" href="{{ route('products') }}">Go Shopping &nbsp;<i
                                class="fa fa-angle-right"></i></a>
                    </div> --}}
                    </div>
                </a>

                <a href="{{ route('products') }}">
                    <div class="header-slider-item d-flex justify-content-center align-items-center">
                        <img src="{{ asset('home_temp/img/slider-2.jpg') }}" class="slider-image" alt="Slider Image" />
                    </div>
                </a>

                <a href="{{ route('products') }}">
                    <div class="header-slider-item d-flex justify-content-center align-items-center">
                        <img src="{{ asset('home_temp/img/slider-3.jpg') }}" class="slider-image" alt="Slider Image" />
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- Products Slider End -->

    <!-- Category Start-->
    <div class="category d-none d-md-block">
        <section class="container-fluid slide-option">
            <div id="infinite" class="highway-slider">
                <div class="highway-barrier">
                    <ul class="highway-lane">
                        @foreach ($categories as $category)
                            <li class="highway-car">
                                <a href="{{ route('products', ['cat_id' => $category->id]) }}"
                                    class="text-center">{{ $category->name }}</a>
                            </li>
                        @endforeach

                        @foreach ($categories as $category)
                            <li class="highway-car">
                                <a href="{{ route('products', ['cat_id' => $category->id]) }}"
                                    class="text-center">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const slider = document.querySelector('.highway-slider');
                const lane = document.querySelector('.highway-lane');

                slider.addEventListener('mouseenter', function() {
                    lane.style.animationPlayState = 'paused';
                });

                slider.addEventListener('mouseleave', function() {
                    lane.style.animationPlayState = 'running';
                });
            });
        </script>
    @endpush
    <!-- Category End-->

    <!-- Product Offers Start -->
    <div class="featured-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Product offers</h1>
            </div>
            <div class="row align-items-center px-2">
                @foreach ($recentProducts as $product)
                    <div class="col-lg-2 col-md-4 col-4 product-item">
                        <div onclick="redirectToProductDetails('{{ route('products.details', $product->id) }}')">
                            <div class="product-title">
                                <a href="{{ route('products.details', $product->id) }}">{{ $product->name }}</a>
                            </div>
                            <div class="product-image align-content-center">
                                <a href="{{ route('products.details', $product->id) }}">
                                    <img src="{{ asset('images/products/' . $product->image) }}" alt="Product Image">
                                </a>
                                <div class="product-action d-none d-md-flex d-lg-flex">
                                    <a href="#" class="wishlist-button" data-product-id="{{ $product->id }}">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                    <a href=""><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="product-price">
                                <div class="d-flex justify-content-md-between px-0">
                                    <h3>TSh.{{ $product->price }}</h3>
                                    <a class="btn d-none d-md-block d-lg-block btn-sm"
                                        href="{{ route('products.details', $product->id) }}"><i
                                            class="fa fa-cart-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- See More Button Start -->
                @if ($recentProducts->count() > 9)
                    <div class="col-md-12 d-flex justify-content-center">
                        <a class="btn align-content-center mt-3" href="{{ route('products') }}">See More Products <i
                                class="fa fa-angle-right"></i></a>
                    </div>
                @endif
                <!-- See More Button End -->

                @if ($recentProducts->isEmpty())
                    <div class="col-12 text-center">
                        <h4>No Products offer available.</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Products Offer End -->

    <!-- Services Slider Start -->
    <div class="header mb-4">
        <div class="container-fluid">
            <div class="header-slider normal-slider">
                <a href="{{ route('services') }}">
                    <div class="header-slider-item d-flex justify-content-center align-items-center">
                        <img src="{{ asset('home_temp/img/service-1.jpg') }}" class="slider-image" alt="Slider Image" />
                    </div>
                </a>
                <a href="{{ route('services') }}">
                    <div class="header-slider-item d-flex justify-content-center align-items-center">
                        <img src="{{ asset('home_temp/img/service-2.jpg') }}" class="slider-image" alt="Slider Image" />
                    </div>
                </a>
                <a href="{{ route('services') }}">
                    <div class="header-slider-item d-flex justify-content-center align-items-center">
                        <img src="{{ asset('home_temp/img/service-3.jpg') }}" class="slider-image" alt="Slider Image" />
                    </div>
                </a>
                <a href="{{ route('services') }}">
                    <div class="header-slider-item d-flex justify-content-center align-items-center">
                        <img src="{{ asset('home_temp/img/service-4.jpg') }}" class="slider-image" alt="Slider Image" />
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- Services Slider End -->

    <!-- Services Offer Start -->
    <div class="recent-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Service offers</h1>
            </div>
            <div class="row align-items-center px-2">
                @foreach ($recentServices as $service)
                    <div class="col-lg-2 col-md-4 col-4 product-item">
                        <div onclick="redirectToProductDetails('{{ route('services.show', $service->id) }}')">
                            <div class="product-title">
                                <a href="{{ route('services.show', $service->id) }}">{{ $service->name }}</a>
                            </div>
                            <div class="product-image align-content-center">
                                <a href="{{ route('services.show', $service->id) }}">
                                    <img src="{{ asset('images/services/' . $service->image) }}" alt="Product Image">
                                </a>
                                <div class="product-action d-none d-md-flex d-lg-flex">
                                    <a href="#"><i class="fa fa-heart"></i></a>
                                    <a href="#"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="product-price">
                                <div class="d-flex justify-content-md-between px-0">
                                    <h3>{{ $service->title }}</h3>
                                    <a class="btn d-none d-md-block d-lg-block btn-sm"
                                        href="{{ route('services.show', $service->id) }}"><i
                                            class="fa fa-cart-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- See More Button Start -->
                @if ($recentServices->count() > 9)
                    <div class="col-md-12 d-flex justify-content-center">
                        <a class="btn align-content-center mt-3" href="{{ route('services') }}">See More Services <i
                                class="fa fa-angle-right"></i></a>
                    </div>
                @endif
                <!-- See More Button End -->

                @if ($recentServices->isEmpty())
                    <div class="col-12 text-center">
                        <h4>No Services offer Available.</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Services offers End -->

    <!-- Categories Circle Start-->
    <div class="feature">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Shop by categories</h1>
            </div>
            <div class="row align-items-center">
                @php
                    $categoryIcons = [
                        'Grocery and Beverages' => 'fas fa-shopping-cart',
                        'Fashion and Apparel' => 'fas fa-tshirt',
                        'Health and Beauty' => 'fas fa-heartbeat',
                        'Home and Kitchen Appliances' => 'fas fa-blender',
                        'Electronics and Gadgets' => 'fas fa-tv',
                        'Art, Crafts, and Hobbies' => 'fas fa-paint-brush',
                        'Agriculture and Fresh Products' => 'fas fa-leaf',
                        'Automotives and Spare Parts' => 'fas fa-car',
                        'Books and Media' => 'fas fa-book',
                        'Home Utilities' => 'fas fa-couch',
                        'Books and Stationery' => 'fas fa-pencil-alt',
                        'Suppliers' => 'fas fa-truck',
                    ];
                @endphp
                @foreach ($categories as $category)
                    @php
                        $iconClass = $categoryIcons[$category->name] ?? 'fab fa-cc-mastercard'; // Default icon if not found
                    @endphp
                    <div class="col-lg-2 col-md-3 col-4 feature-col">
                        <a href="{{ route('products', ['cat_id' => $category->id]) }}" class="feature-link">
                            <div class="feature-content">
                                <i class="{{ $iconClass }}"></i>
                            </div>
                            <p>{{ $category->name }}</p>
                        </a>
                    </div>
                @endforeach

                <!-- See More Button Start -->
                @if ($categories->count() > 9)
                    <div class="col-md-12 d-flex justify-content-center">
                        <a class="btn align-content-center mt-3" href="{{ route('categories') }}">
                            See More Categories <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                @endif
                <!-- See More Button End -->
            </div>
        </div>
    </div>
    <!-- Categories Circle End-->

    @push('scripts')
        {{-- wish lists --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                $('.wishlist-button').on('click', function(event) {
                    event.preventDefault();

                    const productId = $(this).data('product-id');

                    $.ajax({
                        url: '{{ route('wishlist.add') }}',
                        type: 'POST',
                        data: {
                            product_id: productId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert(response.message);

                            // Update the wishlist count
                            let wishlistCount = parseInt($('#wishlist-count').text().replace('(',
                                '').replace(')', ''));
                            wishlistCount++;
                            $('#wishlist-count').text('(' + wishlistCount + ')');
                        },
                        error: function(xhr) {
                            alert(xhr.responseJSON.message);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
