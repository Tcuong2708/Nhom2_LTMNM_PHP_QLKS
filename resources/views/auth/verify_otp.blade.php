@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('account/css/login.css') }}" />
    <style>
        .otp-input {
            width: 45px;
            height: 55px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border-radius: 8px;
            border: 1px solid #ced4da;
            margin: 0 5px;
        }
        .otp-input:focus {
            border-color: #d4af37;
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.5);
            outline: none;
        }
    </style>
@endpush

@section('content')
    <div class="login-wrapper fade-in-box">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card card-login shadow-lg border-0 my-5">

                        <div class="card-header-login text-center py-4 bg-navy text-white">
                            <h2 class="fw-bold">Xác thực OTP</h2>
                            <p class="mb-0 small opacity-75">Vui lòng kiểm tra email của bạn</p>
                        </div>

                        <div class="card-body p-4 p-md-5">

                            @if(session('error'))
                                <div class="alert alert-danger text-center mb-4" role="alert">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success text-center mb-4" role="alert">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif

                            <div class="text-center mb-4">
                                <i class="bi bi-envelope-paper text-warning" style="font-size: 3rem;"></i>
                                <p class="mt-3 text-muted">Chúng tôi đã gửi một mã OTP gồm 6 chữ số đến email: <br/> <strong>{{ session('register_data')['Email'] ?? 'Email của bạn' }}</strong></p>
                                <!-- DEV MODE: HIỂN THỊ OTP TẠM THỜI ĐỂ TEST -->
                                @if(session('dev_otp'))
                                    <div class="alert alert-warning mt-2 fw-bold text-danger">
                                        [DEV MODE] MÃ OTP CỦA BẠN LÀ: {{ session('dev_otp') }}
                                    </div>
                                @endif
                            </div>

                            <form action="{{ url('/register/verify') }}" method="POST" id="otpForm">
                                @csrf
                                <div class="d-flex justify-content-center mb-4">
                                    <input type="text" maxlength="1" class="otp-input" id="otp1" autofocus>
                                    <input type="text" maxlength="1" class="otp-input" id="otp2">
                                    <input type="text" maxlength="1" class="otp-input" id="otp3">
                                    <input type="text" maxlength="1" class="otp-input" id="otp4">
                                    <input type="text" maxlength="1" class="otp-input" id="otp5">
                                    <input type="text" maxlength="1" class="otp-input" id="otp6">
                                </div>
                                <input type="hidden" name="otp" id="fullOtp" required>

                                <button type="submit" class="btn btn-login w-100 py-3 fw-bold shadow-sm" onclick="combineOTP()">
                                    <i class="bi bi-check2-circle me-2"></i> XÁC NHẬN ĐĂNG KÝ
                                </button>
                            </form>

                            <form action="{{ url('/register/resend-otp') }}" method="POST" class="text-center mt-3">
                                @csrf
                                <p class="mb-1 text-muted">Chưa nhận được mã?</p>
                                <button type="submit" class="btn btn-link fw-bold text-decoration-none" style="color: #d4af37;">
                                    Gửi lại mã mới
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JS xử lý nhảy ô nhập OTP
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('keyup', (e) => {
                if (e.key >= 0 && e.key <= 9) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                } else if (e.key === 'Backspace') {
                    if (index > 0) {
                        inputs[index - 1].focus();
                    }
                }
            });
        });

        function combineOTP() {
            let otp = '';
            inputs.forEach(input => {
                otp += input.value;
            });
            document.getElementById('fullOtp').value = otp;
        }
    </script>
@endsection
