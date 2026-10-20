<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\ChiTietDoiTra;
use App\Models\ChiTietDonHang;
use App\Models\DoiTra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DoiTraController extends Controller
{
    //
    public function create($iddh)
    {
        // Tìm đơn hàng theo iddh
        $donHang = DonHang::findOrFail($iddh);

        $chiTietDonHang = $donHang->chiTietDonHang;

        // Trả về view với dữ liệu đơn hàng
        return view('user.DoiTra.create', compact('donHang', 'chiTietDonHang'));
    }

    public function store(Request $request)
    {
        $errors = [];
        // Xác thực lý do đổi trả
        $lydo = $request->input('lydo');
        if (empty($lydo)) {
            $errors['lydo'] = 'Hãy nhập lý do đổi trả';
        } elseif (strlen($lydo) > 255) {
            $errors['lydo'] = 'Lý do đổi trả không được vượt quá 255 ký tự';
        }

        // Xác thực hình ảnh
        $hinh = $request->file('hinh');
        if (empty($hinh)) {
            $errors['hinh'] = 'Hãy tải lên hình ảnh';
        } elseif (!$hinh->isValid()) {
            $errors['hinh'] = 'Hình ảnh không hợp lệ';
        } elseif (!in_array($hinh->getClientOriginalExtension(), ['jpeg', 'png', 'jpg'])) {
            $errors['hinh'] = 'Hình ảnh phải có định dạng jpeg, png, hoặc jpg';
        } elseif ($hinh->getSize() > 2048 * 1024) { // 2048 KB = 2MB
            $errors['hinh'] = 'Hình ảnh phải có dung lượng không quá 2MB';
        }

        // Xác thực video
        $video = $request->file('video');
        if (empty($video)) {
            $errors['video'] = 'Hãy tải lên video';
        } elseif (!$video->isValid()) {
            $errors['video'] = 'Video không hợp lệ';
        } elseif (!in_array($video->getClientOriginalExtension(), ['mp4'])) {
            $errors['video'] = 'Video phải có định dạng mp4';
        }
        // elseif ($hinh->getSize() > 5 * 1024 * 1024) { // 5MB
        //     $errors['hinh'] = 'Hình ảnh phải có dung lượng không quá 5MB';
        // }

        // Xác thực ghi chú (không bắt buộc nhưng giới hạn ký tự)
        $ghichu = $request->input('ghichu');
        if (!empty($ghichu) && strlen($ghichu) > 500) {
            $errors['ghichu'] = 'Ghi chú không được vượt quá 500 ký tự';
        }

        if (empty($request->input('products'))) {
            $errors['products'] = 'Hãy chọn ít nhất 1 sản phẩm';
        }

        // Nếu có lỗi, trả về trang đăng ký cùng với thông báo lỗi
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Lấy thông tin đơn hàng từ iddh trong request
        $donHang = DonHang::findOrFail($request->iddh);

        // Lưu thông tin đổi trả
        $phieuDoiTra = DoiTra::create([
            'idtk' => Auth::user()->idtk, // Lấy idtk của người dùng hiện tại
            'iddh' => $request->iddh,     // Lấy iddh từ request
            'ngaytao' => now(),           // Ngày tạo là ngày hiện tại
            'lydo' => $request->lydo,     // Lý do đổi trả
            'video' => $request->hasFile('video') ? $this->uploadVideo($request->file('video')) : null, // Upload video
            'ghichu' => $request->ghichu, // Ghi chú nếu có
            'hoantien' => 0,
            'hinh' => $request->hasFile('hinh') ? $this->uploadImage($request->file('hinh')) : null, // Upload hình ảnh
            'trangthai' => 'Chờ xác nhận', // Trạng thái mặc định là 'chờ xác nhận'
        ]);

        $tongHoanTien = 0;
        foreach ($request->products as $idsp => $soluong) {
            $sanPham = ChiTietDonHang::where('iddh', $donHang->iddh)->where('idsp', $idsp)->first();
            $dongia = $sanPham->tong;
            $tongHoanTien += $dongia;

            ChiTietDoiTra::create([
                'iddt' => $phieuDoiTra->iddt,
                'idsp' => $idsp,
                'tensp' => $sanPham->tensp,
                'soluong' => $soluong,
                'dongia' => $dongia,
            ]);
        }

        // Cập nhật lại tổng tiền hoàn trong bảng DoiTra
        $phieuDoiTra->update(['hoantien' => $tongHoanTien]);

        // Redirect về trang danh sách đơn hàng với thông báo thành công
        return redirect()->route('doitra.index')->with('success', 'Tạo phiếu đổi trả thành công.');
    }

    /**
     * Hàm upload hình ảnh và trả về tên file đã lưu
     */
    private function uploadImage($file)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(); // Đổi tên file
        $file->move(public_path('imagedt'), $filename); // Lưu vào thư mục public/imagedt
        return $filename;
    }

    /**
     * Hàm upload video và trả về tên file đã lưu
     */
    private function uploadVideo($file)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(); // Đổi tên file
        $file->move(public_path('videodt'), $filename); // Lưu vào thư mục public/videodt
        return $filename;
    }

    public function index()
    {
        // Lấy id của khách hàng đang đăng nhập
        $userId = Auth::user()->idtk;

        // Lấy danh sách đổi trả chỉ của khách hàng đang đăng nhập
        $danhSachDoiTra = DoiTra::where('idtk', $userId)->with('donHang')->get();

        // Trả về view hiển thị danh sách đổi trả
        return view('user.DoiTra.list', compact('danhSachDoiTra'));
    }
}
