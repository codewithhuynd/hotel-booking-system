@extends('host.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Thông báo</h1>

        <form action="{{ route('notifications.readAll') }}" method="POST">
            @csrf
            @method('PATCH')
            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Đánh dấu tất cả đã đọc
            </button>
        </form>
    </div>

    <div class="space-y-4">
        @forelse ($notifications as $notification)
            <div class="p-4 rounded border {{ $notification->is_read ? 'bg-white' : 'bg-blue-50' }}">
                <h3 class="font-semibold">
                    {{ $notification->title }}
                </h3>

                <p class="text-gray-600 mt-1">
                    {{ $notification->message }}
                </p>

                <p class="text-sm text-gray-400 mt-2">
                    {{ $notification->created_at->diffForHumans() }}
                </p>

                @if (! $notification->is_read)
                    <form action="{{ route('notifications.read', $notification) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PATCH')
                        <button class="text-blue-600 underline">
                            Đánh dấu đã đọc
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <p>Chưa có thông báo nào.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
</div>
@endsection