<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Manager;
use App\Models\Package;
use App\Models\Booking;
use App\Models\User;
use App\Mail\EventAttendeesBroadcast;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
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
            'till_number' => 'nullable|string|regex:/^[0-9]{6,10}$/',
            'is_free_entry' => 'nullable|boolean',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,published,cancelled',
            'manager_id' => 'nullable|exists:managers,id',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'packages' => 'nullable|array|min:1',
            'packages.*.name' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric|min:0',
            'packages.*.group_size' => 'nullable|integer|min:1',
            'packages.*.available_tickets' => 'nullable|integer|min:1',
            'packages.*.description' => 'nullable|string',
            'packages.*.icon' => 'nullable|string|max:10',
        ]);

        $isFreeEntry = $request->boolean('is_free_entry');
        if (!$isFreeEntry && empty($validated['till_number'])) {
            return back()->withErrors(['till_number' => 'Till number is required for paid events.'])->withInput();
        }
        if (!$isFreeEntry && empty($validated['packages'])) {
            return back()->withErrors(['packages' => 'At least one package is required for paid events.'])->withInput();
        }

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
                'is_free_entry' => $isFreeEntry,
                'description' => $validated['description'],
                'status' => $validated['status'],
                'manager_id' => $validated['manager_id'],
                'poster' => $posterPath,
            ]);

            // Create packages
            if ($isFreeEntry) {
                Package::create([
                    'event_id' => $event->id,
                    'name' => 'Free Entry',
                    'price' => 0,
                    'group_size' => 1,
                    'available_tickets' => null,
                    'description' => 'Company-sponsored free access. Registration required.',
                    'icon' => '🆓',
                ]);
            } else {
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
            'till_number' => 'nullable|string|regex:/^[0-9]{6,10}$/',
            'is_free_entry' => 'nullable|boolean',
            'status' => 'required|string|in:draft,published,completed,cancelled',
            'payment_confirmed' => 'boolean',
            'manager_id' => 'nullable|exists:managers,id',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'packages' => 'nullable|array|min:1',
            'packages.*.id' => 'nullable|integer',
            'packages.*.name' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric|min:0',
            'packages.*.group_size' => 'nullable|integer|min:1',
            'packages.*.available_tickets' => 'nullable|integer|min:1',
            'packages.*.description' => 'nullable|string',
            'packages.*.icon' => 'nullable|string|max:10',
        ]);

        $isFreeEntry = $request->boolean('is_free_entry');
        if (!$isFreeEntry && empty($validated['till_number'])) {
            return back()->withErrors(['till_number' => 'Till number is required for paid events.'])->withInput();
        }
        if (!$isFreeEntry && empty($validated['packages'])) {
            return back()->withErrors(['packages' => 'At least one package is required for paid events.'])->withInput();
        }

        DB::beginTransaction();
        try {
            // Handle poster upload
            if ($request->hasFile('poster')) {
                if ($event->poster && Storage::disk('public')->exists($event->poster)) {
                    Storage::disk('public')->delete($event->poster);
                }
                $validated['poster'] = $request->file('poster')->store('event-posters', 'public');
            }

            $event->update([
                'name' => $validated['name'],
                'date' => $validated['date'],
                'location' => $validated['location'],
                'till_number' => $isFreeEntry ? null : $validated['till_number'],
                'is_free_entry' => $isFreeEntry,
                'status' => $validated['status'],
                'payment_confirmed' => $request->boolean('payment_confirmed'),
                'manager_id' => $validated['manager_id'],
                'description' => $validated['description'] ?? null,
                'poster' => $validated['poster'] ?? $event->poster,
            ]);

            if ($isFreeEntry) {
                $event->packages()->delete();
                $event->packages()->create([
                    'name' => 'Free Entry',
                    'price' => 0,
                    'group_size' => 1,
                    'available_tickets' => null,
                    'description' => 'Company-sponsored free access. Registration required.',
                    'icon' => '🆓',
                ]);
            } else {
                $packages = $validated['packages'] ?? [];
                $existingIds = $event->packages()->pluck('id')->toArray();
                $incomingIds = collect($packages)->pluck('id')->filter()->map(fn ($id) => (int) $id)->toArray();

                $toDelete = array_diff($existingIds, $incomingIds);
                if (!empty($toDelete)) {
                    $event->packages()->whereIn('id', $toDelete)->delete();
                }

                foreach ($packages as $pkg) {
                    $payload = [
                        'name' => $pkg['name'] ?? '',
                        'price' => $pkg['price'] ?? 0,
                        'group_size' => $pkg['group_size'] ?? 1,
                        'available_tickets' => $pkg['available_tickets'] ?? null,
                        'description' => $pkg['description'] ?? null,
                        'icon' => $pkg['icon'] ?? '🎫',
                    ];

                    if (!empty($pkg['id']) && in_array((int) $pkg['id'], $existingIds, true)) {
                        $event->packages()->where('id', (int) $pkg['id'])->update($payload);
                    } else {
                        $event->packages()->create($payload);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.events.index')
                ->with('success', 'Event updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update event: ' . $e->getMessage()])->withInput();
        }
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

    /**
     * Send an email broadcast to attendees of a specific event.
     */
    public function emailAttendees(Request $request, Event $event)
    {
        $authCheck = $this->checkAuth();
        if ($authCheck) return $authCheck;

        $validated = $request->validate([
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
            'include_pending' => 'nullable|boolean',
            'include_promo' => 'nullable|boolean',
            'audience' => 'nullable|in:event_attendees,all_system',
            'photo_urls' => 'nullable|string',
            'feedback_form_url' => 'nullable|string|max:1000',
        ]);

        $includePending = $request->boolean('include_pending');
        $includePromo = $request->boolean('include_promo');
        $audience = $validated['audience'] ?? 'event_attendees';

        if ($audience === 'all_system') {
            $recipientEmails = $this->extractAllSystemEmails($includePending);
        } else {
            $bookingsQuery = $event->bookings();
            if ($includePending) {
                $bookingsQuery->whereIn('payment_status', ['confirmed', 'pending']);
            } else {
                $bookingsQuery->where('payment_status', 'confirmed');
            }

            $bookings = $bookingsQuery->get();
            $recipientEmails = $this->extractAttendeeEmails($bookings);
        }

        if (empty($recipientEmails)) {
            $audienceLabel = $audience === 'all_system' ? 'all system people' : 'this event audience';
            return back()->withErrors([
                'message' => "No email recipients found for {$audienceLabel} with the selected filters.",
            ])->withInput();
        }

        $mainMessage = trim($validated['message']);
        $promoMessage = $includePromo ? $this->buildCommissionPromoMessage() : '';
        $supplementalMessage = $this->buildMediaAndFeedbackBlock(
            $validated['photo_urls'] ?? '',
            $validated['feedback_form_url'] ?? ''
        );

        $sentCount = 0;
        $failedCount = 0;

        foreach ($recipientEmails as $email) {
            try {
                Mail::to($email)->send(new EventAttendeesBroadcast(
                    $event,
                    $validated['subject'],
                    $mainMessage,
                    $promoMessage,
                    $supplementalMessage
                ));
                $sentCount++;
            } catch (\Throwable $e) {
                $failedCount++;
                Log::error('Failed to send attendee broadcast email', [
                    'event_id' => $event->id,
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $statusMessage = "Email campaign sent. Successful: {$sentCount}";
        if ($failedCount > 0) {
            $statusMessage .= " | Failed: {$failedCount}";
        }

        return redirect()
            ->route('admin.events.show', $event)
            ->with('success', $statusMessage);
    }

    /**
     * Build unique list of attendee emails from bookings.
     */
    private function extractAttendeeEmails($bookings): array
    {
        $emails = [];

        foreach ($bookings as $booking) {
            if (!empty($booking->team_lead_email) && filter_var($booking->team_lead_email, FILTER_VALIDATE_EMAIL)) {
                $emails[] = strtolower(trim($booking->team_lead_email));
            }

            if (!empty($booking->members) && is_array($booking->members)) {
                foreach ($booking->members as $member) {
                    $memberEmail = $member['email'] ?? null;
                    if (!empty($memberEmail) && filter_var($memberEmail, FILTER_VALIDATE_EMAIL)) {
                        $emails[] = strtolower(trim($memberEmail));
                    }
                }
            }
        }

        return array_values(array_unique($emails));
    }

    /**
     * Build promotional commission block.
     */
    private function buildCommissionPromoMessage(): string
    {
        return "From Tikoikoon Technologies:\n" .
            "Tikoikoon Technologies is expanding through strategic event partnerships. If you bring us an event, you become the exclusive manager for that specific event.\n" .
            "You will earn a 20% commission on revenue generated from that event.";
    }

    /**
     * Build optional section with event photos and attendee feedback form.
     */
    private function buildMediaAndFeedbackBlock(string $photoUrlsRaw, string $feedbackFormUrl): string
    {
        $sections = [];

        $photoUrls = preg_split('/[\r\n,]+/', $photoUrlsRaw) ?: [];
        $photoUrls = array_values(array_filter(array_map(function ($url) {
            $url = trim($url);
            return filter_var($url, FILTER_VALIDATE_URL) ? $url : null;
        }, $photoUrls)));

        if (!empty($photoUrls)) {
            $photoLines = array_map(function ($url) {
                return "- {$url}";
            }, $photoUrls);

            $sections[] = "Event Photo Gallery Links:\n" . implode("\n", $photoLines);
        }

        if (!empty($feedbackFormUrl) && filter_var($feedbackFormUrl, FILTER_VALIDATE_URL)) {
            $sections[] = "Attendee Feedback Form (Google Form):\n{$feedbackFormUrl}";
        }

        if (empty($sections)) {
            return '';
        }

        return implode("\n\n", $sections) . "\n\nShared by Tikoikoon Technologies on tikoikoon.co.ke";
    }

    /**
     * Build recipient list for all people in the system.
     */
    private function extractAllSystemEmails(bool $includePending): array
    {
        $emails = [];

        $emails = array_merge(
            $emails,
            User::query()->pluck('email')->toArray(),
            Manager::query()->pluck('email')->toArray()
        );

        $bookingsQuery = Booking::query();
        if ($includePending) {
            $bookingsQuery->whereIn('payment_status', ['confirmed', 'pending']);
        } else {
            $bookingsQuery->where('payment_status', 'confirmed');
        }

        $bookingEmails = $this->extractAttendeeEmails($bookingsQuery->get());
        $emails = array_merge($emails, $bookingEmails);

        $emails = array_filter(array_map(function ($email) {
            $email = strtolower(trim((string) $email));
            return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
        }, $emails));

        return array_values(array_unique($emails));
    }
}
