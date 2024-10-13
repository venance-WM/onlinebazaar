@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <h1>Registered Sellers</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Seller Name</th>
                    <th>Date Joined</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellers as $seller)
                    <tr>
                        <td>{{ $seller->name }}</td>
                        <td>{{ $seller->created_at->format('Y-m-d') }}</td> <!-- Assuming 'created_at' is the date they joined -->
                        <td>
                            {{ $seller->phone }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
