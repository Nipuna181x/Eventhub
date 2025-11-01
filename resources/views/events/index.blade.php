<h1>Events</h1>

@auth
@if(auth()->user()->role === 'admin')
<a href="{{ route('events.create') }}">Create Event</a>
@endif
@endauth

@foreach($events as $event)
    <div>
        <h3>{{ $event->title }}</h3>
        <p>{{ $event->venue }} | {{ $event->date }} {{ $event->time }}</p>
        <a href="{{ route('events.show', $event->id) }}">View</a>
    </div>
@endforeach
