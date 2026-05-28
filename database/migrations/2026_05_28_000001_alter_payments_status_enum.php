<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('unpaid', 'pending', 'pending_cash', 'cash_on_arrival', 'paid', 'expired', 'refunded') NOT NULL DEFAULT 'unpaid'");
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('unpaid', 'pending', 'paid', 'expired', 'refunded') NOT NULL DEFAULT 'unpaid'");
    }
};
