@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('account/css/login.css') }}" />
@endpush

@section('content')
    <div class="login-wrapper fade-in-box">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-5">
                    <div class="card card-login shadow-lg border-0">

                        <div class="card-header-login text-center py-4 bg-navy text-white">
                            <h2 class="fw-bold">Đăng nhập</h2>
                            <p class="mb-0 small opacity-75">Chào mừng bạn trở lại với MAY HOTEL</p>
                        </div>

                        <div class="card-body p-4 p-md-5">

                            @if(session('error'))
                                <div class="alert alert-danger text-center mb-4" role="alert">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif

                            <form action="{{ url('/login') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-navy">Tên đăng nhập</label>
                                    <input type="text" name="username" class="form-control form-control-lg"
                                           placeholder="Nhập tên đăng nhập của bạn" required value="{{ old('username') }}" />
                                    @error('username')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-navy">Mật khẩu</label>
                                    <input type="password" name="password" class="form-control form-control-lg"
                                           placeholder="Nhập mật khẩu" required />
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-check m-0">
                                    <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                                    <label class="form-check-label small text-navy fw-bold" for="rememberMe" style="cursor: pointer;">
                                        Ghi nhớ đăng nhập
                                    </label>
                                </div>

                                <div class="d-flex justify-content-end mb-3">
                                    <a href="#" class="small fw-bold text-decoration-none"
                                       style="color: #d4af37;">
                                        Quên mật khẩu?
                                    </a>
                                </div>

                                <button type="submit" class="btn btn-login w-100 py-3 fw-bold shadow-sm">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> ĐĂNG NHẬP
                                </button>
                            </form>

                            <div class="login-footer text-center mt-4">
                                <p class="mb-1">Chưa có tài khoản? <a href="#" class="fw-bold">Đăng ký ngay</a></p>
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
