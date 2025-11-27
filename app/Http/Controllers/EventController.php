<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Manager;
use App\Models\Package;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class EventController extends Controller
{
    private function checkAuth()
    {
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login');
        }
        return null;
    }

    public function index()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $events = Event::with(['manager', 'packages', 'bookings'])
            ->withCount('bookings')
            ->orderBy('date', 'desc')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $event->load(['manager', 'packages.bookings', 'bookings']);

        // Calculate revenue per package
        $packageStats = $event->packages->map(function ($package) {
            return [
                'name' => $package->name,
                'tickets_sold' => $package->bookings()->where('payment_status', 'confirmed')->sum('group_size'),
                'revenue' => $package->bookings()->where('payment_status', 'confirmed')->sum('price'),
                'bookings_count' => $package->bookings()->where('payment_status', 'confirmed')->count(),
            ];
        });

        return view('admin.events.show', compact('event', 'packageStats'));
    }

    public function create()
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $managers = Manager::all();
        return view('admin.events.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|after:now',
            'location' => 'required|string|max:255',
            'till_number' => 'required|string|regex:/^[0-9]{6,10}$/',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,published,cancelled',
            'manager_id' => 'nullable|exists:managers,id',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'packages' => 'required|array|min:1',
            'packages.*.name' => 'required|string|max:255',
            'packages.*.price' => 'required|numeric|min:0',
            'packages.*.group_size' => 'required|integer|min:1',
            'packages.*.available_tickets' => 'nullable|integer|min:1',
            'packages.*.description' => 'nullable|string',
            'packages.*.icon' => 'nullable|string|max:10',
        ]);

        DB::beginTransaction();
        try {
            // Handle poster upload
            $posterPath = null;
            if ($request->hasFile('poster')) {
                $posterPath = $request->file('poster')->store('event-posters', 'public');
            }

            // Create event with till_number
            $event = Event::create([
                'name' => $validated['name'],
                'date' => $validated['date'],
                'location' => $validated['location'],
                'till_number' => $validated['till_number'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'manager_id' => $validated['manager_id'],
                'poster' => $posterPath,
            ]);

            // Create packages
            foreach ($validated['packages'] as $packageData) {
                Package::create([
                    'event_id' => $event->id,
                    'name' => $packageData['name'],
                    'price' => $packageData['price'],
                    'group_size' => $packageData['group_size'],
                    'available_tickets' => $packageData['available_tickets'],
                    'description' => $packageData['description'],
                    'icon' => $packageData['icon'] ?? '🎫',
                ]);
            }

            DB::commit();
            return redirect()
                ->route('admin.events.index')
                ->with('success', 'Event created successfully with till number!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create event: ' . $e->getMessage()]);
        }
    }

    public function edit(Event $event)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $managers = Manager::all();
        $event->load('packages');
        return view('admin.events.edit', compact('event', 'managers'));
    }

    public function update(Request $request, Event $event)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'till_number' => 'nullable|string|max:50',
            'status' => 'required|string|in:draft,published,completed,cancelled',
            'payment_confirmed' => 'boolean',
            'manager_id' => 'nullable|exists:users,id',
            'poster' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        // Handle poster upload
        if ($request->hasFile('poster')) {
            if ($event->poster && Storage::exists('public/' . $event->poster)) {
                Storage::delete('public/' . $event->poster);
            }
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        // Update the event
        $event->update($validated);

        // Handle Packages
        $packages = $request->input('packages', []);
        $existingIds = $event->packages->pluck('id')->toArray();
        $incomingIds = collect($packages)->pluck('id')->filter()->toArray();

        // Delete removed packages
        $toDelete = array_diff($existingIds, $incomingIds);
        if (!empty($toDelete)) {
            Package::whereIn('id', $toDelete)->delete();
        }

        // Update or create packages
        foreach ($packages as $pkg) {
            if (isset($pkg['id']) && in_array($pkg['id'], $existingIds)) {
                Package::where('id', $pkg['id'])->update([
                    'name' => $pkg['name'] ?? '',
                    'price' => $pkg['price'] ?? 0,
                    'group_size' => $pkg['group_size'] ?? 1,
                    'available_tickets' => $pkg['available_tickets'] ?? 0,
                ]);
            } else {
                $event->packages()->create([
                    'name' => $pkg['name'] ?? '',
                    'price' => $pkg['price'] ?? 0,
                    'group_size' => $pkg['group_size'] ?? 1,
                    'available_tickets' => $pkg['available_tickets'] ?? 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.events')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;


        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();
        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event deleted successfully!');
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

        // CSV Headers
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
            'Member Names',
            'Member Emails',
            'Event Name',
            'Event Date',
            'Till Number'
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
                        $names[] = $member['name'];
                    }
                    if (isset($member['email']) && $member['email']) {
                        $emails[] = $member['email'];
                    }
                }

                $memberNames = implode('; ', $names);
                $memberEmails = implode('; ', $emails);
            }

            $csvData[] = [
                $booking->id,
                $booking->ticket_number,
                $booking->team_lead_name,
                $booking->team_lead_email,
                $booking->team_lead_phone,
                $booking->package ? $booking->package->name : $booking->plan_type,
                $booking->group_size,
                number_format($booking->price, 2),
                ucfirst($booking->payment_status),
                $booking->mpesa_code ?? 'N/A',
                $booking->created_at->format('Y-m-d H:i:s'),
                $booking->confirmed_by_manager ? 'Confirmed' : 'Pending',
                $booking->is_verified ? 'Verified' : 'Not Verified',
                $booking->verified_at ? $booking->verified_at->format('Y-m-d H:i:s') : 'N/A',
                $memberNames,
                $memberEmails,
                $event->name,
                $event->date->format('Y-m-d H:i:s'),
                $event->till_number ?? 'N/A'
            ];
        }

        // Generate CSV filename
        $filename = 'event_' . $event->id . '_' . Str::slug($event->name) . '_bookings_' . date('Y-m-d_H-i-s') . '.csv';

        // Create CSV content with proper escaping
        $csvContent = '';
        foreach ($csvData as $row) {
            $escapedRow = array_map(function ($field) {
                // Escape quotes and wrap in quotes
                return '"' . str_replace('"', '""', $field) . '"';
            }, $row);
            $csvContent .= implode(',', $escapedRow) . "\n";
        }

        // Return CSV download response
        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    /**
     * Display event revenue statistics
     */
    public function revenue(Event $event)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $event->load(['packages.bookings', 'bookings']);

        $stats = [
            'total_revenue' => $event->total_revenue,
            'total_tickets_sold' => $event->total_tickets_sold,
            'pending_bookings' => $event->bookings()->where('payment_status', 'pending')->count(),
            'confirmed_bookings' => $event->bookings()->where('payment_status', 'confirmed')->count(),
        ];

        $packageRevenue = $event->packages->map(function ($package) {
            return [
                'package' => $package,
                'tickets_sold' => $package->bookings()->where('payment_status', 'confirmed')->sum('group_size'),
                'revenue' => $package->bookings()->where('payment_status', 'confirmed')->sum('price'),
                'bookings_count' => $package->bookings()->where('payment_status', 'confirmed')->count(),
            ];
        });

        return view('admin.events.revenue', compact('event', 'stats', 'packageRevenue'));
    }

    /**
     * Generate PDF report for event
     */
    public function pdf(Event $event)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $event->load(['packages.bookings', 'bookings']);

        // This would require a PDF library like DomPDF
        // For now, redirect to show page
        return redirect()->route('admin.events.show', $event)
            ->with('info', 'PDF generation feature coming soon!');
    }
}
