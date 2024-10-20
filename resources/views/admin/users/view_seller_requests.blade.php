@extends('layouts.admin_app')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-10">
                        <h4 class="card-title">Seller Requests - {{ ucfirst($status) }}</h4>
                        <p class="card-description">
                            Here you can manage all the seller requests. You can approve, decline, or view details.
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
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Type</th>
                                @if (Auth()->user()->role == 0)
                                    <th>Agent</th>
                                @endif
                                <th>Action</th>
                                <th>Status</th>
                                <th>Date Submitted</th>
                                <th>Date Reviewed</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="py-1">
                                        <img src="{{ isset(json_decode($request->data)->profile_photo_path) && json_decode($request->data)->profile_photo_path
                                            ? asset('images/user_profile_images/' . json_decode($request->data)->profile_photo_path)
                                            : (isset($request->seller->profile_photo_path) && $request->seller->profile_photo_path
                                                ? asset('images/user_profile_images/' . $request->seller->profile_photo_path)
                                                : asset('admin_temp/images/faces/user.png')) }}"
                                            alt="image" width="100" />
                                    </td>
                                    <td class="text-nowrap">
                                        @if ($request->status == 'approved' && isset($request->seller))
                                            <a href="{{ route('view_seller', $request->seller->id) }}" class="card-link text-decoration-none">
                                                {{ json_decode($request->data)->name ?? ($request->seller->name ?? 'N/A') }}
                                                <i class="mdi mdi-chevron-right"></i>
                                            </a>
                                        @else
                                            {{ json_decode($request->data)->name ?? ($request->seller->name ?? 'N/A') }}
                                        @endif
                                    </td>
                                    
                                    <td>{{ ucfirst(json_decode($request->data)->business_type ?? ($request->seller->sellerDetail->business_type ?? 'N/A')) }}
                                    </td>

                                    @if (Auth()->user()->role == 0)
                                        <td>{{ $request->agent->name ?? 'Deleted Agent' }}</td>
                                    @endif
                                    <td>{{ ucfirst($request->action) }}</td>
                                    <td>
                                        <span
                                            class="badge badge-pill bg-{{ $request->status == 'approved' ? 'success' : ($request->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $request->created_at->format('d M, Y') }}</td>
                                    <td>{{ $request->updated_at->format('d M, Y') }}</td>

                                    <td class="text-nowrap">
                                        @if (Auth()->user()->role == 0)
                                            @if ($request->status == 'pending')
                                                <a href="{{ route('admin.sellers.review', $request->id) }}"
                                                    class="btn btn-primary btn-sm">Review</a>

                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="confirmAction('{{ route('admin.handle.seller.request', $request->id) }}', 'approve')">Approve</button>

                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmAction('{{ route('admin.handle.seller.request', $request->id) }}', 'decline')">Decline</button>
                                            @elseif ($request->status == 'approved')
                                                <!-- Edit seller -->
                                                <a href="{{ route('edit_seller', $request->seller_id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>

                                                <!-- Delete seller -->
                                                <button class="btn btn-danger btn-sm delete-seller"
                                                    data-id="{{ $request->seller_id }}"
                                                    data-name="{{ $request->seller->name ?? 'N/A' }}">
                                                    Delete
                                                </button>
                                            @else
                                                <a href="{{ route('admin.sellers.review', $request->id) }}"
                                                    class="btn btn-primary btn-sm">View</a>
                                            @endif
                                        @endif
                                        @if (Auth()->user()->role == 1)
                                            @if (isset($request->seller_id) && $request->status != 'pending')
                                                <!-- Request Edit seller -->
                                                <a href="{{ route('edit_seller', $request->seller_id) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                @if ($request->status != 'declined')
                                                    <!-- Request Delete seller -->
                                                    <button class="btn btn-danger btn-sm delete-seller"
                                                        data-id="{{ $request->seller_id }}"
                                                        data-name="{{ $request->seller->name ?? 'N/A' }}">
                                                        Delete
                                                    </button>
                                                @endif
                                            @else
                                                <a href="{{ route('view_seller_request', $request->id) }}"
                                                    class="btn btn-primary btn-sm">View</a>

                                                <button class="btn btn-danger btn-sm delete-request"
                                                    data-id="{{ $request->id }}"
                                                    data-name="{{ json_decode($request->data)->name ?? $request->seller->name }}"
                                                    data-request="{{ ucfirst($request->action) }}">
                                                    Cancel Request
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center fs-6">No {{ $status }} seller requests.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('admin_temp/vendors/base/sweetalert2.min.css') }}">
    @endpush

    @push('script')
        {{-- SweetAlert modals --}}
        <script src="{{ asset('admin_temp/vendors/base/sweetalert2.all.min.js') }}"></script>
        @if (Auth::user()->role == 0)
            <script>
                function confirmAction(url, action) {
                    let actionText = action === 'approve' ? 'Approve' : 'Decline';
                    let buttonColor = action === 'approve' ? '#28a745' : '#dc3545';

                    Swal.fire({
                        title: `Are you sure?`,
                        text: `You are about to ${actionText.toLowerCase()} this request.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: buttonColor,
                        cancelButtonColor: '#808080',
                        confirmButtonText: `Yes, ${actionText}!`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let form = document.createElement('form');
                            form.action = url;
                            form.method = 'POST';
                            form.innerHTML = `
                            @csrf
                            <input type="hidden" name="action" value="${action}">
                        `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }

                $(document).on('click', '.delete-seller', function(e) {
                    e.preventDefault();
                    var sellerId = $(this).data('id');
                    var sellerName = $(this).data('name');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You are about to delete " + sellerName + ".",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#808080",
                        confirmButtonText: "Yes, delete!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/agent/sellers/delete/${sellerId}`, // Pass the sellerId here
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    seller_id: sellerId
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire('Deleted!', response.message, 'success').then(() => {
                                            location.reload();
                                        });
                                    }
                                },
                                error: function(response) {
                                    Swal.fire('Error!', 'Failed to delete seller.', 'error');
                                }
                            });
                        }
                    });
                });
            </script>
        @endif
    @endpush
@endsection
