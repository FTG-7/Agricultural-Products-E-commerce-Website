<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\ChiTietDonHang;
use Illuminate\Support\Facades\Auth;


class QLDonHangKHController extends Controller
{
    public function index()
    {
        // Lấy thông tin người dùng từ session
        $userss = session('user');
        
        if ($userss) {
            // Lấy ID của người dùng
            $idtk = $userss->idtk;

            // Lấy tất cả đơn hàng của khách hàng theo idtk
            $donHangs = DonHang::where('idtk', $idtk)->orderBy('iddh', 'desc')->get();


            // Trả về danh sách đơn hàng
            return view('user.MuaHang.showdonhang', compact('donHangs'));
        }

        // Nếu không có thông tin người dùng, chuyển hướng đến trang đăng nhập
        return redirect()->route('show-login')->with('error', 'Bạn cần phải đăng nhập.');
    }


    public function CancelOrder($iddh)
    {
        // Tìm đơn hàng theo ID
        $donHang = DonHang::find($iddh);

        // Kiểm tra xem đơn hàng có tồn tại và có trạng thái là 'Chờ xác nhận'
        if (!$donHang || $donHang->trangthai !== 'Chờ xác nhận') {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại hoặc không thể hủy.');
        }

        // Cập nhật trạng thái của đơn hàng thành 'Đơn hủy'
        $donHang->trangthai = 'Đơn hủy';
        $donHang->save();

        // Cập nhật lại số lượng sản phẩm
        foreach ($donHang->chiTietDonHang as $chiTiet) {
            $sanPham = $chiTiet->sanPham;
            if ($sanPham) {
                $sanPham->soluong += $chiTiet->soluong; // Cộng lại số lượng sản phẩm
                $sanPham->save();
            }
        }

        // Gửi thông báo thành công về trang danh sách đơn hàng
        return redirect()->route('MuaHang.showdonhang')->with('success', 'Đơn hàng đã được hủy thành công.');
    }

    public function ShowOrderDetail($iddh)
    {
        // Lấy thông tin đơn hàng
        $donHang = DonHang::find($iddh);

        // Lấy chi tiết đơn hàng theo iddh và kèm theo ảnh sản phẩm
        $chiTietDonHang = ChiTietDonHang::with('sanPham.anh')  // Load ảnh sản phẩm từ quan hệ 'anh' trong model SanPham
            ->where('iddh', $iddh)
            ->get();

        // Trả về view hiển thị chi tiết đơn hàng kèm thông tin đơn hàng
        return view('user.MuaHang.orderdetail', compact('donHang', 'chiTietDonHang'));
    }

    public function buyAgain($iddh)
    {
        $order = DonHang::with('chiTietDonHang')->find($iddh);

        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }

        if (Auth::check()) {
            $idtk = Auth::id(); // Lấy ID người dùng hiện tại

            // Duyệt qua từng sản phẩm trong đơn hàng
            foreach ($order->chiTietDonHang as $orderDetail) {
                $gioHang = GioHang::where('idsp', $orderDetail->idsp)
                    ->where('idtk', $idtk)
                    ->first();

                if ($gioHang) {
                    // Tăng số lượng nếu sản phẩm đã có trong giỏ
                    $gioHang->soluong += $orderDetail->soluong;
                    $gioHang->save();
                } else {
                    // Thêm sản phẩm mới vào giỏ hàng
                    GioHang::create([
                        'idtk' => $idtk,
                        'idsp' => $orderDetail->idsp,
                        'soluong' => $orderDetail->soluong,
                        'dongia' => $orderDetail->sanPham->gia,
                    ]);
                }
            }

            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
        }

        return redirect()->route('login');
    }

}



