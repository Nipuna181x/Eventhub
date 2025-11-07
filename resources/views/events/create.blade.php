<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-semibold text-center mb-8 text-indigo-600 dark:text-indigo-400">
            Create Event
        </h1>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('events.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1" for="title">Event Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Enter event title"
                    class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="description">Description</label>
                <textarea id="description" name="description" placeholder="Event description" rows="3"
                    class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="location">Location</label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="Event venue/location"
                    class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="starts_at">Start Date & Time *</label>
                <input type="datetime-local" id="starts_at" name="starts_at" value="{{ old('starts_at') }}"
                    class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="ends_at">End Date & Time *</label>
                <input type="datetime-local" id="ends_at" name="ends_at" value="{{ old('ends_at') }}"
                    class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" required>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">End time must be after start time</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1" for="capacity">Capacity</label>
                <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" placeholder="Maximum attendees" min="1"
                    class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition transform hover:scale-[1.02] shadow-md hover:shadow-indigo-500/40">
                Create Event
            </button>
        </form>
    </div>
</body>
</html>