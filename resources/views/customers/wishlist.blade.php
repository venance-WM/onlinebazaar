@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">Wishlist</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="container">
        <h1>My Wishlist</h1>
        @if($wishlists->isEmpty())
            <p>Your wishlist is empty.</p>
        @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wishlists as $index => $wishlist)
                    <tr>
                        <td>{{ $index + 1}}</td>
                        <td>
                            <img class="rounded-circle" 
                                 style="width: 75px; height: 75px; object-fit: cover;" 
                                 src="{{ asset('storage/' . $wishlist->product->image) }}" 
                                 alt="{{ $wishlist->product->name }}">
                        </td>
                        <td>{{ $wishlist->product->name }}</td>
                        <td>{{ Str::limit($wishlist->product->description, 100) }}</td>
                        <td>
                            <a href="{{ route('products.details', $wishlist->product->id) }}" class="btn btn-primary">View </a>
                            <form action="{{ route('wishlist.remove') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $wishlist->product->id }}">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
    <script>
        $(document).ready(function() {
            $('.remove-wishlist-button').on('click', function(event) {
                event.preventDefault();
    
                const productId = $(this).data('product-id');
    
                $.ajax({
                    url: '{{ route("wishlist.remove") }}',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
@endsection
