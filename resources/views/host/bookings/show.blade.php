@extends('host.layouts.app')

@section('title', 'Chi tiết booking')

@section('content')

@php
    $checkIn = $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date) : null;
    $checkOut = $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date) : null;
    $nights = ($checkIn && $checkOut) ? $checkIn->diffInDays($checkOut) : null;
    $bookedAt = $booking->booked_at ? \Carbon\Carbon::parse($booking->booked_at) : null;

    $statusLabels = [
        'pending' => 'Chờ xử lý',
        'awaiting_deposit' => 'Chờ đặt cọc',
        'confirmed' => 'Đã xác nhận',
        'checked_in' => 'Đang lưu trú',
        'checked_out' => 'Đã trả phòng',
        'completed' => 'Đã hoàn tất',
        'cancelled' => 'Đã hủy',
    ];

    $paymentStatusLabels = [
        'unpaid' => 'Chưa thanh toán',
        'pending' => 'Đang chờ',
        'paid' => 'Đã thanh toán',
        'expired' => 'Đã hết hạn',
        'refunded' => 'Đã hoàn tiền',
    ];

    $paymentMethodLabels = [
        'cash' => 'Tiền mặt',
        'banking' => 'Chuyển khoản',
        'momo' => 'MoMo',
        'vnpay' => 'VNPay',
    ];

    $roomStatusLabels = [
        'available' => 'Trống',
        'booked' => 'Đã đặt',
        'occupied' => 'Đang sử dụng',
        'cleaning' => 'Đang dọn',
        'maintenance' => 'Bảo trì',
    ];

    /*
    |--------------------------------------------------------------------------
    | CHỈ CÓ DEPOSIT PAYMENT VÀ ĐANG pending/paid MỚI ĐƯỢC REFUND
    |--------------------------------------------------------------------------
    */
    $hasPaidPayment = $booking->payments
        ->where('type', 'deposit')
        ->whereIn('status', ['pending', 'paid'])
        ->isNotEmpty();

    $canRefund =
        $booking->status === 'cancelled'
        && $hasPaidPayment
        && !($booking->cancellation?->refund_completed);
@endphp

