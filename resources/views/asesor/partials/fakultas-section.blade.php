<!-- Fakultas Section -->
<section id="fakultas" class="py-20 bg-white">
  <div class="w-full mt-3">
    <div class="text-center mb-3 mt-4">
      <h2 class="text-4xl font-bold text-gray-900 mb-4 mt-6">Fakultas Teknik</h2>
    </div>

    @php
      $fakultasList = \App\Models\Fakultas::with([
          'programStudi' => function ($q) {
              $q->where('is_active', true);
          },
      ])
      ->withCount([
          'programStudi' => function ($q) {
              $q->where('is_active', true);
          },
      ])
      ->get();
    @endphp

    @foreach ($fakultasList as $fakultas)
      <div class="group relative mb-8 px-4 sm:px-6 lg:px-8">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-md opacity-0 group-hover:opacity-100 blur-xl transition-all duration-300"></div>
        <div class="relative bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 w-full">
          <div class="flex items-center justify-between mb-4">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
              <span class="text-white text-2xl font-bold">{{ substr($fakultas->nama, 0, 1) }}</span>
            </div>
            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Aktif</span>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $fakultas->nama }}</h3>
          <p class="text-gray-600 mb-4">
            {{ $fakultas->deskripsi ?? 'Fakultas yang berkomitmen pada peningkatan mutu pendidikan.' }}
          </p>
          <div class="flex items-center justify-between text-sm">
            <span class="text-gray-500">
              <span class="font-semibold text-gray-900">{{ $fakultas->program_studi_count }}</span> Program Studi
            </span>
            <a href="{{ route('asesor.dokumen-fakultas') }}#fakultas-{{ $fakultas->id }}"
              class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
              Lihat Detail
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>
