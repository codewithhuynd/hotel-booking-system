<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            $table->string('room_code')->unique();
            $table->string('room_name');

            $table->text('description')->nullable();

            $table->decimal('price', 10, 2);

            $table->integer('capacity');

            $table->enum('status', [
                'available',
                'booked',
                'occupied',
                'cleaning'
            ])->default('available');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};