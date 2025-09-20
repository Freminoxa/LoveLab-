<?php
// app/Http/Controllers/ManagerController.php - Complete with Email Sending

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use App\Models\Event;
use App\Models\Booking;
use App\Mail\TicketConfirmation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ManagerController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (session('manager_id')) {
            return redirect()->route('manager.dashboard');
        }
        
        return view('manager.login');
    }

    /**
     * Handle login authentication
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $manager = Manager::where('email', $credentials['email'])->first();

        if ($manager && Hash::check($credentials['password'], $manager->password)) {
            session([
                'manager_id' => $manager->id,
                'manager_name' => $manager->name,
                'manager_email' => $manager->email
            ]);
            
            return redirect()->route('manager.dashboard')
                           ->with('success', 'Welcome back, ' . $manager->name . '!');
        }

        return back()
            ->withErrors(['email' => 'Invalid email or password'])
            ->withInput($request->only('email'));
    }

    /**
     * Manager Dashboard
     */
    public function dashboard()
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $managerId = session('manager_id');
        $manager = Manager::find($managerId);
        
        $events = Event::where('manager_id', $managerId)
            ->with(['packages', 'bookings'])
            ->orderBy('date', 'desc')
            ->get();

        $stats = [
            'total_events' => $events->count(),
            'total_bookings' => Booking::whereHas('event', function($q) use ($managerId) {
                $q->where('manager_id', $managerId);
            })->count(),
            'pending_confirmations' => Booking::whereHas('event', function($q) use ($managerId) {
                $q->where('manager_id', $managerId);
            })->where('payment_status', 'pending')->count(),
            'total_revenue' => Booking::whereHas('event', function($q) use ($managerId) {
                $q->where('manager_id', $managerId);
            })->where('payment_status', 'confirmed')->sum('price'),
        ];

        return view('manager.dashboard', compact('manager', 'events', 'stats'));
    }

    /**
     * Show event bookings with verification status
     */
    public function eventBookings($eventId)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $managerId = session('manager_id');
        
        $event = Event::where('id', $eventId)
            ->where('manager_id', $managerId)
            ->with(['packages', 'bookings.package'])
            ->firstOrFail();

        $bookings = $event->bookings()
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('manager.event-bookings', compact('event', 'bookings'));
    }

    /**
     * Confirm booking payment and send ticket email - UPDATED WITH EMAIL SENDING
     */
    public function confirmBooking($bookingId)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $managerId = session('manager_id');
        
        $booking = Booking::whereHas('event', function($q) use ($managerId) {
            $q->where('manager_id', $managerId);
        })->with(['event', 'package'])->findOrFail($bookingId);

        // Update booking status
        $booking->update([
            'payment_status' => 'confirmed',
            'confirmed_by_manager' => true,
        ]);

        // Generate QR code if not exists
        if (!$booking->qr_code) {
            $booking->generateQRCode();
        }

        // Reduce available tickets for the package
        if ($booking->package) {
            $booking->package->decrement('available_tickets', $booking->group_size);
        }

        // Reload booking with relationships for email
        $booking->refresh();
        $booking->load(['event', 'package']);

        // Send confirmation email with QR code
        try {
            Mail::to($booking->team_lead_email)->send(
                new TicketConfirmation($booking)
            );
            
            Log::info('Ticket confirmation email sent to: ' . $booking->team_lead_email);
            
            return back()->with('success', 'Payment confirmed and ticket sent to ' . $booking->team_lead_email);
        } catch (\Exception $e) {
            Log::error('Failed to send ticket email: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('warning', 'Payment confirmed but email sending failed: ' . $e->getMessage());
        }
    }

    /**
     * Reject booking payment
     */
    public function rejectBooking($bookingId)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $managerId = session('manager_id');
        
        $booking = Booking::whereHas('event', function($q) use ($managerId) {
            $q->where('manager_id', $managerId);
        })->findOrFail($bookingId);

        $booking->update([
            'payment_status' => 'rejected',
            'confirmed_by_manager' => false,
        ]);

        return back()->with('success', 'Payment rejected!');
    }

    /**
     * Logout manager
     */
    public function logout()
    {
        session()->forget(['manager_id', 'manager_name', 'manager_email']);
        
        return redirect()->route('manager.login')
                       ->with('success', 'Logged out successfully');
    }

    /**
     * Show create manager form
     */
    public function create()
    {
        return view('admin.managers.create');
    }

    /**
     * Store new manager
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:managers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $manager = Manager::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.events.create')
            ->with('success', 'Manager created successfully!');
    }
}