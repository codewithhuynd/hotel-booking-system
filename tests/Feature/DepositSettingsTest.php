<?php

namespace Tests\Feature;

use App\Models\HotelSetting;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DepositSettingsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('hotel_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('deposit_percent')->default(30);
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('hotel_settings');

        parent::tearDown();
    }

    public function test_get_setting_returns_configured_deposit_percent(): void
    {
        HotelSetting::create([
            'deposit_percent' => 25,
        ]);

        $this->assertSame(25.0, getSetting('deposit_percent'));
    }

    public function test_deposit_and_remaining_amount_are_calculated_from_configured_percent(): void
    {
        HotelSetting::create([
            'deposit_percent' => 40,
        ]);

        $totalPrice = 1000;
        $depositPercent = (float) getSetting('deposit_percent', 30);
        $depositAmount = $totalPrice * $depositPercent / 100;
        $remainingAmount = $totalPrice - $depositAmount;

        $this->assertSame(400.0, $depositAmount);
        $this->assertSame(600.0, $remainingAmount);
    }
}
