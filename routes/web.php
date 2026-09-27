<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\AdminRoomController;
use App\Http\Controllers\Web\AdminCategoryController;
use App\Http\Controllers\Web\AdminServiceController;
use App\Http\Controllers\Web\AdminUserController;
use App\Http\Controllers\Web\AdminReviewController;
use App\Http\Controllers\Web\AdminStatisticalController;

// Trang chủ
Route::get('/', [HomeController::class, 'index']);

// Danh sách phòng
Route::get('/rooms', [HomeController::class, 'rooms'])->name('rooms.list');
Route::get('/rooms/{id}', [HomeController::class, 'roomDetail'])->name('rooms.detail');

// Thông tin & Đánh giá
Route::get('/info', [HomeController::class, 'info'])->name('info');
Route::get('/reviews', [HomeController::class, 'reviews'])->name('reviews');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister']);
Route::get('/register/verify', [AuthController::class, 'showVerifyOTP'])->name('register.verify');
Route::post('/register/verify', [AuthController::class, 'processVerifyOTP']);
Route::post('/register/resend-otp', [AuthController::class, 'resendOTP'])->name('register.resend_otp');

// ==========================================
// CÁC ROUTE DÀNH CHO LỄ TÂN & ADMIN (RoleID 1, 2)
// ==========================================
Route::middleware(['staff'])->group(function () {
    Route::get('/staff/room-map', function () {
        return view('staff.room-map');
    });
    Route::get('/admin/check-in', function () {
        return view('admin.check-in');
    });
    Route::get('/admin/check-out', function () {
        return view('admin.check-out');
    });
    Route::get('/admin/invoice', function () {
        return view('admin.invoice');
    });
});

// ==========================================
// CÁC ROUTE CHỈ DÀNH CHO ADMIN (RoleID 1)
// ==========================================
Route::middleware(['admin'])->group(function () {
    // Quản lý Phòng
    Route::resource('/admin/rooms', AdminRoomController::class)->names('admin.rooms');
    
    // Quản lý Loại phòng
    Route::resource('/admin/category', AdminCategoryController::class)->names('admin.category');
    
    // Quản lý Dịch vụ
    Route::resource('/admin/service', AdminServiceController::class)->names('admin.service');
    // Quản lý Người dùng
    Route::resource('/admin/users', AdminUserController::class)->names('admin.users');
    
    // Quản lý Đánh giá
    Route::resource('/admin/reviews', AdminReviewController::class)->only(['index', 'destroy'])->names('admin.reviews');
    
    // Thống kê Doanh thu
    Route::get('/admin/statistical', [AdminStatisticalController::class, 'index'])->name('admin.statistical');
});
