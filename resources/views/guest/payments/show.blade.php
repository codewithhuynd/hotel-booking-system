<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Thanh toán cọc</title>
</head>

<body>

    <h1>Thanh toán đặt cọc</h1>

    <br>

    <p>
        Mã giao dịch:
        <strong>
            {{ $payment->transaction_code }}
        </strong>
    </p>

    <p>
        Số tiền cọc:
        <strong>
            {{ number_format($payment->deposit_amount) }} VND
        </strong>
    </p>

    <br>

    <h3>Thông tin chuyển khoản</h3>

    <p>Ngân hàng: MB BANK</p>
    <p>STK: 123456789</p>
    <p>Chủ tài khoản: HOTEL BOOKING</p>

    <p>
        Nội dung CK:
        <strong>{{ $payment->transaction_code }}</strong>
    </p>

    <br><br>

    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route('guest.payments.upload-proof', $payment) }}">
        @csrf

        <label>Upload bill chuyển khoản</label>

        <br><br>

        <input
            type="file"
            name="proof_image"
            required>
        <br><br>

        <label>Phương thức thanh toán</label>

        <br><br>

        <select name="payment_method" required>
            <option value="banking">Chuyển khoản ngân hàng</option>
            <option value="momo">MoMo</option>
            <option value="vnpay">VNPay</option>
            <option value="cash">Tiền mặt</option>
        </select>
        <br><br>

        <button type="submit">
            Tôi đã thanh toán
        </button>

    </form>

</body>

</html>