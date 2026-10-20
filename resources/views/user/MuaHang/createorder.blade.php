@extends('user.layout.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Tạo đơn hàng</h1>
    </div>
    <!-- Single Page Header End -->


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
            {{ session('error') }}
        </div>
    @endif


    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4 text-center">Thông tin đơn hàng</h1>
            <form action="{{ route('order.confirm') }}" method="post">
                <div class="row g-5">
                    @csrf
                    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
                        <div class="form-item">
                            <label class="form-label my-3">Tên người nhận<sup>*</sup></label>
                            <input type="text" class="form-control" id="tennhan" name="tennhan"
                                value="{{ old('hoten', $user->hoten) }}">
                            @if ($errors->has('tennhan'))
                                <span class="text-danger">{{ $errors->first('tennhan') }}</span>
                            @endif
                        </div>

                        <div class="form-item">
                            <label class="form-label my-3">Chọn phương thức nhận địa chỉ<sup>*</sup></label>
                            <div>
                                <input type="radio" id="selectAddress" name="address_method" value="select"
                                    onchange="toggleAddressFields()"
                                    {{ old('address_method', 'select') === 'select' ? 'checked' : '' }}>
                                <label for="selectAddress">Chọn địa chỉ từ danh sách</label>
                            </div>
                            <div>
                                <input type="radio" id="enterAddress" name="address_method" value="enter"
                                    onchange="toggleAddressFields()"
                                    {{ old('address_method') === 'enter' ? 'checked' : '' }}>
                                <label for="enterAddress">Nhập địa chỉ mới</label>
                            </div>
                        </div>

                        <!-- Chọn địa chỉ từ danh sách -->
                        <div id="phoneSelection"
                            style="{{ old('address_method', 'select') === 'select' ? 'display: block;' : 'display: none;' }}">
                            <label class="form-label my-3">Địa chỉ nhận hàng<sup>*</sup></label>
                            <select class="form-control" id="diachigiaods" name="diachigiaods">
                                @foreach ($diaChiList as $diachi)
                                    <option value="{{ $diachi->diachi }}" {{ $diachi->loai == 1 ? 'selected' : '' }}>
                                        {{ $diachi->diachi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nhập địa chỉ mới -->
                        <div id="addressInput" style="{{ old('address_method') === 'enter' ? 'display: block;' : 'display: none;' }}">
                            <div class="form-item">
                                <label class="form-label my-3">Địa chỉ<sup></sup></label>
                                <input type="text" class="form-control" id="diachigiao_display" name="diachigiao_display"
                                    placeholder="Hãy nhập địa chỉ mới" value="{{ old('diachigiao') }}" disabled>
                                <input type="hidden" name="diachigiao" id="diachigiao" value="{{ old('diachigiao') }}">
                                @if ($errors->has('diachigiao'))
                                    <span class="text-danger">{{ $errors->first('diachigiao') }}</span>
                                @endif
                            </div>

                            <div class="form-item">
                                <label class="form-label my-3">Thành phố<sup></sup></label>
                                <input type="text" class="form-control" id="thanhpho" name="thanhpho"
                                    value="TP Hồ Chí Minh" disabled>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-item">
                                        <label class="form-label my-3">Quận <sup>*</sup></label>
                                        <select class="form-control" id="quan" name="quan"
                                            style="background-color: white; color:rgb(120, 113, 113);">
                                            <option value="" selected>Chọn quận</option>
                                            @foreach ($filteredDistricts as $district)
                                                <option value="{{ $district->Id }}"
                                                    {{ old('quan') == $district->Id ? 'selected' : '' }}>
                                                    {{ $district->Name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('quan'))
                                            <span class="text-danger">{{ $errors->first('quan') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-item">
                                        <label class="form-label my-3">Phường<sup>*</sup></label>
                                        <select class="form-control" id="phuong" name="phuong"
                                            style="background-color: white; color:rgb(120, 113, 113);">
                                            <option value="" selected>Chọn phường</option>
                                            @foreach ($wards as $ward)
                                                <option value="{{ $ward->Id }}"
                                                    {{ old('phuong') == $ward->Id ? 'selected' : '' }}>
                                                    {{ $ward->Name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('phuong'))
                                            <span class="text-danger">{{ $errors->first('phuong') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-item">
                                        <label class="form-label my-3">Đường<sup>*</sup></label>
                                        <input type="text" class="form-control" id="duong" name="duong"
                                            placeholder="Nhập đường" value="{{ old('duong') }}">
                                        @if ($errors->has('duong'))
                                            <span class="text-danger">{{ $errors->first('duong') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-item">
                                        <label class="form-label my-3">Số nhà<sup>*</sup></label>
                                        <input type="text" class="form-control" id="sonha" name="sonha"
                                            placeholder="Nhập số nhà" value="{{ old('sonha') }}">
                                        @if ($errors->has('sonha'))
                                            <span class="text-danger">{{ $errors->first('sonha') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--
                        <div class="form-item">
                            <div class="row">
                                <!-- Cột 1: Địa chỉ nhận hàng -->
                                <div class="col-md-8">
                                    <label class="form-label my-3">Địa chỉ nhận hàng<sup>*</sup></label>
                                    <select class="form-control" id="diachigiao" name="diachigiao">
                                        @foreach ($diaChiList as $diachi)
                                            <option value="{{ $diachi->diachi }}"
                                                {{ $diachi->loai == 1 ? 'selected' : '' }}>
                                                {{ $diachi->diachi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Cột 2: Liên kết đến trang quản lý địa chỉ -->
                                <div class="col-md-4 d-flex align-items-end">
                                    <a href="{{ route('address.index') }}" class="btn btn-primary w-100">Quản lý địa
                                        chỉ</a>
                                </div>
                            </div>
                        </div> --}}


                        <div class="form-item">
                            <label class="form-label my-3">Số điện thoại người nhận<sup>*</sup></label>
                            <input type="text" class="form-control" id="sdt" name="sdt"
                                value="{{ old('sdt', $user->sdt) }}">
                            @if ($errors->has('sdt'))
                                <span class="text-danger">{{ $errors->first('sdt') }}</span>
                            @endif
                        </div>

                        <div class="form-item">
                            <label class="form-label my-3">Phương thức thanh toán<sup>*</sup></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pttt" id="online"
                                    value="online" {{ old('pttt') == 'online' ? 'checked' : '' }}>
                                <label class="form-check-label" for="online">
                                    Thanh toán online
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pttt" id="offline"
                                    value="offline" {{ old('pttt') == 'offline' ? 'checked' : '' }}>
                                <label class="form-check-label" for="offline">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            @if ($errors->has('pttt'))
                                <span class="text-danger">{{ $errors->first('pttt') }}</span>
                            @endif
                        </div>


                        <div class="form-item">
                            <label class="form-label my-3">Ghi chú</label>
                            <textarea class="form-control" id="ghichu" name="ghichu">{{ old('ghichu') }}</textarea>
                        </div>

                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                            <button type="submit" class="btn custom-btn1 py-3 px-4 text-uppercase w-100">
                                Xác nhận đơn hàng
                            </button>
                        </div>

                        
                    </div>
                </div>
            </form>
            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                <form id="offlinepayForm" action="{{ route('cart.index') }}" method="GET">
                    @csrf
                    <button type="submit" class="btn custom-btn2 py-3 px-4 text-uppercase w-50">
                        Hủy Đơn</button>
                </form>
            </div>  
        </div>
    </div>
    <!-- Checkout Page End -->
    
    <style>
        /* Đảm bảo thông báo nằm ở trên cùng, không làm xê dịch layout */
        #success-alert, #error-alert {
            position: fixed;
            top: 320px;         /* Khoảng cách từ trên cùng */
            left: 50%;
            transform: translateX(-50%); /* Canh giữa thông báo */
            z-index: 1050;     /* Đảm bảo thông báo nằm trên các phần tử khác */
            width: 80%;        /* Kích thước thông báo */
            max-width: 600px;  /* Giới hạn chiều rộng tối đa */
            margin: 0 auto;    /* Canh giữa nếu kích thước thông báo thay đổi */
            opacity: 1;        /* Đảm bảo thông báo hiển thị ban đầu */
            transition: opacity 1s ease-out; /* Thêm hiệu ứng mờ dần */
            text-align: center;
        }

        /* Đảm bảo thông báo mờ dần khi ẩn */
        .alert.fade {
            opacity: 0;
        }


        /* Lớp d-none sẽ ẩn phần tử */
        .d-none {
            display: none !important;
        }






        /* Mặc định màu sắc giống trong ảnh */
        .btn.custom-btn1 {
            background-color: #f0bc64; /* Màu nền giống màu xanh trong ảnh */
            color: white; /* Màu chữ trắng */
            transition: all 0.3s ease; /* Hiệu ứng chuyển màu khi hover */
        }

        .btn.custom-btn2 {
            background-color: #EE7C6B; /* Màu nền giống màu xanh trong ảnh */
            color: white; /* Màu chữ trắng */
            transition: all 0.3s ease; /* Hiệu ứng chuyển màu khi hover */
        }
    
        /* Khi hover, màu chữ chuyển thành màu đen cho cả hai lớp .custom-btn1 và .custom-btn2 */
        .btn.custom-btn1:hover,
        .btn.custom-btn2:hover {
            color: black; /* Chữ chuyển thành màu đen khi hover */
            transform: scale(1.05); /* Nút phóng to 5% khi hover */
        }

    </style>

    <script>
        function toggleAddressFields() {
            const method = document.querySelector('input[name="address_method"]:checked').value;
            const phoneSelection = document.getElementById('phoneSelection');
            const addressInput = document.getElementById('addressInput');

            if (method === 'select') {
                phoneSelection.style.display = 'block';
                addressInput.style.display = 'none';
            } else {
                phoneSelection.style.display = 'none';
                addressInput.style.display = 'block';
            }
        }

        // Gọi hàm khi tài liệu được tải xong
        document.addEventListener('DOMContentLoaded', function() {
            toggleAddressFields(); // Gọi hàm để xác định trạng thái ban đầu của các trường
        });


        document.addEventListener('DOMContentLoaded', function() {
            const districts = @json($filteredDistricts);
            const wards = @json($wards);

            const quanSelect = document.getElementById('quan');
            const phuongSelect = document.getElementById('phuong');

            // Cập nhật phường khi quận được chọn
            quanSelect.addEventListener('change', function() {
                const selectedDistrictId = this.value;

                // Xóa các tùy chọn phường hiện tại
                phuongSelect.innerHTML = '<option value="" selected>Chọn phường</option>';

                // Lọc các phường theo quận đã chọn
                wards.forEach(function(ward) {
                    if (ward.DistrictId == selectedDistrictId) {
                        const option = document.createElement('option');
                        option.value = ward.Id;
                        option.textContent = ward.Name;
                        phuongSelect.appendChild(option);
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Hàm cập nhật địa chỉ chi tiết
            function updateAddress() {
                const districts = @json($filteredDistricts);
                const wards = @json($wards);

                var thanhpho = document.getElementById('thanhpho').value;
                var quanId = document.getElementById('quan').value;
                var phuongId = document.getElementById('phuong').value;
                var duong = document.getElementById('duong').value;
                var sonha = document.getElementById('sonha').value;

                // Tìm tên quận từ danh sách districts
                var quan = districts.find(district => district.Id == quanId)?.Name || '';

                // Tìm tên phường từ danh sách wards
                var phuong = wards.find(ward => ward.Id == phuongId)?.Name || '';

                // Tạo địa chỉ từ các trường nhập
                var address = `${sonha} ${duong}, ${phuong}, ${quan}, ${thanhpho}`;

                // Cập nhật giá trị vào trường địa chỉ chi tiết
                document.getElementById('diachigiao').value = address;
                document.getElementById('diachigiao_display').value = address;
            }

            // Lắng nghe sự thay đổi trên các trường nhập
            document.getElementById('thanhpho').addEventListener('change', updateAddress);
            document.getElementById('quan').addEventListener('input', updateAddress);
            document.getElementById('phuong').addEventListener('input', updateAddress);
            document.getElementById('duong').addEventListener('input', updateAddress);
            document.getElementById('sonha').addEventListener('input', updateAddress);
        });

        window.onload = function() {
            setTimeout(function() {
                var successAlert = document.getElementById('success-alert');
                var errorAlert = document.getElementById('error-alert');

                // Ẩn thông báo sau 3 giây
                if (successAlert) {
                    successAlert.classList.add('d-none');
                }

                if (errorAlert) {
                    errorAlert.classList.add('d-none');
                }
            }, 3000); // 3000ms = 3 seconds
        }
    </script>
@endsection
