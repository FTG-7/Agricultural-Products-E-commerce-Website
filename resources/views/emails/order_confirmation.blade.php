<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đơn Hàng</title>
</head>
<body>
    <h2>Chào {{ $name }},</h2>
    <p>Cảm ơn bạn đã đặt hàng tại SunFresh. Dưới đây là thông tin đơn hàng của bạn:</p>

    <h3>Thông tin đơn hàng:</h3>
    <ul>
        <li><strong>Họ tên:</strong> {{ $name }}</li>
        <li><strong>Địa chỉ giao hàng:</strong> {{ $orderData['diachigiao'] }}</li>
        <li><strong>Số điện thoại:</strong> {{ $orderData['sdt'] }}</li>
        <li><strong>Phương thức thanh toán:</strong> {{ $orderData['pttt'] }}</li>
        <li><strong>Tổng tiền:</strong> {{ number_format($orderData['totalBill'] + $orderData['shippingCost'], 0, ',', '.') }} VND</li>
    </ul>

    <h3>Chi tiết sản phẩm:</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng</th>
        </tr>
        @foreach ($orderData['cartItems'] as $item)
        <tr>
            <td>{{ $item->sanpham->tensp }}</td>
            <td>{{ $item->soluong }}</td>
            <td>{{ number_format($item->dongia, 0, ',', '.') }} VND</td>
            <td>{{ number_format($item->itemTotal, 0, ',', '.') }} VND</td>
        </tr>
        @endforeach
    </table>

    <p>Trân trọng,<br>SunFresh</p>
</body>
</html>
