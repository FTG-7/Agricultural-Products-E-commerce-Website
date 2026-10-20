<?php

namespace App\Http\Controllers\User;

use App\Models\SanPham;
use App\Models\loaisp;
use App\Http\Controllers\Controller;
use App\Models\Anh;
use App\Models\BinhLuan;
use App\Models\ChiTietKhuyenMai;
use App\Models\Admin\KhuyenMai;
use App\Models\SpHetHan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Nhập lớp DB ở đây
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SanPhamController extends Controller
{
    public function aboutus()
    {
        return view('user.ds_SanPham.AboutUs');
    }
    public function index()
    {
        $Sanpham = SanPham::with('anh')->orderBy('idsp', 'desc')->limit(8)->get();
        $SanphamBanChay = SanPham::with('anh')
            ->join('chitietdonhang', 'sanpham.idsp', '=', 'chitietdonhang.idsp')
            ->join('donhang', 'chitietdonhang.iddh', '=', 'donhang.iddh')
            ->where('donhang.trangthai', 'Giao thành công')
            ->where('sanpham.soluong', '>', 0)
            ->select('sanpham.*', DB::raw('SUM(chitietdonhang.soluong) as total_sold')) // Tính tổng số lượng bán
            ->groupBy('sanpham.idsp') // Nhóm theo id sản phẩm
            ->orderBy('total_sold', 'desc') // Sắp xếp theo tổng số lượng bán giảm dần
            ->limit(8)
            ->get();

        // Các phần lọc sản phẩm khác (Thịt, Rau, Trái cây, Thủy sản) không thay đổi

        $SanphamThit = SanPham::with('anh')
            ->where('sanpham.soluong', '>', 0)
            ->whereHas('loaisp', function ($query) {
                $query->where('loaisp.idloai', '5');  // Lọc theo loại "Thịt"
            })
            ->orderBy('idsp', 'desc')
            ->limit(8)
            ->get();

        $SanphamRau = SanPham::with('anh')
            ->where('sanpham.soluong', '>', 0)
            ->whereHas('loaisp', function ($query) {
                $query->where('loaisp.idloai', '1');  // Lọc theo loại "Rau"
            })
            ->orderBy('idsp', 'desc')
            ->limit(8)
            ->get();

        $SanphamTraiCay = SanPham::with('anh')
            ->where('sanpham.soluong', '>', 0)
            ->whereHas('loaisp', function ($query) {
                $query->where('loaisp.idloai', '4');  // Lọc theo loại "Trái cây"
            })
            ->orderBy('idsp', 'desc')
            ->limit(8)
            ->get();

        $SanphamThuySan = SanPham::with('anh')
            ->where('sanpham.soluong', '>', 0)
            ->whereHas('loaisp', function ($query) {
                $query->where('loaisp.idloai', '7');  // Lọc theo loại "Thủy sản"
            })
            ->orderBy('idsp', 'desc')
            ->limit(8)
            ->get();

        // Duyệt qua các sản phẩm và thêm thông tin trung bình đánh giá cho từng sản phẩm
        foreach ([$SanphamThit, $SanphamRau, $SanphamTraiCay, $SanphamThuySan, $Sanpham, $SanphamBanChay] as $sanphamGroup) {
            foreach ($sanphamGroup as $product) {
                // Tính trung bình đánh giá của sản phẩm
                $averageRating = BinhLuan::where('idsp', $product->idsp)->avg('rating');
                $product->averageRating = round($averageRating, 1); // Làm tròn giá trị trung bình đánh giá

                // Lấy chi tiết khuyến mãi của sản phẩm
                $chiTietKhuyenMai = ChiTietKhuyenMai::where('idsp', $product->idsp)->first();

                if ($chiTietKhuyenMai) {
                    // Tìm thông tin khuyến mãi
                    $khuyenMai = KhuyenMai::find($chiTietKhuyenMai->idkm);

                    if ($khuyenMai && $khuyenMai->trangthai == 1) {  // Kiểm tra trạng thái khuyến mãi là 1
                        if ($khuyenMai->loaikm === 'giamtien') {
                            // Giảm giá theo số tiền
                            $product->discountAmount = $khuyenMai->noidungkm;
                        } elseif ($khuyenMai->loaikm === 'giamthanhtien') {
                            // Tặng sản phẩm hoặc giảm giá theo tổng tiền
                            $product->increasedProductName = $khuyenMai->tenkm;  // Lưu tên khuyến mãi
                        }
                    } else {
                        // Nếu khuyến mãi hết hạn hoặc không có khuyến mãi
                        $product->discountAmount = 0;
                        $product->increasedProductName = null;
                    }
                } else {
                    // Nếu không có khuyến mãi cho sản phẩm
                    $product->discountAmount = 0;
                    $product->increasedProductName = null;
                }
            }
        }

        $topRatedProducts = SanPham::with('anh')
            ->select('sanpham.*')
            ->leftJoin('binhluan', 'sanpham.idsp', '=', 'binhluan.idsp')
            ->groupBy('sanpham.idsp')
            ->where('sanpham.soluong', '>', 0)
            ->orderByDesc(DB::raw('AVG(binhluan.rating)')) // Sắp xếp theo đánh giá trung bình
            ->limit(10)
            ->get();

        // Tính trung bình đánh giá cho từng sản phẩm
        foreach ($topRatedProducts as $product) {
            // Tính trung bình đánh giá của sản phẩm
            $averageRating = BinhLuan::where('idsp', $product->idsp)->avg('rating');
            $product->averageRating = round($averageRating, 1); // Làm tròn giá trị trung bình đánh giá

            // Lấy chi tiết khuyến mãi của sản phẩm
            $chiTietKhuyenMai = ChiTietKhuyenMai::where('idsp', $product->idsp)->first();

            if ($chiTietKhuyenMai) {
                // Tìm thông tin khuyến mãi
                $khuyenMai = KhuyenMai::find($chiTietKhuyenMai->idkm);

                if ($khuyenMai && $khuyenMai->trangthai == 1) {  // Kiểm tra trạng thái khuyến mãi là 1
                    if ($khuyenMai->loaikm === 'giamtien') {
                        // Giảm giá theo số tiền
                        $product->discountAmount = $khuyenMai->noidungkm;
                    } elseif ($khuyenMai->loaikm === 'giamthanhtien') {
                        // Tặng sản phẩm hoặc giảm giá theo tổng tiền
                        $product->increasedProductName = $khuyenMai->tenkm;  // Lưu tên khuyến mãi
                    }
                } else {
                    // Nếu khuyến mãi hết hạn hoặc không có khuyến mãi
                    $product->discountAmount = 0;
                    $product->increasedProductName = null;
                }
            } else {
                // Nếu không có khuyến mãi cho sản phẩm
                $product->discountAmount = 0;
                $product->increasedProductName = null;
            }
        }
        // Trả về view với các sản phẩm đã lọc theo loại
        return view('user.ds_SanPham.index', compact('SanphamThit', 'SanphamRau', 'SanphamTraiCay', 'SanphamThuySan', 'Sanpham', 'SanphamBanChay', 'topRatedProducts'));
    }

    public function admin_index(Request $request)
    {
        // Lấy từ khóa tìm kiếm và các tùy chọn sắp xếp từ yêu cầu
        $searchTerm = $request->input('search');
        $field = $request->input('field', 'tensp'); // Trường tìm kiếm mặc định
        $searchTerm1 = $request->input('search_1');
        $field1 = $request->input('field_1', 'tensp');
        $sortField = $request->input('sort_field', 'idsp'); // Trường sắp xếp mặc định
        $sortOrder = $request->input('sort', 'desc'); // Thứ tự sắp xếp mặc định
        $idloai = $request->input('idloai');

        // Xác thực thứ tự sắp xếp
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc'; // Mặc định là sắp xếp giảm dần nếu không hợp lệ
        }

        // Định nghĩa các trường sắp xếp hợp lệ để tránh lỗi SQL
        $validSortFields = ['idsp', 'tensp', 'gia', 'xuatxu'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'idsp'; // Mặc định là 'idsp' nếu không hợp lệ
        }

        // Lấy sản phẩm với tìm kiếm, sắp xếp và phân trang
        $products = SanPham::with('anh') // Tải trước mối quan hệ 'anh'
            ->when($searchTerm, function ($query) use ($searchTerm, $field) {
                // Kiểm tra nếu trường là 'idsp' để so khớp chính xác
                if ($field === 'idsp') {
                    return $query->where($field, '=', $searchTerm);
                } else {
                    // Đối với các trường khác, sử dụng so khớp một phần
                    return $query->where($field, 'LIKE', "%{$searchTerm}%");
                }
            })
            // Kiểm tra idloai để lọc sản phẩm theo loại, nhưng không áp dụng nếu idloai là null
            ->when($idloai, function ($query) use ($idloai) {
                $query->whereExists(function ($subQuery) use ($idloai) {
                    $subQuery->select(DB::raw(1))
                        ->from('loaisp')
                        ->join('sanpham_loaisp', 'loaisp.idloai', '=', 'sanpham_loaisp.idloai')
                        ->whereColumn('sanpham.idsp', 'sanpham_loaisp.idsp')
                        ->where('loaisp.idloai', $idloai);
                });
            })
            ->orderBy($sortField, $sortOrder) // Áp dụng sắp xếp chỉ khi sortField hợp lệ
            ->paginate(6); // Đặt số lượng sản phẩm trên mỗi trang

        $noSanPham = SanPham::where('soluong', '<=', 0)
            ->when($searchTerm1, function ($query) use ($searchTerm1, $field1) {
                // Kiểm tra nếu trường là 'idsp' để so khớp chính xác
                if ($field1 === 'idsp') {
                    return $query->where($field1, '=', $searchTerm1);
                } else {
                    // Đối với các trường khác, sử dụng so khớp một phần
                    return $query->where($field1, 'LIKE', "%{$searchTerm1}%");
                }
            })
            ->get();
        $LoaiSP = LoaiSP::withCount('sanpham')->get();
        // Trả về view với danh sách sản phẩm
        return view('admin.SanPham.index', compact('products', 'LoaiSP', 'noSanPham'));
    }

    public function show_product(Request $request, $idloai = null)
    {
        // Mặc định sắp xếp theo 'id' giảm dần
        $sortField = 'idsp';
        $sortOrder = 'desc';

        $max = SanPham::max('gia');

        // Lấy tham số sắp xếp từ request
        if ($request->has('idloai')) {
            $idloai = $request->input('idloai'); // Gán giá trị nếu có
        }
        $sxsplist = $request->input('sxsplist');
        $searchTerm = $request->input('search'); // Từ khóa tìm kiếm
        $minPrice = $request->input('rangeInputMin', 0); // Giá tối thiểu
        $maxPrice = $request->input('rangeInputMax', SanPham::max('gia')); // Giá tối đa

        // Thiết lập sắp xếp
        switch ($sxsplist) {
            case 'idgiam':
                $sortField = 'idsp';
                $sortOrder = 'desc';
                break;
            case 'idtang':
                $sortField = 'idsp';
                $sortOrder = 'asc';
                break;
            case 'giatang':
                $sortField = 'gia';
                $sortOrder = 'asc';
                break;
            case 'giagiam':
                $sortField = 'gia';
                $sortOrder = 'desc';
                break;
        }

        // Tạo truy vấn sản phẩm
        $SanphamQuery = SanPham::with('anh');

        // Nếu có từ khóa tìm kiếm, thêm điều kiện tìm kiếm
        if (!empty($searchTerm)) {
            $SanphamQuery->where('tensp', 'like', '%' . $searchTerm . '%');
        }

        // Nếu có $idloai, thêm điều kiện lọc theo loại sản phẩm
        if (!is_null($idloai)) {
            $SanphamQuery->whereExists(function ($query) use ($idloai) {
                $query->select(DB::raw(1))
                    ->from('loaisp')
                    ->join('sanpham_loaisp', 'loaisp.idloai', '=', 'sanpham_loaisp.idloai')
                    ->whereColumn('sanpham.idsp', 'sanpham_loaisp.idsp')
                    ->where('loaisp.idloai', $idloai);
            });
        }

        // Áp dụng điều kiện lọc theo khoảng giá
        $SanphamQuery->whereBetween('gia', [$minPrice, $maxPrice])->where('trangthai', 1);

        // Áp dụng sắp xếp và phân trang
        $Sanpham = $SanphamQuery->orderBy($sortField, $sortOrder)->paginate(9);

        // Thêm thông tin khuyến mãi cho từng sản phẩm
        foreach ($Sanpham as $product) {
            $averageRating = BinhLuan::where('idsp', $product->idsp)->avg('rating');
            $product->averageRating = round($averageRating, 1); // Làm tròn giá trị trung bình đánh giá

            $chiTietKhuyenMai = ChiTietKhuyenMai::where('idsp', $product->idsp)->first();

            if ($chiTietKhuyenMai) {
                $khuyenMai = KhuyenMai::find($chiTietKhuyenMai->idkm);

                if ($khuyenMai && $khuyenMai->trangthai == 1) {  // Kiểm tra trạng thái khuyến mãi là 1
                    if ($khuyenMai->loaikm === 'giamtien') {
                        $product->discountAmount = $khuyenMai->noidungkm;  // Giảm giá theo số tiền
                    } elseif ($khuyenMai->loaikm === 'giamthanhtien') {
                        $product->increasedProductName =  $khuyenMai->tenkm;  // Tặng sản phẩm hoặc giảm giá theo tổng tiền
                    }
                } else {
                    // Nếu khuyến mãi hết hạn hoặc không có khuyến mãi
                    $product->discountAmount = 0;
                    $product->increasedProductName = null;
                }
            } else {
                $product->discountAmount = 0;
                $product->increasedProductName = null;
            }
        }

        // Lấy danh sách loại sản phẩm để hiển thị ở giao diện
        $LoaiSP = LoaiSP::withCount(['sanpham' => function ($query) {
            $query->where('soluong', '>', 0);
        }])->get();

        // Truyền các tham số vào view để giữ trạng thái
        return view('user.ds_SanPham.show_product', compact('Sanpham', 'LoaiSP', 'idloai', 'sxsplist', 'searchTerm', 'minPrice', 'maxPrice', 'max'));
    }


    public function getSanPhamById($idsp)
    {
        // Lấy sản phẩm theo ID, kèm theo thông tin loại sản phẩm và hình ảnh
        $sanpham = SanPham::with('loaisp', 'anh')->where('idsp', $idsp)->first();

        // Kiểm tra nếu sản phẩm tồn tại
        if (!$sanpham) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }

        // Kiểm tra khuyến mãi của sản phẩm
        $chiTietKhuyenMai = ChiTietKhuyenMai::where('idsp', $sanpham->idsp)->first();
        if ($chiTietKhuyenMai) {
            $khuyenMai = KhuyenMai::find($chiTietKhuyenMai->idkm);
            if ($khuyenMai && $khuyenMai->trangthai == 1) {  // Kiểm tra khuyến mãi còn hiệu lực
                // Kiểm tra loại khuyến mãi
                if ($khuyenMai->loaikm === 'giamtien') {
                    // Khuyến mãi giảm tiền
                    $sanpham->discountAmount = $khuyenMai->noidungkm;
                } elseif ($khuyenMai->loaikm === 'giamthanhtien') {
                    // Khuyến mãi giảm tổng tiền (hoặc tặng sản phẩm)
                    $sanpham->increasedProductName = $khuyenMai->tenkm;
                }
            } else {
                // Nếu khuyến mãi hết hạn hoặc không có
                $sanpham->discountAmount = 0;
                $sanpham->increasedProductName = null;
            }
        } else {
            // Nếu không có khuyến mãi cho sản phẩm
            $sanpham->discountAmount = 0;
            $sanpham->increasedProductName = null;
        }

        // Lấy các sản phẩm liên quan (cùng loại)
        $relatedProducts = SanPham::whereHas('loaisp', function ($query) use ($sanpham) {
            $query->whereIn('loaisp.idloai', $sanpham->loaisp->pluck('idloai')->toArray());
        })
            ->where('idsp', '!=', $sanpham->idsp)  // Loại trừ sản phẩm hiện tại
            ->limit(5)  // Giới hạn số lượng sản phẩm liên quan
            ->get();

        // Kiểm tra khuyến mãi cho các sản phẩm liên quan
        foreach ($relatedProducts as $product) {
            $chiTietKhuyenMai = ChiTietKhuyenMai::where('idsp', $product->idsp)->first();
            if ($chiTietKhuyenMai) {
                $khuyenMai = KhuyenMai::find($chiTietKhuyenMai->idkm);
                if ($khuyenMai && $khuyenMai->trangthai == 1) {
                    // Kiểm tra loại khuyến mãi
                    if ($khuyenMai->loaikm === 'giamtien') {
                        $product->discountAmount = $khuyenMai->noidungkm;  // Giảm giá theo số tiền
                    } elseif ($khuyenMai->loaikm === 'giamthanhtien') {
                        $product->increasedProductName = $khuyenMai->tenkm;  // Tặng sản phẩm hoặc giảm giá theo tổng tiền
                    }
                } else {
                    $product->discountAmount = 0;
                    $product->increasedProductName = null;
                }
            } else {
                $product->discountAmount = 0;
                $product->increasedProductName = null;
            }
        }

        // Lấy danh sách loại sản phẩm
        $LoaiSP = LoaiSP::withCount('sanpham')->get();

        // Lấy bình luận của sản phẩm
        $binhluans = BinhLuan::where('idsp', $idsp)
            ->latest('ngay_binhluan')  // Sắp xếp theo ngày bình luận mới nhất
            ->paginate(5);  // Giới hạn 5 bình luận và tạo phân trang

        // Tính trung bình số sao
        $averageRating = BinhLuan::where('idsp', $idsp)->avg('rating');
        $averageRating = round($averageRating, 1); // Làm tròn 1 chữ số thập phân

        // Trả về view với các thông tin cần thiết
        return view('user.ds_SanPham.detail_product', compact('sanpham', 'relatedProducts', 'binhluans', 'LoaiSP', 'averageRating'));
    }


    public function create()
    {
        $LoaiSP = loaisp::all();
        return view('admin.SanPham.create', compact('LoaiSP'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:255|unique:sanpham,tensp',
            'gia' => 'required|numeric|min:1000|regex:/^\d+000$/',
            'dvt' => 'required|string|max:50/',
            'xuatxu' => 'required|string|max:100/',
            'mota' => 'required|string',
            'handoitra' => 'required|numeric|min:0|max:7',
            'hinh' => 'required|array',
            'hinh.*' => 'image|mimes:jpg,jpeg,png,gif|max:5120',
            'idloai' => 'required',
        ], [
            'ten.required' => 'Phải nhập tên sản phẩm',
            'ten.unique' => 'Tên sản phẩm đã tồn tại, bạn hãy nhập tên sản phẩm khác',

            'gia.required' => 'Phải nhập giá sản phẩm',
            'gia.regex' => 'Giá phải chia hết cho 1000',

            'dvt.required' => 'Phải nhập đơn vị tính sản phẩm',

            'xuatxu.required' => 'Phải nhập xuất xứ sản phẩm',

            'mota.required' => 'Phải nhập mô tả sản phẩm',

            'handoitra.required' => 'Phải nhập hạn đổi trả',
            'handoitra.numeric' => 'Hạn đổi trả phải là số',
            'handoitra.min' => 'Hạn đổi trả không được nhỏ hơn 0',
            'handoitra.max' => 'Hạn đổi trả không được lớn hơn 7',

            'hinh.required' => 'Hãy chọn ít nhất một tệp.',
            'hinh.*.image' => 'Tệp phải là hình ảnh (jpg, jpeg, png, gif).',
            'hinh.*.mimes' => 'Chỉ cho phép các định dạng tệp jpg, jpeg, png, gif.',
            'hinh.*.max' => 'Kích thước tệp không được vượt quá 2MB.',

            'idloai.required' => 'Phải chọn ít nhất một loại sản phẩm.',
        ]);
        // dd($request);
        $product = SanPham::create([
            'tensp' => $request->ten,
            'mota' => $request->mota,
            'gia' => $request->gia,
            'donvitinh' => $request->dvt,
            'xuatxu' => $request->xuatxu,
            'handoitra' => $request->handoitra,
            'soluong' => $request->soluong,
            'soluong' => $request->soluong ?? 0, // Nếu không có giá trị thì mặc định là 0
            'trangthai' => 0,
        ]);


        // Save product images
        if ($request->hasFile('hinh')) {
            $i = 1; // Số tự tăng bắt đầu từ 1
            foreach ($request->file('hinh') as $file) {
                $originalName = $file->getClientOriginalName();
                $imageName = 'Image_' . $i . '_' . $originalName; // Tạo tên tệp với tiền tố 'Image_' và số tự tăng

                // Kiểm tra xem tệp có tồn tại hay không, nếu có thì tăng số
                while (file_exists(public_path('imgsp/' . $imageName))) {
                    $i++;
                    $imageName = 'Image_' . $i . '_' . $originalName; // Tạo tên tệp mới nếu bị trùng
                }

                // Di chuyển tệp vào thư mục 'imgsp'
                $file->move(public_path('imgsp'), $imageName);

                // Lưu thông tin hình ảnh vào cơ sở dữ liệu
                Anh::create([
                    'idsp' => $product->idsp,
                    'tenanh' => $imageName
                ]);

                $i++; // Tăng số tự tăng cho lần lặp tiếp theo
            }
        }


        if ($request->has('idloai')) {
            foreach ($request->idloai as $idloai) {
                $product->loaisp()->attach($idloai); // Gán loại sản phẩm vào bảng phụ
            }
        }

        return redirect()->back()->with('success', 'Bạn đã thêm sản phẩm thành công');
    }

    public function edit($id)
    {
        // Lấy sản phẩm theo ID
        $product = SanPham::with('Anh')->findOrFail($id);

        $loaiSP = LoaiSP::all(); // Lấy tất cả loại sản phẩm

        return view('admin.SanPham.edit', compact('product', 'loaiSP'));
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu ở đây
        $request->validate(
            [
                'tensp' => 'required|string|max:255',
                'mota' => 'required|string',
                'gia' => 'required|numeric|min:0',
                'donvitinh' => 'required|string|max:50',
                'xuatxu' => 'required|string|max:100',
                'soluong' => 'required|integer|min:0',
                'handoitra' => 'required|numeric|min:0|max:7',
                'idloai' => 'required|array',
                'hinh.*' => 'image|mimes:jpg,jpeg,png,gif|max:5120',
                'idloai' => 'required',
            ],
            [
                'ten.required' => 'Phải nhập tên sản phẩm',
                'ten.unique' => 'Tên sản phẩm đã tồn tại, bạn hãy nhập tên sản phẩm khác',
                'ten.regex' => 'Chữ đầu của tên sản phẩm phải viết hoa',

                'gia.required' => 'Phải nhập giá sản phẩm',
                'gia.regex' => 'Giá phải chia hết cho 1000',

                'dvt.required' => 'Phải nhập đơn vị tính sản phẩm',
                'dvt.regex' => 'Chữ đầu của đơn vị tính phải viết hoa',

                'xuatxu.required' => 'Phải nhập xuất xứ sản phẩm',
                'xuatxu.regex' => 'Chữ đầu của xuất xứ phải viết hoa',

                'mota.required' => 'Phải nhập mô tả sản phẩm',

                'handoitra.required' => 'Phải nhập hạn đổi trả',
                'handoitra.numeric' => 'Hạn đổi trả phải là số',
                'handoitra.min' => 'Hạn đổi trả không được nhỏ hơn 0',
                'handoitra.max' => 'Hạn đổi trả không được lớn hơn 7',

                'soluong.required' => 'Phải nhập số lượng sản phẩm',
                'soluong.integer' => 'Số lượng phải là số nguyên',
                'soluong.min' => 'Số lượng không thể nhỏ hơn 0',

                'hinh.required' => 'Hãy chọn ít nhất một tệp.',
                'hinh.*.image' => 'Tệp phải là hình ảnh (jpg, jpeg, png, gif).',
                'hinh.*.mimes' => 'Chỉ cho phép các định dạng tệp jpg, jpeg, png, gif.',
                'hinh.*.max' => 'Kích thước tệp không được vượt quá 5MB.',

                'idloai.required' => 'Phải chọn ít nhất một loại sản phẩm.',
            ]
        );
        // dd($request->imagecheck);
        if ($request->has('imagecheck')) {
            foreach ($request->imagecheck as $imageId) {
                $image = Anh::find($imageId);
                if ($image) {
                    // Xóa tệp hình ảnh từ hệ thống
                    Storage::delete('imgsp/' . $image->filename);
                    // Xóa bản ghi trong cơ sở dữ liệu
                    $image->delete();
                }
            }
        }

        // Lấy sản phẩm theo ID
        $product = SanPham::findOrFail($id);

        // Cập nhật thông tin sản phẩm
        $product->update($request->except('idloai', 'hinh'));

        // Cập nhật loại sản phẩm
        $product->loaisp()->sync($request->idloai);

        // Cập nhật hình ảnh
        if ($request->hasFile('hinh')) {
            foreach ($request->file('hinh') as $file) {
                $imageName = 'image_' . time() . '_' . $file->getClientOriginalName(); // Đặt tên file với tiền tố
                $file->move(public_path('imgsp'), $imageName);

                // Lưu thông tin hình ảnh vào bảng Anh
                Anh::create([
                    'idsp' => $product->idsp,
                    'tenanh' => $imageName // Cung cấp giá trị cho trường tenanh
                ]);
            }
        }



        return redirect()->route('admin.SanPham.admin_index')->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    public function sphh_index(Request $request)
    {
        // Kiểm tra nếu có filter theo ngày
        $dateFilter = $request->input('date_filter');

        // Nếu có filter theo ngày, lọc theo ngày đó, nếu không lấy tất cả dữ liệu
        $query = SpHetHan::query();

        if ($dateFilter) {
            // Chuyển đổi date string thành Carbon object
            $date = Carbon::parse($dateFilter)->format('Y-m-d');
            $query->whereDate('ngayhh', $date);
        }

        // Sắp xếp theo ngày hết hạn từ mới về cũ (giảm dần)
        $query->orderBy('ngayhh', 'desc');

        // Lấy danh sách từ bảng sphethan với phân trang 10 dòng 1 trang
        $sphethan = $query->with('sanPham')->paginate(10);

        // Trả về view và truyền dữ liệu vào
        return view('admin.SpHetHan.index', compact('sphethan', 'dateFilter'));
    }

    public function quantity_index(Request $request)
    {
        // Lấy từ khóa tìm kiếm và các tùy chọn sắp xếp từ yêu cầu
        $searchTerm = $request->input('search');
        $field = $request->input('field', 'tensp'); // Trường tìm kiếm mặc định
        $sortField = $request->input('sort_field', 'idsp'); // Trường sắp xếp mặc định
        $sortOrder = $request->input('sort', 'desc'); // Thứ tự sắp xếp mặc định
        $idloai = $request->input('idloai');

        // Xác thực thứ tự sắp xếp
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc'; // Mặc định là sắp xếp giảm dần nếu không hợp lệ
        }

        // Định nghĩa các trường sắp xếp hợp lệ để tránh lỗi SQL
        $validSortFields = ['idsp', 'tensp', 'gia', 'xuatxu'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'idsp'; // Mặc định là 'idsp' nếu không hợp lệ
        }

        // Lấy sản phẩm với tìm kiếm, sắp xếp và phân trang
        $products = SanPham::with('anh') // Tải trước mối quan hệ 'anh'
            ->when($searchTerm, function ($query) use ($searchTerm, $field) {
                // Kiểm tra nếu trường là 'idsp' để so khớp chính xác
                if ($field === 'idsp') {
                    return $query->where($field, '=', $searchTerm);
                } else {
                    // Đối với các trường khác, sử dụng so khớp một phần
                    return $query->where($field, 'LIKE', "%{$searchTerm}%");
                }
            })
            // Kiểm tra idloai để lọc sản phẩm theo loại, nhưng không áp dụng nếu idloai là null
            ->when($idloai, function ($query) use ($idloai) {
                $query->whereExists(function ($subQuery) use ($idloai) {
                    $subQuery->select(DB::raw(1))
                        ->from('loaisp')
                        ->join('sanpham_loaisp', 'loaisp.idloai', '=', 'sanpham_loaisp.idloai')
                        ->whereColumn('sanpham.idsp', 'sanpham_loaisp.idsp')
                        ->where('loaisp.idloai', $idloai);
                });
            })
            ->orderBy($sortField, $sortOrder) // Áp dụng sắp xếp chỉ khi sortField hợp lệ
            ->get();
        // ->paginate(6); // Đặt số lượng sản phẩm trên mỗi trang
        $LoaiSP = LoaiSP::withCount('sanpham')->get();
        // Trả về view với danh sách sản phẩm
        return view('admin.SoLuong.index', compact('products', 'LoaiSP'));
    }

    public function quantity_update(Request $request)
    {
        // Xử lý trừ số lượng
        foreach ($request->idsp as $index => $idsp) {
            $sanpham = SanPham::find($idsp);
            if ($sanpham) {
                $newQuantity = $sanpham->soluong - $request->soluong[$index];
                if ($newQuantity >= 0) {
                    $sanpham->soluong = $newQuantity;
                    $sanpham->save();
                } else {
                    return redirect()->route('admin.SanPham.quantity_index')->withErrors('Bạn đã trừ quá số lượng ' . $sanpham->tensp);
                }
            }
        }

        return redirect()->route('admin.SanPham.quantity_index')->with('success', 'Cập nhật số lượng thành công');
    }

    public function resetQuantity($id)
    {
        $product = SanPham::find($id);

        if ($product) {
            // Cập nhật số lượng sản phẩm thành 0
            $product->soluong = 0;
            $product->save();

            // Trả về thông báo thành công
            return redirect()->route('admin.SanPham.quantity_index')->with('success', 'Số lượng sản phẩm đã được đặt thành 0.');
        }

        // Nếu không tìm thấy sản phẩm
        return redirect()->route('admin.SanPham.quantity_index')->with('error', 'Không tìm thấy sản phẩm.');
    }
}
