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
| Dọn repo | Cập nhật giới thiệu/hướng dẫn README, xác nhận `.env` đã bị ignore, xóa `testmail.php`. | `README.md`, `.gitignore`, `testmail.php` (đã xóa) |

## Kiểm thử và seed

- Kết quả `php artisan test`: **52 tests passed, 211 assertions**.
- `php artisan migrate:fresh --seed` theo cấu hình `.env` không kết nối được vì MySQL tại `127.0.0.1:3306` chưa chạy.
- Đã chạy thành công migrate và seed trên SQLite in-memory bằng `DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`.

## Bug đã tìm và sửa

| Mã bug | Mô tả | Cách tái hiện | Cách sửa |
|---|---|---|---|
| BUG-BOOKING-001 | Tạo booking thất bại nếu khách để trống ghi chú do controller đọc khóa `note` không tồn tại trong dữ liệu đã validate. | Gửi form đặt phòng hợp lệ nhưng bỏ trống trường ghi chú. | Lưu `null` khi dữ liệu validate không có khóa `note`; kiểm tra trong `BookingCreateTest`. |

## Thống kê mã nguồn

- Controller: **24**
- Model: **12**
- Blade view: **59**
- Migration: **18**
- Test PHP: **21**
- Dòng PHP trong `app/`: **2.956** (đếm toàn bộ file PHP trong `app/`).
