@extends('user.layout.master')

@section('content')
    
    <!-- Single Page Header End -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Đơn Hàng</h1>
    </div>

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

    <!-- Order List Start -->
    <div class="container-fluid py-5" >
        <div class="container py-5">

            <!-- Tab for Order Status -->
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-tat-ca" data-bs-toggle="tab" href="#all">Tất cả</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-choxacnhan" data-bs-toggle="tab" href="#choxacnhan">Chờ xác nhận</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-danggiao" data-bs-toggle="tab" href="#danggiao">Đang giao</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-giaothanhcong" data-bs-toggle="tab" href="#giaothanhcong">Giao thành công</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-giaothatbai" data-bs-toggle="tab" href="#giaothatbai">Giao thất bại</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-donhuy" data-bs-toggle="tab" href="#donhuy">Đã hủy</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content">
                <!-- Tất cả -->
                <div class="tab-pane fade show active" id="all">
                    <!-- Table for all orders -->
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Ngày đặt</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Trạng thái</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donHangs as $donHang)
                                    <tr data-iddh="{{ $donHang->iddh }}" data-ngaydat="{{ $donHang->ngaydat }}" data-trangthai="{{ $donHang->trangthai }}">
                                        <td>{{ $donHang->iddh }}</td>
                                        <td>{{ $donHang->ngaydat }}</td>
                                        <td>{{ number_format($donHang->tongtien, 0, ',', '.') }} VND</td>
                                        <td>{{ $donHang->trangthai }}</td>
                                        <td>
                                            <a href="{{ route('MuaHang.ShowOrderDetail', $donHang->iddh) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                                        </td>

                                        @if($donHang->trangthai == "Chờ xác nhận")
                                            <td>
                                                <form action="{{ route('MuaHang.CancelOrder', $donHang->iddh) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hủy đơn</button>
                                                </form>
                                            </td>
                                        @endif

                                        @if ($donHang->trangthai === 'Giao thành công')
                                                <?php
                                                    // $ngaygiaoDateTime = new DateTime($donHang->ngaygiao); // Chuyển đổi ngày đặt thành DateTime
                                                    // $currentDateTime = new DateTime(); // Ngày hiện tại
                                                    // $diffDays = $currentDateTime->diff($ngaygiaoDateTime)->days; // Tính số ngày khác biệt
                                                    $existingReturn = \App\Models\DoiTra::where('iddh', $donHang->iddh)->exists();
                                                ?>
                                                @if (!$existingReturn)
                                                    <!-- Hiển thị nội dung ở đây nếu điều kiện đúng -->
                                                    <td>
                                                        <a href="{{ route('doitra.create', ['iddh' => $donHang->iddh]) }}"
                                                            class="btn btn-warning btn-sm w-100 d-flex justify-content-center align-items-center">Trả hàng</a>
                                                    </td>
                                                @endif
                                        @endif

                                    </tr>
                                @endforeach
                                @if ($donHangs->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">Không có đơn hàng nào.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Chờ xác nhận -->
                <div class="tab-pane fade" id="choxacnhan">
                    <!-- Table for "Chờ xác nhận" orders -->
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Ngày đặt</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Trạng thái</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donHangs->where('trangthai', 'Chờ xác nhận') as $donHang)
                                    <tr>
                                        <td>{{ $donHang->iddh }}</td>
                                        <td>{{ $donHang->ngaydat }}</td>
                                        <td>{{ number_format($donHang->tongtien, 0, ',', '.') }} VND</td>
                                        <td>{{ $donHang->trangthai }}</td>
                                        <td>
                                            <a href="{{ route('MuaHang.ShowOrderDetail', $donHang->iddh) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('MuaHang.CancelOrder', $donHang->iddh) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-danger btn-sm">Hủy đơn</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Đang giao -->
                <div class="tab-pane fade" id="danggiao">
                    <!-- Table for "Đang giao" orders -->
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Ngày đặt</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Trạng thái</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donHangs->where('trangthai', 'Đang giao') as $donHang)
                                    <tr>
                                        <td>{{ $donHang->iddh }}</td>
                                        <td>{{ $donHang->ngaydat }}</td>
                                        <td>{{ number_format($donHang->tongtien, 0, ',', '.') }} VND</td>
                                        <td>{{ $donHang->trangthai }}</td>
                                        <td>
                                            <a href="{{ route('MuaHang.ShowOrderDetail', $donHang->iddh) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Giao thành công -->
                <div class="tab-pane fade" id="giaothanhcong">
                    <!-- Table for "Giao thành công / Giao thất bại" orders -->
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Ngày đặt</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Trạng thái</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donHangs->where('trangthai', 'Giao thành công') as $donHang)
                                    <tr>
                                        <td>{{ $donHang->iddh }}</td>
                                        <td>{{ $donHang->ngaydat }}</td>
                                        <td>{{ number_format($donHang->tongtien, 0, ',', '.') }} VND</td>
                                        <td>{{ $donHang->trangthai }}</td>
                                        <td>
                                            <a href="{{ route('MuaHang.ShowOrderDetail', $donHang->iddh) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                                        </td>
                                        @if ($donHang->trangthai === 'Giao thành công')
                                                <?php
                                                    // $ngaygiaoDateTime = new DateTime($donHang->ngaygiao); // Chuyển đổi ngày đặt thành DateTime
                                                    // $currentDateTime = new DateTime(); // Ngày hiện tại
                                                    // $diffDays = $currentDateTime->diff($ngaygiaoDateTime)->days; // Tính số ngày khác biệt
                                                    $existingReturn = \App\Models\DoiTra::where('iddh', $donHang->iddh)->exists();
                                                ?>
                                                @if (!$existingReturn)
                                                    <!-- Hiển thị nội dung ở đây nếu điều kiện đúng -->
                                                    <td>
                                                        <a href="{{ route('doitra.create', ['iddh' => $donHang->iddh]) }}"
                                                            class="btn btn-warning btn-sm w-100 d-flex justify-content-center align-items-center">Trả hàng</a>
                                                    </td>
                                                @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Giao thất bại --}}
                <div class="tab-pane fade" id="giaothatbai">
                    <!-- Table for "Giao thành công / Giao thất bại" orders -->
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Ngày đặt</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Trạng thái</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donHangs->where('trangthai', 'Giao thất bại') as $donHang)
                                    <tr>
                                        <td>{{ $donHang->iddh }}</td>
                                        <td>{{ $donHang->ngaydat }}</td>
                                        <td>{{ number_format($donHang->tongtien, 0, ',', '.') }} VND</td>
                                        <td>{{ $donHang->trangthai }}</td>
                                        <td>
                                            <a href="{{ route('MuaHang.ShowOrderDetail', $donHang->iddh) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Đơn hủy -->
                <div class="tab-pane fade" id="donhuy">
                    <!-- Table for "Đơn hủy" orders -->
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Ngày đặt</th>
                                    <th scope="col">Tổng tiền</th>
                                    <th scope="col">Trạng thái</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donHangs->where('trangthai', 'Đơn hủy') as $donHang)
                                    <tr>
                                        <td>{{ $donHang->iddh }}</td>
                                        <td>{{ $donHang->ngaydat }}</td>
                                        <td>{{ number_format($donHang->tongtien, 0, ',', '.') }} VND</td>
                                        <td>{{ $donHang->trangthai }}</td>
                                        <td>
                                            <a href="{{ route('MuaHang.ShowOrderDetail', $donHang->iddh) }}" class="btn btn-primary btn-sm">Chi tiết</a>
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

    <!-- Order List End -->
    <style>
        /* Sử dụng Flexbox để phân chia đều các tab */
        .nav-tabs {
            display: flex;
            justify-content: space-between; /* Giãn cách đều giữa các tab */
            padding: 0; /* Loại bỏ padding của ul */
            margin: 0; /* Loại bỏ margin của ul */
        }

        /* Các ô tab sẽ có chiều rộng bằng nhau */
        .nav-tabs .nav-item {
            flex: 1; /* Điều chỉnh mỗi tab có chiều rộng bằng nhau */
        }

        /* Căn giữa văn bản trong các tab */
        .nav-tabs .nav-link {
            text-align: center; /* Căn giữa chữ trong tab */
            padding: 10px 0; /* Điều chỉnh padding trên và dưới */
            display: block; /* Chuyển liên kết thành khối để chiếm toàn bộ chiều rộng */
        }

        /* Tùy chỉnh màu sắc và viền cho tab khi active */
        .nav-tabs .nav-link.active {
            background-color: #94c43c; /* Màu nền khi hover lên tab */
            color: white;
        }


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
    </style>

    <script>
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
