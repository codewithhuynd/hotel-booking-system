<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn đặt phòng của tôi - Resort Luxury</title>

    <!-- Tailwind CSS for high-end utility design -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Luxury & Premium Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght=0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #5c5d6e; /* Giữ màu nền gốc của bạn hoặc chỉnh tối đi một chút để nổi bật hộp trắng */
            background-image: 
                radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(37, 99, 235, 0.08) 0px, transparent 50%);
            background-attachment: fixed;
        }

        .font-serif-luxury {
            font-family: 'Cormorant Garamond', serif;
        }

        /* THAY ĐỔI: Thẻ kinh mờ nền TRẮNG cao cấp (Glassmorphism Light) */
        .luxury-card {
            background: rgba(255, 255, 255, 0.92); /* Nền trắng đục tinh tế */
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .luxury-card:hover {
            border-color: rgba(16, 185, 129, 0.3);
            box-shadow: 0 25px 50px -12px rgba(16, 185, 129, 0.15);
            transform: translateY(-2px);
        }

        /* THAY ĐỔI: Ô nhập liệu cho nền trắng */
        .glass-input {
            background: rgba(248, 250, 252, 0.8) !important;
            border: 1px solid rgba(226, 232, 240, 1) !important;
            color: #0f172a !important; /* Chữ tối màu để dễ đọc trên nền trắng */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-input:focus {
            outline: none;
            background: #ffffff !important;
            border-color: rgba(16, 185, 129, 0.6) !important;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.1);
        }

        /* Nút Shimmer ngọc lục bảo */
        .btn-shimmer {
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-shimmer::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 30%;
            height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(30deg);
            transition: none;
        }

        .btn-shimmer:hover::after {
            left: 150%;
            transition: all 0.8s ease-in-out;
        }
    </style>
</head>

<body class="text-slate-100 min-h-screen p-4 md:p-8">

