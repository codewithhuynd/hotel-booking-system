<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Payment> */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'type' => 'deposit',
            'transaction_code' => 'DEP-'.strtoupper(fake()->unique()->bothify('########')),
            'deposit_amount' => 300000,
            'payment_method' => 'banking',
            'status' => 'unpaid',
            'deposit_deadline' => now()->addDay(),
        ];
    }
}
