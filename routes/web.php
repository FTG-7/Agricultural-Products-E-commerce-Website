<?php

use App\Http\Controllers\Admin\KhuyenMaiController;
use App\Http\Controllers\Admin\ThongKeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\SanPhamController;
use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\User\QLDonHangKHController;
use App\Http\Controllers\Admin\QLDonHangController;
use App\Http\Controllers\Admin\QLDoiTraController;
use App\Http\Controllers\DoiTraController;
// use App\Http\Controllers\BinhLuanController;

use App\Http\Controllers\User\BinhLuanController;
// use App\Models\Admin\KhuyenMai;
use App\Http\Controllers\QLPhieuNhapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware(['ktrahethan'])->group(function () {
    Route::get('/', [SanPhamController::class, 'index']);

    Route::get('notify', [TaiKhoanController::class, 'notify'])->name('notify');

    Route::get('index', [SanPhamController::class, 'index'])->name('index');

    Route::get('adminindex', function () {
        return view('admin.index');
    })->name('adminindex')->middleware('role:nv,admin');


    Route::get('login', [TaiKhoanController::class, 'showlogin'])->name('show-login');
    Route::post('login', [TaiKhoanController::class, 'login'])->name('login');

    Route::get('register', [TaiKhoanController::class, 'showregister'])->name('show-register');
    Route::post('register', [TaiKhoanController::class, 'register'])->name('register');

    Route::get('logout', [TaiKhoanController::class, 'logout'])->name('logout')->middleware('role:kh,nv,admin');

    Route::get('profile', [TaiKhoanController::class, 'showprofile'])->name('show-profile')->middleware('role:kh,nv,admin');
    Route::post('profile', [TaiKhoanController::class, 'profile'])->name('profile')->middleware('role:kh,nv,admin');

    Route::get('changepassword', [TaiKhoanController::class, 'showchangepassword'])->name('show_changepassword')->middleware('role:kh,nv,admin');
    Route::post('changepassword', [TaiKhoanController::class, 'changepassword'])->name('changepassword')->middleware('role:kh,nv,admin');

    Route::get('/activate/{token}', [TaiKhoanController::class, 'activateAccount'])->name('activate-account');

    Route::get('resend-activation', [TaiKhoanController::class, 'showresendActivationEmail'])->name('show_resend-activation-email');
    Route::post('resend-activation', [TaiKhoanController::class, 'resendActivationEmail'])->name('resend-activation-email');

    Route::get('forgot-password', [TaiKhoanController::class, 'showForgotPasswordForm'])->name('show-forgot-password');
    Route::post('forgot-password', [TaiKhoanController::class, 'sendResetPasswordEmail'])->name('send-reset-password-email');
    Route::get('reset-password/{token}', [TaiKhoanController::class, 'showResetPasswordForm'])->name('show-reset-password-form');
    Route::post('reset-password', [TaiKhoanController::class, 'resetPassword'])->name('reset-password');


    Route::get('/address', [TaiKhoanController::class, 'indexaddress'])->name('address.index')->middleware('role:kh');
    Route::post('/address', [TaiKhoanController::class, 'storeaddress'])->name('address.store')->middleware('role:kh');
    Route::delete('/address/{iddc}', [TaiKhoanController::class, 'destroyaddress'])->name('address.destroy')->middleware('role:kh');
    Route::put('/address/{iddc}/set-default', [TaiKhoanController::class, 'setDefaultaddress'])->name('address.setDefault')->middleware('role:kh');


    Route::prefix('cart')->middleware('role:kh')->group(function () {
        Route::get('/', [GioHangController::class, 'index'])->name('cart.index');
        Route::get('/add/{idsp}', [GioHangController::class, 'addToCart'])->name('cart.add');
        Route::post('/detailadd/{idsp}', [GioHangController::class, 'detailaddToCart'])->name('cart.adddetail');
        Route::post('/update/{idgh}', [GioHangController::class, 'updateCart'])->name('cart.update');
        Route::get('/delete/{idgh}', [GioHangController::class, 'deleteFromCart'])->name('cart.delete');
        Route::get('/clear', [GioHangController::class, 'clearCart'])->name('cart.clear');
        Route::get('/addmn/{idsp}/{quantity}', [GioHangController::class, 'addToCartMN'])->name('cart.addmn');
    });

    Route::prefix('order')->middleware('role:kh')->group(function () {
        Route::get('/create', [ThanhToanController::class, 'create'])->name('order.create');
        Route::post('/confirm', [ThanhToanController::class, 'confirm'])->name('order.confirm');
        Route::get('/review', [ThanhToanController::class, 'review'])->name('order.review');
        Route::post('/store', [ThanhToanController::class, 'store'])->name('order.store');
        Route::get('/store_online', [ThanhToanController::class, 'store_online'])->name('order.store_online');
        Route::get('/success', [ThanhToanController::class, 'success'])->name('order.success');
        Route::get('/{iddh}/buy-again', [QLDonHangKHController::class, 'buyAgain'])->name('order.buyAgain');
        Route::post('/vnpay_payment', [ThanhToanController::class, 'vnpay_payment'])->name('order.vnpay_payment');
    });

    Route::prefix('mail')->middleware('role:admin,nv,kh')->group(function () {
        Route::get('mail-change', [TaiKhoanController::class, 'showMailChange'])->name('show-mail-change');
        Route::post('mail-change', [TaiKhoanController::class, 'requestEmailChange'])->name('request-email-change');
        Route::get('/confirm-old-email/{token}', [TaiKhoanController::class, 'confirmOldEmail'])->name('confirm-old-email');
        Route::get('/confirm-new-email/{token}', [TaiKhoanController::class, 'confirmNewEmail'])->name('confirm-new-email');
    });

    //Đơn Hàng của Khách Hàng (Lịch Sử Mua Hàng)
    Route::get('showdonhang', [QLDonHangKHController::class, 'index'])->name('MuaHang.showdonhang')->middleware('role:kh');
    Route::post('CancelOrder/{iddh}', [QLDonHangKHController::class, 'CancelOrder'])->name('MuaHang.CancelOrder')->middleware('role:kh');
    Route::get('ShowOrderDetail/{iddh}', [QLDonHangKHController::class, 'ShowOrderDetail'])->name('MuaHang.ShowOrderDetail')->middleware('role:kh');

    Route::prefix('phone')->middleware('role:kh')->group(function () {
        Route::get('/', [TaiKhoanController::class, 'showPhone'])->name('phone.show-phone');
        Route::post('/send-otp', [TaiKhoanController::class, 'sendOtp'])->name('phone.send-otp');
        Route::get('/otp-form', [TaiKhoanController::class, 'showOtpForm'])->name('phone.show-otp-form');
        Route::post('/verify-otp', [TaiKhoanController::class, 'verifyOtp'])->name('phone.verify-otp');
    });

    Route::prefix('doitra')->middleware('role:kh')->group(function () {
        Route::get('/create/{iddh}', [DoiTraController::class, 'create'])->name('doitra.create');
        Route::post('/store', [DoiTraController::class, 'store'])->name('doitra.store');
        Route::get('/list', [DoiTraController::class, 'index'])->name('doitra.index');
    });



    // Route::get('show_product', [SanPhamController::class, 'show_product'])->name('user.ds_SanPham.show_product');

    // Route::get('show_product_by_category/{idloai}', [SanPhamController::class, 'show_product_by_category'])->name('user.ds_SanPham.show_product_by_category');

    Route::get('detail_product/{idsp}', [SanPhamController::class, 'getSanPhamById'])->name('user.ds_SanPham.detail_product');

    // Route::get('search_product', [SanPhamController::class, 'searchProduct'])->name('user.ds_SanPham.search_product');

    // Route::get('search_price_product', [SanPhamController::class, 'searchByPriceRange'])->name('sanpham.search_price');
    Route::get('show_product/{idloai?}', [SanPhamController::class, 'show_product'])->name('user.ds_SanPham.show_product');
    Route::get('about_us', [SanPhamController::class, 'aboutus'])->name('user.ds_SanPham.AboutUs');






    // Binh Luận
    // Route::post('detail_product/{idsp}', [BinhLuanController::class, 'store'])->name('user.ds_SanPham.detail_product');
    Route::post('store/{idsp}', [BinhLuanController::class, 'store'])->name('binhluan.store')->middleware('role:admin,nv,kh');

    // Khuyến Mãi

    Route::prefix('admin')->group(function () {
        Route::prefix('KhuyenMai')->middleware('role:admin')->group(function () {
            // Route::get('khuyenMai',[KhuyenMaiController::class,'show_khuyenMai'])->name('admin.KhuyenMai');

            Route::get('index', [KhuyenMaiController::class, 'index'])->name('admin.KhuyenMai.index');

            Route::get('create', [KhuyenMaiController::class, 'create'])->name('admin.KhuyenMai.create');

            Route::post('store', [KhuyenMaiController::class, 'store'])->name('admin.KhuyenMai.store');

            Route::get('edit/{id}', [KhuyenMaiController::class, 'edit'])->name('admin.KhuyenMai.edit');

            Route::put('update/{id}', [KhuyenMaiController::class, 'update'])->name('admin.KhuyenMai.update');

            Route::delete('delete/{id}', [KhuyenMaiController::class, 'delete'])->name('admin.KhuyenMai.delete');

            Route::get('insertChiTietKhuyenMai/{idkm}/{idsp}', [KhuyenMaiController::class, 'insertChiTietKhuyenMai'])->name('admin.KhuyenMai.insertChiTietKhuyenMai');

            Route::delete('chitietkhuyenmai/{idkm}/{idsp}', [KhuyenMaiController::class, 'deleteChiTietKhuyenMai'])->name('admin.KhuyenMai.deleteChiTietKhuyenMai');
        });

        Route::prefix('SanPham')->middleware('role:admin')->group(function () {

            // Route::get('khuyenMai',[SanPhamController::class,'show_khuyenMai'])->name('admin.KhuyenMai');

            Route::get('admin_index', [SanPhamController::class, 'admin_index'])->name('admin.SanPham.admin_index');

            Route::get('create', [SanPhamController::class, 'create'])->name('admin.SanPham.create');

            Route::post('store', [SanPhamController::class, 'store'])->name('admin.SanPham.store');

            Route::get('edit/{id}', [SanPhamController::class, 'edit'])->name('admin.SanPham.edit');

            Route::post('update/{id}', [SanPhamController::class, 'update'])->name('admin.SanPham.update');

            Route::get('quantity_index', [SanPhamController::class, 'quantity_index'])->name('admin.SanPham.quantity_index');
            Route::post('quantity_update', [SanPhamController::class, 'quantity_update'])->name('admin.SanPham.quantity_update');
            Route::get('quantity_reset/{id}', [SanPhamController::class, 'resetQuantity'])->name('admin.SanPham.reset_quantity');
        });

        Route::get('sphh_index', [SanPhamController::class, 'sphh_index'])->name('admin.SanPham.sphh_index')->middleware('role:admin,nv');


        Route::prefix('PhieuNhap')->middleware('role:admin')->group(function () {
            Route::get('show', [QLPhieuNhapController::class, 'show_phieunhap'])->name('admin.PhieuNhap.show');
            Route::get('delete/{id}', [QLPhieuNhapController::class, 'destroy'])->name('admin.PhieuNhap.delete');
            Route::post('create', [QLPhieuNhapController::class, 'create'])->name('admin.PhieuNhap.create');
            Route::get('edit/{id}', [QLPhieuNhapController::class, 'edit'])->name('admin.PhieuNhap.edit');
            Route::put('update/{id}', [QLPhieuNhapController::class, 'update'])->name('admin.PhieuNhap.update');
            Route::post('confirm/{id}', [QLPhieuNhapController::class, 'confirm'])->name('admin.PhieuNhap.confirm');
            Route::get('info/{id}', [QLPhieuNhapController::class, 'info'])->name('admin.PhieuNhap.info');
        });

        Route::prefix('KhachHang')->middleware('role:admin')->group(function () {
            Route::get('index', [TaiKhoanController::class, 'show_CustomerAndLockedCustomer'])->name('admin.KhachHang.index');

            Route::get('lock/{id}', [TaiKhoanController::class, 'lock_Customer'])->name('admin.KhachHang.lock');

            Route::get('unlock/{id}', [TaiKhoanController::class, 'unlock_Customer'])->name('admin.KhachHang.unlock');
        });

        Route::prefix('NhanVien')->middleware('role:admin')->group(function () {
            Route::get('index', [TaiKhoanController::class, 'show_StaffAndLockedStaff'])->name('admin.NhanVien.index');

            Route::get('lock/{id}', [TaiKhoanController::class, 'lock_Staff'])->name('admin.NhanVien.lock');

            Route::get('unlock/{id}', [TaiKhoanController::class, 'unlock_Staff'])->name('admin.NhanVien.unlock');

            //Route::post('add', [TaiKhoanController::class, 'add_Staff'])->name('admin.NhanVien.add');
        });

        Route::prefix('Admin')->middleware('role:admin')->group(function () {
            Route::get('index', [TaiKhoanController::class, 'show_AdminAndStaff'])->name('admin.Admin.index');

            Route::get('grant/{id}', [TaiKhoanController::class, 'grant_Admin'])->name('admin.Admin.grant');

            Route::get('revoke/{id}', [TaiKhoanController::class, 'revoke_Admin'])->name('admin.Admin.revoke');

            // Route::post('add', [TaiKhoanController::class, 'add_Staff'])->name('admin.NhanVien.add');
        });

        Route::prefix('QLDonHang')->group(function () {

            Route::get('index', [QLDonHangController::class, 'index'])->name('admin.QLDonHang.index')->middleware('role:admin');

            Route::get('chuyenTrangThai/{id}/{trangThai}', [QLDonHangController::class, 'chuyenTrangThai'])->name('admin.QLDonHang.chuyenTrangThai')->middleware('role:admin,nv,kh');

            Route::get('chiTiet/{id}', [QLDonHangController::class, 'chiTiet'])->name('admin.QLDonHang.chiTiet')->middleware('role:admin,nv');
        });

        Route::prefix('QLDoiTra')->group(function () {

            Route::get('index', [QLDoiTraController::class, 'index'])->name('admin.QLDoiTra.index')->middleware('role:admin');

            Route::get('chuyenTrangThai/{id}/{trangThai}', [QLDoiTraController::class, 'chuyenTrangThai'])->name('admin.QLDoiTra.chuyenTrangThai')->middleware('role:admin,nv');

            Route::get('chiTiet/{id}', [QLDoiTraController::class, 'chiTiet'])->name('admin.QLDoiTra.chiTiet')->middleware('role:admin,nv');
        });
        Route::prefix('ThongKe')->middleware('role:admin')->group(function () {

            // Route::get('khuyenMai',[SanPhamController::class,'show_khuyenMai'])->name('admin.KhuyenMai');

            // Route::get('index', [ThongKeController::class, 'index'])->name('admin.ThongKe.index')->middleware('role:admin');
            Route::get('index', [ThongKeController::class, 'index'])->name('admin.ThongKe.index');
            // Route::get('create',[SanPhamController::class,'create'])->name('admin.SanPham.create');
            Route::get('/export-sanphamthongke', [ThongKeController::class, 'exportSanPhamThongKe'])->name('export.sanphamthongke');

            // Route::post('store',[SanPhamController::class,'store'])->name('admin.SanPham.store');

            // Route::get('edit/{id}',[SanPhamController::class,'edit'])->name('admin.SanPham.edit');

            // Route::post('update/{id}',[SanPhamController::class,'update'])->name('admin.SanPham.update');

        });
    });

    Route::prefix('nv')->middleware('role:nv')->group(function () {
        Route::prefix('QLDonHang')->group(function () {

            Route::get('index', [QLDonHangController::class, 'shipindex'])->name('nv.QLDonHang.shipindex');

            Route::get('chuyenTrangThai/{id}/{trangThai}', [QLDonHangController::class, 'chuyenTrangThai'])->name('nv.QLDonHang.chuyenTrangThai');
        });

        Route::prefix('QLDoiTra')->group(function () {

            Route::get('index', [QLDoiTraController::class, 'shipindex'])->name('nv.QLDoiTra.shipindex');

            Route::get('chuyenTrangThai/{id}/{trangThai}', [QLDoiTraController::class, 'chuyenTrangThai'])->name('nv.QLDoiTra.chuyenTrangThai');
        });
    });

    // // Phiếu nhập
    // Route::get('show_phieunhap', [QLPhieuNhapController::class, 'show_phieunhap'])->name('admin.ds_PhieuNhap.show_phieunhap');
    // Route::post('create_phieunhap', [QLPhieuNhapController::class, 'create'])->name('admin.ds_PhieuNhap.create');
    // Route::get('delete_phieunhap/{id}', [QLPhieuNhapController::class, 'destroy'])->name('admin.ds_PhieuNhap.delete');

    // Route::get('edit_phieunhap/{id}', [QLPhieuNhapController::class, 'edit'])->name('admin.ds_PhieuNhap.edit');
    // Route::post('save_phieunhap/{id}', [QLPhieuNhapController::class, 'update'])->name('admin.ds_PhieuNhap.update');

});
