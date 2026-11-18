<?php

namespace App\Http\Controllers\Host;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request, StatisticsService $statistics)
    {
        $validated = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ], [
            'date_to.after_or_equal' => 'Ngày kết thúc phải bằng hoặc sau ngày bắt đầu.',
        ]);

        $end = Carbon::parse($validated['date_to'] ?? today())->endOfDay();
        $start = Carbon::parse($validated['date_from'] ?? $end->copy()->subMonths(5)->startOfMonth())->startOfDay();
        $stats = $statistics->forPeriod($start, $end);

        return view('host.dashboard', [
            'stats' => $stats,
            'dateFrom' => $start->toDateString(),
            'dateTo' => $end->toDateString(),
        ]);
    }
}
