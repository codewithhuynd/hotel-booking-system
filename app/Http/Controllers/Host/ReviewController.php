<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Room;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'rating' => ['nullable', 'integer', 'between:1,5'],
            'room_id' => ['nullable', 'integer'],
            'visibility' => ['nullable', 'in:visible,hidden'],
        ]);

        $reviews = Review::with(['user:id,full_name,email', 'room:id,room_name,room_code', 'booking:id,booking_code'])
            ->when($filters['q'] ?? null, function ($query, string $keyword) {
                $like = '%' . $keyword . '%';

                $query->where(function ($query) use ($like) {
                    $query->where('comment', 'like', $like)
                        ->orWhereHas('user', fn ($user) => $user->where('full_name', 'like', $like)->orWhere('email', 'like', $like))
                        ->orWhereHas('booking', fn ($booking) => $booking->where('booking_code', 'like', $like));
                });
            })
            ->when($filters['rating'] ?? null, fn ($query, $rating) => $query->where('rating', $rating))
            ->when($filters['room_id'] ?? null, fn ($query, $roomId) => $query->where('room_id', $roomId))
            ->when(($filters['visibility'] ?? null) === 'visible', fn ($query) => $query->where('is_hidden', false))
            ->when(($filters['visibility'] ?? null) === 'hidden', fn ($query) => $query->where('is_hidden', true))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = Review::query()
            ->selectRaw('COUNT(*) as total, AVG(rating) as average, SUM(CASE WHEN is_hidden THEN 1 ELSE 0 END) as hidden')
            ->first();

        return view('host.reviews.index', [
            'reviews' => $reviews,
            'summary' => $summary,
            'roomOptions' => Room::orderBy('room_name')->pluck('room_name', 'id')->all(),
        ]);
    }

    public function toggle(Review $review)
    {
        $review->update(['is_hidden' => ! $review->is_hidden]);

        return back()->with('success', $review->is_hidden
            ? 'Đã ẩn đánh giá khỏi trang phòng.'
            : 'Đã hiển thị lại đánh giá.');
    }
}
