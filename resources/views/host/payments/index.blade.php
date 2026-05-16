@extends('host.layouts.app')

@section('title', 'Manage Payments')

@section('content')

<h1>Manage Payments</h1>

<br>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
    <br>
@endif

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
    <br>
@endif

@if(!empty($expiredCount))
    <p style="color:#1d4ed8;">
        {{ $expiredCount }} overdue deposit payment(s) expired.
    </p>
    <br>
@endif

<table
    border="1"
    cellpadding="12"
    cellspacing="0"
    width="100%"
    style="background:white; border-collapse:collapse;"
>
    <tr style="background:#1e293b; color:white;">
        <th>ID</th>
        <th>Type</th>
        <th>Booking</th>
        <th>Guest</th>
        <th>Amount</th>
        <th>Method</th>
        <th>Status</th>
        <th>Deadline</th>
        <th>Action</th>
    </tr>

    @forelse($payments as $payment)
        <tr>
            <td>{{ $payment->id }}</td>
            <td>{{ $payment->displayTypeLabel() }}</td>
            <td>{{ $payment->booking?->booking_code ?? '—' }}</td>
            <td>{{ $payment->booking?->user?->full_name ?? '—' }}</td>
            <td>{{ number_format($payment->deposit_amount) }} VND</td>
            <td>{{ strtoupper($payment->payment_method) }}</td>
            <td>{{ $payment->displayStatusLabel() }}</td>
            <td>{{ $payment->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}</td>
            <td>
                <a
                    href="{{ route('host.payments.show', $payment) }}"
                    style="padding:8px 12px; background:#2563eb; color:white; text-decoration:none; border-radius:6px;"
                >
                    View
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9">No payments found.</td>
        </tr>
    @endforelse
</table>

@endsection