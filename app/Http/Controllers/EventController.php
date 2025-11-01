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
}
