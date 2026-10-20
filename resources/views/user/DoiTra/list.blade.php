@extends('user.layout.master')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Danh Sách Đơn Đổi Trả</h1>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4 text-center">Các Đơn Đổi Trả Của Bạn</h2>

                @if($danhSachDoiTra->isEmpty())
                    <p class="text-center">Bạn chưa có đơn đổi trả nào.</p>
                @else
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Đơn Hàng</th>
                                <th>Lý Do</th>
                                <th>Ngày Tạo</th>
                                <th>Trạng Thái</th>
                                <th>Hoàn Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($danhSachDoiTra as $doiTra)
                                <tr>
                                    <td>{{ $doiTra->iddh }}</td>
                                    <td>{{ $doiTra->lydo }}</td>
                                    <td>{{ $doiTra->ngaytao }}</td>
                                    <td>{{ $doiTra->trangthai }}</td>
                                    <td>{{ number_format($doiTra->hoantien, 0, ',', '.') }} VND</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
