@extends('user.layout.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Quản lý địa chỉ</h1>
    </div>
    <!-- Single Page Header End -->

    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4 text-center">Danh sách địa chỉ</h1>
            <div class="row g-5">

                <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Địa chỉ</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addresses as $index => $address)
                                    <tr>
                                        <td>
                                            <p class="mb-0 mt-4">{{ $index + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 mt-4">{{ $address->diachi }}</p>
                                        </td>
                                        <td>
                                            <p class="mb-0 mt-4">
                                                {{ $address->loai == 1 ? 'Mặc định' : '' }}</p>
                                        </td>
                                        <td>
                                            <form action="{{ route('address.destroy', $address->iddc) }}" method="POST"
                                                style="display:inline;" class="address-item-form"
                                                data-id="{{ $address->iddc }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-md rounded-circle bg-light border mt-4"
                                                    type="submit">
                                                    <i class="fa fa-times text-danger"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            @if ($address->loai == 0)
                                                <form action="{{ route('address.setDefault', $address->iddc) }}"
                                                    method="POST" style="display:inline;" class="address-item-form"
                                                    data-id="{{ $address->iddc }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="btn btn-md rounded-circle bg-light border mt-4"
                                                        type="submit">
                                                        <i class="fa fa-check text-success"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($addresses->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">Không có địa chỉ nào.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Cart Page End -->
                </div>

            </div>
        </div>

        <div class="container py-5">
            <h1 class="mb-4 text-center">Thêm địa chỉ</h1>

            <form action="{{ route('address.store') }}" method="post">
                @csrf
                <div class="row g-5">
                    @csrf
                    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">

                        <div class="form-item">
                            <label class="form-label my-3">Địa chỉ<sup></sup></label>
                            <input type="text" class="form-control" id="diachi_display" name="diachi_display"
                                placeholder="Hãy nhập các trường bên dưới, để tạo ra địa chỉ" value="{{ old('diachi') }}"
                                disabled>
                            <input type="hidden" name="diachi" id="diachi" value="{{ old('diachi') }}">
                            @if ($errors->has('diachi'))
                                <span class="text-danger">{{ $errors->first('diachi') }}</span>
                            @endif
                        </div>

                        <div class="form-item">
                            <label class="form-label my-3">Thành phố<sup></sup></label>
                            <input type="text" class="form-control" id="thanhpho" name="thanhpho" value="TP Hồ Chí Minh"
                                disabled>
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


                        <div class="row g-4 text-center align-items-center justify-contenrt-center pt-4">
                            <button type="submit"
                                class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Thêm địa
                                chỉ</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

    </div>

    <style>
        thead tr {
            position: sticky;
            /* Giữ vị trí cố định */
            top: 0;
            /* Màu nền cho phần đầu bảng */
            z-index: 1;
            /* Đảm bảo phần đầu bảng nằm trên các hàng khác */
            border-bottom: 5px solid #81c408 !important;
            /* Viền dưới cho phần đầu bảng */
            background-color: #fff;
        }

        .table-responsive {
            max-height: 400px;
            /* Chiều cao tối đa cho bảng */
            overflow-y: auto;
            /* Cho phép cuộn theo chiều dọc */
        }
    </style>

    <script>
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
                document.getElementById('diachi').value = address;
                document.getElementById('diachi_display').value = address;
            }

            // Lắng nghe sự thay đổi trên các trường nhập
            document.getElementById('thanhpho').addEventListener('change', updateAddress);
            document.getElementById('quan').addEventListener('input', updateAddress);
            document.getElementById('phuong').addEventListener('input', updateAddress);
            document.getElementById('duong').addEventListener('input', updateAddress);
            document.getElementById('sonha').addEventListener('input', updateAddress);
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Lưu ID phần tử được click trước khi submit form
            document.querySelectorAll('.address-item-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    // Lưu ID của phần tử được click vào sessionStorage
                    const clickedElementId = form.getAttribute('data-id');
                    sessionStorage.setItem('clickedElementId', clickedElementId);
                });
            });

            // Khi trang load lại, scroll đến phần tử đã click
            const clickedElementId = sessionStorage.getItem('clickedElementId');

            if (clickedElementId) {
                const clickedElement = document.querySelector(`[data-id="${clickedElementId}"]`);
                if (clickedElement) {
                    clickedElement.scrollIntoView({
                        behavior: 'smooth'
                    }); // Scroll đến phần tử đã click
                }
            }

            // Sau khi xử lý, xóa giá trị đã lưu để tránh cuộn lại lần nữa khi không cần thiết
            sessionStorage.removeItem('clickedElementId');
        });
    </script>
@endsection
