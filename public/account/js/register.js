document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('register-form');
    const errorBox = document.getElementById('error-message');
    const errorText = errorBox.querySelector('span');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorBox.style.display = 'none';

        const payload = {
            tenDangNhap: document.getElementById('tenDangNhap').value.trim(),
            matKhau: document.getElementById('matKhau').value,
            hoTen: document.getElementById('hoTen').value.trim(),
            email: document.getElementById('email').value.trim(),
            soDienThoai: document.getElementById('soDienThoai').value.trim(),
            quocTich: document.getElementById('quocTich').value.trim(),
            diaChi: document.getElementById('diaChi').value.trim()
        };

        const submitBtn = document.getElementById('btn-submit');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang xử lý...';

        try {
            const API_URL = 'http://localhost:8080/api/auth/register';
            
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({ message: 'Đăng ký thất bại. Vui lòng kiểm tra lại thông tin.' }));
                throw new Error(errorData.message || 'Tên đăng nhập hoặc Email có thể đã tồn tại.');
            }

            // Chuyển hướng đến trang xác thực OTP hoặc thông báo thành công
            // Nếu API gửi OTP:
            const data = await response.json().catch(() => ({}));
            
            // Redirect sang trang nhập OTP, truyền email qua query param để lấy ở trang sau
            window.location.href = `verify_register_otp.html?email=${encodeURIComponent(payload.email)}`;

        } catch (error) {
            console.error('Register error:', error);
            errorText.textContent = error.message;
            errorBox.style.display = 'block';
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-person-plus-fill me-2"></i> ĐĂNG KÝ NGAY';
        }
    });
});
