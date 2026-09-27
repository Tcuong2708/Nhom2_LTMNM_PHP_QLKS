@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/users-assets/css/create.css') }}">
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg form-card">
                <div class="card-header text-white py-3" style="background-color: var(--navy-color);">
                    <h4 class="mb-0 fw-bold text-uppercase fs-5">
                        <i class="bi bi-person-plus-fill me-2 text-gold"></i>Thêm Người Dùng
                    </h4>
                </div>
                <div class="card-body p-5">
                    @if($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold" style="color: var(--navy-color);">Tên đăng nhập <span class="text-danger">*</span></label>
                                <input type="text" name="TenDangNhap" class="form-control" value="{{ old('TenDangNhap') }}" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="color: var(--navy-color);">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="MatKhau" class="form-control" required minlength="6" />
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold" style="color: var(--navy-color);">Họ và Tên <span class="text-danger">*</span></label>
                                <input type="text" name="HoTen" class="form-control" value="{{ old('HoTen') }}" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="color: var(--navy-color);">Số điện thoại</label>
                                <input type="text" name="SoDienThoai" class="form-control" value="{{ old('SoDienThoai') }}" />
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold" style="color: var(--navy-color);">Vai trò <span class="text-danger">*</span></label>
                                <select name="RoleID" class="form-select" required>
                                    <option value="3" {{ old('RoleID') == 3 ? 'selected' : '' }}>Khách hàng</option>
                                    <option value="2" {{ old('RoleID') == 2 ? 'selected' : '' }}>Nhân viên Lễ tân</option>
                                    <option value="1" {{ old('RoleID') == 1 ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="color: var(--navy-color);">Trạng thái <span class="text-danger">*</span></label>
                                <select name="TrangThai" class="form-select" required>
                                    <option value="1" {{ old('TrangThai') == 1 ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="0" {{ old('TrangThai') == 0 ? 'selected' : '' }}>Bị khóa</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4 fw-bold">
                                <i class="bi bi-arrow-left me-2"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-gold px-4 fw-bold text-white" style="background: #C5A017;">
                                <i class="bi bi-save me-2"></i>Lưu Người Dùng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
