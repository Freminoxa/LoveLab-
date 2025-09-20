<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Event;
use App\Mail\PaymentStatusUpdated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        
        $query = Booking::with(['event', 'package']);
        
        // Filter by payment status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        
        // Filter by plan type or package
        if ($request->filled('plan')) {
            $query->where(function($q) use ($request) {
                $q->where('plan_type', $request->plan)
                  ->orWhereHas('package', function($subQ) use ($request) {
                      $subQ->where('name', 'LIKE', "%{$request->plan}%");
                  });
            });
        }
        
        // Filter by event
        if ($request->filled('event')) {
            $query->where('event_id', $request->event);
        }
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('team_lead_name', 'LIKE', "%{$search}%")
                  ->orWhere('team_lead_email', 'LIKE', "%{$search}%")
                  ->orWhere('ticket_number', 'LIKE', "%{$search}%");
            });
        }
        
        $bookings = $query->latest()->paginate(20);
        
        // Get events for filter dropdown
        $events = Event::orderBy('name')->get();
        
        return view('admin.bookings', compact('bookings', 'events'));
    }

    public function showBooking(Booking $booking)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $booking->load(['event', 'package']);
        return view('admin.booking-details', compact('booking'));
    }

    public function updatePaymentStatus(Request $request, Booking $booking)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;
        
        $request->validate([
            'payment_status' => 'required|in:pending,confirmed,failed,rejected'
        ]);

        $oldStatus = $booking->payment_status;
        $newStatus = $request->payment_status;

        // Update the booking
        $booking->update([
            'payment_status' => $newStatus,
            'confirmed_by_manager' => $newStatus === 'confirmed'
        ]);

        // Generate QR code if confirming payment and QR doesn't exist
        if ($newStatus === 'confirmed' && !$booking->qr_code) {
            $booking->generateQRCode();
        }

        // Send email notification if status actually changed
        if ($oldStatus !== $newStatus) {
            try {
                Mail::to($booking->team_lead_email)->send(
                    new PaymentStatusUpdated($booking, $oldStatus, $newStatus)
                );
                
                $emailStatus = " Email notification sent to {$booking->team_lead_email}.";
            } catch (\Exception $e) {
                $emailStatus = " Note: Email notification could not be sent.";
                Log::error('Failed to send payment status email: ' . $e->getMessage());
            }
        } else {
            $emailStatus = "";
        }

        return back()->with('success', "Payment status updated successfully!{$emailStatus}");
    }

    /**
     * Export event bookings to CSV with detailed attendee information
     */
    public function exportBookings($eventId)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $event = Event::with(['bookings.package'])->findOrFail($eventId);
        
        $bookings = $event->bookings()
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->get();

        $csvData = [];
        
        // Enhanced CSV Headers
        $csvData[] = [
            'Booking ID',
            'Ticket Number',
            'Team Lead Name',
            'Team Lead Email',
            'Team Lead Phone',
            'Package Name',
            'Group Size',
            'Amount Paid (KSH)',
            'Payment Status',
            'M-Pesa Code',
            'Booking Date',
            'Confirmation Status',
            'Verification Status',
            'Verified At',
            'Verification Count',
            'Member Names',
            'Member Emails',
            'Event Name',
            'Event Date',
            'Event Location',
            'Till Number',
            'QR Code Generated'
        ];

        foreach ($bookings as $booking) {
            // Extract member information
            $memberNames = '';
            $memberEmails = '';
            
            if ($booking->members && is_array($booking->members)) {
                $names = [];
                $emails = [];
                
                foreach ($booking->members as $member) {
                    if (isset($member['name']) && $member['name']) {
                        $names[] = trim($member['name']);
                    }
                    if (isset($member['email']) && $member['email']) {
                        $emails[] = trim($member['email']);
                    }
                }
                
                $memberNames = implode('; ', $names);
                $memberEmails = implode('; ', $emails);
            }

            $csvData[] = [
                $booking->id,
                $booking->ticket_number ?? 'N/A',
                $booking->team_lead_name,
                $booking->team_lead_email,
                $booking->team_lead_phone,
                $booking->package ? $booking->package->name : ($booking->plan_type ?? 'N/A'),
                $booking->group_size,
                number_format($booking->price, 2),
                ucfirst($booking->payment_status),
                $booking->mpesa_code ?? 'N/A',
                $booking->created_at->format('Y-m-d H:i:s'),
                $booking->confirmed_by_manager ? 'Confirmed' : 'Pending',
                $booking->is_verified ? 'Verified' : 'Not Verified',
                $booking->verified_at ? $booking->verified_at->format('Y-m-d H:i:s') : 'N/A',
                $booking->verification_count ?? 0,
                $memberNames,
                $memberEmails,
                $event->name,
                $event->date->format('Y-m-d H:i:s'),
                $event->location,
                $event->till_number ?? 'N/A',
                $booking->qr_code ? 'Yes' : 'No'
            ];
        }

        // Generate CSV filename with event slug
        $eventSlug = Str::slug($event->name);
        $filename = "event_{$event->id}_{$eventSlug}_bookings_" . date('Y-m-d_H-i-s') . '.csv';

        // Create CSV content with proper escaping
        $csvContent = '';
        foreach ($csvData as $row) {
            $escapedRow = array_map(function($field) {
                // Escape quotes and wrap in quotes, handle null values
                $field = $field ?? '';
                return '"' . str_replace('"', '""', $field) . '"';
            }, $row);
            $csvContent .= implode(',', $escapedRow) . "\n";
        }

        // Return CSV download response with proper headers
        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    /**
     * Export all bookings (not event-specific)
     */
    public function exportAllBookings(Request $request)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $query = Booking::with(['event', 'package']);

        // Apply same filters as bookings page
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        
        if ($request->filled('event')) {
            $query->where('event_id', $request->event);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('team_lead_name', 'LIKE', "%{$search}%")
                  ->orWhere('team_lead_email', 'LIKE', "%{$search}%")
                  ->orWhere('ticket_number', 'LIKE', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        $csvData = [];
        
        // CSV Headers for all bookings
        $csvData[] = [
            'Booking ID',
            'Ticket Number',
            'Team Lead Name',
            'Team Lead Email',
            'Team Lead Phone',
            'Event Name',
            'Package Name',
            'Group Size',
            'Amount Paid (KSH)',
            'Payment Status',
            'M-Pesa Code',
            'Booking Date',
            'Confirmation Status',
            'Verification Status',
            'Till Number'
        ];

        foreach ($bookings as $booking) {
            $csvData[] = [
                $booking->id,
                $booking->ticket_number ?? 'N/A',
                $booking->team_lead_name,
                $booking->team_lead_email,
                $booking->team_lead_phone,
                $booking->event ? $booking->event->name : 'N/A',
                $booking->package ? $booking->package->name : ($booking->plan_type ?? 'N/A'),
                $booking->group_size,
                number_format($booking->price, 2),
                ucfirst($booking->payment_status),
                $booking->mpesa_code ?? 'N/A',
                $booking->created_at->format('Y-m-d H:i:s'),
                $booking->confirmed_by_manager ? 'Confirmed' : 'Pending',
                $booking->is_verified ? 'Verified' : 'Not Verified',
                $booking->event && $booking->event->till_number ? $booking->event->till_number : 'N/A'
            ];
        }

        // Generate filename
        $filename = 'all_bookings_' . date('Y-m-d_H-i-s') . '.csv';

        // Create CSV content
        $csvContent = '';
        foreach ($csvData as $row) {
            $escapedRow = array_map(function($field) {
                $field = $field ?? '';
                return '"' . str_replace('"', '""', $field) . '"';
            }, $row);
            $csvContent .= implode(',', $escapedRow) . "\n";
        }

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_authenticated');
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }
}