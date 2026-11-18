# Ghi chú đồ án CNPM

## Bug tìm thấy và đã sửa

| Mã bug | Mô tả | Cách tái hiện | Cách sửa |
|---|---|---|---|
| BUG-BOOKING-001 | Tạo booking thất bại nếu khách để trống ghi chú do controller đọc khóa `note` không tồn tại trong dữ liệu đã validate. | Gửi form đặt phòng hợp lệ nhưng bỏ trống trường ghi chú. | Lưu `null` khi dữ liệu validate không có khóa `note`; kiểm tra trong `BookingCreateTest`. |

## Giả định nghiệp vụ

- Payment cọc được tạo khi Host xác nhận booking; lúc Guest gửi yêu cầu, booking ở trạng thái `pending` và chưa có payment.
- Payment `paid` được tính vào doanh thu theo `paid_at`; lượt đặt được tính theo `booked_at`.
- Công suất phòng dùng các đêm giao với kỳ lọc, loại booking `cancelled`, và mẫu số là số phòng đang hoạt động nhân số ngày trong kỳ.
- Tiền hoàn được tính bằng tổng payment `refunded` của booking có `refund_completed = true` trong kỳ.
