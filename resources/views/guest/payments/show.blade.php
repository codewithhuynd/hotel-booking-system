<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Thanh toán | Grand Elite Hotel</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-50 font-sans text-slate-700 min-h-screen">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- TOPBAR -->
        <div class="flex items-center justify-between border-b pb-4 mb-8">

            <a href="{{ route('guest.bookings.index') }}"
                class="flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-blue-600 transition">

                <svg class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>

                Quay lại bookings
            </a>

            <div class="font-serif text-sm tracking-[0.2em] font-bold">
                THE GRAND ELITE
            </div>
        </div>

        @php
        $defaultMethod = $paymentMethods->first();
        @endphp

        <!-- GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- LEFT -->
            <div class="lg:col-span-7 space-y-6">

                <!-- PAYMENT INFO -->
                <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">

                    <div class="h-1.5 bg-blue-600"></div>

                    <div class="p-6 sm:p-8">

                        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">

                            <span class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                                {{ strtoupper($payment->type) }}
                            </span>

                            @if($payment->deposit_deadline)

                            <div class="bg-amber-50 text-amber-700 text-xs px-3 py-1 rounded-lg">
                                Hạn:
                                {{ $payment->deposit_deadline->format('d/m/Y H:i') }}
                            </div>

                            @endif
                        </div>

                        <h1 class="font-serif text-3xl text-slate-900 mb-2">

                            {{ $payment->type === 'deposit'
                                ? 'Thanh toán tiền cọc'
                                : 'Thanh toán phần còn lại' }}

                        </h1>

                        <p class="text-sm text-slate-500 mb-6">
                            Vui lòng chuyển khoản đúng số tiền bên dưới.
                        </p>

                        <!-- MONEY -->
                        <div class="bg-slate-50 rounded-xl border p-5">

                            <div class="text-xs uppercase tracking-widest text-slate-500 mb-2">
                                Số tiền cần thanh toán
                            </div>

                            <div class="text-3xl font-extrabold text-emerald-600">
                                {{ number_format($payment->deposit_amount) }} VND
                            </div>
                        </div>

                        <!-- TRANSACTION -->
                        <div class="grid grid-cols-2 gap-4 mt-6 border-t pt-5 text-sm">

                            <div>

                                <div class="text-slate-500 text-xs mb-1">
                                    Mã giao dịch
                                </div>

                                <div class="font-bold">
                                    {{ $payment->transaction_code }}
                                </div>
                            </div>

                            <div>

                                <div class="text-slate-500 text-xs mb-1">
                                    Trạng thái
                                </div>

                                <div class="font-bold capitalize">
                                    {{ $payment->status }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BANK INFO -->
                <div class="bg-white rounded-2xl border shadow-sm p-6 sm:p-8">

                    <h2 class="font-serif text-xl text-slate-900 mb-6">
                        Thông tin thanh toán
                    </h2>

                    <div class="space-y-4">

                        <!-- METHOD -->
                        <div class="flex justify-between border-b border-dashed pb-3">

                            <span class="text-slate-500">
                                Phương thức
                            </span>

                            <span id="method-name" class="font-bold">
                                {{ $defaultMethod?->name }}
                            </span>
                        </div>

                        <!-- ACCOUNT NUMBER -->
                        <div class="flex justify-between border-b border-dashed pb-3">

                            <span class="text-slate-500">
                                Số tài khoản
                            </span>

                            <span id="account-number"
                                class="font-bold font-mono">

                                {{ $defaultMethod?->account_number ?? '---' }}

                            </span>
                        </div>

                        <!-- ACCOUNT NAME -->
                        <div class="flex justify-between border-b border-dashed pb-3">

                            <span class="text-slate-500">
                                Chủ tài khoản
                            </span>

                            <span id="account-name"
                                class="font-bold uppercase">

                                {{ $defaultMethod?->account_name ?? '---' }}

                            </span>
                        </div>

                        <!-- QR -->

                        <div id="qr-container"
                            class="{{ $defaultMethod?->type === 'vnpay' && $defaultMethod?->qr_image ? '' : 'hidden' }} pt-4">

                            <div class="text-sm text-slate-500 mb-3">
                                Quét mã QR
                            </div>

                            <img id="qr-image"
                                src="{{ $defaultMethod?->qr_image
            ? asset('storage/' . $defaultMethod->qr_image)
            : '' }}"
                                class="w-72 rounded-xl border">
                        </div>

                        <!-- TRANSFER CONTENT -->
                        <div class="bg-blue-50 border rounded-xl p-4 flex justify-between items-center">

                            <span class="text-sm text-slate-500">
                                Nội dung CK
                            </span>

                            <span class="font-bold text-blue-700 font-mono">
                                {{ $payment->transaction_code }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="lg:col-span-5">

                <div class="bg-white rounded-2xl border shadow-sm p-6 sm:p-8 sticky top-8">

                    <h2 class="font-serif text-xl text-slate-900 mb-6">
                        Xác nhận thanh toán
                    </h2>

                    @if ($errors->any())

                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6 text-sm">

                        <ul class="list-disc pl-5 space-y-1">

                            @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                            @endforeach

                        </ul>
                    </div>

                    @endif

                    @if(session('success'))

                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl p-4 mb-6 text-sm">
                        {{ session('success') }}
                    </div>

                    @endif

                    <!-- FORM -->
                    <form
                        method="POST"
                        enctype="multipart/form-data"
                        action="{{ route('guest.payments.upload-proof', $payment) }}"
                        class="space-y-5">

                        @csrf

                        <!-- FILE -->
                        <div>

                            <label class="block text-sm font-semibold mb-2">
                                Ảnh bill chuyển khoản
                            </label>

                            <input
                                type="file"
                                name="proof_image"
                                required
                                class="w-full border rounded-xl p-3 bg-slate-50">
                        </div>

                        <!-- PAYMENT METHOD -->
                        <div>

                            <label class="block text-sm font-semibold mb-2">
                                Phương thức thanh toán
                            </label>

                            <select
                                id="payment-method-select"
                                name="payment_method_id"
                                required
                                class="w-full border rounded-xl p-3 bg-slate-50">

                                @foreach($paymentMethods as $method)

                                <option value="{{ $method->id }}">
                                    {{ $method->name }}
                                </option>

                                @endforeach

                            </select>
                        </div>

                        <!-- BUTTON -->
                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition">

                            Tôi đã thanh toán
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="text-center text-xs text-slate-400 mt-16 tracking-widest uppercase">
            © 2026 The Grand Elite Hotel
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        const paymentMethods = @json($paymentMethods);

        const select = document.getElementById('payment-method-select');

        const methodName = document.getElementById('method-name');

        const accountNumber = document.getElementById('account-number');

        const accountName = document.getElementById('account-name');

        const qrImage = document.getElementById('qr-image');

        const qrContainer = document.getElementById('qr-container');

        select.addEventListener('change', function() {

            const selectedId = this.value;

            const method = paymentMethods.find(
                item => item.id == selectedId
            );

            if (!method) return;

            methodName.innerText = method.name ?? '---';

            accountNumber.innerText = method.account_number ?? '---';

            accountName.innerText = method.account_name ?? '---';

            if (method.type === 'vnpay' && method.qr_image) {

                qrImage.src = '/storage/' + method.qr_image;

                qrContainer.classList.remove('hidden');

            } else {

                qrContainer.classList.add('hidden');
            }
        });
    </script>

</body>

</html>