<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChiTietDonHang;
use App\Models\SanPham;
use App\Models\loaisp;
use App\Models\DonHang;
use App\Models\DoiTra;
use App\Exports\SanPhamThongKeExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ThongKeController extends Controller
{
    public function tinhTongTienDonHang()
    {
        // Lấy ngày hôm nay
        $today = now()->startOfDay(); // Hoặc dùng Carbon::today() nếu có sử dụng Carbon
        $endOfDay = now()->endOfDay(); // Lấy thời điểm kết thúc trong ngày hôm nay

        // Sử dụng model DonHang để lấy tổng số tiền từ cột 'tongtien' cho đơn hàng trong ngày hôm nay
        $tongTien = DonHang::whereBetween('ngaydat', [$today, $endOfDay])
            ->where('trangthai', 'giao thành công')
            ->sum('tongtien');

        return $tongTien;
    }

    public function demTongLuotMuaHang()
    {
        // Đếm tổng số đơn hàng
        $tongLuotMuaHang = DonHang::count();

        // Trả về tổng lượt mua hàng
        return $tongLuotMuaHang;
    }

    public function thongKeSanPhamBan()
    {
        // Lấy tổng số lượng sản phẩm đã bán
        $dataSanPham = ChiTietDonHang::selectRaw('idsp, SUM(soluong) as total_sold')
            ->groupBy('idsp')
            ->with('sanPham')  // Giả sử có quan hệ đến bảng sản phẩm
            ->get();

        return view('admin.ThongKe.sanPhamBan', compact('dataSanPham'));
    }

    public function tinhTongDoanhThuTheoThang($nam)
    {
        $doanhThuTheoThang = [];

        for ($thang = 1; $thang <= 12; $thang++) {
            $tongDoanhThu = DonHang::whereYear('ngaydat', $nam)
                ->whereMonth('ngaydat', $thang)
                ->sum('tongtien');

            // Lưu tổng doanh thu vào mảng với khóa là tháng
            $doanhThuTheoThang[$thang] = $tongDoanhThu;
        }

        return $doanhThuTheoThang;
    }

    public function tinhTongTienDoiTra()
    {
        return DB::table('doitra')->sum('hoantien');
    }

    public function exportSanPhamThongKe()
    {

        $sanPhamThongKe = DB::table('sanpham as sp')
            ->join('chitietdonhang as ctdh', 'sp.idsp', '=', 'ctdh.idsp')
            ->join('chitietphieunhap as ctpn', 'sp.idsp', '=', 'ctpn.idsp')
            ->selectRaw('
                sp.tensp AS ten_san_pham,
                SUM(ctdh.soluong) AS so_luong_ban,
                SUM(ctdh.soluong * ctdh.gia) AS doanh_thu,
                SUM(ctpn.soluong) AS so_luong_nhap,
                SUM(ctpn.soluong * ctpn.dongia) AS chi_phi_nhap,
                SUM((ctdh.soluong * ctdh.gia)-(ctpn.soluong * ctpn.dongia)) AS loi_nhuan
            ')
            ->groupBy('sp.tensp')
            ->orderBy('doanh_thu', 'desc')
            ->get();

        return Excel::download(new SanPhamThongKeExport($sanPhamThongKe), 'sanphamthongke.xlsx');
    }
    public function index(Request $request)
    {
        $action = $request->input('action'); // Lấy giá trị của 'action'

        if ($action === 'export') {
            return $this->exportSanPhamThongKe();
        } else {
            $action = $request->input('action'); // Lấy giá trị của 'action'


            $nam = $request->input('year', date('Y')); // Mặc định là năm hiện tại nếu không có giá trị
            $quy = $request->input('Quy');

            $tongTien = $this->tinhTongTienDonHang();
            $tongLuotMuaHang = $this->demTongLuotMuaHang();
            $tongTienDoiTra = $this->tinhTongTienDoiTra();

            // Lấy tổng doanh thu cho từng tháng trong năm đã chọn
            $doanhThuTheoThang = $this->tinhTongDoanhThuTheoThang($nam);

            // Chuyển đổi mảng doanh thu thành định dạng phù hợp cho biểu đồ
            $thang = array_keys($doanhThuTheoThang);
            $tongDoanhThu = array_values($doanhThuTheoThang);

            $ngaybd = Carbon::today()->startOfDay(); // Ngày bắt đầu: 00:00:00 hôm nay
            $ngaykt = Carbon::today()->endOfDay();   // Ngày kết thúc: 23:59:59 hôm nay

            $dataSanPham = ChiTietDonHang::selectRaw('
            sanpham.tensp, 
            SUM(chitietdonhang.soluong) as total_sold')  // Tổng số lượng sản phẩm đã bán
                ->join('sanpham', 'sanpham.idsp', '=', 'chitietdonhang.idsp')  // Kết nối với bảng sanpham
                ->join('donhang', 'donhang.iddh', '=', 'chitietdonhang.iddh')  // Kết nối với bảng donhang
                ->whereBetween('donhang.ngaydat', [$ngaybd . ' 00:00:00', $ngaykt . ' 23:59:59'])  // Ràng buộc theo ngày bắt đầu và kết thúc (ngày hôm nay)
                ->groupBy('sanpham.tensp')  // Nhóm theo tên sản phẩm
                ->orderBy('total_sold', 'desc')  // Sắp xếp theo tổng số lượng bán
                ->get();
            // dd( $dataSanPham);
            $dataSanPhamTonKho = DB::table('sanpham')
                ->select('idsp', 'tensp', 'soluong as inventory_stock')
                ->orderBy('inventory_stock', 'desc')
                ->limit(10)
                ->get();



            // Khởi tạo biến ngày bắt đầu và kết thúc
            $ngaybd = null;
            $ngaykt = null;
            $ngaybdtk = null;
            $ngaykttk = null;
            // Nếu có giá trị quý, xác định khoảng thời gian tương ứng
            if ($quy) {
                switch ($quy) {
                    case '0':
                        $ngaybd = $request->input('ngaybd', now()->format('Y-m-d')); // Ngày bắt đầu
                        $ngaykt = $request->input('ngaykt', now()->format('Y-m-d')); // Ngày kết thúc
                        $ngaybdtk = $request->input('ngaybd', now()->format('Y-m-d')); // Ngày bắt đầu
                        $ngaykttk = $request->input('ngaykt', now()->format('Y-m-d')); // Ngày kết thúc
                        break;
                    case '1':
                        $ngaybd = "$nam-01-01"; // Ngày bắt đầu quý 1
                        $ngaykt = "$nam-03-31"; // Ngày kết thúc quý 1
                        $ngaybdtk = "$nam-01-01"; // Ngày bắt đầu quý 1
                        $ngaykttk = "$nam-03-31"; // Ngày kết thúc quý 1
                        break;
                    case '2':
                        $ngaybd = "$nam-04-01"; // Ngày bắt đầu quý 2
                        $ngaykt = "$nam-06-30"; // Ngày kết thúc quý 2
                        $ngaybdtk = "$nam-04-01"; // Ngày bắt đầu quý 2
                        $ngaykttk = "$nam-06-30"; // Ngày kết thúc quý 2
                        break;
                    case '3':
                        $ngaybd = "$nam-07-01"; // Ngày bắt đầu quý 3
                        $ngaykt = "$nam-09-30"; // Ngày kết thúc quý 3
                        $ngaybdtk = "$nam-07-01"; // Ngày bắt đầu quý 3
                        $ngaykttk = "$nam-09-30"; // Ngày kết thúc quý 3
                        break;
                    case '4':
                        $ngaybd = "$nam-10-01"; // Ngày bắt đầu quý 4
                        $ngaykt = "$nam-12-31"; // Ngày kết thúc quý 4
                        $ngaybdtk = "$nam-10-01"; // Ngày bắt đầu quý 4
                        $ngaykttk = "$nam-12-31"; // Ngày kết thúc quý 4
                        break;
                }
            } else {
                // Nếu không có quý, mặc định là lọc theo ngày
                $ngaybd = $request->input('ngaybd', now()->format('Y-m-d')); // Ngày bắt đầu
                $ngaykt = $request->input('ngaykt', now()->format('Y-m-d')); // Ngày kết thúc
                $ngaybdtk = $request->input('ngaybd', now()->format('Y-m-d')); // Ngày bắt đầu
                $ngaykttk = $request->input('ngaykt', now()->format('Y-m-d')); // Ngày kết thúc
            }

            // dd($ngaybd); dd($ngaykt);
            // Lấy doanh thu từng sản phẩm trong khoảng thời gian
            $doanhThuSanPham = ChiTietDonHang::selectRaw(' sanpham.tensp, SUM(chitietdonhang.soluong * chitietdonhang.gia) as total_revenue')
                ->join('sanpham', 'sanpham.idsp', '=', 'chitietdonhang.idsp')
                ->join('donhang', 'donhang.iddh', '=', 'chitietdonhang.iddh') // Giả sử chitietdonhang có khóa ngoại là donhang_id
                // ->join('chitietphieunhap as ctpn', 'sanpham.idsp', '=', 'ctpn.idsp')
                // ->join('phieunhap as pn', 'ctpn.idpn', '=', 'pn.idpn')
                ->where('donhang.trangthai', 'Giao thành công')
                ->whereBetween('donhang.ngaydat', [$ngaybd . ' 00:00:00', $ngaykt . ' 23:59:59'])
                ->groupBy('sanpham.tensp')
                ->orderBy('total_revenue', 'desc')
                ->get();

            // Tính doanh thu từ bảng chitietdonhang
            $doanhThuQuery = DB::table('chitietdonhang as ctdh')
                ->join('donhang as dh', 'ctdh.iddh', '=', 'dh.iddh')
                ->where('dh.trangthai', 'Giao thành công')
                ->whereBetween('dh.ngaydat', [$ngaybdtk . ' 00:00:00', $ngaykttk . ' 23:59:59'])
                ->selectRaw('
                    ctdh.idsp, 
                    SUM(ctdh.soluong * ctdh.gia) AS doanh_thu,
                    SUM(ctdh.soluong) AS so_luong_ban
                ')
                ->groupBy('ctdh.idsp');

            // Tính chi phí nhập từ bảng chitietphieunhap
            $chiPhiNhapQuery = DB::table('chitietphieunhap as ctpn')
                ->join('phieunhap as pn', 'ctpn.idpn', '=', 'pn.idpn')
                ->selectRaw('
                    ctpn.idsp,
                    SUM(ctpn.soluong * ctpn.dongia) AS chi_phi_nhap,
                    SUM(ctpn.soluong) AS so_luong_nhap
                ')
                ->whereBetween('pn.ngaylap', [$ngaybdtk . ' 00:00:00', $ngaykttk . ' 23:59:59'])
                ->groupBy('ctpn.idsp');

            // Truy vấn chính để lấy các thông tin của sản phẩm và kết quả từ doanh thu, chi phí nhập
            $sanPhamThongKe = DB::table('sanpham as sp')
                ->leftJoinSub($doanhThuQuery, 'doanhthu', function ($join) {
                    $join->on('sp.idsp', '=', 'doanhthu.idsp');
                })
                ->leftJoinSub($chiPhiNhapQuery, 'chiphinhap', function ($join) {
                    $join->on('sp.idsp', '=', 'chiphinhap.idsp');
                })
                ->selectRaw('
                    sp.tensp AS ten_san_pham,
          
                    COALESCE(doanhthu.doanh_thu, 0) AS doanh_thu,
                    COALESCE(chiphinhap.chi_phi_nhap, 0) AS chi_phi_nhap,
                    COALESCE(chiphinhap.so_luong_nhap, 0) AS so_luong_nhap,
                    COALESCE(doanhthu.so_luong_ban, 0) AS so_luong_ban,
                    SUM(ctdh.soluong * ctdh.gia) - SUM(ctdh.soluong * COALESCE(ctpn.dongia, 0)) AS loi_nhuan
                ')
                ->join('chitietdonhang as ctdh', 'sp.idsp', '=', 'ctdh.idsp')
                ->leftJoin('chitietphieunhap as ctpn', 'sp.idsp', '=', 'ctpn.idsp') // join với chitietphieunhap để lấy giá nhập
                ->join('donhang as dh', 'ctdh.iddh', '=', 'dh.iddh')
                ->where('dh.trangthai', 'Giao thành công')
                ->whereBetween('dh.ngaydat', [$ngaybdtk . ' 00:00:00', $ngaykttk . ' 23:59:59'])
                ->groupBy('sp.idsp')
                ->orderBy('doanh_thu', 'desc')
                ->paginate(10);



            // Truyền dữ liệu đến view
            return view('admin.ThongKe.index', compact('tongTien', 'tongLuotMuaHang', 'tongDoanhThu', 'thang', 'dataSanPham', 'dataSanPhamTonKho', 'nam', 'doanhThuSanPham', 'ngaybd', 'ngaykt', 'tongTienDoiTra', 'sanPhamThongKe'));
        }
    }
}
