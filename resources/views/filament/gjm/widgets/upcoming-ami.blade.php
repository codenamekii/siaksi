{{-- Lokasi file: resources/views/filament/gjm/widgets/upcoming-ami.blade.php --}}

<x-filament-widgets::widget>
  <x-filament::section>
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-lg font-medium text-gray-900 dark:text-white">Jadwal AMI Mendatang</h2>
      <span class="text-sm text-gray-600 dark:text-gray-400">{{ now()->format('F Y') }}</span>
    </div>

    <div class="space-y-3">
      @forelse($this->getUpcomingAMI() as $jadwal)
        <div class="flex items-center justify-between p-3 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
          <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center">
                <span class="text-lg font-bold text-white">
                  {{ $jadwal->tanggal_mulai->format('d') }}
                </span>
              </div>
            </div>
            <div>
              <h4 class="font-medium text-gray-900 dark:text-white">{{ $jadwal->nama_kegiatan }}</h4>
              <p class="text-sm text-gray-600 dark:text-gray-300">
                {{ $jadwal->tanggal_mulai->format('d M') }} - {{ $jadwal->tanggal_selesai->format('d M Y') }}
              </p>
            </div>
          </div>
          <div class="flex items-center space-x-2">
            <span
              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $jadwal->status === 'scheduled'
                                ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400'
                                : ($jadwal->status === 'ongoing'
                                    ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400'
                                    : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400') }}">
              {{ ucfirst($jadwal->status) }}
            </span>
          </div>
        </div>
      @empty
        <div class="text-center py-6 text-gray-500 dark:text-gray-400">
          <p class="text-lg">Tidak ada jadwal AMI mendatang</p>
        </div>
      @endforelse
    </div>
  </x-filament::section>
</x-filament-widgets::widget>