<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\KhuyenMai;
use App\Models\SanPham;
use App\Models\ChiTietKhuyenMai;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class KhuyenMaiController extends Controller
{
  public function index(Request $request)
  {
    // Lấy từ khóa tìm kiếm và các tùy chọn sắp xếp từ yêu cầu
    $searchTerm = $request->input('search');
    $field = $request->input('field', 'idkm'); // Trường tìm kiếm mặc định
    $sortField = $request->input('sort_field', 'idkm'); // Trường sắp xếp mặc định
    $sortOrder = $request->input('sort', 'asc'); // Thứ tự sắp xếp mặc định

    // Xác thực thứ tự sắp xếp
    if (!in_array($sortOrder, ['asc', 'desc'])) {
      $sortOrder = 'asc'; // Mặc định là sắp xếp tăng dần nếu không hợp lệ
    }

    // Định nghĩa các trường sắp xếp hợp lệ để tránh lỗi SQL
    $validSortFields = ['idkm', 'tenkm', 'loaikm', 'ngaybd', 'ngaykt'];
    if (!in_array($sortField, $validSortFields)) {
      $sortField = 'idkm'; // Mặc định là 'idkm' nếu không hợp lệ
    }

    // Lấy danh sách khuyến mãi với tìm kiếm, sắp xếp và phân trang
    $khuyenmai = KhuyenMai::when($searchTerm, function ($query) use ($searchTerm, $field) {
      // Kiểm tra nếu trường là 'idkm' để so khớp chính xác
      if ($field === 'idkm') {
        return $query->where($field, '=', $searchTerm);
      } else {
        // Đối với các trường khác, sử dụng so khớp một phần
        return $query->where($field, 'LIKE', "%{$searchTerm}%");
      }
    })
      ->orderBy($sortField, $sortOrder) // Áp dụng sắp xếp chỉ khi sortField hợp lệ
      ->paginate(6); // Đặt số lượng khuyến mãi trên mỗi trang

    // Trả về view với danh sách khuyến mãi
    return view('admin.KhuyenMai.index', compact('khuyenmai'));
  }


  public function create()
  {
    $sanpham = SanPham::all();
    return view('admin.KhuyenMai.create', compact('sanpham'));
  }


  // Giảm giá thành tiền
  public function calculateDiscountByPrice($originalPrice, $quantity, $totalPriceAfterDiscount)
  {
    // Tính tổng số tiền giảm
    $totalPriceAfterDiscount = str_replace(['.', ','], ['', '.'], $totalPriceAfterDiscount);
    // dd($originalPrice, $quantity  , $totalPriceAfterDiscount);
    $totalDiscount = ($originalPrice * $quantity) - $totalPriceAfterDiscount;

    // Tính số tiền giảm trên mỗi sản phẩm
    $discountPerItem = $totalDiscount / $quantity;

    // Tính phần trăm giảm giá
    $discountPercentage = ($discountPerItem / $originalPrice) * 100;
    // dd($discountPercentage );
    // Trả về phần trăm giảm giá (làm tròn 2 chữ số thập phân)
    return $discountPercentage;
  }

  public function store(Request $request)
  {
    $gia = 0;

    // Tạo validator và kiểm tra lỗi
    $validator = Validator::make($request->all(), [
      'tenkm' => 'required|string|max:255',
      'loaikm' => 'required|string|in:muanhieu,giamthanhtien,giamtien',
      'ngaybd' => 'required|date|before:ngaykt',
      'ngaykt' => 'required|date|after:ngaybd',
    ]);

    // Điều kiện cho loại khuyến mãi 'giamtien'
    $validator->sometimes('GiamPhanTram', 'required|integer|min:1|max:100', function ($input) {
      return $input->loaikm === 'giamtien';
    });

    $idsp = $request->input('product_id');
    $sanPham = \App\Models\SanPham::find($idsp);

    if ($sanPham) {
      $gia = $sanPham->gia;
      $idsp = $sanPham->idsp;
    } else {
      $validator->errors()->add('idsp', 'Sản phẩm không tồn tại.');
    }


    $validator->sometimes('soluong', 'required|integer|min:1', function ($input) {
      return $input->loaikm === 'giamthanhtien';
    });
    $validator->sometimes('GiaUuDai', 'required|numeric|min:1', function ($input) {
      return $input->loaikm === 'giamthanhtien';
    });

    $validator->after(function ($validator) use ($request, $gia, $sanPham) {
      // Kiểm tra điều kiện 'giamthanhtien'
      if ($request->loaikm === 'giamthanhtien') {
  
          // Kiểm tra giá ưu đãi không âm hoặc không hợp lệ
          if ($request->has('GiaUuDai') && (!is_numeric($request->GiaUuDai) || $request->GiaUuDai < 0)) {
              $validator->errors()->add('giaUuDaiError', 'Giá ưu đãi phải là một số và không được là số âm.');
          }
  
          // Kiểm tra số lượng không âm hoặc không hợp lệ
          if (!$request->has('soluong') || !is_numeric($request->soluong) || $request->soluong < 0) {
              $validator->errors()->add('soluongError', 'Số lượng phải là một số và không được là số âm.');
          }
  
          // Kiểm tra nếu 'GiaUuDai' có giá trị hợp lệ và nhỏ hơn giá gốc * số lượng
          if ($request->has('GiaUuDai') && $request->GiaUuDai >= ($sanPham->gia * $request->soluong)) {
              $validator->errors()->add('giaUuDaiError', 'Giá ưu đãi phải nhỏ hơn giá gốc nhân với số lượng.');
          }
      }
  });
  

    $soluong = $request->has('soluong') ? $request->input('soluong') : 1;
    $request->merge(['dieukien' => $soluong]);

    //  dd($validator->errors()->toArray());
    // Kiểm tra lỗi validate

    if ($validator->fails()) {
      $errors = $validator->errors();

      // Tạo mảng lưu trữ thông báo lỗi
      $customErrors = [];

      // Kiểm tra từng trường và lưu lỗi vào mảng thông báo tương ứng
      if ($errors->has('tenkm')) {
        $customErrors['tenKMError'] = 'Vui lòng nhập tên khuyến mãi.';
      }

      if ($errors->has('loaikm')) {
        $customErrors['loaiKMError'] = 'Vui lòng chọn loại khuyến mãi.';
      }

      // Kiểm tra điều kiện 'giamtien'
      if ($request->loaikm === 'giamtien' && $errors->has('GiamPhanTram')) {
        $customErrors['giamphantramError'] = 'Vui lòng nhập phần trăm giảm giá.';
      }

      // Kiểm tra ngày bắt đầu và ngày kết thúc
      if ($errors->has('ngaybd')) {
        $customErrors['ngayBDError'] = 'Vui lòng chọn ngày bắt đầu khuyến mãi.';
      }
      if ($errors->has('ngaykt')) {
        $customErrors['ngayKTError'] = 'Vui lòng chọn ngày kết thúc khuyến mãi.';
      }
      
      // Kiểm tra điều kiện 'giamthanhtien'
      if ($request->loaikm === 'giamthanhtien') {

        if ($errors->has('giaUuDaiError')) {
          $customErrors['giaUuDaiError'] = $errors->first('giaUuDaiError');
        }

        if ($errors->has('soluong')) {
          $customErrors['soluongError'] = 'Vui lòng nhập số lượng và số lượng không được âm.';
        } else {
          // Kiểm tra nếu 'soluong' là số và không âm
          if (!is_numeric($request->soluong) || $request->soluong < 0) {
            $customErrors['soluongError'] = 'Số lượng phải là một số và không được là số âm.';
          }
        }
    

        if ($request->GiaUuDai >= ($sanPham->gia * $request->soluong)) {
          return back()->withErrors(['giaUuDaiError' => 'Giá ưu đãi phải nhỏ hơn giá gốc.'])->withInput();
        }
      }

      // Trả về với thông tin lỗi
      return back()->withErrors($customErrors)->withInput();
    }


    $dieukien = $request->has('soluong') && $request->input('soluong') !== null ? $request->input('soluong') : 1;

    // Tạo bản ghi khuyến mãi mới
    $khuyenMai = KhuyenMai::create([
      'tenkm' => $request->tenkm,
      'loaikm' => $request->loaikm,
      'dieukien' => $dieukien,    // Kiểm tra nếu 'soluong' có trong request, nếu không gán mặc định là 1
      'noidungkm' => $request->loaikm === 'giamthanhtien'
        ? $this->calculateDiscountByPrice(
          $gia,
          $request->soluong,
          $request->GiaUuDai
        )
        : ($request->loaikm === 'giamtien' ? $request->GiamPhanTram : null),
      'ngaybd' => $request->ngaybd,
      'ngaykt' => $request->ngaykt,
    ]);


    // Nếu loại khuyến mãi là 'giamthanhtien', thêm bản ghi vào ChiTietKhuyenMai
    if ($request->loaikm === 'giamthanhtien') {
      // Tách idsp và giá từ product_id


      // Thêm bản ghi vào ChiTietKhuyenMai
      ChiTietKhuyenMai::create([
        'idkm' => $khuyenMai->idkm, // Lấy id của khuyến mãi vừa tạo
        'idsp' => $idsp,
      ]);
    }

    // Redirect về trang danh sách khuyến mãi và thông báo thành công
    return redirect()->route('admin.KhuyenMai.index')->with('Success', 'Thêm Khuyến Mãi Thành Công');
  }



  public function delete($idkm)
  {
    // Tìm khuyến mãi bằng id
    $khuyenMai = KhuyenMai::find($idkm);

    // Kiểm tra nếu khuyến mãi tồn tại
    if ($khuyenMai) {
      // Xóa khuyến mãi
      $khuyenMai->delete();

      // Chuyển hướng về trang danh sách khuyến mãi với thông báo thành công
      return redirect()->route('admin.KhuyenMai.index')->with('success', 'Khuyến mãi đã được xóa thành công!');
    } else {
      // Chuyển hướng về trang danh sách khuyến mãi với thông báo lỗi
      return redirect()->route('admin.KhuyenMai.index')->with('error', 'Khuyến mãi không tồn tại!');
    }
  }
  public function edit($id)
  {
    // Lấy sản phẩm theo ID
    $khuyenMai = KhuyenMai::findOrFail($id);

    // Lấy tất cả sản phẩm
    $sanpham = SanPham::whereNotIn('idsp', function ($query) {
      $query->select('idsp')
        ->from('chitietkhuyenmai');
    })->get();


    // Sản phẩm đã có trong chương trình khuyến mãi
    $sanphamKhuyenMai = DB::table('sanpham')
      ->join('chitietkhuyenmai', 'sanpham.idsp', '=', 'chitietkhuyenmai.idsp')
      ->where('chitietkhuyenmai.idkm', $id)
      ->select('sanpham.*')
      ->get();
    // Nếu loại khuyến mãi là 'giamthanhtien', lấy 1 sản phẩm của loại đó
    $sanphamGiamThanhTien = 0;
    if ($khuyenMai->loaikm === 'giamthanhtien') {
      $sanphamGiamThanhTien = DB::table('sanpham')
        ->join('chitietkhuyenmai', 'sanpham.idsp', '=', 'chitietkhuyenmai.idsp')
        ->where('chitietkhuyenmai.idkm', $id)
        ->select('sanpham.*')
        ->first(); // Lấy một sản phẩm
    }

    return view('admin.KhuyenMai.apply', compact('khuyenMai', 'sanpham', 'sanphamKhuyenMai', 'sanphamGiamThanhTien'));
  }


  public function insertChiTietKhuyenMai($idkm, $idsp)
  {
    ChiTietKhuyenMai::create([
      'idkm' => $idkm,
      'idsp' => $idsp
    ]);

    return redirect()->route('admin.KhuyenMai.edit', $idkm)->with('success', 'Thêm chi tiết khuyến mãi thành công.');
  }

  public function deleteChiTietKhuyenMai($idkm, $idsp)
  {
    // Tìm chi tiết khuyến mãi theo idkm và idsp
    $chiTietKhuyenMai = ChiTietKhuyenMai::where('idkm', $idkm)
      ->where('idsp', $idsp)
      ->firstOrFail();

    // Xóa chi tiết khuyến mãi
    $chiTietKhuyenMai->delete();

    // Chuyển hướng về trang chỉnh sửa khuyến mãi và hiển thị thông báo thành công
    return redirect()->route('admin.KhuyenMai.edit', $idkm)->with('success', 'Xóa chi tiết khuyến mãi thành công.');
  }

  public function update(Request $request, $id)
  {

    // Validate input
    $validator = Validator::make($request->all(), [
      'tenkm' => 'required|string|max:255',
      'loaikm' => 'required|string|max:50|in:giamtien,giamthanhtien',
      // 'ngaybd' => 'required|date|before:ngaykt',
      // 'ngaykt' => 'required|date|after:ngaybd',
      // 'idsp' => 'required_if:loaikm,giamthanhtien|exists:sanpham,idsp',
    ]);

    // Conditional validation
    $validator->sometimes('GiamPhanTram', 'required|integer|numeric|min:1|max:100', function ($input) {
      return $input->loaikm === 'giamtien';
    });

    $validator->sometimes('soluong', 'required|integer|min:1', function ($input) {
      return $input->loaikm === 'giamthanhtien';
    });

    $validator->sometimes('GiaUuDai', 'required|numeric|min:1', function ($input) {
      return $input->loaikm === 'giamthanhtien';
    });

    // Custom error messages
    if ($validator->fails()) {
      $errors = $validator->errors();
      $customErrors = [];

      if ($errors->has('tenkm')) $customErrors['tenKMError'] = 'Vui lòng nhập tên khuyến mãi.';
      if ($errors->has('loaikm')) $customErrors['loaiKMError'] = 'Vui lòng chọn loại khuyến mãi hợp lệ.';
      if ($request->loaikm === 'giamtien' && $errors->has('GiamPhanTram')) {
        $customErrors['giamphantramError'] = 'Phần trăm giảm giá phải từ 1 đến 100.';
      }
      if ($request->loaikm === 'giamthanhtien' && $errors->has('idsp')) {
        $customErrors['idspError'] = 'Sản phẩm được giảm giá không hợp lệ.';
      }
      // if ($errors->has('ngaybd')) $customErrors['ngayBDError'] = 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc.';
      // if ($errors->has('ngaykt')) $customErrors['ngayKTError'] = 'Ngày kết thúc phải lớn hơn ngày bắt đầu.';

      return back()->withErrors($customErrors)->withInput();
    }




    // Find the promotion by ID
    $promotion = KhuyenMai::findOrFail($id);

    // If `giamthanhtien`, fetch the product price and validate discount
    $sanphamKM = null;
    if ($request->loaikm === 'giamthanhtien') {
      // Tìm `idsp` từ bảng chi tiết khuyến mãi dựa vào `idkm`
      $chiTietKhuyenMai = \App\Models\ChiTietKhuyenMai::where('idkm', $promotion->idkm)->first();

      if (!$chiTietKhuyenMai) {
        return back()->withErrors(['idspError' => 'Không tìm thấy sản phẩm liên quan đến khuyến mãi.'])->withInput();
      }

      $sanPham = \App\Models\SanPham::find($chiTietKhuyenMai->idsp);

      if (!$sanPham) {
        return back()->withErrors(['idspError' => 'Sản phẩm không tồn tại.'])->withInput();
      }

      $sanphamKM = $chiTietKhuyenMai->idsp;

      // Validate `GiaUuDai`
      if ($request->GiaUuDai >= ($sanPham->gia * $request->soluong)) {
        return back()->withErrors(['giaUuDaiError' => 'Giá ưu đãi phải nhỏ hơn giá gốc.'])->withInput();
      }
    }
    // dd($request->GiaUuDai);
    // Update the promotion
    $promotion->update([
      'tenkm' => $request->tenkm,
      'loaikm' => $request->loaikm,
      'dieukien' => $request->loaikm === 'giamthanhtien' ? $request->soluong : 1,
      'noidungkm' => $request->loaikm === 'giamthanhtien'
        ? $this->calculateDiscountByPrice(
          $sanPham->gia,
          $request->soluong,
          $request->GiaUuDai
        )
        : ($request->loaikm === 'giamtien' ? $request->GiamPhanTram : null),

      'ngaybd' => $request->ngaybd,
      'ngaykt' => $request->ngaykt,
    ]);

    return redirect()->route('admin.KhuyenMai.index')->with('success', 'Khuyến mãi đã được cập nhật thành công!');
  }
}
