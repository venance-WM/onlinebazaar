@extends('layouts.admin_app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Customers</h4>
        <p class="card-description">
          customers you have
        </p>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                     <th>Profile</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Date joined</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $index => $user)
                    <tr>
                        <td>{{ $index + 1  }}</td>
                        <td class="py-1">
                            <img src="{{ asset('admin_temp/images/faces/face2.jpg') }}" alt="image"/>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->created_at->format('jS F, Y') }}</td>

                    </tr>
                @endforeach
            </tbody>
          </table>
          @if ($customers->isEmpty())
          <p>No customers registerd.</p>
      @endif
        </div>
      </div>
    </div>
  </div>

@endsection