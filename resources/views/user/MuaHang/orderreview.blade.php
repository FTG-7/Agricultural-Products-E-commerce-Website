@extends('user.layout.master')

@section('content')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Thanh toán</h1>
</div>
<!-- Single Page Header End -->

<!-- Checkout Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">Đơn Thanh Toán</h1>
        <!-- Các trường input -->
        <div class="row g-5">
            <div class="col-md-12 col-lg-6 col-xl-6">
                <div class="form-item">
                    <label class="form-label my-3">Tên người nhận<sup>*</sup></label>
                    <input type="text" id="tennhandl" name="tennhandl" class="form-control"
                        value="{{ $tennhan }}" readonly>
                    <input type="hidden" id="tennhan" name="tennhan" value="{{ $tennhan }}">
                </div>
                <div class="form-item">
                    <label class="form-label my-3">Địa chỉ giao<sup>*</sup></label>
                    <input type="text" id="diachigiaodl" name="diachigiaodl" class="form-control"
                        value="{{ $diachigiao }}" readonly>
                    <input type="hidden" id="diachigiao" name="diachigiao" value="{{ $diachigiao }}">
                </div>
                <div class="form-item">
                    <label class="form-label my-3">Số điện thoại<sup>*</sup></label>
                    <input type="text" id="sdtdl" name="sdtdl" class="form-control"
                        value="{{ $sdt }}" readonly>
                    <input type="hidden" id="sdt" name="sdt" value="{{ $sdt }}">
                </div>
                <br>
                <div class="form-item">
                    <textarea id="ghichudl" name="ghichudl" class="form-control" spellcheck="false" cols="30" rows="11"
                        placeholder="Ghi chú cho shipper" readonly>{{ $ghichu }}</textarea>
                    <input type="hidden" id="ghichu" name="ghichu" value="{{ $ghichu }}">
                </div>
            </div>

            <div class="col-md-12 col-lg-6 col-xl-6">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                            <tr>
                                <td>
                                    @if ($item->sanpham->Anh->isNotEmpty())
                                    <img src="{{ asset('imgsp/' . $item->sanpham->Anh->first()->tenanh) }}"
                                        class="img-fluid me-5 rounded-circle"
                                        style="width: 80px; height: 80px; margin-top:15px"
                                        alt="{{ $item->sanpham->tensp }}">
                                    @else
                                    <img src="{{ asset('imgsp/noImage.jpg') }}"
                                        class="img-fluid me-5 rounded-circle"
                                        style="width: 80px; height: 80px;margin-top:15px" alt="No Image">
                                    @endif
                                </td>
                                <td class="py-5">{{ $item->sanpham->tensp }}</td>

                                <td class="py-5">

                                    @if ($item->discountAmount > 0)
                                    <span class="text-success">
                                        {{ number_format($item->dongia , 0, ',', '.') }} VNĐ /{{ $item->sanpham->donvitinh }}
                                    </span> <br>
                                    <span style="text-decoration: line-through; color: red; font-size:15px">
                                        {{ number_format($item->sanpham->gia, 0, ',', '.') }} VNĐ
                                    </span>

                                    @else
                                    <span class="text-success">
                                        {{ number_format($item->dongia, 0, ',', '.') }} VNĐ /{{ $item->sanpham->donvitinh }}
                                    </span>
                                    @endif

                                    @if ($item->promoName)
                                    <br>
                                    <span style=" color: red; font-size:14px;white-space: nowrap;">
                                        {{ $item->promoName }}
                                    </span>


                                    @endif
                                </td>

                                <td class="py-5 text-center">{{ $item->soluong }}</td>
                                <td class="py-5">
                                    <b>
                                        @if (isset($item->itemTotal))
                                        <span class="text-success" style="white-space: nowrap;">
                                            {{ number_format($item->itemTotal, 0, ',', '.') }} VNĐ
                                        </span>
                                        @else
                                        <span class="text-success">
                                            {{ number_format($item->dongia * $item->soluong, 0, ',', '.') }} VNĐ
                                        </span>
                                        @endif

                                    </b>
                                </td>
                            </tr>
                            @endforeach

                            <tr>
                                <td class="py-5" colspan="1"></td>
                                <td class="py-5">
                                    <p class="mb-0 text-dark py-3">Tổng tiền</p>
                                </td>
                                <td class="py-5">
                                    <div class="py-3 border-bottom border-top">
                                        <p class="mb-0 text-dark"><b>{{ number_format($totalBill, 0, ',', '.') }} VNĐ</b></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-5" colspan="1"></td>
                                <td class="py-5">
                                    <p class="mb-0 text-dark py-3">Phí vận chuyển:</p>
                                </td>
                                <td colspan="3" class="py-5 border-bottom border-top">
                                    <div class="py-3 border-bottom border-top">
                                        <p class="mb-0 text-dark">{{ number_format($shippingCost, 0, ',', '.') }}
                                            VNĐ</p>
                                    </div>
                                    <div class="py-3 border-bottom border-top">
                                        <p class="mb-0 text-dark">Khoảng cách vận chuyển:<br>
                                            {{ round($distance) }} Km
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-5" colspan="1"></td>
                                <td class="py-5">
                                    <p class="mb-0 text-dark text-uppercase py-3">THÀNH TIỀN</p>
                                </td>
                                <td class="py-5">
                                    <div class="py-3 border-bottom border-top">
                                        <p class="mb-0 text-dark"><b>{{ number_format($totalBill+$shippingCost, 0, ',', '.') }}
                                                VNĐ</b></p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                {{-- 2 nút đặt hàng và thanh toán --}}
                <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                    @if ($pttt === 'online')
                        <form id="vnpayForm" action="{{ route('order.vnpay_payment') }}" method="POST">
                            @csrf
                            <!-- Thêm các trường dữ liệu cần thiết ở đây -->
                            <input type="hidden" name="tennhan" value="{{ $tennhan }}">
                            <input type="hidden" name="total" value="{{ $totalBill + $shippingCost }}">
                            <button type="submit" class="btn custom-btn py-3 px-4 text-uppercase w-100" name="redirect">Thanh Toán</button>
                        </form>
                    @else
                        <form id="offlinepayForm" action="{{ route('order.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn custom-btn py-3 px-4 text-uppercase w-100">Đặt Hàng</button>
                        </form>
                    @endif
                </div>




            </div>
        </div>
    </div>
</div>

<style>
    /* Mặc định màu sắc giống trong ảnh */
    .btn.custom-btn {
        background-color: #f0bc64; /* Màu nền giống màu xanh trong ảnh */
        color: white; /* Màu chữ trắng */
        transition: all 0.3s ease; /* Hiệu ứng chuyển màu khi hover */
    }
    /* Khi hover, màu chữ chuyển thành màu đen cho cả hai lớp .custom-btn1 và .custom-btn2 */
    .btn.custom-btn:hover {
        color: black; /* Chữ chuyển thành màu đen khi hover */
        transform: scale(1.05); /* Nút phóng to 5% khi hover */
    }
</style>
@endsection