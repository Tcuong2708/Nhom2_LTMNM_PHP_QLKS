@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('home/rooms/list.css') }}" />
@endpush

@section('content')
    <div class="container py-4">
        <div class="admin-card mb-4">
            <div class="admin-header d-flex justify-content-center align-items-center">
                <h3 class="fw-bold text-uppercase mb-0">
                    <i class="bi bi-grid-fill me-2"></i>Danh Sách Phòng Nghỉ
                </h3>
            </div>
            
            <div class="card-body p-4">
                <div class="card shadow-sm mb-4 border-0 bg-light">
                    <div class="card-body p-4">
                        <form id="search-form" action="{{ url('/rooms') }}" method="GET">
                            <!-- Giữ lại các bộ lọc hiện tại trong URL -->
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('priceRange'))
                                <input type="hidden" name="priceRange" value="{{ request('priceRange') }}">
                            @endif

                            <div class="row gx-3 align-items-center justify-content-center">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 py-2" placeholder="Tìm theo tên phòng..." />
                                        <button type="submit" class="btn btn-search fw-bold text-uppercase">TÌM KIẾM</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 order-md-1 order-2 mt-4 mt-md-0">
                        <div class="filter-card">
                            <div class="filter-header"><i class="bi bi-bookmark-star-fill me-2"></i>Loại Phòng</div>
                            <div class="list-group list-group-flush" id="category-filter">
                                <a href="{{ url('/rooms?' . http_build_query(array_merge(request()->query(), ['category' => '']))) }}" 
                                   class="list-group-item list-group-item-action {{ request('category') == '' ? 'active' : '' }}">
                                    Tất cả
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ url('/rooms?' . http_build_query(array_merge(request()->query(), ['category' => $cat->MaLoai]))) }}" 
                                       class="list-group-item list-group-item-action {{ request('category') == $cat->MaLoai ? 'active' : '' }}">
                                        {{ $cat->Name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="filter-card mt-4">
                            <div class="filter-header"><i class="bi bi-cash-stack me-2"></i>Khoảng Giá</div>
                            <div class="list-group list-group-flush" id="price-filter">
                                <a href="{{ url('/rooms?' . http_build_query(array_merge(request()->query(), ['priceRange' => '']))) }}" 
                                   class="list-group-item list-group-item-action {{ request('priceRange') == '' ? 'active' : '' }}">
                                    Tất cả mức giá
                                </a>
                                <a href="{{ url('/rooms?' . http_build_query(array_merge(request()->query(), ['priceRange' => 'lt500']))) }}" 
                                   class="list-group-item list-group-item-action {{ request('priceRange') == 'lt500' ? 'active' : '' }}">
                                    Dưới 500k
                                </a>
                                <a href="{{ url('/rooms?' . http_build_query(array_merge(request()->query(), ['priceRange' => 'gt2000']))) }}" 
                                   class="list-group-item list-group-item-action {{ request('priceRange') == 'gt2000' ? 'active' : '' }}">
                                    Trên 2 triệu
                                </a>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ url('/rooms') }}" class="btn btn-outline-secondary w-100">Xóa bộ lọc</a>
                        </div>
                    </div>

                    <div class="col-md-9 order-md-2 order-1">
                        <div class="row gx-4 gy-4" id="room-list">
                            @if(count($rooms) > 0)
                                @foreach($rooms as $room)
                                    @php
                                        // Xử lý ImageUrl
                                        $imgSrc = $room->ImageUrl ? asset('images/' . $room->ImageUrl) : 'https://via.placeholder.com/300x220?text=No+Image';
                                        if ($room->ImageUrl && str_starts_with($room->ImageUrl, 'http')) {
                                            $imgSrc = $room->ImageUrl;
                                        }
                                        $loaiName = $categories->where('MaLoai', $room->MaLoai)->first()->Name ?? 'Phòng tiêu chuẩn';
                                    @endphp

                                    <div class="col-lg-4 col-md-6">
                                        <div class="card h-100 room-card shadow-sm border" style="border-radius: 8px;">
                                            <div class="room-img-wrapper position-relative">
                                                @if($room->Price < 600000)
                                                    <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-2 py-1"><i class="bi bi-fire me-1"></i> HOT DEAL</span>
                                                @endif
                                                <a href="{{ url('/rooms/' . $room->ID) }}">
                                                    <img src="{{ $imgSrc }}" class="card-img-top room-img" alt="{{ $loaiName }}">
                                                </a>
                                            </div>
                                            <div class="card-body d-flex flex-column text-center p-4">
                                                <small class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.75rem;">
                                                    <i class="bi bi-people-fill me-1 text-secondary"></i> Sức chứa: {{ $room->MaLoai == 1 ? '1' : ($room->MaLoai == 2 ? '2' : 'Nhiều') }} người
                                                </small>
                                                <h5 class="card-title fw-bold mb-3">
                                                    <a href="{{ url('/rooms/' . $room->ID) }}" class="text-decoration-none" style="color: var(--navy-color);">{{ $loaiName }}</a>
                                                </h5>
                                                <p class="mb-4">
                                                    <span class="fw-bold fs-5" style="color: #dc3545;">{{ number_format($room->Price, 0, ',', '.') }}</span>
                                                    <small class="text-muted fw-normal ms-1">đ/ đêm</small>
                                                </p>
                                                <div class="mt-auto row g-2 align-items-stretch">
                                                    <div class="col-6">
                                                        <a href="{{ url('/rooms/' . $room->ID) }}" class="btn btn-outline-dark fw-bold w-100 h-100 d-flex align-items-center justify-content-center text-uppercase" style="border-radius: 4px; font-size: 0.85rem; min-height: 42px;">
                                                            Chi tiết
                                                        </a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="{{ url('/booking/checkout?room_id=' . $room->ID) }}" class="btn btn-gold text-white fw-bold w-100 h-100 d-flex align-items-center justify-content-center text-uppercase" style="background-color: #C5A017; border: none; border-radius: 4px; font-size: 0.85rem; min-height: 42px;">
                                                            <i class="bi bi-calendar-check-fill me-1"></i> Đặt ngay
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div id="no-results" class="text-center py-5 w-100">
                                    <i class="bi bi-search display-1 text-muted opacity-25"></i>
                                    <h3 class="mt-3 text-muted">Không tìm thấy phòng phù hợp.</h3>
                                    <a href="{{ url('/rooms') }}" class="btn btn-outline-secondary mt-2">Xóa bộ lọc</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
