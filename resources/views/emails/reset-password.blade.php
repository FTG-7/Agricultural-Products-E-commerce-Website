<p>Xin chào {{ $name }},</p>
<p>Bạn đã yêu cầu đặt lại mật khẩu. Vui lòng nhấp vào liên kết dưới đây để đặt lại mật khẩu của bạn:</p>
<a href="{{ route('show-reset-password-form', ['token' => $token]) }}">Đặt lại mật khẩu</a>
<p>Liên kết này sẽ hết hạn sau 60 phút.</p>
