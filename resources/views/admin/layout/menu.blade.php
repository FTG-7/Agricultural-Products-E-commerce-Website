<div class="wrapper">

    <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">

            <div class="logo-header" data-background-color="dark">
                <a href="{{ route('index') }}" class="logo">
                    {{-- <img
                        src="assets/img/kaiadmin/logo_light.svg"
                        alt="navbar brand"
                        class="navbar-brand"
                        height="20" /> --}}
                    <h1 class="custom-title">SunFresh</h1>
                    <style>
                        .custom-title {
                            color: white;
                            /* Màu chữ */
                            text-shadow:
                                -1px -1px 0 #ffb524,
                                1px -1px 0 #ffb524,
                                -1px 1px 0 #ffb524,
                                1px 1px 0 #ffb524;
                            /* Tạo viền chữ bằng cách sử dụng bóng chữ */
                        }
                    </style>
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>

        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <ul class="nav nav-secondary">
                    <li class="nav-item active">

                        <a href="#" class="collapsed" aria-expanded="false">
                            <i class="fas fa-address-card"></i>

                            @if (Auth::user()->quyen === 'admin')
                                <p>Quản lý</p>
                            @elseif (Auth::user()->quyen === 'nv')
                                <p>Nhân viên</p>
                            @endif
                           
                        </a>
                       
                         
                    </li>
                    <li class="nav-item ">

                    
                        <a href="{{ route('index') }}" class="collapsed" aria-expanded="false">
                            <i class="fas fa-home"></i>

                         <p>Trang mua hàng</p>
                      
                        </a>
                         
                    </li>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Tùy chọn</h4>
                    </li>
                    {{-- <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#base">
                            <i class="fas fa-layer-group"></i>
                            <p>Base</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="base">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="components/avatars.html">
                                        <span class="sub-item">Avatars</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="components/buttons.html">
                                        <span class="sub-item">Buttons</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="components/gridsystem.html">
                                        <span class="sub-item">Grid System</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="components/panels.html">
                                        <span class="sub-item">Panels</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="components/notifications.html">
                                        <span class="sub-item">Notifications</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="components/sweetalert.html">
                                        <span class="sub-item">Sweet Alert</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="components/font-awesome-icons.html">
                                        <span class="sub-item">Font Awesome Icons</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="components/simple-line-icons.html">
                                        <span class="sub-item">Simple Line Icons</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="components/typography.html">
                                        <span class="sub-item">Typography</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                    @if (Auth::user()->quyen === 'admin')
                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarLayouts">
                                <i class="fas fa-th-list"></i>
                                <p>Quản lý tài khoản</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="sidebarLayouts">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="{{ route('admin.KhachHang.index') }}">
                                            <span class="sub-item">Quản lý khách hàng</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.NhanVien.index') }}">
                                            <span class="sub-item">Quản lý nhân viên</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.Admin.index') }}">
                                            <span class="sub-item">Quản lý quyền</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a data-bs-toggle="collapse" href="#forms">
                                <i class="fas fa-th-list"></i>
                                <p>Quản lý cửa hàng</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="forms">
                                <ul class="nav nav-collapse">

                                    <li>
                                        <a href="{{ route('admin.KhuyenMai.index') }}">
                                            <span class="sub-item">Quản lý khuyến mãi</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.PhieuNhap.show') }}">
                                            <span class="sub-item">Quản lý phiếu nhập</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('admin.SanPham.admin_index') }}">
                                            <span class="sub-item">Quản lý sản phẩm</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.SanPham.quantity_index') }}">
                                            <span class="sub-item">Quản lý số lượng</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#tables">
                            {{-- <i class="fas fa-table"></i> --}}
                            <i class="fas fa-file"></i>
                            <p>Quản lý đơn</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="tables">
                            <ul class="nav nav-collapse">
                                @if (Auth::user()->quyen === 'admin')
                                    <li>
                                        <a href="{{ route('admin.QLDoiTra.index') }}">
                                            <span class="sub-item">Quản lý đơn đổi trả</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.QLDonHang.index') }}">
                                            <span class="sub-item">Quản lý đơn hàng</span>
                                        </a>
                                    </li>
                                @endif

                                @if (Auth::user()->quyen === 'nv')
                                    <li>
                                        <a href="{{ route('nv.QLDoiTra.shipindex') }}">
                                            <span class="sub-item">Quản lý đơn đổi trả</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('nv.QLDonHang.shipindex') }}">
                                            <span class="sub-item">Quản lý đơn hàng</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    {{-- <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#maps">
                            <i class="fas fa-map-marker-alt"></i>
                            <p>Maps</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="maps">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="maps/googlemaps.html">
                                        <span class="sub-item">Google Maps</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="maps/jsvectormap.html">
                                        <span class="sub-item">Jsvectormap</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                    @if (Auth::user()->quyen === 'admin')
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#charts">
                            <i class="far fa-chart-bar"></i>
                            <p>Thống kê</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="charts">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('admin.ThongKe.index') }}">
                                        <span class="sub-item">Thống kê</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="charts/sparkline.html">
                                        <span class="sub-item">Sparkline</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>
                    @endif


                    <li class="nav-item">
                        <a href="{{ route('admin.SanPham.sphh_index') }}">
                            <i class="fas fa-desktop"></i>
                            <p>Sản phẩm hết hạn</p>
                            <span class="badge badge-success"></span>
                        </a>
                    </li>
                    
                    {{-- <li class="nav-item">
                        <a href="widgets.html">
                            <i class="fas fa-desktop"></i>
                            <p>Widgets</p>
                            <span class="badge badge-success">4</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../../documentation/index.html">
                            <i class="fas fa-file"></i>
                            <p>Documentation</p>
                            <span class="badge badge-secondary">1</span>
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#submenu">
                            <i class="fas fa-bars"></i>
                            <p>Menu Levels</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="submenu">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a data-bs-toggle="collapse" href="#subnav1">
                                        <span class="sub-item">Level 1</span>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse" id="subnav1">
                                        <ul class="nav nav-collapse subnav">
                                            <li>
                                                <a href="#">
                                                    <span class="sub-item">Level 2</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="sub-item">Level 2</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a data-bs-toggle="collapse" href="#subnav2">
                                        <span class="sub-item">Level 1</span>
                                        <span class="caret"></span>
                                    </a>
                                    <div class="collapse" id="subnav2">
                                        <ul class="nav nav-collapse subnav">
                                            <li>
                                                <a href="#">
                                                    <span class="sub-item">Level 2</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="sub-item">Level 1</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>


    <div class="main-panel">
        <div class="main-header">
            <div class="main-header-logo">

                <div class="logo-header" data-background-color="dark">
                    <a href="index.html" class="logo">
                        <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
                            height="20" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>

            </div>

            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    {{-- <nav
                        class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="submit" class="btn btn-search pe-1">
                                    <i class="fa fa-search search-icon"></i>
                                </button>
                            </div>
                            <input
                                type="text"
                                placeholder="Search ..."
                                class="form-control" />
                        </div>
                    </nav> --}}

                    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                        {{-- <li class="nav-item topbar-icon dropdown hidden-caret">
                            <a
                                class="nav-link"
                                data-bs-toggle="dropdown"
                                href="#"
                                aria-expanded="false">
                                <i class="fas fa-layer-group"></i>
                            </a>
                            <div class="dropdown-menu quick-actions animated fadeIn">
                                <div class="quick-actions-header">
                                    <span class="title mb-1">Quick Actions</span>
                                    <span class="subtitle op-7">Shortcuts</span>
                                </div>
                                <div class="quick-actions-scroll scrollbar-outer">
                                    <div class="quick-actions-items">
                                        <div class="row m-0">
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <div class="avatar-item bg-danger rounded-circle">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </div>
                                                    <span class="text">Calendar</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <div
                                                        class="avatar-item bg-warning rounded-circle">
                                                        <i class="fas fa-map"></i>
                                                    </div>
                                                    <span class="text">Maps</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <div class="avatar-item bg-info rounded-circle">
                                                        <i class="fas fa-file-excel"></i>
                                                    </div>
                                                    <span class="text">Reports</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <div
                                                        class="avatar-item bg-success rounded-circle">
                                                        <i class="fas fa-envelope"></i>
                                                    </div>
                                                    <span class="text">Emails</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <div
                                                        class="avatar-item bg-primary rounded-circle">
                                                        <i class="fas fa-file-invoice-dollar"></i>
                                                    </div>
                                                    <span class="text">Invoice</span>
                                                </div>
                                            </a>
                                            <a class="col-6 col-md-4 p-0" href="#">
                                                <div class="quick-actions-item">
                                                    <div
                                                        class="avatar-item bg-secondary rounded-circle">
                                                        <i class="fas fa-credit-card"></i>
                                                    </div>
                                                    <span class="text">Payments</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li> --}}

                        <li class="nav-item topbar-user dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                                aria-expanded="false">
                                {{-- <div class="avatar-sm">
                                    <img src="assets/img/profile.jpg" alt="..."
                                        class="avatar-img rounded-circle" />
                                </div> --}}
                                <span class="profile-username">
                                    <span class="op-7">Chào,</span>
                                    <span class="fw-bold">{{ Auth::user()->hoten }}</span>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg">
                                                <img src="/imgsp/NoAvata.jpg" alt="image profile"
                                                    class="avatar-img rounded" />
                                            </div>
                                            <div class="u-text">
                                                <h4>{{ Auth::user()->hoten }}</h4>
                                                <p class="text-muted">{{ Auth::user()->email }}</p>
                                                <a href="{{ route('show-profile') }}"
                                                    class="btn btn-xs btn-secondary btn-sm" style="color: white">Thông
                                                    tin tài khoản</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('show_changepassword') }}">Đổi mật
                                            khẩu</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}">Đăng xuất</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

        </div>
