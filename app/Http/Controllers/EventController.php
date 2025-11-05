<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use Illuminate\Http\Request;


class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->venue, // field name from form
            'starts_at' => $request->date . ' ' . $request->time,
            'ends_at' => $request->date . ' ' . $request->time, // we will improve later
            'capacity' => $request->capacity,
            'user_id' => auth()->id(),
        ]);
        

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    //newwwww
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
            'description' => 'required',
            'location' => 'required|max:255',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'capacity' => 'required|integer|min:1',
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
