<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use Illuminate\Support\Facades\Auth;
use App\Models\DonHang;
use App\Models\User;
use Illuminate\Http\Request;

class QLDonHangController extends Controller
{
    //
    // Hiển thị danh sách đơn hàng
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $field = $request->input('field', 'tennhan'); // Mặc định tìm theo trường 'tennhan'
        $sortField = $request->input('sort_field', 'iddh'); // Trường mặc định để sắp xếp
        $sortOrder = $request->input('sort', 'desc'); // Mặc định sắp xếp tăng dần

        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc'; // Giá trị mặc định
        }

        // Tìm kiếm và sắp xếp cho từng trạng thái
        $choXacNhan = $this->getDonHangByStatus('Chờ xác nhận', $searchTerm, $field, $sortField, $sortOrder);
        $dongGoi = $this->getDonHangByStatus('Đóng gói', $searchTerm, $field, $sortField, $sortOrder);
        $dangGiao = $this->getDonHangByStatus('Đang giao', $searchTerm, $field, $sortField, $sortOrder);
        $giaoThanhCong = $this->getDonHangByStatus('Giao thành công', $searchTerm, $field, $sortField, $sortOrder);
        $giaoThatBai = $this->getDonHangByStatus('Giao thất bại', $searchTerm, $field, $sortField, $sortOrder);
        $donHuy = $this->getDonHangByStatus('Đơn Hủy', $searchTerm, $field, $sortField, $sortOrder);

        $nhanVien = User::where('quyen', 'nv')->where('dsden', 0)->where('trangthai', 1)->get();

        return view('admin.QLDonHang.index', compact('choXacNhan', 'dongGoi', 'dangGiao', 'giaoThanhCong', 'giaoThatBai', 'donHuy', 'nhanVien', 'searchTerm', 'field'));
    }

    // Hàm tìm đơn hàng theo trạng thái và các tham số tìm kiếm
    private function getDonHangByStatus($trangThai, $searchTerm, $field, $sortField, $sortOrder)
    {
        // Danh sách các trường có thể sắp xếp
        $validSortFields = ['iddh', 'ngaydat', 'tennhan', 'sdt', 'tongtien'];

        // Kiểm tra nếu sortField có trong danh sách các trường hợp lệ
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'iddh'; // Giá trị mặc định
        }

        return DonHang::where('trangthai', $trangThai)
            ->when($searchTerm, function ($query) use ($searchTerm, $field) {
                // Kiểm tra xem trường là 'iddh' hay không
                if ($field === 'iddh') {
                    // Tìm kiếm chính xác cho trường 'iddh'
                    return $query->where($field, '=', $searchTerm);
                } else {
                    // Tìm kiếm tương đối cho các trường khác
                    return $query->where($field, 'LIKE', "%{$searchTerm}%");
                }
            })
            ->with('nhanvien')
            ->orderBy($sortField, $sortOrder)
            ->paginate(5);
            //->get();
    }


    public function chuyenTrangThai($id, $trangThai)
    {
        $idnvgh = request('idnvgh'); // Lấy idnhanvien từ yêu cầu

        // Tìm đơn hàng và cập nhật trạng thái
        $donHang = DonHang::find($id);
        if ($donHang) {
            $donHang->trangThai = $trangThai; // Cập nhật trạng thái

            // Nếu trạng thái là "Giao thành công" và phương thức thanh toán là "offline"
            if ($trangThai === 'Giao thành công' && $donHang->pttt === 'offline') {
                $donHang->ttthanhtoan = 1; // Cập nhật trạng thái thanh toán
                $donHang->ngaygiao = now();
            }

            // Chỉ cập nhật idnvgh nếu nó không rỗng
            if (!empty($idnvgh)) {
                $donHang->idnvgh = $idnvgh;
            }

            // Nếu trạng thái là "Đơn hủy" hoặc "Giao thất bại", cập nhật lại số lượng sản phẩm
            if (in_array($trangThai, ['Đơn hủy'])) {
                foreach ($donHang->chiTietDonHang as $chiTiet) {
                    $sanPham = $chiTiet->sanPham;
                    if ($sanPham) {
                        $sanPham->soluong += $chiTiet->soluong; // Cộng lại số lượng sản phẩm
                        $sanPham->save();
                    }
                }
            }

            $donHang->save();
        }

        return redirect()->back()->with('success', 'Đã chuyển trạng thái đơn hàng.');
    }

    public function chiTiet($id)
    {
        // Tìm đơn hàng theo ID
        $donHang = DonHang::with(['chiTietDonHang', 'taiKhoan', 'nhanvien'])->findOrFail($id);

        // Trả về view chi tiết đơn hàng
        return view('admin.QLDonHang.detail', compact('donHang'));
    }

    public function shipindex(Request $request)
    {
        $searchTerm = $request->input('search');
        $field = $request->input('field', 'tennhan'); // Mặc định tìm theo trường 'tennhan'
        $sortField = $request->input('sort_field', 'iddh'); // Trường mặc định để sắp xếp
        $sortOrder = $request->input('sort', 'desc'); // Mặc định sắp xếp tăng dần
        $idnvgh = Auth::id(); // Nhận idnvgh từ request

        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc'; // Giá trị mặc định
        }

        // Tìm kiếm và sắp xếp cho từng trạng thái
        $dongGoi = $this->shipgetDonHangByStatus('Đóng gói', $searchTerm, $field, $sortField, $sortOrder, $idnvgh);
        $dangGiao = $this->shipgetDonHangByStatus('Đang giao', $searchTerm, $field, $sortField, $sortOrder, $idnvgh);
        $giaoThanhCong = $this->shipgetDonHangByStatus('Giao thành công', $searchTerm, $field, $sortField, $sortOrder, $idnvgh);
        $giaoThatBai = $this->shipgetDonHangByStatus('Giao thất bại', $searchTerm, $field, $sortField, $sortOrder, $idnvgh);
        $donHuy = $this->shipgetDonHangByStatus('Đơn Hủy', $searchTerm, $field, $sortField, $sortOrder, $idnvgh);


        return view('admin.QLDonHang.shipper_index', compact('dongGoi', 'dangGiao', 'giaoThanhCong', 'giaoThatBai', 'donHuy', 'searchTerm', 'field'));
    }

    // Hàm tìm đơn hàng theo trạng thái và các tham số tìm kiếm
    private function shipgetDonHangByStatus($trangThai, $searchTerm, $field, $sortField, $sortOrder, $idnvgh)
    {
        // Danh sách các trường có thể sắp xếp
        $validSortFields = ['iddh', 'ngaydat', 'tennhan', 'sdt', 'tongtien'];

        // Kiểm tra nếu sortField có trong danh sách các trường hợp lệ
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'iddh'; // Giá trị mặc định
        }

        return DonHang::where('trangthai', $trangThai)
            ->where('idnvgh', $idnvgh) // Thêm điều kiện lọc theo idnvgh
            ->when($searchTerm, function ($query) use ($searchTerm, $field) {
                // Kiểm tra xem trường là 'iddh' hay không
                if ($field === 'iddh') {
                    // Tìm kiếm chính xác cho trường 'iddh'
                    return $query->where($field, '=', $searchTerm);
                } else {
                    // Tìm kiếm tương đối cho các trường khác
                    return $query->where($field, 'LIKE', "%{$searchTerm}%");
                }
            })
            ->orderBy($sortField, $sortOrder)
            //->get();
            ->paginate(5);
    }
}
