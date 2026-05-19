@extends('host.layouts.app')

@section('title', 'Create Payment Method')

@section('content')

<h1>Create Payment Method</h1>

<br>

<form
    method="POST"
    action="{{ route('host.payment-methods.store') }}"
    enctype="multipart/form-data"
>

    @csrf

    <input
        type="text"
        name="name"
        placeholder="Name"
    >

    <br><br>

    <select name="type">

        <option value="bank_transfer">
            Bank Transfer
        </option>

        <option value="momo">
            MoMo
        </option>

        <option value="vnpay">
            VNPay
        </option>

        <option value="cash">
            Cash
        </option>

    </select>

    <br><br>

    <input
        type="text"
        name="bank_name"
        placeholder="Bank Name"
    >

    <br><br>

    <input
        type="text"
        name="account_name"
        placeholder="Account Name"
    >

    <br><br>

    <input
        type="text"
        name="account_number"
        placeholder="Account Number"
    >

    <br><br>

    <input
        type="text"
        name="phone_number"
        placeholder="Phone Number"
    >

    <br><br>

    <textarea
        name="description"
        placeholder="Description"
    ></textarea>

    <br><br>

    <input
        type="file"
        name="qr_image"
    >

    <br><br>

    <label>

        <input
            type="checkbox"
            name="is_active"
            checked
        >

        Active

    </label>

    <br><br>

    <button type="submit">
        Create
    </button>

</form>

@endsection