<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Event Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.9/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.9/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.9/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.9/index.global.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                height: 800,
                events: "{{ route('events.calendar-data') }}",
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'short'
                },
                eventDisplay: 'block',
                displayEventEnd: true,
                eventClick: function(info) {
                    window.location.href = "/events/" + info.event.id;
                }
            });
            calendar.render();
        });
    </script>

    <style>
        .fc {
            background-color: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .fc-toolbar-title {
            font-size: 1.5em !important;
            font-weight: 600;
        }
        .fc-button {
            background-color: #4F46E5 !important;
            border: none !important;
        }
        .fc-button:hover {
            background-color: #4338CA !important;
        }
        .fc-button-active {
            background-color: #3730A3 !important;
        }
        .dark .fc {
            background-color: #1F2937;
            color: #E5E7EB;
        }
        .dark .fc-button {
            background-color: #374151 !important;
        }
        .dark .fc-button:hover {
            background-color: #4B5563 !important;
        }
        .dark .fc-button-active {
            background-color: #6B7280 !important;
        }
    </style>
    @endpush
</x-app-layout>