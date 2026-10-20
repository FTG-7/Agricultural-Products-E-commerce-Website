@extends('admin.layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Quản Lý Đơn Đổi Trả</h3>
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
                        <a href="#">Đơn Đổi Trả</a>
                    </li>
                </ul>
            </div>
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5><b>Thông tin đơn đổi trả</b></h5>
                            <p><strong>ID Đổi Trả:</strong> {{ $doiTra->iddt }}</p>
                            <p><strong>Trạng Thái:</strong> {{ $doiTra->trangthai }}</p>
                            <p><strong>Ngày Tạo:</strong> {{ \Carbon\Carbon::parse($doiTra->ngaytao)->format('d/m/Y') }}</p>
                            <p><strong>Ghi Chú:</strong> {{ $doiTra->ghichu }}</p>
                            <p><strong>Nhân Viên Lấy Hàng:</strong>
                                {{ $doiTra->nhanVien ? $doiTra->nhanVien->hoten : 'Chưa có' }}</p>
                            <hr>
                
                            <h5><b>Thông tin đơn hàng</b></h5>
                            <p><strong>ID Đơn Hàng:</strong> {{ $doiTra->donHang->iddh }}</p>
                            <p><strong>Tên Người Nhận:</strong> {{ $doiTra->donHang->tennhan }}</p>
                            <p><strong>Số Điện Thoại:</strong> {{ $doiTra->donHang->sdt }}</p>
                            <p><strong>Địa Chỉ Giao:</strong> {{ $doiTra->donHang->diachigiao }}</p>
                            <hr>
                
                            <h5><b>Chi tiết sản phẩm đổi trả</b></h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Sản Phẩm</th>
                                        <th>Tên Sản Phẩm</th>
                                        <th>Số Lượng</th>
                                        <th>Đơn Giá</th>
                                        <th>Thành Tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($doiTra->chiTietDoiTra as $chiTiet)
                                        <tr>
                                            <td>{{ $chiTiet->idsp }}</td>
                                            <td>{{ $chiTiet->tensp }}</td>
                                            <td>{{ $chiTiet->soluong }}</td>
                                            @php
                                                // Lấy giá của sản phẩm tương ứng từ chiTietDonHang
                                                $chiTietDonHang = $doiTra->donHang->chiTietDonHang->where('idsp', $chiTiet->idsp)->first();
                                            @endphp
                                            <td>{{ number_format($chiTietDonHang->gia, 0, ',', '.') }} VND</td>
                                            <td>{{ number_format($chiTiet->dongia, 0, ',', '.') }} VND</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                
                
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <h5>Hình Ảnh</h5>
                                    @if ($doiTra->hinh)
                                        <img src="{{ asset('imagedt/' . $doiTra->hinh) }}" alt="Hình Ảnh Đổi Trả"
                                            width="90%" height="90%">
                                    @else
                                        <p>Không có hình ảnh.</p>
                                    @endif
                                </div>
                                <div class="col-md-7">
                                    <h5>Video</h5>
                                    @if ($doiTra->video)
                                        <video width="90%" height="90%" controls>
                                            <source src="{{ asset('videodt/' . $doiTra->video) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <p>Không có video.</p>
                                    @endif
                                </div>
                            </div>
                
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection












