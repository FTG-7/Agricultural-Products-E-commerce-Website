@extends('user.layout.master')

@Section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Sản phẩm</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">SunFresh</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-xl-3">
                            <div class="input-group w-100 mx-auto d-flex">
                                <form action="{{ route('user.ds_SanPham.show_product') }}" method="GET" class="d-flex">
                                    <input type="hidden" name="idloai" value="{{ isset($idloai) ? $idloai : null }}">
                                    <input type="hidden" name="sxsplist" value="{{ isset($sxsplist) ? $sxsplist : null }}">
                                    <input type="hidden" name="rangeInputMin"
                                        value="{{ isset($rangeInputMin) ? $rangeInputMin : $minPrice }}">
                                    <input type="hidden" name="rangeInputMax"
                                        value="{{ isset($rangeInputMax) ? $rangeInputMax : $maxPrice }}">

                                    <input type="search" name="search" value="{{ old('search', $searchTerm) }}"
                                        class="form-control p-3" placeholder="Tên sản phẩm" aria-describedby="search-icon-1"
                                        style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                    <button type="submit" id="search-icon-1" class="input-group-text p-3"
                                        style=" border-top-left-radius: 0; border-bottom-left-radius: 0;"><i
                                            class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <div class="col-4"></div>
                        <div class="col-2"></div>

                        <div class="col-xl-3">
                            <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                <form id="sxspform" action="{{ route('user.ds_SanPham.show_product') }}" method="GET">
                                    {{-- <form id="sxspform" action="{{ route('user.ds_SanPham.show_product') }}" method="GET"> --}}
                                    <input type="hidden" name="idloai" value="{{ isset($idloai) ? $idloai : null }}">
                                    <input type="hidden" name="search"
                                        value="{{ isset($searchTerm) ? $searchTerm : null }}">
                                    <input type="hidden" name="rangeInputMin"
                                        value="{{ isset($rangeInputMin) ? $rangeInputMin : $minPrice }}">
                                    <input type="hidden" name="rangeInputMax"
                                        value="{{ isset($rangeInputMax) ? $rangeInputMax : $maxPrice }}">

                                    <label for="fruits">Sắp xếp theo:</label>
                                    <select id="sxsp" name="sxsplist" class="border-0 form-select-sm bg-light me-3"
                                        onchange="submitForm()">
                                        <option value="idgiam">Mới -> Cũ</option>
                                        <option value="idtang">Cũ -> Mới</option>
                                        <option value="giatang">Giá Tăng Dần</option>
                                        <option value="giagiam">Giá Giảm Dần</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Loại sản phẩm</h4>
                                        <hr>
                                        <ul class="list-unstyled fruite-categorie">
                                            <li>
                                                <div class="d-flex justify-content-between fruite-name">

                                                    <a href="{{ route('user.ds_SanPham.show_product') }}">
                                                        <i class="fas fa-sun me-2"></i>Tất Cả
                                                    </a>
                                                </div>
                                            </li>


                                            @foreach ($LoaiSP as $type)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a
                                                            href="{{ route('user.ds_SanPham.show_product', $type->idloai) }}">
                                                            <i class="fas fa-sun me-2"></i>{{ $type->tenloai }}
                                                        </a>

                                                        <span>({{ $type->sanpham_count }})</span>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                                <hr>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4 class="mb-2">Giá tiền</h4>
                                        <label for="rangeInputMin"><b>Từ: </b></label>
                                        <input type="range" class="form-range w-100" id="rangeInputMin"
                                            name="rangeInputMin" min="0" max="{{ $max }}"
                                            value="{{ old('rangeInputMin', $minPrice) }}"
                                            oninput="updateMinAmount(this.value)">
                                        <output id="amountMin" name="amountMin"
                                            for="rangeInputMin">{{ number_format(old('rangeInputMin', $minPrice), 0, ',', '.') }}</output>
                                        <br>
                                        <label for="rangeInputMax" class="mt-3"><b>Đến: </b></label>
                                        <input type="range" class="form-range w-100 mt-2" id="rangeInputMax"
                                            name="rangeInputMax" min="0" max="{{ $max }}"
                                            value="{{ old('rangeInputMax', $maxPrice) }}"
                                            oninput="updateMaxAmount(this.value)">
                                        <output id="amountMax" name="amountMax"
                                            for="rangeInputMax">{{ number_format(old('rangeInputMax', $maxPrice), 0, ',', '.') }}</output>

                                        <!-- Nút tìm kiếm sản phẩm theo giá -->
                                        <div class="mt-3">
                                            <form action="{{ route('user.ds_SanPham.show_product') }}" method="GET">
                                                <input type="hidden" name="idloai"
                                                    value="{{ isset($idloai) ? $idloai : null }}">
                                                <input type="hidden" name="sxsplist"
                                                    value="{{ isset($sxsplist) ? $sxsplist : null }}">
                                                <input type="hidden" name="search"
                                                    value="{{ isset($searchTerm) ? $searchTerm : null }}">

                                                <input type="hidden" name="rangeInputMin" id="rangeInputMinHidden"
                                                    value="{{ old('rangeInputMin', $minPrice) }}">
                                                <input type="hidden" name="rangeInputMax" id="rangeInputMaxHidden"
                                                    value="{{ old('rangeInputMax', $maxPrice) }}">
                                                <button type="submit"
                                                    class="btn border border-secondary px-3 text-primary">Tìm kiếm theo
                                                    giá</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="col-lg-12">
                                    <div class="position-relative">
                                        <img src="{{ asset('inc/img/banner-fruits.jpg') }}" alt="Banner Fruits"
                                            class="img-fluid w-100 rounded">
                                        <div class="position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%);">
                                            <h3 class="text-secondary fw-bold">Sạch<br>Tươi<br>Mới</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-9">
                            <div class="row g-4 ">

                                @if ($Sanpham->isEmpty())
                                    <p>Không có sản phẩm nào.</p>
                                @else
                                    <?php foreach ($Sanpham as $product) : ?>
                                    <div class="col-md-6 col-lg-6 col-xl-4 text-center">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <!-- Sử dụng đường dẫn hình ảnh của sản phẩm -->
                                                @if ($product->anh->isNotEmpty())
                                                    <a
                                                        href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">
                                                        <img src="/imgsp/{{ $product->anh->first()->tenanh }}"
                                                            class="w-100 rounded-top" alt=""
                                                            style="height: 214px;">
                                                    </a>
                                                @else
                                                    <a
                                                        href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">
                                                        <img src="/imgsp/noImage.jpg" class="w-100 rounded-top"
                                                            alt="No Image" style="height: 214px;">
                                                    </a>
                                                @endif

                                            </div>

                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>
                                                    <a
                                                        href="{{ route('user.ds_SanPham.detail_product', $product->idsp) }}">{{ $product->tensp }}</a>
                                                </h4>
                                                <p>&nbsp;&nbsp;Xuất xứ: {{ $product->xuatxu }}</p>
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
                                                                Giá: {{ number_format($product->gia, 0, ',', '.') }} VNĐ
                                                                /{{ $product->donvitinh }}
                                                            </span>
                                                        @endif
                                                        @if ($product->increasedProductName)
                                                            <span
                                                                style="font-size: 17px; display: block; color: red;float: left;">
                                                                {{ $product->increasedProductName }}
                                                            </span>
                                                        @endif
                                                    </p>

                                                    <!-- Hiển thị tên sản phẩm được tặng kèm nếu có -->


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
                                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Thêm
                                                                giỏ hàng
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                @endif

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
                                </style>
                                <div class="row justify-content-center">

                                    {!! $Sanpham->appends(request()->query())->links('pagination::bootstrap-4') !!}


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
        function submitForm() {
            // Lấy giá trị đã chọn từ dropdown menu
            var selectedValue = document.getElementById("sxsp").value;
            // Lưu giá trị đã chọn vào Local Storage
            localStorage.setItem('selectedSortOption', selectedValue);
            // Gán giá trị đã chọn vào biểu mẫu
            document.getElementById("sxspform").submit();
        }

        // Kiểm tra xem có giá trị đã lưu trong Local Storage hay không khi trang được load
        window.onload = function() {
            var storedValue = localStorage.getItem('selectedSortOption');
            if (storedValue) {
                // Nếu có, gán giá trị đó cho dropdown menu
                document.getElementById("sxsp").value = storedValue;
            }
        };

        const rangeInputMin = document.getElementById('rangeInputMin');
        const rangeInputMax = document.getElementById('rangeInputMax');
        const rangeInputMinHidden = document.getElementById('rangeInputMinHidden');
        const rangeInputMaxHidden = document.getElementById('rangeInputMaxHidden');

        rangeInputMin.addEventListener('input', function() {
            rangeInputMinHidden.value = rangeInputMin.value;
        });

        rangeInputMax.addEventListener('input', function() {
            rangeInputMaxHidden.value = rangeInputMax.value;
        });

        //format tiền khi trượt thanh trượt
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Định dạng số với dấu chấm
        }

        function updateMinAmount(value) {
            document.getElementById('amountMin').textContent = formatNumber(value);
        }

        function updateMaxAmount(value) {
            document.getElementById('amountMax').textContent = formatNumber(value);
        }
    </script>
@endsection
