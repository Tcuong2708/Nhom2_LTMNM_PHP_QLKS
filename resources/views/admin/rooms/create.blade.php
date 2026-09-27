@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/rooms-assets/admin-room.css') }}">
@endpush

@section('content')
<div class="container py-5">
    <a href="{{ route('admin.rooms.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Trở về Quản lý phòng
    </a>

    <div class="admin-card">
        <div class="admin-header">
            <h4 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="bi bi-plus-square-fill me-2 text-warning"></i>Thêm Phòng Mới
            </h4>
        </div>

        <div class="card-body p-4 p-md-5">
            @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tên Phòng <span class="text-danger">*</span></label>
                        <input type="text" name="Name" class="form-control" required placeholder="Ví dụ: P101" value="{{ old('Name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Giá Phòng (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" name="Price" class="form-control" required placeholder="Ví dụ: 500000" min="0" value="{{ old('Price') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hình Ảnh (Tải lên)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Trạng Thái <span class="text-danger">*</span></label>
                        <select class="form-select" name="MaTrangThai" required>
                            @foreach($roomStatuses as $status)
                                <option value="{{ $status->MaTrangThai }}" {{ old('MaTrangThai') == $status->MaTrangThai ? 'selected' : '' }}>{{ $status->TrangThai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Số Giường Phụ Tối Đa <span class="text-danger">*</span></label>
                        <input type="number" name="SoGiuongPhuToiDa" class="form-control" value="{{ old('SoGiuongPhuToiDa', 0) }}" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Loại Phòng <span class="text-danger">*</span></label>
                        <select class="form-select" name="MaLoai" required>
                            <option value="" disabled selected>-- Chọn loại phòng --</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->MaLoai }}" {{ old('MaLoai') == $type->MaLoai ? 'selected' : '' }}>{{ $type->Name }} (Tối đa {{ $type->SoNguoi }} người)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Chi Tiết (Mô tả)</label>
                        <textarea class="form-control" name="Detail" rows="3" placeholder="Mô tả về phòng...">{{ old('Detail') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Ghi Chú</label>
                        <textarea class="form-control" name="GhiChu" rows="2" placeholder="Ghi chú nội bộ...">{{ old('GhiChu') }}</textarea>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top text-end">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary px-4 me-2">Hủy</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold" style="background-color: var(--navy-color);">
                        <i class="bi bi-floppy me-1"></i> Lưu Lại
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
