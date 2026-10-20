@extends('admin.layout.master')

@Section('content')
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


            <form action="{{ route('admin.KhuyenMai.store') }}" method="post"
                enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Khuyến Mãi</h4>
                                <button type="submit" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#addRowModal">
                                    <i class="fa fa-plus"></i>
                                    Khuyến Mãi
                                </button>
                            </div>
                        </div>




                        @csrf
                        <div class="row" style=" padding: 20px;">
                            <div class="col-sm-12">
                                <div class="form-group @error('tenkm') has-error @enderror form-group-default">
                                    <label>Tên Khuyến Mãi</label>
                                    <input id="tenkm" name="tenkm" type="text" class="form-control"
                                        value="{{ old('tenkm') }}" placeholder="Nhập tên khuyến mãi" />
                                    @if ($errors->has('tenKMError'))
                                    <small class="form-text text-danger">{{ $errors->first('tenKMError') }}</small>
                                    @endif
                                </div>


                            </div>


                            <!-- Ngày bắt đầu -->
                            <div class="col-sm-6">
                                <div class="form-group @error('ngaybd') has-error @enderror form-group-default">
                                    <label>Ngày Bắt Đầu</label>
                                    <input id="ngaybd" name="ngaybd" type="date" value="{{ old('ngaybd') }}"
                                        class="form-control" />
                                    {{-- <small id="emailHelp " class="form-text text-muted"><?= $ngayBDError ?></small> --}}
                                    @if ($errors->has('ngayBDError'))
                                    <small id="ngaybdHelp"
                                        class="form-text text-danger">{{ $errors->first('ngayBDError') }}</small>
                                    @endif
                                </div>
                            </div>

                            <!-- Ngày kết thúc -->
                            <div class="col-sm-6">
                                <div class="form-group  @error('ngaykt') has-error @enderror form-group-default">
                                    <label>Ngày Kết Thúc</label>
                                    <input id="ngaykt" name="ngaykt" type="date" value="{{ old('ngaykt') }}"
                                        class="form-control" />
                                    {{-- <small id="emailHelp " class="form-text text-muted"><?= $ngayKTError ?></small> --}}
                                    @if ($errors->has('ngayKTError'))
                                    <small id="ngayktHelp"
                                        class="form-text text-danger">{{ $errors->first('ngayKTError') }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group @error('loaikm') has-error @enderror">
                                    <label>Loại giảm giá</label><br />
                                    <div class="d-flex">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="loaikm" value="giamtien" id="giamtien" onclick="toggleFields()"
                                                {{ old('loaikm') == 'giamtien' ? 'checked' : '' }} />
                                            <label class="form-check-label" for="giamtien">Giảm theo phần trăm</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="loaikm" value="giamthanhtien" id="giamthanhtien" onclick="toggleFields()"
                                                {{ old('loaikm') == 'giamthanhtien' ? 'checked' : '' }} />
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
                                <div class="form-group @error('GiamPhanTram') has-error @enderror form-group-default    ">
                                    <label for="exampleFormControlSelect2">Giảm theo phần trăm</label>
                                    <input id="discountField" name="GiamPhanTram" type="text"
                                        value="{{ old('GiamPhanTram') }}" class="form-control"
                                        placeholder="Ví dụ: giảm 30% thì nhập 30" />
                                    @if ($errors->has('giamphantramError'))
                                    <small id="noidungkmHelp"
                                        class="form-text text-danger">{{ $errors->first('giamphantramError') }}</small>
                                    @endif

                                </div>
                            </div>









                            <!-- Chọn sản phẩm -->
                            <div class="col-md-4">
                                <div class="form-group @error('ngaybd') has-error @enderror form-group-default">
                                    <label>Chọn sản phẩm</label>
                                    <select id="productSelect" name="product_id" class="form-control">
                                        <option value="" disabled selected>Chọn sản phẩm</option>
                                        @foreach ($sanpham as $product)
                                        <option value="{{ $product->idsp }}"
                                            {{ old('product_id') == $product->idsp ? 'selected' : '' }}>
                                            {{ $product->tensp }} - {{ number_format($product->gia, 0, ',', '.') }} VND
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('productIDError'))
                                    <small id="productIDHelp" class="form-text text-danger">{{ $errors->first('productIDError') }}</small>
                                    @endif
                                </div>
                            </div>


                            <!-- Số lượng -->
                            <div class="col-md-4">
                                <div class="form-group @error('ngaykt') has-error @enderror form-group-default">
                                    <label>Số lượng</label>
                                    <input id="discountField" name="soluong" type="text" value="{{ old('soluong') }}"
                                        class="form-control" placeholder="Ví dụ: số lượng lớn hơn 2" />
                                    @if ($errors->has('soluongError'))
                                    <small id="soluongHelp"
                                        class="form-text text-danger">{{ $errors->first('soluongError') }}</small>
                                    @endif
                                </div>
                            </div>

                            <!-- Thành tiền -->
                            <div class="col-md-4">
                                <div class="form-group @error('ngaykt') has-error @enderror form-group-default">
                                    <label>Giá Ưu Đãi</label>
                                    <input id="discountField" name="GiaUuDai" type="text" value="{{ old('GiaUuDai') }}"
                                        class="form-control" placeholder="" />
                                    @if ($errors->has('giaUuDaiError'))
                                    <small id="giaUuDaiHelp" class="form-text text-danger">{{ $errors->first('giaUuDaiError') }}</small>
                                    @endif

                                </div>
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


</div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hàm toggleFields() sẽ được gọi khi tài liệu HTML được tải xong
        function toggleFields() {
            var isGiamTienSelected = document.getElementById('giamtien').checked;
            var isGiamThanhTienSelected = document.getElementById('giamthanhtien').checked;

            var giamPhanTramField = document.querySelector('[name="GiamPhanTram"]').parentElement;
            var giamThanhTienFields = [
                document.querySelector('#productSelect').parentElement,
                document.querySelector('[name="soluong"]').parentElement,
                document.querySelector('[name="GiaUuDai"]')?.parentElement // Cần kiểm tra xem phần tử có tồn tại không
            ];

            // Reset tất cả các phần tử về trạng thái ẩn
            giamPhanTramField.style.display = 'none';
            giamThanhTienFields.forEach(field => {
                if (field) field.style.display = 'none'; // Kiểm tra trước khi ẩn
            });

            // Hiển thị các phần tử dựa trên lựa chọn
            if (isGiamTienSelected) {
                giamPhanTramField.style.display = 'block';
            } else if (isGiamThanhTienSelected) {
                giamThanhTienFields.forEach(field => {
                    if (field) field.style.display = 'block';
                });
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

        document.getElementById('ngaybd').setAttribute('min', formattedDate);
        document.getElementById('ngaykt').setAttribute('min', formattedDate);

        document.getElementById('ngaybd').addEventListener('change', function() {
            var startDate = this.value;
            if (startDate) {
                document.getElementById('ngaykt').setAttribute('min', startDate);
            }
        });
    });
</script>
@endsection