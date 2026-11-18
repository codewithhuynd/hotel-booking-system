<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\BookingCancellation;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookingCancelRefundTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_submits_bank_details_and_host_completes_refund(): void
    {
        Storage::fake('public');
        $guest = User::factory()->create(['role' => 'guest']);
        $host = User::factory()->create(['role' => 'host']);
        $booking = Booking::factory()->create(['user_id' => $guest->id, 'status' => 'confirmed']);
        $payment = Payment::factory()->create(['booking_id' => $booking->id, 'status' => 'paid']);

        $this->actingAs($guest)->post(route('guest.bookings.cancel', $booking), [
            'reason' => 'Thay đổi kế hoạch cá nhân',
            'bank_name' => 'Ngân hàng mẫu',
            'bank_account_number' => '1234567890',
            'bank_account_name' => 'NGUYEN VAN A',
        ])->assertRedirect(route('guest.bookings.index'));

        $cancellation = BookingCancellation::firstOrFail();
        $this->assertFalse($cancellation->refund_completed);
        $this->assertSame('cancelled', $booking->fresh()->status);

        $this->actingAs($host)->post(route('host.booking-cancellations.refund', $cancellation), [
            'refund_transaction_code' => 'REF-12345',
            'refund_proof_image' => UploadedFile::fake()->image('refund.png'),
        ])->assertRedirect();

        $this->assertTrue($cancellation->fresh()->refund_completed);
        $this->assertSame('refunded', $payment->fresh()->status);
    }
}
