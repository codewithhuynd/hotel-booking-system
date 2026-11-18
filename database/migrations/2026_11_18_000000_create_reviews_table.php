<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Mỗi booking chỉ được đánh giá một lần.
            $table->foreignId('booking_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();

            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();

            // Host có thể ẩn đánh giá không phù hợp.
            $table->boolean('is_hidden')->default(false);

            $table->timestamps();

            $table->index(['room_id', 'is_hidden']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
