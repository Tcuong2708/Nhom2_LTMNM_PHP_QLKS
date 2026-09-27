@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('account/css/login.css') }}" />
@endpush

@section('content')
    <div class="login-wrapper fade-in-box">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card card-login shadow-lg border-0 my-5">

                        <div class="card-header-login text-center py-4 bg-navy text-white">
                            <h2 class="fw-bold">Đăng ký tài khoản</h2>
                            <p class="mb-0 small opacity-75">Tham gia cùng MAY HOTEL ngay hôm nay</p>
                        </div>

                        <div class="card-body p-4 p-md-5">

                            @if(session('error'))
                                <div class="alert alert-danger text-center mb-4" role="alert">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif

                            <form action="{{ url('/register') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label fw-bold text-navy">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="HoTen" class="form-control form-control-lg"
                                           placeholder="Nhập họ và tên đầy đủ" required value="{{ old('HoTen') }}" />
                                    @error('HoTen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-navy">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" name="SoDienThoai" class="form-control form-control-lg"
                                               placeholder="0912345678" required value="{{ old('SoDienThoai') }}" />
                                        @error('SoDienThoai')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-navy">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="Email" class="form-control form-control-lg"
                                               placeholder="example@gmail.com" required value="{{ old('Email') }}" />
                                        @error('Email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-navy">Mật khẩu <span class="text-danger">*</span></label>
                                        <input type="password" name="MatKhau" class="form-control form-control-lg"
                                               placeholder="Nhập mật khẩu" required />
                                        @error('MatKhau')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold text-navy">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                        <input type="password" name="MatKhau_confirmation" class="form-control form-control-lg"
                                               placeholder="Nhập lại mật khẩu" required />
                                    </div>
                                </div>

                                <!-- Captcha Toán Học Đơn Giản -->
                                @php
                                    $num1 = rand(1, 9);
                                    $num2 = rand(1, 9);
                                    session(['captcha_answer' => $num1 + $num2]);
                                @endphp
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-navy">Mã Captcha <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light border px-3 py-2 rounded text-center fw-bold fs-5 me-3" style="width: 100px; color: #d4af37; background: repeating-linear-gradient(45deg, #f0f0f0, #f0f0f0 10px, #e0e0e0 10px, #e0e0e0 20px);">
                                            {{ $num1 }} + {{ $num2 }} =
                                        </div>
                                        <input type="number" name="captcha" class="form-control form-control-lg" placeholder="?" required />
                                    </div>
                                    @error('captcha')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-login w-100 py-3 fw-bold shadow-sm">
                                    <i class="bi bi-person-plus-fill me-2"></i> TIẾP TỤC (XÁC THỰC EMAIL)
                                </button>
                            </form>

                            <div class="login-footer text-center mt-4">
                                <p class="mb-1">Đã có tài khoản? <a href="{{ url('/login') }}" class="fw-bold">Đăng nhập</a></p>
                                <p class="mt-2">
                                    <a href="{{ url('/') }}" class="small text-muted text-decoration-none">
                                        <i class="bi bi-arrow-left me-1"></i> Quay về trang chủ
                                    </a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
