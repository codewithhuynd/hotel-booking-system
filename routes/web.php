<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Host\HostRegisterController;
use App\Http\Controllers\Host\RoomController;
use App\Http\Controllers\Host\RoomImageController;
use App\Http\Controllers\Host\BookingController;
use App\Http\Controllers\Host\PaymentController;
use App\Http\Controllers\Guest\RoomController as GuestRoomController;
use App\Http\Controllers\Guest\BookingController as GuestBookingController;
use App\Http\Controllers\Guest\PaymentController as GuestPaymentController;
use App\Http\Controllers\Host\HotelSettingController;
use App\Http\Controllers\Host\AboutSectionController;
use App\Http\Controllers\Host\ServiceController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\Host\ContactMessageController as HostContactMessageController;
use App\Http\Controllers\Guest\ProfileController;
use App\Http\Controllers\Host\UserController;
use App\Http\Controllers\Host\PaymentMethodController;
use Illuminate\Support\Facades\Auth;                // ← giữ lại từ DN-fix-bug
use App\Http\Controllers\NotificationController;   // ← thêm từ notification

// ---------------------------------------------------------------------
// PUBLIC ROUTES
// ---------------------------------------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [GuestRoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [GuestRoomController::class, 'show'])->name('rooms.show');
Route::post('/contact-message', [ContactMessageController::class, 'store'])
    ->name('contact-messages.store');

// ---------------------------------------------------------------------
// AUTH ROUTES (guest)
// ---------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ---------------------------------------------------------------------
// EMAIL VERIFICATION ROUTES
// ---------------------------------------------------------------------
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    Auth::logout();
    return view('auth.email-verified');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Link xác thực mới đã được gửi!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Hủy tài khoản chưa xác thực
Route::delete('/email/verify/cancel', function (Request $request) {
    $user = $request->user();
    if (!$user->hasVerifiedEmail()) {
        $user->delete();
        Auth::logout();
        return redirect()->route('register')
            ->with('success', 'Tài khoản đã được hủy. Bạn có thể đăng ký lại bằng email này.');
    }
    return redirect()->route('home');
})->middleware('auth')->name('verification.cancel');

// ---------------------------------------------------------------------
// AUTH REQUIRED ROUTES (không bắt buộc verified)
// ---------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');

    // GUEST + VERIFIED
    Route::middleware(['guest.role', 'verified'])->group(function () {
        Route::get('/my-bookings', [GuestBookingController::class, 'index'])
            ->name('guest.bookings.index');
        Route::get('/rooms/{room}/book', [GuestBookingController::class, 'create'])
            ->name('guest.bookings.create');
        Route::post('/rooms/{room}/book', [GuestBookingController::class, 'store'])
            ->name('guest.bookings.store');
        Route::get('/my-bookings/{booking}/cancel', [GuestBookingController::class, 'showCancelForm'])
            ->name('guest.bookings.cancel-form');
        Route::post('/my-bookings/{booking}/cancel', [GuestBookingController::class, 'cancel'])
            ->name('guest.bookings.cancel');
        Route::post('/my-bookings/{booking}/refund-bank', [GuestBookingController::class, 'submitRefundBank'])
            ->name('guest.bookings.refund-bank');
        Route::get('/payments/{payment}', [GuestPaymentController::class, 'show'])
            ->name('guest.payments.show');
        Route::post('/payments/{payment}/upload-proof', [GuestPaymentController::class, 'uploadProof'])
            ->name('guest.payments.upload-proof');
        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');
        Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])
            ->name('profile.change-password');
    });

    // HOST + VERIFIED
    Route::middleware(['host', 'verified'])->prefix('host')->name('host.')->group(function () {
        Route::redirect('/', '/host/dashboard');
        Route::get('/dashboard', function () {
            return redirect()->route('host.bookings.index');
        })->name('dashboard');

        Route::get('/register-host', [HostRegisterController::class, 'create'])
            ->name('register-host.create');
        Route::post('/register-host', [HostRegisterController::class, 'store'])
            ->name('register-host.store');

        Route::resource('rooms', RoomController::class);
        Route::post('/rooms/{room}/images', [RoomImageController::class, 'store'])
            ->name('rooms.images.store');
        Route::delete('/room-images/{roomImage}', [RoomImageController::class, 'destroy'])
            ->name('rooms.images.destroy');
        Route::post('/room-images/{roomImage}/main', [RoomImageController::class, 'setMain'])
            ->name('rooms.images.main');

        Route::resource('bookings', BookingController::class)->only(['index', 'show']);
        Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])
            ->name('bookings.confirm');
        Route::post('/bookings/{booking}/check-in', [BookingController::class, 'checkIn'])
            ->name('bookings.check-in');
        Route::post('/bookings/{booking}/check-out', [BookingController::class, 'checkOut'])
            ->name('bookings.check-out');
        Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
            ->name('bookings.cancel');

        Route::resource('payments', PaymentController::class)->only(['index', 'show']);
        Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])
            ->name('payments.confirm');
        Route::post('/booking-cancellations/{cancellation}/refund', [BookingController::class, 'refund'])
            ->name('booking-cancellations.refund');

        Route::get('/hotel-settings', [HotelSettingController::class, 'index'])
            ->name('hotel-settings.index');
        Route::get('/hotel-settings/edit', [HotelSettingController::class, 'edit'])
            ->name('hotel-settings.edit');
        Route::put('/hotel-settings', [HotelSettingController::class, 'update'])
            ->name('hotel-settings.update');

        Route::resource('about-sections', AboutSectionController::class)->except(['show']);
        Route::resource('services', ServiceController::class)->except(['show']);

        Route::resource('contact-messages', HostContactMessageController::class)
            ->only(['index', 'show', 'destroy']);
        Route::post('/contact-messages/{contactMessage}/reply', [HostContactMessageController::class, 'reply'])
            ->name('contact-messages.reply');

        Route::resource('users', UserController::class)
            ->only(['index', 'show', 'edit', 'update', 'destroy']);
        Route::resource('payment-methods', PaymentMethodController::class)->except(['show']);
    });
});