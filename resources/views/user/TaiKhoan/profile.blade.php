@extends('user.layout.master')

@Section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Thông tin tài khoản</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4 text-center">Thông tin tài khoản</h1>
            {{-- @if (count($errors))
            @dd($errors)
        @endif --}}
            <form action="{{ route('profile') }}" method="post">
                <div class="row g-5">

                    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
                        @csrf
                        <div class="form-item">
                            <label class="form-label my-3">Họ và tên<sup>*</sup></label>
                            <input type="text" class="form-control" id="hoten" name="hoten"
                                value="{{ old('hoten', $user->hoten) }}">
                            @if ($errors->has('hoten'))
                                <span class="text-danger">{{ $errors->first('hoten') }}</span>
                            @endif
                        </div>
                        {{-- <div class="form-item">
                            <label class="form-label my-3">Email<sup>*</sup></label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div> --}}
                        <div class="form-item">
                            <label class="form-label my-3">Giới tính <sup>*</sup></label>
                            <select class="form-control" id="gioitinh" name="gioitinh">
                                <option value="Nam" {{ old('gioitinh', $user->gioitinh) == 'Nam' ? 'selected' : '' }}>Nam
                                </option>
                                <option value="Nữ" {{ old('gioitinh', $user->gioitinh) == 'Nữ' ? 'selected' : '' }}>Nữ
                                </option>
                            </select>
                            @if ($errors->has('gioitinh'))
                                <span class="text-danger">{{ $errors->first('gioitinh') }}</span>
                            @endif
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Ngày sinh<sup>*</sup></label>
                            <input type="date" class="form-control" id="ngaysinh" name="ngaysinh"
                                value="{{ old('ngaysinh', date('Y-m-d', strtotime($user->ngaysinh))) }}">
                            @if ($errors->has('ngaysinh'))
                                <span class="text-danger">{{ $errors->first('ngaysinh') }}</span>
                            @endif
                        </div>

                        <div class="form-item">
                            <label class="form-label my-3">Số điện thoại<sup></sup></label>
                            <input type="text" class="form-control" id="sdt" name="sdt" value="{{ old('sdt', $user->sdt) }}">
                            @if ($errors->has('sdt'))
                                <span class="text-danger">{{ $errors->first('sdt') }}</span>
                            @endif
                        </div>

                        <div class="form-item">
                            <label class="form-label my-3">Email<sup></sup></label>
                            <input type="text" style="color: #81c408; background-color: white;" class="form-control" value="{{ old('sdt', $user->email) }}" disabled>
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
                            {{-- <input type="hidden" name="sdt" value="0">
                        <input type="hidden" name="dsden" value="0">
                        <input type="hidden" name="quyen" value="kh"> --}}

                            <div class="row g-4 text-center align-items-center justify-contenrt-center pt-4">
                                <button type="submit"
                                    class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Cập nhật thông
                                    tin</button>
                            </div>

                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <div class="col-md-4">
                                    <a href="{{ route('address.index') }}" class="btn border-secondary py-3 px-4 text-uppercase w-100">Quản lý địa chỉ</a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('show_changepassword') }}" class="btn border-secondary py-3 px-4 text-uppercase w-100">Đổi mật khẩu</a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('show-mail-change') }}" class="btn border-secondary py-3 px-4 text-uppercase w-100">Cập nhật email</a>
                                </div>
                            </div>
                            

                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
