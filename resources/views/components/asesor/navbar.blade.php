{{-- resources/views/components/asesor/navbar.blade.php --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<nav class="fixed top-0 z-50 w-full bg-white/95 backdrop-blur-md shadow-lg border-b border-gray-100">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      {{-- Logo Section --}}
      <div class="flex items-center justify-start">
        <a href="{{ route('asesor.dashboard') }}" class="flex items-center ml-2 md:mr-24 group">
          <div class="relative">
            <div
              class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg blur opacity-25 group-hover:opacity-50 transition duration-300">
            </div>
            <div class="relative flex items-center space-x-3 bg-white rounded-lg px-3 py-2">
              <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                </path>
              </svg>
              <span
                class="self-center text-xl font-bold whitespace-nowrap bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                SIAKSI
              </span>
            </div>
          </div>
        </a>
      </div>

      {{-- Desktop Navigation --}}
      <div class="hidden lg:flex lg:items-center lg:space-x-1">
        {{-- Dashboard --}}
        <a href="{{ route('asesor.dashboard') }}"
          class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                 {{ request()->routeIs('asesor.dashboard')
                     ? 'text-white bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/25'
                     : 'text-gray-700 hover:bg-gray-100' }}">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            </path>
          </svg>
          Dashboard
        </a>

        {{-- Dokumen Dropdown --}}
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open"
            class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-all duration-200"
            :class="{ 'text-blue-600': open }">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Dokumen
            <svg class="w-4 h-4 ml-1 transition-transform" :class="{ 'rotate-180': open }" fill="none"
              stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <!-- Dropdown -->
          <div x-show="open" @click.away="open = false" x-transition
            class="absolute left-0 mt-2 w-64 origin-top-left rounded-xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
            <div class="p-1.5 space-y-2">
              <a href="{{ route('asesor.dokumen-institusi') }}"
                class="flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="font-medium">Dokumen Institusi</p>
                  <p class="text-xs text-gray-500">Kebijakan & Standar Universitas</p>
                </div>
              </a>

              <a href="{{ route('asesor.dokumen-fakultas') }}"
                class="flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="font-medium">Dokumen Fakultas</p>
                  <p class="text-xs text-gray-500">Laporan & Kebijakan Fakultas</p>
                </div>
              </a>

              <a href="{{ route('asesor.dokumen-prodi') }}"
                class="flex items-center px-4 py-3 text-sm text-gray-700 rounded-lg hover:bg-purple-50 hover:text-purple-700 transition">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="font-medium">Dokumen Program Studi</p>
                  <p class="text-xs text-gray-500">LKPS, LED & Akreditasi</p>
                </div>
              </a>
            </div>
          </div>
        </div>

        {{-- Informasi Tambahan --}}
        <a href="{{ route('asesor.informasi-tambahan') }}"
          class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                 {{ request()->routeIs('asesor.informasi-tambahan')
                     ? 'text-white bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/25'
                     : 'text-gray-700 hover:bg-gray-100' }}">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          Informasi
        </a>

        {{-- Statistik (Coming Soon) --}}
        <a href="#"
          class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 text-gray-400 cursor-not-allowed">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
            </path>
          </svg>
          Statistik
        </a>

        {{-- Search --}}
        <div class="relative ml-3">
          <form action="{{ route('asesor.dashboard') }}" method="GET" class="relative">
            <input type="text" name="search" placeholder="Cari dokumen..." value="{{ request('search') }}"
              class="w-64 pl-10 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
              viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </form>
        </div>
      </div>

      {{-- User Menu --}}
      <div class="flex items-center">
        <div class="relative group">
          <button
            class="flex items-center p-2 text-sm bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:shadow-lg transition-all duration-200">
            <span class="sr-only">Open user menu</span>
            <div class="flex items-center space-x-3 px-2">
              <div class="text-right hidden md:block">
                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="text-xs opacity-90">Asesor</p>
              </div>
              <div class="h-8 w-8 rounded-full bg-white/20 flex items-center justify-center">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
              </div>
            </div>
          </button>

          {{-- User Dropdown --}}
          <div
            class="absolute right-0 mt-2 w-48 origin-top-right rounded-xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none transform scale-0 group-hover:scale-100 transition-all duration-200 ease-out">
            <div class="p-1.5">
              <a href="#" class="block px-4 py-2.5 text-sm text-gray-400 rounded-lg cursor-not-allowed">
                <div class="flex items-center">
                  <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  Profil Saya (Coming Soon)
                </div>
              </a>
              <hr class="my-1 border-gray-200">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                  class="w-full text-left px-4 py-2.5 text-sm text-red-600 rounded-lg hover:bg-red-50">
                  <div class="flex items-center">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                      </path>
                    </svg>
                    Logout
                  </div>
                </button>
              </form>
            </div>
          </div>
        </div>

        {{-- Mobile menu button --}}
        <button type="button"
          class="lg:hidden ml-3 inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
          onclick="toggleMobileMenu()">
          <span class="sr-only">Open main menu</span>
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>

  {{-- Mobile Menu --}}
  <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-200">
    <div class="px-2 pt-2 pb-3 space-y-1">
      <a href="{{ route('asesor.dashboard') }}"
        class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('asesor.dashboard') ? 'text-white bg-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
        Dashboard
      </a>

      {{-- Mobile Dokumen Accordion --}}
      <div class="space-y-1">
        <button onclick="toggleAccordion('dokumen-menu')"
          class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-100">
          <span>Dokumen</span>
          <svg class="w-4 h-4 transition-transform" id="dokumen-menu-icon" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        <div id="dokumen-menu" class="hidden pl-6 space-y-1">
          <a href="{{ route('asesor.dokumen-institusi') }}"
            class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
            Dokumen Institusi
          </a>
          <a href="{{ route('asesor.dokumen-fakultas') }}"
            class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
            Dokumen Fakultas
          </a>
          <a href="{{ route('asesor.dokumen-prodi') }}"
            class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
            Dokumen Program Studi
          </a>
        </div>
      </div>

      <a href="{{ route('asesor.informasi-tambahan') }}"
        class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('asesor.informasi-tambahan') ? 'text-white bg-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
        Informasi
      </a>

      <a href="#" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-400 cursor-not-allowed">
        Statistik (Coming Soon)
      </a>

      {{-- Mobile Search --}}
      <form action="{{ route('asesor.dashboard') }}" method="GET" class="px-3 py-2">
        <input type="text" name="search" placeholder="Cari dokumen..." value="{{ request('search') }}"
          class="w-full px-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
      </form>
    </div>
  </div>
</nav>

<script>
  function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
  }

  function toggleAccordion(id) {
    const element = document.getElementById(id);
    const icon = document.getElementById(id + '-icon');
    element.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
  }
</script>
