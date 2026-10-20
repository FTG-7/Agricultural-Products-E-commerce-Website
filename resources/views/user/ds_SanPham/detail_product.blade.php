@extends('user.layout.master')

@Section('content')
    <link rel="stylesheet" href="/inc/css/bootstrap.min.css">
    <link rel="stylesheet" href="/inc/css/lightslider.min.css">
    <style>
        .product-description {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Hiển thị tối đa 3 dòng */
            -webkit-box-orient: vertical;
            white-space: normal;
            /* Cho phép văn bản ngắt dòng */
        }
    </style>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            /* Căn giữa các nút phân trang */
            list-style: none;
            /* Loại bỏ bullet points nếu có */
            padding-left: 0;
            margin: 35px;
        }

        .pagination .page-item {
            margin: 0 3px;
            /* Khoảng cách giữa các nút phân trang */
        }

        .pagination .page-link {
            display: block;
            padding: 0.5rem 0.75rem;
            /* border: 1px solid #dee2e6; */
            /* color: #007bff; */
            text-decoration: none;
            /* background-color: #fff; */
            border-radius: 25%;
            /* Thêm border-radius để tạo hình tròn */
            width: 45px;
            /* Điều chỉnh kích thước chiều rộng */
            height: 45px;
            /* Điều chỉnh kích thước chiều cao */
            display: flex;
            justify-content: center;
            align-items: center;
            /* Căn giữa nội dung bên trong nút */
        }

        .fa-star {
            color: #ffc107;
        }

        .fa-star.text-muted {
            color: #fff !important;
            -webkit-text-stroke: 1px #ffc107;
        }

        .fa-star-half {
            position: relative;
            display: inline-block;

        }

        .fa-star-half::before {
            content: '\f005';
            /* Biểu tượng ngôi sao FontAwesome */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            color: #ffc107;
            width: 10%;
            overflow: hidden;
            left: 0;
        }
    </style>
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">{{ $sanpham->tensp }} </h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <!-- <div class="col-lg-7 col-xl-7"> -->
                            <div class="product_slider_img">
                                <div id="vertical">

                                    @foreach ($sanpham->anh as $index => $anh)
                                        <div data-thumb="/imgsp/<?= $anh->tenanh ?>" style="width : 100px; height: 100ppx">
                                            <img src="/imgsp/<?= $anh->tenanh ?>" style="width : 530px; height: 468px" />
                                        </div>
                                    @endforeach

                                    {{-- <?php foreach ($FileName as $name) : ?>
                                    <div data-thumb="imgsp/<?= $name ?>" style="width : 100px; height: 100ppx">
                                        <img src="imgsp/<?= $name ?>" style="width : 530px; height: 468px" />
                                    </div>
                                <?php endforeach; ?> --}}
                                </div>
                            </div>
                            <!-- </div> -->
                            <div class="border rounded">



                            </div>
                        </div>
                        <div class="col-lg-4">
                            <h4 class="fw-bold mb-3">{{ $sanpham->tensp }}</h4>
                            <p class="mb-3">Loại:
                                @foreach ($sanpham->loaisp as $index => $loai)
                                    {{ $loai->tenloai }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </p>
                            <h5 class="fw-bold mb-3">
                                @if ($sanpham->discountAmount > 0)
                                    <span class="text-success" style="display: block;">
                                        {{ number_format($sanpham->gia * (1 - $sanpham->discountAmount / 100), 0, ',', '.') }}
                                        VNĐ /{{ $sanpham->donvitinh }}
                                    </span>
                                    <span style="display: block;  color: red;">
                                        <span style="text-decoration: line-through;font-size: 15px;">
                                            {{ number_format($sanpham->gia, 0, ',', '.') }} VNĐ
                                        </span>
                                        <span
                                            style="display: inline-block; font-size: 12px; background-color: red; color: white; font-weight: bold; padding: 2px 5px; margin-left: 5px; border-radius: 5px;">
                                            -{{ $sanpham->discountAmount }}%
                                        </span>

                                    </span>
                                @else
                                    {{ number_format($sanpham->gia, 0, ',', '.') }} VNĐ
                                    /{{ $sanpham->donvitinh }}
                                @endif
                            </h5>
                            <!-- Đánh giá sản phẩm -->
                            <div class="d-flex align-items-center fw-bold mb-3">
                                <div>
                                    @php
                                        $fullStars = floor($averageRating); // Số sao đầy
                                        $hasHalfStar = $averageRating - $fullStars >= 0.5; // Có nửa sao hay không
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
                                <span class="ms-2">({{ $averageRating }} / 5)</span>
                            </div>

                            <!-- Số lượng sản phẩm -->
                            <form action="{{ route('cart.adddetail', ['idsp' => $sanpham->idsp]) }}" method="POST"> @csrf
                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border" type="button"
                                            onclick="this.closest('form').querySelector('input').stepDown()">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input name="quantity" type="number"
                                        class="form-control form-control-sm text-center border-0" value="1"
                                        min="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border" type="button"
                                            onclick="this.closest('form').querySelector('input').stepUp()">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Thêm vào giỏ hàng -->
                                @if (Auth::check())
                                    @if (Auth::user()->quyen != 'admin' && Auth::user()->quyen != 'nv')
                                        <button type="submit"
                                            class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm giỏ hàng
                                        </button>
                                    @endif
                                @endif

                            </form>

                            @if ($sanpham->increasedProductName)
                                <div class="testimonial-item img-border-radius bg-light rounded p-4">
                                    <div class="position-relative">
                                        <div class="mb-4 border-bottom border-secondary">
                                            <style>
                                                .icon-fire {
                                                    background-image: url(https://cdn.tgdd.vn/bachhoaxanh/www/Content/images/desktop/bhxdesk@2x.v202309061432.png);
                                                    background-repeat: no-repeat;
                                                    background-size: 500px auto;
                                                    vertical-align: middle;
                                                    display: inline-block;
                                                    line-height: 30px;
                                                    background-position: -314px -504px;
                                                    width: 11px;
                                                    height: 16px;
                                                    margin-right: 5px;
                                                }
                                            </style>
                                            <p class="mb-0"><i class="icon-fire"></i>ƯU ĐÃI ĐẶC BIỆT
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center flex-nowrap">


                                            <span style="font-size: 17px; display: block; color: red;float: left;">
                                                {{ $sanpham->increasedProductName }}
                                            </span>

                                        </div>
                                    </div>
                                </div>
                            @endif


                        </div>

                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button
                                        class="nav-link  {{ request()->has('page') ? '' : 'active' }}  border-white border-bottom-0"
                                        type="button" role="tab" id="nav-about-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-about" aria-controls="nav-about" aria-selected="true">Mô tả sản
                                        phẩm</button>
                                    <button
                                        class="nav-link {{ request()->has('page') ? 'active' : '' }} border-white border-bottom-0"
                                        type="button" role="tab" id="nav-mission-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-mission" aria-controls="nav-mission" aria-selected="false">Đánh
                                        giá</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane {{ request()->has('page') ? '' : 'active' }}" id="nav-about"
                                    role="tabpanel" aria-labelledby="nav-about-tab">
                                    <p>&nbsp&nbsp<?= $sanpham->mota ?></p>
                                    <div class="px-2">
                                        <div class="row g-4">
                                            <div class="col-6">
                                                <div
                                                    class="row bg-light align-items-center text-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Mã sản phẩm</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0"><?= $sanpham->idsp ?></p>
                                                    </div>
                                                </div>
                                                <div class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Đơn vị tính</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0"><?= $sanpham->donvitinh ?></p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="row bg-light text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Xuất xứ</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0"><?= $sanpham->xuatxu ?></p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Kiểm tra</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">An toàn</p>
                                                    </div>
                                                </div>
                                                <div
                                                    class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Đánh giá</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">

                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                @php
                                                                    $fullStars = floor($averageRating); // Số sao đầy
                                                                    $hasHalfStar = $averageRating - $fullStars >= 0.5; // Có nửa sao hay không
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
                                                            <span class="ms-2">({{ $averageRating }} / 5)</span>
                                                        </div>

                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane {{ request()->has('page') ? 'active' : '' }}" id="nav-mission"
                                    role="tabpanel" aria-labelledby="nav-mission-tab">
                                    <form action="{{ route('binhluan.store', $sanpham->idsp) }}" method="POST">
                                        @csrf
                                        <h4 class="mb-5 fw-bold">Bình luận</h4>
                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="border rounded my-4">
                                                    <textarea name="noidung" id="noidung" class="form-control border-0" cols="30" rows="6"
                                                        placeholder="Bình luận của bạn" spellcheck="false" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-between py-3 mb-5">
                                                    <div class="d-flex align-items-center">
                                                        <p class="mb-0 me-3">Đánh giá*:</p>
                                                        <div class="d-flex align-items-center star-rating"
                                                            style="font-size: 12px;">
                                                            <i class="fa fa-star text-muted" data-value="1"></i>
                                                            <i class="fa fa-star text-muted" data-value="2"></i>
                                                            <i class="fa fa-star text-muted" data-value="3"></i>
                                                            <i class="fa fa-star text-muted" data-value="4"></i>
                                                            <i class="fa fa-star text-muted" data-value="5"></i>
                                                        </div>
                                                        <input type="hidden" id="rating" name="rating"
                                                            value="">


                                                    </div>
                                                    <button type="submit"
                                                        class="btn border border-secondary text-primary rounded-pill px-4 py-3">Bình
                                                        luận</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    @if ($binhluans->isEmpty())
                                        <div class="d-flex">
                                            <div class="">
                                                <div class="d-flex justify-content-between">
                                                    <h5>Sản phẩm này chưa có bình luận</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <ul>
                                            @foreach ($binhluans as $binhluan)
                                                <div class="d-flex" style="margin-bottom:20px">
                                                    <img src="/imgsp/NoAvata.jpg" class="img-fluid rounded-circle p-3"
                                                        style="width: 100px; height: 100px;" alt="">
                                                    <div style="flex-grow: 1;">
                                                        <p class="mb-2" style="font-size: 14px;">
                                                            {{ $binhluan->ngay_binhluan->format('d/m/Y H:i') }}
                                                        </p>
                                                        <div class="d-flex justify-content-between">
                                                            <h5>{{ $binhluan->user->hoten }}</h5>
                                                            <div class="d-flex mb-3">
                                                                @php
                                                                    $fullStars = floor($binhluan->rating); // Số sao đầy
                                                                @endphp

                                                                @for ($i = 1; $i <= $fullStars; $i++)
                                                                    <i class="fa fa-star text-warning"></i>
                                                                    <!-- Ngôi sao đầy -->
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <p style="flex-grow: 1; word-wrap: break-word;">
                                                            {{ $binhluan->noidung }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </ul>

                                        <!-- Hiển thị phân trang -->
                                        <div class="pagination justify-content-center">
                                            {{-- {{ $binhluans->links() }} --}}
                                            {!! $binhluans->appends(request()->query())->links('pagination::bootstrap-4') !!}
                                        </div>
                                    @endif



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4 fruite">
                        <div class="col-lg-12">
                            <div class="input-group w-100 mx-auto d-flex mb-4">
                                <input type="search" class="form-control p-3" placeholder="Tìm kiếm"
                                    aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                            <div class="mb-4">
                                <h4>Loại sản phẩm</h4>
                                <ul class="list-unstyled fruite-categorie">
                                    <?php foreach ($LoaiSP as $type) : ?>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">


                                            <a href="{{ route('user.ds_SanPham.show_product', $type->idloai) }}">
                                                <i class="fas fa-sun me-2"></i>{{ $type->tenloai }}
                                            </a>

                                            <span>({{ $type->sanpham_count }})</span>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>


                                </ul>
                            </div>
                        </div>
                        {{-- <div class="col-lg-12">
                            <h4 class="mb-4">Featured products</h4>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded" style="width: 100px; height: 100px;">
                                    <img src="img/featur-1.jpg" class="img-fluid rounded" alt="Image">
                                </div>
                                <div>
                                    <h6 class="mb-2">Big Banana</h6>
                                    <div class="d-flex mb-2">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <h5 class="fw-bold me-2">2.99 $</h5>
                                        <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center my-4">
                                <a href="#" class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Vew More</a>
                            </div>
                        </div> --}}
                        <div class="col-lg-12">
                            <div class="position-relative">
                                <img src="/imgsp/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                <div class="position-absolute"
                                    style="top: 50%; right: 10px; transform: translateY(-50%);">
                                    <h3 class="text-secondary fw-bold">Sạch <br> Tươi <br> Mới</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="fw-bold mb-0">Sản phẩm cùng loại</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">

                    @foreach ($relatedProducts as $product)
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">
                                <div class="vesitable-img">
                                    @if ($product->anh->isNotEmpty())
                                        @foreach ($product->anh as $index => $anh)
                                            @if ($anh && isset($anh->tenanh))
                                                <div data-thumb="/imgsp/{{ $anh->tenanh }}" style="height: 250px;">
                                                    <img src="/imgsp/{{ $anh->tenanh }}" style="height: 250px;" />
                                                </div>
                                            @break;
                                        @endif
                                    @endforeach
                                @else
                                    <div data-thumb="/imgsp/noImage.jpg">
                                        <img src="/imgsp/noImage.jpg" />
                                    </div>
                                @endif
                        </a>
                    </div>

                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                        style="top: 10px; right: 10px;"> {{ $product->loaisp->first()->tenloai }}</div>
                    <div class="p-4 pb-0 rounded-bottom">
                        <h4><a
                                href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">{{ $product->tensp }}</a>
                        </h4>
                        <p class="text-muted text-truncate product-description">{{ $product->mota }}</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold">
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
                                    <span class="text-success" style="font-size: 17px;">
                                        Giá: {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                        /{{ $product->donvitinh }}
                                    </span>
                                   
                                @endif
                                @if ($product->increasedProductName)
                                    <span style="font-size: 17px; display: block; color: red;">
                                        {{ $product->increasedProductName }}
                                    </span>
                                @else
                                <span style="display: block;  color: white;">
                                    
                                    <span
                                        style="display: inline-block; font-size: 12px; background-color: white; color: white; font-weight: bold; padding: 2px 5px; margin-left: 5px; border-radius: 5px;">
                                    </span>
                                </span>
                                @endif
                            </p>
                            @if ($product->soluong == 0)
                                <span
                                    class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary disabled bg-secondary text-dark">
                                    <i class="fa fa-shopping-x me-2 text-primary"></i> Hết hàng
                                </span>
                            @else
                                @if (Auth::check())
                                    @if (Auth::user()->quyen == 'admin' || Auth::user()->quyen == 'nv')
                                        <a href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}"
                                            class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Chi tiết sản phẩm
                                        </a>
                                    @else
                                        <a href="{{ route('cart.add', $product->idsp) }}"
                                            class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm giỏ hàng
                                        </a>
                                    @endif
                                @endif
                            @endif

                        </div>
                    </div>
            </div>
            @endforeach



        </div>
    </div>
</div>
</div>
<!-- Single Product End -->

<script src="/inc/js/jquery-1.12.1.min.js"></script>

<script src="/inc/js/jquery.magnific-popup.js"></script>
<!-- swiper js -->
<script src="/inc/js/lightslider.min.js"></script>


<script src="/inc/js/owl.carousel.min.js"></script>

<script src="/inc/js/slick.min.js"></script>

<script src="/inc/js/jquery.counterup.min.js"></script>

<script src="/inc/js/jquery.ajaxchimp.min.js"></script>

<script src="/inc/js/custom.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.querySelectorAll('.star-rating i').forEach(function(star) {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value');
            document.getElementById('rating').value = rating;

            // Cập nhật màu sắc của ngôi sao trong form
            document.querySelectorAll('.star-rating i').forEach(function(star) {
                star.classList.remove('text-secondary');
                star.classList.add('text-muted');
            });

            for (let i = 0; i < rating; i++) {
                document.querySelectorAll('.star-rating i')[i].classList.remove('text-muted');
                document.querySelectorAll('.star-rating i')[i].classList.add('text-secondary');
            }
        });
    });
</script>
@endsection
