<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingCancellation;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $guest1 = User::where('email', 'guest1@gmail.com')->first();
        $guest2 = User::where('email', 'guest2@gmail.com')->first();

        $roomStandard = Room::where('room_code', 'A101')->first();
        $roomDeluxe = Room::where('room_code', 'B201')->first();
        $roomVip = Room::where('room_code', 'VIP301')->first();

        if (! $guest1 || ! $guest2 || ! $roomStandard || ! $roomDeluxe || ! $roomVip) {
            $this->command?->warn('Chạy UserSeeder và RoomSeeder trước khi seed bookings.');

            return;
        }

        $today = Carbon::today();
        $hasExtendedColumns = Schema::hasColumn('bookings', 'booking_code');

        $bookings = [
            [
                'code' => 'BK-2026-001',
                'user_id' => $guest1->id,
                'room' => $roomStandard,
                'check_in' => $today->copy()->addDays(3),
                'check_out' => $today->copy()->addDays(5),
                'guest_count' => 2,
                'contact_name' => $guest1->full_name,
                'contact_phone' => $guest1->phone ?? '0988888888',
                'contact_email' => $guest1->email,
                'status' => 'pending',
                'booked_at' => $today->copy()->setTime(9, 30),
                'note' => 'Đặt phòng qua web — chờ xác nhận.',
                'payment' => [
                    'status' => 'unpaid',
                    'payment_method' => 'banking',
                ],
            ],
            [
                'code' => 'BK-2026-002',
                'user_id' => $guest2->id,
                'room' => $roomDeluxe,
                'check_in' => $today->copy()->addDays(7),
                'check_out' => $today->copy()->addDays(10),
                'guest_count' => 3,
                'contact_name' => $guest2->full_name,
                'contact_phone' => $guest2->phone ?? '0977777777',
                'contact_email' => $guest2->email,
                'status' => 'awaiting_deposit',
                'booked_at' => $today->copy()->setTime(11, 0),
                'note' => 'Khách đã được duyệt, chờ cọc.',
                'payment' => [
                    'status' => 'pending',
                    'payment_method' => 'momo',
                ],
            ],
            [
                'code' => 'BK-2026-003',
                'user_id' => $guest1->id,
                'room' => $roomVip,
                'check_in' => $today->copy()->addDays(14),
                'check_out' => $today->copy()->addDays(17),
                'guest_count' => 4,
                'contact_name' => $guest1->full_name,
                'contact_phone' => $guest1->phone ?? '0988888888',
                'contact_email' => $guest1->email,
                'status' => 'confirmed',
                'booked_at' => $today->copy()->subDays(2)->setTime(14, 15),
                'note' => 'Đã xác nhận và thanh toán cọc.',
                'payment' => [
                    'status' => 'paid',
                    'payment_method' => 'vnpay',
                    'paid_at' => $today->copy()->subDays(2)->setTime(15, 0),
                ],
            ],
            [
                'code' => 'BK-2026-004',
                'user_id' => $guest2->id,
                'room' => $roomDeluxe,
                'check_in' => $today->copy()->subDay(),
                'check_out' => $today->copy()->addDays(2),
                'guest_count' => 2,
                'contact_name' => $guest2->full_name,
                'contact_phone' => $guest2->phone ?? '0977777777',
                'contact_email' => $guest2->email,
                'status' => 'checked_in',
                'booked_at' => $today->copy()->subDays(3)->setTime(10, 0),
                'note' => 'Khách đang lưu trú.',
                'room_status' => 'occupied',
                'payment' => [
                    'status' => 'paid',
                    'payment_method' => 'cash',
                    'paid_at' => $today->copy()->subDays(3)->setTime(11, 0),
                ],
            ],
            [
                'code' => 'BK-2026-005',
                'user_id' => $guest1->id,
                'room' => $roomStandard,
                'check_in' => $today->copy()->subDays(5),
                'check_out' => $today->copy()->subDays(2),
                'guest_count' => 2,
                'contact_name' => $guest1->full_name,
                'contact_phone' => $guest1->phone ?? '0988888888',
                'contact_email' => $guest1->email,
                'status' => 'checked_out',
                'booked_at' => $today->copy()->subDays(8)->setTime(8, 45),
                'note' => 'Đã trả phòng.',
                'payment' => [
                    'status' => 'paid',
                    'payment_method' => 'banking',
                    'paid_at' => $today->copy()->subDays(8)->setTime(9, 30),
                ],
            ],
            [
                'code' => 'BK-2026-006',
                'user_id' => $guest2->id,
                'room' => $roomStandard,
                'check_in' => $today->copy()->addDays(20),
                'check_out' => $today->copy()->addDays(22),
                'guest_count' => 1,
                'contact_name' => $guest2->full_name,
                'contact_phone' => $guest2->phone ?? '0977777777',
                'contact_email' => $guest2->email,
                'status' => 'cancelled',
                'booked_at' => $today->copy()->subDays(1)->setTime(16, 20),
                'note' => 'Khách hủy đặt phòng.',
                'payment' => [
                    'status' => 'refunded',
                    'payment_method' => 'banking',
                    'paid_at' => $today->copy()->subDays(1)->setTime(17, 0),
                ],
            ],
            [
                'code' => 'BK-2026-007',
                'user_id' => $guest1->id,
                'room' => $roomDeluxe,
                'check_in' => $today->copy()->addDays(1),
                'check_out' => $today->copy()->addDays(3),
                'guest_count' => 2,
                'contact_name' => $guest1->full_name,
                'contact_phone' => $guest1->phone ?? '0988888888',
                'contact_email' => $guest1->email,
                'status' => 'pending',
                'booked_at' => $today->copy()->setTime(15, 45),
                'note' => 'Booking tạo hôm nay — test thống kê.',
                'payment' => [
                    'status' => 'pending',
                    'payment_method' => 'banking',
                ],
            ],
        ];

        foreach ($bookings as $item) {
            $room = $item['room'];
            $nights = $item['check_in']->diffInDays($item['check_out']);
            $roomPrice = (float) $room->price;
            $totalPrice = $roomPrice * max($nights, 1);
            $depositAmount = round($totalPrice * 0.3, 2);

            $attributes = [
                'user_id' => $item['user_id'],
                'room_id' => $room->id,
                'check_in_date' => $item['check_in'],
                'check_out_date' => $item['check_out'],
                'guest_count' => $item['guest_count'],
                'contact_name' => $item['contact_name'],
                'contact_phone' => $item['contact_phone'],
                'note' => $item['note'],
                'status' => $item['status'],
                'booked_at' => $item['booked_at'],
            ];

            if ($hasExtendedColumns) {
                $attributes['booking_code'] = $item['code'];
                $attributes['contact_email'] = $item['contact_email'];
                $attributes['room_price'] = $roomPrice;
                $attributes['total_price'] = $totalPrice;
                $attributes['deposit_amount'] = $depositAmount;
            }

            $booking = Booking::create($attributes);

            if (isset($item['room_status'])) {
                $room->update(['status' => $item['room_status']]);
            }

            $paymentData = $item['payment'];
            $paymentAttributes = [
                'booking_id' => $booking->id,
                'deposit_amount' => $hasExtendedColumns ? $depositAmount : round($roomPrice * 0.3, 2),
                'payment_method' => $paymentData['payment_method'],
                'status' => $paymentData['status'],
                'paid_at' => $paymentData['paid_at'] ?? null,
                'deposit_deadline' => $item['booked_at']->copy()->addHours(24),
            ];

            if (Schema::hasColumn('payments', 'transaction_code') && $paymentData['status'] === 'paid') {
                $paymentAttributes['transaction_code'] = 'TXN-' . $item['code'];
            }

            Payment::create($paymentAttributes);
        }

        $rooms = Room::all();
        $statuses = ['pending', 'awaiting_deposit', 'confirmed', 'checked_in', 'checked_out', 'completed', 'cancelled'];

        for ($i = 0; $i < 33; $i++) {
            $status = $statuses[$i % count($statuses)];
            $room = $rooms[$i % $rooms->count()];
            $user = $i % 2 === 0 ? $guest1 : $guest2;
            $bookedAt = $today->copy()->subDays(175 - ($i * 5))->setTime(10 + ($i % 8), 0);

            // Booking chờ duyệt phải là booking mới đặt, nếu không sẽ bị tự huỷ
            // theo quy tắc hotel.pending_expire_hours.
            if ($status === 'pending') {
                $bookedAt = now()->subHours(2 + ($i % 10));
            }
            $slot = intdiv($i, count($statuses));

            $checkIn = match ($status) {
                'checked_in' => $today->copy()->subDay(),
                'checked_out', 'completed' => $today->copy()->subDays(3 + ($slot * 2)),
                'cancelled' => $today->copy()->addDays(($i % 2) ? 12 : 30 + $slot),
                default => $today->copy()->addDays(10 + ($slot * 3)),
            };
            $checkOut = $checkIn->copy()->addDays(2);
            $roomPrice = (float) $room->price;
            $totalPrice = $roomPrice * 2;
            $depositAmount = round($totalPrice * 0.3, 2);
            $paymentStatus = match ($status) {
                'pending' => 'unpaid',
                'awaiting_deposit' => 'pending',
                'cancelled' => $i % 2 === 0 ? 'refunded' : 'expired',
                default => 'paid',
            };

            $booking = Booking::create([
                'booking_code' => sprintf('BK-DEMO-%03d', $i + 8),
                'user_id' => $user->id,
                'room_id' => $room->id,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'guest_count' => min($room->capacity, 2),
                'contact_name' => $user->full_name,
                'contact_phone' => $user->phone ?? '0900000000',
                'contact_email' => $user->email,
                'room_price' => $roomPrice,
                'total_price' => $totalPrice,
                'deposit_amount' => $depositAmount,
                'note' => 'Dữ liệu minh họa cho dashboard.',
                'status' => $status,
                'booked_at' => $bookedAt,
            ]);

            Payment::create([
                'booking_id' => $booking->id,
                'type' => 'deposit',
                'transaction_code' => 'TXN-DEMO-'.sprintf('%03d', $i + 8),
                'deposit_amount' => $depositAmount,
                'payment_method' => 'banking',
                'status' => $paymentStatus,
                'paid_at' => in_array($paymentStatus, ['paid', 'refunded'], true) ? $bookedAt->copy()->addHours(2) : null,
                'deposit_deadline' => $bookedAt->copy()->addDay(),
            ]);

            if ($status === 'cancelled') {
                $refunded = $paymentStatus === 'refunded';

                BookingCancellation::create([
                    'booking_id' => $booking->id,
                    'cancelled_by_user_id' => $user->id,
                    'cancelled_by_type' => 'guest',
                    'reason' => 'Booking dữ liệu minh họa bị hủy.',
                    'cancelled_at' => $bookedAt->copy()->addHours(1),
                    'bank_name' => $refunded ? 'Ngân hàng mẫu' : null,
                    'bank_account_number' => $refunded ? '1234567890' : null,
                    'bank_account_name' => $refunded ? 'NGUYEN VAN A' : null,
                    'refund_info_submitted_at' => $refunded ? $bookedAt->copy()->addHours(1) : null,
                    'refund_completed' => $refunded,
                    'refund_completed_at' => $refunded ? $bookedAt->copy()->addHours(3) : null,
                    'refund_transaction_code' => $refunded ? 'REF-DEMO-'.sprintf('%03d', $i + 8) : null,
                ]);
            }
        }
    }
}
