@extends('admin.layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Sản Phẩm Hết Hạn</h3>
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
                        <a href="#">Sản Phẩm Hết Hạn</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Danh Sách Sản Phẩm Hết Hạn</h4>

                            </div>
                        </div>

                        <div class="row mt-2">
                            <!-- Tìm kiếm theo ngày -->
                            <div class="col-md-6 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                                <form method="GET" action="{{ route('admin.SanPham.sphh_index') }}">
                                    <div class="input-group mb-3">
                                        <input type="date" class="form-control" name="date_filter"
                                            value="{{ request('date_filter') }}">
                                        <button class="btn btn-outline-secondary" type="submit">Lọc</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive" style="margin-top: 25px">
                            <table id="product-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng hết hạn</th>
                                        <th>Số lượng còn</th>
                                        <th>Ngày hết hạn</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng hết hạn</th>
                                        <th>Số lượng còn</th>
                                        <th>Ngày hết hạn</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($sphethan as $product)
                                        <tr>
                                            <td>{{ $product->idhh }}</td>
                                            <td>{{ $product->sanPham->tensp }}</td>
                                            <td>{{ $product->soluong }}</td>
                                            <td>{{ $product->sanPham->soluong }}</td>
                                            <td>{{ date('d-m-Y', strtotime($product->ngayhh)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer d-flex justify-content-center">
                            {{ $sphethan->appends(request()->input())->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
