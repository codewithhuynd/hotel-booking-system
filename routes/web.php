<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| HOST CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Host\HostRegisterController;
use App\Http\Controllers\Host\RoomController;
use App\Http\Controllers\Host\RoomImageController;
use App\Http\Controllers\Host\BookingController;
use App\Http\Controllers\Host\PaymentController;


/*
|--------------------------------------------------------------------------
| GUEST CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Guest\RoomController as GuestRoomController;
use App\Http\Controllers\Guest\BookingController as GuestBookingController;
use App\Http\Controllers\Guest\PaymentController as GuestPaymentController;

/*
|--------------------------------------------------------------------------
| HOME PAGE
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    [HomeController::class, 'index']
)->name('home');

/*
|--------------------------------------------------------------------------
| PUBLIC ROOM PAGES
|--------------------------------------------------------------------------
*/

Route::get(
    '/rooms',
    [GuestRoomController::class, 'index']
)->name('rooms.index');

Route::get(
    '/rooms/{room}',
    [GuestRoomController::class, 'show']
)->name('rooms.show');

/*
|--------------------------------------------------------------------------
| GUEST AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get(
        '/register',
        [AuthController::class, 'showRegister']
    )->name('register');

    Route::post(
        '/register',
        [AuthController::class, 'register']
    );

    Route::get(
        '/login',
        [AuthController::class, 'showLogin']
    )->name('login');

    Route::post(
        '/login',
        [AuthController::class, 'login']
    );
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USERS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    )->name('logout');

    /*
    |--------------------------------------------------------------------------
    | GUEST BOOKINGS
    |--------------------------------------------------------------------------
    */

    Route::middleware('guest.role')->group(function () {

        /*
    |--------------------------------------------------------------------------
    | MY BOOKINGS
    |--------------------------------------------------------------------------
    */

        Route::get(
            '/my-bookings',
            [GuestBookingController::class, 'index']
        )->name('guest.bookings.index');

        /*
    |--------------------------------------------------------------------------
    | CREATE BOOKING
    |--------------------------------------------------------------------------
    */

        Route::get(
            '/rooms/{room}/book',
            [GuestBookingController::class, 'create']
        )->name('guest.bookings.create');

        Route::post(
            '/rooms/{room}/book',
            [GuestBookingController::class, 'store']
        )->name('guest.bookings.store');

        /*
/*
|--------------------------------------------------------------------------
| PAYMENT
|--------------------------------------------------------------------------
*/

        Route::get(
            '/payments/{payment}',
            [GuestPaymentController::class, 'show']
        )->name('guest.payments.show');

        Route::post(
            '/payments/{payment}/upload-proof',
            [GuestPaymentController::class, 'uploadProof']
        )->name('guest.payments.upload-proof');
    });

    /*
    |--------------------------------------------------------------------------
    | HOST PANEL
    |--------------------------------------------------------------------------
    */

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

            Route::get(
                '/dashboard',
                function () {
                    return view('host.dashboard');
                }
            )->name('dashboard');

            /*
            |--------------------------------------------------------------------------
            | CREATE HOST ACCOUNT
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/register-host',
                [HostRegisterController::class, 'create']
            )->name('register-host.create');

            Route::post(
                '/register-host',
                [HostRegisterController::class, 'store']
            )->name('register-host.store');

            /*
            |--------------------------------------------------------------------------
            | ROOM MANAGEMENT
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'rooms',
                RoomController::class
            );

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
            |--------------------------------------------------------------------------
            | BOOKING MANAGEMENT
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'bookings',
                BookingController::class
            )->only([
                'index',
                'show',
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

            Route::resource(
                'payments',
                PaymentController::class
            )->only([
                'index',
                'show',
            ]);

            Route::post(
                '/payments/{payment}/confirm',
                [PaymentController::class, 'confirm']
            )->name('payments.confirm');
        });
});
