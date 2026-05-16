<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->string('booking_code')->unique();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('room_id')
                ->constrained()
                ->onDelete('cascade');

            $table->date('check_in_date');
            $table->date('check_out_date');

            $table->integer('guest_count');

            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email')->nullable();

            $table->decimal('room_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('deposit_amount', 10, 2);

            $table->text('note')->nullable();

            $table->enum('status', [
                'pending',
                'awaiting_deposit',
                'confirmed',
                'checked_in',
                'checked_out',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->timestamp('booked_at');

            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("
            ALTER TABLE bookings
            ADD CONSTRAINT check_dates
            CHECK (check_out_date > check_in_date)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};