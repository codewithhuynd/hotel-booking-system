<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Tạo hoặc cập nhật đánh giá cho một booking đã ở xong.
     */
    public function store(Request $request, Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        if (! $booking->canBeReviewed()) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sau khi đã check-out.');
        }

        if (! $booking->room_id) {
            return back()->with('error', 'Phòng của booking này không còn tồn tại.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ], [
            'rating.required' => 'Vui lòng chọn số sao.',
            'rating.between' => 'Số sao phải từ 1 đến 5.',
            'comment.max' => 'Nhận xét không được vượt quá 1000 ký tự.',
        ]);

        $review = Review::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'user_id' => Auth::id(),
                'room_id' => $booking->room_id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        if ($review->wasRecentlyCreated) {
            notifyRole('host', 'Đánh giá mới', 'Khách ' . Auth::user()->full_name . ' đã đánh giá ' . $review->rating . ' sao cho booking #' . $booking->booking_code . '.', 'info', [
                'booking_id' => $booking->id,
                'url' => route('host.reviews.index'),
            ]);
        }

        return back()->with('success', $review->wasRecentlyCreated
            ? 'Cảm ơn bạn đã đánh giá!'
            : 'Đã cập nhật đánh giá của bạn.');
    }
}
