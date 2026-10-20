@extends('user.layout.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Đổi mật khẩu</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4 text-center">Đổi mật khẩu</h1>

            <form action="{{ route('changepassword') }}" method="post">
                <div class="row g-5">

                    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">

                        @csrf
                        <div class="form-item">
                            <label class="form-label my-3">Nhập Email<sup>*</sup></label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Mật khẩu<sup>*</sup></label>
                            <input type="password" class="form-control" id="password" name="password">

                            @if (session('error'))
                                <span class="text-danger">{{ session('error') }}</span>
                            @endif
                            </br>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Nhập mật khẩu mới<sup>*</sup></label>
                            <input type="password" class="form-control" id="newpassword" name="newpassword">
                            @if ($errors->has('newpassword'))
                                <span class="text-danger">{{ $errors->first('newpassword') }}</span>
                            @endif
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Nhập mật lại khẩu mới<sup>*</sup></label>
                            <input type="password" class="form-control" id="cfnewpassword" name="cfnewpassword">
                            @if ($errors->has('newpasscf'))
                                <span class="text-danger">{{ $errors->first('newpasscf') }}</span>
                            @endif
                        </div>
                        <div class="row g-4 text-center align-items-center justify-contenrt-center pt-4">
                            <button type="submit"
                                class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Đổi mật khẩu</button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
