<p>Chào {{ $name }},</p> <!-- Chào tên người dùng -->
@if ($quyen == 'nv')
    <p>Mật khẩu nhân viên của bạn là: <b>{{ $password }}</b></p>
    <p>Hãy click vào đường nút dưới đây để tiến hành kích hoạt tài khoản.</p>
    <p>Hãy đổi mật khẩu sau khi đăng nhập đề đảm bảo an toàn</p>
    <a href="{{ route('activate-account', $token) }}">Kích hoạt tài khoản</a>
@else
    <p>Cảm ơn bạn đã đăng ký tài khoản tại website SunFresh của chúng tôi.Vui lòng click vào link dưới đây trong vòng 60
        phút để kích hoạt tài khoản của bạn:</p>
    <a href="{{ route('activate-account', $token) }}">Kích hoạt tài khoản</a>
    <p>Nếu bạn không đăng ký tài khoản này, hãy bỏ qua email này.</p>
@endif
