@extends('user.layout.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Đặt lại mật khẩu</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4 text-center">Đặt lại mật khẩu</h1>

            <form action="{{ route('reset-password') }}" method="post">
                <div class="row g-5">
                    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
                        @csrf
                        <div class="form-item">
                            <div class="form-item">
                                <label class="form-label my-3">Mật khẩu mới<sup>*</sup></label>
                                <input type="password" class="form-control" id="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Nhập lại mật khẩu mới<sup>*</sup></label>
                                <input type="password" class="form-control" id="passcf" name="passcf">
                                @if ($errors->has('passcf'))
                                    <span class="text-danger">{{ $errors->first('passcf') }}</span>
                                @endif
                            </div>
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                        </div>

                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="row g-4 text-center align-items-center justify-contenrt-center pt-4">
                            <button type="submit"
                                class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Xác nhận</button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

