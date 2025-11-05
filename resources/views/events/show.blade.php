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
        <p class="mb-2"><span class="font-semibold">📍 Venue:</span> {{ $event->venue ?? $event->location }}</p>
        <p class="mb-2"><span class="font-semibold">📅 Date:</span> {{ $event->date ?? $event->starts_at }}</p>
        <p class="mb-6"><span class="font-semibold">🕒 Time:</span> {{ $event->time ?? $event->ends_at }}</p>
        <a href="{{ route('events.index') }}" class="text-indigo-400 hover:underline">← Back to Events</a>
    </div>
</body>
</html>
