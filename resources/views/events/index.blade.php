<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end items-center mb-6">
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
                <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                    No events available.
                </div>
            @else
                <div class="max-w-4xl mx-auto space-y-6">
                    @foreach($events as $event)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-gray-200 dark:border-gray-700">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                                        {{ $event->title }}
                                    </h3>
                                    <div class="space-y-2 text-gray-600 dark:text-gray-300">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="font-medium">{{ $event->location }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($event->starts_at)->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($event->starts_at)->format('g:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex gap-3 md:flex-col md:items-end">
                                    <a href="{{ route('events.show', $event->id) }}"
                                       class="inline-flex items-center justify-center w-full md:w-40 h-11 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </a>

                                    @if(auth()->check() && auth()->user()->role === 'admin')
                                        <a href="{{ route('events.edit', $event->id) }}"
                                           class="inline-flex items-center justify-center w-full md:w-40 h-11 px-6 bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 whitespace-nowrap">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit Event
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
