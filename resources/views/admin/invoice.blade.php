@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/invoice/css/index.css') }}" />
@endpush

@section('content')
    <div class="container py-4">
        <div id="alert-container"></div>

        <div class="card shadow-sm border-0 admin-card">
            <div class="admin-header d-flex justify-content-between align-items-center">
                <h3 class="fw-bold text-uppercase mb-0">
                    <i class="bi bi-file-earmark-text-fill me-2"></i>Danh sách Đơn đặt phòng
                </h3>
                <a href="{{ url('/admin/invoice/create') }}" class="btn btn-gold px-4 shadow-sm text-white" style="background: #C5A017;">
                    <i class="bi bi-plus-lg me-2"></i>Tạo đơn khách lẻ
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-header-navy" style="background-color: #0F2942; color: white;">
                        <tr>
                            <th class="py-3 text-center text-uppercase small text-white">Mã HĐ</th>
                            <th class="text-center text-uppercase small text-white">Khách hàng</th>
                            <th class="text-center text-uppercase small text-white">Ngày đặt</th>
                            <th class="text-center text-uppercase small text-white">Thời gian lưu trú</th>
                            <th class="text-center text-uppercase small text-white">Tổng tiền</th>
                            <th class="text-center text-uppercase small text-white">Trạng thái</th>
                            <th class="text-center text-uppercase small text-white">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody id="invoice-table-body">
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
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
    <script src="{{ asset('admin/invoice/js/index.js') }}"></script>
@endpush
