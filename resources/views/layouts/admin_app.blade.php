<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Online baazar</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('admin_temp/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_temp/vendors/base/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('admin_temp/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('admin_temp/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @stack('styles')

</head>

<body>
    <div class="container-scroller">
        @include('layouts.inc_admin.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('layouts.inc_admin.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024
                            online baazar </span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Only the best Sallers
                            of all products online</span>
                    </div>
                </footer>
            </div>

        </div>

    </div>

    <!-- plugins:js -->
    <script src="{{ asset('admin_temp/vendors/base/vendor.bundle.base.js') }}"></script>

    <script src="{{ asset('admin_temp/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin_temp/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>

    <!-- inject:js -->
    <script src="{{ asset('admin_temp/js/off-canvas.js') }} "></script>
    <script src="{{ asset('admin_temp/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin_temp/js/template.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('admin_temp/js/dashboard.js') }}"></script>
    <script src="{{ asset('admin_temp/js/data-table.js') }}"></script>
    <script src="{{ asset('admin_temp/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin_temp/js/dataTables.bootstrap4.js') }}"></script>
    @yield('script')
    @stack('script')
    <!-- End custom js for this page-->
</body>

</html>
