@extends('layouts.admin_app')

@section('content')

    <h1>Pending Service Requests</h1>

    @if($serviceRequests->isEmpty())
        <p>No service requested for approval.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th> 
                    <th>Action</th>
                    <th>Review</th>
                    <th>Approve</th>
                    <th>Reject</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serviceRequests as $request)
                    @php
                        $serviceData = json_decode($request->service_data, true);
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $serviceData['name'] ?? 'N/A' }}</td>
                        <td>{{ $serviceData['description'] ?? 'N/A' }}</td>
                        <td>TZs{{ $serviceData['price'] ?? 'N/A' }}/=</td>
                        <td>
                            <!-- Display image in a small circle -->
                            @if(isset($serviceData['image'])) 
                                <img src="{{ asset('images/services/' . $serviceData['image']) }}" 
                                     alt="Service Image" 
                                     style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ ucfirst($request->action) }}</td>
                        <td>
                            <a href="{{ route('admin.service.requests.review', $request->id) }}" class="btn btn-primary">Review</a>
                        </td>
                        <td>
                            <form action="{{ route('admin.service.requests.approve', $request->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.service.requests.reject', $request->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection
