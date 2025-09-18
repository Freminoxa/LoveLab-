<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function showLogin()
    {
        return view('manager.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $manager = Manager::where('email', $credentials['email'])->first();

        if ($manager && Hash::check($credentials['password'], $manager->password)) {
            session(['manager_id' => $manager->id, 'manager_name' => $manager->name]);
            return redirect()->route('manager.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function dashboard()
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $managerId = session('manager_id');
        $manager = Manager::find($managerId);
        $events = Event::where('manager_id', $managerId)
            ->with(['packages', 'bookings'])
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

    public function eventBookings($eventId)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $managerId = session('manager_id');
        $event = Event::where('manager_id', $managerId)
            ->with(['packages', 'bookings'])
            ->findOrFail($eventId);

        $bookings = $event->bookings()->with('package')->latest()->get();

        return view('manager.event-bookings', compact('event', 'bookings'));
    }

    public function confirmBooking($bookingId)
    {
        if (!session('manager_id')) {
            return redirect()->route('manager.login');
        }

        $managerId = session('manager_id');
        $booking = Booking::whereHas('event', function($q) use ($managerId) {
            $q->where('manager_id', $managerId);
        })->findOrFail($bookingId);

        $booking->update([
            'payment_status' => 'confirmed',
            'confirmed_by_manager' => true,
        ]);

        return back()->with('success', 'Booking confirmed successfully!');
    }

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
            'payment_status' => 'failed',
            'confirmed_by_manager' => false,
        ]);

        return back()->with('success', 'Booking rejected!');
    }

    public function logout()
    {
        session()->forget(['manager_id', 'manager_name']);
        return redirect()->route('manager.login')->with('success', 'Logged out successfully');
    }

    // Admin functions for creating managers
    public function create()
    {
        return view('admin.managers.create');
    }

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

        return redirect()->route('admin.events.create')->with('success', 'Manager created successfully!');
    }
}