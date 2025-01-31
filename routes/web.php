<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;


Route::get('/', function () {
    return view('welcome');
});
Route::post('/submit-booking', [BookingController::class, 'submitBooking'])->name('submit.booking');
Route::get('/payment/{booking}', [BookingController::class, 'showPayment'])->name('payment');
Route::post('/confirm-payment', [BookingController::class, 'confirmPayment'])->name('confirm.payment');
