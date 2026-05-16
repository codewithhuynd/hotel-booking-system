<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('booking_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('transaction_code')
                ->nullable();

            $table->decimal('deposit_amount', 10, 2);

            $table->enum('payment_method', [
                'cash',
                'banking',
                'momo',
                'vnpay'
            ]);

            $table->enum('status', [
                'unpaid',
                'pending',
                'paid',
                'expired',
                'refunded'
            ])->default('unpaid');

            $table->timestamp('paid_at')
                ->nullable();

            $table->string('proof_image')
                ->nullable();

            $table->timestamp('deposit_deadline')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
