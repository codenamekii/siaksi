{{-- Lokasi file: resources/views/filament/ujm/widgets/asesor-access-widget.blade.php --}}

<x-filament-widgets::widget>
  <x-filament::section>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Asesor</h3>
          <p class="mt-2 text-gray-600 dark:text-gray-400">
            Akses dashboard asesor untuk melihat dokumen akreditasi dan informasi penilaian
          </p>
        </div>
        <div class="flex-shrink-0">
          <a href="{{ url('/ujm/asesor-access') }}"
            class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transform hover:scale-105 transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            Buka Dashboard Asesor
          </a>
        </div>
      </div>
    </div>

    {{-- Return Button if coming from another dashboard --}}
    @if (session('ujm_original_user'))
      <div class="mt-4">
        <a href="{{ url('/ujm/return-to-original') }}"
          class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
            </path>
          </svg>
          Kembali ke Dashboard UJM
        </a>
      </div>
    @endif
  </x-filament::section>
</x-filament-widgets::widget>