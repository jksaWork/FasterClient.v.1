<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('uploads/logos/0EyBMQAgQEoGz9JMOGGsXlzCT5l85M83DPPq8Wkp.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('uploads/logos/0EyBMQAgQEoGz9JMOGGsXlzCT5l85M83DPPq8Wkp.png')}}" width="50" height="50" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('profile') }}" class="d-block">{{auth()->user()->fullname}}</a>
            </div>
        </div>
        <!-- SidebarSearch Form -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-chart-line"></i>
                        <p>
                                Dashboard
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        {{-- <i class="fa fa-arrow-up-short-wide"></i> --}}
                        <p>
                            Orders
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('addOrder') }}" class="nav-link  {{ request()->routeIs('addOrder') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Order</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('OrderHistory')}}" class="nav-link {{ request()->routeIs('OrderHistory') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Orders Histroy</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('orderTraking')}}" class="nav-link {{ request()->routeIs('orderTraking') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Orders Traking</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
