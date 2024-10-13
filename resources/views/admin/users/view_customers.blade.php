@extends('layouts.admin_app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Customers</h4>
        <p class="card-description">
          Customers List
        </p>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>No.</th>
                <th>
                  Profile
                </th>
                <th>
                  Name
                </th>
                <th>
                  Email
                </th>
                <th>
                  Joined Date
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($customers as $index => $customer)
              <tr>
                <td>{{ $index + 1 }}</td>

                  <td class="py-1">
                      <img src="{{ asset('admin_temp/images/faces/face3.jpg') }}" alt="image"/>
                  </td>
                  <td>{{ $customer->name }}</td>
                  <td>{{ $customer->email }}</td>
                  <td>{{ $customer->created_at->format('jS F, Y') }}</td>
              </tr>
          @endforeach          
            </tbody>
          </table>
          @if ($customers->isEmpty())
              <p>No customers available.</p>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
