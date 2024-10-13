@extends('layouts.admin_app')

@section('content')
    <h1 class="text-center">Review Service Request</h1>

    <div class="d-flex justify-content-center">
        <div class="card p-4 text-center" style="width: 50%;">
            <!-- Display image in a small circle, centered -->
            @if(isset($serviceData['image']))
                <img src="{{ asset('storage/' . $serviceData['image']) }}" 
                     alt="Service Image" 
                     style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; display: block; margin: 0 auto 20px;">
            @else
                <p>No Image Available</p>
            @endif

            <p><strong>Name:</strong> {{ $serviceData['name'] ?? 'check code' }}</p>
            <p><strong>Description:</strong> {{ $serviceData['description'] ?? 'check code' }}</p>
            <p><strong>Price:</strong> TZs{{ $serviceData['price'] ?? 'check code' }} /=</p>
            <p><strong>Action:</strong> {{ ucfirst($serviceRequest->action) }}</p>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back to Service Requests</a>
    </div>
@endsection
