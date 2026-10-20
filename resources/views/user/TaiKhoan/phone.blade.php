@extends('user.layout.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Cập nhật số điện thoại</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4 text-center">Cập nhật số điện thoại</h1>

            <form action="{{ route('phone.send-otp') }}" method="post">
                <div class="row g-5">

                    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">

                        @csrf
                        <div class="form-item">
                            <label class="form-label my-3">Nhập số điện thoại<sup>*</sup></label>
                            <input type="text" class="form-control" id="sdt" name="sdt"
                                value="{{ old('sdt') }}">
                            </br>
                            @if ($errors->has('sdt'))
                                <span class="text-danger">{{ $errors->first('sdt') }}</span>
                            @endif
                        </div>

                        <div class="row g-4 text-center align-items-center justify-contenrt-center pt-4">
                            <button type="submit"
                                class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Nhận OTP</button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
