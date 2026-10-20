@extends('admin.layout.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Chi tiết đơn hàng #{{ $donHang->iddh }}</h3>
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
                    <a href="#">Chi tiết đơn hàng</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-12">
                <div style="border: 1px solid #e0e0e0; border-radius: 5px; padding: 20px;">
                    <h5><b>Thông tin đơn hàng</b></h5>
                    <p><strong>Tên Người Nhận:</strong> {{ $donHang->tennhan }}</p>
                    <p><strong>Số Điện Thoại:</strong> {{ $donHang->sdt }}</p>
                    <p><strong>Địa Chỉ Giao:</strong> {{ $donHang->diachigiao }}</p>
                    <p><strong>Ngày Đặt:</strong> {{ \Carbon\Carbon::parse($donHang->ngaydat)->format('d/m/Y') }}</p>
                    <p><strong>Ngày Giao:</strong> {{ \Carbon\Carbon::parse($donHang->ngaygiao)->format('d/m/Y') }}</p>
                    <p><strong>Ghi Chú:</strong> {{ $donHang->ghichu }}</p>
                    <p><strong>Tổng Tiền:</strong> {{ number_format($donHang->tongtien, 0, ',', '.') }} VND</p>
                    <hr>

                    <h5>Chi tiết sản phẩm</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID Sản Phẩm</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Số Lượng</th>
                                <th>Đơn Giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($donHang->chiTietDonHang as $chiTiet)
                                <tr>
                                    <td>{{ $chiTiet->sanpham->idsp }}</td>
                                    <td>{{ $chiTiet->sanpham->tensp }}</td>
                                    <td>{{ $chiTiet->soluong }}</td>
                                    <td>{{ number_format($chiTiet->sanpham->gia, 0, ',', '.') }} VND</td>
                                    {{-- <td>{{ number_format($chiTiet->soluong * $chiTiet->sanpham->gia, 0, ',', '.') }} VND</td> --}}
                                    <td>{{ number_format($chiTiet->tong, 0, ',', '.') }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
