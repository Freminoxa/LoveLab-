// Manager Panel Routes
Route::prefix('manager')->name('manager.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\ManagerController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\ManagerController::class, 'authenticate'])->name('authenticate');
    Route::get('/dashboard', [\App\Http\Controllers\ManagerController::class, 'dashboard'])->name('dashboard');
    Route::get('/event-bookings', [\App\Http\Controllers\ManagerController::class, 'eventBookings'])->name('event-bookings');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

use App\Models\Event;
Route::get('/', function () {
    $events = Event::all();
    return view('welcome', compact('events'));
});
Route::post('/submit-booking', [BookingController::class, 'submitBooking'])->name('submit.booking');
Route::get('/payment/{booking}', [BookingController::class, 'showPayment'])->name('payment');
Route::post('/confirm-payment', [BookingController::class, 'confirmPayment'])->name('confirm.payment');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::get('/bookings/{booking}', [AdminController::class, 'showBooking'])->name('admin.booking.show');
    Route::patch('/bookings/{booking}/payment-status', [AdminController::class, 'updatePaymentStatus'])->name('admin.booking.update-payment');
});

// Event Management Routes
Route::prefix('admin/events')->name('admin.events.')->group(function () {
    Route::get('/', [\App\Http\Controllers\EventController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\EventController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\EventController::class, 'store'])->name('store');
    Route::get('/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('show');
    Route::get('/{event}/edit', [\App\Http\Controllers\EventController::class, 'edit'])->name('edit');
    Route::put('/{event}', [\App\Http\Controllers\EventController::class, 'update'])->name('update');
    Route::delete('/{event}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('destroy');
    // PDF route placeholder
    Route::get('/{event}/pdf', [\App\Http\Controllers\EventController::class, 'pdf'])->name('pdf');
});

// Manager Management Routes
Route::prefix('admin/managers')->name('admin.managers.')->group(function () {
    Route::get('/create', [\App\Http\Controllers\ManagerController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\ManagerController::class, 'store'])->name('store');
});
