<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPayment(Booking $booking)
    {
        return view('payment', compact('booking'));
    }

    public function confirmPayment(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'mpesa_code' => 'required|string|min:10|max:10'
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);
        $booking->update([
            'mpesa_code' => $validated['mpesa_code'],
            'payment_status' => 'completed'
        ]);

        return redirect()->route('payment.success')
            ->with('success', 'Booking confirmed successfully!');
    }
}