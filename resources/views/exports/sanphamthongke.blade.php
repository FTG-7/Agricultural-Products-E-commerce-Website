<table>
    <thead>
        <tr>
            <th>Tên Sản Phẩm</th>
            <th>Số Lượng Bán</th>
            <th>Số Lượng Nhập</th>
            <th>Doanh Thu</th>
          
            <th>Chi Phí Nhập</th>
            <th>Lợi Nhuận</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sanPhamThongKe as $sanPham)
            <tr>
                <td>{{ $sanPham->ten_san_pham }}</td>
                <td>{{ $sanPham->so_luong_ban }}</td>
                <td>{{ $sanPham->so_luong_nhap }}</td>
                <td>{{ $sanPham->doanh_thu }}</td>
              
                <td>{{ $sanPham->chi_phi_nhap }}</td>
                <td>{{ $sanPham->loi_nhuan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
