<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
    use ApiResponseTrait;

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $result = $this->authService->login($request->username, $request->password);
            return $this->successResponse($result, 'Đăng nhập thành công');
        } catch (Exception $e) {
            $code = $e->getCode() == 0 ? 500 : $e->getCode();
            return $this->errorResponse($e->getMessage(), $code);
        }
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $result = $this->authService->forgotPassword($request->email);
            return $this->successResponse($result, 'Yêu cầu đặt lại mật khẩu đã được xử lý');
        } catch (Exception $e) {
            $code = $e->getCode() == 0 ? 500 : $e->getCode();
            return $this->errorResponse($e->getMessage(), $code);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6'
        ]);

        try {
            $this->authService->verifyOtp($request->email, $request->otp);
            return $this->successResponse(null, 'Xác thực OTP thành công, bạn có thể đổi mật khẩu');
        } catch (Exception $e) {
            $code = $e->getCode() == 0 ? 500 : $e->getCode();
            return $this->errorResponse($e->getMessage(), $code);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed' // Cần gửi password và password_confirmation
        ]);

        try {
            $this->authService->resetPassword($request->email, $request->password);
            return $this->successResponse(null, 'Đổi mật khẩu thành công');
        } catch (Exception $e) {
            $code = $e->getCode() == 0 ? 500 : $e->getCode();
            return $this->errorResponse($e->getMessage(), $code);
        }
    }

    public function logout(Request $request)
    {
        // Xóa token hiện tại đang dùng để đăng nhập
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse(null, 'Đăng xuất thành công');
    }
}
