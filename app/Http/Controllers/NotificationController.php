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

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update([
            'is_read' => true,
        ]);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | HOST CLICK NOTIFICATION
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'host') {

            if ($notification->booking_id) {
                return redirect()->route('host.bookings.show', $notification->booking_id);
            }

            if ($notification->type === 'payment_uploaded' && $notification->payment_id) {
                return redirect()->route('host.payments.show', $notification->payment_id);
            }

            return redirect()->route('host.bookings.index');
        }

        /*
        |--------------------------------------------------------------------------
        | GUEST CLICK NOTIFICATION
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'guest') {

            if ($notification->booking_id) {
                return redirect()->route('guest.bookings.index');
            }

            return redirect()->route('home');
        }

        return redirect()->route('home');
    }

    public function markAllAsRead()
    {
        Auth::user()
            ->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back();
    }
}