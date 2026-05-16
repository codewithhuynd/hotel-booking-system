<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>My Bookings</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            padding: 40px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: bold;
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-paid {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-expired {
            background: #fee2e2;
            color: #991b1b;
        }

        .price {
            color: #16a34a;
            font-size: 20px;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .muted {
            color: #64748b;
        }
    </style>
</head>

<body>
<div class="container">

    <h1>Đơn đặt phòng của tôi</h1>

    <br>

    @if(session('success'))
        <p style="color:green;">{{ session('success') }}</p>
        <br>
    @endif

    @if(session('error'))
        <p style="color:red;">{{ session('error') }}</p>
        <br>
    @endif

    @forelse($bookings as $booking)

        <div class="card">

            <h2>{{ $booking->room->room_name }}</h2>

            <br>

            <p><strong>Mã booking:</strong> {{ $booking->booking_code }}</p>
            <br>
            <p><strong>Check-in:</strong> {{ $booking->check_in_date?->format('d/m/Y') ?? $booking->check_in_date }}</p>
            <br>
            <p><strong>Check-out:</strong> {{ $booking->check_out_date?->format('d/m/Y') ?? $booking->check_out_date }}</p>
            <br>
            <p><strong>Số khách:</strong> {{ $booking->guest_count }}</p>
            <br>

            <p class="price">{{ number_format($booking->total_price) }} VND</p>
            <br>

            <div class="status">{{ ucfirst($booking->status) }}</div>

            <br><br>

            @if($booking->status === 'pending')
                <p class="muted">Chờ host xác nhận booking.</p>
            @endif

            @if($booking->depositPayment)
                <hr style="margin: 16px 0;">

                <p>
                    <strong>Deposit payment:</strong>
                    <span class="status {{ $booking->depositPayment->status === 'paid' ? 'status-paid' : ($booking->depositPayment->status === 'pending' ? 'status-pending' : ($booking->depositPayment->status === 'expired' ? 'status-expired' : '')) }}">
                        {{ $booking->depositPayment->displayStatusLabel() }}
                    </span>
                </p>

                <p><strong>Số tiền:</strong> {{ number_format($booking->depositPayment->deposit_amount) }} VND</p>
                <p><strong>Deadline:</strong> {{ $booking->depositPayment->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}</p>

                @if($booking->status === 'awaiting_deposit' && $booking->depositPayment->status === 'unpaid')
                    <a href="{{ route('guest.payments.show', $booking->depositPayment) }}" class="btn">Thanh toán cọc</a>
                @elseif($booking->depositPayment->status === 'pending')
                    <p class="muted">Đang chờ host xác nhận thanh toán cọc.</p>
                @elseif($booking->depositPayment->status === 'paid')
                    <p style="color:green;">Đã thanh toán cọc.</p>
                @elseif($booking->depositPayment->status === 'expired')
                    <p style="color:red;">Đã hết hạn thanh toán cọc.</p>
                @endif
            @endif

            @if($booking->finalPayment)
                <hr style="margin: 16px 0;">

                <p>
                    <strong>Final payment:</strong>
                    <span class="status {{ $booking->finalPayment->status === 'paid' ? 'status-paid' : ($booking->finalPayment->status === 'pending' ? 'status-pending' : ($booking->finalPayment->status === 'expired' ? 'status-expired' : '')) }}">
                        {{ $booking->finalPayment->displayStatusLabel() }}
                    </span>
                </p>

                <p><strong>Số tiền còn lại:</strong> {{ number_format($booking->finalPayment->deposit_amount) }} VND</p>
                <p><strong>Deadline:</strong> {{ $booking->finalPayment->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}</p>

                @if($booking->status === 'checked_out' && $booking->finalPayment->status === 'unpaid')
                    <a href="{{ route('guest.payments.show', $booking->finalPayment) }}" class="btn">Thanh toán phần còn lại</a>
                @elseif($booking->finalPayment->status === 'pending')
                    <p class="muted">Đang chờ host xác nhận thanh toán cuối.</p>
                @elseif($booking->finalPayment->status === 'paid')
                    <p style="color:green;">Đã thanh toán phần còn lại.</p>
                @elseif($booking->finalPayment->status === 'expired')
                    <p style="color:red;">Payment cuối đã hết hạn.</p>
                @endif
            @endif

        </div>

    @empty
        <div class="card">
            <p>Bạn chưa có booking nào.</p>
        </div>
    @endforelse

</div>
</body>
</html>