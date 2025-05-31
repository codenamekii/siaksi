?>
<x-filament-widgets::widget>
  <x-filament::section>
    <x-slot name="heading">
      Aktivitas Terbaru
    </x-slot>

    <div class="space-y-3">
      @forelse($activities as $activity)
        <div class="flex items-start space-x-3">
          <div class="flex-shrink-0">
            <div class="p-2 bg-{{ $activity['color'] }}-100 rounded-full">
              <x-dynamic-component :component="'heroicon-o-' . str_replace('heroicon-o-', '', $activity['icon'])" class="w-4 h-4 text-{{ $activity['color'] }}-600" />
            </div>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 truncate">
              {{ $activity['title'] }}
            </p>
            <p class="text-xs text-gray-500">
              {{ ucfirst($activity['type']) }} • {{ $activity['date']->diffForHumans() }}
            </p>
          </div>
        </div>
      @empty
        <p class="text-sm text-gray-500 text-center py-4">
          Belum ada aktivitas terbaru
        </p>
      @endforelse
    </div>
  </x-filament::section>
</x-filament-widgets::widget>
