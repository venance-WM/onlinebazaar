@extends('layouts.home_app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

 <!-- Category List Start -->
<div class="product-view feature">
    <div class="container-fluid">
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
                    'Suppliers' => 'fas fa-truck'
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

            @if ($categories->isEmpty())
                <div class="col-12 text-center">
                    <h4>No category available.</h4>
                </div>
            @endif

            <!-- Pagination Start -->
            @if ($categories->total() > 12)
                <div class="col-md-12 d-flex justify-content-center">
                    {{ $categories->links() }}
                </div>
            @endif
            <!-- Pagination End -->
        </div>
    </div>
</div>
<!-- Category List End -->

@endsection
