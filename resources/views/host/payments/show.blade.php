@extends('host.layouts.app')

@section('title', 'Payment Detail')

@section('content')

<h1>
    Payment Detail
</h1>

<br>

@if(session('success'))

    <p style="color:green;">
        {{ session('success') }}
    </p>

    <br>

@endif

@if(session('error'))

    <p style="color:red;">
        {{ session('error') }}
    </p>

    <br>

@endif

<div
    style="
        background:white;
        padding:25px;
        border-radius:10px;
    "
>

    <p>
        <strong>Payment ID:</strong>
        {{ $payment->id }}
    </p>

    <br>

    <p>
        <strong>Status:</strong>
        {{ $payment->displayStatusLabel() }}
    </p>

    <br>

    <p>
        <strong>Deposit Amount:</strong>
        {{ number_format($payment->deposit_amount) }} VND
    </p>

    <br>

    <p>
        <strong>Payment Method:</strong>
        {{ strtoupper($payment->payment_method) }}
    </p>

    <br>

    <p>
        <strong>Transaction Code:</strong>
        {{ $payment->transaction_code ?? '—' }}
    </p>

    <br>

    <p>
        <strong>Deadline:</strong>

        {{ $payment->deposit_deadline?->format('d/m/Y H:i') }}
    </p>

    <br>

    <p>
        <strong>Paid At:</strong>

        {{ $payment->paid_at?->format('d/m/Y H:i') ?? '—' }}
    </p>

    <br>

    <hr>

    <br>

    <h2>
        Booking Information
    </h2>

    <br>

    <p>
        <strong>Booking Code:</strong>
        {{ $payment->booking?->booking_code }}
    </p>

    <br>

    <p>
        <strong>Guest:</strong>
        {{ $payment->booking?->user?->full_name }}
    </p>

    <br>

    <p>
        <strong>Room:</strong>
        {{ $payment->booking?->room?->room_name }}
    </p>

    <br>

    @if($payment->canConfirmDeposit())

        <hr>

        <br>

        <h2>
            Confirm Deposit
        </h2>

        <br>

        <form
            method="POST"
            action="{{ route('host.payments.confirm', $payment) }}"
        >

            @csrf

            <input
                type="text"
                name="transaction_code"
                placeholder="Transaction Code"
                style="
                    padding:10px;
                    width:300px;
                "
            >

            <br><br>

            <button
                type="submit"
                style="
                    padding:12px 20px;
                    background:#16a34a;
                    color:white;
                    border:none;
                    border-radius:8px;
                    cursor:pointer;
                "
            >
                Confirm Payment
            </button>

        </form>

    @endif

</div>

<br>

<a href="{{ route('host.payments.index') }}">
    ← Back to payments
</a>

@endsection