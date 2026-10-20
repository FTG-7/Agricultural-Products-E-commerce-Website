@extends('admin.layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Sản Phẩm</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Sản Phẩm</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Danh Sách Sản Phẩm</h4>
                                <!-- <button class="btn btn-primary btn-round ms-auto"
                                                        onclick="window.location.href='{{ route('admin.SanPham.create') }}'">
                                                        <i class="fa fa-plus"></i>
                                                        Thêm Sản Phẩm
                                                    </button> -->
                                <a href="{{ route('admin.SanPham.create') }}" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Thêm Sản Phẩm
                                </a>

                            </div>
                        </div>

                        <div class="row mt-2">
                            <!-- Tìm kiếm -->
                            <div class="col-md-4 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                                <form method="GET" action="{{ route('admin.SanPham.admin_index') }}">
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="field" aria-label="Chọn trường tìm kiếm">
                                            <option value="idsp" {{ request('field') == 'idsp' ? 'selected' : '' }}>Mã sản
                                                phẩm</option>
                                            <option value="tensp" {{ request('field') == 'tensp' ? 'selected' : '' }}>Tên
                                                sản phẩm</option>
                                            <option value="gia" {{ request('field') == 'gia' ? 'selected' : '' }}>Giá
                                            </option>
                                            <option value="xuatxu" {{ request('field') == 'xuatxu' ? 'selected' : '' }}>Xuất
                                                xứ</option>
                                        </select>
                                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm"
                                            value="{{ request('search') }}">

                                        <input type="hidden" name="idloai" value="{{ request('idloai') }}">
                                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                                        <input type="hidden" name="sort_field" value="{{ request('sort_field') }}">
                                        <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Sắp xếp -->
                            <div class="col-md-4 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                                <form method="GET" action="{{ route('admin.SanPham.admin_index') }}">
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="sort_field" aria-label="Sắp xếp theo"
                                            style="min-width: 150px;">
                                            <option value="idsp" {{ request('sort_field') == 'idsp' ? 'selected' : '' }}>
                                                Mã sản phẩm</option>
                                            <option value="tensp"
                                                {{ request('sort_field') == 'tensp' ? 'selected' : '' }}>Tên sản phẩm
                                            </option>
                                            <option value="gia" {{ request('sort_field') == 'gia' ? 'selected' : '' }}>
                                                Giá</option>
                                            <option value="xuatxu"
                                                {{ request('sort_field') == 'xuatxu' ? 'selected' : '' }}>Xuất xứ</option>
                                        </select>
                                        <select class="form-select" name="sort" aria-label="Thứ tự sắp xếp">
                                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tăng
                                                dần</option>
                                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Giảm
                                                dần</option>
                                        </select>

                                        <input type="hidden" name="idloai" value="{{ request('idloai') }}">
                                        <input type="hidden" name="field" value="{{ request('field') }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="submit">Sắp xếp</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Tìm kiếm theo loại -->
                            <div class="col-md-4 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                                <form method="GET" action="{{ route('admin.SanPham.admin_index') }}">
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="idloai" aria-label="Tìm kiếm theo"
                                            style="min-width: 150px;">
                                            <option value="" {{ request('idloai') === null ? 'selected' : '' }}>Tất
                                                cả</option>
                                            @foreach ($LoaiSP as $type)
                                                <option value="{{ $type->idloai }}"
                                                    {{ request('idloai') == $type->idloai ? 'selected' : '' }}>
                                                    {{ $type->tenloai }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                                        <input type="hidden" name="sort_field" value="{{ request('sort_field') }}">
                                        <input type="hidden" name="field" value="{{ request('field') }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="table-responsive" style="margin-top: 25px">
                            <table id="product-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã SP</th>
                                        <th>Tên SP</th>
                                        <th>Giá</th>
                                        <th>Đơn vị</th>
                                        <th>Xuất xứ</th>
                                        <th>Số lượng</th>
                                        <th>Trạng thái</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Mã SP</th>
                                        <th>Tên SP</th>
                                        <th>Giá</th>
                                        <th>Đơn vị</th>
                                        <th>Xuất xứ</th>
                                        <th>Số lượng</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->idsp }}</td>
                                            <td>{{ $product->tensp }}</td>
                                            <td>{{ number_format($product->gia, 0, ',', '.') }} VNĐ</td>
                                            <td>{{ $product->donvitinh }}</td>
                                            <td>{{ $product->xuatxu }}</td>
                                            <td>{{ $product->soluong }}</td>
                                            <td>{{ $product->trangthai == 1 ? 'Còn Hàng ' : 'Hết Hàng' }}</td>
                                            <td>
                                                <form action="{{ route('admin.SanPham.edit', $product->idsp) }}"
                                                    method="get" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link btn-primary btn-lg"
                                                        data-bs-toggle="tooltip" title="Chỉnh sửa sản phẩm">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer d-flex justify-content-center">
                            {{ $products->appends(request()->input())->links('pagination::bootstrap-4') }}
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Sản Phẩm Hết Hàng</h4>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6"></div>
                            <!-- Tìm kiếm -->
                            <div class="col-md-6 mb-2 d-flex align-items-center" style="padding-left: 50px;">
                                <form id="searchForm" method="GET" action="{{ route('admin.SanPham.admin_index') }}">
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="field_1" aria-label="Chọn trường tìm kiếm">
                                            <option value="idsp" {{ request('field_1') == 'idsp' ? 'selected' : '' }}>Mã
                                                sản
                                                phẩm</option>
                                            <option value="tensp" {{ request('field_1') == 'tensp' ? 'selected' : '' }}>
                                                Tên
                                                sản phẩm</option>
                                            <option value="gia" {{ request('field_1') == 'gia' ? 'selected' : '' }}>Giá
                                            </option>
                                            <option value="xuatxu" {{ request('field_1') == 'xuatxu' ? 'selected' : '' }}>
                                                Xuất
                                                xứ</option>
                                        </select>
                                        <input type="text" class="form-control" name="search_1"
                                            placeholder="Tìm kiếm" value="{{ request('search_1') }}">

                                        <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive table-responsive-1" style="margin-top: 25px">
                            <table id="product-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã SP</th>
                                        <th>Tên SP</th>
                                        <th>Giá</th>
                                        <th>Đơn vị</th>
                                        <th>Xuất xứ</th>
                                        <th>Số lượng</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Mã SP</th>
                                        <th>Tên SP</th>
                                        <th>Giá</th>
                                        <th>Đơn vị</th>
                                        <th>Xuất xứ</th>
                                        <th>Số lượng</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($noSanPham as $product)
                                        <tr>
                                            <td>{{ $product->idsp }}</td>
                                            <td>{{ $product->tensp }}</td>
                                            <td>{{ number_format($product->gia, 0, ',', '.') }} VNĐ</td>
                                            <td>{{ $product->donvitinh }}</td>
                                            <td>{{ $product->xuatxu }}</td>
                                            <td>{{ $product->soluong }}</td>
                                            <td>{{ $product->trangthai == 1 ? 'Còn Hàng ' : 'Hết Hàng' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .table-responsive-1 {
            max-height: 400px;
            /* Giới hạn chiều cao */
            overflow-y: auto;
            /* Kích hoạt thanh cuộn dọc */
        }

        .table-responsive-1 thead {
            position: sticky;
            top: 0;
            /* Giữ thanh tiêu đề ở trên cùng của phần hiển thị */
            background-color: #fff;
            /* Đảm bảo nền của thanh tiêu đề có màu nền phù hợp */
            z-index: 10;
            /* Đảm bảo thanh tiêu đề không bị chồng lên bởi các nội dung khác khi cuộn */
        }
    </style>

    <script>
        // Lưu vị trí cuộn trước khi gửi form
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });

        // Cuộn lại vị trí sau khi trang tải lại
        window.addEventListener('load', function() {
            let scrollPosition = sessionStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, scrollPosition);
                sessionStorage.removeItem('scrollPosition');
            }
        });
    </script>
@endsection
