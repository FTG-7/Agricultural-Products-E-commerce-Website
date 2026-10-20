@extends('admin.layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Danh Sách Phiếu Nhập</h3>
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
                        <a href="#">Phiếu Nhập</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Danh Sách Phiếu Nhập</h4>
                                {{-- nút thêm phiếu nhập --}}
                                <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#addRowModal">
                                    <i class="fa fa-plus"></i>
                                    Thêm Phiếu Nhập
                                </button>
                                <!-- Gọi modal tạo phiếu nhập -->
                                @include('admin.PhieuNhap.create')

                            </div>
                        </div>

                        <div class="row mt-2">
                            <!-- Tìm kiếm -->
                            <div class="col-md-4 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                                <form method="GET" action="{{ route('admin.PhieuNhap.show') }}">
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="field" aria-label="Chọn trường tìm kiếm">
                                            <option value="idpn" {{ request('field') == 'idpn' ? 'selected' : '' }}>Mã phiếu nhập</option>
                                            <option value="tennhacungcap" {{ request('field') == 'tennhacungcap' ? 'selected' : '' }}>Nhà cung cấp</option>
                                        </select>
                                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm"
                                            value="{{ request('search') }}">

                                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                                        <input type="hidden" name="sort_field" value="{{ request('sort_field') }}">
                                        <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Sắp xếp -->
                            <div class="col-md-4 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                                <form method="GET" action="{{ route('admin.PhieuNhap.show') }}">
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="sort_field" aria-label="Sắp xếp theo"
                                            style="min-width: 150px;">
                                            <option value="idsp" {{ request('sort_field') == 'idpn' ? 'selected' : '' }}>
                                                Mã phiếu nhập</option>
                                            <option value="tensp"
                                                {{ request('sort_field') == 'tongtien' ? 'selected' : '' }}>Tổng tiền
                                            </option>
                                        </select>
                                        <select class="form-select" name="sort" aria-label="Thứ tự sắp xếp">
                                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Tăng
                                                dần</option>
                                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Giảm
                                                dần</option>
                                        </select>

                                        <input type="hidden" name="field" value="{{ request('field') }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <button class="btn btn-outline-secondary" type="submit">Sắp xếp</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive" style="margin-top: 25px">
                            <table id="product-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên Nhà Cung Cấp</th>
                                        <th>Ngày Lập</th>
                                        <th>Tổng Tiền</th>
                                        <th>Ghi Chú</th>
                                        <th>Trạng Thái</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên Nhà Cung Cấp</th>
                                        <th>Ngày Lập</th>
                                        <th>Tổng Tiền</th>
                                        <th>Ghi Chú</th>
                                        <th>Trạng Thái</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($PhieuNhap as $pn)
                                    <tr>
                                        <td>{{ $pn->idpn }}</td>
                                        <td>{{ $pn->tennhacungcap }}</td>
                                        <td>{{ date('d-m-Y', strtotime($pn->ngaylap)) }}</td>
                                        <td>{{ number_format($pn->tongtien, 0, ',', '.') }} VND</td>
                                        <td>{{ $pn->ghichu }}</td>
                                        <td>{{ $pn->xacnhan == 1 ? 'Đã Xác Nhận' : 'Chưa Xác Nhận' }}</td>
                                        <td>
                                            @if ($pn->xacnhan == 1)
                                            <a href="{{ route('admin.PhieuNhap.info', $pn->idpn) }}"
                                                class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Thông tin chi tiết">
                                                <i class="fa fa-info"></i>
                                            </a>
                                            @else
                                            <div class="form-button-action">
                                                <a href="{{ route('admin.PhieuNhap.edit', $pn->idpn) }}" class="btn btn-link btn-primary btn-lg"
                                                    data-bs-toggle="tooltip" title="Chỉnh sửa">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                        
                                                <form action="{{ route('admin.PhieuNhap.delete', $pn->idpn) }}" method="GET"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa phiếu nhập này?');" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Xóa">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                        
                                                <form action="{{ route('admin.PhieuNhap.confirm', $pn->idpn) }}" method="POST"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xác nhận phiếu nhập này?');" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-link text-success" data-bs-toggle="tooltip"
                                                        title="Xác Nhận">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        <div class="d-flex justify-content-center">
                            {{ $PhieuNhap->appends(request()->input())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var addRowModal = new bootstrap.Modal(document.getElementById('addRowModal'));
                addRowModal.show();
            });
        </script>
    @endif
@endsection
