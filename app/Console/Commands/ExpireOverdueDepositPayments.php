<?php

namespace App\Console\Commands;

use App\Services\DepositPaymentService;
use Illuminate\Console\Command;

class ExpireOverdueDepositPayments extends Command
{
    protected $signature = 'payments:expire-deposits';

    protected $description = 'Cancel bookings with overdue deposit payments';

    public function handle(DepositPaymentService $service): int
    {
        $count = $service->expireOverduePayments();

        $this->info("Processed {$count} overdue deposit payment(s).");

        return self::SUCCESS;
    }
}
