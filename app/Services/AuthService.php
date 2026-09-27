<?php

namespace App\Services;

use App\Models\Account;
use App\Models\OTPVerification;
use Illuminate\Support\Str;
use Exception;
use Carbon\Carbon;

class AuthService
{
    /**
     * Xử lý đăng nhập
     */
    public function login($username, $password)
    {
        // Kiểm tra tài khoản bằng mật khẩu text thường (theo yêu cầu hiện tại)
        $account = Account::where('TenDangNhap', $username)
                          ->where('MatKhau', $password)
                          ->first();

        if (!$account) {
            throw new Exception('Thông tin đăng nhập không chính xác', 401);
        }

        if ($account->TrangThai == 0) {
            throw new Exception('Tài khoản đang bị vô hiệu hóa, hệ thống từ chối đăng nhập.', 403);
        }

        // Tạo API Token
        $token = $account->createToken('auth_token')->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'IDTaiKhoan' => $account->IDTaiKhoan,
                'HoTen' => $account->HoTen,
                'RoleID' => $account->RoleID,
                'Email' => $account->Email
            ]
        ];
    }

    /**
     * Quên mật khẩu - Sinh mã OTP
     */
    public function forgotPassword($email)
    {
        $account = Account::where('Email', $email)->first();
        if (!$account) {
            throw new Exception('Email không tồn tại trong hệ thống', 404);
        }

        // Tạo OTP ngẫu nhiên 6 số
        $otpCode = rand(100000, 999999);
        
        // Cập nhật hoặc tạo mới OTP cho Email này
        $otpRecord = OTPVerification::updateOrCreate(
            ['Email' => $email],
            [
                'OTPCode' => $otpCode,
                'ExpireTime' => Carbon::now()->addMinutes(5), // Hết hạn sau 5 phút
                'IsVerified' => 0,
                'CreatedAt' => Carbon::now()
            ]
        );

        // TODO: Gửi Email thực tế ở đây khi có cấu hình SMTP
        
        return [
            'message' => 'Mã OTP đã được tạo thành công (Gửi Email giả lập)',
            'test_otp' => $otpCode // Hiển thị tạm để test
        ];
    }

    /**
     * Xác thực mã OTP
     */
    public function verifyOtp($email, $otp)
    {
        $otpRecord = OTPVerification::where('Email', $email)
                                    ->where('OTPCode', $otp)
                                    ->first();

        if (!$otpRecord) {
            throw new Exception('Mã OTP không chính xác', 400);
        }

        if (Carbon::now()->greaterThan($otpRecord->ExpireTime)) {
            throw new Exception('Mã OTP đã hết hạn', 400);
        }

        // Đánh dấu là đã xác thực
        $otpRecord->update(['IsVerified' => 1]);

        return true;
    }

    /**
     * Đặt lại mật khẩu mới
     */
    public function resetPassword($email, $newPassword)
    {
        $otpRecord = OTPVerification::where('Email', $email)->first();

        if (!$otpRecord || $otpRecord->IsVerified == 0) {
            throw new Exception('Bạn chưa xác thực OTP', 403);
        }

        $account = Account::where('Email', $email)->first();
        if (!$account) {
            throw new Exception('Tài khoản không tồn tại', 404);
        }

        // Đổi mật khẩu (Lưu text thường theo yêu cầu)
        $account->update(['MatKhau' => $newPassword]);

        // Xóa OTP sau khi đổi pass thành công
        $otpRecord->delete();

        return true;
    }
}
