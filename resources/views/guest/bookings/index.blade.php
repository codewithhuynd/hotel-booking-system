<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="utf-8">

    <title>
        My Bookings
    </title>

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
    </style>

</head>

<body>

    <div class="container">

        <h1>
            Đơn đặt phòng của tôi
        </h1>

        <br>

        @forelse($bookings as $booking)

        <div class="card">

            <h2>
                {{ $booking->room->room_name }}
            </h2>

            <br>

            <p>
                <strong>Mã booking:</strong>
                {{ $booking->booking_code }}
            </p>

            <br>

            <p>
                <strong>Check-in:</strong>
                {{ $booking->check_in_date }}
            </p>

            <br>

            <p>
                <strong>Check-out:</strong>
                {{ $booking->check_out_date }}
            </p>

            <br>

            <p>
                <strong>Số khách:</strong>
                {{ $booking->guest_count }}
            </p>

            <br>

            <p class="price">
                {{ number_format($booking->total_price) }} VND
            </p>

            <br>

            {{-- STATUS BOOKING --}}
            <div class="status">
                {{ ucfirst($booking->status) }}
            </div>

            <br><br>

            {{-- PAYMENT INFO --}}
            @if($booking->payment)

            <p>
                <strong>Thanh toán cọc:</strong>
                {{ strtoupper($booking->payment->status) }}
            </p>

            <p>
                <strong>Tiền cọc:</strong>
                {{ number_format($booking->payment->deposit_amount) }} VND
            </p>

            <p>
                <strong>Hạn thanh toán:</strong>
                {{ $booking->payment->deposit_deadline }}
            </p>

            <br>

            {{-- NÚT THANH TOÁN --}}
            @if($booking->payment->status === 'unpaid')

            <a
                href="{{ route('guest.payments.show', $booking->payment) }}"
                class="btn">
                Thanh toán cọc
            </a>

            @elseif($booking->payment->status === 'pending')

            <span style="color:orange; font-weight:bold;">
                Đang chờ xác nhận thanh toán
            </span>

            @elseif($booking->payment->status === 'paid')

            <span style="color:green; font-weight:bold;">
                Đã thanh toán cọc
            </span>

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