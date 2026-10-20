<div class="container-fluid fixed-top">
    <div class="container topbar bg-primary d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#"
                        class="text-white">140 Đ. Lê Trọng Tấn, Tây Thạnh, Tân Phú, Thành phố Hồ Chí Minh</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#"
                        class="text-white">info@huit.edu.vn</a></small>
                <small class="me-3"><i class="fas fa-phone me-2 text-secondary"></i><a href="#"
                        class="text-white">0283 8163 318</a></small>
            </div>
        </div>
    </div>
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="{{ route('index') }}" class="navbar-brand">
                <h1 class="text-primary display-6">SunFresh</h1>
            </a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">

                    <a href="{{ route('index') }}" class="nav-item nav-link active">Trang chủ</a>
                    
                    <a href="{{ route('user.ds_SanPham.show_product') }}" class="nav-item nav-link">Sản phẩm</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Loại sản phẩm</a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            @foreach ($LoaiSP as $type)
                                <a href="{{ route('user.ds_SanPham.show_product', $type->idloai) }}" class="dropdown-item">{{ $type->tenloai }}</a>
                            @endforeach
                        </div>
                    </div>
                    @if (Auth::check())
                        @if (Auth::user()->quyen === 'nv' || Auth::user()->quyen === 'admin')
                            <a href="{{ route('adminindex') }}" class="nav-item nav-link">Quản lý</a>
                        @endif
                    @endif
                    <a href="{{ route('user.ds_SanPham.AboutUs') }}" class="nav-item nav-link">Giới Thiệu</a>
                </div>
                <div class="d-flex m-3 me-0">
                    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4"
                        data-bs-toggle="modal" data-bs-target="#searchModal"><i
                            class="fas fa-search text-primary"></i></button>
                    
                    
                    @if (Auth::check())
                        @if (Auth::user()->quyen == 'admin' || Auth::user()->quyen == 'nv' )
                        @else
                            <a href="{{ route('cart.index') }}" class="position-relative me-4 my-auto">
                                <i class="fa fa-shopping-cart fa-2x"></i>
                                {{-- <span
                                    class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                    style="top: -5px; left: 15px; height: 20px; min-width: 20px;">S</span> --}}
                            </a>
                        @endif
                    @endif

                    @if (Auth::check())
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle"
                                data-bs-toggle="dropdown">{{ Auth::user()->hoten }}</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="{{ route('show-profile') }}" class="dropdown-item">Thông tin tài khoản</a>
                                @if (Auth::user()->quyen === 'kh')
                                    <a href="{{ route('MuaHang.showdonhang') }}" class="dropdown-item">Đơn hàng</a>
                                    <a href="{{ route('doitra.index') }}" class="dropdown-item">Lịch sử đổi trả</a>
                                @endif
                                <a href="{{ route('show_changepassword') }}" class="dropdown-item">Đổi mật khẩu</a>
                                <a href="{{ route('logout') }}" class="dropdown-item">Đăng xuất</a>

                            </div>
                        </div>
                    @else
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Tài
                                khoản</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="{{ route('show-login') }}" class="dropdown-item">Đăng nhập</a>
                                <a href="{{ route('show-register') }}" class="dropdown-item">Đăng ký</a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->


<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tìm kiếm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="input-group w-75 mx-auto d-flex">
                    <form action="{{ route('user.ds_SanPham.show_product') }}" method="GET" class="form-control p-3 d-flex">
                        <input type="search" class="form-control p-3" name="search" placeholder="Tên sản phẩm"
                            aria-describedby="search-icon-1">
                        <button type="submit" id="search-icon-1" class="input-group-text p-3"
                            style="margin-left: 5px;"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->
