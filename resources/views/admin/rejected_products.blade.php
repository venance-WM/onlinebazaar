@extends('layouts.admin_app')

@section('content')
    <h2>Rejected Products</h2>
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rejectedProducts as $index => $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" width="50" class="img-thumbnail">
                        </td>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['description'] }}</td>
                        <td>TZs {{ $product['price'] }} /=</td>
                        <td>{{ $product['stock_quantity'] }}</td>
                        <td>
                            <a href="{{ route('admin.products.approval.review', ['id' => $product['id']]) }}" class="btn btn-info btn-sm">View More</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
