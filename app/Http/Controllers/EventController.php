<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Rsvp;


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
 * RSVP to an event
 */
public function rsvp(Event $event)
{
    $user = auth()->user();

    // Check if user is admin
    if ($user->isAdmin()) {
        return redirect()->back()
                         ->with('error', 'Admins cannot RSVP to events.');
    }

    // Check if user already RSVPed
    if ($event->hasUserRsvped($user->id)) {
        return redirect()->back()
                         ->with('error', 'You have already RSVPed to this event.');
    }

    // Check if event is full
    if ($event->isFull()) {
        return redirect()->back()
                         ->with('error', 'This event is at full capacity. Please join the waitlist instead.');
    }

    // Create RSVP
    Rsvp::create([
        'user_id' => $user->id,
        'event_id' => $event->id,
        'status' => 'attending',
    ]);

    return redirect()->back()
                     ->with('success', 'Successfully RSVPed! See you at the event!');
}

/**
 * Join event waitlist
 */
public function joinWaitlist(Event $event)
{
    $user = auth()->user();

    // Check if user is admin
    if ($user->isAdmin()) {
        return redirect()->back()
                         ->with('error', 'Admins cannot join waitlists.');
    }

    // Check if user already RSVPed
    if ($event->hasUserRsvped($user->id)) {
        return redirect()->back()
                         ->with('error', 'You have already RSVPed to this event.');
    }

    // Create waitlist RSVP
    Rsvp::create([
        'user_id' => $user->id,
        'event_id' => $event->id,
        'status' => 'waitlist',
    ]);

    return redirect()->back()
                     ->with('success', 'Added to waitlist! We\'ll notify you if a spot opens up.');
}

/**
 * Cancel RSVP
 */
public function cancelRsvp(Event $event)
{
    $user = auth()->user();

    // Find and delete the RSVP
    $rsvp = Rsvp::where('user_id', $user->id)
                ->where('event_id', $event->id)
                ->first();

    if (!$rsvp) {
        return redirect()->back()
                         ->with('error', 'You have not RSVPed to this event.');
    }

    $wasAttending = $rsvp->status === 'attending';
    $rsvp->delete();

    // If user was attending and there's waitlist, promote first waitlist member
    if ($wasAttending && $event->waitlist()->exists()) {
        $firstWaitlist = $event->waitlist()->oldest()->first();
        $firstWaitlist->update(['status' => 'attending']);
        
        return redirect()->back()
                         ->with('success', 'Your RSVP has been cancelled. The first person on the waitlist has been promoted.');
    }

    return redirect()->back()
                     ->with('success', 'Your RSVP has been cancelled.');
}

/**
 * Show user's RSVPed events
 */
public function myRsvps()
{
    $user = auth()->user();

    // Get all events user has RSVPed to, with their RSVP status
    $rsvps = Rsvp::where('user_id', $user->id)
                 ->with('event')
                 ->orderBy('created_at', 'desc')
                 ->get();

    // Separate attending and waitlist
    $attendingEvents = $rsvps->where('status', 'attending');
    $waitlistEvents = $rsvps->where('status', 'waitlist');

    return view('events.my-rsvps', compact('attendingEvents', 'waitlistEvents'));
}
}