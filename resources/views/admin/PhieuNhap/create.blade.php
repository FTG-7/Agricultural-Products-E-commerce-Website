<!-- Modal thêm phiếu nhập -->
<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-labelledby="addRowModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRowModalLabel">Thêm Phiếu Nhập</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>




            <form action="{{ route('admin.PhieuNhap.create') }}" method="post" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tennhacungcap">Tên Nhà Cung Cấp</label>
                        <input id="tennhacungcap" name="tennhacungcap" type="text" class="form-control" placeholder="Bạn phải nhập tên nhà cung cấp để tiếp tục" required>
                        @if ($errors->has('tenncc'))
                            <span class="text-danger">{{ $errors->first('tenncc') }}</span>
                        @endif
                    </div>
                    
                    <input type="hidden" id="tongtien" name="tongtien" class="form-control" value="0" required>
                    
                    {{-- <div class="form-group">
                        <label for="ngaylap">Ngày Lập Phiếu</label>
                        <input id="ngaylap" name="ngaylap" type="date" class="form-control" required>
                    </div> --}}
                    
                    <div class="form-group">
                        <label for="ghichu">Ghi Chú</label>
                        <textarea id="ghichu" name="ghichu" class="form-control" rows="3" placeholder="Ghi chú (nếu có)" disabled></textarea>
                    </div>

                    <!-- Ô tìm kiếm sản phẩm -->
                    <input type="text" id="search" class="form-control mb-2" style="border: 2px solid black;" placeholder="Tìm Kiếm" disabled>

                    <!-- Bảng sản phẩm -->
                    <h6>Danh Sách Sản Phẩm</h6>
                    <div class="table-responsive me-3" style="max-height: 200px; overflow-y: auto; flex: 1;">
                        <table class="table" id="SanPhamTable"   >
                            <thead>
                                <tr>
                                    <th>ID</th> <!-- Thêm cột ID -->
                                    <th>Tên Sản Phẩm</th>
                                    <th>Giá</th>
                                    <th>DVT</th>
                                    <th>Tồn kho</th>
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
                                            {{-- @if($SanPham->loaisp->isNotEmpty())
                                                @foreach($SanPham->loaisp as $loai)
                                                    {{ $loai->tenloai }}@if(!$loop->last), @endif
                                                @endforeach
                                            @else
                                                Không có danh mục
                                            @endif --}}
                                            {{ $SanPham->donvitinh }}
                                        </td>
                                        <td>{{ $SanPham->soluong }}</td>
                                        <td class="action-column">
                                            <button type="button" class="btn btn-success add-to-details" data-id="{{ $SanPham->idsp }}" data-name="{{ $SanPham->tensp }}" data-price="{{ $SanPham->gia }}" disabled>
                                                <i class="fa fa-plus"></i> <!-- Icon dấu "+" -->
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <!-- Bảng Chi Tiết Phiếu Nhập -->
                    <h6 style="margin-top: 10px ">Chi Tiết Phiếu Nhập</h6>
                    <div class="table-responsive mt-3" style="max-height: 200px; overflow-y: auto;">
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
                            <tbody>
                                <!-- Dữ liệu chi tiết phiếu nhập sẽ được thêm vào đây -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Dòng hiển thị Tổng Tiền -->
                    <div class="form-group mt-2">
                        <label for="displayTongTien">Tổng Tiền:</label>
                        <input type="text" id="displayTongTien" class="form-control" value="0 VND" style="color: #ff0000;" readonly>
                    </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" disabled>Lưu Phiếu Nhập</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Kiểm tra ngay khi nhập xong ô "Tên Nhà Cung Cấp"
        document.getElementById('tennhacungcap').dispatchEvent(new Event('input'));

        // Hàm xử lý khi nhập tên nhà cung cấp
        document.getElementById('tennhacungcap').addEventListener('input', function() {
            var isFilled = this.value.trim() !== ''; // Kiểm tra xem tên nhà cung cấp có được nhập hay không

            // Kích hoạt các trường khi nhập tên nhà cung cấp
            toggleFields(isFilled);
        });

        // Hàm bật/tắt các trường khác khi tên nhà cung cấp được nhập
        function toggleFields(isFilled) {
            var inputs = document.querySelectorAll('input, textarea, button[disabled],table'); // Lấy tất cả các input, textarea, button
            inputs.forEach(function(input) {
                if (input.id !== 'tennhacungcap') { // Nếu không phải là ô nhập tên nhà cung cấp
                    input.disabled = !isFilled; // Nếu không nhập, disable; nếu có nhập, enable
                    if (input.tagName === 'BUTTON') {
                        input.style.cursor = isFilled ? 'pointer' : 'not-allowed'; // Thay đổi con trỏ cho button
                    }
                }
            });
        }


        // Hàm loại bỏ dấu tiếng Việt
        function removeDiacritics(str) {
            return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
        }

        // Tìm kiếm sản phẩm theo thời gian thực
        document.getElementById('search').addEventListener('input', function() {
            var searchTerm = removeDiacritics(this.value); // Lấy giá trị tìm kiếm, chuyển thành không dấu và chữ thường
            var rows = document.querySelectorAll('#SanPhamTable tbody tr'); // Lấy tất cả các hàng trong bảng

            rows.forEach(function(row) {
                var productName = removeDiacritics(row.cells[1].textContent); // Lấy tên sản phẩm từ cột đầu tiên
                if (productName.includes(searchTerm)) {
                    row.style.display = ''; // Hiện hàng nếu tìm thấy
                } else {
                    row.style.display = 'none'; // Ẩn hàng nếu không tìm thấy
                }
            });
        });

        // Xử lý sự kiện click nút thêm sản phẩm
        document.querySelectorAll('.add-to-details').forEach(function(button) {
            button.addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                var name = this.getAttribute('data-name');
                var price = parseFloat(this.getAttribute('data-price')); // Chuyển đổi giá thành số

                // Kiểm tra xem sản phẩm đã có trong bảng chi tiết chưa
                var existingRow = document.querySelector(`#ChiTietPhieuNhapTable tbody tr[data-id="${id}"]`);
                if (existingRow) {
                    alert('Sản phẩm đã được thêm vào phiếu nhập!');
                    return; // Dừng việc thêm sản phẩm nếu đã tồn tại
                }

                // Tạo một hàng mới cho bảng chi tiết phiếu nhập
                var newRow = `
                    <tr data-id="${id}">
                        <td>${id}</td> <!-- Hiển thị ID sản phẩm -->
                        <td>${name}</td>
                        <td>
                            <input type="number" name="soluong[${id}]" value="1" min="1" class="form-control soluong" style="width: 80px;">
                        </td>
                        <td>
                            <input type="number" name="dongia[${id}]" value="${price}" min="0" class="form-control dongia" style="width: 120px;">
                        </td>
                        <td>
                            <input type="hidden" name="tensp[${id}]" value="${name}"> <!-- Thêm tên sản phẩm -->
                            <button type="button" class="btn btn-danger remove-product">
                                <i class="fa fa-trash"></i> <!-- Icon thùng rác để xóa -->
                            </button>
                        </td>
                    </tr>
                `;

                // Thêm hàng mới vào bảng chi tiết
                document.querySelector('#ChiTietPhieuNhapTable tbody').insertAdjacentHTML('beforeend', newRow);

                // Gắn sự kiện xóa cho nút thùng rác
                attachRemoveProductEvent();

                // Gắn sự kiện cập nhật tổng tiền khi thay đổi số lượng và đơn giá
                addInputChangeEvent();

                updateTongTien(); // Cập nhật tổng tiền ban đầu
            });
        });

        // Hàm cập nhật tổng tiền cho toàn bộ phiếu nhập
        function updateTongTien() {
            var tongTien = 0;
            document.querySelectorAll('#ChiTietPhieuNhapTable tbody tr').forEach(function(row) {
                var quantity = parseInt(row.querySelector('input[name^="soluong"]').value) || 0; // Lấy số lượng
                var price = parseFloat(row.querySelector('input[name^="dongia"]').value) || 0; // Lấy đơn giá
                tongTien += quantity * price; // Tính tổng tiền cho sản phẩm
            });
            document.getElementById('tongtien').value = tongTien; // Cập nhật giá trị tổng tiền cho input ẩn
            document.getElementById('displayTongTien').value = formatVND(tongTien); // Cập nhật hiển thị tổng tiền
            console.log('Tổng tiền:', formatVND(tongTien));
        }

        // Hàm thêm sự kiện cho ô nhập số lượng và đơn giá
        function addInputChangeEvent() {
            document.querySelectorAll('#ChiTietPhieuNhapTable tbody tr .soluong, #ChiTietPhieuNhapTable tbody tr .dongia').forEach(function(input) {
                input.addEventListener('input', function() {
                    updateTongTien(); // Cập nhật tổng tiền khi có sự thay đổi
                });
            });
        }

        // Gắn sự kiện xóa cho nút thùng rác
        function attachRemoveProductEvent() {
            document.querySelectorAll('.remove-product').forEach(function(removeButton) {
                removeButton.addEventListener('click', function() {
                    this.closest('tr').remove();
                    updateTongTien(); // Cập nhật tổng tiền sau khi xóa sản phẩm
                });
            });
        }
    });

    // Hàm định dạng số thành tiền VND (không làm tròn)
    function formatVND(value) {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
    }


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

    #displayTongTien {
        font-size: 1.5rem; /* Kích thước chữ lớn hơn */
        color: #ff0000; /* Màu đỏ nổi bật */
        font-weight: bold; /* Chữ in đậm */
        text-align: left; /* Canh giữa */
        padding: 10px;
        border-radius: 8px;
    }

    /* Các trường sẽ có hiệu ứng mờ khi disabled */
    input:disabled, textarea:disabled, button:disabled{
        background-color: #f5f5f5;
        color: black;
    }

    /* Viền đỏ khi input "Tên Nhà Cung Cấp" không có giá trị */
    #tennhacungcap:invalid {
        border-color: red;
    }

    /* Viền bình thường khi input "Tên Nhà Cung Cấp" có giá trị */
    #tennhacungcap:valid {
        border-color: #ccc; /* Hoặc màu bạn muốn */
    }
</style>