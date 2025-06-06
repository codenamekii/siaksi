{{-- Lokasi file: resources/views/filament/gjm/widgets/jadwal-ami-calendar.blade.php --}}

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-3">
            <h2 class="text-lg font-medium">Jadwal AMI Terdekat</h2>
            
            <div class="space-y-2">
                @forelse($jadwalAMI as $jadwal)
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-3 hover:shadow-sm transition">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex-1">
                                <h3 class="font-medium text-sm text-gray-900 dark:text-white">{{ $jadwal->nama_kegiatan }}</h3>
                                <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1 text-xs text-gray-600 dark:text-gray-400">
                                    <span>📅 {{ $jadwal->tanggal_mulai->format('d M Y') }} - {{ $jadwal->tanggal_selesai->format('d M Y') }}</span>
                                    <span>📍 {{ $jadwal->tempat ?? 'Belum ditentukan' }}</span>
                                    <span>🎯 {{ $jadwal->programStudi?->nama ?? 'Tingkat Fakultas' }}</span>
                                </div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full flex-shrink-0
                                {{ $jadwal->status === 'ongoing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                {{ $jadwal->status === 'ongoing' ? 'Berlangsung' : 'Terjadwal' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                        Tidak ada jadwal AMI terdekat
                    </div>
                @endforelse
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>