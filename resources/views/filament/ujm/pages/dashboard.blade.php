<x-filament-panels::page>
  @if (Auth::user()->role === 'gjm')
    <div class="mb-6">
      <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg shadow-lg">
        <div class="px-6 py-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <x-heroicon-o-shield-check class="w-8 h-8" />
              <div>
                <h3 class="text-lg font-semibold">Mode Super Admin</h3>
                <p class="text-sm text-blue-100">Anda sedang melihat dashboard UJM sebagai GJM</p>
              </div>
            </div>
            <x-filament::button href="/gjm" tag="a" color="white" size="sm" icon="heroicon-o-arrow-left">
              Kembali ke GJM
            </x-filament::button>
          </div>
        </div>
      </div>
    </div>
  @endif

  <x-filament-widgets::widgets :widgets="$this->getVisibleWidgets()" :columns="$this->getColumns()" />
</x-filament-panels::page>
