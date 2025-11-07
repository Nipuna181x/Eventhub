<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Success/Error Messages --}}
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        <h1 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $event->title }}</h1>
                        @if($event->description)
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $event->description }}</p>
                        @endif

                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                            @if($event->location)
                                <div>
                                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Location</div>
                                    <div class="text-gray-700 dark:text-gray-200">{{ $event->location }}</div>
                                </div>
                            @endif

                            <div>
                                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Starts</div>
                                <div class="text-gray-700 dark:text-gray-200">{{ $event->starts_at->format('M d, Y @ g:i A') }}</div>
                            </div>

                            <div>
                                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Ends</div>
                                <div class="text-gray-700 dark:text-gray-200">{{ $event->ends_at->format('M d, Y @ g:i A') }}</div>
                            </div>

                            @if($event->capacity)
                                <div>
                                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400">Capacity</div>
                                    <div class="text-gray-700 dark:text-gray-200">{{ $event->capacity }} attendees</div>
                                </div>
                            @endif
                        </div>

                        {{-- Role-based actions --}}
                        <div class="mt-6 flex flex-wrap gap-3">
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('events.edit', $event) }}"
                                       class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg transition">
                                        Edit Event
                                    </a>

                                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this event?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-block bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
                                            Delete Event
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('events.rsvp', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition">
                                            RSVP to Event
                                        </button>
                                    </form>
                                @endif
                            @else
                                <p class="text-sm text-gray-500">Please <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">log in</a> to RSVP.</p>
                            @endauth
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('events.index') }}" class="text-sm text-indigo-600 hover:underline">Back to Events</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>