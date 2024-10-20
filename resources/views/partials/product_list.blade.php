                @foreach ($products as $product)
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
                                    <a href="#"><i class="fa fa-heart"></i></a>
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
