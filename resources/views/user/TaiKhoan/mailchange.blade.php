@extends('user.layout.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Cập nhật gmail</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4 text-center">Cập nhật Mail</h1>

            <form action="{{ route('request-email-change') }}" method="post">
                <div class="row g-5">

                    <div class="col-md-12 col-lg-10 col-xl-8 mx-auto">

                        @csrf
                        <div class="form-item">
                            <label class="form-label my-3">Nhập gmail mới<sup>*</sup></label>
                            <input type="text" class="form-control" id="email" name="email"
                                value="{{ old('email') }}">
                            </br>
                            @if ($errors->has('email'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif

                            </br>
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
