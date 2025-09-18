<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Mail\PaymentStatusUpdated;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $password = $request->input('password');
        
        // Simple password check - change this to your desired password
        if ($password === 'admin123') {
            $request->session()->put('admin_authenticated', true);
            return redirect()->route('admin.dashboard');
        }
        
        return back()->withErrors(['password' => 'Invalid password']);
    }

    public function dashboard()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $bookings = Booking::latest()->paginate(15);
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_payments' => Booking::where('payment_status', 'pending')->count(),
            'confirmed_payments' => Booking::where('payment_status', 'confirmed')->count(),
            'total_revenue' => Booking::where('payment_status', 'confirmed')->sum('price'),
        ];
        
        return view('admin.dashboard', compact('bookings', 'stats'));
    }

    public function bookings(Request $request)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $query = Booking::query();
        
        // Filter by payment status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        
        // Filter by plan type
        if ($request->filled('plan')) {
            $query->where('plan_type', $request->plan);
        }
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('team_lead_name', 'LIKE', "%{$search}%")
                  ->orWhere('team_lead_email', 'LIKE', "%{$search}%");
            });
        }
        
        $bookings = $query->latest()->paginate(20);
        return view('admin.bookings', compact('bookings'));
    }

    public function showBooking(Booking $booking)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        return view('admin.booking-details', compact('booking'));
    }

    public function updatePaymentStatus(Request $request, Booking $booking)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $request->validate([
            'payment_status' => 'required|in:pending,confirmed,failed'
        ]);

        $oldStatus = $booking->payment_status;
        $newStatus = $request->payment_status;

        // Update the booking
        $booking->update([
            'payment_status' => $newStatus
        ]);

        // Send email notification if status actually changed
        if ($oldStatus !== $newStatus) {
            try {
                Mail::to($booking->team_lead_email)->send(
                    new PaymentStatusUpdated($booking, $oldStatus, $newStatus)
                );
                
                $emailStatus = " Email notification sent to {$booking->team_lead_email}.";
            } catch (\Exception $e) {
                $emailStatus = " Note: Email notification could not be sent.";
                \Log::error('Failed to send payment status email: ' . $e->getMessage());
            }
        } else {
            $emailStatus = "";
        }

        return back()->with('success', "Payment status updated successfully!{$emailStatus}");
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_authenticated');
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }
}
