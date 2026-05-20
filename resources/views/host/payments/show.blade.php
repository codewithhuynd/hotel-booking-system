@extends('host.layouts.app')

@section('title', 'Payment Detail')

@section('content')

<style>
    /* Tổng thể & Typography */
    .payment-detail-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
        background-color: #f8fafc;
    }
    .payment-detail-container h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0;
        margin-bottom: 0.25rem;
    }
    .payment-detail-container .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #64748b;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        transition: color 0.15s ease;
        margin-top: 1.5rem;
    }
    .payment-detail-container .back-link:hover {
        color: #2563eb;
    }

    /* Khối thông báo (Alerts) */
    .payment-detail-container .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        border-left: 4px solid transparent;
    }
    .payment-detail-container .alert-success {
        color: #15803d;
        background: #f0fdf4;
        border-left-color: #16a34a;
    }
    .payment-detail-container .alert-error {
        color: #b91c1c;
        background: #fef2f2;
        border-left-color: #dc2626;
    }

    /* Khối thông tin (Card) */
    .payment-detail-container .card {
        background: white;
        padding: 1.75rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }
    .payment-detail-container .card h2 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-top: 0;
        margin-bottom: 1.25rem;
        color: #334155;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Hệ thống lưới thông tin (Grid) */
    .payment-detail-container .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .payment-detail-container .field label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: #94a3b8;
        margin-bottom: 0.35rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .payment-detail-container .field .value {
        font-size: 1rem;
        font-weight: 500;
        color: #1e293b;
    }
    .payment-detail-container .code-highlight {
        font-family: monospace;
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.9rem;
    }

    /* Minh chứng hình ảnh (Proof Image) */
    .proof-wrapper {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
    }
    .proof-image {
        max-width: 100%;
        width: 420px;
        height: auto;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    /* Form điều khiển */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1.25rem;
    }
    .form-group input[type="text"] {
        font-family: inherit;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 10px 12px;
        background-color: #fff;
        color: #1e293b;
        font-size: 0.95rem;
        width: 100%;
        max-width: 360px;
        box-sizing: border-box;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .form-group input[type="text"]:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    /* Nút bấm hành động */
    .btn-confirm {
        padding: 12px 24px;
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        transition: background-color 0.15s ease, transform 0.1s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-confirm:hover {
        background: #15803d;
    }
    .btn-confirm:active {
        transform: scale(0.98);
    }
</style>

<div class="payment-detail-container">

    <h1>Payment Detail</h1>
    <p style="color:#64748b; margin-top: 0; margin-bottom: 1.5rem; font-size: 0.95rem;">
        Quản lý và phê duyệt thông tin giao dịch của khách hàng.
    </p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="card">
        <h2>Thông tin giao dịch</h2>
        
        <div class="grid">
            <div class="field">
                <label>Payment ID</label>
                <div class="value"><strong>#{{ $payment->id }}</strong></div>
            </div>

            <div class="field">
                <label>Loại thanh toán</label>
                <div class="value">{{ $payment->displayTypeLabel() }}</div>
            </div>

            <div class="field">
                <label>Trạng thái</label>
                <div class="value" style="font-weight: 600; color: #0f172a;">
                    {{ $payment->displayStatusLabel() }}
                </div>
            </div>

            <div class="field">
                <label>Mã Booking</label>
                <div class="value">
                    @if($payment->booking?->booking_code)
                        <span class="code-highlight">{{ $payment->booking->booking_code }}</span>
                    @else
                        <span style="color: #94a3b8;">—</span>
                    @endif
                </div>
            </div>

            <div class="field">
                <label>Khách hàng</label>
                <div class="value">{{ $payment->booking?->user?->full_name ?? '—' }}</div>
            </div>

            <div class="field">
                <label>Phòng đặt</label>
                <div class="value">{{ $payment->booking?->room?->room_name ?? '—' }}</div>
            </div>

            <div class="field">
                <label>Số tiền</label>
                <div class="value" style="color: #2563eb; font-weight: 600;">
                    {{ number_format($payment->deposit_amount) }} VND
                </div>
            </div>

            <div class="field">
                <label>Phương thức</label>
                <div class="value">
                    <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.85rem;">
                        {{ strtoupper($payment->payment_method) }}
                    </code>
                </div>
            </div>

            <div class="field">
                <label>Mã giao dịch (Hệ thống)</label>
                <div class="value">{{ $payment->transaction_code ?? '—' }}</div>
            </div>

            <div class="field">
                <label>Hạn thanh toán</label>
                <div class="value" style="color: #475569; font-size: 0.95rem;">
                    {{ $payment->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}
                </div>
            </div>

            <div class="field">
                <label>Thời gian thanh toán</label>
                <div class="value" style="color: #475569; font-size: 0.95rem;">
                    {{ $payment->paid_at?->format('d/m/Y H:i') ?? '—' }}
                </div>
            </div>
        </div>

        @if($payment->proof_image)
            <div class="proof-wrapper">
                <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #94a3b8; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    Hình ảnh minh chứng (Proof Image)
                </label>
                <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" title="Click để xem ảnh lớn">
                    <img
                        src="{{ asset('storage/' . $payment->proof_image) }}"
                        class="proof-image"
                        alt="Proof image"
                    >
                </a>
            </div>
        @endif
    </div>

    @if($payment->status !== 'paid')
        <div class="card" style="border-top: 3px solid #16a34a;">
            <h2>Phê duyệt thanh toán</h2>
            
            <form method="POST" action="{{ route('host.payments.confirm', $payment) }}">
                @csrf

                <div class="form-group">
                    <label for="transaction_code" style="font-size: 0.9rem; font-weight: 600; color: #475569;">
                        Mã giao dịch đối chiếu <span style="color: #94a3b8; font-weight: normal;">(Tùy chọn)</span>
                    </label>
                    <input
                        type="text"
                        name="transaction_code"
                        id="transaction_code"
                        value="{{ old('transaction_code', $payment->transaction_code) }}"
                        placeholder="Ví dụ: TXN12345678"
                    >
                </div>

                <button
                    type="submit"
                    class="btn-confirm"
                    onclick="return confirm('Xác nhận phê duyệt giao dịch thanh toán này?')"
                >
                    Xác nhận đã thanh toán
                </button>
            </form>
        </div>
    @endif

    <a href="{{ route('host.payments.index') }}" class="back-link">
        ← Quay lại danh sách thanh toán
    </a>

</div>

@endsection