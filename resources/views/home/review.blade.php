@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('home/review/review.css') }}">
    <style>
        .text-navy { color: #0F2942 !important; }
        .text-gold { color: #C5A017 !important; }
        .btn-gold { background-color: #C5A017 !important; color: white !important; border: none !important; transition: 0.3s; }
        .btn-gold:hover { background-color: #a68512 !important; transform: translateY(-1px); }
    </style>
@endpush

@section('content')
    <section class="testimonial-section py-4">
        <div class="container">
            <div class="admin-card mb-4">
                <div class="admin-header d-flex justify-content-center align-items-center">
                    <h3 class="fw-bold text-uppercase mb-0 text-white">
                        <i class="bi bi-chat-quote-fill me-2" style="color: #C5A017;"></i>Khách Hàng Nói Gì Về Chúng Tôi
                    </h3>
                </div>
                
                <div class="card-body p-4 p-md-5 bg-white">
                    <!-- Box hiển thị đánh giá -->
                    <div class="testimonial-box shadow-sm border position-relative bg-light rounded-4 p-5 text-center mx-auto" style="max-width: 800px;">
                        
                        <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                            <div class="carousel-inner">
                                @if(isset($reviews) && count($reviews) > 0)
                                    @foreach($reviews as $index => $review)
                                        @php
                                            // Lấy tên user, nếu không có thì dùng tên giả định
                                            $userName = $review->User_ID ? 'Khách hàng #' . $review->User_ID : 'Khách hàng Ẩn danh';
                                            $avatar = "https://ui-avatars.com/api/?name=" . urlencode($userName) . "&background=0F2942&color=fff";
                                        @endphp
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <div class="testimonial-content">
                                                <img loading="lazy" class="testimonial-img mb-3 rounded-circle shadow-sm" style="width: 90px; height: 90px; object-fit: cover;"
                                                     src="{{ $avatar }}" alt="avatar" />
                                                <div class="stars mb-2 text-warning fs-5">
                                                    @for($i = 0; $i < $review->SoSao; $i++)
                                                        <i class='bi bi-star-fill me-1'></i>
                                                    @endfor
                                                    @for($i = $review->SoSao; $i < 5; $i++)
                                                        <i class='bi bi-star text-muted opacity-25 me-1'></i>
                                                    @endfor
                                                </div>
                                                <h5 class="testimonial-name fw-bold text-navy">{{ $userName }}</h5>
                                                <p class="testimonial-text fst-italic text-secondary px-md-5 mt-3">{{ $review->NoiDung }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="carousel-item active">
                                        <p class="text-muted py-4 m-0"><i class="bi bi-chat-dots me-2"></i>Chưa có phản hồi công khai nào từ khách hàng.</p>
                                    </div>
                                @endif
                            </div>
                            
                            @if(isset($reviews) && count($reviews) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev" style="width: 50px;">
                                    <span class="fs-3 text-muted" aria-hidden="true">&#10094;</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next" style="width: 50px;">
                                    <span class="fs-3 text-muted" aria-hidden="true">&#10095;</span>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Form gửi đánh giá -->
                    <div class="form-section mt-5 p-4 p-md-5 bg-white rounded-4 shadow-sm border mx-auto" style="max-width: 800px;">
                        <h3 class="mb-4 text-navy fw-bold text-center">
                            <i class="bi bi-pencil-square me-2 text-gold"></i>Gửi đánh giá của bạn
                        </h3>

                        @if(Auth::check())
                            <form id="review-form" class="row g-4" action="#" method="POST">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-navy">Họ và tên thành viên</label>
                                    <input type="text" class="form-control py-2" value="{{ Auth::user()->HoTen }}" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-navy">Mức độ hài lòng <span class="text-danger">*</span></label>
                                    <select name="SoSao" class="form-select py-2" required>
                                        <option value="">-- Chọn mức đánh giá --</option>
                                        <option value="5">⭐⭐⭐⭐⭐ - Tuyệt vời (5 sao)</option>
                                        <option value="4">⭐⭐⭐⭐ - Rất tốt (4 sao)</option>
                                        <option value="3">⭐⭐⭐ - Tạm được (3 sao)</option>
                                        <option value="2">⭐⭐ - Cần cải thiện (2 sao)</option>
                                        <option value="1">⭐ - Tệ (1 sao)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold text-navy">Nhận xét chi tiết <span class="text-danger">*</span></label>
                                    <textarea name="NoiDung" class="form-control" rows="5" required placeholder="Chia sẻ cảm nghĩ thực tế của bạn về chất lượng dịch vụ tại MAY HOTEL..."></textarea>
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-submit px-5 py-3 rounded-pill text-uppercase fw-bold shadow-sm text-white w-100 w-md-auto" style="background-color: #0F2942;">
                                        <i class="bi bi-send-fill me-2"></i> Gửi Đánh Giá
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-4 bg-light rounded-3">
                                <p class="text-muted small mb-3">Vui lòng đăng nhập tài khoản thành viên để gửi bình luận đánh giá hệ thống.</p>
                                <a href="{{ route('login') }}" class="btn btn-gold fw-bold px-4 py-2 rounded-pill">ĐĂNG NHẬP NGAY</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
