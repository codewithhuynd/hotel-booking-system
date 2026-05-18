<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hủy booking</title>
    <style>
        /* Thiết lập cơ bản */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background: #fff5f5; /* Nền trắng pha chút hồng đỏ rất nhẹ */
            color: #2d3748;
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        /* Hộp bọc chính màu trắng */
        .box {
            width: 100%;
            max-width: 600px;
            background: #ffffff; 
            padding: 35px;
            border-radius: 12px;
            border: 1px solid #fee2e2; /* Viền đỏ nhạt nhẹ nhàng */
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.05); /* Đổ bóng đỏ cực nhẹ */
        }
        /* Tiêu đề màu đỏ */
        h1 {
            color: #dc2626; 
            font-size: 26px;
            margin-bottom: 25px;
            text-align: center;
            border-bottom: 2px solid #fee2e2;
            padding-bottom: 12px;
        }
        /* Khu vực hiển thị thông tin phòng */
        .info-group {
            margin-bottom: 25px;
            background: #fafafa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #dc2626; /* Vạch đứng màu đỏ */
        }
        .info-group p {
            margin-bottom: 8px;
            font-size: 15px;
        }
        .info-group p:last-child {
            margin-bottom: 0;
        }
        /* Ô nhập liệu */
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            font-size: 14px;
            color: #4a5568;
        }
        input,
        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-family: inherit;
            font-size: 15px;
            background: #ffffff;
            outline: none;
        }
        /* Đổi màu viền sang đỏ khi click vào ô nhập */
        input:focus,
        textarea:focus {
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }
        /* Hộp báo lỗi dữ liệu */
        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        /* Thông báo hoàn tiền */
        .muted {
            background: #fff5f5;
            border: 1px dashed #fecaca;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.5;
        }
        /* Nút bấm màu đỏ chủ đạo */
        button {
            width: 100%;
            padding: 14px;
            border: none;
            background: #dc2626;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.2s;
        }
        button:hover {
            background: #b91c1c; /* Đỏ đậm hơn khi rê chuột vào */
        }
    </style>
</head>
<body>

<div class="box">

    <h1>Hủy đặt phòng</h1>

    <div class="info-group">
        <p><strong>Phòng:</strong> {{ $booking->room->room_name }}</p>
        <p><strong>Booking code:</strong> {{ $booking->booking_code }}</p>
    </div>

    @if($errors->any())
        <div class="error-box">
            @foreach($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('guest.bookings.cancel', $booking) }}" method="POST">
        @csrf

        <label>Lý do hủy</label>
        <textarea name="reason" rows="4" required placeholder="Vui lòng nhập lý do hủy phòng...">{{ old('reason') }}</textarea>

        @php
            $needsRefund = $booking->depositPayment && in_array($booking->depositPayment->status, ['pending', 'paid'], true);
        @endphp

        @if($needsRefund)
            <div class="muted">
                Bạn đã chuyển cọc. Vui lòng nhập thông tin tài khoản để nhận refund.
            </div>

            <label>Ngân hàng nhận refund</label>
            <input type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="Ví dụ: Vietcombank, Techcombank..." required>

            <label>Số tài khoản</label>
            <input type="text" name="bank_account_number" value="{{ old('bank_account_number') }}" placeholder="Nhập số tài khoản ngân hàng" required>

            <label>Tên chủ tài khoản</label>
            <input type="text" name="bank_account_name" value="{{ old('bank_account_name') }}" placeholder="Ví dụ: NGUYEN VAN A" required>
        @endif

        <button type="submit" onclick="return confirm('Bạn chắc chắn muốn hủy booking này?')">
            Xác nhận hủy booking
        </button>
    </form>

</div>

</body>
</html>