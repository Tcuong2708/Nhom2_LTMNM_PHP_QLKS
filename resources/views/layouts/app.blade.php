<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MAY HOTEL - Đẳng Cấp Sang Trọng</title>
  
  <link rel="stylesheet" href="{{ asset('css/home.css') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('style.css') }}" />
  
  <style>
    .navbar-nav .nav-link.active-menu {
      font-weight: 700 !important;
      color: #d4af37 !important;
      background-color: rgba(212, 175, 55, 0.1);
      border-radius: 8px;
      padding: 8px 16px !important;
      transition: 0.3s all ease-in-out;
    }
  </style>

  @stack('styles')
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg sticky-top glass-navbar">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
        <img src="{{ asset('images/Logo web.png') }}" alt="Logo" style="height: 32px; object-fit: contain; margin-right: 8px;">
        <span class="fw-bold" style="letter-spacing: 1px;">MAY HOTEL</span>
      </a>
      
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto align-items-center">
          @if(!Auth::check() || (Auth::check() && Auth::user()->RoleID == 3))
            <li class="nav-item"><a class="nav-link {{ Request::is('/') ? 'active-menu' : '' }}" href="{{ url('/') }}">Trang chủ</a></li>
            <li class="nav-item"><a class="nav-link {{ Request::is('info') ? 'active-menu' : '' }}" href="{{ url('/info') }}">Thông tin</a></li>
            <li class="nav-item">
                <a class="nav-link fw-bold px-3 py-2 text-uppercase text-navy {{ Request::is('rooms*') ? 'active-menu' : '' }}" href="{{ url('/rooms') }}">Phòng Nghỉ</a>
            </li>
            <li class="nav-item"><a class="nav-link {{ Request::is('reviews') ? 'active-menu' : '' }}" href="{{ url('/reviews') }}">Đánh giá</a></li>
          @endif

          <!-- Dropdown Tài khoản User -->
          <li class="nav-item dropdown" id="user-menu-container">
            <a class="nav-icon-btn dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle" id="user-icon" style="opacity: 0.6;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom" id="user-dropdown-menu">
                @if(Auth::check())
                    <!-- Đã đăng nhập -->
                    <li>
                        <div class="dropdown-header-user px-3 py-2 fw-bold text-primary border-bottom" style="background-color: #f8f9fa;">
                            Xin chào, {{ Auth::user()->TenDangNhap ?? Auth::user()->HoTen }}
                        </div>
                    </li>
                    
                    @if(Auth::user()->RoleID == 1)
                        <li><div class="dropdown-header text-uppercase text-danger fw-bold mt-2" style="font-size: 0.75rem; padding-left: 1rem;">Quản trị hệ thống</div></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/rooms') }}"><i class="bi bi-houses-fill me-2 text-secondary"></i>Quản lý Phòng</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/category') }}"><i class="bi bi-tags-fill me-2 text-secondary"></i>Quản lý Loại phòng</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/service') }}"><i class="bi bi-stars me-2 text-secondary"></i>Quản lý Dịch vụ</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/users') }}"><i class="bi bi-people-fill me-2 text-secondary"></i>Quản lý Tài khoản</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/reviews') }}"><i class="bi bi-chat-square-heart-fill me-2 text-secondary"></i>Quản lý Đánh giá</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/statistical') }}"><i class="bi bi-graph-up-arrow me-2 text-secondary"></i>Thống kê Doanh thu</a></li>
                        <li><a class="dropdown-item" href="http://localhost:8080/api/rooms" target="_blank"><i class="bi bi-code-slash me-2 text-danger"></i>API Quản lý Phòng</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        
                        <li><div class="dropdown-header text-uppercase text-warning fw-bold mt-1" style="font-size: 0.75rem; padding-left: 1rem;">Nghiệp vụ lễ tân</div></li>
                        <li><a class="dropdown-item" href="{{ url('/staff/room-map') }}"><i class="bi bi-grid-3x3-gap-fill me-2 text-warning"></i>Sơ đồ phòng trực quan</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/invoice') }}"><i class="bi bi-journal-bookmark-fill me-2 text-warning"></i>Quản lý Hoá Đơn</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/check-in') }}"><i class="bi bi-box-arrow-in-right me-2 text-warning"></i>Xử lý Nhận phòng (Check-in)</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/check-out') }}"><i class="bi bi-box-arrow-left me-2 text-warning"></i>Xử lý Trả phòng (Check-out)</a></li>
                        <li><hr class="dropdown-divider" /></li>
                    @elseif(Auth::user()->RoleID == 2)
                        <li><div class="dropdown-header text-uppercase text-warning fw-bold mt-1" style="font-size: 0.75rem; padding-left: 1rem;">Nghiệp vụ lễ tân</div></li>
                        <li><a class="dropdown-item" href="{{ url('/staff/room-map') }}"><i class="bi bi-grid-3x3-gap-fill me-2 text-warning"></i>Sơ đồ phòng trực quan</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/invoice') }}"><i class="bi bi-journal-bookmark-fill me-2 text-warning"></i>Quản lý Hoá Đơn</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/check-in') }}"><i class="bi bi-box-arrow-in-right me-2 text-warning"></i>Xử lý Nhận phòng (Check-in)</a></li>
                        <li><a class="dropdown-item" href="{{ url('/admin/check-out') }}"><i class="bi bi-box-arrow-left me-2 text-warning"></i>Xử lý Trả phòng (Check-out)</a></li>
                        <li><hr class="dropdown-divider" /></li>
                    @else
                        <!-- Khách hàng không có thêm menu -->
                    @endif
                    
                    @if(Auth::user()->RoleID == 3 || Auth::user()->RoleID == 1)
                        <li><a class="dropdown-item" href="{{ url('/home/booking/history') }}"><i class="bi bi-clock-history me-2"></i>Lịch sử đặt phòng</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="bi bi-person-circle me-2"></i>Hồ sơ của tôi</a></li>
                    <li>
                        <form action="{{ url('/logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger fw-bold mt-2"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button>
                        </form>
                    </li>
                @else
                    <!-- Chưa đăng nhập -->
                    <li><a class="dropdown-item" href="{{ url('/login') }}"><i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập</a></li>
                    <li><a class="dropdown-item" href="{{ url('/register') }}"><i class="bi bi-pencil-square me-2"></i>Đăng ký</a></li>
                @endif
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ==================== MAIN CONTENT ==================== -->
  <div class="main-content fade-in-box" id="app-content">
      @yield('content')
  </div>

  @if(!Auth::check() || (Auth::check() && Auth::user()->RoleID == 3))
  <!-- FOOTER -->
  <footer>
    <div class="container">
      <div class="row gy-5">
        <div class="col-md-4">
          <div class="brand-footer mb-3 d-flex align-items-center">
             <img src="{{ asset('images/Logo web.png') }}" alt="Logo" style="height: 40px; object-fit: contain; margin-right: 12px;">
             <span class="fw-bold fs-4">MAY HOTEL</span>
          </div>
          <p>Trải nghiệm sự sang trọng và tiện nghi bậc nhất. Chúng tôi cam kết mang đến cho bạn những kỳ nghỉ không thể nào quên.</p>
        </div>
        <div class="col-md-4">
          <h5>Liên hệ</h5>
          <p class="mb-2"><i class="bi bi-envelope me-2"></i> Email: MayHotel.hotel@gmail.com</p>
          <p class="mb-2"><i class="bi bi-telephone me-2"></i> Hotline: 1800 9327</p>
          <p><i class="bi bi-headset me-2"></i> CSKH: 038 8305167</p>
        </div>
        <div class="col-md-4">
          <h5>Kết nối & Địa chỉ</h5>
          <div class="social-icons mb-4">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
          </div>
          <p class="mb-2"><i class="bi bi-geo-alt me-2"></i> CN1: 140 Lê Trọng Tấn, TP. HCM</p>
          <p><i class="bi bi-geo-alt me-2"></i> CN2: 86 Tân Hòa Đông, Q.6, TP. HCM</p>
        </div>
      </div>
      <hr class="mt-5 mb-4 footer-divider" />
      <div class="row">
        <div class="col-12 text-center text-white-50 small">
          &copy; 2025 MAY HOTEL KINGS. All rights reserved.
        </div>
      </div>
    </div>
  </footer>
  @endif

  <!-- TOAST -->
  <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="toastNotification" class="toast align-items-center shadow-lg text-white border-0 bg-navy" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body fs-6 fw-medium px-4 py-3 d-flex align-items-center">
          <i id="toastIcon" class="bi bi-check-circle-fill me-3 fs-4 text-warning"></i>
          <div id="toastMessage">Thông báo từ hệ thống!</div>
        </div>
        <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <!-- CHATBOT -->
  <div id="chat-circle">
    <i class="bi bi-chat-dots-fill fs-3"></i>
  </div>
  
  <div class="chat-box" id="chat-box">
    <div class="chat-box-header">
      <div>
        <i class="bi bi-robot me-2 fs-5"></i>
        <span class="fw-bold">Hỗ trợ trực tuyến</span>
      </div>
      <span id="chat-box-close" class="fs-5" style="cursor:pointer; transition: 0.3s;"><i class="bi bi-x-lg"></i></span>
    </div>
    
    <div class="chat-box-body" id="chat-logs">
      <div class="msg-bot shadow-sm">
        Xin chào! Tôi là trợ lý ảo AI của May Hotel. Tôi có thể giúp gì cho bạn? <br />
        <small class="text-muted mt-1 d-block">(Ví dụ: "Giá phòng bao nhiêu", "Có hồ bơi không")</small>
      </div>
    </div>
    
    <div class="chat-input-area">
      <input type="text" id="chat-input" class="form-control" placeholder="Nhập tin nhắn..." autocomplete="off" />
      <button id="chat-submit" class="btn-send"><i class="bi bi-send-fill"></i></button>
    </div>
  </div>

  <!-- Javascript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('app.js') }}?v={{ time() }}"></script>
  
  @stack('scripts')
</body>
</html>
