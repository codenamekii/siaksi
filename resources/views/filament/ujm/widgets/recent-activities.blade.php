<x-filament-widgets::widget>
  <x-filament::section>
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-lg font-medium">Aktivitas Terbaru</h2>
    </div>

    <div class="space-y-3">
      @forelse($this->getRecentActivities() as $activity)
        <div class="flex items-start space-x-3 p-3 bg-gray-700 rounded-lg hover:bg-gray-100 transition">
          <div class="flex-shrink-0">
            <div
              class="w-10 h-10 {{ $activity['color'] === 'blue' ? 'bg-blue-100' : ($activity['color'] === 'green' ? 'bg-green-100' : 'bg-purple-100') }} rounded-lg flex items-center justify-center">
              <x-dynamic-component :component="$activity['icon']"
                class="w-5 h-5 {{ $activity['color'] === 'blue' ? 'text-blue-600' : ($activity['color'] === 'green' ? 'text-green-600' : 'text-purple-600') }}" />
            </div>
          </div>
          <div class="flex-1">
            <h4 class="font-medium text-gray-900 line-clamp-1">{{ $activity['title'] }}</h4>
            <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $activity['created_at']->diffForHumans() }}</p>
          </div>
        </div>
      @empty
        <div class="text-center py-6 text-gray-500">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <p class="mt-2">Belum ada aktivitas terbaru</p>
        </div>
      @endforelse
    </div>
  </x-filament::section>
</x-filament-widgets::widget>
