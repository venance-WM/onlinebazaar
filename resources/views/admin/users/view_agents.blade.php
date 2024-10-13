@extends('layouts.admin_app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-10">
                        <h4 class="card-title">Agents</h4>
                        <p class="card-description">
                            Agents List
                        </p>
                    </div>
                    <div class="col-md-2 float-end">
                        <a href="{{ route('admin.agents.register') }}" class="btn btn-primary text-white">Register New
                            Agent</a>
                    </div>
                </div>

                {{-- Alert message for error or success --}}
                @include('partials.validation_message')

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Working Area</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agents as $index => $agent)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="py-1">
                                        <img src="{{ $agent->profile_photo_path ? asset('storage/' . $agent->profile_photo_path) : asset('admin_temp/images/faces/face3.jpg') }}"
                                            alt="image" width="100" />
                                    </td>

                                    <td>{{ $agent->name }}</td>
                                    <td>{{ $agent->email }}</td>
                                    <td>
                                        @if ($agent->agentDetail)
                                            {{ ucfirst($agent->agentDetail->place) }},
                                            @if ($agent->agentDetail->ward)
                                                {{ ucfirst($agent->agentDetail->ward->name) }} -
                                            @endif
                                            @if ($agent->agentDetail->district)
                                                {{ ucwords($agent->agentDetail->district->name) }}
                                            @endif
                                        @else
                                            <em>Details not available</em>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                class="btn @switch($agent->status)
                                                @case('enabled')
                                                    btn-success
                                                    @break
                                                @case('disabled')
                                                    btn-secondary
                                                    @break
                                                @case('onreview')
                                                    btn-warning
                                                    @break                                            
                                                @default
                                                    btn-danger                                                    
                                            @endswitch btn-sm dropdown-toggle"
                                                id="status" data-toggle="dropdown" aria-expanded="false"
                                                aria-haspopup="true">
                                                {{ ucfirst($agent->status) }}
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="status">
                                                <a class="dropdown-item change-status" href="#"
                                                    data-id="{{ $agent->id }}" data-name="{{ $agent->name }}"
                                                    data-status="{{ $agent->status == 'enabled' ? 'disabled' : 'enabled' }}">
                                                    {{ $agent->status == 'enabled' ? 'Disable Agent' : 'Enable Agent' }}
                                                </a>

                                                @if ($agent->status == 'onReview')
                                                    <a class="dropdown-item change-status" href="#"
                                                        data-id="{{ $agent->id }}" data-status="enabled">Review
                                                        Agent</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{-- <a href="#" class="btn btn-outline-primary btn-sm" title="View Agent"><i
                                                class="fa fa-eye"></i></a> --}} {{-- ! Hii ni kwaajiri ya kumview agent na maduka aliyo add, for now skip mpk akianza kuadd --}}
                                        <a href="{{ route('admin.agents.edit', $agent->id) }}"
                                            class="btn btn-outline-secondary btn-sm" title="Edit Agent"><i
                                                class="fa fa-pencil-alt"></i></a>
                                        <a href="#" class="btn btn-outline-danger btn-sm delete-agent"
                                            data-id="{{ $agent->id }}" data-name="{{ $agent->name }}"
                                            title="Delete Agent"><i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($agents->isEmpty())
                        <p>No Agent available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('admin_temp/vendors/base/sweetalert2.min.css') }}">
    @endpush

    @push('script')
        {{-- Sweetalert modals --}}
        <script src="{{ asset('admin_temp/vendors/base/sweetalert2.all.min.js') }}"></script>
        <script>
            $(document).on('click', '.change-status', function(e) {
                e.preventDefault();
                var agentId = $(this).data('id');
                var agentName = $(this).data('name');
                var newStatus = $(this).data('status');
                if (newStatus == 'enabled') {
                    var status = 'enable';
                } else {
                    var status = 'disable';
                }

                Swal.fire({
                    title: "Are you sure?",
                    text: "You are about to " + status + " Agent " + agentName + ".",
                    icon: "warning",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#808080",
                    confirmButtonText: "Yes, " + status + "!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/manage-agents/update/" + agentId + "/status",
                            method: 'PUT',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: "Updated!",
                                        text: response.message,
                                        icon: "success"
                                    }).then(() => {
                                        location
                                            .reload(); // Reload the page to reflect the changes
                                    });
                                } else {
                                    Swal.fire("Error!",
                                        "Failed to update the status of Agent " + agentName +
                                        ". Please try again.",
                                        "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire("Error!",
                                    "There was an error updating the status of Agent " +
                                    agentName + ". Please try again.",
                                    "error");
                            }
                        });
                    }
                });
            });

            // Delete agent modal
            $(document).on('click', '.delete-agent', function(e) {
                e.preventDefault();
                var agentId = $(this).data('id');
                var agentName = $(this).data('name');

                Swal.fire({
                    title: "Delete Agent?",
                    text: "Once you delete agent " + agentName + ", you won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#808080",
                    confirmButtonText: "Yes, delete this agent!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/manage-agents/delete/" + agentId,
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: response.message,
                                        icon: "success"
                                    }).then(() => {
                                        location
                                            .reload();
                                    });
                                } else {
                                    Swal.fire("Error!",
                                        "There was an error deleting the agent. Please try again.",
                                        "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire("Error!",
                                    "There was an error deleting the agent. Please try again.",
                                    "error");
                            }
                        });
                    }
                });
            });
        </script>

        {{-- JS for dropdown status button --}}
        <script src="{{ asset('admin_temp/vendors/base/popper.min.js') }}"></script>
        <script src="{{ asset('admin_temp/vendors/base/bootstrap.min.js') }}"></script>
    @endpush
@endsection
