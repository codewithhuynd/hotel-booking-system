@extends('host.layouts.app')

@section('title', 'Quản lý thanh toán')

@section('content')

<style>
    .payments-container{
        font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }

    .page-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:20px;
        flex-wrap:wrap;
        gap:12px;
    }

    .page-header h1{
        font-size:1.75rem;
        font-weight:800;
        margin:0;
        color:#0f172a;
    }

    .sub-text{
        color:#64748b;
        font-size:14px;
        margin-top:6px;
    }

    .card{
        background:white;
        border-radius:14px;
        border:1px solid #e2e8f0;
        box-shadow:0 10px 30px rgba(15,23,42,0.06);
        padding:12px 16px;
        min-width:180px;
    }

    .card-title{
        font-size:12px;
        color:#64748b;
    }

    .card-value{
        font-size:22px;
        font-weight:800;
        color:#0f172a;
    }

    .alert{
        padding:12px 16px;
        border-radius:10px;
        margin-bottom:14px;
        font-weight:600;
        font-size:14px;
    }

    .alert-success{
        background:#dcfce7;
        color:#166534;
    }

    .alert-error{
        background:#fee2e2;
        color:#991b1b;
    }

    .alert-info{
        background:#eff6ff;
        color:#1d4ed8;
    }

    .table-wrapper{
        background:white;
        border-radius:16px;
        border:1px solid #e2e8f0;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(15,23,42,0.06);
    }

    table{
        width:100%;
        border-collapse:collapse;
        table-layout:fixed;
    }

    thead th{
        background:#1e293b; /* 🔵 xanh đậm giống trang trước */
        color:white;
        font-size:13px;
        text-align:left;
        padding:14px;
        font-weight:700;
    }

    tbody td{
        padding:14px;
        border-bottom:1px solid #f1f5f9;
        color:#334155;
        font-size:14px;
        vertical-align:middle;
        word-break:break-word;
    }

    tbody tr:hover td{
        background:#f8fafc;
    }

    .badge{
        display:inline-block;
        padding:6px 10px;
        border-radius:999px;
        font-size:12px;
        font-weight:700;
        background:#f1f5f9;
        color:#475569;
        white-space:nowrap;
    }

    .code{
        font-family:monospace;
        font-weight:700;
        color:#0f172a;
    }

    .amount{
        font-weight:800;
        color:#0f172a;
    }

    .btn{
        display:inline-block;
        padding:8px 12px;
        background:#2563eb;
        color:white;
        border-radius:10px;
        font-weight:700;
        font-size:13px;
        text-decoration:none;
        white-space:nowrap;
    }

    .right{
        text-align:right;
    }
</style>

<div class="payments-container">

    <!-- HEADER -->
    <div class="page-header">

        <div>
            <h1>Quản lý thanh toán</h1>
            <div class="sub-text">Theo dõi tất cả giao dịch thanh toán trong hệ thống</div>
        </div>

        <div class="card">
            <div class="card-title">Tổng thanh toán</div>
            <div class="card-value">{{ $payments->count() }}</div>
        </div>

    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if(!empty($expiredCount))
        <div class="alert alert-info">
            {{ $expiredCount }} khoản đặt cọc quá hạn.
        </div>
    @endif

    <!-- TABLE -->
    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th style="width:60px;">ID</th>
                    <th>Loại</th>
                    <th>Mã đặt phòng</th>
                    <th>Khách hàng</th>
                    <th>Số tiền</th>
                    <th>Phương thức</th>
                    <th>Trạng thái</th>
                    <th>Hạn thanh toán</th>
                    <th class="right" style="width:90px;">Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @forelse($payments as $payment)

                <tr>

                    <td><strong>#{{ $payment->id }}</strong></td>

                    <td>
                        <span class="badge">
                            {{ $payment->displayTypeLabel() }}
                        </span>
                    </td>

                    <td class="code">
                        {{ $payment->booking?->booking_code ?? '—' }}
                    </td>

                    <td>
                        {{ $payment->booking?->user?->full_name ?? '—' }}
                    </td>

                    <td class="amount">
                        {{ number_format($payment->deposit_amount) }} VNĐ
                    </td>

                    <td>
                        <span class="badge">
                            {{ strtoupper($payment->payment_method) }}
                        </span>
                    </td>

                    <td>
                        {{ $payment->displayStatusLabel() }}
                    </td>

                    <td style="color:#64748b;">
                        {{ $payment->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}
                    </td>

                    <td class="right">
                        <a href="{{ route('host.payments.show', $payment) }}" class="btn">
                            Xem
                        </a>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="9" style="text-align:center;padding:40px;color:#94a3b8;">
                        Không có dữ liệu thanh toán.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection