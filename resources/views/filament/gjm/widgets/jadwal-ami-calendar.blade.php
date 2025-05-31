?>
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-4">
            <h2 class="text-lg font-medium">Kalender AMI Terdekat</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($jadwalAMI as $jadwal)
                    <div class="bg-white border rounded-lg p-4 shadow-sm">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-sm">{{ $jadwal->nama_kegiatan }}</h3>
                            <span class="text-xs px-2 py-1 rounded-full 
                                {{ $jadwal->status === 'ongoing' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $jadwal->status === 'ongoing' ? 'Berlangsung' : 'Terjadwal' }}
                            </span>
                        </div>
                        
                        <div class="space-y-1 text-xs text-gray-600">
                            <p>📅 {{ $jadwal->tanggal_mulai->format('d M Y') }} - {{ $jadwal->tanggal_selesai->format('d M Y') }}</p>
                            <p>📍 {{ $jadwal->tempat ?? 'Belum ditentukan' }}</p>
                            <p>🎯 {{ $jadwal->programStudi?->nama ?? 'Tingkat Fakultas' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500">
                        Tidak ada jadwal AMI terdekat
                    </div>
                @endforelse
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>