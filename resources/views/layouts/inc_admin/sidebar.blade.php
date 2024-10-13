<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link"
                href="
        @if (Auth::user()->role == 0) {{ route('admin.dashboard') }}
          @elseif (Auth::user()->role == 1)
              {{ route('agent.dashboard') }}
          @elseif (Auth::user()->role == 2)
              {{ route('seller.dashboard') }}
          @else
              {{ route('home') }} {{-- Redirect to a default route if no role matches --}} @endif
              ">
                <i class="mdi mdi-view-dashboard menu-icon "></i>
                <span class="menu-title text-primary mb-0 hover-cursor">Dashboard</span>
            </a>
        </li>
        @if (Auth::user()->role == 2)
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
            <i class="mdi mdi-clipboard-check menu-icon"></i>
            <span class="menu-title">Orders</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
                @php
                    // Get the seller's business type from the seller_details table
                    $sellerDetails = DB::table('seller_details')
                        ->where('user_id', Auth::user()->id)
                        ->first();
                @endphp

                @if ($sellerDetails && $sellerDetails->business_type == 'seller')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.orders.index') }}">Products</a>
                    </li>
                @endif

                @if ($sellerDetails && $sellerDetails->business_type == 'service')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('service-orders') }}">Services</a>
                    </li>
                @endif
            </ul>
        </div>
    </li>
@endif

        @if (Auth::User()->role == 1)
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#category-menu" aria-expanded="false"
                    aria-controls="category-menu">
                    <i class="mdi mdi-circle-outline menu-icon"></i>
                    <span class="menu-title">Category</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="category-menu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="{{ route('agent.categories.create') }}">Add
                                category</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{ route('agent.categories.index') }}">View
                                category</a></li>
                    </ul>
                </div>
            </li>
        @endif

        @if (Auth::User()->role == 2)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('seller.customers') }}">
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                    <span class="menu-title">My Customers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('seller.reviews') }}">
                    <i class="mdi mdi-comment-multiple menu-icon"></i>
                    <span class="menu-title">My Reviews</span>
                </a>
            </li>
        @endif

        @if (Auth::User()->role == 0)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.agents.manage') }}">
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                    <span class="menu-title">Manage Agents</span>
                </a>
            </li>
        @endif

        @if (Auth::User()->role == 0 || Auth::User()->role == 1)
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#manage-seller-menu" aria-expanded="false"
                    aria-controls="manage-seller-menu">
                    <i class="mdi mdi-store menu-icon"></i>
                    <span class="menu-title">Manage Sellers</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="manage-seller-menu">
                    <ul class="nav flex-column sub-menu">
                        @if (Auth::User()->role == 1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('create_seller') }}">
                                    Register Seller
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route(Auth::user()->role == 0 ? 'admin.sellers.pending' : 'pending_sellers') }}">Pending
                                Sellers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route(Auth::user()->role == 0 ? 'admin.sellers.approved' : 'approved_sellers') }}">Approved
                                Sellers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route(Auth::user()->role == 0 ? 'admin.sellers.declined' : 'declined_sellers') }}">Declined
                                Sellers</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#manage-products-menu" aria-expanded="false"
                    aria-controls="manage-products-menu">
                    <i class="mdi mdi-package menu-icon"></i>
                    <span class="menu-title">Manage Products</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="manage-products-menu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route(Auth::user()->role == 0 ? 'admin.products.approval' : 'agent.products.pending') }}">Pending
                                Requests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route(Auth::user()->role == 0 ? 'admin.products.approved' : 'agent.products.approved') }}">Approved
                                Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route(Auth::user()->role == 0 ? 'admin.rejected.products' : 'agent.rejected.products') }}">Rejected
                                Products</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#manage-services-menu" aria-expanded="false"
                    aria-controls="manage-services-menu">
                    <i class="mdi mdi-briefcase menu-icon"></i>
                    <span class="menu-title">Manage Services</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="manage-services-menu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route(Auth::user()->role == 0 ? 'admin.service.requests' : 'agent.service.requests') }}">Pending
                                Requests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route(Auth::user()->role == 0 ? 'admin.approvedServices' : 'agent.approvedServices') }}">Approved
                                Services </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route(Auth::user()->role == 0 ? 'agent.declinedServices' : 'agent.declinedServices') }}">Rejected
                                Services </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        @if (in_array(Auth::user()->role, [0, 1, 2]))
            <!-- Settings Menu -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#settings-menu" aria-expanded="false"
                    aria-controls="settings-menu">
                    <i class="mdi mdi-settings menu-icon"></i>
                    <span class="menu-title">Settings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="settings-menu">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="@if (Auth::user()->role == 0) {{ route('admin.settings.profile-details') }} @elseif (Auth::user()->role == 1) {{ route('agent.settings.profile-details') }} @else {{ route('seller.settings.profile-details') }} @endif">
                                Profile Details
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Back Home Menu -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="mdi mdi-arrow-left-bold-circle menu-icon"></i>
                    <span class="menu-title">Back home</span>
                </a>
            </li>

            <!-- Documentation Menu -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('documentation') }}">
                    <i class="mdi mdi-file-document-box-outline menu-icon"></i>
                    <span class="menu-title">Documentation</span>
                </a>
            </li>
        @endif




    </ul>
</nav>