<div class="max-w-5xl mx-auto my-6">

    <!-- Top Luxury Navigation Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-10 pb-6 border-b border-slate-700/40">
        <div>
            <div class="flex items-center space-x-2 mb-1">
                <span class="h-px w-6 bg-emerald-400"></span>
                <span class="text-xs uppercase tracking-[0.25em] text-emerald-300 font-semibold">Tài khoản thành viên</span>
            </div>
            <h1 class="font-serif-luxury text-4xl md:text-5xl text-white font-semibold tracking-wide">
                Đơn đặt phòng của tôi
            </h1>
        </div>

        <a href="{{ route('home') }}" class="group border border-slate-700/50 bg-slate-900/40 hover:bg-slate-900/80 text-slate-200 hover:text-white px-6 py-3.5 rounded-2xl transition-all duration-300 text-sm font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 transform group-hover:-translate-y-0.5 transition-transform text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Trang chủ
        </a>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3 shadow-inner">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-8 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm flex items-center gap-3 shadow-inner">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <!-- BOOKINGS LIST -->
    <div class="space-y-8">
        @forelse($bookings as $booking)

            <div class="luxury-card rounded-3xl p-6 md:p-8">

                <!-- Header block inside card -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-slate-200/80">
                    <div>
                        <span class="text-[10px] uppercase tracking-[0.2em] text-emerald-600 font-bold block mb-1">TÊN PHÒNG NGHỈ DƯỠNG</span>
                        <h2 class="font-serif-luxury text-2xl md:text-3xl text-slate-800 font-semibold tracking-wide">
                            {{ $booking->room->room_name }}
                        </h2>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Booking Code Badge -->
                        <span class="text-xs font-semibold tracking-wider bg-slate-100 text-slate-700 border border-slate-200 px-3.5 py-1.5 rounded-xl">
                            Mã: {{ $booking->booking_code }}
                        </span>

                        <!-- Booking Main Status Badge -->
                        @php
                            $bStatus = $booking->status;
                            $bStatusColor = 'text-amber-600 bg-amber-50 border-amber-200';
                            if(in_array($bStatus, ['confirmed', 'completed'], true)) {
                                $bStatusColor = 'text-emerald-600 bg-emerald-50 border-emerald-200';
                            } elseif(in_array($bStatus, ['cancelled'], true)) {
                                $bStatusColor = 'text-rose-600 bg-rose-50 border-rose-200';
                            } elseif(in_array($bStatus, ['checked_in', 'checked_out'], true)) {
                                $bStatusColor = 'text-blue-600 bg-blue-50 border-blue-200';
                            }
                        @endphp
                        <span class="text-xs font-bold px-3.5 py-1.5 rounded-xl border {{ $bStatusColor }}">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Core Parameters Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 py-6 border-b border-slate-200/60 text-sm">
                    <div>
                        <span class="block text-xs uppercase tracking-wider text-slate-400 font-medium mb-1">Ngày nhận phòng</span>
                        <strong class="text-slate-800 font-semibold text-base">
                            {{ $booking->check_in_date?->format('d/m/Y') ?? $booking->check_in_date }}
                        </strong>
                    </div>

                    <div>
                        <span class="block text-xs uppercase tracking-wider text-slate-400 font-medium mb-1">Ngày trả phòng</span>
                        <strong class="text-slate-800 font-semibold text-base">
                            {{ $booking->check_out_date?->format('d/m/Y') ?? $booking->check_out_date }}
                        </strong>
                    </div>

                    <div>
                        <span class="block text-xs uppercase tracking-wider text-slate-400 font-medium mb-1">Số lượng khách</span>
                        <strong class="text-slate-800 font-semibold text-base">
                            {{ $booking->guest_count }} người
                        </strong>
                    </div>

                    <div>
                        <span class="block text-xs uppercase tracking-wider text-slate-400 font-medium mb-1 text-right">Tổng chi phí</span>
                        <p class="price text-right text-xl md:text-2xl font-black text-emerald-600 tracking-tight">
                            {{ number_format($booking->total_price) }} VND
                        </p>
                    </div>
                </div>

                <!-- Booking Process State Messages -->
                <div class="py-4 text-xs md:text-sm text-slate-600 flex items-center gap-2 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                    @if($booking->status === 'pending')
                        <span>Chờ host xác nhận đơn đặt phòng của bạn.</span>
                    @elseif($booking->status === 'awaiting_deposit')
                        <span class="text-amber-600">Vui lòng tiến hành thanh toán tiền cọc để giữ chỗ.</span>
                    @elseif($booking->status === 'confirmed')
                        <span class="text-emerald-600">Đơn đặt phòng đã được xác nhận chính thức.</span>
                    @elseif($booking->status === 'checked_in')
                        <span class="text-blue-600">Chúc bạn có một kỳ nghỉ tuyệt vời tại Resort.</span>
                    @elseif($booking->status === 'checked_out')
                        <span class="text-purple-600">Đã hoàn tất thủ tục trả phòng nghỉ dưỡng.</span>
                    @elseif($booking->status === 'completed')
                        <span class="text-emerald-600">Đơn đặt phòng đã hoàn thành trọn vẹn.</span>
                    @elseif($booking->status === 'cancelled')
                        <span class="text-rose-600">Đơn đặt phòng đã bị hủy bỏ.</span>
                    @endif
                </div>

                <!-- DEPOSIT PAYMENT BLOCK -->
                @if($booking->depositPayment)
                    <div class="mt-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        @php $deposit = $booking->depositPayment; @endphp

                        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 mb-4">
                            <h3 class="text-sm uppercase tracking-wider text-slate-700 font-bold flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Khoản thanh toán đặt cọc (Deposit)
                            </h3>

                            @php
                                $dStatus = $deposit->status;
                                $dStatusClass = 'border-slate-200 text-slate-500 bg-slate-100';
                                if($dStatus === 'paid') $dStatusClass = 'border-emerald-200 text-emerald-600 bg-emerald-50';
                                if($dStatus === 'pending') $dStatusClass = 'border-amber-200 text-amber-600 bg-amber-50';
                                if($dStatus === 'expired') $dStatusClass = 'border-rose-200 text-rose-600 bg-rose-50';
                            @endphp
                            <span class="text-[11px] uppercase font-bold tracking-wider px-3 py-1 rounded-lg border {{ $dStatusClass }}">
                                {{ $deposit->displayStatusLabel() }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-500 mb-4">
                            <p>Số tiền cọc: <strong class="text-slate-800 text-sm font-bold ml-1">{{ number_format($deposit->deposit_amount) }} VND</strong></p>
                            <p class="sm:text-right">Hạn chót thanh toán: <strong class="text-slate-700 ml-1 font-medium">{{ $deposit->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}</strong></p>
                        </div>

                        <!-- Deposit Call to Actions -->
                        @if($booking->status === 'awaiting_deposit' && $deposit->status === 'unpaid')
                            <div class="pt-2">
                                <a href="{{ route('guest.payments.show', $deposit) }}" class="inline-block btn-shimmer bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-semibold text-xs px-5 py-2.5 rounded-xl shadow-md transition-all duration-300">
                                    Thanh toán cọc ngay
                                </a>
                            </div>
                        @elseif($deposit->status === 'pending')
                            <p class="text-xs text-amber-600 font-semibold">Đang chờ quản trị viên Resort xác nhận giao dịch thanh toán cọc.</p>
                        @elseif($deposit->status === 'paid')
                            <p class="text-xs text-emerald-600 font-semibold flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Bạn đã hoàn thành việc đóng tiền cọc an toàn.
                            </p>
                        @elseif($deposit->status === 'expired')
                            <p class="text-xs text-rose-600 font-semibold">Rất tiếc, liên kết thanh toán tiền đặt cọc đã hết thời hạn.</p>
                        @endif
                    </div>
                @endif

                <!-- FINAL PAYMENT BLOCK -->
                @if($booking->finalPayment)
                    <div class="mt-4 p-5 rounded-2xl bg-slate-50 border border-slate-200">
                        @php $final = $booking->finalPayment; @endphp

                        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-3 mb-4">
                            <h3 class="text-sm uppercase tracking-wider text-slate-700 font-bold flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                Khoản thanh toán còn lại (Final Payment)
                            </h3>

                            @php
                                $fStatus = $final->status;
                                $fStatusClass = 'border-slate-200 text-slate-500 bg-slate-100';
                                if($fStatus === 'paid') $fStatusClass = 'border-emerald-200 text-emerald-600 bg-emerald-50';
                                if($fStatus === 'pending') $fStatusClass = 'border-amber-200 text-amber-600 bg-amber-50';
                                if($fStatus === 'expired') $fStatusClass = 'border-rose-200 text-rose-600 bg-rose-50';
                            @endphp
                            <span class="text-[11px] uppercase font-bold tracking-wider px-3 py-1 rounded-lg border {{ $fStatusClass }}">
                                {{ $final->displayStatusLabel() }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-500 mb-4">
                            <p>Số tiền còn lại: <strong class="text-slate-800 text-sm font-bold ml-1">{{ number_format($final->deposit_amount) }} VND</strong></p>
                            <p class="sm:text-right">Hạn chót thanh toán: <strong class="text-slate-700 ml-1 font-medium">{{ $final->deposit_deadline?->format('d/m/Y H:i') ?? '—' }}</strong></p>
                        </div>

                        <!-- Final Payment Call to Actions -->
                        @if($booking->status === 'checked_out' && $final->status === 'unpaid')
                            <div class="pt-2">
                                <a href="{{ route('guest.payments.show', $final) }}" class="inline-block btn-shimmer bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-semibold text-xs px-5 py-2.5 rounded-xl shadow-md transition-all duration-300">
                                    Thanh toán phần còn lại
                                </a>
                            </div>
                        @elseif($final->status === 'pending')
                            <p class="text-xs text-amber-600 font-semibold">Resort đang tiến hành kiểm tra giao dịch chuyển khoản cuối của bạn.</p>
                        @elseif($final->status === 'paid')
                            <p class="text-xs text-emerald-600 font-semibold flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Toàn bộ hóa đơn lưu trú của bạn đã được quyết toán thành công.
                            </p>
                        @elseif($final->status === 'expired')
                            <p class="text-xs text-rose-600 font-semibold">Hạn thanh toán cuối cùng của quý khách đã quá hạn.</p>
                        @endif
                    </div>
                @endif

                <!-- CANCELLATION INFO & REFUND FORM -->
                @if($booking->cancellation)
                    <div class="mt-4 p-5 rounded-2xl bg-rose-50 border border-rose-100">
                        <h3 class="text-sm uppercase tracking-wider text-rose-600 font-bold mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Chi tiết thông tin hủy đơn
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-600 mb-4">
                            <p>Hủy bởi: <strong class="text-slate-800 ml-1 font-semibold">{{ $booking->cancellation->cancelled_by_type === 'host' ? 'Host (Resort)' : 'Khách hàng' }}</strong></p>
                            <p>Trạng thái hoàn tiền: <strong class="ml-1 font-semibold {{ $booking->cancellation->refund_completed ? 'text-emerald-600' : 'text-amber-600' }}">{{ $booking->cancellation->refund_completed ? 'Đã hoàn tiền thành công' : 'Đang chờ hoàn tiền' }}</strong></p>
                            <p class="sm:col-span-2 bg-white p-3 rounded-xl border border-slate-200">Lý do hủy đơn: <span class="italic text-slate-500">{{ $booking->cancellation->reason }}</span></p>
                        </div>

                        <!-- Refund Bank Info display if exist -->
                        @if($booking->cancellation->bank_name)
                            <div class="bg-white rounded-xl p-4 border border-slate-200 text-xs space-y-2 mt-3">
                                <span class="block uppercase tracking-wider font-bold text-slate-400 text-[10px]">TÀI KHOẢN NHẬN HOÀN TIỀN</span>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-slate-600">
                                    <p>Ngân hàng: <strong class="text-slate-800 font-semibold">{{ $booking->cancellation->bank_name }}</strong></p>
                                    <p>Số tài khoản: <strong class="text-slate-800 font-semibold">{{ $booking->cancellation->bank_account_number }}</strong></p>
                                    <p>Chủ tài khoản: <strong class="text-slate-800 font-semibold">{{ $booking->cancellation->bank_account_name }}</strong></p>
                                </div>
                            </div>
                        @endif

                        <!-- Refund Information Request Form -->
                        @if(
                            $booking->status === 'cancelled'
                            && $booking->cancellation->cancelled_by_type === 'host'
                            && !$booking->cancellation->refund_completed
                            && !$booking->cancellation->bank_name
                            && ($booking->depositPayment && in_array($booking->depositPayment->status, ['pending', 'paid'], true))
                        )
                            <div class="mt-6 pt-6 border-t border-rose-200">
                                <h4 class="text-xs uppercase tracking-wider text-slate-700 font-bold mb-2">Nhập thông tin nhận hoàn tiền (Refund)</h4>
                                <p class="text-xs text-slate-500 mb-4">Do phòng nghỉ đã được hủy bởi Resort, bạn vui lòng khai báo tài khoản ngân hàng dưới đây để chúng tôi thực hiện lệnh hoàn tiền cọc.</p>

                                <form method="POST" action="{{ route('guest.bookings.refund-bank', $booking) }}" class="space-y-4">
                                    @csrf

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-[11px] text-slate-500 font-semibold mb-1.5">Tên Ngân hàng</label>
                                            <input type="text" name="bank_name" required value="{{ old('bank_name') }}" placeholder="Ví dụ: Vietcombank..." class="glass-input w-full px-4 py-3 rounded-xl text-xs">
                                        </div>

                                        <div>
                                            <label class="block text-[11px] text-slate-500 font-semibold mb-1.5">Số tài khoản</label>
                                            <input type="text" name="bank_account_number" required value="{{ old('bank_account_number') }}" placeholder="Nhập số tài khoản..." class="glass-input w-full px-4 py-3 rounded-xl text-xs">
                                        </div>

                                        <div>
                                            <label class="block text-[11px] text-slate-500 font-semibold mb-1.5">Tên chủ tài khoản</label>
                                            <input type="text" name="bank_account_name" required value="{{ old('bank_account_name') }}" placeholder="Tên viết hoa không dấu..." class="glass-input w-full px-4 py-3 rounded-xl text-xs">
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btn-shimmer bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-semibold text-xs px-6 py-3 rounded-xl shadow-md transition-all duration-300">
                                            Gửi thông tin tài khoản hoàn tiền
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @elseif(
                            $booking->status === 'cancelled'
                            && $booking->cancellation->cancelled_by_type === 'host'
                            && !$booking->cancellation->refund_completed
                            && $booking->cancellation->bank_name
                        )
                            <p class="text-xs text-amber-600 font-semibold mt-4 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Bạn đã điền thông tin hoàn tiền thành công. Vui lòng chờ Resort giải ngân.
                            </p>
                        @endif
                    </div>
                @endif

                <!-- Bottom Cancel Action Button -->
                @if(!in_array($booking->status, ['checked_in', 'checked_out', 'completed', 'cancelled'], true))
                    <div class="mt-6 pt-5 border-t border-slate-200 text-right">
                        <a href="{{ route('guest.bookings.cancel-form', $booking) }}" class="inline-flex items-center gap-1.5 border border-rose-200 bg-rose-50 hover:bg-rose-500 text-rose-600 hover:text-white font-bold text-xs px-5 py-2.5 rounded-xl transition-all duration-300 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hủy đơn đặt phòng này
                        </a>
                    </div>
                @endif

            </div>

        @empty
            <!-- Beautiful Empty State -->
            <div class="luxury-card rounded-3xl p-12 text-center border border-slate-200 max-w-xl mx-auto">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 border border-slate-200 text-slate-400 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <h3 class="font-serif-luxury text-2xl text-slate-800 font-bold mb-2">Chưa có đơn đặt phòng</h3>
                <p class="text-slate-500 text-sm max-w-xs mx-auto mb-6">Bạn chưa có đặt phòng nghỉ dưỡng nào trên hệ thống của chúng tôi.</p>
                <a href="{{ route('rooms.index') }}" class="inline-block btn-shimmer bg-gradient-to-r from-emerald-600 to-emerald-500 hover:from-emerald-500 hover:to-emerald-400 text-white font-semibold text-xs px-6 py-3 rounded-xl shadow-md transition-all duration-300">
                    Khám phá danh sách phòng nghỉ
                </a>
            </div>
        @endforelse
    </div>

</div>

</body>
</html>