# Dolphins Hotel Booking System

Đây là đồ án môn **Công nghệ phần mềm**: hệ thống quản lý đặt phòng khách sạn trực tuyến, xây dựng bằng Laravel 11. Ứng dụng mô phỏng hoạt động của một khách sạn với hai vai trò Guest và Host.

## Chức năng theo vai trò

- **Guest (khách):** tìm phòng theo tên, giá, sức chứa và ngày trống; xem chi tiết phòng; đặt và theo dõi booking; gửi chứng từ thanh toán; hủy booking và cung cấp thông tin nhận hoàn tiền; quản lý hồ sơ và gửi tin nhắn liên hệ.
- **Host (chủ khách sạn):** xem dashboard doanh thu, booking, hoàn tiền và công suất phòng; quản lý phòng, ảnh, booking và trạng thái nhận/trả phòng; xác nhận thanh toán và hoàn tiền; quản lý phương thức thanh toán, dịch vụ, nội dung giới thiệu, người dùng, tin nhắn và cài đặt khách sạn.

## Yêu cầu

- PHP 8.2 trở lên và Composer 2
- MySQL 5.7+ hoặc MariaDB 10.3+
- Node.js/npm nếu cần biên dịch tài nguyên frontend

## Cài đặt

```bash
git clone https://github.com/codewithhuynd/hotel-booking-system.git
cd hotel-booking-system
composer install
cp .env.example .env
php artisan key:generate
```

Tạo database `hotel_booking`, sau đó cấu hình `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` và `DB_PASSWORD` trong `.env`.

```bash
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Mở `http://localhost:8000`. Tài khoản demo sau khi seed:

- Host: `host@gmail.com` / `12345678`
- Guest: `guest1@gmail.com` / `12345678`

## Lịch tự động

Lệnh tự hết hạn payment cọc được lên lịch chạy mỗi 5 phút. Khi phát triển cục bộ, mở thêm một terminal và chạy:

```bash
php artisan schedule:work
```

Trong môi trường production, cấu hình Laravel Scheduler gọi `php artisan schedule:run` mỗi phút theo hướng dẫn của Laravel.
