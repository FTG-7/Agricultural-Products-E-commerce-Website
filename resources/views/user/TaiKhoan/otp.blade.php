@extends('user.layout.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Xác nhận OTP</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4 text-center">Xác nhận OTP</h1>

            <form action="{{ route('phone.verify-otp') }}" method="post">
                <div class="row g-5">

                    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">

                        @csrf
                        <div class="form-item">
                            <label class="form-label my-3">Nhập OTP<sup>*</sup></label>
                            <input type="text" class="form-control" id="otp_code" name="otp_code">
                            </br>
                            @if ($errors->has('otp_code'))
                                <span class="text-danger">{{ $errors->first('otp_code') }}</span>
                            @endif
                        </div>

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
