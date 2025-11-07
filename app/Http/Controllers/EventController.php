<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of events
     */
    public function index()
    {
        $events = Event::orderBy('starts_at', 'desc')->get();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event
     */
    public function create()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('events.create');
    }

    /**
     * Store a newly created event
     */
    public function store(Request $request)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'location' => 'nullable|max:255',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'capacity' => 'nullable|integer|min:1',
        ]);

        // Add the authenticated user's ID
        $validated['user_id'] = auth()->id();

        // Create the event
        Event::create($validated);

        return redirect()->route('events.index')
                         ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified event
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing an event
     */
    public function edit(Event $event)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('events.edit', compact('event'));
    }

    /**
     * Update the event
     */
    public function update(Request $request, Event $event)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'location' => 'nullable|max:255',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)
                         ->with('success', 'Event updated successfully!');
    }

    /**
     * Delete the event
     */
    public function destroy(Event $event)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $event->delete();

        return redirect()->route('events.index')
                         ->with('success', 'Event deleted successfully!');
    }

    /**
     * RSVP to an event (placeholder for now)
     */
    public function rsvp(Event $event)
    {
        // Check if user is NOT admin
        if (auth()->user()->isAdmin()) {
            return redirect()->back()
                             ->with('error', 'Admins cannot RSVP to events.');
        }

        // For now, just return a success message
        // Later when you create RSVP table, you'll add the logic here
        return redirect()->back()
                         ->with('success', 'RSVP functionality coming soon!');
    }
}