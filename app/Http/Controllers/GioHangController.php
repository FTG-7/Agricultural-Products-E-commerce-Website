<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Token;
use App\Models\Diachi;
use App\Models\GioHang;
use App\Models\SanPham;
use App\Models\admin\KhuyenMai;
use App\Models\ChiTietKhuyenMai;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class GioHangController extends Controller
{
    //
    public function detailaddToCart(Request $request, $idsp)
    {
        // Kiểm tra xem có giá trị 'quantity' trong request không, nếu không có thì gán giá trị mặc định là 1
        $quantity = $request->input('quantity', 1);
    
        if (Auth::check()) {
            $idtk = Auth::id(); // Lấy id người dùng đã đăng nhập
            $gioHang = GioHang::where('idsp', $idsp)->where('idtk', $idtk)->first();
    
            if ($gioHang) {
                // Tăng số lượng nếu sản phẩm đã có trong giỏ
                $gioHang->soluong += $quantity;
                $gioHang->save();
            } else {
                // Thêm sản phẩm mới vào giỏ hàng
                $sanpham = SanPham::findOrFail($idsp);
                GioHang::create([
                    'idtk' => $idtk,
                    'idsp' => $idsp,
                    'soluong' => $quantity,
                    'dongia' => $sanpham->gia,
                ]);
            }
    
            return redirect()->back();
        }
    
        return redirect()->route('login');
    }
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request, $idsp)
    {
        if (Auth::check()) {
            $idtk = Auth::id(); // Lấy id người dùng đã đăng nhập
            $gioHang = GioHang::where('idsp', $idsp)->where('idtk', $idtk)->first();

            if ($gioHang) {
                // Tăng số lượng nếu sản phẩm đã có trong giỏ
                $gioHang->soluong += 1;
                $gioHang->save();
            } else {
                // Thêm sản phẩm mới vào giỏ hàng
                $sanpham = SanPham::findOrFail($idsp);
                GioHang::create([
                    'idtk' => $idtk,
                    'idsp' => $idsp,
                    'soluong' => 1,
                    'dongia' => $sanpham->gia,
                ]);
            }

            return redirect()->back();
        }

        return redirect()->route('login');
    }

    public function addToCartMN(Request $request, $idsp, $quantity)
    {
        if (Auth::check()) {
            $idtk = Auth::id(); // Lấy ID của người dùng đã đăng nhập
    
            $gioHang = GioHang::where('idsp', $idsp)->where('idtk', $idtk)->first();
    
            if ($gioHang) {
                // Tăng số lượng nếu sản phẩm đã có trong giỏ
                $gioHang->soluong += $quantity;
                $gioHang->save();
            } else {
                // Thêm sản phẩm mới vào giỏ hàng
                $sanpham = SanPham::findOrFail($idsp);
                GioHang::create([
                    'idtk' => $idtk,
                    'idsp' => $idsp,
                    'soluong' => $quantity,
                    'dongia' => $sanpham->gia,
                ]);
            }
    
            return redirect()->route('cart.index');
        }
    
        return redirect()->route('login');
    }


    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteFromCart($idgh)
    {
        $gioHang = GioHang::findOrFail($idgh);
        $gioHang->delete();

        return redirect()->route('cart.index');
    }

    // Xóa tất cả sản phẩm khỏi giỏ hàng
    public function clearCart()
    {
        $idtk = Auth::id();
        GioHang::where('idtk', $idtk)->delete();

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được làm trống');
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart(Request $request, $idgh)
    {
        $gioHang = GioHang::findOrFail($idgh);
        $gioHang->soluong = $request->input('qty');
        $gioHang->save();

        return redirect()->route('cart.index');
    }

    // Hiển thị giỏ hàng
    public function index()
    {
        $idtk = Auth::id();
        $cartItems = GioHang::with('sanpham.Anh')->where('idtk', $idtk)->get();
    
        // Duyệt qua các sản phẩm trong giỏ hàng
        foreach ($cartItems as $gioHang) {
            // Lấy chi tiết khuyến mãi của sản phẩm
            $chiTietKhuyenMai = ChiTietKhuyenMai::where('idsp', $gioHang->idsp)->first();
    
            // Khởi tạo biến cho các thông tin giảm giá và tăng hàng
            $gioHang->setDiscountAmountAttribute(0); // Mặc định không có giảm giá
            $gioHang->setIncreasedProductNameAttribute(null); // Mặc định không có sản phẩm tăng
            $gioHang->setPromoNameAttribute(null); // Mặc định không có tên khuyến mãi
            $gioHang->setPromoContentAttribute(null); // Mặc định không có nội dung khuyến mãi
            $gioHang->setPromoConditionAttribute(null); // Mặc định không có điều kiện khuyến mãi
    
            if ($chiTietKhuyenMai) {
                // Lấy thông tin khuyến mãi
                $khuyenMai = KhuyenMai::find($chiTietKhuyenMai->idkm);
    
                if ($khuyenMai && $khuyenMai->trangthai == 1) {  // Kiểm tra trạng thái khuyến mãi là 1 (hoạt động)
                    // Kiểm tra loại khuyến mãi
                    if ($khuyenMai->loaikm === 'giamtien') {
                        // Lưu số giảm vào biến
                        $gioHang->setDiscountAmountAttribute($khuyenMai->noidungkm); // Số tiền giảm
                    } elseif ($khuyenMai->loaikm === 'giamthanhtien') {
                        // Lưu thông tin khuyến mãi: tên khuyến mãi, nội dung khuyến mãi, và điều kiện khuyến mãi
                        $gioHang->setPromoNameAttribute($khuyenMai->tenkm); // Tên khuyến mãi
                        $gioHang->setPromoContentAttribute($khuyenMai->noidungkm); // Nội dung khuyến mãi
                        $gioHang->setPromoConditionAttribute($khuyenMai->dieukien); // Điều kiện khuyến mãi
                    }
                } else {
                    // Nếu khuyến mãi hết hạn hoặc không có khuyến mãi
                    $gioHang->setDiscountAmountAttribute(0);
                    $gioHang->setIncreasedProductNameAttribute(null);
                    $gioHang->setPromoNameAttribute(null);
                    $gioHang->setPromoContentAttribute(null);
                    $gioHang->setPromoConditionAttribute(null);
                }
            } else {
                // Nếu không có khuyến mãi cho sản phẩm
                $gioHang->setDiscountAmountAttribute(0);
                $gioHang->setIncreasedProductNameAttribute(null);
                $gioHang->setPromoNameAttribute(null);
                $gioHang->setPromoContentAttribute(null);
                $gioHang->setPromoConditionAttribute(null);
            }
        }
    
        return view('user.MuaHang.cart', compact('cartItems'));
    }
    
}
