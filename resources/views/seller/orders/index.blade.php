@extends('layouts.admin_app')
@section('content')
<div class="container">
    <h2 class="text-center">Your Product Orders</h2>
    @if($orders->isEmpty())
        <div class="alert alert-info">
            You have no orders of Products.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order No</th>
                    <th>Customer</th>
                    <th>Product Ordered</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Phone Number</th>
                    <th>Email Verified</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                    @foreach($order->orderItems as $orderItem)
                        <tr>
                            <td>#{{ $index + 1 }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $orderItem->product->name }}</td>
                            <td>{{ $orderItem->quantity }}</td>
                            <td>{{ $orderItem->price }}</td>
                            <td>{{ $order->status }}</td>
                            <td>{{ $order->user->phone }}</td>
                            <td>
                                <a href="#" class="btn btn-success">Confirm order</a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
