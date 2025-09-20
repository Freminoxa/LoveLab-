<?php
// app/Http/Controllers/TicketVerificationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class TicketVerificationController extends Controller
{
    /**
     * Show QR code scanner page for managers
     */
    public function scannerPage($eventId)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $event = Event::where('id', $eventId)
            ->where('manager_id', session('manager_id'))
            ->firstOrFail();

        return view('manager.scanner', compact('event'));
    }

    /**
     * Search for booking by ticket number or attendee details
     */
    public function searchBooking(Request $request)
    {
        if (!session('manager_id')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $query = $request->input('query');
        $eventId = $request->input('event_id');

        $bookings = Booking::where('event_id', $eventId)
            ->where('payment_status', 'confirmed')
            ->where(function($q) use ($query) {
                $q->where('ticket_number', 'LIKE', "%{$query}%")
                  ->orWhere('team_lead_name', 'LIKE', "%{$query}%")
                  ->orWhere('team_lead_email', 'LIKE', "%{$query}%")
                  ->orWhere('team_lead_phone', 'LIKE', "%{$query}%");
            })
            ->with(['event', 'package'])
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'bookings' => $bookings
        ]);
    }

    /**
     * Verify ticket via QR code scan
     */
    public function verifyTicket(Request $request)
    {
        if (!session('manager_id')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'qr_data' => 'required|string',
        ]);

        try {
            // Decode QR data
            $data = json_decode($validated['qr_data'], true);
            
            if (!isset($data['booking_id']) || !isset($data['ticket_number'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid QR code data'
                ], 400);
            }

            $booking = Booking::with(['event', 'package'])
                ->where('id', $data['booking_id'])
                ->where('ticket_number', $data['ticket_number'])
                ->first();

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket not found'
                ], 404);
            }

            // Check if booking belongs to manager's event
            if ($booking->event->manager_id != session('manager_id')) {
                return response()->json([
                    'success' => false,
                    'message' => 'This ticket is for a different event'
                ], 403);
            }

            // Check if payment is confirmed
            if (!$booking->canBeVerified()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket payment not confirmed yet'
                ], 400);
            }

            // Verify the ticket
            $booking->markAsVerified(session('manager_id'));

            return response()->json([
                'success' => true,
                'message' => $booking->verification_count > 1 
                    ? 'Warning: This ticket was already scanned ' . ($booking->verification_count - 1) . ' time(s) before!'
                    : 'Ticket verified successfully!',
                'booking' => $booking,
                'verification_count' => $booking->verification_count,
                'already_verified' => $booking->verification_count > 1
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error verifying ticket: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Manual verification by ticket number
     */
    public function manualVerification(Request $request)
    {
        if (!session('manager_id')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'ticket_number' => 'required|string',
            'event_id' => 'required|exists:events,id'
        ]);

        $booking = Booking::with(['event', 'package'])
            ->where('ticket_number', $validated['ticket_number'])
            ->where('event_id', $validated['event_id'])
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found for this event'
            ], 404);
        }

        // Check if booking belongs to manager's event
        if ($booking->event->manager_id != session('manager_id')) {
            return response()->json([
                'success' => false,
                'message' => 'This ticket is for a different event'
            ], 403);
        }

        if (!$booking->canBeVerified()) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket payment not confirmed yet'
            ], 400);
        }

        $booking->markAsVerified(session('manager_id'));

        return response()->json([
            'success' => true,
            'message' => $booking->verification_count > 1 
                ? 'Warning: Already scanned ' . ($booking->verification_count - 1) . ' time(s)!'
                : 'Ticket verified successfully!',
            'booking' => $booking,
            'verification_count' => $booking->verification_count,
            'already_verified' => $booking->verification_count > 1
        ]);
    }

    /**
     * Get verification statistics
     */
    public function getStats($eventId)
    {
        if (!session('manager_id')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $event = Event::where('id', $eventId)
            ->where('manager_id', session('manager_id'))
            ->firstOrFail();

        $stats = [
            'total_tickets' => $event->bookings()->where('payment_status', 'confirmed')->count(),
            'verified_tickets' => $event->bookings()->where('is_verified', true)->count(),
            'pending_verification' => $event->bookings()
                ->where('payment_status', 'confirmed')
                ->where('is_verified', false)
                ->count(),
            'total_attendees' => $event->bookings()
                ->where('payment_status', 'confirmed')
                ->sum('group_size'),
            'verified_attendees' => $event->bookings()
                ->where('is_verified', true)
                ->sum('group_size'),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}