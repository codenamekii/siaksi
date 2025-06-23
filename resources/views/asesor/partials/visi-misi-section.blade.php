{{-- Lokasi file: resources/views/asesor/partials/visi-misi-section.blade.php --}}

<section id="visi-misi" class="py-24 bg-gradient-to-b from-gray-900 to-gray-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mt-3 mb-6">
      <h2 class="text-4xl font-bold text-white mb-4">Visi & Misi</h2>
      <div class="w-24 h-1 bg-blue-500 mx-auto mb-6"></div>
      <p class="text-xl text-gray-300 max-w-2xl mx-auto">
        @if ($fakultas)
          {{ $fakultas->nama }}
        @else
          Komitmen kami untuk meningkatkan mutu pendidikan tinggi
        @endif
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center rounded-md overflow-hidden">
      <div class="space-y-8">
        <!-- Visi -->
        <div
          class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-xl p-8 transform hover:scale-105 transition-all duration-300">
          <div class="flex items-center mb-6">
            <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center mr-4">
              <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                </path>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-white">Visi</h3>
          </div>
          <div class="text-white/90 leading-relaxed text-lg">
            @if ($fakultas && $fakultas->visi)
              {!! $fakultas->visi !!}
            @else
              <p>Menjadi sistem informasi akreditasi terdepan yang mendukung peningkatan mutu pendidikan tinggi melalui
                pengelolaan dokumen yang efisien, transparan, dan berkelanjutan.</p>
            @endif
          </div>
        </div>

        <!-- Misi -->
        <div class="bg-white rounded-2xl shadow-xl p-8 transform hover:scale-105 transition-all duration-300">
          <div class="flex items-center mb-6">
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
              <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                </path>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">Misi</h3>
          </div>
          <div class="text-gray-600">
            @if ($fakultas && $fakultas->misi)
              <div class="prose prose-lg max-w-none">
                {!! $fakultas->misi !!}
              </div>
            @else
              <ul class="space-y-4">
                <li class="flex items-start">
                  <svg class="w-6 h-6 text-purple-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-lg">Menyediakan akses mudah dan cepat ke dokumen akreditasi</span>
                </li>
                <li class="flex items-start">
                  <svg class="w-6 h-6 text-purple-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-lg">Memfasilitasi proses evaluasi dan penilaian akreditasi</span>
                </li>
                <li class="flex items-start">
                  <svg class="w-6 h-6 text-purple-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-lg">Mendukung transparansi dan akuntabilitas institusi</span>
                </li>
              </ul>
            @endif
          </div>
        </div>
      </div>

      <!-- Tujuan (Optional) -->
      @if ($fakultas && $fakultas->tujuan)
        <div
          class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl shadow-xl p-8 transform hover:scale-105 transition-all duration-300">
          <div class="flex items-center mb-6">
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mr-4">
              <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">Tujuan</h3>
          </div>
          <div class="text-gray-600">
            <div class="prose prose-lg max-w-none">
              {!! $fakultas->tujuan !!}
            </div>
          </div>
        </div>
      @else
        <!-- Image or Additional Content -->
        <div class="relative w-full h-full">
          <div
            class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-3xl transform rotate-3 scale-105">
          </div>
          <img src="{{ asset('storage/ilustrasi1.jpg') }}" alt="Visi Misi Illustration"
            class="relative rounded-3xl shadow-2xl transform -rotate-3 hover:rotate-0 transition-transform duration-500">
        </div>
      @endif
    </div>

    <!-- Additional Info -->
    @if ($fakultas && ($fakultas->dekan || $fakultas->email || $fakultas->website))
      <div class="mt-12 text-center">
        <div class="bg-white/10 backdrop-blur rounded-xl p-6 inline-block">
          @if ($fakultas->dekan)
            <p class="text-gray-300 mb-2">
              <span class="font-semibold">Dekan:</span> {{ $fakultas->dekan }}
            </p>
          @endif
          <div class="flex items-center justify-center space-x-6 text-sm">
            @if ($fakultas->email)
              <a href="mailto:{{ $fakultas->email }}" class="text-blue-400 hover:text-blue-300 transition">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                  </path>
                </svg>
                {{ $fakultas->email }}
              </a>
            @endif
            @if ($fakultas->website)
              <a href="{{ $fakultas->website }}" target="_blank" class="text-blue-400 hover:text-blue-300 transition">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                  </path>
                </svg>
                Website
              </a>
            @endif
          </div>
        </div>
      </div>
    @endif
  </div>
</section>
