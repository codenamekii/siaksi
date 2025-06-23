<x-filament-widgets::widget>
  <x-filament::section>
    <x-slot name="heading">
      Pusat Informasi
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Notifikasi Dokumen -->
      <div class="space-y-4">
        <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
          <x-heroicon-o-bell class="w-5 h-5 text-primary-500" />
          Notifikasi Dokumen Terbaru
        </h3>

        @if ($this->getNotifications()->count() > 0)
          <div class="space-y-3">
            @foreach ($this->getNotifications() as $notification)
              <div
                class="p-3 bg-warning-50 dark:bg-warning-900/20 rounded-lg border border-warning-200 dark:border-warning-800">
                <div class="flex justify-between items-start">
                  <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                      {{ $notification->data['dokumen_nama'] ?? 'Dokumen Baru' }}
                    </p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                      Oleh: {{ $notification->data['uploader_name'] ?? 'Unknown' }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                      {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                    </p>
                  </div>
                  <button wire:click="markNotificationAsRead('{{ $notification->id }}')"
                    class="text-xs text-primary-600 hover:text-primary-500">
                    <x-heroicon-o-check class="w-4 h-4" />
                  </button>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi baru</p>
        @endif
      </div>

      <!-- Jadwal AMI -->
      <div class="space-y-4">
        <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
          <x-heroicon-o-calendar-days class="w-5 h-5 text-success-500" />
          Jadwal AMI Mendatang
        </h3>

        @if ($this->getUpcomingAMI()->count() > 0)
          <div class="space-y-3">
            @foreach ($this->getUpcomingAMI() as $jadwal)
              <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                  {{ $jadwal->nama_kegiatan }}
                </p>
                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                  {{ $jadwal->programStudi->nama ?? ($jadwal->fakultas->nama ?? 'Unknown') }}
                </p>
                <p class="text-xs text-primary-600 dark:text-primary-400 mt-1">
                  {{ $jadwal->tanggal_mulai->format('d M Y') }}
                </p>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada jadwal AMI mendatang</p>
        @endif
      </div>

      <!-- Recent Documents -->
      <div class="space-y-4">
        <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
          <x-heroicon-o-document-text class="w-5 h-5 text-info-500" />
          Dokumen Terbaru
        </h3>

        @if ($this->getRecentDocuments()->count() > 0)
          <div class="space-y-3">
            @foreach ($this->getRecentDocuments() as $dokumen)
              <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                  {{ $dokumen->nama }}
                </p>
                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                  {{ $dokumen->kategori_label }} • {{ $dokumen->user->name }}
                </p>
                <div class="flex items-center gap-2 mt-1">
                  <span
                    class="text-xs px-2 py-0.5 rounded-full {{ $dokumen->level === 'prodi' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                    {{ ucfirst($dokumen->level) }}
                  </span>
                  <span class="text-xs text-gray-500">
                    {{ $dokumen->created_at->diffForHumans() }}
                  </span>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada dokumen</p>
        @endif
      </div>
    </div>
  </x-filament::section>
</x-filament-widgets::widget>
