<div class="modal fade" id="addNhanVienModal" tabindex="-1" aria-labelledby="addNhanVienModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNhanVienModalLabel">Thêm Nhân Viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <!-- Trường thông tin nhân viên -->
                    <div class="mb-3">
                        <label for="hoten" class="form-label">Họ và Tên</label>
                        <input type="text" class="form-control" name="hoten" id="hoten"
                            value="{{ old('hoten') }}" required>
                        @if ($errors->has('hoten'))
                            <span class="text-danger">{{ $errors->first('hoten') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="gioitinh" class="form-label">Giới Tính</label>
                        <select class="form-select" name="gioitinh" id="gioitinh" required>
                            <option value="" {{ old('gioitinh') == '' ? 'selected' : '' }}>Chọn giới tính</option>
                            <option value="Nam" {{ old('gioitinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gioitinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        </select>
                        @if ($errors->has('gioitinh'))
                            <span class="text-danger">{{ $errors->first('gioitinh') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="ngaysinh" class="form-label">Ngày Sinh</label>
                        <input type="date" class="form-control" name="ngaysinh" id="ngaysinh"
                            value="{{ old('ngaysinh') }}" required>
                        @if ($errors->has('ngaysinh'))
                            <span class="text-danger">{{ $errors->first('ngaysinh') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="sdt" class="form-label">Số Điện Thoại</label>
                        <input type="text" class="form-control" name="sdt" id="sdt"
                            value="{{ old('sdt') }}" required>
                        @if ($errors->has('sdt'))
                            <span class="text-danger">{{ $errors->first('sdt') }}</span>
                        @endif
                    </div>
                    {{-- <div class="mb-3 position-relative">
                        <label for="password" class="form-label">Mật Khẩu</label>
                        <input type="password" class="form-control pe-5" name="password" id="password" required>
                        <span class="position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('password', 'togglePasswordIcon1')" style="cursor: pointer;">
                            <i id="togglePasswordIcon1" class="fa fa-eye-slash"></i>
                        </span>
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    
                    <div class="mb-3 position-relative">
                        <label for="passcf" class="form-label">Xác Nhận Mật Khẩu</label>
                        <input type="password" class="form-control pe-5" name="passcf" id="passcf" required>
                        <span class="position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('passcf', 'togglePasswordIcon2')">
                            <i id="togglePasswordIcon2" class="fa fa-eye-slash" style="cursor: pointer;"></i>
                        </span>
                        @if ($errors->has('passcf'))
                            <span class="text-danger">{{ $errors->first('passcf') }}</span>
                        @endif
                    </div> --}}

                    <!-- Thêm trường quyền mặc định là nv -->
                    <input type="hidden" name="quyen" value="nv">
                    <input type="hidden" name="dsden" value="0">

                    <button type="submit" class="btn btn-primary">Thêm Nhân Viên</button>
                    <button type="reset" class="btn btn-danger">Làm Mới</button>
                </form>
            </div>
        </div>
    </div>
</div>



{{-- <script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script> --}}