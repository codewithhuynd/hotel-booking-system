<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận hoàn tiền</title>
</head>
<body style="margin:0; padding:0; background-color:#f5f7fb; font-family:Arial, Helvetica, sans-serif; color:#0f172a;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f7fb; padding:24px;">
        <tr>
            <td align="center">
                <table width="640" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:16px; overflow:hidden; border:1px solid #e5e7eb;">
                    <tr style="background:#111827;">
                        <td style="padding:24px; color:#fff; font-size:20px; font-weight:700;">{{ $hotelName }}</td>
                    </tr>
                    <tr>
                        <td style="padding:24px;">
                            <p style="margin:0 0 8px; font-size:16px;">Xin chào <strong>{{ $guestName }}</strong>,</p>
                            <p style="margin:0 0 16px; line-height:1.6;">Hoàn tiền cho đơn đặt phòng của bạn đã được xác nhận thành công. Dưới đây là thông tin chi tiết:</p>
                            <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse:collapse; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px;">
                                <tr><td style="border-bottom:1px solid #e2e8f0; width:180px; color:#475569;">Khách hàng</td><td style="border-bottom:1px solid #e2e8f0; font-weight:700;">{{ $guestName }}</td></tr>
                                <tr><td style="border-bottom:1px solid #e2e8f0; color:#475569;">Mã booking</td><td style="border-bottom:1px solid #e2e8f0; font-weight:700;">{{ $bookingCode }}</td></tr>
                                <tr><td style="border-bottom:1px solid #e2e8f0; color:#475569;">Phòng</td><td style="border-bottom:1px solid #e2e8f0; font-weight:700;">{{ $roomName }}</td></tr>
                                <tr><td style="border-bottom:1px solid #e2e8f0; color:#475569;">Số tiền hoàn</td><td style="border-bottom:1px solid #e2e8f0; font-weight:700; color:#dc2626;">{{ $refundAmount }}</td></tr>
                                <tr><td style="border-bottom:1px solid #e2e8f0; color:#475569;">Ngân hàng</td><td style="border-bottom:1px solid #e2e8f0; font-weight:700;">{{ $bankName }}</td></tr>
                                <tr><td style="border-bottom:1px solid #e2e8f0; color:#475569;">Số tài khoản</td><td style="border-bottom:1px solid #e2e8f0; font-weight:700;">{{ $bankAccountNumber }}</td></tr>
                                <tr><td style="border-bottom:1px solid #e2e8f0; color:#475569;">Tên chủ tài khoản</td><td style="border-bottom:1px solid #e2e8f0; font-weight:700;">{{ $bankAccountName }}</td></tr>
                                <tr><td style="border-bottom:1px solid #e2e8f0; color:#475569;">Mã giao dịch hoàn tiền</td><td style="border-bottom:1px solid #e2e8f0; font-weight:700;">{{ $transactionCode }}</td></tr>
                                <tr><td style="color:#475569;">Thời gian xác nhận</td><td style="font-weight:700;">{{ $completedAt }}</td></tr>
                            </table>
                            <p style="margin:16px 0 0; line-height:1.6; color:#475569;">Cảm ơn quý khách đã tin tưởng và đặt phòng tại {{ $hotelName }}.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
