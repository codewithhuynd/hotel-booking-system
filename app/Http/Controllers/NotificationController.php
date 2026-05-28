<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function poll()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->orderByDesc('id')
            ->take(8)
            ->get();

        $unreadCount = $user->notifications()
            ->where('is_read', false)
            ->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title ?? 'Thông báo mới',
                    'message' => $notification->message ?? '',
                    'is_read' => (bool) $notification->is_read,
                    'url' => route('notifications.read', $notification->id),
                    'created_at' => optional($notification->created_at)->format('H:i d/m/Y'),
                ];
            })->values(),
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update([
            'is_read' => true,
        ]);

        $user = Auth::user();

        if ($user->role === 'host') {
            if ($notification->booking_id) {
                return redirect()->route('host.bookings.show', $notification->booking_id);
            }

            return redirect()->route('host.bookings.index');
        }

        if ($user->role === 'guest') {
            if ($notification->booking_id) {
                return redirect()->route('guest.bookings.index');
            }

            return redirect()->route('home');
        }

        return redirect()->route('home');
    }

    public function markAllAsRead(Request $request)
    {
        Auth::user()
            ->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return back();
    }

    public function dropdown()
    {
        $notifications = Auth::user()
            ->notifications()
            ->orderByDesc('id')
            ->take(8)
            ->get();

        $unreadCount = Auth::user()
            ->notifications()
            ->where('is_read', false)
            ->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'html' => view('partials.notification-list', compact('notifications'))->render(),
        ]);
    }
}