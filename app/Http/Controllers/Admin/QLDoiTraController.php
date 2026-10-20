<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoiTra;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class QLDoiTraController extends Controller
{
    //
    // Hiển thị danh sách đổi trả
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $field = $request->input('field', 'lydo'); // Mặc định tìm theo trường 'lydo'
        $sortField = $request->input('sort_field', 'id'); // Trường mặc định để sắp xếp
        $sortOrder = $request->input('sort', 'desc'); // Mặc định sắp xếp giảm dần

        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc'; // Giá trị mặc định
        }

        $nhanVien = User::where('quyen', 'nv')->where('dsden', 0)->where('trangthai', 1)->get();

        // Tìm kiếm và sắp xếp cho từng trạng thái
        $choXacNhan = $this->getDoiTraByStatus('Chờ xác nhận', $searchTerm, $field, $sortField, $sortOrder);
        $xacNhan = $this->getDoiTraByStatus('Đã xác nhận', $searchTerm, $field, $sortField, $sortOrder);
        $layHang = $this->getDoiTraByStatus('Đã lấy hàng', $searchTerm, $field, $sortField, $sortOrder);
        $biTuChoi = $this->getDoiTraByStatus('Từ chối', $searchTerm, $field, $sortField, $sortOrder);

        return view('admin.QLDoiTra.index', compact('choXacNhan', 'xacNhan', 'layHang', 'biTuChoi', 'searchTerm', 'field', 'nhanVien'));
    }

    // Hàm tìm đơn đổi trả theo trạng thái và các tham số tìm kiếm
    private function getDoiTraByStatus($trangThai, $searchTerm, $field, $sortField, $sortOrder)
    {
        // Danh sách các trường có thể sắp xếp
        $validSortFields = ['iddt', 'iddh', 'ngaytao', 'hoantien'];

        // Kiểm tra nếu sortField có trong danh sách các trường hợp lệ
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'iddt'; // Giá trị mặc định
        }

        return DoiTra::where('trangthai', $trangThai)
            ->when($searchTerm, function ($query) use ($searchTerm, $field) {
                // Tìm kiếm chính xác hoặc tương đối cho các trường
                if ($field === 'iddt' || $field === 'iddht') {
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
    }

    // Phương thức để chuyển trạng thái đổi trả
    public function chuyenTrangThai($id, $trangThai)
    {
        $idnvgh = request('idnvgh'); // Lấy idnhanvien từ yêu cầu

        // Tìm đơn đổi trả và cập nhật trạng thái
        $doiTra = DoiTra::find($id);
        if ($doiTra) {
            $doiTra->trangthai = $trangThai;

            // Nếu trạng thái là "Đang giao" và phương thức thanh toán là "offline"
            // if ($trangThai === 'Đang giao' && $doiTra->pttt === 'offline') {
            //     $doiTra->ttthanhtoan = 1; // Cập nhật trạng thái thanh toán
            // }

            // Chỉ cập nhật idnvgh nếu nó không rỗng
            if (!empty($idnvgh)) {
                $doiTra->idnvgh = $idnvgh;
            }

            $doiTra->save();
        }

        return redirect()->back()->with('success', 'Đã chuyển trạng thái đơn đổi trả.');
    }

    // Xem chi tiết phiếu đổi trả
    public function chiTiet($id)
    {
        // Tìm phiếu đổi trả theo id và load cả đơn hàng cùng chi tiết đơn hàng
        $doiTra = DoiTra::with(['donHang.chiTietDonHang.sanpham', 'nhanVien'])->find($id);

        // Kiểm tra nếu không tìm thấy phiếu đổi trả
        if (!$doiTra) {
            return redirect()->back()->with('error', 'Phiếu đổi trả không tồn tại.');
        }

        // Trả về view chi tiết với dữ liệu phiếu đổi trả
        return view('admin.QLDoiTra.detail', compact('doiTra'));
    }


    // Hiển thị danh sách đổi trả của nhân viên giao hàng hiện tại
    public function shipindex(Request $request)
    {
        $searchTerm = $request->input('search');
        $field = $request->input('field', 'iddh'); // Mặc định tìm theo trường 'lydo'
        $sortField = $request->input('sort_field', 'iddt'); // Trường mặc định để sắp xếp
        $sortOrder = $request->input('sort', 'desc'); // Mặc định sắp xếp giảm dần
        $idnvgh = Auth::id(); // Nhận id nhân viên giao hàng từ request

        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc'; // Giá trị mặc định
        }

        // Tìm kiếm và sắp xếp theo trạng thái
        $xacNhan = $this->shipgetDoiTraByStatus('Đã xác nhận', $searchTerm, $field, $sortField, $sortOrder, $idnvgh);
        $layHang = $this->shipgetDoiTraByStatus('Đã lấy hàng', $searchTerm, $field, $sortField, $sortOrder, $idnvgh);
        $biTuChoi = $this->shipgetDoiTraByStatus('Từ chối', $searchTerm, $field, $sortField, $sortOrder, $idnvgh);

        return view('admin.QLDoiTra.shipper_index', compact('biTuChoi', 'xacNhan', 'layHang', 'searchTerm', 'field'));
    }

    // Hàm tìm đơn đổi trả theo trạng thái và nhân viên giao hàng
    private function shipgetDoiTraByStatus($trangThai, $searchTerm, $field, $sortField, $sortOrder, $idnvgh)
    {
        // Danh sách các trường có thể sắp xếp
        $validSortFields = ['iddt', 'iddh', 'ngaytao', 'hoantien'];

        // Kiểm tra nếu sortField có trong danh sách các trường hợp lệ
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'iddt'; // Giá trị mặc định
        }

        return DoiTra::where('trangthai', $trangThai)
            ->where('idnvgh', $idnvgh) // Lọc theo nhân viên giao hàng
            ->when($searchTerm, function ($query) use ($searchTerm, $field) {
                if ($field === 'iddt' || $field === 'iddht') {
                    // Tìm kiếm chính xác cho trường 'iddh'
                    return $query->where($field, '=', $searchTerm);
                } else {
                    // Tìm kiếm tương đối cho các trường khác
                    return $query->where($field, 'LIKE', "%{$searchTerm}%");
                }
            })
            ->orderBy($sortField, $sortOrder)
            ->paginate(5);
    }
}
