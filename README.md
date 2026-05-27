# 🏨 DolPHPhins Hotel Booking System

Hệ thống đặt phòng khách sạn trực tuyến được xây dựng bằng **Laravel 11**, phục vụ đồ án học phần Lập trình PHP. Dự án mô phỏng một khách sạn duy nhất với hai nhóm người dùng:

- **Guest** (Khách hàng): Tìm phòng, đặt phòng, thanh toán cọc, xem lịch sử booking, gửi liên hệ.
- **Host** (Chủ khách sạn / Quản trị viên): Quản lý phòng, ảnh phòng, đơn đặt, thanh toán, phương thức thanh toán, dịch vụ, liên hệ, người dùng và cài đặt khách sạn.

## 📋 Yêu cầu hệ thống

| Thành phần | Vai trò |
|------------|---------|
| PHP >= 8.1 | Ngôn ngữ nền tảng |
| MySQL 5.7+ / MariaDB 10.3+ | Cơ sở dữ liệu |
| Composer 2.x | Quản lý thư viện PHP |
| XAMPP (khuyên dùng) | Tích hợp Apache + MySQL + PHP |
| Git | Clone mã nguồn |

## 🚀 Hướng dẫn cài đặt chi tiết

1. Clone mã nguồn về máy:
   ```bash
   git clone https://github.com/codewithhuynd/hotel-booking-system.git
   cd hotel-booking-system

2. Cài đặt các gói PHP (Composer):
   ```bash
   composer install

3. Tạo file cấu hình môi trường:
   ```bash
   cp .env.example .env

4. Tạo Application Key:
   ```bash
   php artisan key:generate

5. Tạo database:
- Mở phpMyAdmin (http://localhost/phpmyadmin).
- Tạo database mới tên hotel_booking, chọn collation utf8mb4_general_ci.

6. Cấu hình database trong file .env:
- Mở file .env và sửa các dòng:
  ```text
   DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=hotel_booking
    DB_USERNAME=root
    DB_PASSWORD=

7. Tạo bảng và dữ liệu mẫu:
   ```bash
   php artisan migrate
   php artisan db:seed

8. Tạo liên kết thư mục lưu trữ (để hiển thị ảnh):
   ```bash
   php artisan storage:link

9. Khởi chạy ứng dụng:
- Với XAMPP (khuyên dùng): copy toàn bộ thư mục hotel-booking-system vào C:\xampp\htdocs\hotel-booking-system. Khởi động Apache và MySQL từ XAMPP Control Panel. Truy cập http://localhost/hotel-booking-system/public.
- Với Laragon: đặt project vào C:\laragon\www\hotel-booking-system và truy cập http://hotel-booking-system.test.
- Với PHP built-in server: php artisan serve rồi mở http://localhost:8000.

## 👥 Tài khoản mẫu (sau khi seed)
- Vai trò: Host ; Email: host@gmail.com ; Mật khẩu: 12345678
- Vai trò: Guest ; Email: guest1@gmail.com ; Mật khẩu: 12345678
- Có thể tạo nhanh qua Tinker:
    ```bash
    php artisan tinker
    User::create(['full_name'=>'Host','email'=>'host@gmail.com','password'=>bcrypt('12345678'),'role'=>'host']);
    exit

## 🧩 Cấu trúc thư mục chính
- Cấu trúc:
    ```text
    hotel-booking-system/
    ├── app/
    │   ├── Http/Controllers/   # Logic xử lý (Guest, Host)
    │   ├── Models/             # Eloquent Models
    │   └── Middleware/         # Phân quyền
    ├── database/
    │   ├── migrations/         # Tạo bảng
    │   └── seeders/            # Dữ liệu mẫu
    ├── resources/views/
    │   ├── home.blade.php      # Trang chủ one-page
    │   ├── guest/              # Giao diện khách hàng
    │   ├── host/               # Giao diện quản trị
    │   └── auth/               # Đăng nhập/đăng ký
    ├── routes/web.php          # Định tuyến toàn bộ ứng dụng
    ├── public/                 # Thư mục gốc web (ảnh, css, js)
    └── storage/app/public/     # Ảnh upload (phòng, QR code, bill...)

## 🔧 Xử lý sự cố thường gặp
- Lỗi 500 – Trang trắng: Xem file storage/logs/laravel.log để biết chi tiết. Thường do chưa tạo APP_KEY → chạy php artisan key:generate. Đảm bảo thư mục storage và bootstrap/cache có quyền ghi.
- "could not find driver" (PDOException): Mở php.ini trong XAMPP (C:\xampp\php\php.ini), bỏ dấu ; như các dòng bên dưới và sau đó Khởi động lại Apache.
    ```text
    extension=pdo_mysql
    extension=mysqlnd
- "Table 'hotel_booking.sessions' doesn't exist": Trong file .env, sửa SESSION_DRIVER=database thành SESSION_DRIVER=file, lưu lại và tải lại trang.
- Ảnh không hiển thị (phòng, QR, hero): Đảm bảo đã chạy php artisan storage:link. Kiểm tra file ảnh có tồn tại trong storage/app/public/rooms/ (hoặc payment_qr/, payment-methods/) không. Nếu thiếu, đăng nhập Host và upload lại ảnh qua giao diện quản lý.

## ⚙️ Các tính năng nổi bật
- ✅ **Tìm kiếm, lọc phòng, xem chi tiết phòng với slider ảnh.**
- ✅ **Đặt phòng, tự động tạo mã booking, thanh toán cọc qua nhiều phương thức.**
- ✅ **Upload bill, xác nhận thanh toán, hoàn tiền khi hủy.**
- ✅ **Quản lý phòng (CRUD), ảnh phòng (set ảnh chính, slider).**
- ✅ **Phân quyền Host/Guest rõ ràng qua Middleware.**
- ✅ **Trang chủ one-page với navbar fixed, cuộn mượt đến các section.**
- ✅ **Gửi tin nhắn liên hệ, Host trả lời.**
- ✅ **Cài đặt thông tin khách sạn (hero, địa chỉ, SĐT, bản đồ).**
- ✅ **Tự động hủy đặt cọc quá hạn (Command Schedule).**
- ✅ **Ràng buộc nghiệp vụ chặt chẽ (không xóa phòng khi có khách, chặn đổi trạng thái phòng sai logic, chỉ Host xóa được Guest, không xóa chính mình hay Host khác).**
