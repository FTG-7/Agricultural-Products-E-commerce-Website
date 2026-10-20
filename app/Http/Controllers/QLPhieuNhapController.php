<?php

namespace App\Http\Controllers;

use App\Models\PhieuNhap;
use App\Models\SanPham;
use App\Models\ChiTietPhieuNhap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class QLPhieuNhapController extends Controller
{
    public function show_phieunhap(Request $request)
    {
        // Lấy từ khóa tìm kiếm và các tùy chọn sắp xếp từ yêu cầu
        $searchTerm = $request->input('search');
        $field = $request->input('field', 'tennhacungcap'); // Trường tìm kiếm mặc định
        $sortField = $request->input('sort_field', 'idpn'); // Trường sắp xếp mặc định
        $sortOrder = $request->input('sort', 'desc'); // Thứ tự sắp xếp mặc định

        // Xác thực thứ tự sắp xếp
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc'; // Mặc định là sắp xếp giảm dần nếu không hợp lệ
        }

        // Định nghĩa các trường sắp xếp hợp lệ để tránh lỗi SQL
        $validSortFields = ['idpn', 'tennhacungcap', 'ngaylap', 'tongtien'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'idpn'; // Mặc định là 'idpn' nếu không hợp lệ
        }

        // Lấy phiếu nhập với tìm kiếm, sắp xếp và phân trang
        $PhieuNhap = PhieuNhap::when($searchTerm, function ($query) use ($searchTerm, $field) {
            // Kiểm tra nếu trường là 'idpn' để so khớp chính xác
            if ($field === 'idpn') {
                return $query->where($field, '=', $searchTerm);
            } else {
                // Đối với các trường khác, sử dụng so khớp một phần
                return $query->where($field, 'LIKE', "%{$searchTerm}%");
            }
        })
            ->orderBy($sortField, $sortOrder) // Áp dụng sắp xếp chỉ khi sortField hợp lệ
            ->paginate(6); // Đặt số lượng phiếu nhập trên mỗi trang

        // Lấy tất cả sản phẩm để hiển thị trong view (nếu cần)
        $SanPhams = SanPham::all();

        // Trả về view với danh sách phiếu nhập và các sản phẩm
        return view('admin.PhieuNhap.show', compact('PhieuNhap', 'SanPhams'));
    }


    public function create(Request $request)
    {
        try {
            // Tạo phiếu nhập
            $phieuNhap = PhieuNhap::create([
                'tennhacungcap' => $request->tennhacungcap,
                'ngaylap' => now(),
                'tongtien' => $request->tongtien,
                'ghichu' => $request->ghichu,
            ]);

            // Lặp qua từng sản phẩm để thêm vào chi tiết phiếu nhập
            foreach ($request->soluong as $idsp => $soluong) {
                // Kiểm tra nếu tồn tại đơn giá và tên sản phẩm
                // if (!isset($request->dongia[$idsp]) || !isset($request->tensp[$idsp])) {
                //     Log::error("Thiếu giá hoặc tên sản phẩm cho idsp: $idsp");
                //     return redirect()->back()->withErrors("Thiếu thông tin cho sản phẩm ID: $idsp.");
                // }

                $dongia = $request->dongia[$idsp]; // Lấy đơn giá từ request
                $tensp = $request->tensp[$idsp]; // Lấy tên sản phẩm từ request

                // Tạo chi tiết phiếu nhập
                ChiTietPhieuNhap::create([
                    'idpn' => $phieuNhap->idpn,
                    'idsp' => $idsp,
                    'tensp' => $tensp,
                    'soluong' => $soluong,
                    'dongia' => $dongia,
                ]);

                // // Cập nhật số lượng sản phẩm trong bảng SanPham
                // $sanPham = SanPham::find($idsp);
                // if ($sanPham) {
                //     $sanPham->soluong += $soluong;
                //     $sanPham->save();
                // }
            }
        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo phiếu nhập: ' . $e->getMessage());
            return redirect()->back()->withErrors('Có lỗi xảy ra: ' . $e->getMessage());
        }

        return redirect()->route('admin.PhieuNhap.show')->with('success', 'Phiếu nhập đã được tạo thành công!');
    }

    //Xóa
    public function destroy($idpn)
    {
        // Tìm phiếu nhập theo ID
        $phieuNhap = PhieuNhap::find($idpn);

        if ($phieuNhap) {
            // Xóa các chi tiết phiếu nhập liên quan
            $phieuNhap->chiTietPhieuNhap()->delete();

            // Xóa phiếu nhập
            $phieuNhap->delete();

            // Quay lại với thông báo thành công
            return redirect()->route('admin.PhieuNhap.show')->with('success', 'Xóa phiếu nhập thành công cùng với các chi tiết!');
        }

        // Nếu không tìm thấy phiếu nhập, quay lại với thông báo lỗi
        return redirect()->route('admin.PhieuNhap.show')->with('error', 'Phiếu nhập không tồn tại!');
    }

    // Phương thức để hiển thị form chỉnh sửa phiếu nhập
    public function edit($idpn)
    {
        $phieuNhap = PhieuNhap::with('chiTietPhieuNhap')->find($idpn); // Đảm bảo bạn sử dụng eager loading để lấy chi tiết
        $SanPhams = SanPham::all(); // Lấy tất cả sản phẩm

        if (!$phieuNhap) {
            return redirect()->back()->with('error', 'Phiếu Nhập không tồn tại');
        }

        // Format lại ngày lập để truyền sang view
        $phieuNhap->ngaylap = Carbon::parse($phieuNhap->ngaylap)->format('d-m-Y');

        return view('admin.PhieuNhap.edit', compact('phieuNhap', 'SanPhams'));
    }

    public function update(Request $request, $idpn)
    {
        try {
            // Debug dữ liệu nhận được để kiểm tra input
            // dd($request->all()); // Uncomment nếu muốn kiểm tra dữ liệu đầu vào

            // Xác thực dữ liệu
            $request->validate([
                'tennhacungcap' => 'required|string|max:255',
                'ngaylap' => 'required|date',
                'ghichu' => 'nullable|string',
                'soluong' => 'required|array',
                'dongia' => 'required|array',
                'tensp' => 'required|array',
            ]);

            // Lấy phiếu nhập hiện tại
            $phieuNhap = PhieuNhap::findOrFail($idpn);

            // Cập nhật thông tin phiếu nhập
            $phieuNhap->tennhacungcap = $request->tennhacungcap;

            // Chuyển đổi định dạng ngày trước khi lưu
            $ngaylap = \Carbon\Carbon::createFromFormat('d-m-Y', $request->ngaylap)->format('Y-m-d');
            $phieuNhap->ngaylap = $ngaylap;

            $phieuNhap->ghichu = $request->ghichu;

            // Lấy danh sách chi tiết phiếu nhập hiện tại
            $currentDetails = ChiTietPhieuNhap::where('idpn', $idpn)->get()->keyBy('idsp');

            // Khởi tạo tổng tiền
            $tongTien = 0;

            // Duyệt qua các sản phẩm được gửi từ form
            foreach ($request->soluong as $idsp => $soluong) {
                $dongia = $request->dongia[$idsp] ?? 0;
                $tensp = $request->tensp[$idsp] ?? '';

                // Tính tổng tiền
                $tongTien += $soluong * $dongia;

                if ($currentDetails->has($idsp)) {
                    // Cập nhật chi tiết nếu đã tồn tại
                    $chiTiet = $currentDetails[$idsp];
                    $chiTiet->update([
                        'soluong' => $soluong,
                        'dongia' => $dongia,
                        'tensp' => $tensp,
                    ]);

                    // Xóa chi tiết này khỏi danh sách để xử lý các chi tiết không còn tồn tại
                    $currentDetails->forget($idsp);
                } else {
                    // Thêm chi tiết mới nếu chưa tồn tại
                    ChiTietPhieuNhap::create([
                        'idpn' => $idpn,
                        'idsp' => $idsp,
                        'soluong' => $soluong,
                        'dongia' => $dongia,
                        'tensp' => $tensp,
                    ]);
                }
            }

            // Xóa các chi tiết không còn tồn tại trong yêu cầu
            foreach ($currentDetails as $chiTiet) {
                $chiTiet->delete();
            }

            // Cập nhật tổng tiền phiếu nhập
            $phieuNhap->tongtien = $tongTien;
            $phieuNhap->save();

            // Chuyển hướng về trang danh sách với thông báo thành công
            return redirect()->route('admin.PhieuNhap.show')
                ->with('success', 'Cập nhật phiếu nhập thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Bắt lỗi validate và trả về thông báo lỗi
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Bắt các lỗi khác và trả về thông báo lỗi
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function confirm($idpn)
    {
        try {
            // Lấy phiếu nhập dựa trên ID
            $phieuNhap = PhieuNhap::findOrFail($idpn);

            // Lấy tất cả chi tiết phiếu nhập liên quan đến phiếu nhập này
            $chiTietPhieuNhaps = $phieuNhap->chiTietPhieuNhap;

            // Duyệt qua từng chi tiết phiếu nhập để cập nhật số lượng sản phẩm
            foreach ($chiTietPhieuNhaps as $chiTiet) {
                $sanPham = SanPham::find($chiTiet->idsp);

                if ($sanPham) {
                    // Cộng số lượng từ phiếu nhập vào sản phẩm
                    $sanPham->soluong += $chiTiet->soluong;
                    $sanPham->save();
                }
            }

            // Cập nhật ngày lập và trạng thái xác nhận của phiếu nhập
            // $phieuNhap->ngaylap = now(); //gán ngày hiện tại
            $phieuNhap->xacnhan = 1; // Đã xác nhận
            $phieuNhap->save();

            // Chuyển hướng với thông báo thành công
            return redirect()->route('admin.PhieuNhap.show')
                ->with('success', 'Phiếu nhập đã được xác nhận và số lượng sản phẩm đã được cập nhật!');
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function info($idpn)
    {
        $phieuNhap = PhieuNhap::with('chiTietPhieuNhap')->find($idpn); // Đảm bảo bạn sử dụng eager loading để lấy chi tiết
        $SanPhams = SanPham::all(); // Lấy tất cả sản phẩm

        if (!$phieuNhap) {
            return redirect()->back()->with('error', 'Phiếu Nhập không tồn tại');
        }

        // Format lại ngày lập để truyền sang view
        $phieuNhap->ngaylap = Carbon::parse($phieuNhap->ngaylap)->format('d-m-Y');

        return view('admin.PhieuNhap.info', compact('phieuNhap', 'SanPhams'));
    }
}
