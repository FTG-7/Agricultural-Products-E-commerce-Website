@extends('user.layout.master')

@section('content')


<!-- Hero Header Start -->
<div class="container-fluid py-5 mb-5 hero-header" style="background-image: url('{{ asset('imgsystem/posterAboutUs.jpg') }}'); background-size: cover; background-position: center;">
    <div class="overlay"></div> <!-- Lớp overlay để làm tối nền -->
    <div class="row justify-content-center text-center position-relative">
        <div class="col-lg-8">
            <h1 class="display-4 text-white mb-3">Chào Mừng Đến Với Sunfresh</h1>
            <p class="lead text-white mb-4">Nông Sản Sạch Cho Cuộc Sống Lành Mạnh, Tươi Ngon và An Toàn</p>
            <a href="{{ route('user.ds_SanPham.show_product') }}" class="btn btn-custom btn-lg">Khám Phá Sản Phẩm</a>
        </div>
    </div>
</div>
<!-- Hero Header End -->



<!-- Giới Thiệu Sunfresh Start -->
<section class="container py-5" style="background-color: #f8f9fa;">
    <div class="row text-center">
        <div class="col-12">
            <h2 class="display-4 text-success mb-4">Giới Thiệu Về Sunfresh</h2>
            <p class="lead mb-4">Sunfresh là thương hiệu chuyên cung cấp nông sản sạch, hữu cơ, không hóa chất, cam kết mang đến những sản phẩm tươi ngon, an toàn và bổ dưỡng cho sức khỏe. Với mỗi sản phẩm, chúng tôi mong muốn bảo vệ sức khỏe gia đình bạn và bảo vệ môi trường thiên nhiên. Chúng tôi tự hào là cầu nối giữa người tiêu dùng và nông dân, giúp xây dựng một cộng đồng tiêu dùng thông minh và bền vững.</p>
            <p class="mb-4">Tại Sunfresh, chúng tôi tin rằng mỗi quyết định về thực phẩm là một hành động góp phần bảo vệ sức khỏe và tương lai của chính chúng ta. Mỗi sản phẩm của chúng tôi đều được chăm sóc tỉ mỉ, đảm bảo sự an toàn tối đa cho khách hàng, không sử dụng hóa chất hay các sản phẩm gây hại cho sức khỏe.</p>
        </div>
    </div>
</section>
<!-- Giới Thiệu Sunfresh End -->

<!-- Sứ Mệnh và Tầm Nhìn Start -->
<section class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <h3 class="text-success mb-4">Sứ Mệnh</h3>
            <p>Sunfresh cam kết cung cấp thực phẩm sạch, an toàn và giàu dinh dưỡng cho cộng đồng. Chúng tôi mong muốn trở thành một phần không thể thiếu trong bữa ăn mỗi gia đình, giúp bạn và gia đình có một lối sống lành mạnh và bền vững. Sứ mệnh của chúng tôi là thúc đẩy nền nông nghiệp sạch, hữu cơ tại Việt Nam và bảo vệ sức khỏe người tiêu dùng. Chúng tôi không chỉ cung cấp nông sản sạch mà còn thúc đẩy mô hình sản xuất bền vững, bảo vệ môi trường và giảm thiểu tác động xấu đến trái đất.</p>
        </div>
        <div class="col-md-6 mb-4">
            <h3 class="text-success mb-4">Tầm Nhìn</h3>
            <p>Trở thành thương hiệu hàng đầu tại Việt Nam trong cung cấp các sản phẩm nông sản sạch, hữu cơ, đồng thời nâng cao nhận thức cộng đồng về tầm quan trọng của việc sử dụng thực phẩm sạch. Chúng tôi mong muốn xây dựng một cộng đồng tiêu dùng thông minh và bảo vệ sức khỏe cho thế hệ tương lai. Mục tiêu dài hạn của Sunfresh là hướng tới việc mở rộng ra các thị trường quốc tế, mang sản phẩm Việt Nam đến gần hơn với người tiêu dùng trên toàn cầu.</p>
        </div>
    </div>
</section>
<!-- Sứ Mệnh và Tầm Nhìn End -->

<!-- Lợi Ích Của Việc Ăn Nông Sản Sạch Start -->
<section class="container py-5" style="background-color: #e9f9f4;">
    <div class="row text-center">
        <div class="col-12">
            <h2 class="display-4 text-success mb-4">Lợi Ích Của Việc Ăn Nông Sản Sạch</h2>
            <p class="lead mb-4">Ăn nông sản sạch không chỉ giúp bạn có được sức khỏe tốt mà còn giúp bảo vệ môi trường. Dưới đây là một số lợi ích khi tiêu thụ các sản phẩm nông sản sạch:</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-heart text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title text-success mt-3">Tăng Cường Sức Khỏe</h5>
                    <p class="card-text">Nông sản sạch giàu vitamin và khoáng chất tự nhiên, giúp cơ thể khỏe mạnh, tăng cường sức đề kháng và phòng ngừa bệnh tật.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-leaf text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title text-success mt-3">Bảo Vệ Môi Trường</h5>
                    <p class="card-text">Nông sản sạch được sản xuất theo phương pháp hữu cơ, không sử dụng hóa chất hay thuốc trừ sâu, góp phần bảo vệ đất đai, nguồn nước và hệ sinh thái.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-handshake text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title text-success mt-3">Hỗ Trợ Nông Dân</h5>
                    <p class="card-text">Khi mua nông sản sạch từ Sunfresh, bạn không chỉ chăm sóc sức khỏe gia đình mình mà còn giúp đỡ những nông dân Việt Nam sản xuất theo phương pháp bền vững.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Lợi Ích Của Việc Ăn Nông Sản Sạch End -->

