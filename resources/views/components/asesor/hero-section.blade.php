{{-- Lokasi file: resources/views/components/asesor/hero-section.blade.php --}}

<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
  <!-- Animated Background -->
  <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50">
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    <!-- Floating shapes -->
    <div
      class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
    </div>
    <div
      class="absolute top-40 right-10 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
    </div>
    <div
      class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000">
    </div>
  </div>

  <!-- Hero Content -->
  <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="animate-fade-in-up">
      <!-- Welcome Message for returning users -->
      @if (session('gjm_original_user') || session('ujm_original_user'))
        <div class="mb-8 inline-flex items-center px-6 py-3 bg-white/90 backdrop-blur-md rounded-full shadow-lg">
          <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd"></path>
          </svg>
          <span class="text-gray-700 font-medium">
            @if (session('gjm_original_user'))
              Anda masuk sebagai Asesor dari Dashboard GJM
            @else
              Anda masuk sebagai Asesor dari Dashboard UJM
            @endif
          </span>
        </div>
      @endif

      <h1 class="text-5xl md:text-7xl font-bold mb-6">
        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
          Sistem Informasi
        </span>
        <br>
        <span class="text-gray-900">Dokumen Akreditasi</span>
      </h1>
      <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto">
        Platform terpadu untuk mengelola dan mengakses dokumen akreditasi institusi, fakultas, dan program studi
      </p>

      <!-- CTA Buttons -->
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="#features"
          class="group relative inline-flex items-center justify-center px-8 py-3 overflow-hidden font-bold text-white rounded-lg shadow-2xl">
          <span
            class="absolute top-0 left-0 w-40 h-40 -mt-10 -ml-3 transition-all duration-700 bg-purple-500 rounded-full blur-md ease"></span>
          <span class="absolute inset-0 w-full h-full transition duration-700 group-hover:rotate-180 ease">
            <span class="absolute bottom-0 left-0 w-24 h-24 -ml-10 bg-blue-600 rounded-full blur-md"></span>
            <span class="absolute bottom-0 right-0 w-24 h-24 -mr-10 bg-pink-500 rounded-full blur-md"></span>
          </span>
          <span class="relative">Mulai Eksplorasi</span>
        </a>
        <a href="#statistik"
          class="inline-flex items-center justify-center px-8 py-3 border-2 border-gray-900 text-gray-900 font-bold rounded-lg hover:bg-gray-900 hover:text-white transition-all duration-300">
          Lihat Statistik
          <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
          </svg>
        </a>
      </div>

      <!-- Quick Stats -->
      <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
        <div class="text-center">
          <div class="text-4xl font-bold text-gray-900">{{ $totalDokumen ?? 0 }}</div>
          <div class="text-sm text-gray-600 mt-1">Dokumen</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold text-gray-900">{{ $totalFakultas ?? 0 }}</div>
          <div class="text-sm text-gray-600 mt-1">Fakultas</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold text-gray-900">{{ $totalProdi ?? 0 }}</div>
          <div class="text-sm text-gray-600 mt-1">Program Studi</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold text-gray-900">{{ $prodiTerakreditasi ?? 0 }}</div>
          <div class="text-sm text-gray-600 mt-1">Terakreditasi</div>
        </div>
      </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
      <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
      </svg>
    </div>
  </div>
</section>
