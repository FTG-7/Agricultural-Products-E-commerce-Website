@extends('user.layout.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Tạo Phiếu Đổi Trả</h1>
    </div>
    <!-- Single Page Header End -->

    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4 text-center">Tạo Phiếu Đổi Trả cho Đơn hàng #{{ $donHang->iddh }}</h1>
            <form action="{{ route('doitra.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                <div class="row g-5">
                    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
                        <input type="hidden" name="iddh" value="{{ $donHang->iddh }}">
                        <input type="hidden" name="hoantien" value="{{ $donHang->tongtien }}">

                        <div class="form-item">
                            <label class="form-label my-3">Lý do<sup>*</sup></label>
                            <textarea class="form-control" id="lydo" name="lydo" required>{{ old('lydo') }}</textarea>
                            @if ($errors->has('lydo'))
                                <span class="text-danger">{{ $errors->first('lydo') }}</span>
                            @endif
                        </div>

                        <div class="form-item">
                            <label class="form-label my-3">Hình ảnh</label>
                            <input type="file" class="form-control" id="hinh" name="hinh" accept="image/*"
                                onchange="checkImageSize()">
                            @if ($errors->has('hinh'))
                                <span class="text-danger">{{ $errors->first('hinh') }}</span>
                            @endif
                        </div>

                        <div class="form-item">
                            <label class="form-label my-3">Video</label>
                            <input type="file" class="form-control" id="video" name="video" accept="video/*"
                                onchange="checkVideoSize()">
                            @if ($errors->has('video'))
                                <span class="text-danger">{{ $errors->first('video') }}</span>
                            @endif
                        </div>

                        <!-- Thêm ghi chú -->
                        <div class="form-item">
                            <label class="form-label my-3">Ghi chú</label>
                            <textarea class="form-control" id="ghichu" name="ghichu">{{ old('ghichu') }}</textarea>
                            @if ($errors->has('ghichu'))
                                <span class="text-danger">{{ $errors->first('ghichu') }}</span>
                            @endif
                        </div>

                        <!-- Bảng sản phẩm còn trong thời gian đổi trả -->
                        <div class="form-item">
                            <label class="form-label my-3">Sản phẩm còn trong thời gian đổi trả<sup>*</sup></label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Tên sản phẩm</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-center">Giá</th>
                                        <th class="text-center">Tổng giá</th>
                                        <th class="text-center">Chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $hasReturnableProducts = false; // Biến kiểm tra có sản phẩm đổi trả không
                                    @endphp
                                    @foreach ($chiTietDonHang as $item)
                                        @php
                                            $ngaygiaoDateTime = new DateTime($donHang->ngaygiao); // Chuyển đổi ngày giao thành DateTime
                                            $currentDateTime = new DateTime(); // Ngày hiện tại
                                            $diffDays = $currentDateTime->diff($ngaygiaoDateTime)->days; // Tính số ngày khác biệt
                                            $allowReturnDays = $item->sanPham->handoitra; // Số ngày cho phép đổi trả
                                            $tongt = $item->gia * $item->soluong;
                                        @endphp
                                        @if ($diffDays <= $allowReturnDays && $tongt == $item->tong && $item->sanPham->handoitra != 0)
                                            <tr>
                                                <td class="text-center">{{ $item->tensp }}</td>
                                                <td class="text-center">{{ $item->soluong }}</td>
                                                <td class="text-center">{{ number_format($item->gia, 0, ',', '.') }} VNĐ
                                                </td>
                                                <td class="text-center">{{ number_format($item->tong, 0, ',', '.') }} VNĐ
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="products[{{ $item->idsp }}]"
                                                        value="{{ $item->soluong }}"
                                                        {{ old('products.' . $item->idsp) ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                            @php
                                                $hasReturnableProducts = true; // Đánh dấu có sản phẩm đổi trả
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if (!$hasReturnableProducts)
                                        <tr>
                                            <td colspan="5" class="text-center">Không còn sản phẩm được đổi trả</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if ($errors->has('products'))
                            <span class="text-danger">{{ $errors->first('products') }}</span>
                        @endif

                        <!-- Bảng sản phẩm đã quá hạn đổi -->
                        <div class="form-item">
                            <label class="form-label my-3">Sản phẩm đã quá hạn đổi</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Tên sản phẩm</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-center">Giá</th>
                                        <th class="text-center">Tổng giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($chiTietDonHang as $item)
                                        @php
                                            $ngaygiaoDateTime = new DateTime($donHang->ngaygiao); // Chuyển đổi ngày giao thành DateTime
                                            $currentDateTime = new DateTime(); // Ngày hiện tại
                                            $diffDays = $currentDateTime->diff($ngaygiaoDateTime)->days; // Tính số ngày khác biệt
                                            $allowReturnDays = $item->sanPham->handoitra; // Số ngày cho phép đổi trả
                                        @endphp
                                        @if ($diffDays > $allowReturnDays)
                                            <tr>
                                                <td class="text-center">{{ $item->tensp }}</td>
                                                <td class="text-center">{{ $item->soluong }}</td>
                                                <td class="text-center">{{ number_format($item->gia, 0, ',', '.') }} VNĐ
                                                </td>
                                                <td class="text-center">{{ number_format($item->tong, 0, ',', '.') }} VNĐ
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Bảng sản phẩm không được đổi -->
                        <div class="form-item">
                            <label class="form-label my-3">Sản phẩm không được đổi</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">Tên sản phẩm</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-center">Giá</th>
                                        <th class="text-center">Tổng giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($chiTietDonHang as $item)
                                        @php
                                            $tongt = $item->gia * $item->soluong;
                                        @endphp
                                        @if ($tongt != $item->tong || $item->sanPham->handoitra == 0)
                                            <tr>
                                                <td class="text-center">{{ $item->tensp }}</td>
                                                <td class="text-center">{{ $item->soluong }}</td>
                                                <td class="text-center">{{ number_format($item->gia, 0, ',', '.') }} VNĐ
                                                </td>
                                                <td class="text-center">{{ number_format($item->tong, 0, ',', '.') }} VNĐ
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                            <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Tạo Phiếu Đổi Trả</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Checkout Page End -->

    <script>
        function validateForm() {
            // Kiểm tra kích thước video
            if (!checkVideoSize()) {
                return false; // Ngăn không gửi form nếu video không hợp lệ
            }
            
            // Kiểm tra kích thước hình ảnh
            if (!checkImageSize()) {
                return false; // Ngăn không gửi form nếu hình ảnh không hợp lệ
            }
    
            return true; // Gửi form nếu tất cả đều hợp lệ
        }
    
        function checkVideoSize() {
            const videoInput = document.getElementById('video');
            const file = videoInput.files[0];
    
            if (file) {
                const fileSizeMB = file.size / (1024 * 1024); // Chuyển đổi kích thước tệp từ byte sang MB
                if (fileSizeMB > 5) { // Kiểm tra kích thước lớn hơn 5MB
                    alert('Video phải có dung lượng không quá 5MB.');
                    videoInput.value = ''; // Reset input nếu kích thước không hợp lệ
                    return false; // Trả về false để ngăn gửi form
                }
            }
            return true; // Trả về true nếu video hợp lệ
        }
    
        function checkImageSize() {
            const imageInput = document.getElementById('hinh');
            const file = imageInput.files[0];
    
            if (file) {
                const fileSizeMB = file.size / (1024 * 1024); // Chuyển đổi kích thước tệp từ byte sang MB
                if (fileSizeMB > 2) { // Kiểm tra kích thước lớn hơn 2MB
                    alert('Hình ảnh phải có dung lượng không quá 2MB.');
                    imageInput.value = ''; // Reset input nếu kích thước không hợp lệ
                    return false; // Trả về false để ngăn gửi form
                }
            }
            return true; // Trả về true nếu hình ảnh hợp lệ
        }
    </script>    
@endsection
