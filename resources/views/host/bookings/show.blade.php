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
        'cancelled' => 'Đã hủy',
    ];

    $paymentStatusLabels = [
        'unpaid' => 'Chưa thanh toán',
        'pending' => 'Đang chờ',
        'paid' => 'Đã thanh toán',
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
    ];
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
    .booking-detail .actions button {
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        color: white;
        cursor: pointer;
        font-size: 0.9rem;
    }
    .booking-detail .btn-confirm { background: #16a34a; }
    .booking-detail .btn-checkin { background: #2563eb; }
    .booking-detail .btn-checkout { background: #7c3aed; }
    .booking-detail .btn-cancel { background: #dc2626; }
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

    {{-- Tổng quan --}}
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

    {{-- Khách & liên hệ --}}
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
                <label>Tên liên hệ (contact_name)</label>
                <div class="value">{{ $booking->contact_name ?? '—' }}</div>
            </div>
            <div class="field">
                <label>SĐT liên hệ (contact_phone)</label>
                <div class="value">{{ $booking->contact_phone ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Email liên hệ (contact_email)</label>
                <div class="value">{{ $booking->contact_email ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Số khách (guest_count)</label>
                <div class="value">{{ $booking->guest_count ?? '—' }}</div>
            </div>
        </div>
    </div>

    {{-- Phòng --}}
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
                <label>Giá phòng (hiện tại)</label>
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

    {{-- Lịch lưu trú --}}
    <div class="card">
        <h2>Lịch lưu trú</h2>
        <div class="grid">
            <div class="field">
                <label>Nhận phòng (check-in)</label>
                <div class="value">{{ $checkIn?->format('d/m/Y') ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Trả phòng (check-out)</label>
                <div class="value">{{ $checkOut?->format('d/m/Y') ?? '—' }}</div>
            </div>
            <div class="field">
                <label>Số đêm</label>
                <div class="value">{{ $nights !== null ? $nights . ' đêm' : '—' }}</div>
            </div>
        </div>
    </div>

    {{-- Giá & thanh toán booking --}}
    <div class="card">
        <h2>Giá booking</h2>
        <div class="grid">
            <div class="field">
                <label>Giá phòng tại thời điểm đặt (room_price)</label>
                <div class="value">
                    @if(isset($booking->room_price))
                        {{ number_format($booking->room_price, 0, ',', '.') }} VND/đêm
                    @else
                        <span class="muted">—</span>
                    @endif
                </div>
            </div>
            <div class="field">
                <label>Tổng tiền (total_price)</label>
                <div class="value">
                    @if(isset($booking->total_price))
                        {{ number_format($booking->total_price, 0, ',', '.') }} VND
                    @else
                        <span class="muted">—</span>
                    @endif
                </div>
            </div>
            <div class="field">
                <label>Tiền cọc (deposit_amount trên booking)</label>
                <div class="value">
                    @if(isset($booking->deposit_amount))
                        {{ number_format($booking->deposit_amount, 0, ',', '.') }} VND
                    @else
                        <span class="muted">—</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Thanh toán (payment) --}}
    <div class="card">
        <h2>Thanh toán (payment)</h2>
        @if($booking->payment)
            @php $payment = $booking->payment; @endphp
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
                    <label>Số tiền cọc</label>
                    <div class="value">{{ number_format($payment->deposit_amount, 0, ',', '.') }} VND</div>
                </div>
                <div class="field">
                    <label>Phương thức</label>
                    <div class="value">
                        {{ $paymentMethodLabels[$payment->payment_method] ?? $payment->payment_method }}
                    </div>
                </div>
                <div class="field">
                    <label>Trạng thái thanh toán</label>
                    <div class="value">
                        {{ $paymentStatusLabels[$payment->status] ?? $payment->status }}
                    </div>
                </div>
                <div class="field">
                    <label>Hạn đặt cọc</label>
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
                    <label>Tạo / cập nhật payment</label>
                    <div class="value">
                        {{ $payment->created_at?->format('d/m/Y H:i') }}
                        @if($payment->updated_at && $payment->updated_at->ne($payment->created_at))
                            · {{ $payment->updated_at->format('d/m/Y H:i') }}
                        @endif
                    </div>
                </div>
            </div>
        @else
            <p class="value muted">Chưa có bản ghi thanh toán.</p>
        @endif
    </div>

    {{-- Ghi chú --}}
    <div class="card">
        <h2>Ghi chú</h2>
        @if(filled($booking->note))
            <div class="note-box">{{ $booking->note }}</div>
        @else
            <p class="value muted">Không có ghi chú.</p>
        @endif
    </div>

    {{-- Hủy booking --}}
    @if($booking->status === 'cancelled' || $booking->cancellation)
        <div class="card">
            <h2>Thông tin hủy</h2>
            <div class="grid">
                <div class="field">
                    <label>Lý do hủy</label>
                    <div class="value">{{ $booking->cancellation?->reason ?? '—' }}</div>
                </div>
                <div class="field">
                    <label>Thời điểm hủy</label>
                    <div class="value">
                        @if($booking->cancellation?->cancelled_at)
                            {{ \Carbon\Carbon::parse($booking->cancellation->cancelled_at)->format('d/m/Y H:i') }}
                        @else
                            —
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Thao tác --}}
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

            @if($booking->status !== 'checked_out' && $booking->status !== 'cancelled')
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
