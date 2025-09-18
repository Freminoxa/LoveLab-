<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Manager;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
	public function index()
	{
		$events = Event::with('manager', 'packages')->get();
		return view('admin.events.index', compact('events'));
	}

	public function show(Event $event)
	{
		$event->load('manager', 'packages');
		return view('admin.events.show', compact('event'));
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
			'poster' => 'nullable|image',
			'manager_id' => 'nullable|exists:managers,id',
			'payment_confirmed' => 'nullable|boolean',
		]);

		if ($request->hasFile('poster')) {
			$validated['poster'] = $request->file('poster')->store('posters', 'public');
		}

		$event = Event::create([
			'name' => $validated['name'],
			'date' => $validated['date'],
			'location' => $validated['location'],
			'poster' => $validated['poster'] ?? null,
			'manager_id' => $validated['manager_id'] ?? null,
			'payment_confirmed' => $validated['payment_confirmed'] ?? false,
		]);

		// Optionally, attach packages logic here

		return redirect()->route('admin.events.index')->with('success', 'Event created successfully!');
	}

	public function edit(Event $event)
	{
		$managers = Manager::all();
		return view('admin.events.edit', compact('event', 'managers'));
	}

	public function update(Request $request, Event $event)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'date' => 'required|date',
			'location' => 'required|string|max:255',
			'poster' => 'nullable|image',
			'manager_id' => 'nullable|exists:managers,id',
			'payment_confirmed' => 'nullable|boolean',
		]);

		if ($request->hasFile('poster')) {
			$validated['poster'] = $request->file('poster')->store('posters', 'public');
		}

		$event->update([
			'name' => $validated['name'],
			'date' => $validated['date'],
			'location' => $validated['location'],
			'poster' => $validated['poster'] ?? $event->poster,
			'manager_id' => $validated['manager_id'] ?? $event->manager_id,
			'payment_confirmed' => $validated['payment_confirmed'] ?? $event->payment_confirmed,
		]);

		return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
	}

	public function destroy(Event $event)
	{
		if ($event->poster) {
			Storage::disk('public')->delete($event->poster);
		}
		$event->delete();
		return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully!');
	}
}
