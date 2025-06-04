<x-filament-widgets::widget>
  <x-filament::section>
    <div class="space-y-4">
      {{-- Header --}}
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-medium">Akses Dashboard</h2>
      </div>

      {{-- Asesor Dashboard Button --}}
      <div class="p-4 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg">
        <div class="flex items-center justify-between text-white">
          <div>
            <h3 class="text-xl font-semibold">Dashboard Asesor</h3>
            <p class="text-sm opacity-90">Akses ke dashboard asesor untuk melihat dokumen</p>
          </div>
          <a href="{{ url('/gjm/login-as-asesor') }}"
            class="inline-flex items-center px-4 py-2 bg-white text-purple-600 font-semibold rounded-lg hover:bg-gray-100 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            Buka Dashboard
          </a>
        </div>
      </div>

      {{-- UJM List --}}
      <div>
        <h3 class="text-lg font-medium mb-3">Dashboard UJM Program Studi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          @foreach ($this->getUjmUsers() as $ujm)
            <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-lg transition">
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <h4 class="font-semibold text-gray-900">{{ $ujm->name }}</h4>
                  <p class="text-sm text-gray-600 mt-1">
                    {{ $ujm->programStudi?->nama ?? 'No Program Studi' }}
                  </p>
                  @if ($ujm->programStudi?->fakultas)
                    <p class="text-xs text-gray-500 mt-1">
                      {{ $ujm->programStudi->fakultas->nama }}
                    </p>
                  @endif
                  <p class="text-xs text-gray-400 mt-2">{{ $ujm->email }}</p>
                </div>
              </div>
              <div class="mt-3">
                <a href="{{ url('/gjm/login-as-ujm/' . $ujm->id) }}"
                  class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition">
                  <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                    </path>
                  </svg>
                  Akses Dashboard
                </a>
              </div>
            </div>
          @endforeach
        </div>

        @if ($this->getUjmUsers()->isEmpty())
          <div class="text-center py-8 text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
              </path>
            </svg>
            <p class="mt-2">Belum ada UJM yang terdaftar</p>
          </div>
        @endif
      </div>
    </div>
  </x-filament::section>
</x-filament-widgets::widget>
