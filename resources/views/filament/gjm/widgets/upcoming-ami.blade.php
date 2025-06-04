<x-filament-widgets::widget>
  <x-filament::section>
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-lg font-medium">Jadwal AMI Mendatang</h2>
      <span class="text-sm text-gray-500">{{ now()->format('F Y') }}</span>
    </div>

    <div class="space-y-3">
      @forelse($this->getUpcomingAMI() as $jadwal)
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
          <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <span class="text-lg font-bold text-blue-600">
                  {{ $jadwal->tanggal_mulai->format('d') }}
                </span>
              </div>
            </div>
            <div>
              <h4 class="font-medium text-gray-900">{{ $jadwal->nama_kegiatan }}</h4>
              <p class="text-sm text-gray-500">
                {{ $jadwal->tanggal_mulai->format('d M') }} - {{ $jadwal->tanggal_selesai->format('d M Y') }}
              </p>
            </div>
          </div>
          <div class="flex items-center space-x-2">
            <span
              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $jadwal->status === 'scheduled'
                                ? 'bg-yellow-100 text-yellow-800'
                                : ($jadwal->status === 'ongoing'
                                    ? 'bg-blue-100 text-blue-800'
                                    : 'bg-green-100 text-green-800') }}">
              {{ ucfirst($jadwal->status) }}
            </span>
          </div>
        </div>
      @empty
        <div class="text-center py-6 text-gray-500">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
          <p class="mt-2">Tidak ada jadwal AMI mendatang</p>
        </div>
      @endforelse
    </div>
  </x-filament::section>
</x-filament-widgets::widget>
