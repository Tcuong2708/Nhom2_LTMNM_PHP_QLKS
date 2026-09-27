<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\OTPVerification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Đăng nhập text thường theo yêu cầu
        $account = Account::where('TenDangNhap', $request->username)
                          ->where('MatKhau', $request->password)
                          ->first();

        if ($account) {
            if ($account->TrangThai == 0) {
                return back()->with('error', 'Tài khoản đang bị vô hiệu hóa.');
            }

            Auth::login($account, $request->has('remember'));
            
            // Nếu là Admin (1) hoặc Lễ tân (2), trỏ thẳng vào trang quản lý
            if ($account->RoleID == 1 || $account->RoleID == 2) {
                return redirect('/staff/room-map');
            }
            
            return redirect('/');
        }

        return back()->with('error', 'Thông tin đăng nhập không chính xác.')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        $request->validate([
            'HoTen' => 'required|string|max:255',
            'SoDienThoai' => 'required|string|max:15',
            'Email' => 'required|email|max:255',
            'MatKhau' => 'required|string|min:6|confirmed',
            'captcha' => 'required|numeric',
        ], [
            'MatKhau.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'captcha.required' => 'Vui lòng nhập kết quả phép toán.'
        ]);

        // Validate Captcha
        $correctCaptcha = session('captcha_answer');
        if ($request->captcha != $correctCaptcha) {
            return back()->with('error', 'Mã Captcha không chính xác!')->withInput();
        }

        // Validate Email/Phone in DB
        $exists = Account::where('Email', $request->Email)
                         ->orWhere('SoDienThoai', $request->SoDienThoai)
                         ->exists();
        if ($exists) {
            return back()->with('error', 'Tài khoản đã tồn tại. Vui lòng đăng nhập hoặc sử dụng thông tin khác!')->withInput();
        }

        // Generate OTP
        $otpCode = rand(100000, 999999);
        $expireTime = Carbon::now()->addMinutes(5);

        // Save OTP to DB
        OTPVerification::updateOrCreate(
            ['Email' => $request->Email],
            [
                'OTPCode' => (string)$otpCode,
                'ExpireTime' => $expireTime,
                'IsVerified' => 0,
                'CreatedAt' => Carbon::now()
            ]
        );

        // Save Registration Data to Session temporarily
        $registerData = $request->only(['HoTen', 'SoDienThoai', 'Email', 'MatKhau']);
        session([
            'register_data' => $registerData,
            'otp_attempts' => 0,
            'dev_otp' => $otpCode // HACK FOR DEV MODE: Show OTP on screen
        ]);

        return redirect()->route('register.verify')->with('success', 'Mã OTP đã được tạo! (Dev mode: Xem mã trên màn hình)');
    }

    public function showVerifyOTP()
    {
        if (!session()->has('register_data')) {
            return redirect()->route('register')->with('error', 'Vui lòng đăng ký trước.');
        }
        return view('auth.verify_otp');
    }

    public function processVerifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $registerData = session('register_data');
        if (!$registerData) {
            return redirect()->route('register')->with('error', 'Phiên đăng ký đã hết hạn.');
        }

        $email = $registerData['Email'];
        $otpRecord = OTPVerification::where('Email', $email)->first();

        if (!$otpRecord) {
            return back()->with('error', 'Không tìm thấy yêu cầu xác thực.');
        }

        // Check expiration
        if (Carbon::now()->greaterThan($otpRecord->ExpireTime)) {
            $otpRecord->update(['OTPCode' => null]); // Invalidate
            return back()->with('error', 'Mã OTP đã hết hạn. Vui lòng gửi lại mã mới.');
        }

        // Check matching
        if ($otpRecord->OTPCode !== $request->otp) {
            $attempts = session('otp_attempts', 0) + 1;
            session(['otp_attempts' => $attempts]);

            if ($attempts >= 3) {
                // Invalidate OTP if wrong >= 3 times
                $otpRecord->update(['OTPCode' => null]);
                session(['otp_attempts' => 0]);
                return back()->with('error', 'Bạn đã nhập sai quá 3 lần. Mã OTP đã bị hủy, vui lòng gửi lại mã mới.');
            }

            return back()->with('error', "Mã OTP không chính xác. Bạn còn " . (3 - $attempts) . " lần thử.");
        }

        // Verification SUCCESS
        $otpRecord->update(['IsVerified' => 1, 'OTPCode' => null]);

        // Create Account (TEXT PASSWORD AS REQUESTED)
        Account::create([
            'TenDangNhap' => $registerData['Email'], // Using Email as username
            'MatKhau' => $registerData['MatKhau'],   // Plain text password
            'HoTen' => $registerData['HoTen'],
            'SoDienThoai' => $registerData['SoDienThoai'],
            'Email' => $registerData['Email'],
            'RoleID' => 3, // Khách hàng
            'TrangThai' => 1 // Kích hoạt
        ]);

        // Clear session
        session()->forget(['register_data', 'otp_attempts', 'dev_otp']);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    public function resendOTP()
    {
        $registerData = session('register_data');
        if (!$registerData) {
            return redirect()->route('register')->with('error', 'Vui lòng đăng ký trước.');
        }

        $email = $registerData['Email'];
        $otpCode = rand(100000, 999999);
        $expireTime = Carbon::now()->addMinutes(5);

        OTPVerification::updateOrCreate(
            ['Email' => $email],
            [
                'OTPCode' => (string)$otpCode,
                'ExpireTime' => $expireTime,
                'IsVerified' => 0,
                'CreatedAt' => Carbon::now()
            ]
        );

        session([
            'otp_attempts' => 0,
            'dev_otp' => $otpCode
        ]);

        return back()->with('success', 'Đã gửi lại mã OTP mới!');
    }
}
