<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Manager;
use App\Models\Package;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['manager', 'packages', 'bookings'])
            ->withCount('bookings')
            ->get();
        return view('admin.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load(['manager', 'packages.bookings', 'bookings']);
        
        // Calculate revenue per package
        $packageStats = $event->packages->map(function($package) {
            return [
                'name' => $package->name,
                'tickets_sold' => $package->bookings()->where('payment_status', 'confirmed')->sum('group_size'),
                'revenue' => $package->bookings()->where('payment_status', 'confirmed')->sum('price'),
            ];
        });
        
        return view('admin.events.show', compact('event', 'packageStats'));
    }

    public function create()
    {
        $managers = Manager::all();
        return view('admin.events.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster' => 'nullable|image|max:5120',
            'manager_id' => 'nullable|exists:managers,id',
            'payment_confirmed' => 'nullable|boolean',
            'packages' => 'required|array|min:1',
            'packages.*.name' => 'required|string|max:255',
            'packages.*.price' => 'required|numeric|min:0',
            'packages.*.group_size' => 'required|integer|min:1',
            'packages.*.description' => 'nullable|string',
            'packages.*.available_tickets' => 'nullable|integer|min:0',
            'packages.*.icon' => 'nullable|string|max:10',
        ]);

        DB::beginTransaction();
        try {
            // Handle poster upload
            if ($request->hasFile('poster')) {
                $validated['poster'] = $request->file('poster')->store('posters', 'public');
            }

            // Create event
            $event = Event::create([
                'name' => $validated['name'],
                'date' => $validated['date'],
                'location' => $validated['location'],
                'description' => $validated['description'] ?? null,
                'poster' => $validated['poster'] ?? null,
                'manager_id' => $validated['manager_id'] ?? null,
                'payment_confirmed' => $validated['payment_confirmed'] ?? false,
                'status' => 'published',  // ← CHANGED from 'active' to 'published'
            ]);

            // Create packages
            foreach ($validated['packages'] as $packageData) {
                $event->packages()->create([
                    'name' => $packageData['name'],
                    'price' => $packageData['price'],
                    'group_size' => $packageData['group_size'],
                    'description' => $packageData['description'] ?? null,
                    'available_tickets' => $packageData['available_tickets'] ?? null,
                    'icon' => $packageData['icon'] ?? '🎫',
                ]);
            }

            DB::commit();
            return redirect()->route('admin.events.index')->with('success', 'Event created successfully with packages!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create event: ' . $e->getMessage()]);
        }
    }

    public function edit(Event $event)
    {
        $managers = Manager::all();
        $event->load('packages');
        return view('admin.events.edit', compact('event', 'managers'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster' => 'nullable|image|max:5120',
            'manager_id' => 'nullable|exists:managers,id',
            'payment_confirmed' => 'nullable|boolean',
            'status' => 'required|in:draft,published,completed,cancelled',  // ← FIXED: changed from 'active,completed,cancelled' to include all valid values
        ]);

        if ($request->hasFile('poster')) {
            // Delete old poster
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update([
            'name' => $validated['name'],
            'date' => $validated['date'],
            'location' => $validated['location'],
            'description' => $validated['description'] ?? $event->description,
            'poster' => $validated['poster'] ?? $event->poster,
            'manager_id' => $validated['manager_id'] ?? $event->manager_id,
            'payment_confirmed' => $validated['payment_confirmed'] ?? $event->payment_confirmed,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        // Check if there are confirmed bookings
        if ($event->bookings()->where('payment_status', 'confirmed')->exists()) {
            return back()->withErrors(['error' => 'Cannot delete event with confirmed bookings!']);
        }

        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }
        
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully!');
    }

    public function revenue(Event $event)
    {
        $event->load(['packages.bookings', 'bookings']);
        
        $stats = [
            'total_revenue' => $event->total_revenue,
            'total_tickets_sold' => $event->total_tickets_sold,
            'pending_bookings' => $event->bookings()->where('payment_status', 'pending')->count(),
            'confirmed_bookings' => $event->bookings()->where('payment_status', 'confirmed')->count(),
        ];

        $packageRevenue = $event->packages->map(function($package) {
            return [
                'package' => $package,
                'tickets_sold' => $package->bookings()->where('payment_status', 'confirmed')->sum('group_size'),
                'revenue' => $package->bookings()->where('payment_status', 'confirmed')->sum('price'),
                'bookings_count' => $package->bookings()->where('payment_status', 'confirmed')->count(),
            ];
        });

        return view('admin.events.revenue', compact('event', 'stats', 'packageRevenue'));
    }
}