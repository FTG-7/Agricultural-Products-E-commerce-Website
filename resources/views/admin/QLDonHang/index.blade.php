@extends('admin.layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Quản Lý Đơn Hàng</h3>
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
                        <a href="#">Đơn Hàng</a>
                    </li>
                </ul>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-3 mb-3 d-flex align-items-center">
                                    <!-- Cột 1 -->
                                    <h4 class="card-title">Quản Lý Đơn Hàng</h4>
                                </div>
                                {{-- <div class="col-md-1 mb-3 d-flex align-items-center">
                                    <!-- Cột 2 -->
                                </div> --}}
                                <div class="col-md-4 mb-3 d-flex align-items-center">
                                    <!-- Cột 3 -->
                                    <!-- Sắp xếp -->
                                    <form method="GET" action="{{ route('admin.QLDonHang.index') }}"
                                        class="d-inline-block">
                                        <div class="input-group mb-3">
                                            <select class="form-select" name="sort" aria-label="Sắp xếp theo">
                                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tăng
                                                    dần</option>
                                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>
                                                    Giảm dần</option>
                                            </select>
                                            <select class="form-select" name="sort_field" aria-label="Sắp xếp theo">
                                                <option value="iddh"
                                                    {{ request('sort_field') == 'iddh' ? 'selected' : '' }}>
                                                    Mã Đơn Hàng
                                                </option>
                                                <option value="ngaydat"
                                                    {{ request('sort_field') == 'ngaydat' ? 'selected' : '' }}>
                                                    Ngày Đặt
                                                </option>
                                                <option value="tennhan"
                                                    {{ request('sort_field') == 'tennhan' ? 'selected' : '' }}>
                                                    Tên Người Nhận</option>
                                                <option value="sdt"
                                                    {{ request('sort_field') == 'sdt' ? 'selected' : '' }}>
                                                    SĐT
                                                </option>
                                                <option value="tongtien"
                                                    {{ request('sort_field') == 'tongtien' ? 'selected' : '' }}>
                                                    Tổng tiền</option>
                                            </select>
                                            <!-- Hoặc trường khác mà bạn muốn -->
                                            <input type="hidden" name="field" value="{{ request('field') }}">
                                            <input type="hidden" name="search" value="{{ request('search') }}">
                                            <button class="btn btn-outline-secondary" type="submit">Sắp xếp</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-5 mb-3 d-flex align-items-center">
                                    <!-- Cột 4 -->
                                    <!-- Tìm kiếm -->
                                    <form method="GET" action="{{ route('admin.QLDonHang.index') }}">
                                        <div class="input-group mb-3">
                                            <select class="form-select" name="field" aria-label="Chọn trường tìm kiếm">
                                                <option value="iddh" {{ request('field') == 'iddh' ? 'selected' : '' }}>
                                                    Mã Đơn Hàng
                                                </option>
                                                <option value="tennhan"
                                                    {{ request('field') == 'tennhan' ? 'selected' : '' }}>
                                                    Tên Người Nhận
                                                </option>
                                                <option value="sdt" {{ request('field') == 'sdt' ? 'selected' : '' }}>
                                                    SĐT
                                                </option>
                                                <option value="diachigiao"
                                                    {{ request('field') == 'diachigiao' ? 'selected' : '' }}>
                                                    Địa Chỉ Giao
                                                </option>
                                            </select>
                                            <input type="text" class="form-control" name="search" placeholder="Tìm kiếm"
                                                value="{{ request('search') }}">
                                            <!-- Hidden inputs để giữ thông tin sắp xếp -->
                                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                                            <input type="hidden" name="sort_field" value="{{ request('sort_field') }}">
                                            <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <!-- Tab navigation -->
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-cho-xac-nhan-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-cho-xac-nhan" type="button" role="tab"
                                    aria-controls="pills-cho-xac-nhan" aria-selected="true">Chờ xác nhận</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-dong-goi-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-dong-goi" type="button" role="tab"
                                    aria-controls="pills-dong-goi" aria-selected="false">Đóng gói</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-dang-giao-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-dang-giao" type="button" role="tab"
                                    aria-controls="pills-dang-giao" aria-selected="false">Đang giao</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-giao-thanh-cong-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-giao-thanh-cong" type="button" role="tab"
                                    aria-controls="pills-giao-thanh-cong" aria-selected="false">Giao thành công</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-giao-that-bai-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-giao-that-bai" type="button" role="tab"
                                    aria-controls="pills-giao-that-bai" aria-selected="false">Giao thất bại</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-don-huy-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-don-huy" type="button" role="tab"
                                    aria-controls="pills-don-huy" aria-selected="false">Đơn hủy</button>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class="tab-content mb-3" id="pills-tabContent">
                            <!-- Chờ xác nhận -->
                            <div class="tab-pane fade show active" id="pills-cho-xac-nhan" role="tabpanel"
                                aria-labelledby="pills-cho-xac-nhan-tab">
                                <!-- Nội dung cho đơn hàng chờ xác nhận -->
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <!-- Cột 1 -->
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <!-- Cột 2 -->
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <!-- Cột 3 -->
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <!-- Cột 4 -->
                                        <select id="nhan-vien-select" class="form-control"
                                            aria-label="Chọn nhân viên phụ trách đơn">
                                            <option selected>Chọn nhân viên phụ trách đơn</option>
                                            @foreach ($nhanVien as $nv)
                                                <option value="{{ $nv->idtk }}">{{ $nv->hoten }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Nội dung cho đơn hàng chờ xác nhận -->
                                <div class="table-responsive" style="margin-top: 25px">
                                    <table id="customer-table" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Xác Nhận</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Xác Nhận</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($choXacNhan as $dh)
                                                <tr>
                                                    <td>{{ $dh->iddh }}</td>
                                                    <td>{{ $dh->tennhan }}</td>
                                                    <td style="max-width: 250px;">{{ $dh->diachigiao }}</td>
                                                    <td>{{ $dh->sdt }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($dh->ngaydat)}}</td>
                                                    <td>{{ $dh->pttt }}</td>
                                                    <td>{{ number_format($dh->tongtien, 0, ',', '.') }}</td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="#" id="chuyen-trang-thai"
                                                                class="btn btn-link btn-success" data-bs-toggle="tooltip"
                                                                title="Hủy"
                                                                onclick="return checkSelect('{{ $dh->iddh }}');">
                                                                <i class="fa fa-check"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chiTiet', ['id' => $dh->iddh]) }}"
                                                                class="btn btn-link btn-info" data-bs-toggle="tooltip"
                                                                title="Xem chi tiết">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>

                                                    {{-- <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chuyenTrangThai', ['id' => $dh->iddh, 'trangThai' => 'Đang giao']) }}"
                                                                class="btn btn-link btn-success" data-bs-toggle="tooltip"
                                                                title="Hủy">
                                                                <i class="fa fa-check"></i>
                                                            </a>
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-footer d-flex justify-content-center">
                                    {{ $choXacNhan->appends(request()->input())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>

                            <!-- Đóng gói -->
                            <div class="tab-pane fade" id="pills-dong-goi" role="tabpanel"
                                aria-labelledby="pills-dong-goi-tab">
                                <!-- Nội dung cho đơn hàng đóng gói -->
                                {{-- <div class="row">
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <!-- Cột 1 -->
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <!-- Cột 2 -->
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <!-- Cột 3 -->
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <!-- Cột 4 -->
                                    </div>
                                </div> --}}
                                <!-- Nội dung cho đơn hàng đóng gói -->
                                <div class="table-responsive" style="margin-top: 25px">
                                    <table id="customer-table" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Phụ trách</th>
                                                <th>Hủy</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Phụ trách</th>
                                                <th>Hủy</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($dongGoi as $dh)
                                                <tr>
                                                    <td>{{ $dh->iddh }}</td>
                                                    <td>{{ $dh->tennhan }}</td>
                                                    <td style="max-width: 250px;">{{ $dh->diachigiao }}</td>
                                                    <td>{{ $dh->sdt }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($dh->ngaydat) }}</td>
                                                    <td>{{ $dh->pttt }}</td>
                                                    <td>{{ $dh->tongtien }}</td>
                                                    <td>{{ $dh->nhanvien ? $dh->nhanvien->hoten : 'Chưa phân công' }}</td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chuyenTrangThai', ['id' => $dh->iddh, 'trangThai' => 'Đơn hủy']) }}"
                                                                class="btn btn-link btn-danger" data-bs-toggle="tooltip"
                                                                title="Hủy">
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chiTiet', ['id' => $dh->iddh]) }}"
                                                                class="btn btn-link btn-info" data-bs-toggle="tooltip"
                                                                title="Xem chi tiết">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    {{ $dongGoi->appends(request()->input())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>

                            <!-- Đang giao -->
                            <div class="tab-pane fade" id="pills-dang-giao" role="tabpanel"
                                aria-labelledby="pills-dang-giao-tab">
                                <!-- Nội dung cho đơn hàng đang giao -->
                                <div class="table-responsive" style="margin-top: 25px">
                                    <table id="customer-table" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Phụ trách</th>
                                                <th>Hủy</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Phụ trách</th>
                                                <th>Hủy</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($dangGiao as $dh)
                                                <tr>
                                                    <td>{{ $dh->iddh }}</td>
                                                    <td>{{ $dh->tennhan }}</td>
                                                    <td style="max-width: 250px;">{{ $dh->diachigiao }}</td>
                                                    <td>{{ $dh->sdt }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($dh->ngaydat) }}</td>
                                                    <td>{{ $dh->pttt }}</td>
                                                    <td>{{ $dh->tongtien }}</td>
                                                    <td>{{ $dh->nhanvien ? $dh->nhanvien->hoten : 'Chưa phân công' }}</td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chuyenTrangThai', ['id' => $dh->iddh, 'trangThai' => 'Giao thất bại']) }}"
                                                                class="btn btn-link btn-danger" data-bs-toggle="tooltip"
                                                                title="Hủy">
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chiTiet', ['id' => $dh->iddh]) }}"
                                                                class="btn btn-link btn-info" data-bs-toggle="tooltip"
                                                                title="Xem chi tiết">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    {{ $dangGiao->appends(request()->input())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>

                            <!-- Giao thành công -->
                            <div class="tab-pane fade" id="pills-giao-thanh-cong" role="tabpanel"
                                aria-labelledby="pills-giao-thanh-cong-tab">
                                <!-- Nội dung cho đơn hàng giao thành công -->
                                <div class="table-responsive" style="margin-top: 25px">
                                    <table id="customer-table" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Phụ trách</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Phụ trách</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($giaoThanhCong as $dh)
                                                <tr>
                                                    <td>{{ $dh->iddh }}</td>
                                                    <td>{{ $dh->tennhan }}</td>
                                                    <td style="max-width: 250px;">{{ $dh->diachigiao }}</td>
                                                    <td>{{ $dh->sdt }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($dh->ngaydat) }}</td>
                                                    <td>{{ $dh->pttt }}</td>
                                                    <td>{{ $dh->tongtien }}</td>
                                                    <td>{{ $dh->nhanvien ? $dh->nhanvien->hoten : 'Chưa phân công' }}</td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chiTiet', ['id' => $dh->iddh]) }}"
                                                                class="btn btn-link btn-info" data-bs-toggle="tooltip"
                                                                title="Xem chi tiết">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    {{-- <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chuyenTrangThai', ['id' => $dh->iddh, 'trangThai' => 'Đang giao']) }}"
                                                                class="btn btn-link btn-success" data-bs-toggle="tooltip"
                                                                title="Hủy">
                                                                <i class="fa fa-check"></i>
                                                            </a>
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    {{ $giaoThanhCong ->appends(request()->input())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>

                            <!-- Giao thất bại -->
                            <div class="tab-pane fade" id="pills-giao-that-bai" role="tabpanel"
                                aria-labelledby="pills-giao-that-bai-tab">
                                <!-- Nội dung cho đơn hàng giao thất bại -->
                                <div class="table-responsive" style="margin-top: 25px">
                                    <table id="customer-table" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Phụ trách</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Phụ trách</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($giaoThatBai as $dh)
                                                <tr>
                                                    <td>{{ $dh->iddh }}</td>
                                                    <td>{{ $dh->tennhan }}</td>
                                                    <td style="max-width: 250px;">{{ $dh->diachigiao }}</td>
                                                    <td>{{ $dh->sdt }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($dh->ngaydat) }}</td>
                                                    <td>{{ $dh->pttt }}</td>
                                                    <td>{{ $dh->tongtien }}</td>
                                                    <td>{{ $dh->nhanvien ? $dh->nhanvien->hoten : 'Chưa phân công' }}</td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chiTiet', ['id' => $dh->iddh]) }}"
                                                                class="btn btn-link btn-info" data-bs-toggle="tooltip"
                                                                title="Xem chi tiết">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    {{-- <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chuyenTrangThai', ['id' => $dh->iddh, 'trangThai' => 'Đang giao']) }}"
                                                                class="btn btn-link btn-success" data-bs-toggle="tooltip"
                                                                title="Hủy">
                                                                <i class="fa fa-check"></i>
                                                            </a>
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    {{ $giaoThatBai->appends(request()->input())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>

                            <!-- Đơn hủy -->
                            <div class="tab-pane fade" id="pills-don-huy" role="tabpanel"
                                aria-labelledby="pills-don-huy-tab">
                                <!-- Nội dung cho đơn hủy -->
                                <div class="table-responsive" style="margin-top: 25px">
                                    <table id="customer-table" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Phụ trách</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Id</th>
                                                <th>Người Nhận</th>
                                                <th>Địa Chỉ Giao</th>
                                                <th>SĐT Người Nhận</th>
                                                <th>Ngày đặt</th>
                                                <th>PTTT</th>
                                                <th>Tổng Tiền</th>
                                                <th>Phụ trách</th>
                                                <th>Chi tiết</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($donHuy as $dh)
                                                <tr>
                                                    <td>{{ $dh->iddh }}</td>
                                                    <td>{{ $dh->tennhan }}</td>
                                                    <td style="max-width: 250px;">{{ $dh->diachigiao }}</td>
                                                    <td>{{ $dh->sdt }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($dh->ngaydat) }}</td>
                                                    <td>{{ $dh->pttt }}</td>
                                                    <td>{{ $dh->tongtien }}</td>
                                                    <td>{{ $dh->nhanvien ? $dh->nhanvien->hoten : 'Chưa phân công' }}</td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chiTiet', ['id' => $dh->iddh]) }}"
                                                                class="btn btn-link btn-info" data-bs-toggle="tooltip"
                                                                title="Xem chi tiết">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                    {{-- <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('admin.QLDonHang.chuyenTrangThai', ['id' => $dh->iddh, 'trangThai' => 'Đang giao']) }}"
                                                                class="btn btn-link btn-success" data-bs-toggle="tooltip"
                                                                title="Hủy">
                                                                <i class="fa fa-check"></i>
                                                            </a>
                                                        </div>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer d-flex justify-content-center">
                                    {{ $donHuy->appends(request()->input())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Style for nav-pills */
        .nav-pills {
            display: flex;
            justify-content: space-between;
        }

        .nav-pills .nav-item {
            flex: 1;
            text-align: center;
        }

        .nav-pills .nav-link {
            border: 1px solid #ebecec !important;
            border-radius: 0 !important;
            color: #2a2f5b !important;
            padding: 20px 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        .nav-pills .nav-link.active {
            background-color: #1572e8 !important;
            color: white !important;
        }

        .tab-content .tab-pane {
            border: 1px solid #ebecec;
            padding: 15px;
            color: #2a2f5b;
        }

        /* Adjust button hover color */
        .nav-pills .nav-link:hover {
            background-color: #1572e8 !important;
            color: white !important;
        }

        

        thead tr {
            position: sticky;
            /* Giữ vị trí cố định */
            top: 0;
            /* Màu nền cho phần đầu bảng */
            z-index: 1;
            /* Đảm bảo phần đầu bảng nằm trên các hàng khác */
            border-bottom: 5px solid #1572e8 !important;
            /* Viền dưới cho phần đầu bảng */
            background-color: #fff;
        }

        tfoot tr {
            position: sticky;
            /* Giữ vị trí cố định */
            bottom: 0;
            /* Màu nền cho phần đầu bảng */
            z-index: 1;
            /* Đảm bảo phần đầu bảng nằm trên các hàng khác */
            border-top: 5px solid #1572e8 !important;
            /* Viền dưới cho phần đầu bảng */
            background-color: #fff;
        }
    </style>


    <script>
        // Lưu trạng thái tab hiện tại vào sessionStorage
        document.addEventListener("DOMContentLoaded", function() {
            var activeTab = sessionStorage.getItem("activeTab");
            if (activeTab) {
                var activeTabElement = document.querySelector(`[data-bs-target="${activeTab}"]`);
                if (activeTabElement) {
                    var tab = new bootstrap.Tab(activeTabElement);
                    tab.show();
                }
            }

            var scrollPosition = sessionStorage.getItem("scrollPosition");
            if (scrollPosition) {
                window.scrollTo(0, scrollPosition); // Khôi phục vị trí cuộn
            }
        });

        // Lưu tab đang active và vị trí cuộn khi tab bị thay đổi
        document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(function(tabButton) {
            tabButton.addEventListener("shown.bs.tab", function(e) {
                sessionStorage.setItem("activeTab", e.target.getAttribute("data-bs-target"));
            });
        });

        // Lưu vị trí cuộn trước khi chuyển trang
        window.addEventListener("beforeunload", function() {
            sessionStorage.setItem("scrollPosition", window.scrollY);
        });

        // Hàm kiểm tra chọn nhân viên
        function checkSelect(dhId) { // Nhận tham số dhId
            var select = document.getElementById('nhan-vien-select');
            var selectedValue = select.value;

            console.log("Giá trị selectedValue: ", selectedValue); // In ra giá trị

            if (selectedValue === "Chọn nhân viên phụ trách đơn") {
                alert("Vui lòng chọn nhân viên phụ trách đơn trước khi chuyển trạng thái.");
                return false; // Ngăn không cho tiếp tục
            } else {
                var trangThai = 'Đóng gói';
                // Nếu đã chọn nhân viên, chuyển đến trang chuyển trạng thái
                var url =
                    "{{ route('admin.QLDonHang.chuyenTrangThai', ['id' => '__id__', 'trangThai' => '__trangThai__']) }}";
                url = url.replace('__id__', dhId).replace('__trangThai__', trangThai) + "?idnvgh=" + selectedValue;

                window.location.href = url; // Chuyển hướng đến URL
                return true; // Cho phép tiếp tục
            }
        }
    </script>
@endsection

{{-- .table-responsive {
    max-height: 400px;
    /* Chiều cao tối đa cho bảng */
    overflow-y: auto;
    /* Cho phép cuộn theo chiều dọc */
} --}}