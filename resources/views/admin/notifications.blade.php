@extends('layouts.admin_app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Card for Users Registered Today -->
        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-info mb-3">
                <div class="card-header text-center">Users Today</div>
                <div class="card-body">
                    <h5 class="card-title text-center text-white">{{ $usersToday }}</h5>
                    <p class="card-text text-center">Registered today.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.notifications', ['period' => 'today']) }}" class="btn btn-light">View</a>
                </div>
            </div>
        </div>

        <!-- Card for Users Registered This Week -->
        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header text-center">Users This Week</div>
                <div class="card-body">
                    <h5 class="card-title text-center text-white">{{ $usersThisWeek }}</h5>
                    <p class="card-text text-center">Registered this week.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.notifications', ['period' => 'week']) }}" class="btn btn-light">View</a>
                </div>
            </div>
        </div>

        <!-- Card for Users Registered This Month -->
        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-header text-center">Users This Month</div>
                <div class="card-body">
                    <h5 class="card-title text-center text-white">{{ $usersThisMonth }}</h5>
                    <p class="card-text text-center">Registered this month.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.notifications', ['period' => 'month']) }}" class="btn btn-light">View</a>
                </div>
            </div>
        </div>

        <!-- Card for Users Registered This Year -->
        <div class="col-lg-3 col-md-6">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header text-center">Users This Year</div>
                <div class="card-body">
                    <h5 class="card-title text-center text-white">{{ $usersThisYear }}</h5>
                    <p class="card-text text-center">Registered this year.</p>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.notifications', ['period' => 'year']) }}" class="btn btn-light">View</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Table to display detailed user list -->
    <div class="row mt-4">
        <div class="col-12">
            <h3>Users registered {{ $period }}</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($users) > 0)
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">No users registered for this period.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
