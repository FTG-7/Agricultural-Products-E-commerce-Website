@extends('admin.layout.master')

@Section('content')
@php
$isProductInPromotion = $sanphamGiamThanhTien !== null;
@endphp
<div class="container">
    <div class="page-inner">


        <div class="row">
            <div class="col-md-7">
                <div class="card card-round">
                    <form action="{{ route('admin.KhuyenMai.update', ['id' => $khuyenMai->idkm]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Chỉnh sửa khuyến mãi</div>
                                <div class="card-tools">
                                    <button type="submit" class="btn btn-label-success btn-round btn-sm me-2">
                                        <span class="btn-label">
                                            <i class="fa fa-pencil"></i>
                                        </span>
                                        Chỉnh Sửa
                                    </button>

                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="min-height: 375px">


                                <div class="col-md-12">
                                    <div class="card">

                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div
                                                    class="form-group @error('tenkm') has-error @enderror form-group-default">
                                                    <label>Tên Khuyến Mãi</label>
                                                    <input id="tenkm" name="tenkm" type="text"
                                                        class="form-control"
                                                        value="{{ old('tenkm', $khuyenMai->tenkm) }}"
                                                        placeholder="Nhập tên khuyến mãi" />
                                                    @if ($errors->has('tenKMError'))
                                                    <small
                                                        class="form-text text-danger">{{ $errors->first('tenKMError') }}</small>
                                                    @endif
                                                </div>


                                            </div>

                                            <!-- <div class="col-sm-12">
                                                        <div
                                                            class="form-group @error('dieukienKM') has-error @enderror form-group-default">
                                                            <label>Điều Kiện Khuyến Mãi</label>
                                                            <input id="dieukien" name="dieukien" type="text"
                                                                class="form-control"
                                                                value="{{ old('dieukien', $khuyenMai->dieukien) }}"
                                                                placeholder="Ví dụ: nhập 2 nếu số lượng > 2" />
                                                            @if ($errors->has('dieukienKMError'))
                                                                <small id="dieukienHelp"
                                                                    class="form-text text-danger">{{ $errors->first('dieukienKMError') }}</small>
                                                            @endif

                                                        </div>
                                                    </div> -->

                                            <!-- Ngày bắt đầu -->
                                            <div class="col-sm-6">
                                                <div class="form-group @error('ngaybd') has-error @enderror form-group-default">
                                                    <label>Ngày Bắt Đầu</label>
                                                    <input id="ngaybd" name="ngaybd" type="date"
                                                        value="{{ old('ngaybd', \Carbon\Carbon::parse($khuyenMai->ngaybd)->format('Y-m-d')) }}"
                                                        class="form-control" />
                                                    @if ($errors->has('ngayBDError'))
                                                    <small id="ngaybdHelp" class="form-text text-danger">{{ $errors->first('ngayBDError') }}</small>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Ngày kết thúc -->
                                            <div class="col-sm-6">
                                                <div class="form-group @error('ngaykt') has-error @enderror form-group-default">
                                                    <label>Ngày Kết Thúc</label>
                                                    <input id="ngaykt" name="ngaykt" type="date"
                                                        value="{{ old('ngaykt', \Carbon\Carbon::parse($khuyenMai->ngaykt)->format('Y-m-d')) }}"
                                                        class="form-control" />
                                                    @if ($errors->has('ngayKTError'))
                                                    <small id="ngayktHelp" class="form-text text-danger">{{ $errors->first('ngayKTError') }}</small>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group @error('loaikm') has-error @enderror">
                                                    <label>Loại giảm giá</label><br />
                                                    <div class="d-flex">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="loaikm" value="giamtien"
                                                                id="giamtien" onclick="toggleFields()"
                                                                {{ old('loaikm', $khuyenMai->loaikm) == 'giamtien' ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="giamtien">Giảm theo phần trăm</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="loaikm" value="giamthanhtien"
                                                                id="giamthanhtien" onclick="toggleFields()"
                                                                {{ old('loaikm', $khuyenMai->loaikm) == 'giamthanhtien' ? 'checked' : '' }} />
                                                            <label class="form-check-label" for="giamthanhtien">Giảm thành tiền</label>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('loaiKMError'))
                                                    <small id="loaikmHelp"
                                                        class="form-text text-danger">{{ $errors->first('loaiKMError') }}</small>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group @error('GiamPhanTram') has-error @enderror">
                                                    <label for="exampleFormControlSelect2">Giảm theo phần trăm</label>
                                                    <input id="discountField" name="GiamPhanTram" type="text"
                                                        value="{{ old('GiamPhanTram', $khuyenMai->noidungkm ? $khuyenMai->noidungkm : '') }}"
                                                        class="form-control"
                                                        placeholder="Ví dụ: giảm 30% thì nhập 30" />
                                                    @if ($errors->has('giamphantramError'))
                                                    <small id="noidungkmHelp"
                                                        class="form-text text-danger">{{ $errors->first('giamphantramError') }}</small>
                                                    @endif

                                                </div>
                                            </div>


                                            <!-- Chọn sản phẩm -->

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label id="singleProductWarning" class="text-danger" style="display: none;">Chỉ Áp Dụng Cho 1 Sản Phẩm</label>
                                                </div>
                                            </div>

                                            <!-- Số lượng -->
                                            <div class="col-md-4">
                                                <div class="form-group @error('soluong') has-error @enderror form-group-default">
                                                    <label>Số lượng</label>
                                                    <input id="soluongField" name="soluong" type="text" value="{{ old('soluong',  $isProductInPromotion ? $khuyenMai->dieukien : 0) }}"
                                                        class="form-control" placeholder="Ví dụ: số lượng lớn hơn 2" @if(!$isProductInPromotion) disabled @endif />
                                                    @if ($errors->has('soluongError'))
                                                    <small id="soluongHelp" class="form-text text-danger">{{ $errors->first('soluongError') }}</small>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Giá ưu đãi -->
                                            @php
                                            $gia = $sanphamGiamThanhTien->gia ?? 0; // Giá sản phẩm
                                            $dieukien = $khuyenMai->dieukien ?? 1; // Điều kiện khuyến mãi
                                            $noidungkm = $khuyenMai->noidungkm ?? 0; // Nội dung khuyến mãi (% giảm giá)

                                            $giaUuDai = ((100 - $noidungkm) / 100) * $gia * $dieukien;

                                            $giaUuDai = round($giaUuDai, 2); // Làm tròn tới 2 chữ số thập phân

                                            $giaUuDai = $isProductInPromotion ? $giaUuDai : 0;
                                            @endphp

                                            <div class="col-md-4">
                                                <div class="form-group @error('GiaUuDai') has-error @enderror form-group-default">
                                                    <label>Giá Ưu Đãi</label>
                                                    <input id="discountField" name="GiaUuDai" type="text"
                                                        value="{{ old('GiaUuDai',number_format($giaUuDai, 0, ',', '.')) }}"
                                                        class="form-control" placeholder="Nhập giá ưu đãi" @if(!$isProductInPromotion) disabled @endif />
                                                    @if ($errors->has('giaUuDaiError'))
                                                    <small id="giaUuDaiHelp" class="form-text text-danger">{{ $errors->first('giaUuDaiError') }}</small>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<div class="col-md-5">
    <div class="card  card-round">
        <div class="card-header">
            <div class="card-head-row">
                <div class="card-title">Áp dụng vào sản phẩm</div>

            </div>

        </div>
        <div class="card-body pb-0">
            <div class="table-responsive me-3" style="max-height: 365px; overflow-y: auto;overflow-x: hidden; flex: 1;">
                <table class="table table-bordered" id="SanPhamTable">
                    <thead>
                        <tr>

                            <th>Tên SP</th>
                            <th>Giá</th>
                            <th>Danh Mục</th>
                            <th>Thao Tác</th> <!-- Cột chứa nút thêm -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sanpham as $SanPham)
                        <tr>
                            <td>{{ $SanPham->tensp }}</td>
                            <td>{{ number_format($SanPham->gia, 0, ',', '.') }} đ</td>
                            <td>
                                @if ($SanPham->loaisp->isNotEmpty())
                                @foreach ($SanPham->loaisp as $loai)
                                {{ $loai->tenloai }}@if (!$loop->last),@endif
                                @endforeach
                                @else
                                Không có danh mục
                                @endif
                            </td>
                            <td class="action-column">


                                <style>
                                    /* Lớp CSS để làm mờ nút và vô hiệu hóa việc click */
                                    .disabled-link {
                                        pointer-events: none;
                                        /* Vô hiệu hóa sự kiện click */
                                        opacity: 0.5;
                                        /* Làm mờ nút */
                                    }
                                </style>
                                <a href="{{ route('admin.KhuyenMai.insertChiTietKhuyenMai', ['idkm' => $khuyenMai->idkm, 'idsp' => $SanPham->idsp]) }}"
                                    class="btn btn-success @if($khuyenMai->loaikm == 'giamthanhtien' && $isProductInPromotion) disabled-link @endif">
                                    <i class="fa fa-plus"></i> <!-- Icon dấu "+" -->
                                </a>


                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div class="card card-round">
        <div class="card-body pb-0">
            <h4 class="card-title">Danh sách sản phẩm áp dụng khuyến mãi</h4>

            <div class="table-responsive me-3" style="max-height: 365px; overflow-y: auto; flex: 1;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>

                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sanphamKhuyenMai as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->tensp }}</td>
                            <td>{{ number_format($product->gia, 0, ',', '.') }} đ</td>

                            <td>
                                <!-- Các nút thao tác (nếu cần) -->

                                <form
                                    action="{{ route('admin.KhuyenMai.deleteChiTietKhuyenMai', ['idkm' => $khuyenMai->idkm, 'idsp' => $product->idsp]) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                </form>


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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hàm toggleFields() sẽ được gọi khi tài liệu HTML được tải xong
        function toggleFields() {
            var isGiamTienSelected = document.getElementById('giamtien').checked;
            var isGiamThanhTienSelected = document.getElementById('giamthanhtien').checked;

            var giamPhanTramField = document.querySelector('[name="GiamPhanTram"]')?.parentElement;
            var giamThanhTienFields = [
                document.querySelector('[name="soluong"]')?.parentElement,
                document.querySelector('[name="GiaUuDai"]')?.parentElement
            ];

            var warningMessage = document.getElementById('singleProductWarning'); // Thông báo đỏ

            // Reset tất cả các phần tử về trạng thái ẩn
            if (giamPhanTramField) giamPhanTramField.style.display = 'none';
            giamThanhTienFields.forEach(field => {
                if (field) field.style.display = 'none'; // Kiểm tra trước khi ẩn
            });

            if (warningMessage) warningMessage.style.display = 'none'; // Ẩn thông báo đỏ mặc định

            // Hiển thị các phần tử dựa trên lựa chọn
            if (isGiamTienSelected) {
                if (giamPhanTramField) giamPhanTramField.style.display = 'block';
            } else if (isGiamThanhTienSelected) {
                giamThanhTienFields.forEach(field => {
                    if (field) field.style.display = 'block';
                });
                if (warningMessage) warningMessage.style.display = 'block'; // Hiển thị thông báo đỏ
            }
        }

        // Gọi hàm toggleFields khi tải trang
        toggleFields();

        // Gắn sự kiện khi thay đổi giá trị radio
        document.querySelectorAll('input[name="loaikm"]').forEach(function(radio) {
            radio.addEventListener('change', toggleFields);
        });

        // Xử lý ngày
        var today = new Date();
        var day = String(today.getDate()).padStart(2, '0');
        var month = String(today.getMonth() + 1).padStart(2, '0');
        var year = today.getFullYear();
        var formattedDate = year + '-' + month + '-' + day;

        var startDateField = document.getElementById('ngaybd');
        var endDateField = document.getElementById('ngaykt');

        var startDateChanged = false; // Flag để theo dõi xem người dùng đã thay đổi ngày bắt đầu chưa

        // Lắng nghe sự kiện focus (khi người dùng click vào trường ngày bắt đầu)
        startDateField?.addEventListener('focus', function() {
            // Chỉ thiết lập min khi người dùng click vào trường này
            startDateField.setAttribute('min', formattedDate);
            endDateField.setAttribute('min', formattedDate);
        });

           // Xử lý khi thay đổi ngày bắt đầu
    startDateField?.addEventListener('change', function() {
        startDateChanged = true;  // Đánh dấu rằng người dùng đã thay đổi ngày bắt đầu
        var startDate = this.value;
        if (startDate && endDateField) {
            // Nếu ngày bắt đầu được chọn, đặt giá trị min cho ngày kết thúc
            endDateField.setAttribute('min', startDate);
        }
    });

    // Xử lý khi người dùng thay đổi ngày kết thúc (đảm bảo ngày kết thúc không sớm hơn ngày bắt đầu)
    endDateField?.addEventListener('change', function() {
        if (startDateChanged && this.value < startDateField.value) {
            // Kiểm tra nếu ngày kết thúc nhỏ hơn ngày bắt đầu, hiển thị lỗi (hoặc thông báo phù hợp)
            alert('Ngày kết thúc không thể nhỏ hơn ngày bắt đầu.');
        }
    });
    });
</script>
@endsection