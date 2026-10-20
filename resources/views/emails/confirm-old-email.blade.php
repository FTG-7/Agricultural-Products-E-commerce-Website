<p>Xin chào {{ $name }},</p>
<p>Vui lòng click vào đường link bên dưới để hoàn tác và khôi phục email cũ:</p>
<p>
    <a href="{{ route('confirm-old-email', ['token' => $token, 'email' => $oldEmail]) }}">Khôi phục email cũ</a>
</p>
<p>Nếu bạn không có nhu cầu khôi phục email, vui lòng bỏ qua email này.</p>
