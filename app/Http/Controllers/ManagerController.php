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

            // Check if this is first login
            if ($manager->isFirstLogin()) {
                session(['must_change_password' => true]);
                return redirect()->route('manager.change-password')
                    ->with('info', 'Welcome! Please change your password to continue.');
            }

            return redirect()->route('manager.dashboard')
                ->with('success', 'Welcome back, ' . $manager->name . '!');
        }

        return back()
            ->withErrors(['email' => 'Invalid email or password'])
            ->withInput($request->only('email'));
    }

    /**
     * Show change password form
     */
    public function showChangePassword()
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        // If password already changed, redirect to dashboard
        $manager = Manager::find(session('manager_id'));
        if (!$manager->isFirstLogin() && !session('must_change_password')) {
            return redirect()->route('manager.dashboard');
        }

        return view('manager.change-password');
    }

    /**
     * Handle password change
     */
    public function changePassword(Request $request)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $manager = Manager::find(session('manager_id'));

        // Verify current password
        if (!Hash::check($request->current_password, $manager->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password
        $manager->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Mark password as changed
        $manager->markPasswordAsChanged();

        // Clear the session flag
        session()->forget('must_change_password');

        return redirect()->route('manager.dashboard')
            ->with('success', 'Password changed successfully! Welcome to your dashboard.');
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

        // Check if password change is required
        if ($manager->isFirstLogin() || session('must_change_password')) {
            return redirect()->route('manager.change-password')
                ->with('info', 'Please change your password to access the dashboard.');
        }

        // Start with base query
        $query = Event::where('manager_id', $managerId)
            ->with(['packages', 'bookings']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
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
            'total_attended' => Booking::whereIn('event_id', $allManagerEvents)
                ->where('has_attended', true)->count(),
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

        $booking = Booking::whereHas('event', function ($q) use ($managerId) {
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

        $booking = Booking::whereHas('event', function ($q) use ($managerId) {
            $q->where('manager_id', $managerId);
        })->findOrFail($bookingId);

        $booking->update([
            'payment_status' => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Payment rejected!');
    }

    /**
     * Confirm attendance for a booking at entrance
     */
    public function confirmAttendance(Request $request, $bookingId)
    {
        if (!session('manager_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $managerId = session('manager_id');
        
        $booking = Booking::whereHas('event', function($q) use ($managerId) {
            $q->where('manager_id', $managerId);
        })->findOrFail($bookingId);

        // Only allow attendance confirmation for confirmed payments
        if ($booking->payment_status !== 'confirmed') {
            return redirect()->back()->with('error', 'Cannot confirm attendance for unconfirmed payment!');
        }

        // Toggle attendance status
        if ($booking->has_attended) {
            $booking->update([
                'has_attended' => false,
                'attended_at' => null,
                'attended_by' => null
            ]);
            $message = 'Attendance removed!';
        } else {
            $booking->update([
                'has_attended' => true,
                'attended_at' => now(),
                'attended_by' => $managerId
            ]);
            $message = 'Attendance confirmed!';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Show the form for creating a new manager (Admin only)
     */
    public function create()
    {
        // Check if admin is authenticated
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login')->with('error', 'Admin access required');
        }

        return view('admin.managers.create');
    }

    /**
     * Store a newly created manager in storage (Admin only)
     */
    public function store(Request $request)
    {
        // Check if admin is authenticated
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login')->with('error', 'Admin access required');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:managers',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $manager = Manager::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            // Don't set password_changed_at - leave it null for first login detection
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', "Manager '{$manager->name}' created successfully! They will be required to change their password on first login.");
    }

    /**
     * Display a listing of managers (Admin only) - Optional
     */
    public function index()
    {
        // Check if admin is authenticated
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login')->with('error', 'Admin access required');
        }

        $managers = Manager::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.managers.index', compact('managers'));
    }

    /**
     * Show manager details (Admin only) - Optional
     */
    public function show($id)
    {
        // Check if admin is authenticated
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login')->with('error', 'Admin access required');
        }

        $manager = Manager::with(['events'])->findOrFail($id);

        return view('admin.managers.show', compact('manager'));
    }

    /**
     * Show the form for editing a manager (Admin only) - Optional
     */
    public function edit($id)
    {
        // Check if admin is authenticated
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login')->with('error', 'Admin access required');
        }

        $manager = Manager::findOrFail($id);

        return view('admin.managers.edit', compact('manager'));
    }

    /**
     * Update the specified manager (Admin only) - Optional
     */
    public function update(Request $request, $id)
    {
        // Check if admin is authenticated
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login')->with('error', 'Admin access required');
        }

        $manager = Manager::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:managers,email,' . $manager->id,
            'phone' => 'nullable|string|max:20',
        ];

        // Only validate password if provided
        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $request->validate($rules);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $manager->update($updateData);

        return redirect()->route('admin.managers.show', $manager->id)
            ->with('success', "Manager '{$manager->name}' updated successfully!");
    }

    /**
     * Remove the specified manager (Admin only) - Optional
     */
    public function destroy($id)
    {
        // Check if admin is authenticated
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login')->with('error', 'Admin access required');
        }

        $manager = Manager::findOrFail($id);

        // Check if manager has events - you might want to prevent deletion if they do
        $eventCount = $manager->events()->count();

        if ($eventCount > 0) {
            return back()->with('error', "Cannot delete manager '{$manager->name}' - they have {$eventCount} associated event(s).");
        }

        $managerName = $manager->name;
        $manager->delete();

        return redirect()->route('admin.managers.index')
            ->with('success', "Manager '{$managerName}' deleted successfully!");
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['manager_id', 'manager_name', 'manager_email', 'must_change_password']);
        return redirect()->route('manager.login')->with('success', 'Logged out successfully!');
    }


    public function exportBookings($eventId)
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

        $filename = 'event_' . $event->id . '_bookings_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return response()->streamDownload(function () use ($bookings) {
            $file = fopen('php://output', 'w');

            // Write CSV header
            fputcsv($file, [
                'Booking ID',
                'Team Lead Name',
                'Team Lead Email',
                'Team Lead Phone',
                'Package',
                'Group Size',
                'Price',
                'Payment Status',
                'Created At'
            ]);

            // Write CSV rows
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->team_lead_name,
                    $booking->team_lead_email,
                    $booking->team_lead_phone,
                    $booking->package->name ?? 'N/A',
                    $booking->group_size,
                    number_format($booking->price, 2),
                    ucfirst($booking->payment_status),
                    $booking->created_at->toDateTimeString(),
                ]);
            }

            fclose($file);
        }, $filename, $headers);
    }
}
