<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium">Akses Dashboard Asesor</h2>
                <p class="text-sm text-gray-600">Lihat dashboard dari perspektif asesor</p>
            </div>
            
            <x-filament::button
                wire:click="goToAsesorDashboard"
                icon="heroicon-o-eye"
                color="info"
            >
                Masuk sebagai GJM
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>