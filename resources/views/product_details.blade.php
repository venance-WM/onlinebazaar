@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
                <li class="breadcrumb-item active">Product Detail</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Detail Start -->
    <div class="product-detail">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-detail-top">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="product-slider-single normal-slider">
                                    <img src="{{ asset('images/products/' . $product->image) }}" alt="Product Image">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="product-content">
                                    <div class="title">
                                        <h1>{{ $product->name }}</h1>
                                    </div>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="price">
                                        <h4>Price:</h4>
                                        <h4>TSh.{{ $product->price }} <span></span></h4>
                                    </div>
                                    <div class="price">
                                        <h4>Available:</h4>
                                        <h4>{{ $product->stock_quantity }} {{ ucfirst($product->unit->name) }}</h4>
                                    </div>
                                    <div class="row quantity">
                                        <div class="col-md-2 col-4">
                                            <h4>Quantity:</h4>
                                        </div>
                                        <div class="col-md-3 col-8 text-start">
                                            @if ($product->stock_quantity === 0)
                                                <h4><span class="badge badge-info">
                                                        Out of Stock
                                                    </span></h4>
                                            @else
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <button type="button" class="btn btn-outline-secondary btn-number"
                                                            data-type="minus" data-field="quantity">
                                                            <span class="fa fa-minus"></span>
                                                        </button>
                                                    </span>
                                                    <form action="{{ route('cart.store', ['id' => $product->id]) }}"
                                                        method="POST" id="addToCartForm">
                                                        @csrf
                                                        <input type="text" name="quantity"
                                                            class="form-control input-number px-2" value="1"
                                                            min="1" max="{{ $product->stock_quantity }}"
                                                            placeholder="0">
                                                    </form>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary btn-number"
                                                            data-type="plus" data-field="quantity">
                                                            <span class="fa fa-plus"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-7"></div>
                                    </div>
                                    <div class="action">
                                        @if ($product->stock_quantity === 0)
                                            <a href="#related-products" class="btn">See Other Related Products</a>
                                        @else
                                            <button type="submit" class="btn mr-3 mr-md-2 mr-lg-2" id="addToCartBtn">
                                                <i class="fa fa-shopping-cart"></i> Add to Cart
                                            </button>
                                            <button type="button" class="btn">
                                                <i class="fa fa-shopping-bag"></i> Buy Now
                                            </button>
                                        @endif
                                    </div>
                                    <a href="{{ route('seller.profile', $product->seller_id) }}"
                                        class="d-flex align-items-center px-0 mt-1 pt-1">
                                        <img src="{{ asset(empty($product->seller->profile_photo_path) ? 'storage/user_profile_images/user.png' : 'images/user_profile_images/' . $product->seller->profile_photo_path) }}"
                                            alt="Profile Picture" class="rounded-circle"
                                            style="width: 30px; height: 30px; margin-right: 8px;">
                                        <p
                                            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0;">
                                            <span>{{ Str::limit($product->seller->name, 30, '...') }}</span>
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row product-detail-bottom">
                        <div class="col-lg-12">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#reviews">Reviews
                                        ({{ $reviews->count() }})</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="description" class="container tab-pane active">
                                    <h4>Product description</h4>
                                    <p>{{ $product->description }}</p>
                                </div>

                                <div id="reviews" class="container tab-pane fade">
                                    <div class="reviews-submit">
                                        <h4>Give your Review:</h4>
                                        <div class="col-12">
                                            @if ($errors->any())
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    @foreach ($errors->all() as $error)
                                                        <div>{{ $error }}</div>
                                                    @endforeach
                                                    <button type="button" class="close" data-dismiss="alert"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                        <form action="{{ route('review.store', $product->id) }}" method="POST">
                                            @csrf
                                            <div class="ratting">
                                                <i class="far fa-star" data-rating="1"></i>
                                                <i class="far fa-star" data-rating="2"></i>
                                                <i class="far fa-star" data-rating="3"></i>
                                                <i class="far fa-star" data-rating="4"></i>
                                                <i class="far fa-star" data-rating="5"></i>
                                                <input type="hidden" name="rating" id="rating" value="0"
                                                    required>
                                            </div>
                                            <div class="row form">
                                                <div class="col-sm-6">
                                                    <input type="text" name="name" placeholder="Name"
                                                        value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="email" name="email" placeholder="Email"
                                                        value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                                                </div>
                                                <div class="col-sm-12">
                                                    <textarea name="review" placeholder="Review" required></textarea>
                                                </div>
                                                <div class="col-sm-12">
                                                    <button type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    @if ($reviews->count() > 0)
                                        <div class="reviews-list">
                                            <h4>Customer Reviews:</h4>
                                            <ul>
                                                @foreach ($reviews as $review)
                                                    <li>
                                                        <strong>{{ $review->name }}</strong>
                                                        <span>Rated: {{ $review->rating }}/5</span>
                                                        <p>{{ $review->review }}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p>No reviews yet. Be the first to review this product!</p>
                                    @endif
                                </div>
                            </div>

                            <!-- JavaScript for star rating selection -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const stars = document.querySelectorAll('.ratting i');

                                    stars.forEach(star => {
                                        star.addEventListener('click', function() {
                                            const rating = star.getAttribute('data-rating');
                                            document.getElementById('rating').value = rating;

                                            stars.forEach(s => {
                                                if (s.getAttribute('data-rating') <= rating) {
                                                    s.classList.remove('far');
                                                    s.classList.add('fas');
                                                } else {
                                                    s.classList.remove('fas');
                                                    s.classList.add('far');
                                                }
                                            });
                                        });
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <div class="product" id="related-products">
                    <div class="section-header">
                        <h1>Related Items</h1>
                    </div>

                    <div
                        class="row align-items-center product-slider @if ($relatedProducts->count() > 4) product-slider-3 @endif">
                        @forelse ($relatedProducts as $product)
                            <div class="col-lg-3 col-md-4 col-4 product-item">
                                <div onclick="redirectToProductDetails('{{ route('products.details', $product->id) }}')">
                                    <div class="product-title">
                                        <a href="{{ route('products.details', $product->id) }}">{{ $product->name }}</a>
                                    </div>
                                    <div class="product-image align-content-center">
                                        <a href="{{ route('products.details', $product->id) }}">
                                            <img src="{{ asset('images/products/' . $product->image) }}" alt="Product Image">
                                        </a>
                                        <div class="product-action d-none d-md-flex d-lg-flex">
                                            <a href="#"><i class="fa fa-heart"></i></a>
                                            <a href="#"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <div class="d-flex justify-content-between px-0">
                                            <h3>TSh.{{ $product->price }}</h3>
                                            <a class="btn d-none d-md-block d-lg-block btn-sm"
                                                href="{{ route('products.details', $product->id) }}"><i
                                                    class="fa fa-cart-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <h4>No related products available.</h4>
                            </div>
                        @endforelse
                    </div>
                </div>
                <!-- Related Product End -->
            </div>
        </div>
    </div>
    </div>
    <!-- Product Detail End -->
@endsection

@section('script')
    <script>
        document.querySelectorAll('.btn-number').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                var fieldName = button.getAttribute('data-field');
                var type = button.getAttribute('data-type');
                var input = document.querySelector('input[name="' + fieldName + '"]');
                var currentValue = parseInt(input.value);

                if (!isNaN(currentValue)) {
                    if (type == 'minus') {
                        if (currentValue > parseInt(input.min)) {
                            currentValue -= 1;
                        }
                    } else if (type == 'plus') {
                        if (currentValue < parseInt(input.max)) {
                            currentValue += 1;
                        }
                    }
                    input.value = currentValue;
                } else {
                    input.value = 1; // Default to 1 if NaN
                }
            });
        });

        document.getElementById('addToCartBtn').addEventListener('click', function() {
            document.getElementById('addToCartForm').submit();
        });
    </script>
@endsection
