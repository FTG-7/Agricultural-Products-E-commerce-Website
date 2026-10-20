<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Token;
use App\Models\ChiTietKhuyenMai;
use App\Models\admin\KhuyenMai;
use App\Models\Diachi;
use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\SanPham;
use App\Services\DistanceService;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ThanhToanController extends Controller
{
    //
    // Hiển thị form tạo đơn hàng
    public function create()
    {
        $user = Auth::user();

        // Kiểm tra giỏ hàng của người dùng
        $cartItems = GioHang::where('idtk', $user->idtk)->get();

        // Lọc các sản phẩm có số lượng yêu cầu vượt quá số lượng còn lại
        $insufficientStockItems = $cartItems->filter(function ($item) {
            return $item->soluong > $item->sanpham->soluong; // Nếu số lượng yêu cầu > số lượng còn lại
        });

        // Nếu có sản phẩm không đủ số lượng, tạo thông báo
        if ($insufficientStockItems->isNotEmpty()) {
            $insufficientStockDetails = $insufficientStockItems->map(function ($item) {
                return $item->sanpham->tensp . " (Còn " . $item->sanpham->soluong . " sản phẩm)";
            })->implode(', ');

            // Chuyển thông báo lỗi và danh sách sản phẩm không đủ số lượng vào view
            return view('user.MuaHang.cart', compact('cartItems', 'insufficientStockDetails'));
        }

        // Lấy danh sách tỉnh
        $vietnamProvinces = json_decode(file_get_contents(public_path('tinh.json')));

        // Mặc định là TP Hồ Chí Minh
        $defaultProvinceId = 2; // ID của TP Hồ Chí Minh
        $districts = json_decode(file_get_contents(public_path('quan.json')));
        $wards = json_decode(file_get_contents(public_path('phuong.json')));

        // Lọc quận theo tỉnh TP Hồ Chí Minh
        $filteredDistricts = array_filter($districts, function ($district) use ($defaultProvinceId) {
            return $district->ProvinceId == $defaultProvinceId;
        });

        usort($filteredDistricts, function ($a, $b) {
            return strcmp($a->Name, $b->Name);
        });

        // Lấy danh sách địa chỉ của người dùng và chọn địa chỉ có loại là 1
        $diaChiList = DiaChi::where('idtk', $user->idtk)->get();
        $diaChiMacDinh = DiaChi::where('idtk', $user->idtk)->where('loai', 1)->first();

        return view('user.MuaHang.createorder', compact('user', 'diaChiList', 'diaChiMacDinh', 'vietnamProvinces', 'filteredDistricts', 'wards'));
    }

    // Xác nhận đơn hàng
    public function confirm(Request $request, DistanceService $distanceService)
    {
        $errors = [];

        $validPrefixes = [
            '086',
            '096',
            '097',
            '098',
            '039',
            '038',
            '037',
            '036',
            '035',
            '034',
            '033',
            '032',
            '091',
            '094',
            '088',
            '083',
            '084',
            '085',
            '081',
            '082',
            '070',
            '079',
            '077',
            '076',
            '078',
            '089',
            '090',
            '093',
            '092',
            '052',
            '056',
            '058',
            '099',
            '059'
        ];

        // Lấy thông tin từ form
        $addressMethod = $request->input('address_method');
        $tennhan = $request->input('tennhan');
        $sdt = $request->input('sdt');
        $ghichu = $request->input('ghichu');
        $pttt = $request->input('pttt');

        //Xử lý địa chỉ
        if ($addressMethod === 'select') {
            $diachigiao = $request->input('diachigiaods'); // Lấy giá trị địa chỉ từ dropdown
        } elseif ($addressMethod === 'enter') {
            $diachigiao = $request->input('diachigiao'); // Lấy địa chỉ nhập mới
            $quan = $request->input('quan');
            $phuong = $request->input('phuong');
            $duong = $request->input('duong');
            $sonha = $request->input('sonha');

            // Kiểm tra trường 'quan'
            if (empty($quan)) {
                $errors['quan'] = 'Hãy chọn quận';
            }

            // Kiểm tra trường 'phuong'
            if (empty($phuong)) {
                $errors['phuong'] = 'Hãy chọn phường';
            }

            // Kiểm tra trường 'duong'
            if (empty($duong)) {
                $errors['duong'] = 'Hãy nhập tên đường';
            } elseif (strlen($duong) > 255) {
                $errors['duong'] = 'Tên đường không được vượt quá 255 ký tự';
            }

            // Kiểm tra trường 'sonha'
            if (empty($sonha)) {
                $errors['sonha'] = 'Hãy nhập số nhà';
            } elseif (!preg_match('/^[0-9]+(\/[0-9]+)*$/', $sonha)) {
                $errors['sonha'] = 'Số nhà phải là một số hợp lệ (ví dụ: 328 hoặc 328/1 hoặc 47/2/57/33)';
            }
        }

        // Kiểm tra dữ liệu nhập vào
        if (empty($tennhan)) {
            $errors['tennhan'] = 'Hãy nhập tên người nhận';
        }

        if (empty($sdt)) {
            $errors['sdt'] = 'Hãy nhập số điện thoại';
        } elseif (strlen($sdt) !== 10) {
            $errors['sdt'] = 'Số điện thoại phải có 10 chữ số';
        } elseif (!preg_match('/^(' . implode('|', $validPrefixes) . ')\d{7}$/', $sdt)) {
            $errors['sdt'] = 'Số điện thoại không hợp lệ';
        }

        if (empty($pttt)) {
            $errors['pttt'] = 'Hãy chọn phương thức thanh toán';
        }

        // Nếu có lỗi, trả về form với thông báo lỗi
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Địa chỉ cố định (ví dụ: kho hàng hoặc cửa hàng)
        $origin = '140 Đ. Lê Trọng Tấn, Tây Thạnh, Tân Phú, Hồ Chí Minh';

        // Tính khoảng cách từ địa chỉ cố định đến địa chỉ người nhận
        $distance = $distanceService->getDrivingDistance($origin, $diachigiao);
        // Kiểm tra ngày hiện tại có phải ngày đặc biệt không
        $today = now()->format('d/m');
        $specialDates = ['06/10', '02/02', '03/03', '04/04', '05/05', '06/06', '07/07', '08/08', '09/09', '10/10', '11/11', '12/12']; // Các ngày đặc biệt
        $freeShippingLimit = in_array($today, $specialDates) ? 15 : 2; // Miễn phí trong 15km nếu là ngày đặc biệt

        // Tính phí vận chuyển
        $shippingCost = 0;
        if ($distance > $freeShippingLimit) {
            // Điều chỉnh bắt đầu tính phí từ 15km nếu là ngày đặc biệt
            if (in_array($today, $specialDates)) {
                $shippingCost = $distanceService->calculateShippingCost($distance - 13); // Trừ 13 vì vd: 17-13 = 4, 15-13= 2
            } else {
                $shippingCost = $distanceService->calculateShippingCost($distance);
            }
        }

        $idtk = Auth::id();
        $cartItems = GioHang::with('sanpham.Anh')->where('idtk', $idtk)->get();

        $totalCart = $cartItems->sum(function ($gioHang) {
            return $gioHang->dongia * $gioHang->soluong;
        });

        $totalBill = $totalCart + $shippingCost;

        // Lưu thông tin đơn hàng vào session
        $request->session()->put('order', [
            'tennhan' => $tennhan,
            'diachigiao' => $diachigiao,
            'sdt' => $sdt,
            'ghichu' => $ghichu,
            'pttt' => $pttt,
            'totalCart' => $totalCart,
            'totalBill' => $totalBill,
            'shippingCost' => $shippingCost,
            'distance' => $distance,
            'cartItems' => $cartItems,
            'addressMethod' => $addressMethod,
        ]);
        // Chuyển sang trang xác nhận đơn hàng
        return redirect()->route('order.review');
    }

    // Hiển thị trang xác nhận đơn hàng
    public function review()
    {
        $orderData = session('order');
        // dd($orderData);
        if (!$orderData) {
            return redirect()->route('order.create')->with('error', 'Không tìm thấy thông tin đơn hàng.');
        }

        $idtk = Auth::id();
        $cartItems = GioHang::with('sanpham.Anh')->where('idtk', $idtk)->get();

        $totalBill = 0;
        // dd($cartItems);
        foreach ($cartItems as $sp) {
            $chiTietKhuyenMai = ChiTietKhuyenMai::where('idsp', $sp->idsp)->first();

            // Khởi tạo biến cho các thông tin giảm giá và tăng hàng
            $sp->setDiscountAmountAttribute(0); // Mặc định không có giảm giá
            $sp->setIncreasedProductNameAttribute(null); // Mặc định không có sản phẩm tăng
            $sp->setPromoNameAttribute(null); // Mặc định không có tên khuyến mãi
            $sp->setPromoContentAttribute(null); // Mặc định không có nội dung khuyến mãi
            $sp->setPromoConditionAttribute(null); // Mặc định không có điều kiện khuyến mãi

            if ($chiTietKhuyenMai) {
                // Kiểm tra loại khuyến mãi
                $khuyenMai = KhuyenMai::find($chiTietKhuyenMai->idkm);

                if ($khuyenMai) {
                    // Nếu khuyến mãi đang hoạt động
                    if ($khuyenMai->trangthai == 1) {
                        if ($khuyenMai->loaikm === 'giamtien') {
                            // Lưu số giảm vào biến
                            $sp->setDiscountAmountAttribute($khuyenMai->noidungkm); // Số tiền giảm
                        } elseif ($khuyenMai->loaikm === 'giamthanhtien') {
                            // Lưu thông tin khuyến mãi: tên khuyến mãi, nội dung khuyến mãi, và điều kiện khuyến mãi
                            $sp->setPromoNameAttribute($khuyenMai->tenkm); // Lưu tên khuyến mãi
                            $sp->setPromoContentAttribute($khuyenMai->noidungkm); // Lưu nội dung khuyến mãi
                            $sp->setPromoConditionAttribute($khuyenMai->dieukien); // Lưu điều kiện khuyến mãi
                        }
                    }
                }
            }
            // Tính toán giá trị itemTotal dựa trên khuyến mãi và giảm giá
            if ($sp->promoName && $sp->promoCondition) {
                // Tính số lượng theo điều kiện khuyến mãi
                $quantityPromo = intdiv($sp->soluong, $sp->promoCondition); // Số nhóm đủ điều kiện
                $remainingQuantity = $sp->soluong % $sp->promoCondition; // Số sản phẩm còn lại không áp dụng khuyến mãi

                // Tính tổng tiền của nhóm khuyến mãi và không khuyến mãi
                $promoTotal = $quantityPromo * $sp->promoCondition * ((100 - $sp->promoContent) / 100) * $sp->dongia;
                $nonPromoTotal = $remainingQuantity * $sp->dongia;

                // Tổng tiền của sản phẩm
                $itemTotal = $promoTotal + $nonPromoTotal;
            } elseif ($sp->discountAmount > 0) {
                // Tính tổng tiền với giảm giá phần trăm
                $itemTotal = ($sp->dongia * (1 - $sp->discountAmount / 100)) * $sp->soluong;
            } else {
                // Tính tổng tiền bình thường
                $itemTotal = $sp->dongia * $sp->soluong;
            }

            // Cộng dồn tổng tiền
            $totalBill += $itemTotal;

            // Cập nhật giá trị giảm giá cho sản phẩm trong giỏ hàng
            $discountedPrice = $sp->dongia * (1 - $sp->discountAmount / 100);
            $cartItems->where('idsp', $sp->idsp)->first()->setAttribute('dongia', $discountedPrice);

            // Lưu tổng tiền của sản phẩm vào giỏ hàng
            $cartItems->where('idsp', $sp->idsp)->first()->setAttribute('itemTotal', $itemTotal);
        }



        session([
            'order.cartItems' => $cartItems,
            'order.totalBill' => $totalBill,
        ]);

        return view('user.MuaHang.orderreview', [
            'tennhan' => $orderData['tennhan'],
            'diachigiao' => $orderData['diachigiao'],
            'sdt' => $orderData['sdt'],
            'ghichu' => $orderData['ghichu'],
            'pttt' => $orderData['pttt'],

            'totalBill' => $totalBill,
            'shippingCost' => $orderData['shippingCost'],
            'distance' => $orderData['distance'],
            'cartItems' => $cartItems,
        ]);
    }



    // Lưu thông tin đơn hàng
    public function store(Request $request)
    {
        $orderData = $request->session()->get('order');
        if (!$orderData) {
            return redirect()->route('notify')->with('error', 'Đơn Hàng Đã Tồn Tại.');
        }
        // Lưu thông tin đơn hàng
        $donHang = DonHang::create([
            'idtk' => Auth::id(),
            'tennhan' => $orderData['tennhan'],
            'diachigiao' => $orderData['diachigiao'],
            'sdt' => $orderData['sdt'],
            'ghichu' => $orderData['ghichu'],
            'pttt' => $orderData['pttt'],
            'tongtien' => $orderData['totalBill'] + $orderData['shippingCost'],
            'ttthanhtoan' => 0,
            'trangthai' => 'Chờ xác nhận',
            'ngaydat' => now(),
        ]);
        // Lưu chi tiết đơn hàng
        foreach ($orderData['cartItems'] as $item) {
            DB::table('chitietdonhang')->insert([
                'iddh' => $donHang->iddh,
                'idsp' => $item->idsp,
                'tensp' => $item->sanpham->tensp,
                'soluong' => $item->soluong,
                'gia' => $item->dongia,
                'tong' => $item->itemTotal,
            ]);

            // Trừ số lượng sản phẩm trong bảng sanpham
            $sanPham = SanPham::find($item['idsp']);
            if ($sanPham) {
                $sanPham->soluong -= $item['soluong'];
                if ($sanPham->soluong < 0) {
                    $sanPham->soluong = 0; // Đảm bảo không âm
                }
                $sanPham->save();
            }
        }

        $addressMethod = $orderData['addressMethod'];
        if ($addressMethod === 'enter') {
            // Kiểm tra xem địa chỉ đã tồn tại trong danh sách địa chỉ của khách hàng chưa
            $existingAddress = Diachi::where('idtk', Auth::user()->idtk)
                ->where('diachi', $orderData['diachigiao'])
                ->first();

            if (!$existingAddress) {
                // Kiểm tra xem địa chỉ có phải là địa chỉ đầu tiên của tài khoản không
                $isFirstAddress = Diachi::where('idtk', Auth::user()->idtk)->count() === 0;

                // Xác định loại địa chỉ
                $loai = $isFirstAddress ? '1' : '0';

                // Nếu địa chỉ chưa tồn tại, thêm vào
                Diachi::create([
                    'idtk' => Auth::user()->idtk,
                    'diachi' => $orderData['diachigiao'],
                    'loai' => $loai, // Giả sử bạn đã định nghĩa biến $loai ở đâu đó
                ]);
            }
        }

        // Xóa giỏ hàng sau khi đơn hàng được xác nhận
        GioHang::where('idtk', Auth::id())->delete();
        $email = Auth::user()->email;
        // Gửi email thông báo đơn hàng đã được tạo
        Mail::send('emails.order_confirmation', [
            'name' => $orderData['tennhan'],
            'orderData' => $orderData,
        ], function ($message) use ($email) {
            $message->to($email)
                ->subject('Xác Nhận Đơn Hàng của Bạn');
        });

        // Xóa thông tin đơn hàng trong session
        $request->session()->forget('order');

        // Chuyển hướng đến trang hoàn thành đơn hàng
        return redirect()->route('order.success');
    }

    public function success()
    {
        return view('user.MuaHang.success');
    }

    public function vnpay_payment(Request $request)
    {
        // dd($request);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('order.store_online');
        $vnp_TmnCode = 'H3Y1JYVJ'; //Mã website tại VNPAY 
        $vnp_HashSecret = 'IHQSZJ076R889NMKRTSUJU3JZ7NNOZBX'; //Chuỗi bí mật

        $vnp_TxnRef = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        // $vnp_TxnRef = '101'; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $request->input('tennhan');
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->input('total') * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];


        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );

        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function store_online(Request $request)
    {
        // Lấy thông tin từ request
        $responseCode = $request->input('vnp_ResponseCode');
        $orderData = $request->session()->get('order');
        $payDate = $request->input('vnp_PayDate'); // Lấy payDate từ request
        // Kiểm tra mã phản hồi
        if ($responseCode === '00') {

            // Giải mã payDate từ định dạng "YYYYMMDDHHMMSS"
            $payDateFormatted = Carbon::createFromFormat('YmdHis', $payDate);

            // Nếu giao dịch thành công, lưu thông tin đơn hàng
            $donHang = DonHang::create([
                'idtk' => Auth::id(),
                'tennhan' => $orderData['tennhan'],
                'diachigiao' => $orderData['diachigiao'],
                'sdt' => $orderData['sdt'],
                'ghichu' => $orderData['ghichu'],
                'pttt' => $orderData['pttt'], // phương thức thanh toán
                'tongtien' => $orderData['totalBill'] + $orderData['shippingCost'],
                'ttthanhtoan' => 1, // Đặt ttthanhtoan là 1
                'trangthai' => 'Chờ xác nhận',
                'ngaydat' => $payDateFormatted, // Gán thời gian đã giải mã vào ngaydat
            ]);

            // Lưu chi tiết đơn hàng
            foreach ($orderData['cartItems'] as $item) {
                DB::table('chitietdonhang')->insert([
                    'iddh' => $donHang->iddh,
                    'idsp' => $item->idsp,
                    'tensp' => $item->sanpham->tensp,
                    'soluong' => $item->soluong,
                    'gia' => $item->dongia,
                    'tong' => $item->itemTotal,
                ]);

                // Trừ số lượng sản phẩm trong bảng sanpham
                $sanPham = SanPham::find($item['idsp']);
                if ($sanPham) {
                    $sanPham->soluong -= $item['soluong'];
                    if ($sanPham->soluong < 0) {
                        $sanPham->soluong = 0; // Đảm bảo không âm
                    }
                    $sanPham->save();
                }
            }

            // Kiểm tra địa chỉ giao hàng
            $addressMethod = $orderData['addressMethod'];
            if ($addressMethod === 'enter') {
                // Kiểm tra xem địa chỉ đã tồn tại trong danh sách địa chỉ của khách hàng chưa
                $existingAddress = Diachi::where('idtk', Auth::user()->idtk)
                    ->where('diachi', $orderData['diachigiao'])
                    ->first();

                if (!$existingAddress) {
                    // Kiểm tra xem địa chỉ có phải là địa chỉ đầu tiên của tài khoản không
                    $isFirstAddress = Diachi::where('idtk', Auth::user()->idtk)->count() === 0;

                    // Xác định loại địa chỉ
                    $loai = $isFirstAddress ? '1' : '0';

                    // Nếu địa chỉ chưa tồn tại, thêm vào
                    Diachi::create([
                        'idtk' => Auth::user()->idtk,
                        'diachi' => $orderData['diachigiao'],
                        'loai' => $loai, // Giả sử bạn đã định nghĩa biến $loai ở đâu đó
                    ]);
                }
            }

            // Xóa giỏ hàng sau khi đơn hàng được xác nhận
            GioHang::where('idtk', Auth::id())->delete();

            $email = Auth::user()->email;
            // Gửi email thông báo đơn hàng đã được tạo
            Mail::send('emails.order_confirmation', [
                'name' => $orderData['tennhan'],
                'orderData' => $orderData,
            ], function ($message) use ($email) {
                $message->to($email)
                    ->subject('Xác Nhận Đơn Hàng của Bạn');
            });

            // Xóa thông tin đơn hàng trong session
            $request->session()->forget('order');

            // Chuyển hướng đến trang hoàn thành đơn hàng
            return redirect()->route('order.success');
        } else {
            // Nếu giao dịch không thành công, có thể xử lý thông báo lỗi
            return redirect()->route('order.create')->with('error', 'Thanh toán online thất bại !!!');
        }
    }
}
