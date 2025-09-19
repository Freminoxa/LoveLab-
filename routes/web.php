<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\EventController;
use App\Models\Event;

// ==============================================
// PUBLIC ROUTES
// ==============================================

// Homepage
Route::get('/', function () {
    $events = Event::where('status', 'published')->get();
    return view('welcome', compact('events'));
});

Route::get('/about', function () {
    return view('about');
});

// Booking Routes
Route::post('/submit-booking', [BookingController::class, 'submitBooking'])->name('submit.booking');
Route::get('/payment/{booking}', [BookingController::class, 'showPayment'])->name('payment');
Route::post('/confirm-payment', [BookingController::class, 'confirmPayment'])->name('confirm.payment');

// ==============================================
// ADMIN ROUTES
// ==============================================

Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('authenticate');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    
    // Dashboard & Bookings
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{booking}', [AdminController::class, 'showBooking'])->name('booking.show');
    Route::patch('/bookings/{booking}/payment-status', [AdminController::class, 'updatePaymentStatus'])->name('booking.update-payment');
    
    // Event Management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
        Route::get('/{event}/pdf', [EventController::class, 'pdf'])->name('pdf');
    });
    
    // Manager Management
    Route::prefix('managers')->name('managers.')->group(function () {
        Route::get('/create', [ManagerController::class, 'create'])->name('create');
        Route::post('/', [ManagerController::class, 'store'])->name('store');
    });
});

// ==============================================
// MANAGER ROUTES
// ==============================================

Route::prefix('manager')->name('manager.')->group(function () {
    // Login Routes (Public)
    Route::get('/login', [ManagerController::class, 'showLogin'])->name('login');
    Route::post('/login', [ManagerController::class, 'login'])->name('authenticate');
    
    // Protected Manager Routes
    Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
    Route::get('/events/{event}/bookings', [ManagerController::class, 'eventBookings'])->name('event.bookings');
    Route::post('/bookings/{booking}/confirm', [ManagerController::class, 'confirmBooking'])->name('booking.confirm');
    Route::post('/bookings/{booking}/reject', [ManagerController::class, 'rejectBooking'])->name('booking.reject');
    Route::post('/logout', [ManagerController::class, 'logout'])->name('logout');
});