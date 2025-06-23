{{-- resources/views/filament/gjm/widgets/jadwal-ami-calendar.blade.php --}}
<x-filament-widgets::widget>
  <x-filament::section>
    <x-slot name="heading">
      Kalender Jadwal AMI
    </x-slot>

    <div class="p-4">
      <div id="calendar-jadwal-ami" wire:ignore></div>
    </div>

    @push('scripts')
      <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          var calendarEl = document.getElementById('calendar-jadwal-ami');

          if (calendarEl) {
            var calendar = new FullCalendar.Calendar(calendarEl, {
              initialView: 'dayGridMonth',
              headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
              },
              events: @json($events),
              eventClick: function(info) {
                if (info.event.url) {
                  window.location.href = info.event.url;
                  info.jsEvent.preventDefault();
                }
              },
              eventDisplay: 'block',
              height: 'auto',
              locale: 'id',
              buttonText: {
                today: 'Hari ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari'
              }
            });

            calendar.render();
          }
        });
      </script>
    @endpush

    @push('styles')
      <style>
        #calendar-jadwal-ami {
          min-height: 400px;
        }

        .fc-event {
          cursor: pointer;
          padding: 2px 4px;
          border-radius: 4px;
          font-size: 0.875rem;
        }

        .fc-daygrid-event {
          white-space: normal;
        }
      </style>
    @endpush
  </x-filament::section>
</x-filament-widgets::widget>
