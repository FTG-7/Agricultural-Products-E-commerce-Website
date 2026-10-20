@extends('user.layout.master')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Thông báo</h1>
    </div>
    <!-- Single Page Header End -->


    <!-- 404 Start -->
    <div class="container-fluid py-5">
        <div class="container py-5 text-center">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1 class="mb-4">
                        @if (isset($message))
                            {{ $message }}
                        @endif
                        @if (isset($error))
                            {{ $error }}
                        @endif

                        @if (session('error'))
                            {{ session('error') }}
                        @endif
                        @if (session('message'))
                            {{ session('message') }}
                        @endif
                    </h1>
                    <a class="btn border-secondary rounded-pill py-3 px-5" href="{{ route('index') }}">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 404 End -->
@endsection
