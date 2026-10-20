@extends('admin.layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Quản lý số lượng</h3>
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
                        <a href="#">Quản lý số lượng</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Quản lý số lượng sản phẩm</h4>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <!-- Tìm kiếm -->
                            <div class="col-md-4 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                                <form method="GET" action="{{ route('admin.SanPham.quantity_index') }}">
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="field" aria-label="Chọn trường tìm kiếm">
                                            <option value="idsp" {{ request('field') == 'idsp' ? 'selected' : '' }}>Mã
                                                sản
                                                phẩm</option>
                                            <option value="tensp" {{ request('field') == 'tensp' ? 'selected' : '' }}>Tên
                                                sản phẩm</option>
                                            <option value="gia" {{ request('field') == 'gia' ? 'selected' : '' }}>Giá
                                            </option>
                                            <option value="xuatxu" {{ request('field') == 'xuatxu' ? 'selected' : '' }}>
                                                Xuất
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
                                <form method="GET" action="{{ route('admin.SanPham.quantity_index') }}">
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
                                <form method="GET" action="{{ route('admin.SanPham.quantity_index') }}">
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

                        <!-- Thông báo thành công và lỗi -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="table-responsive" style="margin-top: 25px">
                            <table id="product-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã SP</th>
                                        <th>Tên SP</th>
                                        <th>Số lượng</th>
                                        <th>Trạng thái</th>
                                        <th>Số lượng trừ</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Mã SP</th>
                                        <th>Tên SP</th>
                                        <th>Số lượng</th>
                                        <th>Trạng thái</th>
                                        <th>Số lượng trừ</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <form action="{{ route('admin.SanPham.quantity_update') }}" method="post"
                                        id="product-form">
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->idsp }}</td>
                                                <td>{{ $product->tensp }}</td>
                                                <td>{{ $product->soluong }}</td>
                                                <td>{{ $product->trangthai == 1 ? 'Còn Hàng' : 'Hết Hàng' }}</td>
                                                <td>
                                                    @csrf
                                                    <input type="hidden" name="idsp[]" value="{{ $product->idsp }}">
                                                    <input type="number" name="soluong[]" value="0" min="0"
                                                        max="{{ $product->soluong }}">
                                                </td>
                                                <td>
                                                    <!-- Nút Reset -->
                                                    <a class="btn btn-warning btn-sm"
                                                        href="{{ route('admin.SanPham.reset_quantity', $product->idsp) }}">Đặt thành 0</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </form>
                                </tbody>
                            </table>
                        </div>

                        <!-- Nút Cập nhật nằm dưới cùng và cố định -->
                        <div class="text-center mt-3 sticky-footer">
                            <button type="submit" class="btn btn-primary w-100" form="product-form">Cập nhật</button>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .table-responsive {
            max-height: 400px;
            /* Giới hạn chiều cao */
            overflow-y: auto;
            /* Kích hoạt thanh cuộn dọc */
        }

        .table-responsive thead {
            position: sticky;
            top: 0;
            /* Giữ thanh tiêu đề ở trên cùng của phần hiển thị */
            background-color: #fff;
            /* Đảm bảo nền của thanh tiêu đề có màu nền phù hợp */
            z-index: 10;
            /* Đảm bảo thanh tiêu đề không bị chồng lên bởi các nội dung khác khi cuộn */
        }

        .sticky-footer {
            position: sticky;
            bottom: 0;
            width: 100%;
            background-color: #fff;
            padding: 10px 0;
            z-index: 20;
        }

        .sticky-footer .btn {
            width: 100%;
            padding: 10px 0;
            /* Tùy chỉnh độ cao cho nút */
        }
        
    </style>

    <script>
        // Ẩn thông báo sau 10 giây
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 10000);

    </script>
@endsection
