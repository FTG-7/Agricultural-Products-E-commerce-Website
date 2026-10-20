@extends('user.layout.master')

@Section('content')
    <!-- Hero Section Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">100% Sản phẩm sạch</h4>
                    <h1 class="mb-3 display-3 text-primary">Rau củ & Trái cây</h1>
                    <h1 class="mb-3 display-3 text-primary">Thịt cá</h1>
                    <div class="position-relative mx-auto">
                        <form action="{{ route('user.ds_SanPham.show_product') }}" method="GET">
                            <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="search"
                                name="search" placeholder="Tên sản phẩm">
                            <button type="submit"
                                class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100"
                                style="top: 0; right: 25%;">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId1" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="inc/img/hero-img-1.png" class="img-fluid w-100 h-100 bg-secondary rounded"
                                    alt="First slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Trái cây</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="inc/img/hero-img-2.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Rau củ</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="inc/img/hero-img-3.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Thịt cá</a>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId1"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId1"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Featurs Section Start -->
    <div class="container-fluid featurs ">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-car-side fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Miễn phí giao hàng</h5>
                            <p class="mb-0">Miễn phí với hóa đơn trên 100.000đ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-user-shield fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Bảo mật thông tin</h5>
                            <p class="mb-0">100% bảo mật thông tin khách hàng</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-exchange-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Sản phẩm an toàn</h5>
                            <p class="mb-0">Có chứng nhận an toàn thực phẩm</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fa fa-phone-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Hỗ trợ 24/7</h5>
                            <p class="mb-0">Tận tình hỗ trợ nhanh chóng mọi lúc</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Featurs Section End -->

    <!-- Banner Section Start -->
    <div class="container-fluid banner " style="margin-top: 0px;margin-bottom: 0px; ">
        <div class="container py-5">
            <div id="carouselId2" class="carousel slide position-relative" data-bs-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active rounded" style="height: 210px">
                        <img src="/banner/banner_1.jpg" class="img-fluid w-100 h-100 bg-secondary rounded"
                            alt="First slide">
                        <!-- <a href="#" class="btn px-4 py-2 text-white rounded">Trái cây</a> -->
                    </div>
                    <div class="carousel-item rounded" style="height: 210px">
                        <img src="/banner/banner_2.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                        <!-- <a href="#" class="btn px-4 py-2 text-white rounded">Rau củ</a> -->
                    </div>
                    <div class="carousel-item rounded" style="height: 210px">
                        <img src="/banner/banner_3.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                        <!-- <a href="#" class="btn px-4 py-2 text-white rounded">Thịt cá</a> -->
                    </div>
                    <div class="carousel-item rounded" style="height: 210px">
                        <img src="/banner/banner_4.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                        <!-- <a href="#" class="btn px-4 py-2 text-white rounded">Thịt cá</a> -->
                    </div>
                    <div class="carousel-item rounded" style="height: 210px">
                        <img src="/banner/banner_5.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                        <!-- <a href="#" class="btn px-4 py-2 text-white rounded">Thịt cá</a> -->
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselId2" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselId2" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <!-- Banner Section End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Sản phẩm mới</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill"
                                    href="#tab-1">
                                    <span class="text-dark" style="width: 130px;">Tất cả</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                    <span class="text-dark" style="width: 130px;">Rau</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                    <span class="text-dark" style="width: 130px;">Trái cây</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-4">
                                    <span class="text-dark" style="width: 130px;">Thịt</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-5">
                                    <span class="text-dark" style="width: 130px;">Thủy sản</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">

                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">

                                    @foreach ($Sanpham as $product)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    @if ($product->anh->isNotEmpty())
                                                        <a
                                                            href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">
                                                            <img src="/imgsp/{{ $product->anh->first()->tenanh }}"
                                                                class="w-100 rounded-top" alt=""
                                                                style="height: 214px;">
                                                        </a>
                                                    @endif
                                                </div>

                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">Mới</div>

                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><a
                                                            href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">{{ $product->tensp }}</a>
                                                    </h4>
                                                    <p>&nbsp&nbspXuất xứ: {{ $product->xuatxu }}</p>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            @php
                                                                $fullStars = floor($product->averageRating); // Số sao đầy
                                                                $hasHalfStar =
                                                                    $product->averageRating - $fullStars >= 0.5; // Có nửa sao hay không
                                                            @endphp

                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $fullStars)
                                                                    <!-- Ngôi sao đầy -->
                                                                    <i class="fa fa-star text-warning"></i>
                                                                @elseif ($hasHalfStar && $i == $fullStars + 1)
                                                                    <!-- Ngôi sao nửa -->
                                                                    <i class="fa fa-star-half-alt text-warning"></i>
                                                                    @php $hasHalfStar = false; @endphp <!-- Xóa trạng thái nửa sao -->
                                                                @else
                                                                    <!-- Ngôi sao trống -->
                                                                    <i class="fa fa-star text-muted"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span class="ms-2">({{ $product->averageRating }} / 5)</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold" style="min-height: 60px;">

                                                            {{-- {{ number_format($product->gia, 0, ',', '.') . 'VNĐ  / ' . $product->donvitinh }} --}}
                                                            @if ($product->discountAmount > 0)
                                                                <span class="text-success"
                                                                    style="font-size: 17px; display: block;">
                                                                    Giá:
                                                                    {{ number_format($product->gia * (1 - $product->discountAmount / 100), 0, ',', '.') }}
                                                                    VNĐ /{{ $product->donvitinh }}
                                                                </span>
                                                                <span style="display: block;  color: red;">
                                                                    <span
                                                                        style="text-decoration: line-through;font-size: 17px;">
                                                                        {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                                                    </span>
                                                                    <span
                                                                        style="display: inline-block; font-size: 15px; background-color: red; color: white; font-weight: bold; padding: 2px 5px; margin-left: 5px; border-radius: 5px;">
                                                                        -{{ $product->discountAmount }}%
                                                                    </span>

                                                                </span>
                                                            @else
                                                                <span class="text-success"
                                                                    style="font-size: 17px; float: left;">
                                                                    Giá: {{ number_format($product->gia, 0, ',', '.') }}
                                                                    VNĐ /{{ $product->donvitinh }}
                                                                </span>
                                                            @endif
                                                            @if ($product->increasedProductName)
                                                                <span style="font-size: 17px; display: block; color: red;">
                                                                    {{ $product->increasedProductName }}
                                                                </span>
                                                            @endif
                                                        </p>

                                                        @if (Auth::check())
                                                            @if (Auth::user()->quyen == 'admin' || Auth::user()->quyen == 'nv' )
                                                                <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}"
                                                                    class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                    Chi tiết sản phẩm
                                                                </a>
                                                            @else
                                                                @if ($product->soluong == 0)
                                                                    <span class="btn btn-secondary rounded-pill px-3">Hết
                                                                        hàng</span>
                                                                @else 
                                                                    <a href="{{ route('cart.add', $product->idsp) }}"
                                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                        <i
                                                                            class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                        Thêm giỏ hàng
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ---------------------------------------------------------------------------------- -->
                    <div id="tab-2" class="tab-pane fade show p-0 ">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @foreach ($SanphamRau as $product)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    @if ($product->anh->isNotEmpty())
                                                        <a
                                                            href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">
                                                            <img src="/imgsp/{{ $product->anh->first()->tenanh }}"
                                                                class="w-100 rounded-top" alt=""
                                                                style="height: 214px;">
                                                        </a>
                                                    @endif
                                                </div>

                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">Mới</div>

                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><a
                                                            href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">{{ $product->tensp }}</a>
                                                    </h4>
                                                    <p>&nbsp&nbspXuất xứ: {{ $product->xuatxu }}</p>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            @php
                                                                $fullStars = floor($product->averageRating); // Số sao đầy
                                                                $hasHalfStar =
                                                                    $product->averageRating - $fullStars >= 0.5; // Có nửa sao hay không
                                                            @endphp

                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $fullStars)
                                                                    <!-- Ngôi sao đầy -->
                                                                    <i class="fa fa-star text-warning"></i>
                                                                @elseif ($hasHalfStar && $i == $fullStars + 1)
                                                                    <!-- Ngôi sao nửa -->
                                                                    <i class="fa fa-star-half-alt text-warning"></i>
                                                                    @php $hasHalfStar = false; @endphp <!-- Xóa trạng thái nửa sao -->
                                                                @else
                                                                    <!-- Ngôi sao trống -->
                                                                    <i class="fa fa-star text-muted"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span class="ms-2">({{ $product->averageRating }} / 5)</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold" style="min-height: 60px;">

                                                            {{-- {{ number_format($product->gia, 0, ',', '.') . 'VNĐ  / ' . $product->donvitinh }} --}}
                                                            @if ($product->discountAmount > 0)
                                                                <span class="text-success"
                                                                    style="font-size: 17px; display: block;">
                                                                    Giá:
                                                                    {{ number_format($product->gia * (1 - $product->discountAmount / 100), 0, ',', '.') }}
                                                                    VNĐ /{{ $product->donvitinh }}
                                                                </span>
                                                                <span style="display: block;  color: red;">
                                                                    <span
                                                                        style="text-decoration: line-through;font-size: 15px;">
                                                                        {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                                                    </span>
                                                                    <span
                                                                        style="display: inline-block; font-size: 12px; background-color: red; color: white; font-weight: bold; padding: 2px 5px; margin-left: 5px; border-radius: 5px;">
                                                                        -{{ $product->discountAmount }}%
                                                                    </span>

                                                                </span>
                                                            @else
                                                                <span class="text-success"
                                                                    style="font-size: 17px;float: left;">
                                                                    Giá: {{ number_format($product->gia, 0, ',', '.') }}
                                                                    VNĐ
                                                                    /{{ $product->donvitinh }}
                                                                </span>
                                                            @endif
                                                            @if ($product->increasedProductName)
                                                                <span style="font-size: 17px; display: block; color: red;">
                                                                    {{ $product->increasedProductName }}
                                                                </span>
                                                            @endif
                                                        </p>




                                                        @if ($product->soluong == 0)
                                                            <span class="btn btn-secondary rounded-pill px-3">Hết
                                                                hàng</span>
                                                        @else
                                                            @if (Auth::check())
                                                                @if (Auth::user()->quyen == 'admin' || Auth::user()->quyen == 'nv')
                                                                    <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}"
                                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                        <i
                                                                            class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                        Chi tiết sản phẩm
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('cart.add', $product->idsp) }}"
                                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                        <i
                                                                            class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                        Thêm giỏ hàng
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane fade show p-0 ">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @foreach ($SanphamTraiCay as $product)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    @if ($product->anh->isNotEmpty())
                                                        <a
                                                            href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">
                                                            <img src="/imgsp/{{ $product->anh->first()->tenanh }}"
                                                                class="w-100 rounded-top" alt=""
                                                                style="height: 214px;">
                                                        </a>
                                                    @endif
                                                </div>

                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">Mới</div>

                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><a
                                                            href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">{{ $product->tensp }}</a>
                                                    </h4>
                                                    <p>&nbsp&nbspXuất xứ: {{ $product->xuatxu }}</p>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            @php
                                                                $fullStars = floor($product->averageRating); // Số sao đầy
                                                                $hasHalfStar =
                                                                    $product->averageRating - $fullStars >= 0.5; // Có nửa sao hay không
                                                            @endphp

                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $fullStars)
                                                                    <!-- Ngôi sao đầy -->
                                                                    <i class="fa fa-star text-warning"></i>
                                                                @elseif ($hasHalfStar && $i == $fullStars + 1)
                                                                    <!-- Ngôi sao nửa -->
                                                                    <i class="fa fa-star-half-alt text-warning"></i>
                                                                    @php $hasHalfStar = false; @endphp <!-- Xóa trạng thái nửa sao -->
                                                                @else
                                                                    <!-- Ngôi sao trống -->
                                                                    <i class="fa fa-star text-muted"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span class="ms-2">({{ $product->averageRating }} / 5)</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold" style="min-height: 60px;">

                                                            {{-- {{ number_format($product->gia, 0, ',', '.') . 'VNĐ  / ' . $product->donvitinh }} --}}
                                                            @if ($product->discountAmount > 0)
                                                                <span class="text-success"
                                                                    style="font-size: 17px; display: block;">
                                                                    Giá:
                                                                    {{ number_format($product->gia * (1 - $product->discountAmount / 100), 0, ',', '.') }}
                                                                    VNĐ /{{ $product->donvitinh }}
                                                                </span>
                                                                <span style="display: block;  color: red;">
                                                                    <span
                                                                        style="text-decoration: line-through;font-size: 15px;">
                                                                        {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                                                    </span>
                                                                    <span
                                                                        style="display: inline-block; font-size: 12px; background-color: red; color: white; font-weight: bold; padding: 2px 5px; margin-left: 5px; border-radius: 5px;">
                                                                        -{{ $product->discountAmount }}%
                                                                    </span>

                                                                </span>
                                                            @else
                                                                <span class="text-success"
                                                                    style="font-size: 17px;float: left;">
                                                                    Giá: {{ number_format($product->gia, 0, ',', '.') }}
                                                                    VNĐ
                                                                    /{{ $product->donvitinh }}
                                                                </span>
                                                            @endif
                                                            @if ($product->increasedProductName)
                                                                <span style="font-size: 17px; display: block; color: red;">
                                                                    {{ $product->increasedProductName }}
                                                                </span>
                                                            @endif
                                                        </p>




                                                        @if ($product->soluong == 0)
                                                            <span class="btn btn-secondary rounded-pill px-3">Hết
                                                                hàng</span>
                                                        @else
                                                            @if (Auth::check())
                                                                @if (Auth::user()->quyen == 'admin' || Auth::user()->quyen == 'nv')
                                                                    <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}"
                                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                        <i
                                                                            class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                        Chi tiết sản phẩm
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('cart.add', $product->idsp) }}"
                                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                        <i
                                                                            class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                        Thêm giỏ hàng
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane fade show p-0 ">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @foreach ($SanphamThit as $product)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    @if ($product->anh->isNotEmpty())
                                                        <a
                                                            href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">
                                                            <img src="/imgsp/{{ $product->anh->first()->tenanh }}"
                                                                class="w-100 rounded-top" alt=""
                                                                style="height: 214px;">
                                                        </a>
                                                    @endif
                                                </div>

                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">Mới</div>

                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><a
                                                            href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">{{ $product->tensp }}</a>
                                                    </h4>
                                                    <p>&nbsp&nbspXuất xứ: {{ $product->xuatxu }}</p>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            @php
                                                                $fullStars = floor($product->averageRating); // Số sao đầy
                                                                $hasHalfStar =
                                                                    $product->averageRating - $fullStars >= 0.5; // Có nửa sao hay không
                                                            @endphp

                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $fullStars)
                                                                    <!-- Ngôi sao đầy -->
                                                                    <i class="fa fa-star text-warning"></i>
                                                                @elseif ($hasHalfStar && $i == $fullStars + 1)
                                                                    <!-- Ngôi sao nửa -->
                                                                    <i class="fa fa-star-half-alt text-warning"></i>
                                                                    @php $hasHalfStar = false; @endphp <!-- Xóa trạng thái nửa sao -->
                                                                @else
                                                                    <!-- Ngôi sao trống -->
                                                                    <i class="fa fa-star text-muted"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span class="ms-2">({{ $product->averageRating }} / 5)</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold" style="min-height: 60px;">

                                                            {{-- {{ number_format($product->gia, 0, ',', '.') . 'VNĐ  / ' . $product->donvitinh }} --}}
                                                            @if ($product->discountAmount > 0)
                                                                <span class="text-success"
                                                                    style="font-size: 17px; display: block;">
                                                                    Giá:
                                                                    {{ number_format($product->gia * (1 - $product->discountAmount / 100), 0, ',', '.') }}
                                                                    VNĐ /{{ $product->donvitinh }}
                                                                </span>
                                                                <span style="display: block;  color: red;">
                                                                    <span
                                                                        style="text-decoration: line-through;font-size: 15px;">
                                                                        {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                                                    </span>
                                                                    <span
                                                                        style="display: inline-block; font-size: 12px; background-color: red; color: white; font-weight: bold; padding: 2px 5px; margin-left: 5px; border-radius: 5px;">
                                                                        -{{ $product->discountAmount }}%
                                                                    </span>

                                                                </span>
                                                            @else
                                                                <span class="text-success"
                                                                    style="font-size: 17px;float: left;">
                                                                    Giá: {{ number_format($product->gia, 0, ',', '.') }}
                                                                    VNĐ
                                                                    /{{ $product->donvitinh }}
                                                                </span>
                                                            @endif
                                                            @if ($product->increasedProductName)
                                                                <span style="font-size: 17px; display: block; color: red;">
                                                                    {{ $product->increasedProductName }}
                                                                </span>
                                                            @endif
                                                        </p>




                                                        @if ($product->soluong == 0)
                                                            <span class="btn btn-secondary rounded-pill px-3">Hết
                                                                hàng</span>
                                                        @else
                                                            @if (Auth::check())
                                                                @if (Auth::user()->quyen == 'admin' || Auth::user()->quyen == 'nv')
                                                                    <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}"
                                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                        <i
                                                                            class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                        Chi tiết sản phẩm
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('cart.add', $product->idsp) }}"
                                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                        <i
                                                                            class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                        Thêm giỏ hàng
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-5" class="tab-pane fade show p-0 ">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @foreach ($SanphamThuySan as $product)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    @if ($product->anh->isNotEmpty())
                                                        <a
                                                            href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">
                                                            <img src="/imgsp/{{ $product->anh->first()->tenanh }}"
                                                                class="w-100 rounded-top" alt=""
                                                                style="height: 214px;">
                                                        </a>
                                                    @endif
                                                </div>

                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">Mới</div>

                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4><a
                                                            href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">{{ $product->tensp }}</a>
                                                    </h4>
                                                    <p>&nbsp&nbspXuất xứ: {{ $product->xuatxu }}</p>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            @php
                                                                $fullStars = floor($product->averageRating); // Số sao đầy
                                                                $hasHalfStar =
                                                                    $product->averageRating - $fullStars >= 0.5; // Có nửa sao hay không
                                                            @endphp

                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $fullStars)
                                                                    <!-- Ngôi sao đầy -->
                                                                    <i class="fa fa-star text-warning"></i>
                                                                @elseif ($hasHalfStar && $i == $fullStars + 1)
                                                                    <!-- Ngôi sao nửa -->
                                                                    <i class="fa fa-star-half-alt text-warning"></i>
                                                                    @php $hasHalfStar = false; @endphp <!-- Xóa trạng thái nửa sao -->
                                                                @else
                                                                    <!-- Ngôi sao trống -->
                                                                    <i class="fa fa-star text-muted"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span class="ms-2">({{ $product->averageRating }} / 5)</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold" style="min-height: 60px;">

                                                            {{-- {{ number_format($product->gia, 0, ',', '.') . 'VNĐ  / ' . $product->donvitinh }} --}}
                                                            @if ($product->discountAmount > 0)
                                                                <span class="text-success"
                                                                    style="font-size: 17px; display: block;">
                                                                    Giá:
                                                                    {{ number_format($product->gia * (1 - $product->discountAmount / 100), 0, ',', '.') }}
                                                                    VNĐ /{{ $product->donvitinh }}
                                                                </span>
                                                                <span style="display: block;  color: red;">
                                                                    <span
                                                                        style="text-decoration: line-through;font-size: 15px;">
                                                                        {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                                                    </span>
                                                                    <span
                                                                        style="display: inline-block; font-size: 12px; background-color: red; color: white; font-weight: bold; padding: 2px 5px; margin-left: 5px; border-radius: 5px;">
                                                                        -{{ $product->discountAmount }}%
                                                                    </span>

                                                                </span>
                                                            @else
                                                                <span class="text-success"
                                                                    style="font-size: 17px;float: left;">
                                                                    Giá: {{ number_format($product->gia, 0, ',', '.') }}
                                                                    VNĐ
                                                                    /{{ $product->donvitinh }}
                                                                </span>
                                                            @endif
                                                            @if ($product->increasedProductName)
                                                                <span style="font-size: 17px; display: block; color: red;">
                                                                    {{ $product->increasedProductName }}
                                                                </span>
                                                            @endif
                                                        </p>




                                                        @if ($product->soluong == 0)
                                                            <span class="btn btn-secondary rounded-pill px-3">Hết
                                                                hàng</span>
                                                        @else
                                                            @if (Auth::check())
                                                                @if (Auth::user()->quyen == 'admin' || Auth::user()->quyen == 'nv')
                                                                    <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}"
                                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                        <i
                                                                            class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                        Chi tiết sản phẩm
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('cart.add', $product->idsp) }}"
                                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                        <i
                                                                            class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                        Thêm giỏ hàng
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid service py-5">
        <div class="container py-5">
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.ds_SanPham.show_product') }}">
                        <div class="service-item bg-secondary rounded border border-secondary">
                            <img src="\imgsp\featur-1.jpg" class="img-fluid rounded-top w-100" alt="">
                            <div class="px-4 rounded-bottom">
                                <div class="service-content bg-primary text-center p-4 rounded">
                                    <h5 class="text-white">Táo Tươi Ngon</h5>
                                    <h3 class="mb-0">Ưu đãi hấp dẫn</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.ds_SanPham.show_product') }}">
                        <div class="service-item bg-dark rounded border border-dark">
                            <img src="\imgsp\featur-2.jpg" class="img-fluid rounded-top w-100" alt="">
                            <div class="px-4 rounded-bottom">
                                <div class="service-content bg-light text-center p-4 rounded">
                                    <h5 class="text-primary">Trái Cây Tươi Ngon</h5>
                                    <h3 class="mb-0">Miễn Phí Giao Hàng</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.ds_SanPham.show_product') }}">
                        <div class="service-item bg-primary rounded border border-primary">
                            <img src="\imgsp\featur-3.jpg" class="img-fluid rounded-top w-100" alt="">
                            <div class="px-4 rounded-bottom">
                                <div class="service-content bg-secondary text-center p-4 rounded">
                                    <h5 class="text-white">Rau Củ Hữu Cơ</h5>
                                    <h3 class="mb-0">Ưu đãi siêu hời</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
    <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h1 class="mb-0">Top Sản Phẩm Bán Chạy</h1>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                @foreach ($SanphamBanChay as $product)
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            @if ($product->anh->isNotEmpty())
                                <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">
                                    <img src="/imgsp/{{ $product->anh->first()->tenanh }}" class="w-100 rounded-top"
                                        alt="" style="height: 214px;">
                                </a>
                            @endif
                        </div>
                        <!-- <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div> -->
                        <div class="p-4 rounded-bottom">
                            <h4><a
                                    href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">{{ $product->tensp }}</a>
                            </h4>
                            <p>&nbsp&nbspXuất xứ: {{ $product->xuatxu }}</p>
                            <div class="d-flex align-items-center">
                                <div>
                                    @php
                                        $fullStars = floor($product->averageRating); // Số sao đầy
                                        $hasHalfStar = $product->averageRating - $fullStars >= 0.5; // Có nửa sao hay không
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $fullStars)
                                            <!-- Ngôi sao đầy -->
                                            <i class="fa fa-star text-warning"></i>
                                        @elseif ($hasHalfStar && $i == $fullStars + 1)
                                            <!-- Ngôi sao nửa -->
                                            <i class="fa fa-star-half-alt text-warning"></i>
                                            @php $hasHalfStar = false; @endphp <!-- Xóa trạng thái nửa sao -->
                                        @else
                                            <!-- Ngôi sao trống -->
                                            <i class="fa fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ms-2">({{ $product->averageRating }} / 5)</span>
                            </div>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold" style="min-height: 60px;">


                                    @if ($product->discountAmount > 0)
                                        <span class="text-success" style="font-size: 17px; display: block;">
                                            Giá:
                                            {{ number_format($product->gia * (1 - $product->discountAmount / 100), 0, ',', '.') }}
                                            VNĐ /{{ $product->donvitinh }}
                                        </span>
                                        <span style="display: block;  color: red;">
                                            <span style="text-decoration: line-through;font-size: 15px;">
                                                {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                            </span>
                                            <span
                                                style="display: inline-block; font-size: 12px; background-color: red; color: white; font-weight: bold; padding: 2px 5px; margin-left: 5px; border-radius: 5px;">
                                                -{{ $product->discountAmount }}%
                                            </span>

                                        </span>
                                    @else
                                        <span class="text-success" style="font-size: 17px;float: left;">
                                            Giá: {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                            /{{ $product->donvitinh }}
                                        </span>
                                    @endif
                                    @if ($product->increasedProductName)
                                        <span style="font-size: 17px; display: block; color: red;float: left;">
                                            {{ $product->increasedProductName }}
                                        </span>
                                    @endif
                                </p>




                                @if (Auth::check())
                                    @if (Auth::user()->quyen == 'admin' || Auth::user()->quyen == 'nv')
                                        <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}"
                                            class="btn border border-secondary rounded-pill px-3 text-primary">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                            Chi tiết sản phẩm
                                        </a>
                                    @else
                                        <a href="{{ route('cart.add', $product->idsp) }}"
                                            class="btn border border-secondary rounded-pill px-3 text-primary">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm giỏ hàng
                                        </a>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Banner Section Start-->
    <div class="container-fluid banner bg-secondary my-5">
        <div class="container py-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="py-4">
                        <h1 class="display-3 text-white">Trái Cây Tươi Ngon</h1>
                        <p class="fw-normal display-3 text-dark mb-4" style="font-size: 45px;">Tại Cửa Hàng Của Chúng Tôi
                        </p>
                        <p class="mb-4 text-dark" style="font-size: 20px;">Chúng tôi cam kết mang đến cho bạn những trái
                            cây tươi ngon, được chọn lọc kỹ lưỡng từ những vùng đất màu mỡ nhất. Hãy đến và khám phá sự khác
                            biệt!</p>
                        <a href="{{ route('user.ds_SanPham.show_product') }}"
                            class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">MUA NGAY</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="imgsp/baner-1.png" class="img-fluid w-100 rounded" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bestsaler Product Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5" style="max-width: 1000px;">
                <h1 class="display-4">Sản phẩm được yêu thích hàng đầu</h1>
                <p style="font-size: 20px;">Chúng tôi tự hào giới thiệu những sản phẩm được yêu thích và lựa chọn nhiều
                    nhất bởi người tiêu dùng.</p>
            </div>


            <div class="row g-4">
                @foreach ($topRatedProducts as $index => $product)
                    @if ($index < 6)
                        <!-- Hiển thị 6 sản phẩm đầu tiên trong col-lg-6 col-xl-4 -->
                        <div class="col-lg-6 col-xl-4">
                            <div class="p-4 rounded bg-light">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        @if ($product->anh->isNotEmpty())
                                            <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">
                                                <img src="/imgsp/{{ $product->anh->first()->tenanh }}"
                                                    class="w-100 img-fluid rounded-circle" alt=""
                                                    style="height: 170px;">
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <a
                                            href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">{{ $product->tensp }}</a>
                                        <div class="d-flex my-3">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    @php
                                                        $fullStars = floor($product->averageRating); // Số sao đầy
                                                        $hasHalfStar = $product->averageRating - $fullStars >= 0.5; // Có nửa sao hay không
                                                    @endphp

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $fullStars)
                                                            <!-- Ngôi sao đầy -->
                                                            <i class="fa fa-star text-warning"></i>
                                                        @elseif ($hasHalfStar && $i == $fullStars + 1)
                                                            <!-- Ngôi sao nửa -->
                                                            <i class="fa fa-star-half-alt text-warning"></i>
                                                            @php $hasHalfStar = false; @endphp <!-- Xóa trạng thái nửa sao -->
                                                        @else
                                                            <!-- Ngôi sao trống -->
                                                            <i class="fa fa-star text-muted"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="ms-2">({{ $product->averageRating }} / 5)</span>
                                            </div>
                                        </div>
                                        <h4 class="mb-3">
                                            <p class="text-dark fs-5 fw-bold" style="min-height: 60px;">
                                                @if ($product->discountAmount > 0)
                                                    <span class="text-success" style="font-size: 17px; display: block;">
                                                        Giá:
                                                        {{ number_format($product->gia * (1 - $product->discountAmount / 100), 0, ',', '.') }}
                                                        VNĐ /{{ $product->donvitinh }}
                                                    </span>
                                                    <span style="display: block; color: red;">
                                                        <span style="text-decoration: line-through;font-size: 15px;">
                                                            {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                                        </span>
                                                        <span
                                                            style="display: inline-block; font-size: 12px; background-color: red; color: white; font-weight: bold; padding: 2px 5px; margin-left: 5px; border-radius: 5px;">
                                                            -{{ $product->discountAmount }}%
                                                        </span>
                                                    </span>
                                                @else
                                                    <span class="text-success" style="font-size: 17px;float: left;">
                                                        Giá: {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                                        /{{ $product->donvitinh }}
                                                    </span>
                                                @endif
                                                @if ($product->increasedProductName)
                                                    <span style="font-size: 17px; display: block; color: red;">
                                                        {{ $product->increasedProductName }}
                                                    </span>
                                                @endif
                                            </p>
                                        </h4>
                                        {{-- <a href="{{ route('cart.add', $product->idsp) }}" class="btn border border-secondary rounded-pill px-3 text-primary">
                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm giỏ hàng
                                </a> --}}
                                        @if (Auth::check())
                                            @if (Auth::user()->quyen == 'admin' || Auth::user()->quyen == 'nv')
                                                <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}"
                                                    class="btn border border-secondary rounded-pill px-3 text-primary">
                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                                    Chi tiết sản phẩm
                                                </a>
                                            @else
                                                <a href="{{ route('cart.add', $product->idsp) }}"
                                                    class="btn border border-secondary rounded-pill px-3 text-primary">
                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm giỏ hàng
                                                </a>
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Hiển thị các sản phẩm còn lại trong col-md-6 col-lg-6 col-xl-3 -->
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="text-center">
                                @if ($product->anh->isNotEmpty())
                                    <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">
                                        <img src="/imgsp/{{ $product->anh->first()->tenanh }}" class="img-fluid rounded"
                                            style="width: 100%; /* Đảm bảo ảnh chiếm hết chiều rộng của div */
    height: 210px; /* Chỉ định chiều cao cố định cho ảnh */
    object-fit: cover; "
                                            alt="">
                                    </a>
                                @endif
                                <div class="py-4">
                                    <a href="#" class="h5">{{ $product->tensp }}</a>
                                    <div class="d-flex my-3 justify-content-center">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                @php
                                                    $fullStars = floor($product->averageRating); // Số sao đầy
                                                    $hasHalfStar = $product->averageRating - $fullStars >= 0.5; // Có nửa sao hay không
                                                @endphp

                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $fullStars)
                                                        <!-- Ngôi sao đầy -->
                                                        <i class="fa fa-star text-warning"></i>
                                                    @elseif ($hasHalfStar && $i == $fullStars + 1)
                                                        <!-- Ngôi sao nửa -->
                                                        <i class="fa fa-star-half-alt text-warning"></i>
                                                        @php $hasHalfStar = false; @endphp <!-- Xóa trạng thái nửa sao -->
                                                    @else
                                                        <!-- Ngôi sao trống -->
                                                        <i class="fa fa-star text-muted"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="ms-2">({{ $product->averageRating }} / 5)</span>
                                        </div>
                                    </div>
                                    <h4 class="mb-3">
                                        <p class="text-dark fs-5 fw-bold" style="min-height: 60px;margin:0px">
                                            @if ($product->discountAmount > 0)
                                                <span class="text-success" style="font-size: 17px; display: block;">
                                                    Giá:
                                                    {{ number_format($product->gia * (1 - $product->discountAmount / 100), 0, ',', '.') }}
                                                    VNĐ /{{ $product->donvitinh }}
                                                </span>
                                                <span style="display: block; color: red;">
                                                    <span style="text-decoration: line-through;font-size: 15px;">
                                                        {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                                    </span>
                                                    <span
                                                        style="display: inline-block; font-size: 12px; background-color: red; color: white; font-weight: bold; padding: 2px 5px; margin-left: 5px; border-radius: 5px;">
                                                        -{{ $product->discountAmount }}%
                                                    </span>
                                                </span>
                                            @else
                                                <span class="text-success" style="font-size: 17px;">
                                                    Giá: {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                                    /{{ $product->donvitinh }}
                                                </span>
                                            @endif
                                            @if ($product->increasedProductName)
                                                <span style="font-size: 17px; display: block; color: red;">
                                                    {{ $product->increasedProductName }}
                                                </span>
                                            @endif
                                        </p>
                                    </h4>
                                    @if (Auth::check())
                                        @if (Auth::user()->quyen == 'admin' || Auth::user()->quyen == 'nv')
                                            <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}"
                                                class="btn border border-secondary rounded-pill px-3 text-primary">
                                                <i class="fa fa-shopping-bag me-2 text-primary"></i>
                                                Chi tiết sản phẩm
                                            </a>
                                        @else
                                            <a href="{{ route('cart.add', $product->idsp) }}"
                                                class="btn border border-secondary rounded-pill px-3 text-primary">
                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm giỏ hàng
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach





            </div>
        </div>
    </div>
    <!-- Bestsaler Product End -->
@endsection
