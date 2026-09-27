@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/check-out-assets/css/index.css') }}" />
@endpush

@section('content')
    <div class="container py-5">
        <div id="alert-container"></div>

        <div class="card shadow-sm border-0 rounded-3 overflow-hidden admin-card">
            <div class="admin-header d-flex justify-content-between align-items-center">
                <h3 class="fw-bold text-uppercase mb-0">
                    <i class="bi bi-box-arrow-left me-2"></i>Nghiệp vụ Trả phòng & Kết toán (Check-out)
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-header-navy" style="background-color: #0F2942; color: white;">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase small text-white">Mã HD</th>
                                <th class="text-uppercase small text-white">Khách lưu trú</th>
                                <th class="text-center text-uppercase small text-white">Số phòng giải phóng</th>
                                <th class="text-uppercase small text-white">Thời gian ở</th>
                                <th class="text-center text-uppercase small text-white" style="width: 320px;">Tất toán & Phụ thu tại quầy</th>
                            </tr>
                        </thead>
                        <tbody id="checkout-table-body">
                            <!-- Data will be populated here by JS -->
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/check-out-assets/js/index.js') }}"></script>
@endpush
