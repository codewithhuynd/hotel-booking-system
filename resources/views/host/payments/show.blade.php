@extends('host.layouts.app')

@section('title', 'Payment Detail')

@section('content')

<h1>Payment Detail</h1>

<br>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
    <br>
@endif

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
    <br>
@endif

<div style="background:white; padding:25px; border-radius:10px;">

    <p><strong>Payment ID:</strong> {{ $payment->id }}</p>
    <br>

    <p><strong>Type:</strong> {{ $payment->displayTypeLabel() }}</p>
    <br>

    <p><strong>Status:</strong> {{ $payment->displayStatusLabel() }}</p>
    <br>

    <p><strong>Booking Code:</strong> {{ $payment->booking?->booking_code ?? '—' }}</p>
    <br>

    <p><strong>Guest:</strong> {{ $payment->booking?->user?->full_name ?? '—' }}</p>
    <br>

    <p><strong>Room:</strong> {{ $payment->booking?->room?->room_name ?? '—' }}</p>
    <br>

    <p><strong>Amount:</strong> {{ number_format($payment->deposit_amount) }} VND</p>
    <br>

    <p><strong>Payment Method:</strong> {{ strtoupper($payment->payment_method) }}</p>
    <br>

    <p><strong>Transaction Code:</strong> {{ $payment->transaction_code ?? '—' }}</p>
    <br>

    <p><strong>Deadline:</strong> {{ $payment->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}</p>
    <br>

    <p><strong>Paid At:</strong> {{ $payment->paid_at?->format('d/m/Y H:i') ?? '—' }}</p>
    <br>

    @if($payment->proof_image)
        <p><strong>Proof image:</strong></p>
        <br>
        <img
            src="{{ asset('storage/' . $payment->proof_image) }}"
            alt="Proof image"
            style="max-width: 420px; border-radius: 10px;"
        >
        <br><br>
    @endif

    @if($payment->status !== 'paid')
        <hr>
        <br>

        <h2>Confirm Payment</h2>
        <br>

        <form method="POST" action="{{ route('host.payments.confirm', $payment) }}">
            @csrf

            <p>
                <label for="transaction_code"><strong>Transaction Code (optional)</strong></label>
                <br><br>
                <input
                    type="text"
                    name="transaction_code"
                    id="transaction_code"
                    value="{{ old('transaction_code', $payment->transaction_code) }}"
                    placeholder="TXN-123456"
                    style="padding:8px; width:100%; max-width:320px;"
                >
            </p>

            <br>

            <button
                type="submit"
                style="padding:12px 20px; background:#16a34a; color:white; border:none; border-radius:8px; cursor:pointer;"
                onclick="return confirm('Confirm this payment?')"
            >
                Confirm Payment
            </button>
        </form>
    @endif

</div>

<br>

<a href="{{ route('host.payments.index') }}">← Back to payments</a>

@endsection