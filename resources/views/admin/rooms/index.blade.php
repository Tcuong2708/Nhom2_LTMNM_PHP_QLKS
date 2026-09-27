@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/rooms-assets/admin-room.css') }}">
@endpush

@section('content')
<div class="container py-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="admin-card">
        <div class="admin-header d-flex justify-content-between align-items-center">
            <h3 class="fw-bold text-uppercase mb-0">
                <i class="bi bi-ui-checks-grid me-2"></i>Quản Lý Phòng
            </h3>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-gold px-4 shadow-sm text-white" style="background: #C5A017;">
                <i class="bi bi-plus-circle-fill me-1"></i> Thêm Phòng Mới
            </a>
        </div>

        <div class="card-body p-4 bg-light border-bottom">
            <form action="{{ route('admin.rooms.index') }}" method="GET">
                <div class="row gx-3 align-items-center justify-content-center">
                    <div class="col-md-8">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 py-2" placeholder="Tìm kiếm theo tên phòng..." value="{{ request('search') }}" />
                            <button type="submit" class="btn btn-gold px-4 text-white fw-bold text-uppercase" style="background: #C5A017;">TÌM KIẾM</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-header-navy" style="background-color: #0F2942; color: white;">
                <tr>
                    <th class="py-3 text-center text-uppercase small text-white">ID</th>
                    <th class="text-center text-uppercase small text-white">Hình ảnh</th>
                    <th class="text-center text-uppercase small text-white">Tên phòng</th>
                    <th class="text-center text-uppercase small text-white">Loại Phòng</th>
                    <th class="text-center text-uppercase small text-white">Giá phòng</th>
                    <th class="text-center text-uppercase small text-white">Trạng thái</th>
                    <th class="text-center text-uppercase small text-white">Thao tác</th>
                </tr>
                </thead>
                <tbody id="table-body">
                    @forelse($rooms as $room)
                    <tr>
                        <td class="text-center fw-bold text-secondary">#{{ $room->ID }}</td>
                        <td class="text-center">
                            @if($room->ImageUrl)
                                @php
                                    $imgPath = $room->ImageUrl;
                                    if (!Str::contains($imgPath, '/') && !Str::startsWith($imgPath, 'http')) {
                                        $imgPath = 'images/' . $imgPath;
                                    }
                                @endphp
                                <img src="{{ asset($imgPath) }}" alt="{{ $room->Name }}" class="rounded" style="width: 80px; height: 60px; object-fit: cover; border: 1px solid #ddd;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted mx-auto" style="width: 80px; height: 60px; border: 1px solid #ddd;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td class="text-center fw-bold" style="color: #0F2942;">{{ $room->Name }}</td>
                        <td class="text-center"><span class="badge bg-secondary">{{ $room->TenLoai }}</span></td>
                        <td class="text-center text-danger fw-bold">{{ number_format($room->Price, 0, ',', '.') }} đ</td>
                        <td class="text-center">
                            @if($room->MaTrangThai == 1)
                                <span class="status-badge status-1">Đang Trống</span>
                            @elseif($room->MaTrangThai == 2)
                                <span class="status-badge status-2">Đã Đặt</span>
                            @else
                                <span class="status-badge status-3">{{ $room->TenTrangThai }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.rooms.edit', $room->ID) }}" class="btn btn-sm btn-warning text-white shadow-sm mx-1" title="Sửa"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.rooms.destroy', $room->ID) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phòng này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm ms-1" title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Không có dữ liệu phòng.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
