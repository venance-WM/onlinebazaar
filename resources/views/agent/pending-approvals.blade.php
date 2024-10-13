@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <h1>Pending Product Approvals</h1>

        <!-- Pending Products Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingProducts as $productRequest)
                    @if($productRequest->data) <!-- Check if JSON data exists -->
                        <tr>
                            <td>{{ $productRequest->id }}</td>
                            <td>{{ $productRequest->data->name }}</td>
                            <td>{{ $productRequest->data->price }}</td>
                            <td>{{ $productRequest->data->description }}</td>
                            <td>{{ $productRequest->status }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
