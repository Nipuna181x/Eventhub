<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $event->title }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 text-white flex justify-center items-center min-h-screen">
    <div class="max-w-lg w-full bg-gray-800 rounded-2xl shadow-xl p-8">
        <h1 class="text-3xl font-bold mb-4 text-indigo-400">{{ $event->title }}</h1>
        <p class="text-gray-300 mb-4">{{ $event->description }}</p>
        <p class="mb-2"><span class="font-semibold">📍 Venue:</span> {{ $event->venue ?? $event->location }}</p>
        <p class="mb-2"><span class="font-semibold">📅 Date:</span> {{ $event->date ?? $event->starts_at }}</p>
        <p class="mb-6"><span class="font-semibold">🕒 Time:</span> {{ $event->time ?? $event->ends_at }}</p>
        <a href="{{ route('events.index') }}" class="text-indigo-400 hover:underline">← Back to Events</a>
    </div>
</body>
</html>-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $event->title }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 text-white flex justify-center items-center min-h-screen">
    <div class="max-w-lg w-full bg-gray-800 rounded-2xl shadow-xl p-8">
        <h1 class="text-3xl font-bold mb-4 text-indigo-400">{{ $event->title }}</h1>
        <p class="text-gray-300 mb-4">{{ $event->description }}</p>
        <p class="mb-2"><span class="font-semibold">📍 Venue:</span> {{ $event->location }}</p>
        <p class="mb-2"><span class="font-semibold">📅 Date:</span> {{ $event->starts_at }}</p>
        <p class="mb-6"><span class="font-semibold">🕒 Time:</span> {{ $event->ends_at }}</p>

        {{-- Role-based buttons section --}}
        <div class="flex gap-3 mb-6">
            @auth
                @if(auth()->user()->isAdmin())
                    {{-- Admin buttons: Edit and Delete --}}
                    <a href="{{ route('events.edit', $event) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                        ✏️ Edit Event
                    </a>
                    
                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this event?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                            🗑️ Delete Event
                        </button>
                    </form>
                @else
                    {{-- User button: RSVP --}}
                    <form action="{{ route('events.rsvp', $event) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                            ✓ RSVP to Event
                        </button>
                    </form>
                @endif
            @else
                {{-- Not logged in --}}
                <p class="text-gray-400">Please <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">login</a> to RSVP</p>
            @endauth
        </div>

        <a href="{{ route('events.index') }}" class="text-indigo-400 hover:underline">← Back to Events</a>
    </div>
</body>
</html>
