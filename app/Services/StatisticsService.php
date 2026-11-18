<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Carbon\Carbon;

class StatisticsService
{
    public function forPeriod(Carbon $start, Carbon $end): array
    {
        $periodStart = $start->copy()->startOfDay();
        $periodEnd = $end->copy()->endOfDay();
        $exclusiveEnd = $periodEnd->copy()->startOfDay()->addDay();
        $monthlyRevenue = [];
        $cursor = $periodStart->copy()->startOfMonth();

        while ($cursor->lte($periodEnd)) {
            $monthlyRevenue[$cursor->format('Y-m')] = 0.0;
            $cursor->addMonth();
        }

        $payments = Payment::query()
            ->where('status', 'paid')
            ->whereBetween('paid_at', [$periodStart, $periodEnd])
            ->get(['deposit_amount', 'paid_at']);

        foreach ($payments as $payment) {
            $key = Carbon::parse($payment->paid_at)->format('Y-m');
            $monthlyRevenue[$key] += (float) $payment->deposit_amount;
        }

        $bookings = Booking::query()
            ->whereBetween('booked_at', [$periodStart, $periodEnd]);
        $periodBookings = (clone $bookings)->with('room')->get();
        $occupancyBookings = Booking::query()
            ->overlapping($periodStart->toDateString(), $exclusiveEnd->toDateString())
            ->with('room')
            ->get();

        $daysInPeriod = $periodStart->diffInDays($exclusiveEnd);
        $roomCount = Room::query()->count();
        $bookedNights = 0;

        foreach ($occupancyBookings as $booking) {
            $checkIn = Carbon::parse($booking->check_in_date)->max($periodStart);
            $checkOut = Carbon::parse($booking->check_out_date)->min($exclusiveEnd);
            $bookedNights += max(0, $checkIn->diffInDays($checkOut));
        }

        $topRooms = $periodBookings->groupBy('room_id')
            ->map(fn ($items) => ['room' => $items->first()->room, 'count' => $items->count()])
            ->sortByDesc('count')
            ->take(5)
            ->values();

        $statusCounts = (clone $bookings)->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return [
            'totalRevenue' => array_sum($monthlyRevenue),
            'bookingCount' => (clone $bookings)->count(),
            'cancelledCount' => (clone $bookings)->where('status', 'cancelled')->count(),
            'refundTotal' => (float) Payment::query()
                ->where('payments.status', 'refunded')
                ->whereHas('booking.cancellation', fn ($query) => $query
                    ->where('refund_completed', true)
                    ->whereBetween('refund_completed_at', [$periodStart, $periodEnd]))
                ->sum('payments.deposit_amount'),
            'monthlyRevenue' => $monthlyRevenue,
            'statusCounts' => $statusCounts,
            'occupancyRate' => $roomCount && $daysInPeriod
                ? round($bookedNights / ($roomCount * $daysInPeriod) * 100, 2)
                : 0,
            'topRooms' => $topRooms,
        ];
    }
}
