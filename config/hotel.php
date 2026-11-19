<?php

/*
|--------------------------------------------------------------------------
| Quy tắc nghiệp vụ của khách sạn
|--------------------------------------------------------------------------
| Có thể ghi đè bằng biến môi trường tương ứng trong .env / Railway Variables.
*/

return [

    // Số giờ khách có để đặt cọc sau khi host xác nhận booking.
    'deposit_deadline_hours' => (int) env('HOTEL_DEPOSIT_DEADLINE_HOURS', 24),

    // Số giờ khách có để thanh toán phần còn lại sau khi check-out.
    'final_deadline_hours' => (int) env('HOTEL_FINAL_DEADLINE_HOURS', 24),

    // Booking 'pending' mà host không xác nhận sau số giờ này sẽ tự huỷ.
    'pending_expire_hours' => (int) env('HOTEL_PENDING_EXPIRE_HOURS', 48),

    // Khách huỷ trước ngày nhận phòng ít nhất số ngày này thì được hoàn cọc;
    // huỷ muộn hơn thì khách sạn giữ lại tiền cọc.
    'free_cancellation_days' => (int) env('HOTEL_FREE_CANCELLATION_DAYS', 3),

];
