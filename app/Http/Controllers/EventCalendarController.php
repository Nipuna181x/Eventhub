<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventCalendarController extends Controller
{
    public function index()
    {
        return view('events.calendar');
    }

    public function getEvents()
    {
        try {
            $events = Event::all()->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->starts_at->format('Y-m-d\TH:i:s'),
                    'end' => $event->ends_at->format('Y-m-d\TH:i:s'),
                    'url' => route('events.show', $event->id)
                ];
            });

            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}