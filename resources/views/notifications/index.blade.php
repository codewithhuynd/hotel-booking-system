<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold">Thông báo</h2>
            <p class="text-slate-500">Theo dõi các cập nhật đặt phòng, thanh toán và hủy booking.</p>
        </div>

        @if($unreadCount > 0)
            <form method="POST" action="{{ route('notifications.mark-all-read') }}">@csrf<button class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Đánh dấu đã đọc tất cả</button></form>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="rounded-2xl bg-white p-8 text-center text-slate-500 shadow-sm">Bạn chưa có thông báo nào.</div>
    @else
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <article class="rounded-2xl border {{ $notification->read_at ? 'border-slate-200 bg-white' : 'border-amber-200 bg-amber-50' }} p-4 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">{{ $notification->data['title'] ?? 'Thông báo' }}</h3>
                            <p class="text-slate-600">{{ $notification->data['message'] ?? '' }}</p>
                            <small class="text-slate-400">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>

                        @if(is_null($notification->read_at))
                            <form method="POST" action="{{ route('notifications.mark-read', $notification->id) }}">@csrf<button class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Đánh dấu đã đọc</button></form>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-4">{{ $notifications->links() }}</div>
    @endif
</div>
    @include('partials.notification-modal')
</body>
</html>
