<?php

namespace App\Console\Commands;

use App\Services\BookingExpiryService;
use Illuminate\Console\Command;

class ExpireStaleBookings extends Command
{
    protected $signature = 'bookings:expire';

    protected $description = 'Tự huỷ booking pending quá hạn xác nhận và booking no-show';

    public function handle(BookingExpiryService $service): int
    {
        $result = $service->run();

        $this->info("Đã huỷ {$result['pending']} booking pending quá hạn và {$result['no_show']} booking no-show.");

        return self::SUCCESS;
    }
}
