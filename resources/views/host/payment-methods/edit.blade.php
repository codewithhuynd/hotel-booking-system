@extends('host.layouts.app')

@section('title', 'Edit Payment Method')

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

    /* Định dạng trường nhập liệu (Input, Textarea) */
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
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    /* Thiết kế khu vực quản lý hình ảnh QR */
    .qr-management {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .qr-current {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .qr-current span {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
    }
    .qr-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: white;
    }
    .qr-upload-box {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 120px;
    }

    /* Tùy chỉnh Checkbox kiểu Switch hoặc khối Toggle */
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
        accent-color: #2563eb;
    }

    /* Nút Submit hành động */
    .form-actions {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
    }
    .btn-submit {
        padding: 10px 24px;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 600;
        transition: background-color 0.15s ease;
    }
    .btn-submit:hover {
        background: #1d4ed8;
    }
</style>

<div class="form-container">

    <h1>Edit Payment Method</h1>

    <div class="form-card">
        <form
            method="POST"
            action="{{ route('host.payment-methods.update', $paymentMethod) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="form-grid">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Method Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        value="{{ $paymentMethod->name }}"
                    >
                </div>

                <!-- Type -->
                <div class="form-group">
                    <label for="type">Payment Type</label>
                    <input
                        type="text"
                        name="type"
                        id="type"
                        class="form-control"
                        value="{{ $paymentMethod->type }}"
                    >
                </div>

                <!-- Bank Name -->
                <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input
                        type="text"
                        name="bank_name"
                        id="bank_name"
                        class="form-control"
                        value="{{ $paymentMethod->bank_name }}"
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
                        value="{{ $paymentMethod->account_name }}"
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
                        value="{{ $paymentMethod->account_number }}"
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
                        value="{{ $paymentMethod->phone_number }}"
                    >
                </div>

                <!-- Description -->
                <div class="form-group full-width">
                    <label for="description">Description</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        class="form-control"
                    >{{ $paymentMethod->description }}</textarea>
                </div>

                <!-- QR Image Section -->
                <div class="form-group full-width">
                    <label>QR Code Image</label>
                    <div class="qr-management">
                        @if($paymentMethod->qr_image)
                            <div class="qr-current">
                                <span>Current QR</span>
                                <img
                                    src="{{ asset('storage/' . $paymentMethod->qr_image) }}"
                                    class="qr-img"
                                    alt="Current QR Code"
                                >
                            </div>
                        @endif
                        
                        <div class="qr-upload-box">
                            <span style="font-size: 0.8rem; color: #64748b; margin-bottom: 0.5rem; font-weight: 500;">
                                @if($paymentMethod->qr_image) Upload new to replace @else Choose QR image file @endif
                            </span>
                            <input
                                type="file"
                                name="qr_image"
                                style="font-size: 0.9rem;"
                            >
                        </div>
                    </div>
                </div>

                <!-- Is Active status -->
                <div class="form-group full-width">
                    <label class="checkbox-container">
                        <input
                            type="checkbox"
                            name="is_active"
                            {{ $paymentMethod->is_active ? 'checked' : '' }}
                        >
                        Active this payment method
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    Update Method
                </button>
            </div>

        </form>
    </div>

</div>

@endsection