@extends('admin.layout.master')

@Section('content')
    <style>
        #bar-chart-horizontal {
            width: 100%;
            height: 400px;
        }
    </style><!-- Font Awesome -->
    <!-- Include MDB Charts CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" />
    <!-- Include MDB Charts JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>

    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Thống Kê</h3>
                    {{-- <h6 class="op-7 mb-2">Free Bootstrap 5 Admin Dashboard</h6> --}}
                </div>
                <div class="ms-md-auto py-2 py-md-0">
                    {{-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>              --}}
                    {{-- <form action="{{ route('admin.ThongKe.index') }}" method="post" enctype="multipart/form-data"> --}}
                    {{-- <a href="#" class="btn btn-primary btn-round">Add Customer</a> --}}
                    {{-- <button type="submit" class="btn btn-primary btn-round">Thống kê </button> --}}

                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Tổng doanh thu trong ngày</p>
                                        <h4 class="card-title">{{ number_format($tongTien, 0, ',', '.') }} VND</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Lượt mua</p>
                                        <h4 class="card-title">{{ number_format($tongLuotMuaHang) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-luggage-cart"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Tổng tiền đổi trả</p>
                                        <h4 class="card-title">{{ number_format($tongTienDoiTra, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row card-tools-still-right">
                                <h4 class="card-title">DOANH THU THEO NĂM</h4>
                                <div class="card-tools">

                                    <form method="GET" action="{{ route('admin.ThongKe.index') }}">
                                        <label for="year">Chọn năm:</label>
                                        <select class="form-select input-fixed" name="year" id="year">
                                            @for ($i = 2020; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}"
                                                    {{ (isset($_GET['year']) && $_GET['year'] == $i) || (!isset($_GET['year']) && $i == date('Y')) ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>

                                        <button type="submit" class="btn btn-primary btn-round">Xem Doanh Thu</button>
                                    </form>


                                </div>
                            </div>
                            <!-- <p class="card-category">
                                    Map of the distribution of users around the world
                                </p> -->
                        </div>
                        <div class="card-body">

                            <div class="chart-container">

                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <canvas id="bar-chart-doanh-thu"></canvas>

                                <script>
                                    const thang = @json($thang);
                                    const tongDoanhThu = @json($tongDoanhThu);

                                    const dataDoanhThu = {
                                        labels: thang.map(month => 'Tháng ' + month), // Thêm 'tháng' vào nhãn
                                        datasets: [{
                                            label: 'Doanh thu (VNĐ)',
                                            data: tongDoanhThu,
                                            backgroundColor: '#007bff',
                                        }],
                                    };

                                    const optionsDoanhThu = {
                                        plugins: {
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        let label = context.dataset.label || '';
                                                        label = `${label}: ${context.formattedValue} VNĐ`;
                                                        return label;
                                                    },
                                                },
                                            },
                                        },
                                    };

                                    // Tạo biểu đồ
                                    const ctx = document.getElementById('bar-chart-doanh-thu').getContext('2d');
                                    const barChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: dataDoanhThu,
                                        options: optionsDoanhThu,
                                    });
                                </script>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row card-tools-still-right">
                                <h4 class="card-title">DOANH THU SẢN PHẨM THEO NGÀY</h4>
                                <div class="card-tools">
                                    @php
                                        use Carbon\Carbon;
                                        $today = Carbon::now()->toDateString(); // Lấy ngày hiện tại dưới dạng 'Y-m-d'
                                    @endphp


                                    <form method="GET" action="{{ route('admin.ThongKe.index') }}">
                                        <div class="row form-group">
                                            <div class="col-sm-6">
                                                <label for="ngaybd">Ngày bắt đầu:</label>
                                                <input id="ngaybd" name="ngaybd" type="date"
                                                    value="{{ old('ngaybd', $ngaybd) }}" class="form-control" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="ngaykt">Ngày kết thúc:</label>
                                                <input id="ngaykt" name="ngaykt" type="date"
                                                    value="{{ old('ngaykt', $ngaykt) }}" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-3">
                                            <!-- Sử dụng flexbox để căn chỉnh nút -->
                                            <button type="submit" class="btn btn-primary btn-round">Xem Doanh Thu</button>
                                        </div>
                                    </form>






                                </div>
                            </div>

                        </div>
                        <div class="card-body">

                            <div class="chart-container">

                                <!-- Biểu đồ doanh thu sản phẩm theo ngày -->
                                <canvas id="product-revenue-chart"></canvas>
                                <script>
                                    const labels = @json($doanhThuSanPham->pluck('tensp'));
                                    const data = @json($doanhThuSanPham->pluck('total_revenue'));

                                    console.log(labels); // Kiểm tra giá trị
                                    console.log(data); // Kiểm tra giá trị

                                    const ctx2 = document.getElementById('product-revenue-chart').getContext('2d');
                                    const productRevenueChart = new Chart(ctx2, {
                                        type: 'bar',
                                        data: {
                                            labels: labels,
                                            datasets: [{
                                                label: 'Doanh Thu Từng Sản Phẩm',
                                                data: data,
                                                backgroundColor: '#007bff',
                                            }],
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            plugins: {
                                                tooltip: {
                                                    callbacks: {
                                                        label: function(context) {
                                                            let label = context.dataset.label || '';
                                                            label = `${label}: ${context.formattedValue} VND`;
                                                            return label;
                                                        },
                                                    },
                                                },
                                            },
                                        },
                                    });
                                </script>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Số lượng sản phẩm đã bán trong ngày</div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="bar-chart-horizontal-1"></canvas>

                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                                <script>
                                    const labels1 = @json($dataSanPham->pluck('tensp')); // Lấy tên sản phẩm
                                    const data1 = @json($dataSanPham->pluck('total_sold')); // Lấy tổng số lượng đã bán

                                    // Kiểm tra dữ liệu truyền vào biểu đồ
                                    // console.log(labels1);
                                    // console.log(data1);

                                    const dataBarHorizontal1 = {
                                        labels: labels1, // Tên sản phẩm
                                        datasets: [{
                                            label: 'Số lượng sản phẩm đã bán',
                                            data: data1, // Tổng số lượng đã bán
                                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            borderWidth: 1,
                                        }],
                                    };

                                    const optionsBarHorizontal1 = {
                                        indexAxis: 'y', // Biểu đồ ngang
                                        scales: {
                                            x: {
                                                stacked: true,
                                                grid: {
                                                    display: true,
                                                    borderDash: [2],
                                                },
                                                ticks: {
                                                    color: 'rgba(0,0,0, 0.5)',
                                                },
                                            },
                                            y: {
                                                stacked: true,
                                                grid: {
                                                    display: false,
                                                },
                                                ticks: {
                                                    color: 'rgba(0,0,0, 0.5)',
                                                },
                                            },
                                        },
                                    };

                                    new Chart(document.getElementById('bar-chart-horizontal-1'), {
                                        type: 'bar',
                                        data: dataBarHorizontal1,
                                        options: optionsBarHorizontal1,
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Số lượng sản phảm tồn kho</div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="bar-chart-horizontal-2"></canvas>

                                <script>
                                    const labels2 = @json($dataSanPhamTonKho->pluck('tensp')); // Lấy tên sản phẩm
                                    const data2 = @json($dataSanPhamTonKho->pluck('inventory_stock')); // Lấy số lượng hàng tồn kho

                                    // Kiểm tra dữ liệu truyền vào biểu đồ
                                    console.log(labels2);
                                    console.log(data2);

                                    const dataBarHorizontal2 = {
                                        labels: labels2, // Tên sản phẩm
                                        datasets: [{
                                            label: 'Số lượng hàng tồn kho',
                                            data: data2, // Số lượng hàng tồn kho
                                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                            borderColor: 'rgba(255, 99, 132, 1)',
                                            borderWidth: 1,
                                        }],
                                    };

                                    const optionsBarHorizontal2 = {
                                        indexAxis: 'y', // Biểu đồ ngang
                                        scales: {
                                            x: {
                                                stacked: true,
                                                grid: {
                                                    display: true,
                                                    borderDash: [2],
                                                },
                                                ticks: {
                                                    color: 'rgba(0,0,0, 0.5)',
                                                },
                                            },
                                            y: {
                                                stacked: true,
                                                grid: {
                                                    display: false,
                                                },
                                                ticks: {
                                                    color: 'rgba(0,0,0, 0.5)',
                                                },
                                            },
                                        },
                                    };

                                    new Chart(document.getElementById('bar-chart-horizontal-2'), {
                                        type: 'bar',
                                        data: dataBarHorizontal2,
                                        options: optionsBarHorizontal2,
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Thống kê sản phẩm</h4>
                        <div class="card-tools">
                            <form method="GET" action="{{ route('admin.ThongKe.index') }}">
                                <div class="row form-group mb-3">
                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <label for="Quy">Chọn Quý:</label>
                                        <select class="form-select input-fixed" id="Quy" name="Quy">
                                            <option value="0"
                                                {{ isset($_GET['Quy']) && $_GET['Quy'] == 0 ? 'selected' : '' }}>Bỏ Chọn 
                                            </option>
                                            <option value="1"
                                                {{ isset($_GET['Quy']) && $_GET['Quy'] == 1 ? 'selected' : '' }}>Quý 1
                                            </option>
                                            <option value="2"
                                                {{ isset($_GET['Quy']) && $_GET['Quy'] == 2 ? 'selected' : '' }}>Quý 2
                                            </option>
                                            <option value="3"
                                                {{ isset($_GET['Quy']) && $_GET['Quy'] == 3 ? 'selected' : '' }}>Quý 3
                                            </option>
                                            <option value="4"
                                                {{ isset($_GET['Quy']) && $_GET['Quy'] == 4 ? 'selected' : '' }}>Quý 4
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <label for="year">Chọn Năm:</label>
                                        <select class="form-select input-fixed" name="year" id="year">
                                            @for ($i = 2020; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}"
                                                    {{ (isset($_GET['year']) && $_GET['year'] == $i) || (!isset($_GET['year']) && $i == date('Y')) ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <label for="ngaybdtk">Ngày bắt đầu:</label>
                                        <input id="ngaybdtk" name="ngaybdtk" type="date"
                                            value="{{ old('ngaybd', $ngaybd) }}" class="form-control" />
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-12">
                                        <label for="ngaykttk">Ngày kết thúc:</label>
                                        <input id="ngaykttk" name="ngaykttk" type="date"
                                            value="{{ old('ngaykt', $ngaykt) }}" class="form-control" />
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <!-- Nút Xem Doanh Thu -->
                                    <button type="submit" class="btn btn-primary btn-round me-2" name="action"
                                        value="view" id="viewRevenueButton">Xem Doanh Thu</button>

                                    <!-- Nút Xuất File Excel -->
                                    <button type="submit" class="btn btn-primary btn-round" name="action"
                                        value="export">Xuất file excel</button>
                                </div>
                            </form>






                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="display table table-striped table-hover">
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>SL bán</th>
            <th>SL nhập</th>
            <th>Doanh thu</th>
            <th>Chi phí nhập</th>
            <!-- <th>Tiền lời thu được</th> -->
            <th>Tình trạng</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Tên sản phẩm</th>
            <th>SL bán</th>
            <th>SL nhập</th>
            <th>Doanh thu</th>
            <th>Chi phí nhập</th>
            <!-- <th>Tiền lời</th> -->
            <th>Tình trạng</th>
        </tr>
    </tfoot>
    <tbody>
        @foreach ($sanPhamThongKe as $sanPham)
            @php
                // Lấy giá trị và xử lý để đảm bảo không có null
                $soLuongBan = $sanPham->so_luong_ban ?? 0;
                $soLuongNhap = $sanPham->so_luong_nhap ?? 0;
                $doanhThu = $sanPham->doanh_thu ?? 0;
                $chiPhiNhap = $sanPham->chi_phi_nhap ?? 0;
                $loiNhuan = $sanPham->loi_nhuan ?? 0;

                // Xác định màu sắc tình trạng
                $tinhTrang = $doanhThu - $chiPhiNhap;
                if ($tinhTrang > 0) {
                    $tinhTrangClass = 'text-success'; // Lợi
                } elseif ($tinhTrang < 0) {
                    $tinhTrangClass = 'text-danger'; // Lỗ
                } else {
                    $tinhTrangClass = 'text-warning'; // Thu hồi vốn
                }
            @endphp
            <tr>
                <td>{{ $sanPham->ten_san_pham }}</td>
                <td>{{ $soLuongBan }}</td>
                <td>{{ $soLuongNhap }}</td>
                <td>{{ number_format($doanhThu, 0, ',', '.') }} VNĐ</td>
                <td>{{ number_format($chiPhiNhap, 0, ',', '.') }} VNĐ</td>
                <!-- <td>{{ number_format($loiNhuan, 0, ',', '.') }} VNĐ</td> -->
                <td class="{{ $tinhTrangClass }}">
                    @if ($tinhTrang > 0)
                        Lời
                    @elseif ($tinhTrang < 0)
                        Lỗ
                    @else
                        Thu hồi vốn
                    @endif
                </td>                    
            </tr>
        @endforeach
    </tbody>
</table>

                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            {{ $sanPhamThongKe->appends(request()->input())->links('pagination::bootstrap-4') }}
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
     
        // Xử lý ngày
        document.getElementById('ngaybd').removeAttribute('min');
        document.getElementById('ngaykt').removeAttribute('min');

        document.getElementById('ngaybd').addEventListener('change', function() {
            var startDate = this.value;
            if (startDate) {
                document.getElementById('ngaykt').setAttribute('min', startDate);
            }
        });


 
        document.getElementById('ngaykttk').setAttribute('min', formattedDate);

        document.getElementById('ngaybdtk').addEventListener('change', function() {
            var startDate = this.value;
            if (startDate) {
                document.getElementById('ngaykttk').setAttribute('min', startDate);
            }
        });
    });
</script>
    <script>
        document.getElementById('viewRevenueButton').addEventListener('click', function() {
            // Lưu vị trí cuộn hiện tại vào localStorage
            localStorage.setItem('scrollPosition', window.scrollY);
        });

        window.onload = function() {
            // Kiểm tra xem có vị trí cuộn đã lưu không
            if (localStorage.getItem('scrollPosition')) {
                // Cuộn đến vị trí đã lưu
                window.scrollTo(0, localStorage.getItem('scrollPosition'));
            }
        }
    </script>
@endsection
