@extends('admin.layout.master')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Chỉnh Sửa Phiếu Nhập</h3>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">



                    <form action="{{ route('admin.PhieuNhap.update', $phieuNhap->idpn) }}" method="POST">
                        @csrf
                        @method('PUT')
            
                        <!-- Thông tin phiếu nhập -->
                        <div class="form-group">
                            <label for="tennhacungcap">Tên Nhà Cung Cấp</label>
                            <input type="text" id="tennhacungcap" name="tennhacungcap" value="{{ old('tennhacungcap', $phieuNhap->tennhacungcap) }}" class="form-control" required>
                        </div>
            
                        <div class="form-group">
                            <label for="ngaylap">Ngày Lập</label>
                            <input 
                                type="text" 
                                id="ngaylap" 
                                name="ngaylap" 
                                value="{{ \Carbon\Carbon::parse($phieuNhap->ngaylap)->format('d-m-Y') }}" 
                                class="form-control" 
                                readonly>
                        </div>


                        <div class="form-group">
                            <label for="ghichu">Ghi Chú</label>
                            <textarea id="ghichu" name="ghichu" class="form-control">{{ old('ghichu', $phieuNhap->ghichu) }}</textarea>
                        </div>
            
                        <!-- Ô tìm kiếm sản phẩm -->
                        <input type="text" id="searchSanPham" class="form-control mb-2" style="border: 2px solid black; margin:10px; width:98%;" placeholder="Tìm Kiếm" >


                        <h6>Danh Sách Sản Phẩm</h6>
                        <div class="table-responsive me-3" style="max-height: 200px; overflow-y: auto; flex: 1;">
                            <table class="table" id="SanPhamTable">
                                <thead>
                                    <tr>
                                        <th>ID</th> <!-- Thêm cột ID -->
                                        <th>Tên Sản Phẩm</th>
                                        <th>Giá Bán</th>
                                        <th>Danh Mục</th>
                                        <th>Thao Tác</th> <!-- Cột chứa nút thêm -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($SanPhams as $SanPham)
                                        <tr>
                                            <td>{{ $SanPham->idsp }}</td> <!-- Hiển thị ID sản phẩm -->
                                            <td>{{ $SanPham->tensp }}</td>
                                            <td>{{ number_format($SanPham->gia, 0, ',', '.') }} đ</td>
                                            <td>
                                                @if($SanPham->loaisp->isNotEmpty())
                                                    @foreach($SanPham->loaisp as $loai)
                                                        {{ $loai->tenloai }}@if(!$loop->last), @endif
                                                    @endforeach
                                                @else
                                                    Không có danh mục
                                                @endif
                                            </td>
                                            <td class="action-column">
                                                <button type="button" class="btn btn-success add-to-details" data-id="{{ $SanPham->idsp }}" data-name="{{ $SanPham->tensp }}" data-price="{{ $SanPham->gia }}">
                                                    <i class="fa fa-plus"></i> <!-- Icon dấu "+" -->
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
            

                        <!-- Ô tìm kiếm sản phẩm trong chi tiết phiếu nhập -->
                        <input type="text" id="searchChiTietPhieuNhap" class="form-control mb-2" style="border: 2px solid black; margin:10px; width:98%;" placeholder="Tìm Kiếm" >
                        
                        {{-- Bảng chi tiết phiếu nhập --}}
                        <h6>Chi Tiết Phiếu Nhập</h6>
                        <div class="table-responsive mt-3" style="max-height: 400px; overflow-y: auto;">
                            <table class="table" id="ChiTietPhieuNhapTable">
                                <thead>
                                    <tr>
                                        <th>ID</th> <!-- Thêm cột ID -->
                                        <th>Tên Sản Phẩm</th>
                                        <th>Số Lượng</th>
                                        <th>Đơn Giá</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody id="detail-body">
                                    @foreach($phieuNhap->chiTietPhieuNhap as $chiTiet)
                                        <tr id="row-{{ $chiTiet->idsp }}">
                                            <td>{{ $chiTiet->idsp }}</td>
                                            <td>
                                                <input type="text" name="tensp[{{ $chiTiet->idsp }}]" 
                                                       value="{{ old('tensp.' . $chiTiet->idsp, $chiTiet->tensp) }}" 
                                                       class="form-control"
                                                       readonly>
                                            </td>
                                            <td>
                                                <input type="number" name="soluong[{{ $chiTiet->idsp }}]" value="{{ old('soluong.' . $chiTiet->idsp, $chiTiet->soluong) }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" name="dongia[{{ $chiTiet->idsp }}]" value="{{ old('dongia.' . $chiTiet->idsp, $chiTiet->dongia) }}" class="form-control">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger remove-product">
                                                    <i class="fa fa-trash"></i> <!-- Icon thùng rác để xóa -->
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="form-group mt-2">
                            <label for="displayTongTien">Tổng Tiền:</label>
                            {{-- <input type="hidden" id="tongtien" name="tongtien" value="0"> --}}
                            <input type="text" id="displayTongTien" class="form-control" value="{{ number_format($phieuNhap->tongtien, 0, ',', '.') }}" readonly>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập Nhật Phiếu Nhập</button>
                        </div>
                    </form>




                </div>
            </div>
        </div>
    </div>
