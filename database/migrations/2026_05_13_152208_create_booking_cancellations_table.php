<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_cancellations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('cancelled_by_user_id')
                ->constrained('users')
                ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | CANCEL INFO
            |--------------------------------------------------------------------------
            */

            $table->text('reason')->nullable();

            $table->timestamp('cancelled_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | REFUND BANK INFO
            |--------------------------------------------------------------------------
            */

            $table->string('bank_name')->nullable();

            $table->string('bank_account_number')->nullable();

            $table->string('bank_account_name')->nullable();

            /*
            |--------------------------------------------------------------------------
            | REFUND INFO
            |--------------------------------------------------------------------------
            */

            $table->boolean('refund_completed')
                ->default(false);

            $table->timestamp('refund_completed_at')
                ->nullable();

            $table->string('refund_transaction_code')
                ->nullable();

            $table->string('refund_proof_image')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_cancellations');
    }
};