# Ghi chú đồ án CNPM

## Giả định nghiệp vụ

- Payment cọc được tạo khi Host xác nhận booking; lúc Guest gửi yêu cầu, booking ở trạng thái `pending` và chưa có payment.
- Payment `paid` được tính vào doanh thu theo `paid_at`; lượt đặt được tính theo `booked_at`.
- Công suất phòng dùng các đêm giao với kỳ lọc, loại booking `cancelled`, và mẫu số là số phòng đang hoạt động nhân số ngày trong kỳ.
- Tiền hoàn được tính bằng tổng payment `refunded` của booking có `refund_completed = true` trong kỳ.

## Chức năng đã thêm hoặc sửa

| Hạng mục | Nội dung | File liên quan |
|---|---|---|
| Lịch hết hạn cọc | Tự chạy `payments:expire-deposits` mỗi 5 phút; kiểm thử trước/sau deadline. | `routes/console.php`, `tests/Feature/DepositExpireTest.php` |
| Tìm phòng theo ngày | Validate ngày, lọc phòng trùng lịch bằng scope dùng chung, giữ ngày khi chuyển sang đặt phòng. | `app/Models/Booking.php`, `app/Http/Controllers/Guest/RoomController.php`, `app/Http/Controllers/Guest/BookingController.php`, `resources/views/partials/search-box.blade.php`, `resources/views/guest/rooms/index.blade.php`, `resources/views/guest/rooms/show.blade.php`, `resources/views/guest/bookings/create.blade.php`, `tests/Feature/RoomSearchTest.php` |
| Dashboard Host | Thống kê doanh thu, booking, hoàn tiền, công suất, biểu đồ theo tháng/trạng thái và top phòng. | `app/Services/StatisticsService.php`, `app/Http/Controllers/Host/DashboardController.php`, `resources/views/host/dashboard.blade.php`, `resources/views/host/layouts/app.blade.php`, `routes/web.php`, `tests/Feature/StatisticsServiceTest.php`, `tests/Feature/HostDashboardAuthorizationTest.php` |
| Chống đặt trùng đồng thời | Khóa dòng phòng và chạy kiểm tra giao lịch/tạo booking trong transaction. | `app/Http/Controllers/Guest/BookingController.php` |
| Luồng đặt và phân quyền | Thêm factories và feature test đặt phòng, lifecycle, hủy/hoàn tiền, quyền truy cập. | `database/factories/RoomFactory.php`, `database/factories/BookingFactory.php`, `database/factories/PaymentFactory.php`, `tests/Feature/BookingCreateTest.php`, `tests/Feature/BookingLifecycleTest.php`, `tests/Feature/BookingCancelRefundTest.php`, `tests/Feature/AuthorizationTest.php` |
| Trạng thái phòng | Check-in chuyển sang `occupied`, check-out chuyển sang `cleaning`; Host có thể mở lại phòng đang dọn/bảo trì. | `app/Http/Controllers/Host/BookingController.php`, `app/Http/Controllers/Host/RoomController.php`, `resources/views/host/rooms/index.blade.php`, `routes/web.php`, `tests/Feature/RoomStatusTest.php` |
| Dữ liệu demo | Seed 8 phòng, 40 booking qua 6 tháng, payment và một số hồ sơ hoàn tiền. | `database/seeders/RoomSeeder.php`, `database/seeders/BookingSeeder.php` |
| Gửi email xác minh | Bắt lỗi SMTP khi đăng ký/gửi lại, ghi log và hiển thị hướng dẫn thử lại bằng tiếng Việt. | `app/Http/Controllers/AuthController.php`, `app/Http/Controllers/Host/HostRegisterController.php`, `app/Http/Controllers/Auth/EmailVerificationController.php`, `resources/views/auth/verify-email.blade.php`, `tests/Feature/EmailVerificationDeliveryTest.php` |
| Dọn repo | Cập nhật giới thiệu/hướng dẫn README, xác nhận `.env` đã bị ignore, xóa `testmail.php`. | `README.md`, `.gitignore`, `testmail.php` (đã xóa) |

## Kiểm thử và seed

- Kết quả `php artisan test`: **54 tests passed, 221 assertions**.
- Đã chạy thành công migrate và seed trên SQLite in-memory bằng `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`.
- Sau khi MySQL được bật, đã chạy thành công `php artisan migrate:fresh --seed` theo cấu hình `.env`.
- Kết nối TCP tới `smtp.gmail.com:587` thành công ngoài sandbox; tiến trình Laravel được chạy ngoài sandbox để cho phép gửi SMTP.
- Lỗi SMTP khi gửi lại xác minh được xử lý an toàn trong `EmailVerificationDeliveryTest`; chưa gửi thư thử tới hộp thư thật.

## Bug đã tìm và sửa

| Mã bug | Mô tả | Cách tái hiện | Cách sửa |
|---|---|---|---|
| BUG-BOOKING-001 | Tạo booking thất bại nếu khách để trống ghi chú do controller đọc khóa `note` không tồn tại trong dữ liệu đã validate. | Gửi form đặt phòng hợp lệ nhưng bỏ trống trường ghi chú. | Lưu `null` khi dữ liệu validate không có khóa `note`; kiểm tra trong `BookingCreateTest`. |
| BUG-MAIL-001 | SMTP không kết nối được làm endpoint gửi lại email xác minh trả lỗi 500. | Khi Gmail SMTP cổng 587 không truy cập được, gửi lại email tại `/email/verify`. | Bắt lỗi vận chuyển, ghi log và hiển thị hướng dẫn tiếng Việt để kiểm tra kết nối SMTP; giữ tài khoản để người dùng thử gửi lại. |

## Thống kê mã nguồn

- Controller: **24**
- Model: **12**
- Blade view: **59**
- Migration: **18**
- Test PHP: **22**
- Dòng PHP trong `app/`: **2.991** (đếm toàn bộ file PHP trong `app/`).
