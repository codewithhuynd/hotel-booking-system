<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotel_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('hotel_settings', 'deposit_percent')) {
                $table->unsignedTinyInteger('deposit_percent')->default(30)->after('hero_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('hotel_settings', function (Blueprint $table) {
            if (Schema::hasColumn('hotel_settings', 'deposit_percent')) {
                $table->dropColumn('deposit_percent');
            }
        });
    }
};
