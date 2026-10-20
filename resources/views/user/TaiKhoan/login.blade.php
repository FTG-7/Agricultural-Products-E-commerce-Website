@extends('user.layout.master')
<style>
    .texttc {
        font-weight: 800;
        font-size: 16px;
        color: dodgerblue;
    }
    .password-container {
        position: relative;
    }
    .toggle-password {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 1.2rem;
        color: #888;
    }
</style>
@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Đăng nhập</h1>
    </div>
    <!-- Single Page Header End -->

    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <form action="{{ route('login') }}" method="post">
                <div class="row g-5">
                    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
                        @csrf
                        <div class="form-item">
                            <label class="form-label my-3">Nhập Email<sup>*</sup></label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Mật khẩu<sup>*</sup></label>
                            <div class="password-container">
                                <input type="password" class="form-control" id="password" name="password">
                                <i class="fa fa-eye-slash toggle-password" onclick="togglePassword()"></i>
                            </div>
                            @if (session('message'))
                                <span class="texttc">{{ session('message') }}</span>
                            @endif
                            @if (session('error'))
                                <span class="text-danger">{{ session('error') }}</span>
                            @endif
                            <br>
                            <a href="{{ route('show-forgot-password') }}">Quên mật khẩu</a> |
                            <a href="{{ route('show-register') }}">Đăng ký</a><br>
                            <a href="{{ route('show_resend-activation-email') }}">Kích hoạt lại tài khoản</a>
                        </div>

                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                            <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">
                                Đăng nhập
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Nội dung khác của trang đăng nhập -->
    @if(session('error'))
    <script>
        swal("Thông báo", "{{ session('error') }}", "error");
    </script>
    @endif

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
@endsection
