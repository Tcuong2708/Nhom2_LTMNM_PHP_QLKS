@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/category-assets/css/edit.css') }}">
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card admin-form-card shadow-lg border-0">
                <div class="admin-header rounded-top">
                    <h3 class="mb-1 fw-bold text-uppercase" style="letter-spacing: 1px;">
                        <i class="bi bi-pencil-square me-2 text-gold"></i>Cập Nhật Loại Phòng
                    </h3>
                    <p class="mb-0 small text-white-50">Mã số: <span id="display-id">#{{ $category->MaLoai }}</span></p>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.category.update', $category->MaLoai) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Tên loại phòng <span class="text-danger">*</span></label>
                            <input type="text" id="Name" name="Name" class="form-control form-control-lg modern-input" placeholder="Nhập tên loại phòng..." value="{{ old('Name', $category->Name) }}" required />
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Sức chứa tối đa (Người) <span class="text-danger">*</span></label>
                            <input type="number" id="SoNguoi" name="SoNguoi" class="form-control form-control-lg modern-input" placeholder="Nhập số người tối đa" value="{{ old('SoNguoi', $category->SoNguoi) }}" min="1" required />
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-4">
                            <a href="{{ route('admin.category.index') }}" class="btn btn-outline-secondary px-4 modern-btn">
                                <i class="bi bi-arrow-left me-1"></i> Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-gold px-4 shadow-sm modern-btn-gold" style="background: #C5A017; color: white;">
                                <i class="bi bi-check-lg me-1"></i> LƯU THAY ĐỔI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
