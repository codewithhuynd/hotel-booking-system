<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Host\HostRegisterController;
use App\Http\Controllers\Host\RoomController;
use App\Http\Controllers\Host\RoomImageController;
use App\Http\Controllers\Host\BookingController;
use App\Http\Controllers\Host\PaymentController;

/*
|--------------------------------------------------------------------------
| TRANG CHỦ (công khai + đã đăng nhập: có nút đăng xuất)
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');

/*
|--------------------------------------------------------------------------
| GUEST — đăng ký khách, đăng nhập
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| ĐÃ ĐĂNG NHẬP
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('home');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('host')
        ->prefix('host')
        ->name('host.')
        ->group(function () {

            /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

            Route::redirect('/', '/host/dashboard');

            Route::get('/dashboard', function () {
                return view('host.dashboard');
            })->name('dashboard');

            /*
        |--------------------------------------------------------------------------
        | CREATE HOST ACCOUNT
        |--------------------------------------------------------------------------
        */

            Route::get('/register-host', [HostRegisterController::class, 'create'])
                ->name('register-host.create');

            Route::post('/register-host', [HostRegisterController::class, 'store'])
                ->name('register-host.store');

            /*
        |--------------------------------------------------------------------------
        | ROOM MANAGEMENT
        |--------------------------------------------------------------------------
        */

            Route::resource('rooms', RoomController::class);

            /*
        |--------------------------------------------------------------------------
        | ROOM IMAGES
        |--------------------------------------------------------------------------
        */

            Route::post(
                '/rooms/{room}/images',
                [RoomImageController::class, 'store']
            )->name('rooms.images.store');

            Route::delete(
                '/room-images/{roomImage}',
                [RoomImageController::class, 'destroy']
            )->name('rooms.images.destroy');

            Route::post(
                '/room-images/{roomImage}/main',
                [RoomImageController::class, 'setMain']
            )->name('rooms.images.main');
            /*
/*
|--------------------------------------------------------------------------
| BOOKING MANAGEMENT
|--------------------------------------------------------------------------
*/

            Route::resource('bookings', BookingController::class)
                ->only([
                    'index',
                    'show'
                ]);

            Route::post(
                '/bookings/{booking}/confirm',
                [BookingController::class, 'confirm']
            )->name('bookings.confirm');

            Route::post(
                '/bookings/{booking}/check-in',
                [BookingController::class, 'checkIn']
            )->name('bookings.check-in');

            Route::post(
                '/bookings/{booking}/check-out',
                [BookingController::class, 'checkOut']
            )->name('bookings.check-out');

            Route::post(
                '/bookings/{booking}/cancel',
                [BookingController::class, 'cancel']
            )->name('bookings.cancel');

            /*
|--------------------------------------------------------------------------
| PAYMENT MANAGEMENT
|--------------------------------------------------------------------------
*/

            Route::resource('payments', PaymentController::class)
                ->only([
                    'index',
                    'show',
                ]);

            Route::post(
                '/payments/{payment}/confirm',
                [PaymentController::class, 'confirm']
            )->name('payments.confirm');
        });
});
