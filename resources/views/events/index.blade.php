<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col items-center p-6">

    <div class="w-full max-w-5xl">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">All Events</h1>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('events.create') }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-5 py-2 rounded-lg transition transform hover:scale-[1.03] shadow-md hover:shadow-indigo-500/40">
                        + Create Event
                    </a>
                @endif
            @endauth
        </div>

        @if($events->isEmpty())
            <div class="text-center text-gray-500 dark:text-gray-400">
                No events available.
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($events as $event)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-indigo-500/20 transition p-6">
                        <h3 class="text-xl font-semibold text-indigo-500 dark:text-indigo-400 mb-2">
                            {{ $event->title }}
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-4">
                            📍 {{ $event->venue }}<br>
                            🗓️ {{ $event->date }} at {{ $event->time }}
                        </p>

                        <div class="flex justify-between items-center mt-3">
                            <a href="{{ route('events.show', $event->id) }}"
                               class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                                View Details
                            </a>

                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <a href="{{ route('events.edit', $event->id) }}"
                                   class="text-gray-600 dark:text-gray-300 text-sm hover:text-indigo-400">
                                    ✏️ Edit
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>
