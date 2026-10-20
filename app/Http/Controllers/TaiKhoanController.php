<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Token;
use App\Models\Diachi;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Infobip\Api\Client;
use Infobip\Configuration;
// use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class TaiKhoanController extends Controller
{
    // Hàm tạo mật khẩu ngẫu nhiên đáp ứng các yêu cầu
    public function generatePassword()
    {
        // Khai báo chuỗi ký tự chứa các ký tự in hoa, in thường, số và ký tự đặc biệt
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Chữ cái in hoa (A-Z)
        $lowercase = 'abcdefghijklmnopqrstuvwxyz'; // Chữ cái in thường (a-z)
        $numbers = '0123456789'; // Các chữ số (0-9)
        $specialChars = '!@#$%^&*()'; // Các ký tự đặc biệt (!, @, #, $, %, ^, &, *, ())

        // Khởi tạo biến mật khẩu là chuỗi rỗng
        $password = '';

        // Thêm một ký tự in hoa ngẫu nhiên vào mật khẩu
        $password .= $uppercase[rand(0, strlen($uppercase) - 1)];

        // Thêm một chữ số ngẫu nhiên vào mật khẩu
        $password .= $numbers[rand(0, strlen($numbers) - 1)];

        // Thêm một ký tự đặc biệt ngẫu nhiên vào mật khẩu
        $password .= $specialChars[rand(0, strlen($specialChars) - 1)];

        // Tạo chuỗi chứa tất cả các loại ký tự để bổ sung vào mật khẩu
        $remainingChars = $uppercase . $lowercase . $numbers . $specialChars;

        // Thực hiện vòng lặp để bổ sung thêm các ký tự ngẫu nhiên cho mật khẩu
        for ($i = 3; $i < 8; $i++) { // Lặp từ 3 đến 7 để đảm bảo mật khẩu có ít nhất 8 ký tự
            $password .= $remainingChars[rand(0, strlen($remainingChars) - 1)];
        }

        // Xáo trộn các ký tự trong mật khẩu và trả về kết quả
        return str_shuffle($password);
    }

    public function showregister()
    {
        return view('user.TaiKhoan.register');
    }

    public function register(Request $request)
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

        // Xác thực tên
        $hoten = $request->input('hoten');
        if (empty($hoten)) {
            $errors['hoten'] = 'Hãy nhập họ và tên';
        } elseif ($hoten !== ucwords(strtolower($hoten))) {
            $errors['hoten'] = 'Chữ cái đầu của mỗi từ trong họ và tên phải viết hoa';
        } elseif (!preg_match("/^[\p{L}\s]+$/u", $hoten)) {
            $errors['hoten'] = 'Họ và tên chỉ được chứa chữ cái và khoảng trắng';
        }

        // Xác thực email
        $email = $request->input('email');
        if (empty($email)) {
            $errors['email'] = 'Hãy nhập email';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        } elseif (User::where(DB::raw('BINARY email'), $email)->exists()) {
            $errors['email'] = 'Email đã tồn tại';
        }

        // Xác thực giới tính
        $gioitinh = $request->input('gioitinh');
        if (empty($request->input('gioitinh'))) {
            $errors['gioitinh'] = 'Hãy chọn giới tính';
        }

        $quyen = $request->input('quyen');
        // Xác thực ngày sinh
        $ngaysinh = $request->input('ngaysinh');
        if (empty($ngaysinh)) {
            $errors['ngaysinh'] = 'Hãy chọn ngày sinh';
        } else {
            $ngaysinhTimestamp = strtotime($ngaysinh);
            $currentDateTimestamp = strtotime(date("Y-m-d"));

            if ($ngaysinhTimestamp > $currentDateTimestamp) {
                $errors['ngaysinh'] = 'Ngày sinh không được lớn hơn ngày hiện tại';
            } else {
                // Tính toán tuổi người dùng
                $ngaysinhDate = new DateTime($ngaysinh);
                $currentDate = new DateTime(); // Ngày hiện tại
                $age = $currentDate->diff($ngaysinhDate)->y;

                // Kiểm tra người dùng có ít nhất 15 tuổi
                if ($quyen == 'nv' && $age < 18) {
                    $errors['ngaysinh'] = 'Nhân viên phải từ 18 tuổi trở lên';
                } elseif ($age < 15) {
                    $errors['ngaysinh'] = 'Người dùng phải lớn hơn 15 tuổi';
                }
            }
        }

        // Xác thực số điện thoại
        $sdt = $request->input('sdt');
        if (empty($sdt)) {
            $errors['sdt'] = 'Hãy nhập số điện thoại';
        } elseif (strlen($sdt) !== 10) {
            $errors['sdt'] = 'Số điện thoại phải có 10 chữ số';
        } elseif (!preg_match('/^(' . implode('|', $validPrefixes) . ')\d{7}$/', $sdt)) {
            $errors['sdt'] = 'Số điện thoại không hợp lệ';
        } elseif (User::where('sdt', $sdt)->exists()) {
            $errors['sdt'] = 'Số điện thoại đã tồn tại';
        }

        // Nếu quyền là 'nv', tự động tạo mật khẩu ngẫu nhiên thỏa các điều kiện
        if ($quyen === 'nv') {
            $password = $this->generatePassword();
            $passcf = $password;
        } else {
            // Xác thực mật khẩu do người dùng nhập
            $password = $request->input('password');
            if (empty($password)) {
                $errors['password'] = 'Hãy nhập mật khẩu';
            } elseif (strlen($password) < 8) {
                $errors['password'] = 'Mật khẩu phải có ít nhất 8 ký tự';
            } elseif (!preg_match('/[A-Z]/', $password)) {
                $errors['password'] = 'Mật khẩu phải có ít nhất một ký tự viết hoa';
            } elseif (!preg_match('/[0-9]/', $password)) {
                $errors['password'] = 'Mật khẩu phải có ít nhất một chữ số';
            } elseif (!preg_match('/[\W_]/', $password)) {
                $errors['password'] = 'Mật khẩu phải có ít nhất một ký tự đặc biệt';
            }

            // Xác thực xác nhận mật khẩu
            $passcf = $request->input('passcf');
            if (empty($passcf)) {
                $errors['passcf'] = 'Hãy nhập lại mật khẩu';
            } elseif ($password !== $passcf) {
                $errors['passcf'] = 'Mật khẩu nhập lại không khớp';
            }
        }

        // Nếu có lỗi, trả về trang đăng ký cùng với thông báo lỗi
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $activationToken = Str::random(60);
        // Tạo người dùng mới
        $userData = [
            'hoten' => $hoten,
            'email' => $email,
            'gioitinh' => $gioitinh,
            'ngaysinh' => $ngaysinh,
            'sdt' => $sdt,
            'dsden' => $request->input('dsden'),
            'password' => bcrypt($password), // Mã hóa mật khẩu
            'quyen' => $quyen, // Thêm quyền nếu cần
            'trangthai' => 0, // Trạng thái chưa kích hoạt
        ];
        $user = User::create($userData);

        // Lưu token vào bảng tokens
        Token::create([
            'idtk' => $user->idtk, // Lưu idtk nếu có
            'token' => $activationToken,
            'loai' => 'kichhoat',
            'hethan' => now()->addMinutes(60), // Token có thời gian sống là 60 phút
        ]);

        // Gửi email xác nhận
        Mail::send('emails.verify-account', [
            'token' => $activationToken,
            'name' => $userData['hoten'],
            'password' => $password,
            'quyen' => $userData['quyen']
        ], function ($message) use ($request) {
            $message->to($request->input('email'))
                ->subject('Kích hoạt tài khoản SunFresh');
        });

        if ($quyen === 'nv') {
            return redirect()->route('admin.NhanVien.index');
        }
        // Chuyển hướng đến trang đăng nhập hoặc trang nào đó sau khi đăng ký thành công
        return view('user.news-status')->with('message', 'Hãy vào kiểm tra mail để kích hoạt tài khoản!');
    }

    public function activateAccount($token)
    {
        // Tìm token trong bảng tokens
        $tokenRecord = Token::where('token', $token)
            ->where('loai', 'kichhoat')
            ->where('hethan', '>', now())
            ->first();

        if (!$tokenRecord) {
            return redirect()->route('show-login')->with('error', 'Token không hợp lệ hoặc đã hết hạn.');
        }

        // Lưu thông tin người dùng vào bảng taikhoan
        $user = User::find($tokenRecord->idtk);

        if ($user) {
            $user->trangthai = 1; // Đánh dấu tài khoản đã được kích hoạt
            $user->save();

            // Xóa token sau khi kích hoạt thành công
            $tokenRecord->delete();

            return view('user.news-status')->with('message', 'Tài khoản của bạn đã được kích hoạt thành công hãy đăng nhập!');
        }

        return redirect()->route('show-login')->with('error', 'Không tìm thấy thông tin người dùng.');
    }


    public function showresendActivationEmail()
    {
        return view('user.TaiKhoan.resendactivation');
    }

    public function resendActivationEmail(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user || $user->trangthai === 1) {
            return redirect()->back()->with('error', 'Tài khoản không tồn tại hoặc đã được kích hoạt.');
        }

        // Kiểm tra xem có token nào gần đây không
        $recentToken = Token::where('idtk', $user->idtk)
            ->where('loai', 'kichhoat')
            ->orderBy('created_at', 'desc')
            ->first();

        // Nếu đã gửi token gần đây và chưa đến 60 phút, thông báo cho người dùng
        if ($recentToken && $recentToken->hethan > now()) {
            return redirect()->back()->with('error', 'Bạn vui lòng chờ thêm trước khi yêu cầu gửi lại email kích hoạt.');
        }

        // Tạo lại token và gửi lại email
        $activationToken = Str::random(60);
        Token::create([
            'idtk' => $user->idtk, // Lưu idtk
            'token' => $activationToken,
            'loai' => 'kichhoat',
            'hethan' => now()->addMinutes(60), // Token có thời gian sống là 60 phút
        ]);

        // Gửi email xác nhận
        Mail::send('emails.verify-account', ['token' => $activationToken, 'name' => $user->hoten], function ($message) use ($request) {
            $message->to($request->input('email'))
                ->subject('Kích hoạt tài khoản SunFresh');
        });
        return view('user.news-status')->with('message', 'Email kích hoạt đã được gửi lại. Vui lòng kiểm tra hộp thư của bạn.');
    }

    public function showlogin()
    {
        return view('user.TaiKhoan.login');
    }

    public function login(Request $request)
    {
        // Lấy giá trị email và password từ request
        $credentials = $request->only('email', 'password');

        // Kiểm tra xem tài khoản có tồn tại không
        $user = User::where('email', $credentials['email'])->first();

        // Kiểm tra xem tài khoản có tồn tại
        if ($user) {
            // Kiểm tra dsden
            if ($user->dsden === 1) {
                // Chuyển hướng về trang login với thông báo lỗi
                return redirect()->route('show-login')->with(['error' => 'Tài Khoản của Bạn đã bị khóa! Bạn không được phép truy cập.'])->withInput();
            }

            // Nếu tài khoản chưa được kích hoạt
            if ($user->trangthai !== 1) {
                return redirect()->route('show-login')->with(['error' => 'Tài khoản chưa được kích hoạt.'])->withInput();
            }

            // Kiểm tra xác thực thông tin đăng nhập
            if (Auth::attempt($credentials)) {
                // Đăng nhập thành công
                session(['user' => $user]);

                // Phân hướng dựa trên quyền
                if ($user->quyen === 'admin') {
                    return redirect()->route('admin.ThongKe.index');
                } elseif ($user->quyen === 'nv') {
                    return redirect()->route('nv.QLDonHang.shipindex');
                } elseif ($user->quyen === 'kh') {
                    return redirect()->route('index');
                }
            } else {
                // Nếu xác thực không thành công
                return redirect()->route('show-login')->with(['error' => 'Thông tin đăng nhập không chính xác.'])->withInput();
            }
        }

        // Nếu tài khoản không tồn tại
        return redirect()->route('show-login')->with(['error' => 'Thông tin đăng nhập không tồn tại.'])->withInput();
    }



    public function logout()
    {
        Auth::logout();
        session()->forget('user'); // Xóa thông tin người dùng từ session (nếu có)
        return redirect()->route('show-login');
    }

    //========================================================================================================
    public function showprofile()
    {

        // dd(session()->all());
        // if (Auth::check()) {
        //     // Kiểm tra thông tin người dùng
        $userss = session('user');
        //dd($user); // Xem thông tin người dùng

        // }
        // return view('user.TaiKhoan.profile');
        // Lấy người dùng hiện tại
        // $user = Auth::user();
        // dd($user);
        if ($userss) {
            // Lấy ID của người dùng
            $userId = $userss->idtk;

            // Truy vấn thông tin người dùng từ bảng users
            $user = User::where('idtk', $userId)->first();
            if ($user) {
                return view('user.TaiKhoan.profile', compact('user'));
            } else {
                return redirect()->route('show-login')->with('error', 'Người dùng không tồn tại.');
            }
        }
        return redirect()->route('show-login')->with('error', 'Bạn cần phải đăng nhập.');
    }
    public function profile(Request $request)
    {
        $errors = [];
        $user = User::find(\auth()->id());

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

        // Xác thực tên
        $hoten = $request->input('hoten');
        // dd($hoten);
        if (empty($hoten)) {
            $errors['hoten'] = 'Hãy nhập họ và tên';
        } elseif ($hoten !== ucwords(strtolower($hoten))) {
            $errors['hoten'] = 'Chữ cái đầu của mỗi từ trong họ và tên phải viết hoa';
        } elseif (!preg_match("/^[\p{L}\s]+$/u", $hoten)) {
            $errors['hoten'] = 'Họ và tên chỉ được chứa chữ cái và khoảng trắng';
        }

        // Xác thực giới tính
        $gioitinh = $request->input('gioitinh');
        if (empty($request->input('gioitinh'))) {
            $errors['gioitinh'] = 'Hãy chọn giới tính';
        }

        // Xác thực ngày sinh
        $ngaysinh = $request->input('ngaysinh');
        if (empty($ngaysinh)) {
            $errors['ngaysinh'] = 'Hãy chọn ngày sinh';
        } else {
            $ngaysinhTimestamp = strtotime($ngaysinh);
            $currentDateTimestamp = strtotime(date("Y-m-d"));

            if ($ngaysinhTimestamp > $currentDateTimestamp) {
                $errors['ngaysinh'] = 'Ngày sinh không được lớn hơn ngày hiện tại';
            } else {
                // Tính toán tuổi người dùng
                $ngaysinhDate = new DateTime($ngaysinh);
                $currentDate = new DateTime(); // Ngày hiện tại
                $age = $currentDate->diff($ngaysinhDate)->y;

                // Kiểm tra người dùng có ít nhất 15 tuổi
                if ($age < 15) {
                    $errors['ngaysinh'] = 'Người dùng phải lớn hơn 15 tuổi';
                }
            }
        }

        $sdt = $request->input('sdt');
        if (empty($sdt)) {
            $errors['sdt'] = 'Hãy nhập số điện thoại';
        } elseif (strlen($sdt) !== 10) {
            $errors['sdt'] = 'Số điện thoại phải có 10 chữ số';
        } elseif (!preg_match('/^(' . implode('|', $validPrefixes) . ')\d{7}$/', $sdt)) {
            $errors['sdt'] = 'Số điện thoại không hợp lệ';
        } elseif ($sdt !== $user->sdt && User::where('sdt', $sdt)->exists()) { // Kiểm tra nếu số điện thoại đã tồn tại
            $errors['sdt'] = 'Số điện thoại đã tồn tại';
        }

        // Nếu có lỗi, trả về trang đăng ký cùng với thông báo lỗi
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }


        // Sửa người dùng mới
        $user->update([
            'hoten' => $hoten,
            'gioitinh' => $gioitinh,
            'ngaysinh' => $ngaysinh,
            'sdt' => $sdt,
        ]);

        // Chuyển hướng đến trang đăng nhập hoặc trang nào đó sau khi đăng ký thành công
        return redirect()->route('show-profile');
    }

    //========================================================================================================
    public function showchangepassword()
    {
        return view('user.TaiKhoan.changepassword');
    }

    public function changepassword(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $newpassword = $request->input('newpassword');
        $cfnewpassword = $request->input('cfnewpassword');
        $errors = [];

        if (empty($email)) {
            $errors['email'] = 'Hãy nhập mật khẩu';
        }
        if (empty($password)) {
            $errors['password'] = 'Hãy nhập mật khẩu';
        }

        if (!empty($errors)) {
            return redirect()->route('show_changepassword')->with(['error' => 'Hãy nhập email và mật khẩu']);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::find(\auth()->id());
            if (empty($newpassword)) {
                $errors['newpassword'] = 'Hãy nhập mật khẩu';
            } elseif (strlen($newpassword) < 8) {
                $errors['newpassword'] = 'Mật khẩu phải có ít nhất 8 ký tự';
            } elseif (!preg_match('/[A-Z]/', $newpassword)) {
                $errors['newpassword'] = 'Mật khẩu phải có ít nhất một ký tự viết hoa';
            } elseif (!preg_match('/[0-9]/', $newpassword)) {
                $errors['newpassword'] = 'Mật khẩu phải có ít nhất một chữ số';
            } elseif (!preg_match('/[\W_]/', $newpassword)) {
                $errors['newpassword'] = 'Mật khẩu phải có ít nhất một ký tự đặc biệt';
            }

            // Xác thực xác nhận mật khẩu
            if (empty($cfnewpassword)) {
                $errors['newpasscf'] = 'Hãy nhập lại mật khẩu';
            } elseif ($newpassword !== $cfnewpassword) {
                $errors['newpasscf'] = 'Mật khẩu nhập lại không khớp';
            }

            // Nếu có lỗi, trả về trang đăng ký cùng với thông báo lỗi
            if (!empty($errors)) {
                return redirect()->route('show_changepassword')->withErrors($errors)->withInput();
            } else {
                // Sửa người dùng mới
                $user->update([
                    'password' => bcrypt($newpassword),
                ]);

                return redirect()->route('show-profile');
            }
        } else {
            // Nếu xác thực không thành công, bạn có thể xử lý lỗi ở đây
            return redirect()->route('show_changepassword')->with(['error' => 'Thông tin đăng nhập không chính xác']);
        }
    }

    //========================================================================================================
    public function showForgotPasswordForm()
    {
        return view('user.TaiKhoan.forgotpassword');
    }

    public function sendResetPasswordEmail(Request $request)
    {
        // Kiểm tra email có tồn tại không
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email không tồn tại trong hệ thống.');
        }

        // Tạo token reset mật khẩu
        $resetToken = Str::random(60);
        Token::create([
            'idtk' => $user->idtk,
            'token' => $resetToken,
            'loai' => 'quenmk',
            'hethan' => now()->addMinutes(60), // Token sẽ hết hạn sau 60 phút
        ]);

        // Gửi email reset mật khẩu
        Mail::send('emails.reset-password', ['token' => $resetToken, 'name' => $user->hoten], function ($message) use ($request) {
            $message->to($request->input('email'))
                ->subject('Yêu cầu đặt lại mật khẩu');
        });

        return redirect()->back()->with('message', 'Email đặt lại mật khẩu đã được gửi. Vui lòng kiểm tra hộp thư của bạn.');
    }

    public function showResetPasswordForm($token)
    {
        // Kiểm tra token có hợp lệ và chưa hết hạn
        $tokenRecord = Token::where('token', $token)
            ->where('loai', 'quenmk')
            ->where('hethan', '>', now())
            ->first();
        if (!$tokenRecord) {
            return redirect()->route('show-forgot-password')->with('error', 'Token không hợp lệ hoặc đã hết hạn.');
        }

        return view('user.TaiKhoan.resetpassword', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        // Kiểm tra token
        $tokenRecord = Token::where('token', $request->input('token'))
            ->where('loai', 'quenmk')
            ->where('hethan', '>', now())
            ->first();

        if (!$tokenRecord) {
            return redirect()->route('show-reset-password-form', ['token' => $request->input('token')])->with('error', 'Token không hợp lệ hoặc đã hết hạn.');
        }

        $errors = [];
        // Xác thực mật khẩu
        $password = $request->input('password');
        if (empty($password)) {
            $errors['password'] = 'Hãy nhập mật khẩu';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 8 ký tự';
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $errors['password'] = 'Mật khẩu phải có ít nhất một ký tự viết hoa';
        } elseif (!preg_match('/[0-9]/', $password)) {
            $errors['password'] = 'Mật khẩu phải có ít nhất một chữ số';
        } elseif (!preg_match('/[\W_]/', $password)) {
            $errors['password'] = 'Mật khẩu phải có ít nhất một ký tự đặc biệt';
        }

        $passcf = $request->input('passcf');
        if (empty($passcf)) {
            $errors['passcf'] = 'Hãy nhập lại mật khẩu';
        } elseif ($password !== $passcf) {
            $errors['passcf'] = 'Mật khẩu nhập lại không khớp';
        }

        // Nếu có lỗi, trả về thông báo lỗi
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Cập nhật mật khẩu mới cho người dùng
        $user = User::where('idtk', $tokenRecord->idtk)->first();
        $user->password = bcrypt($request->input('password'));
        $user->save();

        // Xóa token sau khi reset mật khẩu thành công
        $tokenRecord->delete();

        return redirect()->route('show-login')->with('message', 'Mật khẩu của bạn đã được đặt lại thành công.');
    }

    //========================================================================================================
    // Hiển thị danh sách địa chỉ của người dùng
    public function indexaddress()
    {
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

        $addresses = Diachi::where('idtk', Auth::user()->idtk)->get();
        return view('user.TaiKhoan.address', compact('vietnamProvinces', 'filteredDistricts', 'wards', 'defaultProvinceId', 'addresses'));
        // Lấy các địa chỉ của người dùng hiện tại
    }

    // Lưu địa chỉ mới
    public function storeaddress(Request $request)
    {
        // Khởi tạo mảng lỗi
        $errors = [];

        // Kiểm tra dữ liệu nhập
        $diachi = $request->input('diachi');
        $loai = $request->input('loai');
        $quan = $request->input('quan');
        $phuong = $request->input('phuong');
        $duong = $request->input('duong');
        $sonha = $request->input('sonha');

        // Kiểm tra trường 'diachi'
        if (empty($diachi)) {
            $errors['diachi'] = 'Hãy nhập địa chỉ';
        }

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

        // Nếu có lỗi, trả về thông báo lỗi
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Kiểm tra xem địa chỉ có phải là địa chỉ đầu tiên của tài khoản không
        $isFirstAddress = Diachi::where('idtk', Auth::user()->idtk)->count() === 0;

        // Xác định loại địa chỉ
        $loai = $isFirstAddress ? '1' : '0';

        // Tạo địa chỉ mới
        Diachi::create([
            'idtk' => Auth::user()->idtk,
            'diachi' => $request->input('diachi'),
            'loai' => $loai,
        ]);

        return redirect()->route('address.index')->with('success', 'Địa chỉ đã được thêm thành công.');
    }

    // Xóa địa chỉ
    public function destroyaddress($iddc)
    {
        // Tìm địa chỉ theo id và id tài khoản người dùng
        $diachi = Diachi::where('iddc', $iddc)->where('idtk', Auth::user()->idtk)->firstOrFail();

        // Kiểm tra nếu địa chỉ có 'loai' là 1 (mặc định)
        if ($diachi->loai == 1) {
            // Tìm địa chỉ tiếp theo của người dùng để đặt làm mặc định
            $diachiKhac = Diachi::where('idtk', Auth::user()->idtk)
                ->where('iddc', '!=', $iddc) // Không phải địa chỉ đang xóa
                ->first();

            // Nếu tìm thấy địa chỉ khác, đặt nó làm mặc định
            if ($diachiKhac) {
                $diachiKhac->loai = 1; // Đặt 'loai' là 1 cho địa chỉ mới
                $diachiKhac->save();
            }
        }

        // Xóa địa chỉ hiện tại
        $diachi->delete();

        return redirect()->route('address.index');
    }

    // Chuyển địa chỉ thành mặc định
    public function setDefaultaddress($iddc)
    {
        // Lấy idtk của người dùng hiện tại
        $idtk = Auth::user()->idtk;

        // Đặt tất cả các địa chỉ của người dùng thành 'bt' (bình thường)
        Diachi::where('idtk', $idtk)->update(['loai' => '0']);

        // Đặt địa chỉ được chọn thành 'md' (mặc định)
        $diachi = Diachi::where('iddc', $iddc)->where('idtk', $idtk)->firstOrFail();
        $diachi->loai = 1;
        $diachi->save();

        return redirect()->route('address.index');
    }

    //Khách Hàng
    public function show_CustomerAndLockedCustomer(Request $request)
    {
        // Lấy từ khóa tìm kiếm và các tùy chọn sắp xếp từ yêu cầu
        $searchTerm = $request->input('search');
        $field = $request->input('field', 'hoten'); // Mặc định tìm theo trường 'hoten'
        $sortField = $request->input('sort_field', 'idtk'); // Trường mặc định để sắp xếp
        $sortOrder = $request->input('sort', 'desc'); // Mặc định sắp xếp giảm dần
        $nlock = $request->input('nlock', 0);

        // Kiểm tra nếu sortOrder hợp lệ
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc'; // Giá trị mặc định
        }

        // Kiểm tra các tham số tìm kiếm và sắp xếp cho trường thứ 2 (nếu có)
        $searchTerm1 = $request->input('search1');
        $field1 = $request->input('field1', 'hoten'); // Mặc định tìm theo trường 'hoten'
        $sortField1 = $request->input('sort_field1', 'idtk'); // Trường mặc định để sắp xếp
        $sortOrder1 = $request->input('sort1', 'desc'); // Mặc định sắp xếp giảm dần

        // Kiểm tra nếu sortOrder1 hợp lệ
        if (!in_array($sortOrder1, ['asc', 'desc'])) {
            $sortOrder1 = 'desc'; // Giá trị mặc định
        }

        // Lấy tất cả người dùng có quyền là 'kh' và trạng thái không bị khóa (dsden = 0)
        $customers = $this->getCustomerByStatus(0, $searchTerm, $field, $sortField, $sortOrder);

        // Lấy tất cả khách hàng có quyền là 'kh' và trạng thái bị khóa (dsden = 1)
        $lock_customers = $this->getCustomerByStatus(1, $searchTerm1, $field1, $sortField1, $sortOrder1);

        // Trả về view với cả hai danh sách
        return view('admin.KhachHang.index', compact('customers', 'lock_customers'));
    }

    private function getCustomerByStatus($dsden, $searchTerm, $field, $sortField, $sortOrder)
    {
        // Danh sách các trường có thể sắp xếp
        $validSortFields = ['idtk', 'hoten', 'gioitinh', 'ngaysinh'];

        // Kiểm tra nếu sortField có trong danh sách các trường hợp lệ
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'idtk'; // Giá trị mặc định
        }

        return User::where('dsden', $dsden)
            ->when($searchTerm, function ($query) use ($searchTerm, $field) {
                // Tìm kiếm chính xác hoặc tương đối cho các trường
                if ($field === 'idtk') {
                    // Tìm kiếm chính xác cho trường 'idtk'
                    return $query->where($field, '=', $searchTerm);
                } else {
                    // Tìm kiếm tương đối cho các trường khác
                    return $query->where($field, 'LIKE', "%{$searchTerm}%");
                }
            })
            ->where('quyen', 'kh')
            ->orderBy($sortField, $sortOrder)
            ->get();
    }

    public function lock_Customer($id)
    {
        // Tìm khách hàng dựa trên idtk
        $customer = User::find($id);

        // Kiểm tra nếu tìm thấy khách hàng
        if ($customer) {
            // Cập nhật cột dsden (0 là unlock, 1 là lock)
            $customer->dsden = 1; // 1 là trạng thái 'lock'
            $customer->save();

            // Chuyển hướng về trang danh sách khách hàng với thông báo thành công
            return redirect()->route('admin.KhachHang.index')->with('success', 'Khách hàng đã bị khóa.');
        }

        // Trường hợp không tìm thấy khách hàng
        return redirect()->route('admin.KhachHang.index')->with('error', 'Không tìm thấy khách hàng.');
    }

    public function unlock_Customer($id)
    {
        // Tìm khách hàng dựa trên idtk
        $customer = User::find($id);

        // Kiểm tra nếu tìm thấy khách hàng
        if ($customer) {
            // Cập nhật cột dsden (0 là unlock, 1 là lock)
            $customer->dsden = 0; // 0 là trạng thái 'unlock'
            $customer->save();

            // Chuyển hướng về trang danh sách khách hàng với thông báo thành công
            return redirect()->route('admin.KhachHang.index')->with('success', 'Khách hàng đã được mở khóa.');
        }

        // Trường hợp không tìm thấy khách hàng
        return redirect()->route('admin.KhachHang.index')->with('error', 'Không tìm thấy khách hàng.');
    }


    //Nhân Viên
    public function show_StaffAndLockedStaff(Request $request)
    {
        $searchTerm = $request->input('search');
        $field = $request->input('field', 'hoten'); // Mặc định tìm theo trường 'tennhan'
        $sortField = $request->input('sort_field', 'idtk'); // Trường mặc định để sắp xếp
        $sortOrder = $request->input('sort', 'desc'); // Mặc định sắp xếp giảm dần
        $nlock = $request->input('nlock', 0);

        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc'; // Giá trị mặc định
        }

        $searchTerm1 = $request->input('search1');
        $field1 = $request->input('field1', 'hoten'); // Mặc định tìm theo trường 'tennhan'
        $sortField1 = $request->input('sort_field1', 'idtk'); // Trường mặc định để sắp xếp
        $sortOrder1 = $request->input('sort1', 'desc'); // Mặc định sắp xếp giảm dần

        if (!in_array($sortOrder1, ['asc', 'desc'])) {
            $sortOrder1 = 'asc'; // Giá trị mặc định
        }

        $lock = $request->input('lock', 1);

        // Lấy tất cả người dùng không bị khóa (dsden = 0)
        $staffs = $this->getStaffByStatus($nlock, $searchTerm, $field, $sortField, $sortOrder);

        // Lấy tất cả người dùng bị khóa (dsden = 1)
        $lock_staffs = $this->getStaffByStatus($lock, $searchTerm1, $field1, $sortField1, $sortOrder1);

        // Trả về view với cả hai danh sách
        return view('admin.NhanVien.index', compact('staffs', 'lock_staffs'));
    }

    private function getStaffByStatus($dsden, $searchTerm, $field, $sortField, $sortOrder)
    {
        // Danh sách các trường có thể sắp xếp
        $validSortFields = ['idtk', 'hoten', 'gioitinh', 'ngaysinh'];

        // Kiểm tra nếu sortField có trong danh sách các trường hợp lệ
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'idtk'; // Giá trị mặc định
        }

        return User::where('dsden', $dsden)
            ->when($searchTerm, function ($query) use ($searchTerm, $field) {
                // Tìm kiếm chính xác hoặc tương đối cho các trường
                if ($field === 'idtk') {
                    // Tìm kiếm chính xác cho trường 'idtk'
                    return $query->where($field, '=', $searchTerm);
                } else {
                    // Tìm kiếm tương đối cho các trường khác
                    return $query->where($field, 'LIKE', "%{$searchTerm}%");
                }
            })
            ->whereIn('quyen', ['nv', 'admin'])
            ->orderBy($sortField, $sortOrder)
            ->get();
    }

    public function show_AdminAndStaff(Request $request)
    {
        // Các thông tin sắp xếp và tìm kiếm cho Admin
        $searchTerm = $request->input('search');
        $field = $request->input('field', 'hoten'); // Mặc định tìm theo trường 'tennhan'
        $sortField = $request->input('sort_field', 'idtk'); // Trường mặc định để sắp xếp
        $sortOrder = $request->input('sort', 'desc'); // Mặc định sắp xếp giảm dần
        $roleAdmin = $request->input('roleAdmin', 'admin');

        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc'; // Giá trị mặc định
        }

        // Các thông tin sắp xếp và tìm kiếm cho Nhân viên
        $searchTerm1 = $request->input('search1');
        $field1 = $request->input('field1', 'hoten'); // Mặc định tìm theo trường 'hoten'
        $sortField1 = $request->input('sort_field1', 'idtk'); // Trường mặc định để sắp xếp
        $sortOrder1 = $request->input('sort1', 'desc'); // Mặc định sắp xếp giảm dần
        $roleStaff = $request->input('roleStaff', 'nv');

        if (!in_array($sortOrder1, ['asc', 'desc'])) {
            $sortOrder1 = 'desc'; // Giá trị mặc định
        }

        // Lấy danh sách Admin
        $admins = $this->getStaffByRole($roleAdmin, $searchTerm, $field, $sortField, $sortOrder);

        // Lấy danh sách Nhân viên
        $staffs = $this->getStaffByRole($roleStaff, $searchTerm1, $field1, $sortField1, $sortOrder1);

        // Trả về view với cả hai danh sách Admin và Nhân viên
        return view('admin.Admin.index', compact('admins', 'staffs'));
    }

    private function getStaffByRole($role, $searchTerm, $field, $sortField, $sortOrder)
    {
        // Danh sách các trường có thể sắp xếp
        $validSortFields = ['idtk', 'hoten', 'gioitinh', 'ngaysinh'];

        // Kiểm tra nếu sortField có trong danh sách các trường hợp lệ
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'idtk'; // Giá trị mặc định
        }

        return User::where('quyen', $role)
            ->when($searchTerm, function ($query) use ($searchTerm, $field) {
                // Tìm kiếm chính xác hoặc tương đối cho các trường
                if ($field === 'idtk') {
                    // Tìm kiếm chính xác cho trường 'idtk'
                    return $query->where($field, '=', $searchTerm);
                } else {
                    // Tìm kiếm tương đối cho các trường khác
                    return $query->where($field, 'LIKE', "%{$searchTerm}%");
                }
            })
            ->orderBy($sortField, $sortOrder)
            ->get();
    }

    public function grant_Admin($id)
    {
        // Tìm khách hàng dựa trên idtk
        $admin = User::find($id);

        // Kiểm tra nếu tìm thấy khách hàng
        if ($admin) {
            // Cập nhật cột dsden (0 là unlock, 1 là lock)
            $admin->quyen = "admin"; // 1 là trạng thái 'lock'
            $admin->save();

            // Chuyển hướng về trang danh sách khách hàng với thông báo thành công
            return redirect()->route('admin.Admin.index')->with('success', 'Gán Quản Lý Thành Công.');
        }

        // Trường hợp không tìm thấy khách hàng
        return redirect()->route('admin.Admin.index')->with('error', 'Gán Không Thành Công.');
    }


    public function revoke_Admin($id)
    {
        // Tìm khách hàng dựa trên idtk
        $admin = User::find($id);

        // Kiểm tra nếu tìm thấy khách hàng
        if ($admin) {
            // Cập nhật cột dsden (0 là unlock, 1 là lock)
            $admin->quyen = "nv"; // 1 là trạng thái 'lock'
            $admin->save();

            // Chuyển hướng về trang danh sách khách hàng với thông báo thành công
            return redirect()->route('admin.Admin.index')->with('success', 'Gán Quản Lý Thành Công.');
        }

        // Trường hợp không tìm thấy khách hàng
        return redirect()->route('admin.Admin.index')->with('error', 'Gán Không Thành Công.');
    }


    public function lock_Staff($id)
    {
        // Tìm khách hàng dựa trên idtk
        $staff = User::find($id);

        // Kiểm tra nếu tìm thấy khách hàng
        if ($staff) {
            // Cập nhật cột dsden (0 là unlock, 1 là lock)
            $staff->dsden = 1; // 1 là trạng thái 'lock'
            $staff->save();

            // Chuyển hướng về trang danh sách khách hàng với thông báo thành công
            return redirect()->route('admin.NhanVien.index')->with('success', 'Khách hàng đã bị khóa.');
        }

        // Trường hợp không tìm thấy khách hàng
        return redirect()->route('admin.NhanVien.index')->with('error', 'Không tìm thấy khách hàng.');
    }

    public function unlock_Staff($id)
    {
        // Tìm khách hàng dựa trên idtk
        $staff = User::find($id);

        // Kiểm tra nếu tìm thấy khách hàng
        if ($staff) {
            // Cập nhật cột dsden (0 là unlock, 1 là lock)
            $staff->dsden = 0; // 0 là trạng thái 'unlock'
            $staff->save();

            // Chuyển hướng về trang danh sách khách hàng với thông báo thành công
            return redirect()->route('admin.NhanVien.index')->with('success', 'Khách hàng đã được mở khóa.');
        }

        // Trường hợp không tìm thấy khách hàng
        return redirect()->route('admin.NhanVien.index')->with('error', 'Không tìm thấy khách hàng.');
    }

    public function showPhone()
    {
        return view('user.TaiKhoan.phone');
    }

    public function sendOtp(Request $request)
    {
        $errors = [];
        $phone = $request->input('sdt');

        if (empty($phone)) {
            $errors['sdt'] = 'Hãy nhập số điện thoại';
        }

        // Kiểm tra định dạng số điện thoại
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

        if (strlen($phone) !== 10) {
            $errors['sdt'] = 'Số điện thoại phải có 10 chữ số';
        } elseif (!preg_match('/^(' . implode('|', $validPrefixes) . ')\d{7}$/', $phone)) {
            $errors['sdt'] = 'Số điện thoại không hợp lệ';
        }

        // Kiểm tra số điện thoại đã tồn tại
        if (User::where('sdt', $phone)->exists()) {
            $errors['sdt'] = 'Số điện thoại đã được sử dụng';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Lưu số điện thoại vào session để xác nhận sau
        session(['phone' => $phone]);

        // Tạo mã OTP ngẫu nhiên
        $otpCode = rand(100000, 999999);
        session(['otp_code' => $otpCode]);

        // Chuyển đổi số điện thoại sang định dạng quốc tế nếu cần
        $internationalPhone = '+84' . substr($phone, 1); // +84 là mã quốc gia của Việt Nam

        // Chuyển hướng đến trang hiển thị form nhập OTP
        return redirect()->route('phone.show-otp-form');
    }

    public function showOtpForm()
    {
        return view('user.TaiKhoan.otp');
    }

    public function verifyOtp(Request $request)
    {
        $otpCode = session('otp_code');
        $inputOtp = $request->input('otp_code');

        $errors = [];
        if (empty($inputOtp)) {
            $errors['otp_code'] = 'Hãy nhập OTP';
        } elseif (!preg_match('/^\d{6}$/', $inputOtp)) {  // Kiểm tra chỉ có đúng 6 chữ số
            $errors['otp_code'] = 'OTP phải chứa chính xác 6 chữ số';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        if ($otpCode && $otpCode == $inputOtp) {
            session()->forget('otp_code');

            // Cập nhật số điện thoại trong bảng taikhoan
            $phone = session('phone');
            $user = User::find(\auth()->id());
            $user->sdt = $phone; // Đánh dấu tài khoản đã được kích hoạt
            $user->save();

            return redirect()->route('show-profile');
        }

        return redirect()->route('phone.show-otp-form')->with(['error' => 'Mã OTP không chính xác.']);
    }

    public function showMailChange()
    {
        return view('user.TaiKhoan.mailchange');
    }

    public function requestEmailChange(Request $request)
    {
        $user = Auth::user(); // Lấy người dùng hiện tại
        $newEmail = $request->input('email'); // Email mới
        $errors = [];
        // Xác thực email
        if (empty($newEmail)) {
            $errors['email'] = 'Hãy nhập email';
        } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        } elseif (User::where(DB::raw('BINARY email'), $newEmail)->exists()) {
            $errors['email'] = 'Email đã tồn tại';
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        // Kiểm tra xem có token nào gần đây không
        // $recentToken = Token::where('idtk', $user->idtk)
        //     ->where('loai', 'doimail')
        //     ->orderBy('created_at', 'desc')
        //     ->first();

        // // Nếu đã gửi token gần đây và chưa đến 60 phút, thông báo cho người dùng
        // if ($recentToken && $recentToken->hethan > now()) {
        //     if ($recentToken->created_at->diffInMinutes(now()) < 10) {
        //         return redirect()->back()->with('error', 'Bạn vui lòng chờ thêm trước khi yêu cầu sửa email.');
        //     }
        // }

        // Tạo token cho email mới, thời gian sống là 30 phút
        $newEmailToken = Str::random(64);
        Token::create([
            'idtk' => $user->idtk,
            'token' => $newEmailToken,
            'loai' => 'doimail',
            'hethan' => now()->addMinutes(30), // 30 phút
        ]);

        // Gửi email xác nhận đến email mới
        Mail::send('emails.confirm-new-email', ['token' => $newEmailToken, 'newEmail' => $newEmail, 'name' => $user->hoten], function ($message) use ($newEmail) {
            $message->to($newEmail)
                ->subject('Xác nhận mail mới');
        });

        // Tạo token cho email cũ, thời gian sống là 1 tuần
        $oldEmailToken = Str::random(64);
        Token::create([
            'idtk' => $user->idtk,
            'token' => $oldEmailToken,
            'loai' => 'doimail',
            'hethan' => now()->addWeek(), // 1 tuần
        ]);

        // Gửi email xác nhận đến email cũ
        Mail::send('emails.confirm-old-email', ['token' => $oldEmailToken, 'oldEmail' => $user->email, 'name' => $user->hoten], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Email SunFresh bị thay đổi');
        });

        return redirect()->back()->with('message', 'Hãy vào mail để xác nhận mail mới');
    }

    public function confirmNewEmail($token)
    {
        // Tìm token trong bảng tokens
        $tokenData = Token::where('token', $token)
            ->where('loai', 'doimail')
            ->where('hethan', '>', now())
            ->first();

        if (!$tokenData) {
            return view('user.news-status')->with('error', 'Token không hợp lệ hoặc đã hết hạn.');
        }

        $newEmail = request()->query('email'); // Lấy email mới từ URL
        $user = User::find($tokenData->idtk);

        if ($user && $newEmail) {
            // Cập nhật email mới
            $user->update(['email' => $newEmail]);
            $tokenData->delete();
            return view('user.news-status')->with('message', 'Gmail của bạn đã được cập nhật');
        }

        return view('confirm-new-email')->with('message', null);
    }

    public function confirmOldEmail($token)
    {
        // Tìm token trong bảng tokens
        $tokenData = Token::where('token', $token)
            ->where('loai', 'doimail')
            ->where('hethan', '>', now())
            ->first();

        if (!$tokenData) {
            return view('user.news-status')->with('error', 'Token không hợp lệ hoặc đã hết hạn.');
        }

        $oldEmail = request()->query('email'); // Lấy email cũ từ URL
        $user = User::find($tokenData->idtk);

        if ($user && $oldEmail) {
            // Khôi phục email cũ
            $user->update(['email' => $oldEmail]);

            // Xóa token hiện tại và token của email mới
            Token::where('idtk', $user->idtk)
                ->where('loai', 'doimail')
                ->delete();

            return view('user.news-status')->with('message', 'Gmail của bạn đã được khôi phục');
        }

        return view('confirm-old-email')->with('message', null);
    }

    public function notify()
    {
        return view('user.news-status');
    }
}
