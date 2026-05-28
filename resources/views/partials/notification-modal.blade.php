@php
    $latestNotification = auth()->check()
        ? auth()->user()->unreadNotifications()->latest()->first()
        : null;
@endphp

@if($latestNotification)
<style>
    .ntf-backdrop {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        background: rgba(15, 23, 42, 0.65);
    }
    .ntf-modal {
        width: 100%;
        max-width: 420px;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.25);
        overflow: hidden;
        font-family: Arial, Helvetica, sans-serif;
    }
    .ntf-header, .ntf-footer {
        padding: 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .ntf-footer {
        border-top: 1px solid #e5e7eb;
        border-bottom: 0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .ntf-title { font-size: 13px; text-transform: uppercase; letter-spacing: .2em; color: #059669; }
    .ntf-heading { margin-top: 6px; font-size: 20px; font-weight: 700; color: #0f172a; }
    .ntf-body { padding: 16px; color: #475569; line-height: 1.6; }
    .ntf-btn { border: 0; border-radius: 10px; padding: 10px 14px; font-weight: 700; cursor: pointer; }
    .ntf-btn-secondary { background: #111827; color: #fff; }
    .ntf-btn-primary { background: #10b981; color: #fff; }
    .ntf-close { border: 0; background: transparent; cursor: pointer; color: #64748b; font-size: 18px; }
</style>

<div id="notification-modal-backdrop" class="ntf-backdrop" data-notification-id="{{ $latestNotification->id ?? '' }}" role="dialog" aria-modal="true" aria-label="Thông báo mới">
    <div class="ntf-modal">
        <div class="ntf-header" style="display:flex; align-items:flex-start; justify-content:space-between; gap:12px;">
            <div>
                <div class="ntf-title">Thông báo mới</div>
                <div class="ntf-heading">{{ $latestNotification->data['title'] ?? 'Bạn có thông báo mới' }}</div>
            </div>
            <button id="notification-close-btn" type="button" class="ntf-close" aria-label="Đóng thông báo">×</button>
        </div>

        <div class="ntf-body">
            <p>{{ $latestNotification->data['message'] ?? 'Vui lòng kiểm tra thông báo để tiếp tục.' }}</p>
        </div>

        <div class="ntf-footer">
            @php
                $notificationUrl = $latestNotification->data['url'] ?? null;
                if (! $notificationUrl && auth()->check()) {
                    if (! empty($latestNotification->data['booking_id'])) {
                        $notificationUrl = auth()->user()->role === 'host'
                            ? route('admin.bookings.show', ['booking' => $latestNotification->data['booking_id']])
                            : route('guest.bookings.show', ['booking' => $latestNotification->data['booking_id']]);
                    } elseif (! empty($latestNotification->data['payment_id'])) {
                        $notificationUrl = auth()->user()->role === 'host'
                            ? route('admin.payments.show', ['payment' => $latestNotification->data['payment_id']])
                            : route('guest.payments.show', ['payment' => $latestNotification->data['payment_id']]);
                    }
                }
            @endphp
            <a href="{{ route('notifications.index') }}" class="ntf-btn ntf-btn-secondary">Xem tất cả</a>
            @if($notificationUrl)
                <a id="notification-go-btn" href="{{ $notificationUrl }}" class="ntf-btn ntf-btn-primary">Đi đến thông báo</a>
            @else
                <button id="notification-confirm-btn" type="button" class="ntf-btn ntf-btn-primary">Đóng</button>
            @endif
        </div>
    </div>
</div>

<script>
    (function () {
        const backdrop = document.getElementById('notification-modal-backdrop');
        if (!backdrop) return;

        const notificationId = backdrop.getAttribute('data-notification-id');
        const markReadUrl = "{{ route('notifications.mark-read', '__NOTIFICATION_ID__') }}".replace('__NOTIFICATION_ID__', notificationId);

        function closeNotificationModal() {
            backdrop.style.display = 'none';
            document.body.style.overflow = '';
        }

        function markAsRead() {
            if (!notificationId) return;

            fetch(markReadUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'same-origin'
            }).catch(function () {
                // Ignore network error; modal can still be closed.
            });
        }

        document.body.style.overflow = 'hidden';

        function handleClose() {
            markAsRead();
            closeNotificationModal();
        }

        document.getElementById('notification-close-btn')?.addEventListener('click', handleClose);
        document.getElementById('notification-confirm-btn')?.addEventListener('click', handleClose);
        document.getElementById('notification-go-btn')?.addEventListener('click', function () {
            markAsRead();
            closeNotificationModal();
        });

        backdrop.addEventListener('click', function (event) {
            if (event.target === backdrop) {
                handleClose();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                handleClose();
            }
        });
    })();
</script>
@endif