<style>
    .booking-detail h1 { margin-bottom: 0.5rem; }
    .booking-detail .back-link {
        display: inline-block;
        margin-bottom: 1rem;
        color: #2563eb;
        text-decoration: none;
    }
    .booking-detail .back-link:hover { text-decoration: underline; }
    .booking-detail .alert-success {
        color: #166534;
        background: #dcfce7;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    .booking-detail .alert-error {
        color: #991b1b;
        background: #fee2e2;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    .booking-detail .card {
        background: white;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.25rem;
    }
    .booking-detail .card h2 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
        color: #1e293b;
    }
    .booking-detail .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1rem 1.5rem;
    }
    .booking-detail .field label {
        display: block;
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }
    .booking-detail .field .value {
        font-size: 0.95rem;
        color: #0f172a;
        word-break: break-word;
    }
    .booking-detail .field .value.muted {
        color: #94a3b8;
        font-style: italic;
    }
    .booking-detail .status-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 600;
        background: #e2e8f0;
        color: #334155;
    }
    .booking-detail .status-badge.pending { background: #fef3c7; color: #92400e; }
    .booking-detail .status-badge.awaiting_deposit { background: #ffedd5; color: #9a3412; }
    .booking-detail .status-badge.confirmed { background: #dbeafe; color: #1e40af; }
    .booking-detail .status-badge.checked_in { background: #d1fae5; color: #065f46; }
    .booking-detail .status-badge.checked_out { background: #f3f4f6; color: #374151; }
    .booking-detail .status-badge.completed { background: #dcfce7; color: #166534; }
    .booking-detail .status-badge.cancelled { background: #fee2e2; color: #991b1b; }
    .booking-detail .note-box {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #94a3b8;
        white-space: pre-wrap;
    }
    .booking-detail .actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }
    .booking-detail .actions button,
    .booking-detail .actions .btn-link {
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-block;
    }
    .booking-detail .btn-confirm { background: #16a34a; }
    .booking-detail .btn-checkin { background: #2563eb; }
    .booking-detail .btn-checkout { background: #7c3aed; }
    .booking-detail .btn-cancel { background: #dc2626; }
    .booking-detail .btn-refund { background: #16a34a; }
    .booking-detail .proof-link { color: #2563eb; text-decoration: none; }
</style>

<div class="booking-detail">

    <a href="{{ route('host.bookings.index') }}" class="back-link">← Danh sách booking</a>

    <h1>Chi tiết booking</h1>
    <p style="color:#64748b; margin-bottom:1.25rem;">
        Mã: <strong>{{ $booking->booking_code ?? '—' }}</strong>
        · ID: #{{ $booking->id }}
    </p>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="card">
        <h2>Tổng quan</h2>
        <div class="grid">
            <div class="field">
                <label>Mã booking</label>
                <div class="value">{{ $booking->booking_code ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Trạng thái</label>
                <div class="value">
                    <span class="status-badge {{ $booking->status }}">
                        {{ $statusLabels[$booking->status] ?? strtoupper($booking->status) }}
                    </span>
                </div>
            </div>
            <div class="field">
                <label>Thời điểm đặt (booked_at)</label>
                <div class="value">
                    @if($bookedAt)
                        {{ $bookedAt->format('d/m/Y H:i') }}
                    @else
                        <span class="muted">—</span>
                    @endif
                </div>
            </div>
            <div class="field">
                <label>Tạo lúc</label>
                <div class="value">{{ $booking->created_at?->format('d/m/Y H:i') ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Cập nhật lúc</label>
                <div class="value">{{ $booking->updated_at?->format('d/m/Y H:i') ?? '—' }}</div>
            </div>
            @if($booking->deleted_at)
                <div class="field">
                    <label>Đã xóa mềm</label>
                    <div class="value">{{ $booking->deleted_at?->format('d/m/Y H:i') }}</div>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <h2>Khách & liên hệ</h2>
        <div class="grid">
            <div class="field">
                <label>Tài khoản (user)</label>
                <div class="value">{{ $booking->user?->full_name ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Email tài khoản</label>
                <div class="value">{{ $booking->user?->email ?? '—' }}</div>
            </div>
            <div class="field">
                <label>SĐT tài khoản</label>
                <div class="value">{{ $booking->user?->phone ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Tên liên hệ</label>
                <div class="value">{{ $booking->contact_name ?? '—' }}</div>
            </div>
            <div class="field">
                <label>SĐT liên hệ</label>
                <div class="value">{{ $booking->contact_phone ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Email liên hệ</label>
                <div class="value">{{ $booking->contact_email ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Số khách</label>
                <div class="value">{{ $booking->guest_count ?? '—' }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Phòng</h2>
        <div class="grid">
            <div class="field">
                <label>Mã phòng</label>
                <div class="value">{{ $booking->room?->room_code ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Tên phòng</label>
                <div class="value">{{ $booking->room?->room_name ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Sức chứa</label>
                <div class="value">{{ $booking->room?->capacity ?? '—' }} khách</div>
            </div>
            <div class="field">
                <label>Giá phòng</label>
                <div class="value">
                    @if($booking->room?->price !== null)
                        {{ number_format($booking->room->price, 0, ',', '.') }} VND/đêm
                    @else
                        —
                    @endif
                </div>
            </div>
            <div class="field">
                <label>Trạng thái phòng</label>
                <div class="value">
                    {{ $roomStatusLabels[$booking->room?->status] ?? ($booking->room?->status ?? '—') }}
                </div>
            </div>
            @if($booking->room?->description)
                <div class="field" style="grid-column: 1 / -1;">
                    <label>Mô tả phòng</label>
                    <div class="value">{{ $booking->room->description }}</div>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <h2>Lịch lưu trú</h2>
        <div class="grid">
            <div class="field">
                <label>Nhận phòng</label>
                <div class="value">{{ $checkIn?->format('d/m/Y') ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Trả phòng</label>
                <div class="value">{{ $checkOut?->format('d/m/Y') ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Số đêm</label>
                <div class="value">{{ $nights !== null ? $nights . ' đêm' : '—' }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Giá booking</h2>
        <div class="grid">
            <div class="field">
                <label>Giá phòng tại thời điểm đặt</label>
                <div class="value">
                    {{ number_format($booking->room_price, 0, ',', '.') }} VND/đêm
                </div>
            </div>
            <div class="field">
                <label>Tổng tiền</label>
                <div class="value">
                    {{ number_format($booking->total_price, 0, ',', '.') }} VND
                </div>
            </div>
            <div class="field">
                <label>Tiền cọc</label>
                <div class="value">
                    {{ number_format($booking->deposit_amount, 0, ',', '.') }} VND
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Thanh toán</h2>

        @if($booking->payments->count())
            @foreach($booking->payments as $payment)
                <div style="border:1px solid #e2e8f0; border-radius:10px; padding:20px; margin-bottom:16px;">
                    <h3 style="margin-bottom:12px;">
                        {{ strtoupper($payment->type) }} PAYMENT
                    </h3>

                    <div class="grid">
                        <div class="field">
                            <label>ID payment</label>
                            <div class="value">#{{ $payment->id }}</div>
                        </div>
                        <div class="field">
                            <label>Mã giao dịch</label>
                            <div class="value">{{ $payment->transaction_code ?? '—' }}</div>
                        </div>
                        <div class="field">
                            <label>Số tiền</label>
                            <div class="value">{{ number_format($payment->deposit_amount, 0, ',', '.') }} VND</div>
                        </div>
                        <div class="field">
                            <label>Phương thức</label>
                            <div class="value">{{ $paymentMethodLabels[$payment->payment_method] ?? $payment->payment_method }}</div>
                        </div>
                        <div class="field">
                            <label>Trạng thái</label>
                            <div class="value">{{ $paymentStatusLabels[$payment->status] ?? $payment->status }}</div>
                        </div>
                        <div class="field">
                            <label>Hạn thanh toán</label>
                            <div class="value">
                                {{ $payment->deposit_deadline ? \Carbon\Carbon::parse($payment->deposit_deadline)->format('d/m/Y H:i') : '—' }}
                            </div>
                        </div>
                        <div class="field">
                            <label>Đã thanh toán lúc</label>
                            <div class="value">
                                {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') : '—' }}
                            </div>
                        </div>
                        <div class="field">
                            <label>Proof image</label>
                            <div class="value">
                                @if($payment->proof_image)
                                    <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="proof-link">Xem ảnh</a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="value muted">Chưa có bản ghi thanh toán.</p>
        @endif
    </div>

    <div class="card">
        <h2>Ghi chú</h2>
        @if(filled($booking->note))
            <div class="note-box">{{ $booking->note }}</div>
        @else
            <p class="value muted">Không có ghi chú.</p>
        @endif
    </div>

    @if($booking->status === 'cancelled' || $booking->cancellation)
        <div class="card">
            <h2>Thông tin hủy</h2>

            @if($booking->cancellation)
                <div class="grid">
                    <div class="field">
                        <label>Người hủy</label>
                        <div class="value">{{ $booking->cancellation->cancelledBy?->full_name ?? '—' }}</div>
                    </div>

                    <div class="field">
                        <label>Thời điểm hủy</label>
                        <div class="value">
                            {{ $booking->cancellation->cancelled_at?->format('d/m/Y H:i') ?? '—' }}
                        </div>
                    </div>

                    <div class="field" style="grid-column: 1 / -1;">
                        <label>Lý do</label>
                        <div class="value">{{ $booking->cancellation->reason ?? '—' }}</div>
                    </div>

                    @if($hasPaidPayment)
                        <div class="field">
                            <label>Ngân hàng refund</label>
                            <div class="value">{{ $booking->cancellation->bank_name ?? '—' }}</div>
                        </div>

                        <div class="field">
                            <label>Số tài khoản</label>
                            <div class="value">{{ $booking->cancellation->bank_account_number ?? '—' }}</div>
                        </div>

                        <div class="field">
                            <label>Chủ tài khoản</label>
                            <div class="value">{{ $booking->cancellation->bank_account_name ?? '—' }}</div>
                        </div>

                        <div class="field">
                            <label>Refund status</label>
                            <div class="value">
                                {{ $booking->cancellation->refund_completed ? 'Đã hoàn tiền' : 'Chờ hoàn tiền' }}
                            </div>
                        </div>

                        <div class="field">
                            <label>Mã giao dịch hoàn tiền</label>
                            <div class="value">{{ $booking->cancellation->refund_transaction_code ?? '—' }}</div>
                        </div>

                        <div class="field">
                            <label>Ảnh giao dịch hoàn tiền</label>
                            <div class="value">
                                @if($booking->cancellation->refund_proof_image)
                                    <a
                                        href="{{ asset('storage/' . $booking->cancellation->refund_proof_image) }}"
                                        target="_blank"
                                        class="proof-link"
                                    >
                                        Xem ảnh
                                    </a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <p class="value muted">Chưa có bản ghi hủy.</p>
            @endif
        </div>
    @endif

    @if($canRefund)
        <div class="card">
            <h2>Hoàn tiền cho booking bị hủy</h2>

            <form
                method="POST"
                action="{{ route('host.booking-cancellations.refund', $booking->cancellation) }}"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="grid">
                    <div class="field" style="grid-column: 1 / -1;">
                        <label>Mã giao dịch hoàn tiền</label>
                        <input
                            type="text"
                            name="refund_transaction_code"
                            required
                            style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px;"
                            value="{{ old('refund_transaction_code') }}"
                        >
                    </div>

                    <div class="field" style="grid-column: 1 / -1;">
                        <label>Ảnh giao dịch hoàn tiền</label>
                        <input
                            type="file"
                            name="refund_proof_image"
                            accept="image/*"
                            required
                            style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px;"
                        >
                    </div>
                </div>

                <button
                    type="submit"
                    class="btn-refund"
                    onclick="return confirm('Xác nhận đã hoàn tiền?')"
                >
                    Xác nhận hoàn tiền
                </button>
            </form>
        </div>
    @endif

    <div class="card">
        <h2>Thao tác</h2>
        <div class="actions">
            @if($booking->status === 'pending')
                <form method="POST" action="{{ route('host.bookings.confirm', $booking) }}">
                    @csrf
                    <button type="submit" class="btn-confirm">Xác nhận booking</button>
                </form>
            @endif

            @if($booking->status === 'confirmed')
                <form method="POST" action="{{ route('host.bookings.check-in', $booking) }}">
                    @csrf
                    <button type="submit" class="btn-checkin">Check-in</button>
                </form>
            @endif

            @if($booking->status === 'checked_in')
                <form method="POST" action="{{ route('host.bookings.check-out', $booking) }}">
                    @csrf
                    <button type="submit" class="btn-checkout">Check-out</button>
                </form>
            @endif

            @if(!in_array($booking->status, ['checked_out', 'cancelled', 'completed'], true))
                <form method="POST" action="{{ route('host.bookings.cancel', $booking) }}">
                    @csrf
                    <button type="submit" class="btn-cancel" onclick="return confirm('Hủy booking này?')">
                        Hủy booking
                    </button>
                </form>
            @endif
        </div>
    </div>

</div>

@endsection