<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
    <div class="container py-5">
        <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
            <div class="row g-4">
                <div class="col-lg-3">
                    <a href="#">
                        <h1 class="text-primary mb-0">SunFresh</h1>
                        <p class="text-secondary mb-0">Nông sản sạch</p>
                    </a>
                </div>
                <div class="col-lg-6">
                </div>
                <div class="col-lg-3">
                    <div class="d-flex justify-content-end pt-3">
                        <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Chúng tôi là ?</h4>
                    <p class="mb-4">SunFresh là trang web bán thực phẩm bao gồm rau, củ, quả, trái cây, thịt, cá và
                        thủy sản, trang web giúp cho
                        người dùng có thể dễ dàng mua thực phẩm chỉ bằng việc lên trang web và chọn mua.</p>
                    <a href="{{ route('user.ds_SanPham.AboutUs') }}" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Xem thêm</a>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Loại sản phẩm</h4>
                    @foreach ($LoaiSP as $type)
                        <a href="{{ route('user.ds_SanPham.show_product', $type->idloai) }}"
                            class="btn-link">{{ $type->tenloai }}</a>
                    @endforeach
                </div>
            </div> --}}
            <div class="col-lg-4 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Liên hệ</h4>
                    <p>Địa chỉ: 140 Đ. Lê Trọng Tấn, Tây Thạnh, Tân Phú, Thành phố Hồ Chí Minh</p>
                    <p>Email: info@huit.edu.vn</p>
                    <p>Phone: 0283 8163 318</p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                {{-- <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Liên kết</h4>
                    <a class="btn-link" href="{{ route('index') }}">Trang chủ</a>
                    <a class="btn-link" href="{{ route('user.ds_SanPham.show_product') }}">Sản phẩm</a>
                    <a class="btn-link" href="{{ route('user.ds_SanPham.AboutUs') }}">Giới thiệu</a>
                </div> --}}
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0672790781086!2d106.62609067451758!3d10.806159158645636!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752be27d8b4f4d%3A0x92dcba2950430867!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBUaMawxqFuZyBUUC4gSOG7kyBDaMOtIE1pbmggKEhVSVQp!5e0!3m2!1svi!2s!4v1733747358792!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <span class="text-light"><a href="{{ route('index') }}"><i class="fas fa-copyright text-light me-2"></i>SunFresh</a></span>
            </div>
            <div class="col-md-6 my-auto text-center text-md-end text-white">
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->



<!-- Back to Top -->
<a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
        class="fa fa-arrow-up"></i></a>
