{{-- Lokasi file: resources/views/asesor/partials/berita-pengumuman-section.blade.php --}}

<!-- Berita dan Pengumuman Section -->
<div class="py-12 bg-gray-50">
  <section id="berita" class="py-24 bg-gradient-to-br from-gray-100 to-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-4xl font-bold text-gray-900 mb-4">Berita & Pengumuman</h2>
      <div class="w-24 h-1 bg-blue-500 mx-auto mb-6"></div>
      <p class="text-md text-gray-600 max-w-2xl mb-3 mx-auto">
        Informasi terkini seputar akreditasi dan penjaminan mutu pendidikan
      </p>
    </div>

    @php
      $beritaTerbaru = \App\Models\Berita::with(['user', 'programStudi.fakultas'])
          ->published()
          ->latest('tanggal_publikasi')
          ->take(6)
          ->get();

      $beritaList = $beritaTerbaru->where('kategori', 'berita');
      $pengumumanList = $beritaTerbaru->where('kategori', 'pengumuman');
    @endphp

    <!-- Filter Buttons -->
    <div x-data="{ activeTab: 'semua' }">
      <div class="flex justify-center mb-3 space-x-4">
        <button @click="activeTab = 'semua'"
          :class="activeTab === 'semua' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50'"
          class="px-6 py-3 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
          Semua
        </button>
        <button @click="activeTab = 'berita'"
          :class="activeTab === 'berita' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50'"
          class="px-6 py-3 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
          Berita
        </button>
        <button @click="activeTab = 'pengumuman'"
          :class="activeTab === 'pengumuman' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-700 hover:bg-gray-50'"
          class="px-6 py-3 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
          Pengumuman
        </button>
      </div>

      <!-- Content -->
      <div>
        <!-- Semua -->
        <div x-show="activeTab === 'semua'" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform translate-y-4"
          x-transition:enter-end="opacity-100 transform translate-y-0">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($beritaTerbaru as $item)
              <article
                class="bg-white rounded-md shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                <a href="{{ route('asesor.berita.detail', $item->slug) }}" class="block">
                  @if ($item->getFirstMediaUrl('gambar'))
                    <div class="h-48 overflow-hidden">
                      <img src="{{ $item->getFirstMediaUrl('gambar') }}" alt="{{ $item->judul }}"
                        class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>
                  @else
                    <div
                      class="h-48 bg-gradient-to-br {{ $item->kategori === 'berita' ? 'from-blue-400 to-blue-600' : 'from-purple-400 to-purple-600' }} flex items-center justify-center">
                      <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if ($item->kategori === 'berita')
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                          </path>
                        @else
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                          </path>
                        @endif
                      </svg>
                    </div>
                  @endif

                  <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                      <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $item->kategori === 'berita' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                        {{ ucfirst($item->kategori) }}
                      </span>
                      <time class="text-xs text-gray-500">{{ $item->formatted_published_date }}</time>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600 transition">
                      {{ $item->judul }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $item->excerpt }}</p>

                    <div class="flex items-center justify-between">
                      <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $item->user->name }}
                      </div>
                      <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">
                        {{ ucfirst($item->level) }}
                      </span>
                    </div>
                  </div>
                </a>
              </article>
            @endforeach
          </div>
        </div>

        <!-- Berita Only -->
        <div x-show="activeTab === 'berita'" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform translate-y-4"
          x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($beritaList as $berita)
              <article
                class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                <a href="{{ route('asesor.berita.detail', $berita->slug) }}" class="block">
                  @if ($berita->getFirstMediaUrl('gambar'))
                    <div class="h-48 overflow-hidden">
                      <img src="{{ $berita->getFirstMediaUrl('gambar') }}" alt="{{ $berita->judul }}"
                        class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>
                  @else
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                      <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                        </path>
                      </svg>
                    </div>
                  @endif

                  <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                      <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Berita
                      </span>
                      <time class="text-xs text-gray-500">{{ $berita->formatted_published_date }}</time>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600 transition">
                      {{ $berita->judul }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $berita->excerpt }}</p>

                    <div class="flex items-center justify-between">
                      <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $berita->user->name }}
                      </div>
                      <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">
                        {{ ucfirst($berita->level) }}
                      </span>
                    </div>
                  </div>
                </a>
              </article>
            @empty
              <div class="col-span-3 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                  </path>
                </svg>
                <p class="mt-2 text-gray-500">Belum ada berita terbaru</p>
              </div>
            @endforelse
          </div>
        </div>

        <!-- Pengumuman Only -->
        <div x-show="activeTab === 'pengumuman'" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform translate-y-4"
          x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($pengumumanList as $pengumuman)
              <article
                class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                <a href="{{ route('asesor.berita.detail', $pengumuman->slug) }}" class="block">
                  @if ($pengumuman->getFirstMediaUrl('gambar'))
                    <div class="h-48 overflow-hidden">
                      <img src="{{ $pengumuman->getFirstMediaUrl('gambar') }}" alt="{{ $pengumuman->judul }}"
                        class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </div>
                  @else
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                      <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                        </path>
                      </svg>
                    </div>
                  @endif

                  <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                      <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        Pengumuman
                      </span>
                      <time class="text-xs text-gray-500">{{ $pengumuman->formatted_published_date }}</time>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600 transition">
                      {{ $pengumuman->judul }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $pengumuman->excerpt }}</p>

                    <div class="flex items-center justify-between">
                      <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $pengumuman->user->name }}
                      </div>
                      <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">
                        {{ ucfirst($pengumuman->level) }}
                      </span>
                    </div>
                  </div>
                </a>
              </article>
            @empty
              <div class="col-span-3 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                  </path>
                </svg>
                <p class="mt-2 text-gray-500">Belum ada pengumuman terbaru</p>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>

    <!-- View All Button -->
    <div class="text-center mt-12">
      <a href="{{ route('asesor.berita.index') }}"
        class="inline-flex items-center px-6 py-3 bg-blue-600 text-black font-semibold rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
        Lihat Semua Berita & Pengumuman
        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
        </svg>
      </a>
    </div>
  </div>
  </section>
</div>
{{-- End of Berita dan Pengumuman Section --}}
