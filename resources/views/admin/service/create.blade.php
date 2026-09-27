@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/service-assets/css/create.css') }}">
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg form-card">
                <div class="card-header text-white py-3" style="background-color: var(--navy-color);">
                    <h4 class="mb-0 fw-bold text-uppercase fs-5">
                        <i class="bi bi-plus-lg me-2 text-gold"></i>Thêm Dịch Vụ Mới
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

                    <form action="{{ route('admin.service.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color: var(--navy-color);">Tên dịch vụ <span class="text-danger">*</span></label>
                            <input type="text" name="TenDV" class="form-control form-control-lg" placeholder="Ví dụ: Ăn sáng, Giặt ủi..." value="{{ old('TenDV') }}" required />
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold" style="color: var(--navy-color);">Giá tiền (VNĐ) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="GiaTien" class="form-control" min="0" placeholder="0" value="{{ old('GiaTien') }}" required />
                                    <span class="input-group-text bg-light text-secondary">VNĐ</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="color: var(--navy-color);">Đơn vị tính <span class="text-danger">*</span></label>
                                <input type="text" name="DonVi" class="form-control" placeholder="Lần, Suất, Kg..." value="{{ old('DonVi') }}" required />
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 border-top pt-4 mt-3">
                            <a href="{{ route('admin.service.index') }}" class="btn btn-outline-secondary px-4 fw-bold">
                                <i class="bi bi-arrow-left me-2"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-gold px-4 fw-bold text-white" style="background: #C5A017;">
                                <i class="bi bi-save me-2"></i>Lưu Dịch Vụ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
