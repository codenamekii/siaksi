?>
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-4">
            @if($programStudi)
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $programStudi->nama }}</h3>
                    <p class="text-sm text-gray-600">{{ $programStudi->kode }} - {{ $programStudi->jenjang }}</p>
                </div>

                @if($programStudi->visi)
                    <div>
                        <h4 class="font-medium text-gray-700">Visi:</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $programStudi->visi }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <p class="text-sm text-gray-500">Kepala Program Studi</p>
                        <p class="font-medium">{{ $programStudi->kaprodi ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ $programStudi->email ?? 'Belum diisi' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Telepon</p>
                        <p class="font-medium">{{ $programStudi->telepon ?? 'Belum diisi' }}</p>
                    </div>
                </div>
            @else
                <p class="text-gray-500">User belum terhubung dengan program studi.</p>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>