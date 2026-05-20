@extends('host.layouts.app')

@section('title', 'Manage Payments')

@section('content')

<style>
    /* Tổng thể & Typography */
    .payments-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }
    .payments-container h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0;
        margin-bottom: 1.5rem;
    }

    /* Khối thông báo hệ thống (Alerts) */
    .payments-container .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        border-left: 4px solid transparent;
    }
    .payments-container .alert-success {
        color: #15803d;
        background: #f0fdf4;
        border-left-color: #16a34a;
    }
    .payments-container .alert-error {
        color: #b91c1c;
        background: #fef2f2;
        border-left-color: #dc2626;
    }
    .payments-container .alert-info {
        color: #1d4ed8;
        background: #eff6ff;
        border-left-color: #3b82f6;
    }

    /* Cấu trúc Bảng Hiện Đại */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        background: white;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.95rem;
    }
    .custom-table th {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
    }
    .custom-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
    }
    .custom-table tr:last-child td {
        border-bottom: none;
    }
    .custom-table tr:hover td {
        background-color: #f8fafc;
    }

    /* Các nhãn thông tin tinh chỉnh */
    .payments-container .badge-type {
        background-color: #f1f5f9;
        color: #475569;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .payments-container .code-text {
        font-family: monospace;
        background: #f8fafc;
        padding: 2px 6px;
        border-radius: 4px;
        color: #0f172a;
        font-weight: 500;
    }
    .payments-container .amount-text {
        font-weight: 600;
        color: #0f172a;
    }
    .payments-container .muted-text {
        color: #94a3b8;
        font-style: italic;
    }

    /* Nút hành động đơn lẻ */
    .btn-view {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 14px;
        background-color: #2563eb;
        color: white !important;
        text-decoration: none;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: background-color 0.15s ease, transform 0.1s ease;
    }
    .btn-view:hover {
        background-color: #1d4ed8;
    }
    .btn-view:active {
        transform: scale(0.97);
    }
</style>

<div class="payments-container">

    <h1>Manage Payments</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if(!empty($expiredCount))
        <div class="alert alert-info">
            <strong>{{ $expiredCount }}</strong> overdue deposit payment(s) expired.
        </div>
    @endif

    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Type</th>
                    <th>Booking</th>
                    <th>Guest</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Deadline</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td><strong>#{{ $payment->id }}</strong></td>
                        
                        <td>
                            <span class="badge-type">
                                {{ $payment->displayTypeLabel() }}
                            </span>
                        </td>
                        
                        <td>
                            @if($payment->booking?->booking_code)
                                <span class="code-text">{{ $payment->booking->booking_code }}</span>
                            @else
                                <span class="muted-text">—</span>
                            @endif
                        </td>
                        
                        <td>
                            <span style="font-weight: 500; color: #0f172a;">
                                {{ $payment->booking?->user?->full_name ?? '—' }}
                            </span>
                        </td>
                        
                        <td>
                            <span class="amount-text">
                                {{ number_format($payment->deposit_amount) }} VND
                            </span>
                        </td>
                        
                        <td>
                            <code style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 0.85rem;">
                                {{ strtoupper($payment->payment_method) }}
                            </code>
                        </td>
                        
                        <td>
                            {{-- Giữ nguyên phương thức hiển thị nhãn trạng thái từ Model của bạn --}}
                            <span style="font-weight: 500;">
                                {{ $payment->displayStatusLabel() }}
                            </span>
                        </td>
                        
                        <td>
                            <span style="font-size: 0.9rem; color: #475569;">
                                {{ $payment->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}
                            </span>
                        </td>
                        
                        <td style="text-align: center;">
                            <a href="{{ route('host.payments.show', $payment) }}" class="btn-view">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: #94a3b8; padding: 2rem 0; font-style: italic;">
                            No payments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection