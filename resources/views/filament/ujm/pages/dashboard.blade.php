<x-filament-panels::page>
    @if (session('gjm_original_user'))
        <div class="mb-4">
            <x-filament::button
                color="info"
                icon="heroicon-o-arrow-left"
                href="{{ route('return.to.original') }}"
                tag="a"
            >
                Kembali ke Dashboard GJM
            </x-filament::button>
        </div>
    @endif

    <x-filament-widgets::widgets
        :widgets="$this->getVisibleWidgets()"
        :columns="$this->getColumns()"
    />
</x-filament-panels::page>