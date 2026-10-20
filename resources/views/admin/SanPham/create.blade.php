@extends('admin.layout.master')

@Section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3"><a href="{{route('admin.SanPham.admin_index')}}">Sản Phẩm</a></h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Thêm sản phẩm</a>
                    </li>

                </ul>
            </div>
            <div class="row">

                <form action="{{ route('admin.SanPham.store') }}" method="post" enctype="multipart/form-data">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Thêm sản phẩm</h4>
                                    <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                        data-bs-target="#addRowModal" id="addProductBtn">
                                        <i class="fa fa-plus"></i>
                                        Thêm sản phẩm
                                    </button>
                                </div>
                            </div>


                            <div class="table-responsive" style="margin-top: 25px">

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label>Tên sản phẩm</label>
                                        <input type="text" name="ten" class="form-control"
                                            value="{{ old('ten') }}">
                                        @error('ten')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label>Giá sản phẩm</label>
                                        <input type="text" name="gia" class="form-control"
                                            value="{{ old('gia') }}">
                                        @error('gia')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label>Đơn vị tính</label>
                                        <input type="text" name="dvt" class="form-control"
                                            value="{{ old('dvt') }}">
                                        @error('dvt')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label>Xuất xứ</label>
                                        <input type="text" name="xuatxu" class="form-control"
                                            value="{{ old('xuatxu') }}">
                                        @error('xuatxu')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="handoitra">Hạn đổi trả:</label>
                                        <input type="number" class="form-control" name="handoitra"
                                            value="{{ old('handoitra') }}" required>
                                        @error('handoitra')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label>Hình ảnh</label>
                                        <input type="file" name="hinh[]" id="imageInput" multiple class="form-control">
                                        <span id="imageError" class="text-danger"></span>
                                        @error('hinh')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Loại sản phẩm</label>
                                    <div class="row">
                                        @foreach ($LoaiSP as $type)
                                            <div class="col-md-6">
                                                <input type="checkbox" name="idloai[]" value="{{ $type->idloai }}"
                                                    @if (in_array($type->idloai, old('idloai', []))) checked @endif>
                                                <label>{{ $type->tenloai }}</label>
                                            </div>
                                        @endforeach
                                        @error('idloai')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea name="mota" class="form-control">{{ old('mota') }}</textarea>
                                    @error('mota')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                </form>

            </div>
        </div>
    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("addProductBtn").addEventListener("click", function(event) {
                const files = document.getElementById("imageInput").files;
                const maxSize = 2 * 1024 * 1024; // 2MB
                let hasLargeImages = false;
                let errorMessage = "";

                // Xóa thông báo lỗi cũ
                document.getElementById("imageError").innerHTML = "";

                for (const file of files) {
                    if (file.size > maxSize) {
                        hasLargeImages = true;
                        errorMessage +=
                            `Ảnh "${file.name}" vượt quá 2MB (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                    }
                }

                if (hasLargeImages) {
                    // Ngăn không cho gửi form
                    event.preventDefault();
                    // Hiển thị thông báo lỗi trong window.alert
                    alert(errorMessage); // Hiển thị cảnh báo
                    document.getElementById("imageError").innerHTML =
                        errorMessage; // Hiển thị lỗi trong span
                }
            });
        });
    </script>
@endsection
