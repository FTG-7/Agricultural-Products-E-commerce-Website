@extends('admin.layout.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Thông Tin Chi Tiết Phiếu Nhập</h3>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">



                    <form action="{{ route('admin.PhieuNhap.update', $phieuNhap->idpn) }}" method="GET">
                        @csrf
            
                        <!-- Thông tin phiếu nhập -->
                        <div class="form-group">
                            <label for="tennhacungcap">Tên Nhà Cung Cấp</label>
                            <p id="tennhacungcap" class="form-control-static">{{ $phieuNhap->tennhacungcap }}</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="ngaylap">Ngày Lập</label>
                            <p id="ngaylap" class="form-control-static">{{ \Carbon\Carbon::parse($phieuNhap->ngaylap)->format('d-m-Y') }}</p>
                        </div>
                        
                        <div class="form-group">
                            <label for="ghichu">Ghi Chú</label>
                            <p id="ghichu" class="form-control-static text-start" style="white-space: pre-wrap;">{{ $phieuNhap->ghichu ?: 'Không có' }}</p>
                        </div>
            
                        
                        <!-- Ô tìm kiếm sản phẩm trong chi tiết phiếu nhập -->
                        <input type="text" id="searchChiTietPhieuNhap" class="form-control mb-2" style="border: 2px solid black; margin:10px; width:98%;" placeholder="Tìm Kiếm" >
                        
                        {{-- Bảng chi tiết phiếu nhập --}}
                        <h6>Chi Tiết Phiếu Nhập</h6>
                        <div class="table-responsive mt-3" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-bordered" id="ChiTietPhieuNhapTable">
                                <thead>
                                    <tr>
                                        <th>ID</th> <!-- Thêm cột ID -->
                                        <th>Tên Sản Phẩm</th>
                                        <th>Số Lượng</th>
                                        <th>Đơn Giá</th>
                                    </tr>
                                </thead>
                                <tbody id="detail-body">
                                    @foreach($phieuNhap->chiTietPhieuNhap as $chiTiet)
                                        <tr id="row-{{ $chiTiet->idsp }}">
                                            <td>{{ $chiTiet->idsp }}</td>
                                            <td>{{ $chiTiet->tensp }}</td> <!-- Hiển thị trực tiếp tên sản phẩm -->
                                            <td>{{ $chiTiet->soluong }}</td>
                                            <td>{{ number_format($chiTiet->dongia, 0, ',', '.') }} VND</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="form-group mt-2">
                            <label for="displayTongTien">Tổng Tiền:</label>
                            <p id="displayTongTien" class="form-control-static fw-bold fs-4 text-danger">
                                {{ number_format($phieuNhap->tongtien, 0, ',', '.') }} VND
                            </p>
                        </div>
                    </form>




                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function removeDiacritics(str) {
                return str
                    .normalize("NFD") // Tách các ký tự Unicode
                    .replace(/[\u0300-\u036f]/g, "") // Loại bỏ dấu
                    .toLowerCase(); // Chuyển về chữ thường
            }

            const searchInput = document.getElementById('searchChiTietPhieuNhap');
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    const searchTerm = removeDiacritics(this.value);
                    const rows = document.querySelectorAll('#ChiTietPhieuNhapTable tbody tr');

                    rows.forEach(function (row) {
                        // Lấy nội dung của cột Tên Sản Phẩm
                        const productName = removeDiacritics(row.cells[1].textContent.trim());

                        // Hiển thị hoặc ẩn hàng dựa trên từ khóa tìm kiếm
                        row.style.display = productName.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
        });

    </script>

    <style>
        /* Tittle từng cột di chuyển theo mỗi khi roll xuống */
        .table thead tr {
        position: sticky;
        top: 0; /* Vị trí dính lên trên cùng */
        background-color: white; /* Màu nền để tiêu đề không bị trong suốt */
        z-index: 1; /* Đảm bảo nó ở trên cùng */
        border-bottom: 2px solid #007bff; /* Đường viền dưới để phân cách */
        }

        h6 {
            padding-left: 10px;
        }

        #displayTongTien {
            font-size: 1.5rem; /* Kích thước chữ lớn hơn */
            color: #ff0000; /* Màu đỏ nổi bật */
            font-weight: bold; /* Chữ in đậm */
            text-align: left; /* Canh giữa */
            background-color: #ffe5e5; /* Nền màu nhạt để nổi bật */
            padding: 10px;
            border-radius: 8px;
        }
    </style>
@endsection
