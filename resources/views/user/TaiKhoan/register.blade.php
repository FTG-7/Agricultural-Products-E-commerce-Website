@extends('user.layout.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Đăng ký</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4 text-center">Đăng ký</h1>
            {{-- @if (count($errors))
                @dd($errors)
            @endif --}}
            <form action="{{ route('register') }}" method="post">
                <div class="row g-5">
                    @csrf
                    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
                        @csrf
                        <div class="form-item">
                            <label class="form-label my-3">Họ và tên<sup>*</sup></label>
                            <input type="text" class="form-control" id="hoten" name="hoten"
                                value="{{ old('hoten') }}">
                            @if ($errors->has('hoten'))
                                <span class="text-danger">{{ $errors->first('hoten') }}</span>
                            @endif
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Email<sup>*</sup></label>
                            <input type="text" class="form-control" id="email" name="email"
                                value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Giới tính <sup>*</sup></label>
                            <select class="form-control" id="gioitinh" name="gioitinh">
                                <option value="">Chọn giới tính</option>
                                <option value="Nam" {{ old('gioitinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ old('gioitinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            </select>
                            @if ($errors->has('gioitinh'))
                                <span class="text-danger">{{ $errors->first('gioitinh') }}</span>
                            @endif
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Ngày sinh<sup>*</sup></label>
                            <input type="date" class="form-control" id="ngaysinh" name="ngaysinh"
                                value="{{ old('ngaysinh') }}">
                            @if ($errors->has('ngaysinh'))
                                <span class="text-danger">{{ $errors->first('ngaysinh') }}</span>
                            @endif
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Số điện thoại<sup>*</sup></label>
                            <input type="text" class="form-control" id="sdt" name="sdt" value="{{ old('sdt') }}">
                            @if ($errors->has('sdt'))
                                <span class="text-danger">{{ $errors->first('sdt') }}</span>
                            @endif
                        </div>
                        
                        <div class="form-item">
                            <label class="form-label my-3">Mật khẩu<sup>*</sup></label>
                            <input type="password" class="form-control" id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Nhập lại mật khẩu<sup>*</sup></label>
                            <input type="password" class="form-control" id="passcf" name="passcf">
                            @if ($errors->has('passcf'))
                                <span class="text-danger">{{ $errors->first('passcf') }}</span>
                            @endif
                        </div>

                        <input type="hidden" name="dsden" value="0">
                        <input type="hidden" name="quyen" value="kh">

                        <div class="row g-4 text-center align-items-center justify-contenrt-center pt-4">
                            <button type="submit"
                                class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Đăng ký</button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- Checkout Page End -->
@endsection
