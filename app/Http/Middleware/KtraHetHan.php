<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\SanPham;
use App\Models\ChiTietPhieuNhap;
use App\Models\ChiTietDonHang;
use App\Models\SpHetHan;
use App\Models\admin\KhuyenMai;

class KtraHetHan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Lấy ngày hiện tại
        $today = Carbon::today();
        // Kiểm tra xem đã có bản ghi trong bảng `sphethan` với `ngayhh` là hôm nay chưa
        $exists = SpHetHan::whereDate('ngayhh', '<=', $today)->exists();

        // Kiểm tra tất cả các sản phẩm trong hệ thống
        $allProducts = SanPham::all();

        foreach ($allProducts as $product) {
            // Kiểm tra nếu số lượng sản phẩm bằng 0, cập nhật trạng thái thành 0
            if ($product->soluong === 0) {
                $product->update(['trangthai' => 0]);
            } elseif ($product->soluong > 0) {
                $product->update(['trangthai' => 1]);
            }
        }

        // Kiểm tra khuyến mãi đã hết hạn

        $expiredPromos = KhuyenMai::where('ngaykt', '<', $today)->where('trangthai', 1)->get();

        foreach ($expiredPromos as $promo) {
            // Cập nhật trạng thái khuyến mãi hết hạn
            $promo->update(['trangthai' => 0]);
        }
        // Kiểm tra và cập nhật trạng thái khuyến mãi chưa hết hạn (ngày kết thúc lớn hơn ngày hiện tại)
        $activePromos = KhuyenMai::where('ngaykt', '>', $today)->where('trangthai', 0)->get();

        foreach ($activePromos as $promo) {
            // Cập nhật trạng thái khuyến mãi đang còn hiệu lực thành 1 (hoạt động)
            $promo->update(['trangthai' => 1]);
        }
        if ($exists) {
            // Nếu đã tồn tại bản ghi cho ngày hôm nay, bỏ qua middleware
            return $next($request);
        }

        // $expiredProducts = ChiTietPhieuNhap::join('phieunhap', 'chitietphieunhap.idpn', '=', 'phieunhap.idpn')
        //     ->join('sanpham', 'chitietphieunhap.idsp', '=', 'sanpham.idsp')
        //     ->whereRaw('phieunhap.xacnhan = 1 AND DATE(phieunhap.ngaylap) + INTERVAL sanpham.handoitra DAY = ?', [$today])
        //     ->get(['chitietphieunhap.*', 'phieunhap.ngaylap', 'sanpham.handoitra']);

        $expiredProducts = ChiTietPhieuNhap::join('phieunhap', 'chitietphieunhap.idpn', '=', 'phieunhap.idpn')
            ->join('sanpham', 'chitietphieunhap.idsp', '=', 'sanpham.idsp')
            ->whereRaw('DATE(phieunhap.ngaylap) + INTERVAL sanpham.handoitra DAY <= ?', [$today])
            ->get(['chitietphieunhap.*', 'phieunhap.ngaylap', 'sanpham.handoitra']);


        foreach ($expiredProducts as $product) {
            $idsp = $product->idsp;
            $soluongNhap = $product->soluong;



            // Tính tổng số lượng đã bán của sản phẩm trong các đơn hàng
            $soldQuantity = ChiTietDonHang::where('idsp', $idsp)
                // ->whereHas('donHang', function ($query) {
                //     $query->where('trangthai', 'Giao Thành Công');
                // })
                ->sum('soluong');

            // Tính số lượng hết hạn
            $expiredQuantity = max($soluongNhap - $soldQuantity, 0);

            if ($expiredQuantity > 0) {
                // Trừ số lượng sản phẩm hết hạn trong bảng `sanpham`
                // SanPham::where('idsp', $idsp)->decrement('soluong', $expiredQuantity);
                //Tính ngày hết hạn
                $ngayhh = \Carbon\Carbon::parse($product->ngaylap)->addDays($product->handoitra);
                // Lưu thông tin sản phẩm hết hạn
                SpHetHan::create([
                    'idsp' => $idsp,
                    'soluong' => $expiredQuantity,
                    'ngayhh' => $ngayhh,
                ]);
            }
        }

        return $next($request);
    }
}