</div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Lắng nghe sự kiện thay đổi trong toàn bộ tbody của bảng ChiTietPhieuNhapTable
            const detailTableBody = document.querySelector('#ChiTietPhieuNhapTable tbody');

            if (detailTableBody) {
                detailTableBody.addEventListener('input', updateTongTien);
                detailTableBody.addEventListener('change', updateTongTien);
            }

            
                    // Tìm kiếm sản phẩm theo thời gian thực
                    document.getElementById('searchSanPham').addEventListener('input', function () {
                        var searchTerm = removeDiacritics(this.value);
                        var rows = document.querySelectorAll('#SanPhamTable tbody tr');

                        rows.forEach(function (row) {
                            var productName = removeDiacritics(row.cells[1].textContent);
                            row.style.display = productName.includes(searchTerm) ? '' : 'none';
                        });
                    });

                    document.getElementById('searchChiTietPhieuNhap').addEventListener('input', function () {
                        var searchTerm = removeDiacritics(this.value);
                        var rows = document.querySelectorAll('#ChiTietPhieuNhapTable tbody tr');

                        rows.forEach(function (row) {
                            var productName = removeDiacritics(row.cells[1].textContent);
                            row.style.display = productName.includes(searchTerm) ? '' : 'none';
                        });
                    });

            // Sự kiện thêm sản phẩm
            document.querySelectorAll('.add-to-details').forEach(function (button) {
                button.addEventListener('click', function () {
                    var id = this.getAttribute('data-id');
                    var name = this.getAttribute('data-name');
                    var price = parseFloat(this.getAttribute('data-price')) || 0;

                    // Kiểm tra sản phẩm đã tồn tại trong bảng chưa
                    var exists = Array.from(document.querySelectorAll('#ChiTietPhieuNhapTable tbody tr')).some(function (row) {
                        return row.querySelector(`[data-id="${id}"]`) || row.querySelector(`input[name="tensp[${id}]"]`);
                    });

                    if (exists) {
                        alert('Sản phẩm này đã tồn tại trong bảng!');
                        return;
                    }

                    // Tạo hàng mới
                    var newRow = `
                        <tr data-id="${id}">
                            <td>${id}</td>
                            <td>
                                <input type="text" 
                                name="tensp[${id}]" 
                                value="${name}" 
                                class="form-control" 
                                readonly>
                            </td>
                            <td>
                                <input type="number" name="soluong[${id}]" value="1" min="1" class="form-control soluong">
                            </td>
                            <td>
                                <input type="number" name="dongia[${id}]" value="${price}" min="0" class="form-control dongia">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-product">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    document.querySelector('#ChiTietPhieuNhapTable tbody').insertAdjacentHTML('beforeend', newRow);

                    // Gắn lại sự kiện
                    attachRemoveProductEvent();
                    updateTongTien();
                });
            });


            // Sử dụng event delegation
            document.querySelector('#ChiTietPhieuNhapTable tbody').addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-product') || event.target.closest('.remove-product')) {
                    const row = event.target.closest('tr'); // Lấy dòng hiện tại
                    if (row) row.remove(); // Xóa dòng
                    updateTongTien(); // Cập nhật tổng tiền
                }
            });

            // Hàm cập nhật tổng tiền
            function updateTongTien() {
                var tongTien = 0; // Khởi tạo tổng tiền

                // Duyệt qua từng dòng trong bảng ChiTietPhieuNhapTable
                document.querySelectorAll('#ChiTietPhieuNhapTable tbody tr').forEach(function (row) {
                    // Lấy giá trị số lượng và đơn giá từ các input trong mỗi dòng
                    var quantityInput = row.querySelector('input[name^="soluong"]');
                    var priceInput = row.querySelector('input[name^="dongia"]');

                    // Đảm bảo giá trị được chuyển đổi thành số, nếu không mặc định là 0
                    var quantity = quantityInput ? parseInt(quantityInput.value) || 0 : 0;
                    var price = priceInput ? parseFloat(priceInput.value) || 0 : 0;

                    // Tính tổng tiền cho dòng này và cộng dồn vào tổng tiền
                    tongTien += quantity * price;
                });

                // Cập nhật tổng tiền vào input ẩn và hiển thị
                var hiddenTongTien = document.getElementById('tongtien');
                var displayTongTien = document.getElementById('displayTongTien');

                if (hiddenTongTien) {
                    hiddenTongTien.value = tongTien; // Tổng tiền dạng số cho xử lý backend
                }

                if (displayTongTien) {
                    displayTongTien.value = formatVND(tongTien); // Hiển thị tổng tiền dưới dạng VND
                }

                console.log('Tổng tiền cập nhật:', tongTien);
            }

            // Hàm định dạng số thành kiểu tiền tệ (VND)
            function formatVND(value) {
                return new Intl.NumberFormat('vi-VN').format(value);
            }

            // Hàm loại bỏ dấu tiếng Việt
            function removeDiacritics(str) {
                return str
                    .normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, "")
                    .toLowerCase();
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
            padding: 10px;
            border-radius: 8px;
        }
        
    </style>
@endsection
