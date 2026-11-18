<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HostProfileFilterReviewTest extends TestCase
{
    use RefreshDatabase;

    /* ---------------- 1. Hồ sơ host ---------------- */

    public function test_host_can_open_profile_page(): void
    {
        $host = User::factory()->create(['role' => 'host']);

        $this->actingAs($host)
            ->get(route('profile.edit'))
            ->assertOk()
            ->assertViewIs('host.profile.edit')
            ->assertSee($host->email);
    }

    public function test_guest_still_gets_guest_profile_page(): void
    {
        $guest = User::factory()->create(['role' => 'guest']);

        $this->actingAs($guest)
            ->get(route('profile.edit'))
            ->assertOk()
            ->assertViewIs('guest.profile.edit');
    }

    public function test_host_can_update_profile(): void
    {
        $host = User::factory()->create(['role' => 'host']);

        $this->actingAs($host)
            ->post(route('profile.update'), [
                'full_name' => 'Chủ Khách Sạn',
                'phone' => '0901234567',
            ])
            ->assertSessionHas('success');

        $this->assertSame('Chủ Khách Sạn', $host->fresh()->full_name);
        $this->assertSame('0901234567', $host->fresh()->phone);
    }

    public function test_host_password_change_requires_correct_current_password(): void
    {
        $host = User::factory()->create(['role' => 'host']);

        $this->actingAs($host)
            ->post(route('profile.change-password'), [
                'current_password' => 'sai-mat-khau',
                'new_password' => 'matkhau123',
                'new_password_confirmation' => 'matkhau123',
            ])
            ->assertSessionHasErrors('current_password');
    }

    /* ---------------- 2. Tìm kiếm, lọc, phân trang ---------------- */

    public function test_host_can_search_and_filter_bookings(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $match = Booking::factory()->create(['booking_code' => 'BK-TIMTHAY1', 'status' => 'pending']);
        $other = Booking::factory()->create(['booking_code' => 'BK-KHAC0002', 'status' => 'pending']);
        $cancelled = Booking::factory()->create(['booking_code' => 'BK-TIMTHAY2', 'status' => 'cancelled']);

        $this->actingAs($host)
            ->get(route('host.bookings.index', ['q' => 'TIMTHAY', 'status' => 'pending']))
            ->assertOk()
            ->assertSee($match->booking_code)
            ->assertDontSee($other->booking_code)
            ->assertDontSee($cancelled->booking_code);
    }

    public function test_host_can_filter_bookings_by_check_in_date(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $early = Booking::factory()->create(['check_in_date' => '2030-01-05', 'check_out_date' => '2030-01-06']);
        $late = Booking::factory()->create(['check_in_date' => '2030-03-05', 'check_out_date' => '2030-03-06']);

        $this->actingAs($host)
            ->get(route('host.bookings.index', ['from' => '2030-01-01', 'to' => '2030-01-31']))
            ->assertOk()
            ->assertSee($early->booking_code)
            ->assertDontSee($late->booking_code);
    }

    public function test_bookings_list_is_paginated(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        Booking::factory()->count(16)->create();

        $response = $this->actingAs($host)->get(route('host.bookings.index'));

        $response->assertOk();
        $this->assertSame(15, $response->viewData('bookings')->count());
        $this->assertSame(16, $response->viewData('bookings')->total());
    }

    public function test_host_can_filter_payments_by_type_and_status(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        // Danh sách thanh toán hiển thị mã booking, nên kiểm tra theo mã booking.
        $paidDeposit = Payment::factory()->create(['status' => 'paid']);
        $unpaidDeposit = Payment::factory()->create(['status' => 'unpaid']);

        $this->actingAs($host)
            ->get(route('host.payments.index', ['type' => 'deposit', 'status' => 'paid']))
            ->assertOk()
            ->assertSee($paidDeposit->booking->booking_code)
            ->assertDontSee($unpaidDeposit->booking->booking_code);
    }

    public function test_host_can_search_users(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $match = User::factory()->create(['role' => 'guest', 'email' => 'nguyen.timthay@example.com']);
        $other = User::factory()->create(['role' => 'guest', 'email' => 'khac@example.com']);

        $this->actingAs($host)
            ->get(route('host.users.index', ['q' => 'timthay']))
            ->assertOk()
            ->assertSee($match->email)
            ->assertDontSee($other->email);
    }

    public function test_invalid_filter_value_is_rejected(): void
    {
        $host = User::factory()->create(['role' => 'host']);

        $this->actingAs($host)
            ->get(route('host.bookings.index', ['status' => 'khong-hop-le']))
            ->assertSessionHasErrors('status');
    }

    /* ---------------- 3. Đánh giá phòng ---------------- */

    public function test_guest_can_review_checked_out_booking(): void
    {
        $booking = Booking::factory()->create(['status' => 'checked_out']);

        $this->actingAs($booking->user)
            ->post(route('guest.bookings.review', $booking), ['rating' => 5, 'comment' => 'Phòng rất đẹp'])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('reviews', [
            'booking_id' => $booking->id,
            'room_id' => $booking->room_id,
            'user_id' => $booking->user_id,
            'rating' => 5,
            'comment' => 'Phòng rất đẹp',
        ]);
    }

    public function test_reviewing_again_updates_existing_review(): void
    {
        $booking = Booking::factory()->create(['status' => 'completed']);

        $this->actingAs($booking->user)->post(route('guest.bookings.review', $booking), ['rating' => 3]);
        $this->actingAs($booking->user)->post(route('guest.bookings.review', $booking), ['rating' => 4, 'comment' => 'Đổi ý']);

        $this->assertSame(1, Review::count());
        $this->assertSame(4, Review::first()->rating);
    }

    public function test_guest_cannot_review_booking_before_checkout(): void
    {
        $booking = Booking::factory()->create(['status' => 'confirmed']);

        $this->actingAs($booking->user)
            ->post(route('guest.bookings.review', $booking), ['rating' => 5])
            ->assertSessionHas('error');

        $this->assertSame(0, Review::count());
    }

    public function test_guest_cannot_review_someone_elses_booking(): void
    {
        $booking = Booking::factory()->create(['status' => 'checked_out']);
        $stranger = User::factory()->create(['role' => 'guest']);

        $this->actingAs($stranger)
            ->post(route('guest.bookings.review', $booking), ['rating' => 1])
            ->assertForbidden();
    }

    public function test_rating_must_be_between_one_and_five(): void
    {
        $booking = Booking::factory()->create(['status' => 'checked_out']);

        $this->actingAs($booking->user)
            ->post(route('guest.bookings.review', $booking), ['rating' => 6])
            ->assertSessionHasErrors('rating');
    }

    public function test_room_page_shows_visible_reviews_and_average(): void
    {
        $room = Room::factory()->create();
        $visible = Booking::factory()->create(['room_id' => $room->id, 'status' => 'completed']);
        $hidden = Booking::factory()->create(['room_id' => $room->id, 'status' => 'completed']);

        Review::create(['booking_id' => $visible->id, 'user_id' => $visible->user_id, 'room_id' => $room->id, 'rating' => 4, 'comment' => 'Nhận xét hiển thị']);
        Review::create(['booking_id' => $hidden->id, 'user_id' => $hidden->user_id, 'room_id' => $room->id, 'rating' => 1, 'comment' => 'Nhận xét bị ẩn', 'is_hidden' => true]);

        $this->get(route('rooms.show', $room))
            ->assertOk()
            ->assertSee('Nhận xét hiển thị')
            ->assertDontSee('Nhận xét bị ẩn')
            ->assertSee('4.0');
    }

    public function test_host_can_hide_and_unhide_review(): void
    {
        $host = User::factory()->create(['role' => 'host']);
        $booking = Booking::factory()->create(['status' => 'completed']);
        $review = Review::create(['booking_id' => $booking->id, 'user_id' => $booking->user_id, 'room_id' => $booking->room_id, 'rating' => 2]);

        $this->actingAs($host)->post(route('host.reviews.toggle', $review))->assertSessionHas('success');
        $this->assertTrue($review->fresh()->is_hidden);

        $this->actingAs($host)->post(route('host.reviews.toggle', $review));
        $this->assertFalse($review->fresh()->is_hidden);

        $this->actingAs($host)->get(route('host.reviews.index'))->assertOk()->assertSee($booking->booking_code);
    }

    public function test_guest_cannot_access_host_review_management(): void
    {
        $guest = User::factory()->create(['role' => 'guest']);

        $this->actingAs($guest)->get(route('host.reviews.index'))->assertForbidden();
    }

    public function test_guest_pages_show_review_form_only_after_checkout(): void
    {
        $done = Booking::factory()->create(['status' => 'checked_out']);
        $upcoming = Booking::factory()->create(['user_id' => $done->user_id, 'status' => 'confirmed']);

        $this->actingAs($done->user)
            ->get(route('guest.bookings.show', $done))
            ->assertOk()
            ->assertSee('action="'.route('guest.bookings.review', $done).'"', false);

        $this->actingAs($done->user)
            ->get(route('guest.bookings.show', $upcoming))
            ->assertOk()
            ->assertDontSee('action="'.route('guest.bookings.review', $upcoming).'"', false);

        $this->actingAs($done->user)
            ->get(route('guest.bookings.index'))
            ->assertOk()
            ->assertSee('Đánh giá kỳ nghỉ');
    }
}
