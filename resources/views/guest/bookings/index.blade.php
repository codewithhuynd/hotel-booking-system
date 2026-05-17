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

        .btn-danger {
            background: #dc2626;
        }

        .muted {
            color: #64748b;
        }

        hr {
            border: none;
            border-top: 1px solid #e2e8f0;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            margin-top: 8px;
            margin-bottom: 14px;
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

            <div class="status">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</div>

            <br><br>

            @if($booking->status === 'pending')
                <p class="muted">Chờ host xác nhận booking.</p>
            @elseif($booking->status === 'awaiting_deposit')
                <p class="muted">Vui lòng thanh toán tiền cọc.</p>
            @elseif($booking->status === 'confirmed')
                <p style="color:green;">Booking đã được xác nhận.</p>
            @elseif($booking->status === 'checked_in')
                <p style="color:#2563eb;">Bạn đang lưu trú.</p>
            @elseif($booking->status === 'checked_out')
                <p style="color:#7c3aed;">Đã checkout.</p>
            @elseif($booking->status === 'completed')
                <p style="color:green;">Booking đã hoàn tất.</p>
            @elseif($booking->status === 'cancelled')
                <p style="color:red;">Booking đã bị hủy.</p>
            @endif

            @if($booking->depositPayment)
                <hr style="margin: 16px 0;">

                @php $deposit = $booking->depositPayment; @endphp

                <p>
                    <strong>Deposit payment:</strong>
                    <span class="status
                        {{ $deposit->status === 'paid' ? 'status-paid' : '' }}
                        {{ $deposit->status === 'pending' ? 'status-pending' : '' }}
                        {{ $deposit->status === 'expired' ? 'status-expired' : '' }}">
                        {{ $deposit->displayStatusLabel() }}
                    </span>
                </p>

                <p><strong>Số tiền:</strong> {{ number_format($deposit->deposit_amount) }} VND</p>
                <p><strong>Deadline:</strong> {{ $deposit->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}</p>

                @if($booking->status === 'awaiting_deposit' && $deposit->status === 'unpaid')
                    <a href="{{ route('guest.payments.show', $deposit) }}" class="btn">Thanh toán cọc</a>
                @elseif($deposit->status === 'pending')
                    <p class="muted">Đang chờ host xác nhận thanh toán cọc.</p>
                @elseif($deposit->status === 'paid')
                    <p style="color:green;">Đã thanh toán cọc.</p>
                @elseif($deposit->status === 'expired')
                    <p style="color:red;">Đã hết hạn thanh toán cọc.</p>
                @endif
            @endif

            @if($booking->finalPayment)
                <hr style="margin: 16px 0;">

                @php $final = $booking->finalPayment; @endphp

                <p>
                    <strong>Final payment:</strong>
                    <span class="status
                        {{ $final->status === 'paid' ? 'status-paid' : '' }}
                        {{ $final->status === 'pending' ? 'status-pending' : '' }}
                        {{ $final->status === 'expired' ? 'status-expired' : '' }}">
                        {{ $final->displayStatusLabel() }}
                    </span>
                </p>

                <p><strong>Số tiền còn lại:</strong> {{ number_format($final->deposit_amount) }} VND</p>
                <p><strong>Deadline:</strong> {{ $final->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}</p>

                @if($booking->status === 'checked_out' && $final->status === 'unpaid')
                    <a href="{{ route('guest.payments.show', $final) }}" class="btn">Thanh toán phần còn lại</a>
                @elseif($final->status === 'pending')
                    <p class="muted">Đang chờ host xác nhận thanh toán cuối.</p>
                @elseif($final->status === 'paid')
                    <p style="color:green;">Đã thanh toán phần còn lại.</p>
                @elseif($final->status === 'expired')
                    <p style="color:red;">Payment cuối đã hết hạn.</p>
                @endif
            @endif

            @if($booking->cancellation)
                <hr style="margin: 16px 0;">

                <h3>Thông tin hủy</h3>

                <p>
                    <strong>Hủy bởi:</strong>
                    {{ $booking->cancellation->cancelled_by_type === 'host' ? 'Host' : 'Guest' }}
                </p>

                <p><strong>Lý do:</strong> {{ $booking->cancellation->reason }}</p>

                @if($booking->cancellation->bank_name)
                    <p><strong>Ngân hàng refund:</strong> {{ $booking->cancellation->bank_name }}</p>
                    <p><strong>STK:</strong> {{ $booking->cancellation->bank_account_number }}</p>
                    <p><strong>Chủ TK:</strong> {{ $booking->cancellation->bank_account_name }}</p>
                @endif

                <p>
                    <strong>Hoàn tiền:</strong>
                    {{ $booking->cancellation->refund_completed ? 'Đã hoàn tiền' : 'Chờ hoàn tiền' }}
                </p>

                @if(
                    $booking->status === 'cancelled'
                    && $booking->cancellation->cancelled_by_type === 'host'
                    && !$booking->cancellation->refund_completed
                    && !$booking->cancellation->bank_name
                    && ($booking->depositPayment && in_array($booking->depositPayment->status, ['pending', 'paid'], true))
                )
                    <hr style="margin: 16px 0;">

                    <h3>Nhập thông tin tài khoản để nhận refund</h3>

                    <p class="muted">
                        Host đã hủy booking. Vui lòng cung cấp thông tin ngân hàng để host hoàn tiền.
                    </p>

                    <form method="POST" action="{{ route('guest.bookings.refund-bank', $booking) }}">
                        @csrf

                        <label>Ngân hàng</label>
                        <input type="text" name="bank_name" required value="{{ old('bank_name') }}">

                        <label>Số tài khoản</label>
                        <input type="text" name="bank_account_number" required value="{{ old('bank_account_number') }}">

                        <label>Tên chủ tài khoản</label>
                        <input type="text" name="bank_account_name" required value="{{ old('bank_account_name') }}">

                        <button type="submit" class="btn">
                            Gửi thông tin refund
                        </button>
                    </form>
                @elseif(
                    $booking->status === 'cancelled'
                    && $booking->cancellation->cancelled_by_type === 'host'
                    && !$booking->cancellation->refund_completed
                    && $booking->cancellation->bank_name
                )
                    <p class="muted">
                        Bạn đã gửi thông tin ngân hàng. Vui lòng chờ host hoàn tiền.
                    </p>
                @endif
            @endif

            @if(!in_array($booking->status, ['checked_in', 'checked_out', 'completed', 'cancelled'], true))
                <hr style="margin: 16px 0;">

                <a href="{{ route('guest.bookings.cancel-form', $booking) }}" class="btn btn-danger">
                    Hủy booking
                </a>
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