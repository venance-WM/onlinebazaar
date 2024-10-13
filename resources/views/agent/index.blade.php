@extends('layouts.admin_app')
@section('content')
    {{-- <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="me-md-3 me-xl-5">
                        <h2>Welcome back,</h2>
                        <p class="mb-md-0">Analysis of system</p>
                    </div>
                    <div class="d-flex">
                        <i class="mdi mdi-view-dashboard text-muted hover-cursor"></i>
                        <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                        <p class="text-primary mb-0 hover-cursor">Analysis</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                    <button type="button" class="btn btn-light bg-white btn-icon me-3 d-none d-md-block ">
                        null
                    </button>
                    <button class="btn btn-primary mt-2 mt-xl-0">system errors report</button>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container">
        <h1 class="text-center">Agent Dashboard</h1>

        <div class="row">
            <!-- Total Registered Sellers -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Registered Sellers</h5>
                        <p class="card-text text-center">{{ $totalSellers }}</p>
                        <!-- Link inside card, below content -->
                        <a href="{{ route('agent.sellers') }}" class="btn btn-primary mt-3 d-block text-center">View</a>
                    </div>
                </div>
            </div>

            <!-- Total Products/Services Added -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Products/Services Added</h5>
                        <p class="card-text text-center">{{ $totalProducts }}</p>
                        <!-- Link inside card, below content -->
                        <a href="{{ route('agent.products') }}" class="btn btn-primary mt-3 d-block text-center">View</a>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pending Approvals</h5>
                        <p class="card-text text-center">{{ $pendingApprovals }}</p>
                        <!-- Link inside card, below content -->
                        <a href="{{ route('agent.pending-approvals') }}" class="btn btn-primary mt-3 d-block text-center">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('login-alert'))
        @push('styles')
            <link rel="stylesheet" href="{{ asset('admin_temp/vendors/base/sweetalert2.min.css') }}">
        @endpush

        @push('script')
            <script src="{{ asset('admin_temp/vendors/base/sweetalert2.all.min.js') }}"></script>
            @if (session('login-alert'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Change your password',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            html: `
                                  <input id="password" type="password" class="swal2-input" placeholder="New Password">
                                  <input id="confirm-password" type="password" class="swal2-input" placeholder="Confirm New Password">
                                  `,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Change Password',
                            cancelButtonText: 'Logout',
                            showCancelButton: true,
                            preConfirm: () => {
                                const password = document.getElementById('password').value;
                                const confirmPassword = document.getElementById('confirm-password').value;

                                if (!password || !confirmPassword) {
                                    Swal.showValidationMessage(
                                        'Please enter both password and confirm password fields');
                                    return false;
                                }

                                if (password !== confirmPassword) {
                                    Swal.showValidationMessage('Passwords do not match');
                                    return false;
                                }

                                return {
                                    password
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const password = result.value.password;

                                // Send AJAX request to update password
                                $.ajax({
                                    url: '{{ route('custom.password.update') }}',
                                    type: 'POST',
                                    data: {
                                        current_password: '{{ __(123456) }}',
                                        password: password,
                                        password_confirmation: password,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        if (response.message) {
                                            Swal.fire('Success', response.message +
                                                    ' Now you can login with your new password.', 'success')
                                                .then(() => {
                                                    location
                                                        .reload();
                                                });
                                        } else {
                                            Swal.fire('Error', 'An error occurred while updating password',
                                                'error');
                                        }
                                    },
                                    error: function(xhr) {
                                        let message = 'An error occurred while updating password';
                                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                                            message = Object.values(xhr.responseJSON.errors).flat().join(
                                                ' ');
                                        }
                                        Swal.fire('Error', message, 'error');
                                    }
                                });
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                document.getElementById('logout').submit();
                            }
                        });
                    });
                </script>
            @endif
        @endpush
    @endif
@endsection
