@extends('layouts.admin_app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-10">
                        <h4 class="card-title">Manage sellers</h4>
                        <p class="card-description">
                            Here you can manage all the registered sellers. You can add, edit, or delete sellers as needed.
                        </p>
                    </div>
                </div>

                {{-- Alert message for error or success --}}
                @include('partials.validation_message')

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Seller Name</th>
                                <th>Business Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sellers as $seller)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $seller->name }}</td>
                                    <td>{{ $seller->sellerDetail->business_name ?? 'N/A' }}</td>
                                    <td>{{ $seller->email }}</td>
                                    <td>{{ $seller->phone }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                class="btn @switch($seller->status)
                                                @case('enabled')
                                                    btn-success
                                                    @break
                                                @case('disabled')
                                                    btn-secondary
                                                    @break
                                                @case('pending')
                                                    btn-warning
                                                    @break                                            
                                                @default
                                                    btn-danger                                                    
                                            @endswitch btn-sm dropdown-toggle"
                                                id="status-{{ $seller->id }}" data-toggle="dropdown" aria-expanded="false"
                                                aria-haspopup="true">
                                                {{ ucfirst($seller->status) }}
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="status-{{ $seller->id }}">
                                                <a class="dropdown-item change-status" href="#"
                                                    data-id="{{ $seller->id }}"
                                                    data-status="{{ $seller->status == 'enabled' ? 'disabled' : 'enabled' }}">
                                                    {{ $seller->status == 'enabled' ? 'Disable seller' : 'Enable seller' }}
                                                </a>

                                                @if ($seller->status == 'pending')
                                                    <a class="dropdown-item change-status" href="#"
                                                        data-id="{{ $seller->id }}" data-status="enabled">Review
                                                        seller</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Edit seller -->
                                        <a href="{{ route('edit_seller', $seller->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>

                                        <!-- Delete seller -->
                                        <button class="btn btn-danger btn-sm delete-seller" data-id="{{ $seller->id }}"
                                            data-name="{{ $seller->name }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No sellers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @push('styles')
                    <link rel="stylesheet" href="{{ asset('admin_temp/vendors/base/sweetalert2.min.css') }}">
                @endpush

                @push('script')
                    {{-- SweetAlert modals --}}
                    <script src="{{ asset('admin_temp/vendors/base/sweetalert2.all.min.js') }}"></script>
                    <script>
                        $(document).on('click', '.change-status', function(e) {
                            e.preventDefault();
                            var sellerId = $(this).data('id');
                            var newStatus = $(this).data('status');
                            var statusText = newStatus == 'enabled' ? 'enable' : 'disable';

                            Swal.fire({
                                title: "Are you sure?",
                                text: "You are about to " + statusText + " this seller.",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#808080",
                                confirmButtonText: "Yes, " + statusText + "!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: "{{ url('/manage-sellers') }}/" + sellerId + "/status",
                                        method: 'PUT',
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            status: newStatus
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
                                                    "Failed to update the status. Please try again.",
                                                    "error");
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            Swal.fire("Error!",
                                                "There was an error updating the status. Please try again.",
                                                "error");
                                        }
                                    });
                                }
                            });
                        });

                        // Delete seller modal
                        $(document).on('click', '.delete-seller', function(e) {
                            e.preventDefault();
                            var sellerId = $(this).data('id');
                            var sellerName = $(this).data('name');

                            Swal.fire({
                                title: "Delete seller?",
                                text: "Once you delete seller " + sellerName + ", you won't be able to revert this!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#808080",
                                confirmButtonText: "Yes, delete this seller!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: "{{ url('/manage-sellers') }}/" + sellerId,
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
                                                .reload(); // Reload the page to reflect the changes
                                                });
                                            } else {
                                                Swal.fire("Error!",
                                                    "There was an error deleting the seller. Please try again.",
                                                    "error");
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            Swal.fire("Error!",
                                                "There was an error deleting the seller. Please try again.",
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
