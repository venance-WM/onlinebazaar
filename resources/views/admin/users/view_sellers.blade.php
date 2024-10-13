@extends('layouts.admin_app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Sellers</h4>
        <p class="card-description">
          Sellers List
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
              @foreach ($sellers as $index => $seller)
              <tr>
                <td>{{ $index + 1 }}</td>
                  <td class="py-1">
                      <img src="{{ asset('admin_temp/images/faces/face1.jpg') }}" alt="image"/>
                  </td>
                  <td>{{ $seller->name }}</td>
                  <td>{{ $seller->email }}</td>
                  <td>{{ $seller->created_at->format('jS F, Y') }}</td>
              </tr>
          @endforeach          
            </tbody>
          </table>
          @if ($sellers->isEmpty())
              <p>No sellers available.</p>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
