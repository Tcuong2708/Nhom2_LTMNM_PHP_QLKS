# Ghi chú Cập nhật - Module Nghiệp vụ Lễ Tân
*Ngày thực hiện: 20/09/2026*

Tài liệu này ghi lại toàn bộ các thay đổi, chỉnh sửa và thêm mới trong mã nguồn nhằm hoàn thiện chức năng **Nghiệp vụ Lễ tân** (Sơ đồ phòng, Check-in, Check-out, Quản lý Hóa đơn) và khắc phục các lỗi hệ thống của Laravel.

---

## 1. Thêm mới các API Controllers (Backend)
Tạo mới 4 Controllers tại thư mục `app/Http/Controllers/Api/Staff/` để xử lý logic lấy dữ liệu thật từ Database (thay vì dùng dữ liệu cứng):
- **`RoomMapController.php`**: API lấy sơ đồ phòng (`/api/rooms/map`).
- **`CheckinController.php`**: API xử lý lấy danh sách chờ check-in và thực hiện check-in (`/api/checkin/init`, `/api/checkin/execute`).
- **`CheckoutController.php`**: API xử lý lấy danh sách trả phòng và kết toán (`/api/checkout/invoices`, `/api/checkout/execute`).
- **`InvoiceController.php`**: API quản lý hóa đơn.

> **Đặc biệt lưu ý về Code:** 
> - Đã thiết lập sẵn cơ chế **Mock Data (Dữ liệu giả)** bên trong các Controller. Nếu Database (bảng Phòng, Hóa Đơn) bị rỗng, hệ thống sẽ tự động trả về dữ liệu ảo để phục vụ test giao diện (tránh lỗi trắng trang). Khi có dữ liệu thật trong MySQL, cơ chế này tự ẩn đi.
> - **Sửa lỗi kế thừa Controller:** Do dự án bị thiếu mất file base `Controller.php` gốc của Laravel, nên toàn bộ 4 file Controller này đã được xóa bỏ cú pháp `extends Controller` để tránh lỗi sập PHP ngầm (Class Not Found).

## 2. Cấu hình lại Route (Backend)
- **Sửa file:** `routes/api.php`
- Đã khai báo (register) toàn bộ các endpoint API cho 4 Controller trên để Frontend có thể gọi được thông qua đường dẫn `http://localhost:8080/api/...`.

## 3. Cập nhật mã nguồn Frontend (JS)
Chuyển đổi toàn bộ các trang giao diện của Lễ tân từ việc dùng dữ liệu cứng tĩnh (Fake Arrays) sang việc gọi API động bằng `fetch()`:
- **Sửa file:** `frontend/staff/room-map/js/index.js` -> Đổ dữ liệu sơ đồ phòng, tự động đổi màu trạng thái phòng.
- **Sửa file:** `frontend/admin/check-in/js/index.js` -> Xử lý thao tác nhận phòng.
- **Sửa file:** `frontend/admin/check-out/js/index.js` -> Lấy danh sách trả phòng. **[FIX LỖI]** Đã bổ sung logic đọc `roomId` từ URL (Sơ đồ phòng gửi sang) và lọc danh sách hóa đơn tương ứng, giúp màn hình Check-out không bị lỗi "râu ông nọ cắm cằm bà kia".

## 4. Khôi phục các File Core của Laravel (Rất quan trọng)
Dự án ban đầu bị mất hoặc trống trơn (0 byte) hàng loạt file quan trọng dùng để khởi động ứng dụng Laravel. Đã khôi phục và cấu hình lại theo chuẩn Laravel 11:
- **Khôi phục file:** `artisan` (Để nhận lệnh qua Terminal).
- **Khôi phục file:** `server.php` (Để chạy server nội bộ).
- **Khôi phục file:** `public/index.php` (Cửa ngõ chính của Backend).
- **Khôi phục file:** `bootstrap/app.php` (Nạp Route và Middleware).
*(Các file này đều được đánh dấu bằng comment `// [BOT NOTE]` ở dòng số 2 để các lập trình viên khác trong team dễ dàng nhận diện).*

---

### Hướng dẫn chạy Test chuẩn nhất cho Team
1. Cần Import file `database/QLKS.sql` vào MySQL qua phần mềm HeidiSQL trên Laragon.
2. Cấu hình port của Apache trên Laragon sang `8888` (tránh đụng cổng 8080 của Laravel). Bật **Start All** (Chỉ cần MySQL và Apache chạy).
3. Mở Terminal và gõ lệnh `php artisan serve --port=8080` để khởi chạy Backend.
4. Mở trực tiếp file `index.html` trong thư mục `frontend/staff/room-map/` trên Chrome để xem thành quả.
