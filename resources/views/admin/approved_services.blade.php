@extends('layouts.admin_app')

@section('content')
    <h1>Approved Services</h1>

    @if($approvedServices->isEmpty())
        <p>No approved services found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                    <th>Approval Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approvedServices as $serviceRequest)
                    @php
                        $serviceData = json_decode($serviceRequest->service_data, true);
                    @endphp
                    <tr>
                        <td>{{ $serviceData['name'] ?? 'N/A' }}</td>
                        <td>{{ $serviceData['description'] ?? 'N/A' }}</td>
                        <td>Tzs{{ $serviceData['price'] ?? 'N/A' }} /=</td>
                        <td>{{ ucfirst($serviceRequest->action) }}</td>
                        <td>{{ $serviceRequest->updated_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    </div>
@endsection
