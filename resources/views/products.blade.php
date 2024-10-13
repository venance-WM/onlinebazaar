@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product List Start -->
    <div class="product-view">
        <div class="container-fluid">
            <div class="row px-2" id="product-list">
                <!-- Filters -->
                <div class="col-md-12">
                    <div class="product-view-top">
                        <div class="row d-flex justify-content-center" id="product-filters">
                            <div class="col-md-2 col-6">
                                <div class="product-short">
                                    <div class="dropdown">
                                        <div class="dropdown-toggle" data-toggle="dropdown">Short by</div>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item sort-by" data-sort="newest">Newest</a>
                                            <a href="#" class="dropdown-item sort-by" data-sort="popular">Popular</a>
                                            <a href="#" class="dropdown-item sort-by" data-sort="most_sale">Most
                                                sale</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="product-price-range">
                                    <div class="dropdown">
                                        <div class="dropdown-toggle" data-toggle="dropdown">Filter by Price
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item sort-by" data-sort="low_to_high">Low
                                                to
                                                High</a>
                                            <a href="#" class="dropdown-item sort-by" data-sort="high_to_low">High
                                                to
                                                Low</a>
                                            <a href="#" class="dropdown-item sort-by" data-sort="random">Random</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filters End -->

                @foreach ($products as $product)
                    <div class="col-lg-2 col-md-4 col-4 product-item">
                        <div onclick="redirectToProductDetails('{{ route('products.details', $product->id) }}')">
                            <div class="product-title">
                                <a href="{{ route('products.details', $product->id) }}">{{ $product->name }}</a>
                            </div>
                            <div class="product-image align-content-center">
                                <a href="{{ route('products.details', $product->id) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
                                </a>
                                <div class="product-action d-none d-md-flex d-lg-flex">
                                    <a href="#" class="wishlist-button" data-product-id="{{ $product->id }}">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                    <a href="#"><i class="fa fa-search"></i></a>
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

                @if ($products->isEmpty())
                    <div class="col-12 text-center">
                        <h4>No products available.</h4>
                    </div>
                @endif

                <!-- Pagination Start -->
                @if ($products->total() > 9)
                    <div class="col-md-12 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                @endif
                <!-- Pagination End -->
            </div>
        </div>
    </div>
    <!-- Product List End -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.sort-by').on('click', function(e) {
                e.preventDefault();
                var sortBy = $(this).data('sort');
                var catId = {{ $category_id ?? 'null' }};
                var url = '{{ route('products.filter') }}';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        sortBy: sortBy,
                        catId: catId
                    },
                    success: function(data) {
                        $('#product-list').html(data.products); // Update product list
                        $('#product-filters').html(data.filters); // Update filters
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });
        });

        //wish lists
        $(document).ready(function() {
        $('.wishlist-button').on('click', function(event) {
            event.preventDefault();

            const productId = $(this).data('product-id');

            $.ajax({
                url: '{{ route("wishlist.add") }}',
                type: 'POST',
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.message);

                    // Update the wishlist count
                    let wishlistCount = parseInt($('#wishlist-count').text().replace('(', '').replace(')', ''));
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



@endsection
