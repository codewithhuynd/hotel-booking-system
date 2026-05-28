<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/heading-font.css">
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">

@include('partials.toast-notification')

<div class="mx-auto max-w-5xl px-4 py-8">
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <p class="text-sm uppercase tracking-[0.25em] text-emerald-600">Đơn đặt phòng của bạn</p>
            <h1 class="text-3xl font-semibold text-slate-900">{{ $booking->booking_code }}</h1>
        </div>
        <a href="{{ route('guest.bookings.index') }}" class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Quay lại</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-xl font-semibold text-slate-900">Thông tin đặt phòng</h2>
            <dl class="grid gap-4 text-sm md:grid-cols-2">
                <div><dt class="text-slate-500">Phòng</dt><dd class="font-semibold text-slate-900">{{ $booking->room->room_name ?? '—' }}</dd></div>
                <div><dt class="text-slate-500">Trạng thái</dt><dd class="font-semibold text-slate-900">{{ $booking->displayStatusLabel() }}</dd></div>
                <div><dt class="text-slate-500">Ngày nhận</dt><dd class="font-semibold text-slate-900">{{ $booking->check_in_date?->format('d/m/Y') }}</dd></div>
                <div><dt class="text-slate-500">Ngày trả</dt><dd class="font-semibold text-slate-900">{{ $booking->check_out_date?->format('d/m/Y') }}</dd></div>
                <div><dt class="text-slate-500">Số khách</dt><dd class="font-semibold text-slate-900">{{ $booking->guest_count }}</dd></div>
                <div><dt class="text-slate-500">Tổng tiền</dt><dd class="font-semibold text-emerald-700">{{ number_format($booking->total_price, 0, ',', '.') }} VND</dd></div>
            </dl>
            @if($booking->note)
                <div class="mt-6 rounded-2xl bg-slate-50 p-4 text-sm text-slate-600">{{ $booking->note }}</div>
            @endif
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-xl font-semibold text-slate-900">Thanh toán</h2>
            @forelse($booking->payments as $payment)
                <article class="mb-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm">
                    <p class="font-semibold text-slate-900">{{ $payment->displayTypeLabel() }}</p>
                    <p class="text-slate-500">Số tiền: {{ number_format($payment->deposit_amount, 0, ',', '.') }} VND</p>
                    <p class="text-slate-500">Phương thức: {{ $payment->payment_method }}</p>
                    <p class="text-slate-500">Trạng thái: {{ $payment->displayStatusLabel() }}</p>
                    @if($payment->proof_image)
                        <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="mt-2 inline-block text-emerald-700 hover:underline">Xem minh chứng</a>
                    @endif
                    @if($payment->type === 'deposit')
                        <a href="{{ route('guest.payments.show', $payment) }}" class="mt-3 inline-block rounded-xl bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">Xem / cập nhật thanh toán</a>
                    @endif
                </article>
            @empty
                <p class="text-sm text-slate-500">Chưa có giao dịch thanh toán.</p>
            @endforelse
        </section>
    </div>
</div>
@include('partials.notification-modal')
</body>
</html>
