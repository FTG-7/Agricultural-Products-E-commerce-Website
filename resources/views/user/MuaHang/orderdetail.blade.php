@extends('user.layout.master')

@section('content')
    <!-- Single Page Header Start -->
    <div class="container-fluid page-header py-5" style="background-color: #8BC34A;">
        <h1 class="text-center text-white display-6">Chi Tiết Đơn Hàng</h1>
    </div>
    <!-- Single Page Header End -->

    <!-- Order Detail Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">

            <!-- Hiển thị id của đơn hàng và các thông tin khác của đơn hàng -->
            <div class="d-flex align-items-center mb-4">
                <!-- Nút quay về -->
                <a href="{{ route('MuaHang.showdonhang') }}" class="btn custom-btn btn-sm me-3" title="Trở Về">
                    <i class="fas fa-arrow-left"></i> Trở Về
                </a>
                <h1 class="mb-0 ms-2">Đơn Hàng #{{ $donHang->iddh ?? 'N/A' }}</h1>
            </div>

            <div class="mb-4 p-4 rounded" style="background-color: #F1F8E9;">
                <p><strong>Ngày đặt hàng:</strong> {{ $donHang->ngaydat ?? 'N/A' }}</p>
                <p><strong>Trạng thái:</strong> <span class="badge bg-success" style="font-size: 15px;">{{ $donHang->trangthai ?? 'N/A' }}</span></p>

                
                <p><strong>Trạng thái thanh toán:</strong> 
                    <span style="font-size: 15px;" class="badge {{ $donHang->ttthanhtoan === 1 ? 'bg-success' : 'bg-danger' }}">
                        {{ $donHang->ttthanhtoan === 1 ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                    </span>
                </p>

                <p><strong>Địa chỉ giao hàng:</strong> {{ $donHang->diachigiao ?? 'N/A' }}</p>
                <p><strong>Ghi chú:</strong> {{ $donHang->ghichu ?? 'Không có' }}</p>
            </div>

            <div class="table-responsive mb-4" style="max-height: 350px; overflow-y: auto;">
                <table class="table">
                    <thead style="background-color: #8BC34A; color: white;">
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col" class="text-end">Giá</th>
                            <th scope="col" class="text-end">Số lượng</th>
                            <th scope="col" class="text-end">Tổng</th>
                            <th scope="col" class="text-end">Chi tiết</th>
                            <th scope="col" class="text-end">Mua lại</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chiTietDonHang as $item)
                            <tr>
                                <td>
                                    <!-- Hiển thị tên sản phẩm và ảnh sản phẩm -->
                                    <div class="d-flex">
                                        <div class="me-3">
                                            @if ($item->sanPham->anh->isNotEmpty())
                                                <img src="/imgsp/{{ $item->sanPham->anh->first()->tenanh }}" alt="Sản phẩm" style="width: 150px; height: 150px; object-fit: cover; border-radius:10px;">
                                            @else
                                                <img src="/imgsp/noImage.jpg" alt="Sản phẩm" style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                        </div>
                                        <div style="font-size: 30px;">
                                            {{ $item->tensp }}
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end" style="font-size: 20px;">{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                                <td class="text-end" style="font-size: 20px;">{{ $item->soluong }}</td>
                                <td class="text-end" style="font-size: 20px;">{{ number_format($item->tong, 0, ',', '.') }} VNĐ</td>
                                <td class="text-end">
                                    <a href="{{ route('user.ds_SanPham.detail_product', $item->idsp) }}" class="btn btn-warning btn-sm py-2 px-3">Chi tiết</a>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('cart.addmn', ['idsp' => $item->idsp, 'quantity' => $item->soluong]) }}" class="btn btn-success btn-sm py-2 px-3">Mua lại</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-3 rounded text-end" style="background-color: #F1F8E9;">
                <h4 class="mb-0">Phí vận chuyển: 
                    <span class="text-danger">
                        {{ number_format($donHang->tongtien - $chiTietDonHang->sum('tong'), 0, ',', '.') }} VNĐ
                    </span>
                </h4>
            </div>

            <div class="p-3 rounded text-end" style="background-color: #F1F8E9;">
                <h4 class="mb-0">Tổng cộng: 
                    <span class="text-danger">
                        {{ number_format($donHang->tongtien, 0, ',', '.') }} VNĐ
                    </span>
                </h4>
            </div>

            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                <div class="col-md-12">
                    <a href="{{ route('order.buyAgain', $donHang->iddh) }}" class="btn btn-primary border-secondary py-3 px-4 text-uppercase w-100" style="color: white;">Mua lại</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Detail Page End -->

    <style>
        .table thead tr {
            position: sticky;
            top: 0;
            background-color: #8BC34A;
            z-index: 1;
            border-bottom: 2px solid #7CB342;
        }

        .custom-btn {
            background-color: #8BC34A;
            border-color: #8BC34A;
            color: white;
        }

        .custom-btn:hover {
            background-color: #7CB342;
            border-color: #7CB342;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
@endsection
