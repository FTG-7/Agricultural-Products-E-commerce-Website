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
                        <a href="#">Chỉnh sửa sản phẩm</a>
                    </li>
                    <!-- <li class="separator">
                                                <i class="icon-arrow-right"></i>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#">Datatables</a>
                                            </li> -->
                </ul>
            </div>
            <div class="row">


                <form action="{{ route('admin.SanPham.update', $product->idsp) }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Chỉnh Sửa Sản Phẩm</h4>
                                    <button class="btn btn-primary btn-round ms-auto" type="submit" id="addProductBtn">
                                        <i class="fa fa-plus"></i>
                                        Cập Nhật
                                    </button>
                                </div>
                            </div>


                            <div class="table-responsive" style="margin-top: 25px">

                                @csrf
                                @method('POST')

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="tensp">Tên sản phẩm:</label>
                                        <input type="text" class="form-control" name="tensp"
                                            value="{{ old('tensp', $product->tensp) }}" required>
                                        @error('tensp')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="handoitra">Hạn đổi trả:</label>
                                        <input type="number" class="form-control" name="handoitra"
                                            value="{{ old('handoitra', $product->handoitra) }}" required>
                                        @error('handoitra')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="gia">Giá:</label>
                                        <input type="number" class="form-control" name="gia"
                                            value="{{ old('gia', $product->gia) }}" required>
                                        @error('gia')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="donvitinh">Đơn vị tính:</label>
                                        <input type="text" class="form-control" name="donvitinh"
                                            value="{{ old('donvitinh', $product->donvitinh) }}" required>
                                        @error('donvitinh')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="xuatxu">Xuất xứ:</label>
                                        <input type="text" class="form-control" name="xuatxu"
                                            value="{{ old('xuatxu', $product->xuatxu) }}" required>
                                        @error('xuatxu')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- <div class="col-md-6">
                                        <label for="soluong">Số lượng:</label> --}}
                                        <input type="hidden" class="form-control" name="soluong"
                                            value="{{ old('soluong', $product->soluong) }}" required>
                                        {{-- @error('soluong')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="mota">Mô tả:</label>
                                        <textarea class="form-control" name="mota" required>{{ old('mota', $product->mota) }}</textarea>
                                        @error('mota')
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
                                                    {{ $product->loaisp->contains('idloai', $type->idloai) ? 'checked' : '' }}>
                                                <label>{{ $type->tenloai }}</label>
                                            </div>
                                        @endforeach
                                        @error('idloai')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label for="hinh">Thêm Hình ảnh:</label>
                                    <input type="file" class="form-control" name="hinh[]" id="imageInput" multiple>
                                    <span id="imageError" class="text-danger"></span>
                                    @error('hinh')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Chọn hình ảnh để xóa</label>
                                    <div class="row">
                                        @foreach ($product->Anh as $image)
                                            <div class="col-6 col-sm-3">
                                                <label class="imagecheck mb-4">
                                                    <input name="imagecheck[]" type="checkbox"
                                                        value="{{ $image->idanh }}" class="imagecheck-input" />
                                                    <figure class="imagecheck-figure">
                                                        <img src="{{ asset('imgsp/' . $image->tenanh) }}"
                                                            alt="Product Image" class="imagecheck-image" width="300"
                                                            height="270" />
                                                    </figure>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
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
