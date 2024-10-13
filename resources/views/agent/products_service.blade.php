@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <h1>Products and Services</h1>

        <!-- Products Table -->
        <h2>Products</h2>
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
                @foreach($products as $productRequest)
                    @if($productRequest->data) 
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

        <!-- Services Table -->
        <h2>Services</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Price</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $serviceRequest)
                    @if($serviceRequest->data) <!-- Check if JSON data exists -->
                        <tr>
                            <td>{{ $serviceRequest->data->name }}</td>
                            <td>{{ $serviceRequest->data->price ?? 'No specified price' }} /=</td>
                            <td>{{ $serviceRequest->data->description }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
