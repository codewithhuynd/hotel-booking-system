<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">

    <title>
        Thanh toán
    </title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            padding: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        h1 {
            margin-bottom: 20px;
        }

        .payment-type {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 13px;
            font-weight: bold;
        }

        .price {
            color: #16a34a;
            font-size: 28px;
            font-weight: bold;
            margin: 15px 0;
        }

        .section {
            margin-top: 25px;
        }

        .section h3 {
            margin-bottom: 10px;
        }

        .bank-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 16px;
            border-radius: 10px;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            margin-top: 8px;
            margin-bottom: 18px;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 14px 18px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 15px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #2563eb;
        }
    </style>
</head>

<body>

<div class="container">

    <a
        href="{{ route('guest.bookings.index') }}"
        class="back">
        ← Quay lại bookings
    </a>

    <div class="card">

        <h1>
            {{ $payment->type === 'deposit'
                ? 'Thanh toán tiền cọc'
                : 'Thanh toán phần còn lại' }}
        </h1>

        <div class="payment-type">
            {{ strtoupper($payment->type) }}
        </div>

        <div class="price">
            {{ number_format($payment->deposit_amount) }} VND
        </div>

        <p>
            <strong>Mã giao dịch:</strong>
            {{ $payment->transaction_code }}
        </p>

        <br>

        <p>
            <strong>Deadline:</strong>

            {{ $payment->deposit_deadline
                ? $payment->deposit_deadline->format('d/m/Y H:i')
                : '—' }}
        </p>

        <div class="section">

            <h3>
                Thông tin chuyển khoản
            </h3>

            <div class="bank-box">

                <p>
                    <strong>Ngân hàng:</strong>
                    MB BANK
                </p>

                <br>

                <p>
                    <strong>Số tài khoản:</strong>
                    123456789
                </p>

                <br>

                <p>
                    <strong>Chủ tài khoản:</strong>
                    HOTEL BOOKING
                </p>

                <br>

                <p>
                    <strong>Nội dung CK:</strong>
                    {{ $payment->transaction_code }}
                </p>

            </div>

        </div>

        <div class="section">

            <h3>
                Upload minh chứng thanh toán
            </h3>

            @if ($errors->any())

                <div class="error">

                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach

                </div>

            @endif

            @if(session('success'))

                <div class="success">
                    {{ session('success') }}
                </div>

            @endif

            <form
                method="POST"
                enctype="multipart/form-data"
                action="{{ route('guest.payments.upload-proof', $payment) }}">

                @csrf

                <label>
                    Ảnh bill chuyển khoản
                </label>

                <input
                    type="file"
                    name="proof_image"
                    required>

                <label>
                    Phương thức thanh toán
                </label>

                <select
                    name="payment_method"
                    required>

                    <option value="banking">
                        Chuyển khoản ngân hàng
                    </option>

                    <option value="momo">
                        MoMo
                    </option>

                    <option value="vnpay">
                        VNPay
                    </option>

                    <option value="cash">
                        Tiền mặt
                    </option>

                </select>

                <button type="submit">
                    Tôi đã thanh toán
                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>