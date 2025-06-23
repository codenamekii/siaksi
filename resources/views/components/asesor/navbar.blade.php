{{-- Lokasi file: resources/views/components/asesor/navbar.blade.php --}}

<nav class="w-full fixed top-0 left-0 right-0 z-50 bg-white shadow-md transition-all duration-300" x-data="{ scrolled: false, mobileMenuOpen: false }"
  @scroll.window="scrolled = window.pageYOffset > 20" :class="{ 'shadow-lg': scrolled }">

  {{-- GJM Viewing Indicator --}}
  {{-- @if (Auth::user()->role === 'gjm')
  <div class="bg-blue-600 text-white text-center py-2 text-sm font-medium">
    <div class="flex items-center justify-center space-x-2">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
      </svg>
      <span>Anda sedang melihat sebagai GJM (Super Admin)</span>
    </div>
  </div>
  @endif --}}

  <div class="w-full bg-white shadow px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-24 ">
      <!-- Logo and Brand -->
      <div class="flex items-center">
        <a href="{{ route('asesor.dashboard') }}" class="flex items-center space-x-3">
          <img src="{{ asset('storage/logoteknik.png') }}" alt="Logo" class="h-12 w-auto">
          <div>
            <span class="text-2xl font-bold ml-2 text-gray-900">SIAKSI</span>
          </div>
        </a>
      </div>

      <!-- Desktop Navigation -->
      <div class="hidden lg:flex items-center space-x-1">
        <!-- Beranda Dropdown -->
        <div class="relative" x-data="{ open: false }">
          <button @click="open = !open" @click.away="open = false"
            class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200 inline-flex items-center">
            Beranda
            <svg class="ml-2 w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="currentColor"
              viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </button>
          <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute left-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div class="py-1">
              <a href="#visi-misi" @click="open = false"
                class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                Visi & Misi
              </a>
              <a href="#fakultas" @click="open = false"
                class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                Fakultas
              </a>
              <a href="#program-studi" @click="open = false"
                class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                Program Studi
              </a>
            </div>
          </div>
        </div>

        <!-- Dokumen Dropdown -->
        <div class="relative" x-data="{ open: false }">
          <button @click="open = !open" @click.away="open = false"
            class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200 inline-flex items-center">
            Dokumen
            <svg class="ml-2 w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="currentColor"
              viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </button>
          <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute left-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div class="relative py-1">
              <a href="{{ route('asesor.dokumen-institusi') }}"
                class="flex px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                Dokumen Institusi
              </a>
              <a href="{{ route('asesor.dokumen-fakultas') }}"
                class="flex px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                Dokumen Fakultas
              </a>
              <a href="{{ route('asesor.dokumen-prodi') }}"
                class="flex px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                Dokumen Prodi
              </a>
            </div>
          </div>
        </div>

        <!-- Media Dropdown (menggantikan Akreditasi) -->
        <div class="relative" x-data="{ open: false }">
          <button @click="open = !open" @click.away="open = false"
            class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200 inline-flex items-center">
            Media
            <svg class="ml-2 w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="currentColor"
              viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </button>
          <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute left-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div class="py-1">
              <a href="{{ route('asesor.berita.index') }}"
                class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <div class="flex items-center">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                    </path>
                  </svg>
                  Berita
                </div>
              </a>
              <a href="{{ route('asesor.galeri') }}"
                class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <div class="flex items-center">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                  </svg>
                  Galeri
                </div>
              </a>
              <a href=https://jtek.ft-uim.ac.id/index.php/jtek
                class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <div class="flex items-center">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                  </svg>
                  Publikasi Ilmiah
                </div>
              </a>
            </div>
          </div>
        </div>

        <!-- Informasi -->
        <a href="{{ route('asesor.informasi-tambahan') }}"
          class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
          Informasi
        </a>
      </div>

      <div class="flex items-center space-x-4">
        <!-- Return Button for GJM/UJM -->
        @if (Auth::user()->role === 'gjm')
          <a href="/gjm"
            class="hidden lg:inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12">
              </path>
            </svg>
            Kembali ke Dashboard GJM
          </a>
        @elseif(Auth::user()->role === 'ujm')
          <a href="/ujm"
            class="hidden lg:inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12">
              </path>
            </svg>
            Kembali ke Dashboard UJM
          </a>
        @endif

        <!-- User Menu -->
        <div class="relative" x-data="{ open: false }">
          <button @click="open = !open" @click.away="open = false"
            class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
            <div
              class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center shadow-md">
              <span class="text-white font-bold text-xs">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="hidden lg:block text-left">
              <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
              <p class="text-xs text-gray-500">
                @if (Auth::user()->role === 'gjm')
                  GJM (Viewing as Asesor)
                @elseif(Auth::user()->role === 'ujm')
                  UJM (Viewing as Asesor)
                @else
                  Asesor
                @endif
              </p>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </button>
          <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div class="py-1">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
              <hr class="my-1">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                  Logout
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- Mobile menu button -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
          class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
          <svg class="h-6 w-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg class="h-6 w-6" x-show="mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile menu -->
  <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform -translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-2" class="lg:hidden bg-white border-t border-gray-200">
    <div class="px-2 pt-2 pb-3 space-y-1">
      <a href="{{ route('asesor.dashboard') }}"
        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Beranda</a>
      <a href="{{ route('asesor.dokumen-institusi') }}"
        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Dokumen
        Institusi</a>
      <a href="{{ route('asesor.dokumen-fakultas') }}"
        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Dokumen
        Fakultas</a>
      <a href="{{ route('asesor.dokumen-prodi') }}"
        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Dokumen
        Prodi</a>
      <a href="{{ route('asesor.berita.index') }}"
        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Berita</a>
      <a href="{{ route('asesor.galeri') }}"
        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Galeri</a>
      <a href="{{ route('asesor.informasi-tambahan') }}"
        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Informasi</a>

      @if (Auth::user()->role === 'gjm')
        <div class="border-t border-gray-200 pt-2 mt-2">
          <a href="/gjm"
            class="block px-3 py-2 rounded-md text-base font-medium text-white bg-blue-600 hover:bg-blue-700">
            Kembali ke Dashboard GJM
          </a>
        </div>
      @elseif(Auth::user()->role === 'ujm')
        <div class="border-t border-gray-200 pt-2 mt-2">
          <a href="/ujm"
            class="block px-3 py-2 rounded-md text-base font-medium text-white bg-green-600 hover:bg-green-700">
            Kembali ke Dashboard UJM
          </a>
        </div>
      @endif
    </div>
  </div>
</nav>
