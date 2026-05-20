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

    $hasRefundableDeposit = $booking->payments
        ->where('type', 'deposit')
        ->whereIn('status', ['pending', 'paid'])
        ->isNotEmpty();

    $hasRefundBankInfo =
        filled($booking->cancellation?->bank_name) &&
        filled($booking->cancellation?->bank_account_number) &&
        filled($booking->cancellation?->bank_account_name);

    $canRefund =
        $booking->status === 'cancelled'
        && $hasRefundableDeposit
        && $hasRefundBankInfo
        && !($booking->cancellation?->refund_completed);
@endphp

<style>
    /* Tổng thể & Typography */
    .booking-detail {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
        background-color: #f8fafc;
    }
    .booking-detail h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-top: 0.5rem;
        margin-bottom: 0.25rem;
        color: #0f172a;
    }
    .booking-detail .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #64748b;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: color 0.2s;
    }
    .booking-detail .back-link:hover {
        color: #2563eb;
    }

    /* Khối thông báo (Alerts) */
    .booking-detail .alert-success,
    .booking-detail .alert-error,
    .booking-detail .alert-warning {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        border-left: 4px solid transparent;
    }
    .booking-detail .alert-success {
        color: #15803d;
        background: #f0fdf4;
        border-left-color: #16a34a;
    }
    .booking-detail .alert-error {
        color: #b91c1c;
        background: #fef2f2;
        border-left-color: #dc2626;
    }
    .booking-detail .alert-warning {
        color: #b45309;
        background: #fffbeb;
        border-left-color: #d97706;
    }

    /* Cấu trúc các Thẻ (Cards) */
    .booking-detail .card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }
    .booking-detail .card h2 {
        font-size: 1.15rem;
        font-weight: 600;
        margin-top: 0;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    /* Hệ thống lưới thông tin (Grid) */
    .booking-detail .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.25rem;
    }
    .booking-detail .field label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: #94a3b8;
        margin-bottom: 0.35rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .booking-detail .field .value {
        font-size: 0.95rem;
        font-weight: 500;
        color: #1e293b;
        word-break: break-word;
    }
    .booking-detail .field .value.muted {
        color: #cbd5e1;
        font-style: normal;
    }

    /* Nhãn trạng thái (Badges) */
    .booking-detail .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #475569;
    }
    .booking-detail .status-badge.pending { background: #fef3c7; color: #d97706; }
    .booking-detail .status-badge.awaiting_deposit { background: #ffedd5; color: #ea580c; }
    .booking-detail .status-badge.confirmed { background: #dbeafe; color: #2563eb; }
    .booking-detail .status-badge.checked_in { background: #d1fae5; color: #059669; }
    .booking-detail .status-badge.checked_out { background: #f1f5f9; color: #475569; }
    .booking-detail .status-badge.completed { background: #dcfce7; color: #16a34a; }
    .booking-detail .status-badge.cancelled { background: #fee2e2; color: #dc2626; }

    /* Nội dung phụ & Hộp ghi chú */
    .booking-detail .note-box {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #cbd5e1;
        color: #475569;
        font-size: 0.95rem;
        white-space: pre-wrap;
    }
    .booking-detail .proof-link {
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
    }
    .booking-detail .proof-link:hover {
        text-decoration: underline;
    }

    /* Khu vực Thao tác (Form & Buttons) */
    .booking-detail .actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .booking-detail .actions form {
        margin: 0;
        width: 100%;
    }
    .booking-detail .actions button,
    .booking-detail .btn-refund {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        transition: background-color 0.15s ease, transform 0.1s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .booking-detail .actions button:active,
    .booking-detail .btn-refund:active {
        transform: scale(0.98);
    }
    .booking-detail .btn-confirm { background: #16a34a; }
    .booking-detail .btn-confirm:hover { background: #15803d; }
    .booking-detail .btn-checkin { background: #2563eb; }
    .booking-detail .btn-checkin:hover { background: #1d4ed8; }
    .booking-detail .btn-checkout { background: #7c3aed; }
    .booking-detail .btn-checkout:hover { background: #6d28d9; }
    .booking-detail .btn-cancel { background: #dc2626; width: auto; }
    .booking-detail .btn-cancel:hover { background: #b91c1c; }
    .booking-detail .btn-refund { background: #16a34a; margin-top: 1rem; }
    .booking-detail .btn-refund:hover { background: #15803d; }

    /* Inputs tinh chỉnh */
    .booking-detail input[type="text"],
    .booking-detail input[type="file"],
    .booking-detail textarea {
        font-family: inherit;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        padding: 10px 12px !important;
        background-color: #fff;
        color: #1e293b;
        font-size: 0.95rem;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .booking-detail input[type="text"]:focus,
    .booking-detail textarea:focus {
        outline: none;
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
</style>

<div class="booking-detail">

    <a href="{{ route('host.bookings.index') }}" class="back-link">← Danh sách booking</a>

    <h1>Chi tiết booking</h1>
    <p style="color:#64748b; margin-top: 0; margin-bottom:1.5rem; font-size: 0.95rem;">
        Mã: <strong style="color: #0f172a;">{{ $booking->booking_code ?? '—' }}</strong>
        <span style="color: #cbd5e1; margin: 0 6px;">·</span> ID: #{{ $booking->id }}
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
                <label>Thời điểm đặt</label>
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
                    <div class="value" style="color:#475569; font-size:0.9rem;">{{ $booking->room->description }}</div>
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
                <label>Giá tại thời điểm đặt</label>
                <div class="value">{{ number_format($booking->room_price, 0, ',', '.') }} VND/đêm</div>
            </div>
            <div class="field">
                <label>Tổng tiền</label>
                <div class="value" style="color:#2563eb; font-weight:600;">{{ number_format($booking->total_price, 0, ',', '.') }} VND</div>
            </div>
            <div class="field">
                <label>Tiền cọc</label>
                <div class="value" style="color:#16a34a; font-weight:600;">{{ number_format($booking->deposit_amount, 0, ',', '.') }} VND</div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Thanh toán</h2>

        @if($booking->payments->count())
            @foreach($booking->payments as $payment)
                <div style="border:1px solid #e2e8f0; border-radius:8px; padding:16px; margin-bottom:16px; background-color:#f8fafc;">
                    <h3 style="margin-top:0; margin-bottom:12px; font-size:0.85rem; letter-spacing:0.05em; color:#64748b;">
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
                                    <span class="muted">—</span>
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
                <div class="grid" style="margin-bottom:12px;">
                    <div class="field">
                        <label>Người hủy</label>
                        <div class="value">
                            {{ $booking->cancellation->cancelled_by_type === 'host' ? 'Host' : 'Guest' }}
                        </div>
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

                    @if($booking->cancellation->cancelled_by_type === 'host' && !$booking->cancellation->bank_name && $hasRefundableDeposit)
                        <div class="field" style="grid-column: 1 / -1;">
                            <label>Trạng thái refund</label>
                            <div class="value">
                                <span style="color:#b45309; font-weight:500;">Chờ guest nhập thông tin ngân hàng</span>
                            </div>
                        </div>
                    @endif

                    @if($hasRefundBankInfo)
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
                            <label>Guest gửi bank info lúc</label>
                            <div class="value">
                                {{ $booking->cancellation->refund_info_submitted_at?->format('d/m/Y H:i') ?? '—' }}
                            </div>
                        </div>

                        <div class="field">
                            <label>Refund status</label>
                            <div class="value">
                                <span class="status-badge {{ $booking->cancellation->refund_completed ? 'completed' : 'pending' }}">
                                    {{ $booking->cancellation->refund_completed ? 'Đã hoàn tiền' : 'Chờ hoàn tiền' }}
                                </span>
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
                                    <span class="muted">—</span>
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
                        <label style="margin-bottom: 0.5rem;">Mã giao dịch hoàn tiền</label>
                        <input
                            type="text"
                            name="refund_transaction_code"
                            required
                            style="width:100%; box-sizing: border-box;"
                            value="{{ old('refund_transaction_code') }}"
                        >
                    </div>

                    <div class="field" style="grid-column: 1 / -1;">
                        <label style="margin-bottom: 0.5rem;">Ảnh giao dịch hoàn tiền</label>
                        <input
                            type="file"
                            name="refund_proof_image"
                            accept="image/*"
                            required
                            style="width:100%; box-sizing: border-box;"
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
    @elseif($booking->status === 'cancelled' && $booking->cancellation && $hasRefundableDeposit && !$hasRefundBankInfo)
        <div class="card">
            <h2>Chờ khách bổ sung thông tin refund</h2>
            <div class="alert-warning" style="margin-bottom:0;">
                Khách chưa gửi thông tin ngân hàng. Khi khách nhập xong, nút hoàn tiền sẽ xuất hiện ở đây.
            </div>
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

                    <div style="width:100%; margin-bottom:12px;">
                        <textarea
                            name="reason"
                            required
                            placeholder="Nhập lý do hủy booking..."
                            style="
                                width:100%;
                                min-height:100px;
                                box-sizing: border-box;
                                resize: vertical;
                            "
                        >{{ old('reason') }}</textarea>
                    </div>

                    <button
                        type="submit"
                        class="btn-cancel"
                        onclick="return confirm('Xác nhận hủy booking này?')"
                    >
                        Hủy booking
                    </button>
                </form>
            @endif
        </div>
    </div>

</div>

@endsection