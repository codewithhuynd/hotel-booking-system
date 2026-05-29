@extends('host.layouts.app')

@section('title', 'Chỉnh sửa phương thức thanh toán')

@section('content')

<style>
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
        margin-bottom: 1.5rem;
    }

    .form-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.25rem;
    }

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

    .form-control {
        width: 100%;
        padding: 10px 14px;
        font-size: 0.95rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #0f172a;
        background-color: #fff;
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
    }

    .qr-upload-box {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 120px;
    }

    .checkbox-container {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 600;
        color: #334155;
        user-select: none;
    }

    .checkbox-container input {
        width: 18px;
        height: 18px;
        accent-color: #2563eb;
    }

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
    }

    .btn-submit:hover {
        background: #1d4ed8;
    }
</style>

<div class="form-container">

    <h1>Chỉnh sửa phương thức thanh toán</h1>

    <div class="form-card">
        <form method="POST"
              action="{{ route('host.payment-methods.update', $paymentMethod) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label for="name">Tên phương thức</label>
                    <input type="text" name="name" id="name"
                           class="form-control"
                           value="{{ $paymentMethod->name }}">
                </div>

                <div class="form-group">
                    <label for="type">Loại thanh toán</label>
                    <input type="text" name="type" id="type"
                           class="form-control"
                           value="{{ $paymentMethod->type }}">
                </div>

                <div class="form-group">
                    <label for="bank_name">Tên ngân hàng</label>
                    <input type="text" name="bank_name" id="bank_name"
                           class="form-control"
                           value="{{ $paymentMethod->bank_name }}">
                </div>

                <div class="form-group">
                    <label for="account_name">Tên tài khoản</label>
                    <input type="text" name="account_name" id="account_name"
                           class="form-control"
                           value="{{ $paymentMethod->account_name }}">
                </div>

                <div class="form-group">
                    <label for="account_number">Số tài khoản</label>
                    <input type="text" name="account_number" id="account_number"
                           class="form-control"
                           value="{{ $paymentMethod->account_number }}">
                </div>

                <div class="form-group">
                    <label for="phone_number">Số điện thoại</label>
                    <input type="text" name="phone_number" id="phone_number"
                           class="form-control"
                           value="{{ $paymentMethod->phone_number }}">
                </div>

                <div class="form-group full-width">
                    <label for="description">Mô tả</label>
                    <textarea name="description" id="description"
                              class="form-control">{{ $paymentMethod->description }}</textarea>
                </div>

                <div class="form-group full-width">
                    <label>Mã QR thanh toán</label>

                    <div class="qr-management">

                        @if($paymentMethod->qr_image)
                            <div class="qr-current">
                                <span>QR hiện tại</span>
                                <img src="{{ asset('storage/' . $paymentMethod->qr_image) }}"
                                     class="qr-img"
                                     alt="QR Code">
                            </div>
                        @endif

                        <div class="qr-upload-box">
                            <span style="font-size:0.8rem;color:#64748b;margin-bottom:0.5rem;">
                                @if($paymentMethod->qr_image)
                                    Tải lên để thay thế
                                @else
                                    Chọn ảnh QR
                                @endif
                            </span>

                            <input type="file" name="qr_image">
                        </div>

                    </div>
                </div>

                <div class="form-group full-width">
                    <label class="checkbox-container">
                        <input type="checkbox" name="is_active"
                               {{ $paymentMethod->is_active ? 'checked' : '' }}>
                        Kích hoạt phương thức này
                    </label>
                </div>

            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    Cập nhật phương thức
                </button>
            </div>

        </form>
    </div>

</div>

@endsection