<!-- Chứng Nhận Chất Lượng Start -->
<section class="container py-5">
    <div class="row text-center">
        <div class="col-12">
            <h2 class="display-4 text-success mb-4">Chứng Nhận Chất Lượng</h2>
            <p class="lead mb-4">Sunfresh cam kết đảm bảo chất lượng sản phẩm với các chứng nhận hữu cơ và an toàn thực phẩm từ các tổ chức uy tín. Chúng tôi đảm bảo rằng mọi sản phẩm của mình đều đạt các tiêu chuẩn chất lượng quốc tế và luôn an toàn cho người tiêu dùng.</p>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <img src="{{ asset('imgsystem/chungnhanhuuco.png') }}" class="img-fluid" alt="Chứng nhận hữu cơ">
                </div>
                <div class="col-md-4 mb-4">
                    <img src="{{ asset('imgsystem/antoanthucpham.png') }}" class="img-fluid" alt="Chứng nhận an toàn thực phẩm">
                </div>
                <div class="col-md-4 mb-4">
                    <img src="{{ asset('imgsystem/chungnhannongsansach.jpg') }}" class="img-fluid" alt="Chứng nhận nông sản sạch">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Chứng Nhận Chất Lượng End -->

<!-- Hướng Dẫn Mua Hàng Start -->
<section class="container py-5" style="background-color: #f8f9fa;">
    <div class="row text-center">
        <div class="col-12">
            <h2 class="display-4 text-success mb-4">Hướng Dẫn Mua Hàng</h2>
            <p class="lead mb-4">Mua sắm tại Sunfresh vô cùng đơn giản! Hãy làm theo các bước dưới đây để có thể nhận được những sản phẩm nông sản sạch, tươi ngon từ chúng tôi:</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-search text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title text-success mt-3">Bước 1: Khám Phá Sản Phẩm</h5>
                    <p class="card-text">Truy cập website và chọn các sản phẩm nông sản sạch mà bạn yêu thích.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-cart-plus text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title text-success mt-3">Bước 2: Thêm Vào Giỏ Hàng</h5>
                    <p class="card-text">Thêm các sản phẩm vào giỏ hàng và tiếp tục thanh toán khi đã chọn xong.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-truck text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title text-success mt-3">Bước 3: Nhận Hàng</h5>
                    <p class="card-text">Chúng tôi giao hàng tận nơi nhanh chóng, giúp bạn nhận được thực phẩm sạch trong thời gian ngắn nhất.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hướng Dẫn Mua Hàng End -->

<!-- Thông Tin Liên Hệ Start -->
<section class="container py-5 text-center">
    <h2 class="display-4 text-success mb-4">Thông Tin Liên Hệ</h2>
    <p class="lead">Website: www.sunfresh.vn</p>
    <p class="lead">Điện thoại: 0987 654 321</p>
    <p class="lead">Email: info@sunfresh.vn</p>
    <p class="lead">Địa chỉ: 123 Đường Nông Sản, TP. Hồ Chí Minh</p>
</section>
<!-- Thông Tin Liên Hệ End -->

<style>
    .hero-header {
        position: relative;
        background-size: cover;
        background-position: center;
    }

    /* Overlay giúp làm tối nền ảnh mà không làm tối chữ */
    .hero-header .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4); /* Độ tối của lớp overlay */
    }

    /* Điều chỉnh text để nổi bật */
    .hero-header .text-white {
        position: relative;
        z-index: 1; /* Đảm bảo chữ luôn nằm trên overlay */
    }

    /* Custom button style */
    .btn-custom {
        background-color: white; /* Màu nền nút trắng */
        color: black; /* Màu chữ nút đen */
    }

    .btn-custom:hover {
        background-color: #f8f9fa; /* Màu nền khi hover (di chuột lên) */
        color: black; /* Đảm bảo chữ vẫn đen khi hover */
        border-color: black; /* Đảm bảo viền vẫn đen khi hover */
    }
    
    /* Điều chỉnh kích thước hình ảnh trong section Chứng Nhận Chất Lượng */
    section .row img {
        max-width: 100%;   /* Hình ảnh không vượt quá chiều rộng của thẻ chứa */
        height: auto;      /* Đảm bảo hình ảnh giữ tỷ lệ khi thay đổi kích thước */
        object-fit: contain; /* Giữ nguyên tỷ lệ hình ảnh, không bị cắt bớt */
        max-height: 150px; /* Điều chỉnh chiều cao tối đa cho các hình ảnh */
        margin: 0 auto;    /* Căn giữa hình ảnh */
    }

    /* Điều chỉnh chiều cao cố định cho các card */
    .card {
        height: 250px; /* Chiều cao cố định cho các card */
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Đảm bảo nội dung trong card được căn chỉnh đều */
        text-align: center;
    }
    

    /* Cải thiện hình ảnh và các icon bên trong card */
    .card i {
        font-size: 3rem; /* Giữ icon lớn và cân đối */
        color: #28a745; /* Màu sắc cho icon */
    }

    /* Đảm bảo chiều cao của các card là bằng nhau */
    .card-body {
        flex-grow: 1;
    }

    /* Thêm một chút padding để nội dung trong các card không bị dính vào mép */
    .card-body {
        padding: 20px;
    }

    /* Điều chỉnh cách hiển thị nội dung trong card */
    .card-title {
        font-size: 1.5rem;
        margin-top: 15px;
    }

    .card-text {
        font-size: 1rem;
    }
</style>
@endsection
