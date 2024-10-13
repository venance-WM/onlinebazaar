@extends('layouts.admin_app')
@section('content')
<div class="container">
    <h2 class="text-center">Service Orders</h2>
    <hr>
    @if ($serviceOrders->isEmpty())
    <div class="d-flex justify-content-center">
        <p class="text-center mt-4">No service orders you have. <i><small>Service-orders will be seen here.</small></i></p>
    </div>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Service No:</th>
                <th>Service</th>
                <th>User</th>
                <th>Ordered At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($serviceOrders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->service->title }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->created_at }}</td>
                <td>
                    <a href="#" class="btn btn-success">Confirm order</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection