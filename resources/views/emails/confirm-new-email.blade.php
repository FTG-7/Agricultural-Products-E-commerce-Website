<p>Xin chào {{ $name }},</p>
<p>Vui lòng click vào đường link bên dưới để xác nhận email mới:</p>
<p>
    <a href="{{ route('confirm-new-email', ['token' => $token, 'email' => $newEmail]) }}">Xác nhận email mới</a>
</p>
<p>Nếu bạn không yêu cầu thay đổi email, vui lòng bỏ qua email này.</p>
