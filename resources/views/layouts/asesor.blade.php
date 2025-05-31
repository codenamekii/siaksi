<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'SIAKSI') }} - @yield('title', 'Asesor')</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

  <!-- Styles & Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<body class="font-sans antialiased">
  <div class="min-h-screen bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <!-- Logo & Nav Links -->
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <a href="{{ route('asesor.dashboard') }}" class="text-xl font-bold text-gray-800">
                SIAKSI
              </a>
            </div>

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <x-nav-link :href="route('asesor.dashboard')" :active="request()->routeIs('asesor.dashboard')">
                Dashboard
              </x-nav-link>

              <!-- Dropdown Dokumen Institusi -->
              <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                  class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out"
                  :class="open ||
                      '{{ request()->routeIs('asesor.dokumen-institusi') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}'">
                  Dokumen Institusi
                  <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
                  </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition
                  class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                  <div class="py-1">
                    <a href="{{ route('asesor.dokumen-institusi') }}#kebijakan"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                      Kebijakan SPMI
                    </a>
                    <a href="{{ route('asesor.dokumen-institusi') }}#standar"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                      Standar Mutu
                    </a>
                  </div>
                </div>
              </div>

              <x-nav-link :href="route('asesor.dokumen-fakultas')" :active="request()->routeIs('asesor.dokumen-fakultas')">
                Dokumen Fakultas
              </x-nav-link>

              <x-nav-link :href="route('asesor.dokumen-prodi')" :active="request()->routeIs('asesor.dokumen-prodi')">
                Dokumen Program Studi
              </x-nav-link>

              <x-nav-link :href="route('asesor.informasi-tambahan')" :active="request()->routeIs('asesor.informasi-tambahan')">
                Informasi Tambahan
              </x-nav-link>
            </div>
          </div>

          <!-- User Menu -->
          <div class="hidden sm:flex sm:items-center sm:ml-6">
            <div class="ml-3 relative" x-data="{ open: false }">
              <button @click="open = !open"
                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                <span>{{ Auth::user()->name }}</span>
                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
              </button>

              <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                <div class="py-1">
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                      class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                      Logout
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Mobile Hamburger -->
          <div class="-mr-2 flex items-center sm:hidden">
            <button @click="open = !open"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <main>
      @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white mt-12">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="border-t border-gray-200 pt-6">
          <p class="text-center text-sm text-gray-500">
            © {{ date('Y') }} SIAKSI - Sistem Informasi Dokumen Akreditasi. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
  </div>

  @livewireScripts
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  @stack('scripts')
</body>

</html>
