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
                    {{-- Flash messages --}}
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
                        <h1 class="text-2xl font-bold text-indigo-600">{{ $event->title }}</h1>
                        @if($event->description)
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $event->description }}</p>
                        @endif

                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            @if($event->location)
                                <div>
                                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Location
                                    </div>
                                    <div class="text-gray-700 dark:text-gray-200">{{ $event->location }}</div>
                                </div>
                            @endif

                            <div>
                                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Starts
                                </div>
                                <div class="text-gray-700 dark:text-gray-200">{{ $event->starts_at->format('M d, Y @ g:i A') }}</div>
                            </div>

                            <div>
                                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Ends
                                </div>
                                <div class="text-gray-700 dark:text-gray-200">{{ $event->ends_at->format('M d, Y @ g:i A') }}</div>
                            </div>

                            <div>
                                <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-2M9 20H4v-2a3 3 0 013-3h2m6-7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    Capacity
                                </div>
                                <div class="text-gray-700 dark:text-gray-200">@if($event->capacity) {{ $event->attendees()->count() }} / {{ $event->capacity }} attending @else Unlimited @endif</div>
                            </div>
                        </div>

                        {{-- Admin-only: Attending and Waitlist --}}
                        @auth
                            @if(auth()->user()->isAdmin())
                                @php
                                    $attending = $event->attendees()->with('user')->get();
                                    $waitlist = $event->waitlist()->with('user')->get();
                                @endphp

                                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Attending</h3>
                                        @if($attending->isEmpty())
                                            <p class="text-sm text-gray-500">No attendees yet.</p>
                                        @else
                                            <ul class="space-y-2">
                                                @foreach($attending as $rsvp)
                                                    <li class="text-gray-700 dark:text-gray-100">{{ $rsvp->user->name ?? '—' }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>

                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3">Waitlist</h3>
                                        @if($waitlist->isEmpty())
                                            <p class="text-sm text-gray-500">No one on the waitlist.</p>
                                        @else
                                            <ul class="space-y-2">
                                                @foreach($waitlist as $rsvp)
                                                    <li class="text-gray-700 dark:text-gray-100">{{ $rsvp->user->name ?? '—' }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endauth

                        {{-- Actions --}}
                        <div class="mt-6 flex flex-wrap gap-3">
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg">
                                        Edit Event
                                    </a>

                                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg">
                                            Delete Event
                                        </button>
                                    </form>
                                @else
                                    @php $userRsvpStatus = $event->getUserRsvpStatus(auth()->id()); @endphp

                                    @if($userRsvpStatus === 'attending')
                                        <div class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg">You are attending</div>
                                        <form action="{{ route('events.cancel-rsvp', $event) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg">Cancel RSVP</button>
                                        </form>

                                    @elseif($userRsvpStatus === 'waitlist')
                                        <div class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-lg">On waitlist</div>
                                        <form action="{{ route('events.cancel-rsvp', $event) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg">Leave Waitlist</button>
                                        </form>

                                    @else
                                        @if(!$event->isFull())
                                            <form action="{{ route('events.rsvp', $event) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">RSVP to Event</button>
                                            </form>
                                        @else
                                            <form action="{{ route('events.waitlist', $event) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg">Join Waitlist</button>
                                            </form>
                                        @endif
                                    @endif
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