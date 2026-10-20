@extends('admin.layout.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Danh Sách Khách Hàng</h3>
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
                    <a href="#">Khách Hàng</a>
                </li>
            </ul>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Danh Sách Khách Hàng</h4>
                            
                            {{-- <button
                                class="btn btn-primary btn-round ms-auto"
                                data-bs-toggle="modal"
                                data-bs-target="#addCustomerModal">
                                <i class="fa fa-plus" style="margin-right: 0.7rem"></i>
                                Thêm Khách Hàng 
                            </button> --}}

                            
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                            <!-- Sắp xếp -->
                            <form method="GET" action="{{ route('admin.KhachHang.index') }}">
                                <div class="input-group mb-3">
                                    <select class="form-select" name="sort" aria-label="Sắp xếp theo">
                                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                                    </select>
                                    <select class="form-select" name="sort_field" aria-label="Sắp xếp theo" style="min-width: 150px;">
                                        <option value="idtk" {{ request('sort_field') == 'idtk' ? 'selected' : '' }}>Mã khách hàng</option>
                                        <option value="hoten" {{ request('sort_field') == 'hoten' ? 'selected' : '' }}>Họ tên</option>
                                        <option value="gioitinh" {{ request('sort_field') == 'gioitinh' ? 'selected' : '' }}>Giới tính</option>
                                        <option value="ngaysinh" {{ request('sort_field') == 'ngaysinh' ? 'selected' : '' }}>Ngày sinh</option>
                                    </select>
                                    <input type="hidden" name="field" value="{{ request('field') }}">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="nlock" value="0">
                                    <button class="btn btn-outline-secondary" type="submit">Sắp xếp</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                            <!-- Tìm kiếm -->
                            <form method="GET" action="{{ route('admin.KhachHang.index') }}" >
                                <div class="input-group mb-3">
                                    <select class="form-select" name="field" aria-label="Chọn trường tìm kiếm">
                                        <option value="idtk" {{ request('field') == 'idtk' ? 'selected' : '' }}>Mã khách hàng</option>
                                        <option value="hoten" {{ request('field') == 'hoten' ? 'selected' : '' }}>Họ tên</option>
                                        <option value="sdt" {{ request('field') == 'sdt' ? 'selected' : '' }}>SĐT</option>
                                        <option value="email" {{ request('field') == 'email' ? 'selected' : '' }}>Email</option>
                                    </select>
                                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm" value="{{ request('search') }}">
                                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                                    <input type="hidden" name="sort_field" value="{{ request('sort_field') }}">
                                    <input type="hidden" name="nlock" value="0">
                                    <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive" style="margin-top: 25px">
                        <table id="customer-table" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ Tên</th>
                                    <th>Giới Tính</th>
                                    <th>Ngày Sinh</th>
                                    <th>SĐT</th>
                                    <th>Email</th>
                                    <th>Trạng Thái</th>
                                    <th style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ Tên</th>
                                    <th>Giới Tính</th>
                                    <th>Ngày Sinh</th>
                                    <th>SĐT</th>
                                    <th>Email</th>
                                    <th>Trạng Thái</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->idtk }}</td>
                                    <td>{{ $customer->hoten }}</td>
                                    <td>{{ $customer->gioitinh }}</td>
                                    <td>{{ \Carbon\Carbon::parse($customer->ngaysinh)->format('d/m/Y') }}</td>
                                    <td>{{ $customer->sdt }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->trangthai == 1 ? 'Đã kích hoạt' : 'Chưa kích hoạt' }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="{{ route('admin.KhachHang.lock', $customer->idtk) }}" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Khóa Khách Hàng">
                                                <i class="fa fa-lock"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Danh Sách Đen</h4>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                            <!-- Sắp xếp -->
                            <form method="GET" action="{{ route('admin.KhachHang.index') }}">
                                <div class="input-group mb-3">
                                    <select class="form-select" name="sort1" aria-label="Sắp xếp theo">
                                        <option value="asc" {{ request('sort1') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                                        <option value="desc" {{ request('sort1') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                                    </select>
                                    <select class="form-select" name="sort_field1" aria-label="Sắp xếp theo" style="min-width: 150px;">
                                        <option value="idtk" {{ request('sort_field1') == 'idtk' ? 'selected' : '' }}>Mã khách hàng</option>
                                        <option value="hoten" {{ request('sort_field1') == 'hoten' ? 'selected' : '' }}>Họ tên</option>
                                        <option value="gioitinh" {{ request('sort_field1') == 'gioitinh' ? 'selected' : '' }}>Giới tính</option>
                                        <option value="ngaysinh" {{ request('sort_field1') == 'ngaysinh' ? 'selected' : '' }}>Ngày sinh</option>
                                    </select>
                                    <input type="hidden" name="field1" value="{{ request('field') }}">
                                    <input type="hidden" name="search1" value="{{ request('search') }}">
                                    <input type="hidden" name="lock" value="1">
                                    <button class="btn btn-outline-secondary" type="submit">Sắp xếp</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                            <!-- Tìm kiếm -->
                            <form method="GET" action="{{ route('admin.KhachHang.index') }}">
                                <div class="input-group mb-3">
                                    <select class="form-select" name="field1" aria-label="Chọn trường tìm kiếm">
                                        <option value="idtk" {{ request('field1') == 'idtk' ? 'selected' : '' }}>Mã khách hàng</option>
                                        <option value="hoten" {{ request('field1') == 'hoten' ? 'selected' : '' }}>Họ tên</option>
                                        <option value="sdt" {{ request('field1') == 'sdt' ? 'selected' : '' }}>SĐT</option>
                                        <option value="email" {{ request('field1') == 'email' ? 'selected' : '' }}>Email</option>
                                    </select>
                                    <input type="text" class="form-control" name="search1" placeholder="Tìm kiếm" value="{{ request('search1') }}">
                                    <input type="hidden" name="sort1" value="{{ request('sort') }}">
                                    <input type="hidden" name="sort_field1" value="{{ request('sort_field') }}">
                                    <input type="hidden" name="lock" value="1">
                                    <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive" style="margin-top: 25px">
                        <table id="lock-customer-table" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ Tên</th>
                                    <th>Giới Tính</th>
                                    <th>Ngày Sinh</th>
                                    <th>SĐT</th>
                                    <th>Email</th>
                                    <th>Trạng Thái</th>
                                    <th style="width: 10%"></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ Tên</th>
                                    <th>Giới Tính</th>
                                    <th>Ngày Sinh</th>
                                    <th>SĐT</th>
                                    <th>Email</th>
                                    <th>Trạng Thái</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($lock_customers as $customer)
                                <tr>
                                    <td>{{ $customer->idtk }}</td>
                                    <td>{{ $customer->hoten }}</td>
                                    <td>{{ $customer->gioitinh }}</td>
                                    <td>{{ \Carbon\Carbon::parse($customer->ngaysinh)->format('d/m/Y') }}</td>
                                    <td>{{ $customer->sdt }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->trangthai == 1 ? 'Đã kích hoạt' : 'Chưa kích hoạt' }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="{{ route('admin.KhachHang.unlock', $customer->idtk) }}" class="btn btn-link btn-success" data-bs-toggle="tooltip" title="Mở Khóa Khách Hàng">
                                                <i class="fa fa-unlock"></i>
                                            </a>
                                        </div>
                                    </td>
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
    .table-responsive {
    overflow-x: auto; /* Thanh cuộn ngang */
    max-height: 500px; /* Giới hạn chiều cao của bảng nếu cần */
    }
</style>
@endsection
