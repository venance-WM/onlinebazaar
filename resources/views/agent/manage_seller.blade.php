@extends('layouts.admin_app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-10">
                        <h4 class="card-title">Manage Sellers</h4>
                        <p class="card-description">
                            Here you can manage all the sellers you registered. You can request to add, edit, or delete
                            sellers as needed.
                        </p>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('create_seller') }}" class="btn btn-primary">Add New Seller</a>
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
                                        <span
                                            class="badge badge-pill @switch($seller->status)
                                            @case('enabled')
                                                bg-success
                                                @break
                                            @case('disabled')
                                                bg-secondary
                                                @break
                                            @case('pending')
                                                bg-warning text-dark
                                                @break
                                            @default
                                                bg-danger
                                        @endswitch">
                                            {{ ucfirst($seller->status) }}
                                        </span>


                                    </td>
                                    <td>
                                        <!-- Edit Seller -->
                                        <a href="{{ route('edit_seller', $seller->id) }}"
                                            class="btn btn-primary btn-sm">Edit</a>

                                        <!-- Delete Seller -->
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
                        // Delete seller modal
                        $(document).on('click', '.delete-seller', function(e) {
                            e.preventDefault();
                            var sellerId = $(this).data('id');
                            var sellerName = $(this).data('name');

                            Swal.fire({
                                title: "Request to Delete Seller?",
                                text: "Once the request to delete " + sellerName + " is approved, you won't be able to revert this!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#808080",
                                confirmButtonText: "Yes, request DELETE!"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: "{{ url('agent/sellers') }}/" + sellerId,
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
