<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Package;

class BookingController extends Controller
{
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

        // Verify package belongs to event
        $package = Package::where('id', $validated['package_id'])
            ->where('event_id', $validated['event_id'])
            ->firstOrFail();

        // Check if tickets are available
        if (!$package->hasAvailableTickets()) {
            return back()->withErrors(['error' => 'Sorry, this package is sold out!']);
        }

        $booking = Booking::create([
            'event_id' => $validated['event_id'],
            'package_id' => $validated['package_id'],
            'plan_type' => $package->name,
            'group_size' => $validated['group_size'],
            'price' => $validated['price'],
            'team_lead_name' => $validated['team_lead_name'],
            'team_lead_email' => $validated['team_lead_email'],
            'team_lead_phone' => $validated['team_lead_phone'],
            'members' => $validated['members'] ?? null,
            'payment_status' => 'pending',
        ]);

        return redirect()->route('payment', $booking)->with('success', 'Booking created! Please complete payment.');
    }

    public function showPayment(Booking $booking)
    {
        $booking->load(['event', 'package']);
        return view('payment', compact('booking'));
    }

    public function confirmPayment(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'mpesa_code' => 'required|string|min:10|max:15'
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);
        $booking->update([
            'mpesa_code' => $validated['mpesa_code'],
            'payment_status' => 'pending', // Manager needs to confirm
        ]);

        return redirect('/')->with('success', 'Payment submitted! Your booking will be confirmed by the event manager.');
    }
}
