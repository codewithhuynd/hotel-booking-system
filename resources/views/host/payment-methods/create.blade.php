@extends('host.layouts.app')

@section('title', 'Tạo phương thức thanh toán')

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

    .qr-upload-zone {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
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
        accent-color: #16a34a;
    }

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
    }

    .btn-submit:hover {
        background: #15803d;
    }
</style>

<div class="form-container">

    <h1>Tạo phương thức thanh toán</h1>

    <div class="form-card">

        <form method="POST"
              action="{{ route('host.payment-methods.store') }}"
              enctype="multipart/form-data">

            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label for="name">Tên phương thức</label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control"
                           placeholder="Nhập tên phương thức">
                </div>

                <div class="form-group">
                    <label for="type">Loại thanh toán</label>
                    <select name="type" id="type" class="form-control">
                        <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                        <option value="momo">MoMo</option>
                        <option value="vnpay">VNPay</option>
                        <option value="cash">Tiền mặt</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="bank_name">Tên ngân hàng</label>
                    <input type="text"
                           name="bank_name"
                           id="bank_name"
                           class="form-control"
                           placeholder="Ví dụ: Vietcombank">
                </div>

                <div class="form-group">
                    <label for="account_name">Tên tài khoản</label>
                    <input type="text"
                           name="account_name"
                           id="account_name"
                           class="form-control"
                           placeholder="Nguyễn Văn A">
                </div>

                <div class="form-group">
                    <label for="account_number">Số tài khoản</label>
                    <input type="text"
                           name="account_number"
                           id="account_number"
                           class="form-control"
                           placeholder="123456789">
                </div>

                <div class="form-group">
                    <label for="phone_number">Số điện thoại</label>
                    <input type="text"
                           name="phone_number"
                           id="phone_number"
                           class="form-control"
                           placeholder="09xxxxxxxx">
                </div>

                <div class="form-group full-width">
                    <label for="description">Mô tả</label>
                    <textarea name="description"
                              id="description"
                              class="form-control"
                              placeholder="Nhập mô tả phương thức thanh toán"></textarea>
                </div>

                <div class="form-group full-width">
                    <label for="qr_image">Ảnh mã QR</label>
                    <div class="qr-upload-zone">
                        <input type="file"
                               name="qr_image"
                               id="qr_image">
                    </div>
                </div>

                <div class="form-group full-width">
                    <label class="checkbox-container">
                        <input type="checkbox"
                               name="is_active"
                               checked>
                        Kích hoạt phương thức này ngay
                    </label>
                </div>

            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    Tạo phương thức
                </button>
            </div>

        </form>

    </div>

</div>

@endsection