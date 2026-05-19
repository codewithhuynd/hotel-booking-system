@extends('host.layouts.app')

@section('title', 'Edit Payment Method')

@section('content')

<h1>Edit Payment Method</h1>

<br>

<form
    method="POST"
    action="{{ route('host.payment-methods.update', $paymentMethod) }}"
    enctype="multipart/form-data"
>

    @csrf
    @method('PUT')

    <input
        type="text"
        name="name"
        value="{{ $paymentMethod->name }}"
    >

    <br><br>

    <input
        type="text"
        name="type"
        value="{{ $paymentMethod->type }}"
    >

    <br><br>

    <input
        type="text"
        name="bank_name"
        value="{{ $paymentMethod->bank_name }}"
    >

    <br><br>

    <input
        type="text"
        name="account_name"
        value="{{ $paymentMethod->account_name }}"
    >

    <br><br>

    <input
        type="text"
        name="account_number"
        value="{{ $paymentMethod->account_number }}"
    >

    <br><br>

    <input
        type="text"
        name="phone_number"
        value="{{ $paymentMethod->phone_number }}"
    >

    <br><br>

    <textarea name="description">{{ $paymentMethod->description }}</textarea>

    <br><br>

    @if($paymentMethod->qr_image)

        <img
            src="{{ asset('storage/' . $paymentMethod->qr_image) }}"
            width="200"
        >

        <br><br>

    @endif

    <input
        type="file"
        name="qr_image"
    >

    <br><br>

    <label>

        <input
            type="checkbox"
            name="is_active"
            {{ $paymentMethod->is_active ? 'checked' : '' }}
        >

        Active

    </label>

    <br><br>

    <button type="submit">
        Update
    </button>

</form>

@endsection