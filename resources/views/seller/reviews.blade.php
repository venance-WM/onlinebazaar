@extends('layouts.admin_app')
@section('content')
<div class="container">
    <h1>Product Reviews</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Customer Name</th>
                <th>Review</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $review)
                <tr>
                    <td>{{ $review->product->name }}</td>
                    <td>{{ $review->name }}</td>
                    <td>{{ $review->review }}</td>
                    <td>{{ $review->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection