<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Package;

class BookingController extends Controller
{
    /**
     * Step 1: Collect booking info and store in session.
     */
    public function submitBooking(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'package_id' => 'required|exists:packages,id',
            'team_lead_name' => 'required|string|max:255',
            'team_lead_email' => 'required|email',
            'team_lead_phone' => 'required|string',
            'members' => 'nullable|array',
            'members.*.name' => 'required|string|max:255',
            'members.*.email' => 'nullable|email',
            'members.*.phone' => 'nullable|string',
            'price' => 'required|numeric',
            'group_size' => 'required|integer|min:1',
        ]);

        // Verify package belongs to the event
        $package = Package::where('id', $validated['package_id'])
            ->where('event_id', $validated['event_id'])
            ->firstOrFail();

        // Check if tickets are available
        if (!$package->hasAvailableTickets()) {
            return back()->withErrors(['error' => 'Sorry, this package is sold out!']);
        }

        // Store booking details in session (instead of creating a DB record)
        session([
            'pending_booking' => [
                'event_id' => $validated['event_id'],
                'package_id' => $validated['package_id'],
                'plan_type' => $package->name,
                'group_size' => $validated['group_size'],
                'price' => $validated['price'],
                'team_lead_name' => $validated['team_lead_name'],
                'team_lead_email' => $validated['team_lead_email'],
                'team_lead_phone' => $validated['team_lead_phone'],
                'members' => $validated['members'] ?? null,
            ],
        ]);

        return redirect()->route('payment', ['booking' => session('pending_booking')])
            ->with('success', 'Booking details saved! Please proceed with payment.');
    }

    /**
     * Step 2: Show payment page using session data.
     */
    public function showPayment()
    {
        $bookingData = session('pending_booking');

        if (!$bookingData) {
            return redirect()->back()->withErrors(['error' => 'No pending booking found. Please try again.']);
        }

        $event = Event::find($bookingData['event_id']);
        $package = Package::find($bookingData['package_id']);

        return view('payment', [
            'booking' => $bookingData,
            'event' => $event,
            'package' => $package,
        ]);
    }

    /**
     * Step 3: Confirm payment and create booking.
     */
    public function confirmPayment(Request $request)
    {
        $validated = $request->validate([
            'mpesa_code' => 'required|string|min:10|max:15',
        ]);

        $bookingData = session('pending_booking');

        if (!$bookingData) {
            return redirect()->route('home')->withErrors(['error' => 'Session expired. Please book again.']);
        }

        // Create booking now (after payment submission)
        $booking = Booking::create([
            'event_id' => $bookingData['event_id'],
            'package_id' => $bookingData['package_id'],
            'plan_type' => $bookingData['plan_type'],
            'group_size' => $bookingData['group_size'],
            'price' => $bookingData['price'],
            'team_lead_name' => $bookingData['team_lead_name'],
            'team_lead_email' => $bookingData['team_lead_email'],
            'team_lead_phone' => $bookingData['team_lead_phone'],
            'members' => $bookingData['members'],
            'mpesa_code' => $validated['mpesa_code'],
            'payment_status' => 'pending', // manager needs to confirm
        ]);

        // Clear the session booking data
        session()->forget('pending_booking');

        return redirect('/')->with('success', 'Payment submitted! Your booking will be confirmed by the event manager.');
    }
}
