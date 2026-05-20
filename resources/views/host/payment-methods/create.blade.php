@extends('host.layouts.app')

@section('title', 'Create Payment Method')

@section('content')

<style>
    /* Tổng thể & Typography */
    .form-container {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        color: #1e293b;
    }
    .form-container h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin-top: 0;
        margin-bottom: 1.5rem;
    }

    /* Khối thẻ chứa Form (Card) */
    .form-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    /* Bố cục lưới chia cột */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.25rem;
    }

    /* Thành phần Form Group */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .form-group.full-width {
        grid-column: span 2;
    }
    .form-group label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #475569;
    }

    /* Định dạng trường nhập liệu (Input, Select, Textarea) */
    .form-control {
        width: 100%;
        padding: 10px 14px;
        font-size: 0.95rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #0f172a;
        background-color: #fff;
        box-sizing: border-box;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .form-control:focus {
        outline: none;
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3E%3C/svg%3E");
        background-position: right 10px center;
        background-repeat: no-repeat;
        background-size: 1.25rem;
        padding-right: 40px;
    }
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    /* Khu vực upload file QR */
    .qr-upload-zone {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    /* Tùy chỉnh Checkbox */
    .checkbox-container {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 600;
        color: #334155;
        user-select: none;
        margin-top: 0.5rem;
    }
    .checkbox-container input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #16a34a;
    }

    /* Nút Submit hành động */
    .form-actions {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
    }
    .btn-submit {
        padding: 10px 24px;
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 600;
        transition: background-color 0.15s ease;
    }
    .btn-submit:hover {
        background: #15803d;
    }
</style>

<div class="form-container">

    <h1>Create Payment Method</h1>

    <div class="form-card">
        <form
            method="POST"
            action="{{ route('host.payment-methods.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="form-grid">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Method Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        placeholder="Name"
                    >
                </div>

                <!-- Type -->
                <div class="form-group">
                    <label for="type">Payment Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="momo">MoMo</option>
                        <option value="vnpay">VNPay</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <!-- Bank Name -->
                <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input
                        type="text"
                        name="bank_name"
                        id="bank_name"
                        class="form-control"
                        placeholder="Bank Name"
                    >
                </div>

                <!-- Account Name -->
                <div class="form-group">
                    <label for="account_name">Account Name</label>
                    <input
                        type="text"
                        name="account_name"
                        id="account_name"
                        class="form-control"
                        placeholder="Account Name"
                    >
                </div>

                <!-- Account Number -->
                <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input
                        type="text"
                        name="account_number"
                        id="account_number"
                        class="form-control"
                        placeholder="Account Number"
                    >
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input
                        type="text"
                        name="phone_number"
                        id="phone_number"
                        class="form-control"
                        placeholder="Phone Number"
                    >
                </div>

                <!-- Description -->
                <div class="form-group full-width">
                    <label for="description">Description</label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control"
                        placeholder="Description"
                    ></textarea>
                </div>

                <!-- QR Image -->
                <div class="form-group full-width">
                    <label for="qr_image">QR Code Image</label>
                    <div class="qr-upload-zone">
                        <input
                            type="file"
                            name="qr_image"
                            id="qr_image"
                            style="font-size: 0.9rem;"
                        >
                    </div>
                </div>

                <!-- Is Active status -->
                <div class="form-group full-width">
                    <label class="checkbox-container">
                        <input
                            type="checkbox"
                            name="is_active"
                            checked
                        >
                        Active this payment method immediately
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    Create Method
                </button>
            </div>

        </form>
    </div>

</div>

@endsection