?>
<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            AMI Mendatang
        </x-slot>

        <x-slot name="headerEnd">
            <x-filament::link 
                href="{{ \App\Filament\Gjm\Resources\JadwalAMIResource::getUrl() }}"
                size="sm"
            >
                Lihat Semua
            </x-filament::link>
        </x-slot>

        <div class="space-y-3">
            @forelse($upcomingAMI as $ami)
                <div class="border-l-4 border-warning-500 pl-3 py-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-sm">{{ $ami->nama_kegiatan }}</p>
                            <p class="text-xs text-gray-600">
                                {{ $ami->programStudi?->nama ?? 'Tingkat Fakultas' }}
                            </p>
                        </div>
                        <span class="text-xs text-gray-500">
                            {{ $ami->tanggal_mulai->diffForHumans() }}
                        </span>
                    </div>
                    <div class="mt-1">
                        <p class="text-xs text-gray-500">
                            📅 {{ $ami->tanggal_mulai->format('d M') }} - {{ $ami->tanggal_selesai->format('d M Y') }}
                        </p>
                        @if($ami->tempat)
                            <p class="text-xs text-gray-500">📍 {{ $ami->tempat }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 text-center py-4">
                    Tidak ada jadwal AMI mendatang
                </p>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

<?php