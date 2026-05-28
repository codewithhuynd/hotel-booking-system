@forelse($notifications as $notification)
    <form action="{{ route('notifications.read', $notification) }}" method="POST">
        @csrf
        @method('PATCH')

        <button type="submit"
                class="notification-item {{ !$notification->is_read ? 'unread' : '' }}">
            <span>{{ $notification->title ?? 'Thông báo mới' }}</span>
            <small>{{ $notification->message ?? '' }}</small>
            <small>{{ $notification->created_at->format('H:i d/m/Y') }}</small>
        </button>
    </form>
@empty
    <div class="notification-empty">
        Chưa có thông báo nào.
    </div>
@endforelse