@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
                <li class="breadcrumb-item active">Cart</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Cart Start -->
    <div class="cart-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-page-inner">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th class="text-nowrap">Quantity</th>
                                        <th>Total</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse($cartItems as $item)
                                        <tr data-id="{{ $item->id }}">
                                            <td>
                                                <div class="img">
                                                    <a href="#"><img
                                                            src="{{ asset('storage/' . $item->product->image) }}"
                                                            alt="Image"></a>
                                                    <p>{{ $item->product->name }}</p>
                                                </div>
                                            </td>
                                            <td>Tshs. {{ $item->product->price }}</td>
                                            <td class="text-nowrap">
                                                <div class="input-group d-flex justify-content-center">
                                                    <span class="input-group-prepend">
                                                        <button type="button" class="btn btn-outline-secondary btn-number"
                                                            data-type="minus" data-id="{{ $item->id }}">
                                                            <span class="fa fa-minus"></span>
                                                        </button>
                                                    </span>
                                                    <input type="text" name="quantity"
                                                        class="input-number quantity-input" value="{{ $item->quantity }}"
                                                        data-id="{{ $item->id }}" readonly>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary btn-number"
                                                            data-type="plus" data-id="{{ $item->id }}">
                                                            <span class="fa fa-plus"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="item-total">Tshs. {{ $item->product->price * $item->quantity }}</td>
                                            <td>
                                                <form action="{{ route('cart.destroy', ['id' => $item->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">Your cart is empty.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-page-inner">
                        <div class="row">
                            <div class="col-12">
                                <div class="coupon">
                                    <input type="text" placeholder="Coupon Code">
                                    <button>Apply Code</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="cart-summary">
                                    <div class="cart-content">
                                        <h1>Cart Summary</h1>
                                        <p>Sub Total<span class="cart-subtotal">Tshs.
                                                {{ $cartItems->sum(function ($item) {
                                                    return $item->product->price * $item->quantity;
                                                }) }}</span>
                                        </p>
                                        <p>Shipping Cost<span>Tshs. 0</span></p>
                                        <h2>Grand Total<span class="cart-grand-total">Tshs.
                                                {{ $cartItems->sum(function ($item) {
                                                    return $item->product->price * $item->quantity;
                                                }) + 0 }}</span>
                                        </h2>
                                    </div>
                                    <div class="cart-btn pt-4">
                                        <a href="{{ route('order.place') }}" class="btn btn-block">Place Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

    <!-- Related Products Start -->
    <div class="recent-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>You may also like</h1>
            </div>

            <div class="row align-items-center product-slider @if ($relatedProducts->count() >= 4) product-slider-3 @endif">
                @forelse ($relatedProducts as $product)
                    <div class="col-lg-3 col-md-4 col-4 product-item">
                        <div onclick="redirectToProductDetails('{{ route('products.details', $product->id) }}')">
                            <div class="product-title">
                                <a href="{{ route('products.details', $product->id) }}">{{ $product->name }}</a>
                            </div>
                            <div class="product-image align-content-center">
                                <a href="{{ route('products.details', $product->id) }}">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image">
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
    </div>
    <!-- Related Products End -->
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-number').forEach(button => {
                button.addEventListener('click', function() {
                    let type = this.dataset.type;
                    let id = this.dataset.id;
                    let input = document.querySelector(`input[data-id='${id}']`);
                    let quantity = parseInt(input.value);
                    if (type === 'minus' && quantity > 1) {
                        quantity--;
                    } else if (type === 'plus' && quantity < 10) {
                        quantity++;
                    } else {
                        return;
                    }
                    input.value = quantity;
                    updateQuantity(id, quantity);
                });
            });

            function updateQuantity(id, quantity) {
                fetch(`/customer/cart/update/${id}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateCartTotals();
                        } else {
                            logJSError('Failed to update quantity in database', `/cart/update/${id}`);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        logJSError(error.message, `/customer/cart/update/${id}`);
                    });
            }

            function updateCartTotals() {
                fetch('/customer/cart/totals', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector('.cart-subtotal').innerText = `Tshs. ${data.subtotal}`;
                            document.querySelector('.cart-grand-total').innerText = `Tshs. ${data.grandTotal}`;
                            document.querySelectorAll('tr[data-id]').forEach(row => {
                                let id = row.dataset.id;
                                let quantity = parseInt(document.querySelector(`input[data-id='${id}']`)
                                    .value);
                                let price = parseFloat(row.querySelector('td:nth-child(2)').innerText
                                    .replace('Tshs. ', ''));
                                row.querySelector('.item-total').innerText =
                                    `Tshs. ${price * quantity}`;
                            });
                        } else {
                            logJSError('Failed to update cart totals', '/customer/cart/totals');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        logJSError(error.message, '/customer/cart/totals');
                    });
            }

            function logJSError(message, url = '', line = 0, column = 0, error = '') {
                fetch('/customer/log-js-error', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message,
                            url,
                            line,
                            column,
                            error
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            console.error('Failed to log JS error to the server');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            window.onerror = function(message, source, lineno, colno, error) {
                logJSError(message, source, lineno, colno, error ? error.stack : '');
                return false;
            };
        });
    </script>
@endsection
