<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hủy booking</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f5f6fa;
            padding:40px;
        }
        .box{
            max-width:700px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:12px;
        }
        input,
        textarea{
            width:100%;
            padding:12px;
            margin-top:8px;
            margin-bottom:20px;
            border:1px solid #cbd5e1;
            border-radius:8px;
        }
        button{
            padding:12px 20px;
            border:none;
            background:#dc2626;
            color:white;
            border-radius:8px;
            cursor:pointer;
        }
        .muted{
            color:#64748b;
        }
    </style>
</head>
<body>

<div class="box">

    <h1>Hủy booking</h1>

    <br>

    <p><strong>Phòng:</strong> {{ $booking->room->room_name }}</p>
    <p><strong>Booking code:</strong> {{ $booking->booking_code }}</p>

    <br>

    @if($errors->any())
        <div style="color:red; margin-bottom:20px;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('guest.bookings.cancel', $booking) }}" method="POST">
        @csrf

        <label>Lý do hủy</label>
        <textarea name="reason" rows="5" required>{{ old('reason') }}</textarea>

        @php
            $needsRefund = $booking->depositPayment && in_array($booking->depositPayment->status, ['pending', 'paid'], true);
        @endphp

        @if($needsRefund)
            <p class="muted">Bạn đã chuyển cọc. Vui lòng nhập thông tin tài khoản để nhận refund.</p>

            <label>Ngân hàng nhận refund</label>
            <input type="text" name="bank_name" value="{{ old('bank_name') }}" required>

            <label>Số tài khoản</label>
            <input type="text" name="bank_account_number" value="{{ old('bank_account_number') }}" required>

            <label>Tên chủ tài khoản</label>
            <input type="text" name="bank_account_name" value="{{ old('bank_account_name') }}" required>
        @endif

        <button type="submit" onclick="return confirm('Bạn chắc chắn muốn hủy booking này?')">
            Xác nhận hủy booking
        </button>
    </form>

</div>

</body>
</html>