<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phản hồi từ khách sạn</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8fafc; color: #0f172a; margin: 0; padding: 24px;">
    <div style="max-width: 640px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
        <div style="background: linear-gradient(135deg, #0f172a, #1e293b); color: #ffffff; padding: 20px 24px;">
            <h2 style="margin: 0; font-size: 22px;">Phản hồi từ {{ $hotelName }}</h2>
            <p style="margin: 6px 0 0; color: #cbd5e1; font-size: 14px;">Xin chào {{ $guestName }},</p>
        </div>

        <div style="padding: 24px; line-height: 1.6; font-size: 15px; color: #334155;">
            <p style="margin-top: 0;">{{ $replyMessage }}</p>

            @if(!empty($originalMessage))
                <div style="margin-top: 18px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; font-size: 14px; color: #475569;">
                    <strong>Tin nhắn ban đầu của bạn:</strong><br>
                    {{ $originalMessage }}
                </div>
            @endif

            <p style="margin-bottom: 0; margin-top: 18px; color: #475569;">Trân trọng,<br>{{ $hotelName }}</p>
        </div>
    </div>
</body>
</html>
