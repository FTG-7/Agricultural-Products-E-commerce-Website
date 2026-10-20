@extends('admin.layout.master')

@Section('content')
    <?php
    use App\Models\SanPham; // Thêm dòng này để import class SanPham
    ?>
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Khuyến mãi</h3>
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
                        <a href="#">khuyến Mãi</a>
                    </li>
                
                </ul>
            </div>
            <div class="row">



                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Khuyến Mãi</h4>
                                <a href="{{ route('admin.KhuyenMai.create') }}" class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Khuyến Mãi
                                </a>
                            </div>
           

                        <div class="row mt-2">
                            <!-- Tìm kiếm -->
                            <div class="col-md-6 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                                <form method="GET" action="{{ route('admin.KhuyenMai.index') }}">
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="field" aria-label="Chọn trường tìm kiếm">
                                            <option value="idkm" {{ request('field') == 'idkm' ? 'selected' : '' }}> Mã khuyến mãi </option>
                                            <option value="tenkm" {{ request('field') == 'tenkm' ? 'selected' : '' }}>Tên khuyến mãi</option>
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
                            <div class="col-md-6 mb-3 d-flex align-items-center" style="padding-left: 50px;">
                                <form method="GET" action="{{ route('admin.KhuyenMai.index') }}">
                                    <div class="input-group mb-3">
                                        <select class="form-select" name="sort_field" aria-label="Sắp xếp theo"
                                            style="min-width: 150px;">
                                            <option value="idkm" {{ request('sort_field') == 'idkm' ? 'selected' : '' }}>
                                                Mã khuyến mãi</option>
                                            <option value="tenkm"
                                                {{ request('sort_field') == 'tenkm' ? 'selected' : '' }}>Tên khuyến mãi
                                            </option>
                                            <option value="loaikm" {{ request('sort_field') == 'loaikm' ? 'selected' : '' }}>
                                                Loại khuyến mãi</option>
                                            <option value="ngaydb"
                                                {{ request('sort_field') == 'ngaydb' ? 'selected' : '' }}>Ngày bắt đầu</option>
                                            <option value="ngaykt"
                                                {{ request('sort_field') == 'ngaydb' ? 'selected' : '' }}>Ngày kết thúc</option>
                                        </select>
                                        <select class="form-select" name="sort" aria-label="Thứ tự sắp xếp" style="padding-left: 50px;">
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

                        </div>

                        <div class="table-responsive" style="margin-top: 25px">
                            <table id="promotion-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Tên KM</th>
                                        <th>Loại KM</th>
                                        <th>Điều kiện số lượng</th>
                                        <th>khuyến mãi</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Tình trạng</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Tên KM</th>
                                        <th>Loại KM</th>
                                        <th>Điều kiện số lượng</th>
                                        <th>khuyến mãi</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Tình trạng</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php foreach ($khuyenmai as $KT) : ?>
                                    <tr>
                                        <td><?= $KT->idkm ?></td>
                                        <td><?= $KT->tenkm ?></td>
                                        <td><?= $KT->loaikm ?></td>
                                        <td><?= $KT->dieukien ?></td>
                                        <td>
                                            <?php
                                            
                                                echo htmlspecialchars($KT->noidungkm) . '%';
                                            
                                            ?>
                                        </td>
                                        <td><?= date('d-m-Y', strtotime($KT->ngaybd)) ?></td>
                                        <td><?= date('d-m-Y', strtotime($KT->ngaykt)) ?></td>
                                        <td> <?= $KT->trangthai == 1 ? 'Còn áp dụng' : 'Hết hạn' ?></td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('admin.KhuyenMai.edit', $KT->idkm) }}" class="btn btn-link btn-primary btn-lg"
                                                    data-bs-toggle="tooltip" title="Edit Task"
                                                    data-original-title="Edit Task">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.KhuyenMai.delete', $KT->idkm) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa khuyến mãi này?');"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-danger"
                                                        data-bs-toggle="tooltip" title="Remove"
                                                        data-original-title="Remove">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>


                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>




                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            {{ $khuyenmai->appends(request()->input())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    </div>

    </div>
@endsection
