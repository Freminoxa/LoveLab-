<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Mail\BookingReceived;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function submitBooking(Request $request)
    {
        $validated = $request->validate([
            'plan_type' => 'required|string',
            'group_size' => 'required|integer',
            'team_lead_email' => 'required|email',
            'team_lead_name' => 'required|string',
            'team_lead_phone' => 'required|string',
            'members' => 'sometimes|array',
            'members.*.name' => 'required_with:members|string',
            'members.*.email' => 'required_with:members|email',
        ]);

        // Calculate amount based on plan type
        $amount = $this->calculateAmount($validated['plan_type'], $validated['group_size']);

        $booking = Booking::create([
            'plan_type' => $validated['plan_type'],
            'group_size' => $validated['group_size'],
            'price' => $amount,
            'team_lead_email' => $validated['team_lead_email'],
            'team_lead_name' => $validated['team_lead_name'],
            'team_lead_phone' => $validated['team_lead_phone'],
            'members' => $validated['members'] ?? null
        ]);

        // Send booking confirmation email
        try {
            Mail::to($booking->team_lead_email)->send(new BookingReceived($booking));
        } catch (\Exception $e) {
            \Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
            // Continue with the process even if email fails
        }

        return redirect()->route('payment', ['booking' => $booking->id]);
    }

    public function showPayment(Booking $booking)
    {
        return view('payment', [
            'booking' => $booking,
            'tillNumber' => '123456', // Replace with actual till number
            'paymentGuidelines' => [
                '1. Go to M-Pesa Menu',
                '2. Select Lipa Na M-Pesa',
                '3. Enter Till Number 123456',
                '4. Enter Amount Ksh '.$booking->price,
                '5. Complete Transaction'
            ]
        ]);
    }

    public function confirmPayment(Request $request)
            {
                $validated = $request->validate([
                    'booking_id' => 'required|exists:bookings,id',
                    'mpesa_code' => 'required|string|size:10'
                ]);

                $booking = Booking::find($validated['booking_id']);

                // Update only the M-Pesa code, but keep payment status as 'pending'
                $booking->update([
                    'mpesa_code' => $validated['mpesa_code'],
                    'payment_status' => 'pending'
                ]);

                return redirect('/')->with('success', 'Your booking has been received! 🎉 We are waiting for payment confirmation from our team. Keep an eye on your email for updates on your ticket.');
            }

    private function calculateAmount($planType, $groupSize)
    {
        // Implement your pricing logic here
        $pricing = [
            'IP' => [500, 800, 1500, 2500],
            'VIP' => [1000, 1800, 4500, 7500],
            'VVIP' => [2500, 4800, 13500, 22500]
        ];
        
        $index = match($groupSize) {
            1 => 0,
            2 => 1,
            6 => 2,
            10 => 3,
            default => 0
        };

        return $pricing[$planType][$index] ?? 0;
    }
}