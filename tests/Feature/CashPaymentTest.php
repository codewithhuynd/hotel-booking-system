<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CashPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_cash_payment_does_not_require_proof_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'guest',
        ]);

        $room = Room::create([
            'room_code' => 'R-001',
            'room_name' => 'Deluxe',
            'description' => 'Test room',
            'price' => 100,
            'capacity' => 2,
            'status' => 'available',
        ]);

        $booking = Booking::create([
            'booking_code' => 'BK-TEST',
            'user_id' => $user->id,
            'room_id' => $room->id,
            'check_in_date' => now()->addDay(),
            'check_out_date' => now()->addDays(2),
            'guest_count' => 1,
            'contact_name' => 'Guest',
            'contact_phone' => '0900000000',
            'contact_email' => 'guest@example.com',
            'room_price' => 100,
            'total_price' => 100,
            'deposit_amount' => 30,
            'note' => null,
            'status' => 'pending',
            'booked_at' => now(),
        ]);

        $paymentMethod = PaymentMethod::create([
            'name' => 'Cash',
            'type' => 'cash',
            'is_active' => true,
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'type' => 'deposit',
            'transaction_code' => 'DEP-TEST',
            'deposit_amount' => 30,
            'payment_method' => 'cash',
            'status' => 'unpaid',
            'deposit_deadline' => now()->addDay(),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('guest.payments.upload-proof', $payment), [
                'payment_method_id' => $paymentMethod->id,
            ]);

        $response->assertRedirect(route('guest.bookings.index'));
        $response->assertSessionHas('success');

        $payment->refresh();

        $this->assertNull($payment->proof_image);
        $this->assertSame('cash', $payment->payment_method);
        $this->assertSame('pending_cash', $payment->status);
    }

    public function test_non_cash_payment_still_requires_proof_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'guest',
        ]);

        $room = Room::create([
            'room_code' => 'R-002',
            'room_name' => 'Suite',
            'description' => 'Test room',
            'price' => 150,
            'capacity' => 2,
            'status' => 'available',
        ]);

        $booking = Booking::create([
            'booking_code' => 'BK-TEST-2',
            'user_id' => $user->id,
            'room_id' => $room->id,
            'check_in_date' => now()->addDay(),
            'check_out_date' => now()->addDays(2),
            'guest_count' => 1,
            'contact_name' => 'Guest',
            'contact_phone' => '0900000001',
            'contact_email' => 'guest2@example.com',
            'room_price' => 150,
            'total_price' => 150,
            'deposit_amount' => 45,
            'note' => null,
            'status' => 'pending',
            'booked_at' => now(),
        ]);

        $paymentMethod = PaymentMethod::create([
            'name' => 'Bank Transfer',
            'type' => 'banking',
            'is_active' => true,
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'type' => 'deposit',
            'transaction_code' => 'DEP-TEST-2',
            'deposit_amount' => 45,
            'payment_method' => 'banking',
            'status' => 'unpaid',
            'deposit_deadline' => now()->addDay(),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('guest.payments.upload-proof', $payment), [
                'payment_method_id' => $paymentMethod->id,
            ]);

        $response->assertSessionHasErrors('proof_image');
    }
}
