<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Tạo đánh giá mẫu cho khoảng 70% booking đã ở xong.
     */
    public function run(): void
    {
        $comments = [
            5 => ['Phòng sạch sẽ, view đẹp, nhân viên rất thân thiện.', 'Tuyệt vời! Sẽ quay lại lần sau.', 'Giường êm, phòng yên tĩnh, rất đáng tiền.'],
            4 => ['Phòng đẹp, vị trí thuận tiện. Bữa sáng hơi ít món.', 'Trải nghiệm tốt, check-in nhanh chóng.', null],
            3 => ['Phòng ổn so với giá, cách âm chưa tốt lắm.', 'Tạm được, wifi đôi lúc chập chờn.'],
            2 => ['Phòng hơi cũ, điều hoà kêu to.'],
        ];

        $ratings = [5, 5, 5, 4, 4, 4, 3, 2];

        Booking::query()
            ->whereIn('status', Review::REVIEWABLE_BOOKING_STATUSES)
            ->whereDoesntHave('review')
            ->whereNotNull('room_id')
            ->get()
            ->each(function (Booking $booking) use ($comments, $ratings) {
                if (random_int(1, 10) > 7) {
                    return;
                }

                $rating = $ratings[array_rand($ratings)];
                $options = $comments[$rating];

                Review::create([
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                    'room_id' => $booking->room_id,
                    'rating' => $rating,
                    'comment' => $options[array_rand($options)],
                    'created_at' => $booking->check_out_date?->copy()->addDay() ?? now(),
                    'updated_at' => now(),
                ]);
            });
    }
}
