@extends('layouts.app')

@push('styles')
    <!-- CSS riêng cho Sơ đồ phòng -->
    <link rel="stylesheet" href="{{ asset('staff/room-map-assets/css/index.css') }}" />
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="admin-card mb-4">
            <div class="admin-header d-flex justify-content-between align-items-center">
                <h3 class="fw-bold text-uppercase mb-0">
                    <i class="bi bi-grid-3x3-gap-fill me-2"></i>Sơ đồ phòng nghỉ trực quan
                </h3>
                <a href="{{ url('/admin/check-in') }}" class="btn btn-gold px-4 shadow-sm text-white" style="background: #C5A017;">
                    <i class="bi bi-journal-bookmark-fill me-2"></i>Xem danh sách Chờ Check-in
                </a>
            </div>
            
            <div class="card-body p-4">
                <div class="d-flex gap-4 p-3 bg-white rounded shadow-sm border mb-4" style="font-size: 0.9rem;">
                    <span class="fw-bold"><i class="bi bi-square-fill text-success me-1"></i>Phòng trống</span>
                    <span class="fw-bold"><i class="bi bi-square-fill text-danger me-1"></i>Đang ở (Check-in)</span>
                    <span class="fw-bold"><i class="bi bi-square-fill text-warning me-1"></i>Chờ dọn dẹp (Sau Check-out)</span>
                </div>

                <div id="loading-spinner" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2">Đang tải sơ đồ phòng...</p>
                </div>

                <div class="room-grid" id="room-grid">
                    <!-- Room cards will be rendered here by JS -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Script gọi API sơ đồ phòng của Lễ tân -->
    <script src="{{ asset('staff/room-map-assets/js/index.js') }}"></script>
@endpush
