@extends('user.layout.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Giỏ hàng</h1>
    </div>
    <!-- Single Page Header End -->

    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalBill = 0; // Khởi tạo tổng tiền
                        @endphp

                        @foreach ($cartItems as $item)
                            <tr>
                                <td scope="row">
                                    <a href="{{ route('user.ds_SanPham.detail_product', $item->sanpham->idsp) }}">
                                        @if ($item->sanpham->Anh->isNotEmpty())
                                            <img src="{{ asset('imgsp/' . $item->sanpham->Anh->first()->tenanh) }}"
                                                class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                                alt="{{ $item->sanpham->tensp }}">
                                        @else
                                            <img src="{{ asset('imgsp/noImage.jpg') }}"
                                                class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;"
                                                alt="No Image">
                                        @endif
                                    </a>


                                </td>
                                <td>
                                    <p class="mb-0 mt-4"><a
                                            href="{{ route('user.ds_SanPham.detail_product', $item->sanpham->idsp) }}">{{ $item->sanpham->tensp }}</a>
                                    </p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">
                                        @if ($item->discountAmount > 0)
                                            <span style="text-decoration: line-through; color: red; font-size:15px">
                                                {{ number_format($item->dongia, 0, ',', '.') }} VNĐ
                                            </span>
                                            <span class="text-success">
                                                {{ number_format($item->dongia * (1 - $item->discountAmount / 100), 0, ',', '.') }}
                                                VNĐ /{{ $item->sanpham->donvitinh }}
                                            </span>
                                        @else
                                            <span class="text-success">
                                                {{ number_format($item->dongia, 0, ',', '.') }} VNĐ
                                                /{{ $item->sanpham->donvitinh }}
                                            </span>
                                        @endif
                                    </p>
                                    @if ($item->promoName)
                                        <p class="mt-2" style="color:red">
                                            {{ $item->promoName }}

                                        </p>
                                    @endif
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                onclick="updateQuantity('{{ $item->idgh }}', {{ $item->soluong - 1 }})">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0"
                                            value="{{ $item->soluong }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                onclick="updateQuantity('{{ $item->idgh }}', {{ $item->soluong + 1 }})">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <p class="mb-0 mt-4">
                                        @if ($item->promoName && $item->promoCondition)
                                            @php
                                                // Tính số lượng theo điều kiện khuyến mãi
                                                $quantityPromo = intdiv($item->soluong, $item->promoCondition); // Số nhóm đủ điều kiện
                                                $remainingQuantity = $item->soluong % $item->promoCondition; // Số sản phẩm còn lại không áp dụng khuyến mãi

                                                // Công thức 1: Tính tổng giá trị nhóm khuyến mãi
                                                $promoTotal =
                                                    $quantityPromo *
                                                    $item->promoCondition *
                                                    ((100 - $item->promoContent) / 100) *
                                                    $item->dongia; // Tổng tiền của nhóm khuyến mãi

                                                // Công thức 2: Tính tổng giá trị không áp dụng khuyến mãi
                                                $nonPromoTotal = $remainingQuantity * $item->dongia; // Tổng tiền không áp dụng khuyến mãi

                                                // Tổng tiền sản phẩm
                                                $itemTotal = $promoTotal + $nonPromoTotal;
                                            @endphp
                                            <span class="text-success">
                                                {{ number_format($itemTotal, 0, ',', '.') }} VNĐ
                                            </span>
                                        @elseif ($item->discountAmount > 0)
                                            @php
                                                // Tính tổng tiền với giảm giá phần trăm
                                                $itemTotal =
                                                    $item->dongia * (1 - $item->discountAmount / 100) * $item->soluong;
                                            @endphp
                                            <span class="text-success">
                                                {{ number_format($itemTotal, 0, ',', '.') }} VNĐ
                                            </span>
                                        @else
                                            @php
                                                // Tính tổng tiền bình thường
                                                $itemTotal = $item->dongia * $item->soluong;
                                            @endphp
                                            <span class="text-success">
                                                {{ number_format($itemTotal, 0, ',', '.') }} VNĐ
                                            </span>
                                        @endif
                                        @php
                                            $totalBill += $itemTotal; // Cộng dồn vào tổng tiền
                                        @endphp
                                    </p>
                                </td>

                                <td>
                                    <form action="{{ route('cart.delete', $item->idgh) }}" method="GET">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-md rounded-circle bg-light border mt-4">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if ($cartItems->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Chưa thêm sản phẩm</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Coupon and Total -->
            <div class="mt-4 mb-3 d-flex justify-content-end">
                <form action="{{ route('cart.clear') }}" method="GET">
                    <button type="submit" class="btn border-secondary rounded-pill px-5 py-4 text-primary bg-light"
                        type="button">Xóa tất cả</button>
                </form>
                {{-- <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code"> --}}

            </div>

            <div class="row g-4 justify-content-end">
                <div class="col-8">
                    @if (isset($insufficientStockDetails) && $insufficientStockDetails)
                        <div class="alert alert-danger">
                            <strong>Lỗi!</strong> Bạn không thể đặt số lượng các sản phẩm sau đây vì số lượng yêu cầu vượt
                            quá số lượng có sẵn:
                            <ul>
                                @foreach (explode(', ', $insufficientStockDetails) as $productDetail)
                                    <li>{{ $productDetail }}</li>
                                @endforeach
                            </ul>
                            Vui lòng điều chỉnh lại số lượng sản phẩm trong giỏ hàng.
                        </div>
                    @endif
                </div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4 mb-3 border-bottom">
                            {{-- <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1> --}}
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="mb-0 me-4">Tổng tiền:</h5>
                                <p class="mb-0">{{ number_format($totalBill, 0, ',', '.') }} VNĐ</p>
                            </div>
                        </div>
                        {{-- <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Thành tiền</h5>
                            <p class="mb-0 pe-4">{{ number_format($totalBill + 30000, 0, ',', '.') }} VNĐ</p>
                </div> --}}
                        <a href="{{ route('order.create') }}"
                            class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">Thanh
                            toán</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

    <script>
        function updateQuantity(cartId, quantity) {
            if (quantity < 0) {
                alert('Số lượng không thể nhỏ hơn 0');
                return;
            }

            let url = `{{ route('cart.update', ':id') }}`.replace(':id', cartId);
            $.post(url, {
                _token: '{{ csrf_token() }}',
                qty: quantity
            }, function(data) {
                location.reload();
            });
        }
    </script>
@endsection
