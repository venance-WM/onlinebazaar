<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
            <a class="navbar-brand brand-logo"
                href="
        @if (Auth::user()->role == 0) {{ route('admin.dashboard') }}
          @elseif (Auth::user()->role == 1)
              {{ route('agent.dashboard') }}
          @elseif (Auth::user()->role == 2)
              {{ route('seller.dashboard') }}
          @else
              {{ route('home') }} @endif ">
                <small>Online Baazar</small>
            </a>

            <a class="navbar-brand brand-logo-mini" href="#">
                <img src="{{ asset('home_temp/img/logo1.png') }}" alt="logo" class="rounded-circle" width="50px" />
            </a>
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-sort-variant"></span>
            </button>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <span class="text-center d-block">
            @if (Auth::check() && Auth::user()->role == 0)
                Welcome! Admin,
            @elseif (Auth::check() && Auth::user()->role == 1)
                Welcome! Agent,
            @elseif (Auth::check() && Auth::user()->role == 2)
                Welcome! Seller,
            @endif
            <strong class="text-uppercase">{{ Auth::user()->name }} .</strong>
        </span>
        <ul class="navbar-nav navbar-nav-right">
            @if (Auth::User()->role == 0)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.notifications') }}">
            <i class="mdi mdi-bell-outline menu-icon"></i>
            <span class="menu-title">Notifications</span>
        </a>
    </li>
@endif

                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                            <img src="{{ Auth::user()->profile_photo_path != null ? asset('images/user_profile_images/' . Auth::user()->profile_photo_path) : asset('admin_temp/images/faces/user.png') }}" style="object-fit: cover;" alt="profile 1" />
                            <span class="nav-profile-name">{{ Auth::user()->name }}</span>
                        </a>
                        
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    {{-- <a class="dropdown-item" href="#">
              <i class="mdi mdi-settings text-primary"></i>
              Settings
            </a> --}}
                    <form id="logout" action="{{ route('logout') }}" method="POST">
                        <a role="button" class="dropdown-item" onclick="document.getElementById('logout').submit();">
                            <i class="mdi mdi-logout text-primary"></i>
                            Logout</a>
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
