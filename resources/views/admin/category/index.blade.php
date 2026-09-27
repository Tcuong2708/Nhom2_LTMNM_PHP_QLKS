@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/category-assets/css/index.css') }}">
@endpush

@section('content')
<div class="container py-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0 admin-card">
        <div class="admin-header d-flex justify-content-between align-items-center">
            <h3 class="fw-bold text-uppercase mb-0">
                <i class="bi bi-bookmark-star-fill me-2"></i>Quản Lý Loại Phòng
            </h3>
            <a href="{{ route('admin.category.create') }}" class="btn btn-gold px-4 shadow-sm text-white" style="background: #C5A017;">
                <i class="bi bi-plus-lg me-1"></i> Thêm Mới
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                <thead class="table-header-navy" style="background-color: #0F2942; color: white;">
                    <tr>
                        <th class="py-3 text-center text-uppercase small text-white">Mã số</th>
                        <th class="text-center text-uppercase small text-white">Tên loại phòng</th>
                        <th class="text-center text-uppercase small text-white">Sức chứa tối đa (Người)</th>
                        <th class="text-center text-uppercase small text-white">Số lượng phòng</th>
                        <th class="text-center text-uppercase small text-white" style="width: 150px;">Thao tác</th>
                    </tr>
                </thead>
                    <tbody id="category-table-body">
                        @forelse($categories as $cat)
                        <tr>
                            <td class="text-center fw-bold text-muted">#{{ $cat->MaLoai }}</td>
                            <td class="text-center fw-bold text-navy" style="color: #0F2942;">{{ $cat->Name }}</td>
                            <td class="text-center"><span class="badge bg-info text-dark"><i class="bi bi-people-fill me-1"></i> {{ $cat->SoNguoi }}</span></td>
                            <td class="text-center"><span class="badge bg-secondary">{{ $cat->so_luong_phong ?? 0 }} phòng</span></td>
                            <td class="text-center">
                                <a href="{{ route('admin.category.edit', $cat->MaLoai) }}" class="btn btn-sm btn-warning text-white shadow-sm" title="Sửa"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.category.destroy', $cat->MaLoai) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa loại phòng này? Thao tác này không thể phục hồi!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm ms-1" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Không có dữ liệu loại phòng.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
