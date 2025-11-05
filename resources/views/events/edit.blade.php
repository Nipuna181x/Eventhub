<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-semibold text-center mb-8 text-indigo-600 dark:text-indigo-400">
            Edit Event
        </h1>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('events.update', $event) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1" for="title">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" placeholder="Enter event title"
                    class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="description">Description</label>
                <textarea id="description" name="description" placeholder="Event description" rows="3"
                    class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="venue">Venue</label>
                    <input type="text" id="venue" name="venue" value="{{ old('venue', $event->location) }}" placeholder="Event location"
                        class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="capacity">Capacity</label>
                    <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $event->capacity) }}" placeholder="Number of seats" min="1"
                        class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1" for="date">Date</label>
                    <input type="date" id="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($event->starts_at)->format('Y-m-d')) }}"
                        class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1" for="time">Time</label>
                    <input type="time" id="time" name="time" value="{{ old('time', \Carbon\Carbon::parse($event->starts_at)->format('H:i')) }}"
                        class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition transform hover:scale-[1.02] shadow-md hover:shadow-indigo-500/40">
                    Update Event
                </button>
                <a href="{{ route('events.show', $event) }}"
                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-2.5 rounded-lg transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>