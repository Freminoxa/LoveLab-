<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketVerificationController;
use App\Http\Controllers\SitemapController;
use App\Models\Event;

// ==============================================
// PUBLIC ROUTES
// ==============================================

// Homepage
Route::get('/', function () {
    $upcomingEvents = Event::where('status', 'published')
        ->where('date', '>=', now())
        ->with(['packages'])
        ->orderBy('date', 'asc')
        ->get();
    
    $pastEvents = Event::where('status', 'published')
        ->where('date', '<', now())
        ->with(['packages', 'bookings'])
        ->orderBy('date', 'desc')
        ->limit(6)
        ->get();
    
    // For backward compatibility, keep $events as upcoming events
    $events = $upcomingEvents;
    
    return view('welcome', compact('events', 'upcomingEvents', 'pastEvents'));
});

Route::get('/about', function () {
    return view('about');
})->name('about');

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Booking Routes
Route::post('/submit-booking', [BookingController::class, 'submitBooking'])->name('submit.booking');
Route::get('/payment', [BookingController::class, 'showPayment'])->name('payment');
Route::post('/confirm-payment', [BookingController::class, 'confirmPayment'])->name('confirm.payment');

// ==============================================
// EVENT-SPECIFIC ROUTES (NEW)
// ==============================================

// Event page by slug - domain/event-title
Route::get('/{slug}', function ($slug) {
    // Convert slug back to event name and search
    $eventName = str_replace('-', ' ', $slug);

    $event = Event::where('status', 'published')
        ->with(['packages'])
        ->where(function ($query) use ($eventName, $slug) {
            $query->where('name', 'LIKE', "%{$eventName}%")
                ->orWhere('name', 'LIKE', "%{$slug}%");
        })
        ->first();

    if (!$event) {
        abort(404, 'Event not found');
    }

    return view('event-page', compact('event'));
})->where('slug', '^(?!admin|manager|api).*$'); 
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
        Route::get('/{event}/revenue', [EventController::class, 'revenue'])->name('revenue');
        Route::get('/{event}/export', [EventController::class, 'exportBookings'])->name('export');
    });

    // Manager Management
    Route::prefix('managers')->name('managers.')->group(function () {
        Route::get('/create', [ManagerController::class, 'create'])->name('create');
        Route::post('/', [ManagerController::class, 'store'])->name('store');
    });

    // CSV Export Routes
    Route::get('/export/bookings/{event}', [EventController::class, 'exportBookings'])->name('bookings.export');
});

// ==============================================
// MANAGER ROUTES
// ==============================================

Route::prefix('manager')->name('manager.')->group(function () {
    // Login Routes (Public)
    Route::get('/login', [ManagerController::class, 'showLogin'])->name('login');
    Route::post('/login', [ManagerController::class, 'login'])->name('authenticate');

    // Password Change Routes (for first-time login)
    Route::get('/change-password', [ManagerController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [ManagerController::class, 'changePassword'])->name('update-password');

    // Protected Manager Routes (middleware check is handled in controller)
    Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
    Route::get('/events/{event}/bookings', [ManagerController::class, 'eventBookings'])->name('event.bookings');
    Route::get('/events/{event}/bookings/export', [ManagerController::class, 'exportBookings'])->name('export.bookings');
    Route::post('/bookings/{booking}/confirm', [ManagerController::class, 'confirmBooking'])->name('booking.confirm');
    Route::post('/bookings/{booking}/reject', [ManagerController::class, 'rejectBooking'])->name('booking.reject');
    Route::post('/bookings/{booking}/attend', [ManagerController::class, 'confirmAttendance'])->name('booking.attend');
    Route::post('/bookings/{booking}/attendance', [ManagerController::class, 'confirmAttendance'])->name('booking.attendance');
    Route::post('/confirm-attendance/{booking}', [ManagerController::class, 'confirmAttendance'])->name('confirm-attendance');
    Route::post('/logout', [ManagerController::class, 'logout'])->name('logout');

    // Ticket Verification Routes
    Route::get('/events/{event}/scanner', [TicketVerificationController::class, 'scannerPage'])->name('scanner');
    Route::post('/verify-ticket', [TicketVerificationController::class, 'verifyTicket'])->name('verify.ticket');
    Route::post('/manual-verification', [TicketVerificationController::class, 'manualVerification'])->name('manual.verification');
    Route::get('/search-booking', [TicketVerificationController::class, 'searchBooking'])->name('search.booking');
    Route::get('/verification-stats/{event}', [TicketVerificationController::class, 'getStats'])->name('verification.stats');
});
// ==============================================
// API ROUTES (Optional for future features)
// ==============================================

Route::prefix('api')->name('api.')->group(function () {
    // Public API endpoints
    Route::get('/events', function () {
        return Event::where('status', 'published')
            ->with(['packages'])
            ->get();
    });

    Route::get('/events/{event}', function (Event $event) {
        if ($event->status !== 'published') {
            abort(404);
        }
        return $event->load(['packages']);
    });
});

// ==============================================
// FALLBACK ROUTES
// ==============================================

// 404 handler for undefined routes
Route::fallback(function () {
    return view('errors.404');
});
