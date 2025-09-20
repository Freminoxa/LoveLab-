<?php

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
     * Manager Dashboard with Search and Filtering
     */
    public function dashboard(Request $request)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $managerId = session('manager_id');
        $manager = Manager::find($managerId);
        
        // Start with base query
        $query = Event::where('manager_id', $managerId)
            ->with(['packages', 'bookings']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'upcoming':
                    $query->where('date', '>', now());
                    break;
                case 'past':
                    $query->where('date', '<', now()->startOfDay());
                    break;
                case 'today':
                    $query->whereDate('date', today());
                    break;
            }
        }

        $events = $query->orderBy('date', 'desc')->get();

        // Calculate stats (only for manager's events)
        $allManagerEvents = Event::where('manager_id', $managerId)->pluck('id');
        
        $stats = [
            'total_events' => $events->count(),
            'total_bookings' => Booking::whereIn('event_id', $allManagerEvents)->count(),
            'pending_confirmations' => Booking::whereIn('event_id', $allManagerEvents)
                ->where('payment_status', 'pending')->count(),
            'total_revenue' => Booking::whereIn('event_id', $allManagerEvents)
                ->where('payment_status', 'confirmed')->sum('price'),
        ];

        return view('manager.dashboard', compact('manager', 'events', 'stats'));
    }

    /**
     * Show event bookings
     */
    public function eventBookings($eventId)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $managerId = session('manager_id');
        
        $event = Event::where('id', $eventId)
            ->where('manager_id', $managerId)
            ->with(['bookings.package'])
            ->firstOrFail();

        $bookings = $event->bookings()
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('manager.event-bookings', compact('event', 'bookings'));
    }

    /**
     * Confirm booking payment
     */
    public function confirmBooking(Request $request, $bookingId)
    {
        if (!session('manager_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $managerId = session('manager_id');
        
        $booking = Booking::whereHas('event', function($q) use ($managerId) {
            $q->where('manager_id', $managerId);
        })->findOrFail($bookingId);

        $booking->update([
            'payment_status' => 'confirmed',
            'confirmed_by_manager' => true
        ]);

        // Generate QR code if not exists
        if (!$booking->qr_code) {
            $booking->generateQRCode();
        }

        // Send confirmation email
        try {
            Mail::to($booking->team_lead_email)->send(new TicketConfirmation($booking));
            Log::info("Confirmation email sent for booking {$booking->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send confirmation email for booking {$booking->id}: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Payment confirmed and confirmation email sent!');
    }

    /**
     * Reject booking payment
     */
    public function rejectBooking(Request $request, $bookingId)
    {
        if (!session('manager_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $managerId = session('manager_id');
        
        $booking = Booking::whereHas('event', function($q) use ($managerId) {
            $q->where('manager_id', $managerId);
        })->findOrFail($bookingId);

        $booking->update([
            'payment_status' => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Payment rejected!');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['manager_id', 'manager_name', 'manager_email']);
        return redirect()->route('manager.login')->with('success', 'Logged out successfully!');
    }
}